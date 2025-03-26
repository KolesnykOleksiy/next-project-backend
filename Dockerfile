FROM php:8.2

# Встановлення необхідних пакетів та розширень
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Встановлюємо робочу директорію
WORKDIR /var/www/html

# Копіюємо файли проєкту у контейнер
COPY . .

# Команда запуску Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
