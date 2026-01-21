# BrewBreeze Deployment Guide

This guide provides step-by-step instructions for deploying the BrewBreeze application to various hosting platforms.

---

## Prerequisites

- PHP >= 8.3
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js >= 18.x and NPM
- Git
- SSL Certificate (for HTTPS)

---

## Pre-Deployment Checklist

- [ ] Update `.env` file with production values
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY`
- [ ] Configure database credentials
- [ ] Configure email settings
- [ ] Configure payment gateway credentials (Stripe/PayPal)
- [ ] Set up SSL certificate
- [ ] Review security documentation

---

## Environment Configuration

### Required Environment Variables

```env
APP_NAME="BrewBreeze"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Payment Gateways
STRIPE_SECRET_KEY=sk_live_your_stripe_secret_key
STRIPE_PUBLIC_KEY=pk_live_your_stripe_public_key
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
PAYPAL_MODE=live

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=your-domain.com,www.your-domain.com
SANCTUM_TOKEN_EXPIRATION=1440

# Session Configuration
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=error
```

---

## Deployment Platforms

### Option 1: Railway

1. **Create Railway Account**
   - Sign up at [railway.app](https://railway.app)
   - Create a new project

2. **Connect GitHub Repository**
   - Connect your GitHub repository to Railway
   - Railway will detect Laravel automatically

3. **Add Database**
   - Click "New" → "Database" → "MySQL"
   - Railway will provide database credentials

4. **Configure Environment Variables**
   - Go to "Variables" tab
   - Add all required environment variables
   - Railway automatically provides `DATABASE_URL`

5. **Configure Build Settings**
   - Build Command: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

6. **Run Migrations**
   - After deployment, open Railway console
   - Run: `php artisan migrate --force`
   - Run: `php artisan db:seed` (optional)

7. **HTTPS**
   - Railway automatically provides HTTPS via Let's Encrypt
   - Update `APP_URL` to your Railway domain

---

### Option 2: Heroku

1. **Install Heroku CLI**
   ```bash
   # macOS
   brew tap heroku/brew && brew install heroku
   
   # Windows/Linux
   # Download from https://devcenter.heroku.com/articles/heroku-cli
   ```

2. **Login to Heroku**
   ```bash
   heroku login
   ```

3. **Create Heroku App**
   ```bash
   heroku create your-app-name
   ```

4. **Add Buildpacks**
   ```bash
   heroku buildpacks:add heroku/php
   heroku buildpacks:add heroku/nodejs
   ```

5. **Add MySQL Add-on**
   ```bash
   heroku addons:create cleardb:ignite
   ```

6. **Set Environment Variables**
   ```bash
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   heroku config:set APP_KEY=$(php artisan key:generate --show)
   # Add all other environment variables
   ```

7. **Deploy**
   ```bash
   git push heroku main
   ```

8. **Run Migrations**
   ```bash
   heroku run php artisan migrate --force
   ```

9. **HTTPS**
   - Heroku provides free HTTPS via Let's Encrypt
   - Update `APP_URL` to your Heroku domain

---

### Option 3: DigitalOcean App Platform

1. **Create DigitalOcean Account**
   - Sign up at [digitalocean.com](https://www.digitalocean.com)

2. **Create New App**
   - Click "Create" → "Apps"
   - Connect your GitHub repository

3. **Configure App Settings**
   - Framework: Laravel
   - Build Command: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
   - Run Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

4. **Add Database**
   - Click "Add Resource" → "Database"
   - Choose MySQL
   - DigitalOcean will provide connection string

5. **Configure Environment Variables**
   - Add all required environment variables
   - Use database connection string provided

6. **HTTPS**
   - DigitalOcean automatically provides HTTPS
   - Update `APP_URL` to your app domain

---

### Option 4: AWS EC2

1. **Launch EC2 Instance**
   - Choose Ubuntu Server 22.04 LTS
   - Configure security groups (HTTP, HTTPS, SSH)
   - Create key pair for SSH access

2. **Connect to Instance**
   ```bash
   ssh -i your-key.pem ubuntu@your-ec2-ip
   ```

3. **Install Dependencies**
   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install PHP 8.3
   sudo add-apt-repository ppa:ondrej/php
   sudo apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-xml php8.3-curl php8.3-zip php8.3-mbstring php8.3-gd
   
   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   
   # Install Node.js
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt install -y nodejs
   
   # Install Nginx
   sudo apt install -y nginx
   
   # Install MySQL
   sudo apt install -y mysql-server
   ```

