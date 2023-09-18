# Use the official PHP image with Apache as the web server
FROM php:8.0-apache

# Install system dependencies and required libraries for GD extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Set the working directory inside the container
WORKDIR /var/www/html/acsi_emfs

# Copy Laravel files into the container
COPY . .

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Install npm packages
RUN npm install

# Build Vue.js assets
RUN npm run production

# Set permissions for Laravel storage directory
RUN chown -R www-data:www-data /var/www/html/acsi_emfs
RUN chmod -R 755 /var/www/html/acsi_emfs

RUN chown -R www-data:www-data /var/www/html/acsi_emfs/public
RUN chmod -R 755 /var/www/html/acsi_emfs/public

RUN chown -R www-data:www-data /var/www/html/acsi_emfs/storage
RUN chmod -R 775 /var/www/html/acsi_emfs/storage

# Enable Apache modules and configure the virtual host
RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Expose the port that Apache is listening on
EXPOSE 80

# Start Apache web server
CMD ["apache2-foreground"]
