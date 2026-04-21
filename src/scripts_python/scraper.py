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

        # 2. PRECIOS (La clave)
        # Buscamos el precio actual (rebajado)
        meta_actual = soup.find("meta", property="product:price:amount")
        precio_rebajado = meta_actual.get("content") if meta_actual else "0.00"

        # Buscamos el precio antiguo (el que suele estar tachado en PrestaShop)
        precio_original = "0.00"
        old_price_tag = soup.select_one('.regular-price, .old-price, .text-muted.line-through')
        if old_price_tag:
            match = re.search(r'\d+[.,]\d+', old_price_tag.get_text())
            if match: precio_original = match.group().replace(',', '.')
        else:
            # Si no hay etiqueta de "precio viejo", el original es igual al rebajado
            precio_original = precio_rebajado

        # 3. IMAGEN
        imagen = ""
        meta_img = soup.find("meta", property="og:image")
        imagen = meta_img.get("content") if meta_img else "https://via.placeholder.com/300"

        # DEVOLVEMOS 4 DATOS
        print(f"{nombre};{precio_rebajado};{precio_original};{imagen}")
            
    except Exception as e:
        print(f"Error;0.00;0.00;no_image.png")

if __name__ == "__main__":
    extraer_tienda_running()