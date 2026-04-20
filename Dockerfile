FROM php:8.2-apache

# 1. Instalamos extensiones de PHP necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql

# 2. INSTALAMOS PYTHON y PIP (Añadimos lib-xml para BeautifulSoup)
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    python3-venv \
    libxml2-dev

# 3. Instalamos las librerías con el flag necesario
# He añadido 'lxml' que es un motor más rápido para BeautifulSoup
RUN pip3 install --no-cache-dir requests beautifulsoup4 lxml --break-system-packages

# Habilitamos el mod_rewrite de Apache para URLs bonitas
RUN a2enmod rewrite