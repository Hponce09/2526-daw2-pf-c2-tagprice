import sys
import requests
from bs4 import BeautifulSoup
import re

def extraer_tienda_running():
    url = sys.argv[1]
    headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"}
    
    try:
        response = requests.get(url, headers=headers, timeout=15)
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # 1. NOMBRE
        h1 = soup.find("h1")
        nombre = h1.get_text().strip() if h1 else "Producto"

        # 2. PRECIOS (Afinando la puntería para TiendaRunning)
        precio_rebajado = "0.00"
        precio_original = "0.00"

        # Buscamos el precio actual (el que está en rosa/rojo en la web)
        # En PrestaShop suele estar en un span con itemprop="price" o clase current-price
        tag_actual = soup.select_one('.current-price span, [itemprop="price"]')
        if tag_actual:
            texto_actual = tag_actual.get_text()
            match = re.search(r'\d+[.,]\d+', texto_actual)
            if match: precio_rebajado = match.group().replace(',', '.')

        # Buscamos el precio viejo (el que está tachado: 200,00 €)
        tag_viejo = soup.select_one('.regular-price')
        if tag_viejo:
            texto_viejo = tag_viejo.get_text()
            match = re.search(r'\d+[.,]\d+', texto_viejo)
            if match: precio_original = match.group().replace(',', '.')
        else:
            # Si no hay precio viejo tachado, el original es el mismo que el actual
            precio_original = precio_rebajado

        # 3. IMAGEN
        meta_img = soup.find("meta", property="og:image")
        imagen = meta_img.get("content") if meta_img else "https://via.placeholder.com/300"

        # Devolvemos: Nombre;Rebajado;Original;Imagen
        print(f"{nombre};{precio_rebajado};{precio_original};{imagen}")
            
    except Exception as e:
        print(f"Error;0.00;0.00;no_image.png")

if __name__ == "__main__":
    extraer_tienda_running()