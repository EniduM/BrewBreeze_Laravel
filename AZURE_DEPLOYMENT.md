# Azure Deployment Guide for BrewBreeze Laravel App

## Problem
Your Laravel app is deployed to Azure, but only showing the default "Your web app is running and waiting for your content" page. This happens because the app hasn't been properly built and configured on Azure.

## Solution

### Files Created/Updated
1. **startup.sh** - Enhanced startup script with composer install, npm build, and Laravel optimizations
2. **deploy.sh** - Complete deployment script for Azure
3. **.deployment** - Tells Azure to use our custom deployment script
4. **web.config** - Updated with better routing and security

### Steps to Fix Your Deployment

#### Option 1: Using Azure Portal (Recommended for Quick Fix)

1. **Go to Azure Portal** → Your App Service

2. **Configure Application Settings**:
   - Navigate to: **Configuration** → **Application settings**
   - Add these settings:
     ```
     APP_ENV=production
     APP_KEY=base64:22KodqoNz5JTH6nZ1tqiQT+FTkhXtMlc90VUZsutWSM=
     APP_DEBUG=false
     DB_CONNECTION=mysql (or your database type)
     DB_HOST=<your-database-host>
     DB_PORT=3306
     DB_DATABASE=<your-database-name>
     DB_USERNAME=<your-database-username>
     DB_PASSWORD=<your-database-password>
     ```

3. **Configure Startup Command**:
   - Navigate to: **Configuration** → **General settings**
   - Set **Startup Command** to: `bash startup.sh`
   - Click **Save**

4. **Redeploy Your Application**:
   - Go to **Deployment Center**
   - Click **Sync** or **Redeploy** (depending on your deployment method)
   - OR: Push a new commit to trigger redeployment

5. **Enable Detailed Error Messages** (Temporarily):
   - Navigate to: **Configuration** → **Application settings**
   - Add: `WEBSITE_DETAILED_ERRORS=1`
   - Check logs at: **Monitoring** → **Log stream**

#### Option 2: Using Azure CLI

```bash
# Set your app name and resource group
APP_NAME="brew-breeze-app"
RESOURCE_GROUP="your-resource-group"

# Configure startup command
az webapp config set --name $APP_NAME --resource-group $RESOURCE_GROUP --startup-file "bash startup.sh"

# Set application settings
az webapp config appsettings set --name $APP_NAME --resource-group $RESOURCE_GROUP --settings \
  APP_ENV="production" \
  APP_KEY="base64:22KodqoNz5JTH6nZ1tqiQT+FTkhXtMlc90VUZsutWSM=" \
  APP_DEBUG="false" \
  DB_CONNECTION="mysql"

# Restart the app
az webapp restart --name $APP_NAME --resource-group $RESOURCE_GROUP
```

#### Option 3: Complete Redeployment via GitHub Actions

If you're using GitHub Actions, update your workflow file:

```yaml
- name: Deploy to Azure Web App
  uses: azure/webapps-deploy@v2
  with:
    app-name: 'brew-breeze-app'
    slot-name: 'production'
    publish-profile: ${{ secrets.AZURE_WEBAPP_PUBLISH_PROFILE }}
    package: .

- name: Run post-deployment commands
  run: |
    az webapp config set --name brew-breeze-app --resource-group your-resource-group --startup-file "bash startup.sh"
```

### Important Checklist

- [ ] Database is created and accessible from Azure
- [ ] All environment variables are set in Azure Portal
- [ ] Startup command is configured: `bash startup.sh`
- [ ] File permissions for `storage` and `bootstrap/cache` are correct
- [ ] `.env` file has correct database credentials
- [ ] Migrations have been run (or will run automatically)
- [ ] Assets are built (`npm run build`)
- [ ] Composer dependencies are installed

### Troubleshooting

#### Check Logs
```bash
# Via Azure CLI
az webapp log tail --name brew-breeze-app --resource-group your-resource-group

# Or in Azure Portal
Monitoring → Log stream
```

#### Common Issues

1. **Still seeing placeholder page**:
   - Ensure startup command is set correctly
   - Check that `web.config` is in root directory
   - Verify PHP version is 8.1 or higher

2. **500 Error**:
   - Check storage permissions: `chmod -R 775 storage bootstrap/cache`
   - Ensure APP_KEY is set
   - Check database connection settings
   - Review error logs

3. **Missing Assets (CSS/JS)**:
   - Run `npm run build` before deployment
   - Check that `public/build` directory exists
   - Verify `public/storage` link is created

4. **Database Connection Issues**:
   - Verify database credentials in Application Settings
   - Check if Azure App Service can reach your database
   - For Azure Database, ensure firewall rules allow App Service

### Manual Commands (if needed)

SSH into your Azure App Service and run:

```bash
cd /home/site/wwwroot

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Laravel setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Run migrations (if safe)
php artisan migrate --force
```

### After Deployment

1. Visit your app URL (not the default Azure URL shown in the screenshot)
2. Check that the Laravel welcome page or your app loads
3. Test database connectivity
4. Monitor logs for any errors

### Need More Help?

If still not working:
1. Check **Log Stream** in Azure Portal
2. Enable **Application Insights** for detailed diagnostics
3. Verify all environment variables are correct
4. Check that PHP and Node.js versions match your local environment

---

**Note**: The placeholder page appears because Azure hasn't executed the application code yet. Following these steps will trigger proper deployment and start serving your Laravel application.
