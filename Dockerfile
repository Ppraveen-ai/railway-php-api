FROM php:8.2-cli

# Install mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy app
COPY public/ /app
WORKDIR /app

# Expose Railway's dynamic port
EXPOSE 8000

# Run PHP built-in server on Railway's $PORT
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8000} -t /app"]
