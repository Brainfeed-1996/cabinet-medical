FROM php:8.2-apache

# 1. Mise à jour des paquets et installation des dépendances
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Activation des modules Apache (ajout de authz_core)
RUN a2enmod rewrite headers authz_core

# 3. Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Configuration du répertoire de travail
WORKDIR /var/www/html

# 5. Création des répertoires nécessaires
RUN mkdir -p /var/www/html/public /var/www/html/private/logs

# 6. Copie de la configuration Apache
COPY apache.conf /etc/apache2/apache2.conf

# 7. Copie des fichiers de l'application
COPY . /var/www/html/

# 8. Configuration des permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/private/logs

# 9. Exposition du port
EXPOSE 80

# 10. Commande de démarrage
CMD ["apache2-foreground"]