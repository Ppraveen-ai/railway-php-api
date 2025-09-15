FROM php:8.2-apache

# Enable mysqli extension for MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy app files
COPY public/ /var/www/html/

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port (Railway sets $PORT at runtime)
EXPOSE ${PORT}

# Run entrypoint script instead of apache2-foreground directly
CMD ["/entrypoint.sh"]
