#!/bin/bash

echo "Starting Brew Breeze Laravel Application..."

# Navigate to app directory
cd /home/site/wwwroot

# Set proper permissions
chmod -R 755 storage bootstrap/cache

# Create required directories if they don't exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Laravel startup configuration complete!"
