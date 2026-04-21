import sys
import requests
from bs4 import BeautifulSoup
import re

def extraer_datos():
    if len(sys.argv) < 2:
        print("Error;0.00;0.00;none")
        return

    url = sys.argv[1]
    # Headers más "humanos" para evitar que Atmosfera Sport nos bloquee
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36",
        "Accept-Language": "es-ES,es;q=0.9",
        "Referer": "https://www.google.com/"
    }
    
    try:
        response = requests.get(url, headers=headers, timeout=15)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # 1. NOMBRE (Búsqueda multietiqueta)
        nombre = "Producto"
        h1 = soup.find("h1")
        if h1:
            nombre = h1.get_text().strip()

        # 2. PRECIO REBAJADO (EL QUE PAGAS)
        precio_rebajado = "0.00"
        # Añadimos selectores para Atmosfera Sport (.current-price-value, .sales)
        sel_rebajado = [
            '.current-price-value', '.current-price', '.sales .price', 
            '.pdp-product-price', '.price-item--sale', '[itemprop="price"]'
        ]
        for sel in sel_rebajado:
            tag = soup.select_one(sel)
            if tag:
                texto = tag.get_text().replace(',', '.')
                match = re.search(r'\d+[.]\d+', texto)
                if match: 
                    precio_rebajado = match.group()
                    break

        # 3. PRECIO ORIGINAL (TACHADO)
        precio_original = "0.00"
        # Selectores para Atmosfera Sport (.regular-price-value, .was)
        sel_original = [
            '.regular-price-value', '.regular-price', '.was .price', 
            '.price-item--regular', '.pdp-price_type_deleted', '.line-through'
        ]
        for sel in sel_original:
            tag = soup.select_one(sel)
            if tag:
                texto = tag.get_text().replace(',', '.')
                match = re.search(r'\d+[.]\d+', texto)
                if match: 
                    precio_original = match.group()
                    break
        
        # Si no detectamos original, lo igualamos al rebajado
        if precio_original == "0.00":
            precio_original = precio_rebajado

        # 4. IMAGEN (EL GRAN FALLO EN ATMOSFERA)
        imagen = ""
        # Buscamos primero en el meta (Atmosfera lo usa bien)
        meta_img = soup.find("meta", property="og:image")
        if meta_img:
            imagen = meta_img.get("content")
        
        if not imagen:
            # Fallback a la imagen principal del producto
            img_tag = soup.select_one('.product-main-image img, .pdp-main-image img')
            if img_tag:
                imagen = img_tag.get('src')

        # Limpiar URL de imagen
        if imagen and imagen.startswith('//'):
            imagen = "https:" + imagen

        print(f"{nombre};{precio_rebajado};{precio_original};{imagen}")
            
    except Exception as e:
        print(f"Error;0.00;0.00;none")

if __name__ == "__main__":
    extraer_datos()