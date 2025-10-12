FROM php:8.3.10

# System dependencies
RUN apt-get update -y && apt-get install -y openssl zip unzip git libpq-dev postgresql-client

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable PostgreSQL extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /app

# Copy source code
COPY ./backend /app

# Install dependencies
RUN composer install --no-interaction

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
