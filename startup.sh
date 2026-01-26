#!/bin/bash

echo "Starting Brew Breeze Laravel Application..."

# Navigate to app directory
cd /home/site/wwwroot

# Install composer dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Install npm dependencies and build assets if node_modules doesn't exist
if [ ! -d "node_modules" ]; then
    echo "Installing NPM dependencies..."
    npm ci --production
    echo "Building assets..."
    npm run build
fi

# Create required directories if they don't exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/cache/data
mkdir -p storage/logs

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Copy environment file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate --force
fi

# Clear and cache configurations
echo "Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (optional, comment out if not needed)
# php artisan migrate --force

# Create symbolic link for storage
php artisan storage:link

echo "Laravel startup configuration complete!"

# Start PHP-FPM or return to let Azure handle it
echo "Application ready!"
