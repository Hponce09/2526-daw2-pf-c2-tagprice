import sys
import requests
from bs4 import BeautifulSoup
import json
import re

def extraer_tienda_running():
    if len(sys.argv) < 2:
        print("Error: Sin URL;0.00")
        return

    url = sys.argv[1]
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36"
    }
    
    try:
        response = requests.get(url, headers=headers, timeout=15)
        if response.status_code != 200:
            print(f"Error HTTP {response.status_code};0.00")
            return

        soup = BeautifulSoup(response.text, 'html.parser')
        nombre = ""
        precio_final = "0.00"

        # --- 1. EXTRAER NOMBRE (H1 estándar) ---
        h1 = soup.find("h1")
        nombre = h1.get_text().strip() if h1 else "Producto"

        # --- 2. EXTRAER PRECIO REBAJADO (Estrategia de capas) ---
        
        # CAPA A: Buscar en etiquetas META (suelen tener el precio final que ve el usuario)
        meta_price = soup.find("meta", property="product:price:amount") or \
                     soup.find("meta", {"itemprop": "price"})
        
        if meta_price:
            precio_final = meta_price.get("content", "0.00")

        # CAPA B: Si la capa A falla o da el precio viejo, buscamos el JSON LD
        if precio_final == "0.00" or precio_final == "200": # Si detectamos que sigue en 200, intentamos mejorar
            scripts = soup.find_all("script", type="application/ld+json")
            for s in scripts:
                try:
                    data = json.loads(s.string)
                    if isinstance(data, list): data = data[0]
                    if data.get("@type") == "Product":
                        offers = data.get("offers", {})
                        if isinstance(offers, dict):
                            precio_final = offers.get("price", precio_final)
                        elif isinstance(offers, list):
                            precio_final = offers[0].get("price", precio_final)
                except: continue

        # CAPA C: Búsqueda visual (por si las anteriores fallan o son el precio sin descuento)
        # Buscamos el div o span que suele tener el precio actual en PrestaShop
        selector_oferta = soup.select_one('.current-price span, [itemprop="price"], .product-price .current-price')
        if selector_oferta:
            texto_precio = selector_oferta.get_text()
            # Extraemos el número (ej: "159,95 €" -> "159.95")
            match = re.search(r'\d+[.,]\d+', texto_precio)
            if match:
                posible_precio = match.group().replace(',', '.')
                # Si este precio es menor al que ya tenemos, es que hemos encontrado la rebaja
                if float(posible_precio) < float(precio_final) or precio_final == "0.00":
                    precio_final = posible_precio

        # --- 3. LIMPIEZA FINAL ---
        precio_final = str(precio_final).replace(',', '.').strip()
        
        print(f"{nombre};{precio_final}")
            
    except Exception as e:
        print(f"Error de conexion;0.00")

if __name__ == "__main__":
    extraer_tienda_running()