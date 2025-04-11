FROM php:8.2-apache

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Configuration d'Apache
RUN a2enmod rewrite headers
COPY apache.conf /etc/apache2/apache2.conf

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Création des répertoires nécessaires
RUN mkdir -p /var/www/html/public /var/www/html/private/logs

# Copie des fichiers du projet
COPY . /var/www/html/

# Vérification du contenu du répertoire
RUN ls -la /var/www/html/

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/private/logs

# Exposition du port 80
EXPOSE 80

# Démarrage d'Apache
CMD ["apache2-foreground"]
