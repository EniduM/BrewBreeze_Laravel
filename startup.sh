#!/bin/bash
set -e

echo "=== Brew Breeze startup (Azure Linux PHP) ==="

# Always run from wwwroot
cd /home/site/wwwroot

# Ensure Laravel writable dirs exist (safe even if already exist)
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache \
         storage/framework/cache/data \
         storage/logs \
         bootstrap/cache

# Permissions (best-effort; don't fail startup if chmod isn't allowed)
chmod -R 775 storage bootstrap/cache || true

# -------------------------------
# NGINX: point web root to /public
# -------------------------------
# Expect a file named "default" (nginx site config) in /home/site/wwwroot
if [ -f "/home/site/wwwroot/default" ]; then
  echo "Applying custom NGINX site config..."
  cp /home/site/wwwroot/default /etc/nginx/sites-available/default
  echo "Reloading NGINX..."
  service nginx reload || nginx -s reload || true
else
  echo "WARNING: /home/site/wwwroot/default not found."
  echo "NGINX will not be reconfigured. Your site may show the default page/404."
fi

echo "=== Startup finished ==="
