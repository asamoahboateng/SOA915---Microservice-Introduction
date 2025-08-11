#!/bin/bash
set -e

cd /var/www

# Install dependencies if vendor folder doesn't exist
if [ ! -d "vendor" ]; then
  echo "Running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Create .env if it doesn't exist
if [ ! -f ".env" ]; then
  echo ".env file not found. Copying from .env.example..."
  cp .env.example .env
fi

# Generate application key
echo "Running php artisan key:generate..."
php artisan key:generate --force

# Execute CMD from Dockerfile (e.g., php artisan serve ...)
exec "$@"
