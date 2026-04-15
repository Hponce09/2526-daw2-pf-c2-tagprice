FROM php:8.2-apache

# 1. Instalamos extensiones de PHP necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 2. INSTALAMOS PYTHON y PIP (Lo que necesitas para el scraping)
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    python3-venv

# 3. Instalamos las librerías de scraping para que PHP pueda usarlas
RUN pip3 install requests beautifulsoup4 --break-system-packages

# Habilitamos el mod_rewrite de Apache para URLs bonitas
RUN a2enmod rewrite