# Utiliser une image PHP officielle comme base
FROM php:8.2-fpm

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Nettoyer le cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers du projet
COPY . /var/www/html

# Installer les dépendances PHP
RUN composer install --no-interaction --no-plugins --no-scripts

# Installer les dépendances Node.js
RUN npm install && npm run build

# Générer la clé d'application
RUN php artisan key:generate

# Définir les permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Exposer le port 9000
EXPOSE 9999

# Commande par défaut
CMD ["php-fpm"]
