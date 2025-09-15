FROM php:8.2-apache

# Enable mysqli extension for MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your app into Apache docroot
COPY public/ /var/www/html/

# Tell Apache to use Railway's assigned port
RUN echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Expose the port (Railway sets $PORT at runtime)
EXPOSE ${PORT}

# Start Apache server
CMD ["apache2-foreground"]