4. **Clone Repository**
   ```bash
   cd /var/www
   sudo git clone https://github.com/your-username/brewbreeze.git
   sudo chown -R www-data:www-data brewbreeze
   cd brewbreeze
   ```

5. **Configure Application**
   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   php artisan key:generate
   # Edit .env with production values
   npm install
   npm run build
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Configure Nginx**
   ```bash
   sudo nano /etc/nginx/sites-available/brewbreeze
   ```
   
   Add configuration:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/brewbreeze/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       
       index index.php;
       
       charset utf-8;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }
       
       error_page 404 /index.php;
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```
   
   Enable site:
   ```bash
   sudo ln -s /etc/nginx/sites-available/brewbreeze /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

7. **Configure SSL with Let's Encrypt**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com -d www.your-domain.com
   ```

8. **Set Up Supervisor (for queues)**
   ```bash
   sudo apt install supervisor
   sudo nano /etc/supervisor/conf.d/brewbreeze-worker.conf
   ```
   
   Add:
   ```ini
   [program:brewbreeze-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/brewbreeze/artisan queue:work --sleep=3 --tries=3
   autostart=true
   autorestart=true
   user=www-data
   numprocs=2
   redirect_stderr=true
   stdout_logfile=/var/www/brewbreeze/storage/logs/worker.log
   ```
   
   Start supervisor:
   ```bash
   sudo supervisorctl reread
   sudo supervisorctl update
   sudo supervisorctl start brewbreeze-worker:*
   ```

---

## Post-Deployment Tasks

1. **Run Migrations**
   ```bash
   php artisan migrate --force
   ```

2. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

3. **Clear and Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

4. **Set File Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

5. **Test Application**
   - Visit your domain
   - Test login/registration
   - Test API endpoints
   - Test payment processing

---

## Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY` generated
- [ ] HTTPS enabled with valid SSL certificate
- [ ] Secure database credentials
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] `SESSION_SAME_SITE=lax` or `strict`
- [ ] Payment gateway in `live` mode
- [ ] Environment variables secured (not in git)
- [ ] File permissions correctly set
- [ ] Firewall configured
- [ ] Regular backups configured

---

## Monitoring

### Log Files

- Application logs: `storage/logs/laravel.log`
- API logs: `storage/logs/api-*.log`

### Health Check

The application includes a health check endpoint:

```
GET /up
```

Returns `200 OK` if the application is healthy.

---

## Backup Strategy

### Database Backups

```bash
# Manual backup
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated backup (cron job)
0 2 * * * mysqldump -u username -p database_name > /backups/backup_$(date +\%Y\%m\%d).sql
```

### File Backups

```bash
# Backup storage and uploaded files
tar -czf backup_files_$(date +%Y%m%d).tar.gz storage/
```

---

## Troubleshooting

### Application Not Loading

1. Check `APP_DEBUG=true` temporarily to see errors
2. Check log files: `storage/logs/laravel.log`
3. Verify environment variables are set correctly
4. Check file permissions

### Database Connection Issues

1. Verify database credentials in `.env`
2. Check database server is running
3. Verify firewall rules allow database connections
4. Test connection manually

### 500 Internal Server Error

1. Check `storage/logs/laravel.log`
2. Verify file permissions
3. Check PHP error logs
4. Clear caches: `php artisan cache:clear`

### SSL Certificate Issues

1. Verify certificate is valid
2. Check certificate expiration
3. Verify domain matches certificate
4. Check Nginx/Apache SSL configuration

---

## Support

For deployment support, please contact the development team or refer to:
- Laravel Deployment Documentation: https://laravel.com/docs/deployment
- Your hosting provider's documentation

---

**Last Updated:** {{ date('Y-m-d') }}
