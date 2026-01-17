FROM php:8.2-cli

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY public/ /app
WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
