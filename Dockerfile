FROM php:8.2-cli

# Install mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy app
COPY public/ /app

WORKDIR /app

# Expose Railway port
EXPOSE ${PORT}

# Run PHP built-in server
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /app"]
