FROM php:8.2-cli

# Install mysqli for MySQL support
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your app files into /app
COPY public/ /app

WORKDIR /app

# Use shell form CMD so $PORT expands at runtime
CMD php -S 0.0.0.0:${PORT:-8000} -t /app
