FROM php:8.2-apache

# Étape 1: Installation des dépendances
RUN apt-get update && \
    apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Étape 2: Activation des modules Apache
RUN a2enmod rewrite headers authz_core

# Étape 3: Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Étape 4: Configuration
WORKDIR /var/www/html
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Étape 5: Copie de l'application
COPY . /var/www/html/

# Étape 6: Configuration des permissions
RUN mkdir -p /var/www/html/private/logs && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 /var/www/html/private/logs

EXPOSE 80
CMD ["apache2-foreground"]