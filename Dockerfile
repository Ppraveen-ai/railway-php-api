# Use official PHP + Apache image
FROM php:8.2-apache

# Enable mysqli extension for MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your app into Apache’s web root
COPY public/ /var/www/html/

# Expose Apache port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
