#!/bin/bash

# Azure Deployment Script for Laravel
echo "=========================================="
echo "Starting Laravel Deployment on Azure"
echo "=========================================="

# Exit on any error
set -e

# Get deployment paths
DEPLOYMENT_SOURCE="${DEPLOYMENT_SOURCE:-$PWD}"
DEPLOYMENT_TARGET="${DEPLOYMENT_TARGET:-/home/site/wwwroot}"

echo "Deployment source: $DEPLOYMENT_SOURCE"
echo "Deployment target: $DEPLOYMENT_TARGET"

# Install Composer dependencies
echo "Installing Composer dependencies..."
cd "$DEPLOYMENT_SOURCE"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --quiet
php -r "unlink('composer-setup.php');"
php composer.phar install --no-dev --optimize-autoloader --no-interaction --prefer-dist
rm composer.phar

# Install Node dependencies and build assets
if [ -f "package.json" ]; then
    echo "Installing NPM dependencies..."
    npm ci --production=false
    
    echo "Building frontend assets..."
    npm run build
fi

# Copy files to target
echo "Copying files to deployment target..."
rsync -a --exclude 'node_modules' --exclude '.git' "$DEPLOYMENT_SOURCE/" "$DEPLOYMENT_TARGET/"

# Setup Laravel
cd "$DEPLOYMENT_TARGET"

# Create storage directories
echo "Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create .env if it doesn't exist
if [ ! -f ".env" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    php artisan key:generate --force --no-interaction
fi

# Laravel optimizations
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache  
php artisan view:cache

# Storage link
php artisan storage:link --force || true

echo "=========================================="
echo "Deployment completed successfully!"
echo "=========================================="
