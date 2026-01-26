# BrewBreeze - Coffee Subscription SaaS Platform

A modern Laravel 10 application for managing coffee subscriptions, orders, and customer relationships.

[![Deploy to Azure](https://img.shields.io/badge/Deploy%20to-Azure-blue)](https://brew-breeze-app-gcdpfzedbzg4dkh2.canadacentral-01.azurewebsites.net)
[![Laravel](https://img.shields.io/badge/Laravel-10-red)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-blue)](https://php.net)

## Features

- **User Authentication**: Role-based authentication with Laravel Jetstream
- **Admin Dashboard**: Complete admin panel for managing products, orders, and subscriptions
- **Customer Portal**: Customer dashboard for browsing products, managing cart, and viewing orders
- **Shopping Cart**: Full cart functionality with quantity management
- **Order Management**: Complete checkout flow with payment processing
- **Subscription Management**: Customer subscription tier management
- **Messaging System**: Customer-to-admin messaging
- **REST API**: Token-based API with Laravel Sanctum
  - API versioning (v1)
  - Rate limiting (60/100 requests per minute)
  - Pagination support
  - Comprehensive error handling
  - Request/response logging
- **Payment Gateway Integration**: Stripe, PayPal, and Bank Transfer support
- **Security**: Comprehensive security measures (CSRF, XSS, SQL injection protection)
- **Advanced Eloquent Features**: Query scopes, accessors, mutators
- **Documentation**: Complete API documentation and deployment guide

## Requirements

- PHP >= 8.3
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js >= 18.x and NPM
- XAMPP (or similar local development environment)

## Installation

### 1. Clone the Repository

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/BrewBreeze/brew-breeze
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials:

```env
APP_NAME="Brew Breeze"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brew_breeze
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a MySQL database named `brew_breeze`:

```sql
CREATE DATABASE brew_breeze CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Seed Database

```bash
php artisan db:seed
```

This will create:
- 1 Admin user: `admin@brewbreeze.com` / `password`
- 3 Customer users: `john@example.com`, `jane@example.com`, `bob@example.com` / `password`
- 6 Demo products

### 9. Build Frontend Assets

```bash
npm run build
```

Or for development with hot reload:

```bash
npm run dev
```

### 10. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Credentials

### Admin Account
- **Email**: `admin@brewbreeze.com`
- **Password**: `password`
- **Access**: Full admin dashboard at `/admin/dashboard`

### Customer Accounts
- **Email**: `john@example.com` / `jane@example.com` / `bob@example.com`
- **Password**: `password`
- **Access**: Customer dashboard at `/dashboard`

## Application Structure

### Routes

#### Web Routes
- `/` - Landing page (redirects authenticated users)
- `/dashboard` - Customer dashboard (requires customer role)
- `/admin/dashboard` - Admin dashboard (requires admin role)
- `/products` - Product browsing
- `/cart` - Shopping cart
- `/checkout` - Checkout process
- `/orders` - Order history
- `/message` - Contact admin form

#### API Routes
- `POST /api/login` - Authenticate and get token
- `POST /api/logout` - Revoke token
- `GET /api/products` - List products
- `POST /api/cart` - Add to cart (requires customer scope)
- `POST /api/orders` - Create order (requires customer scope)
- `GET /api/subscriptions` - List subscriptions (requires customer scope)

### Key Directories

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/          # API controllers
│   ├── Middleware/        # Custom middleware
│   └── Requests/          # Form request validation
├── Livewire/
│   ├── Admin/             # Admin Livewire components
│   └── Customer/          # Customer Livewire components
├── Models/                # Eloquent models
└── Policies/              # Authorization policies

database/
├── migrations/            # Database migrations
└── seeders/              # Database seeders

resources/
├── views/
│   ├── admin/            # Admin views
│   ├── customer/         # Customer views
│   └── livewire/         # Livewire component views
└── js/                   # JavaScript assets

routes/
├── web.php               # Web routes
└── api.php               # API routes
```

## Database Schema

### Key Tables
- `users` - Authentication users (with role: admin/customer)
- `admins` - Admin records
- `customers` - Customer records
- `products` - Product catalog
- `carts` - Shopping carts
- `cart_items` - Cart items
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment records
- `subscriptions` - Customer subscriptions
- `messages` - Customer messages to admin

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
./vendor/bin/pint
```

### Database Reset

To reset the database and reseed:

```bash
php artisan migrate:fresh --seed
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## API Usage

### Authentication

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password"}'

# Response includes token
{
  "success": true,
  "data": {
    "token": "1|...",
    "user": {...}
  }
}
```

### Using the Token

```bash
# Get products
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN"

# Add to cart
curl -X POST http://localhost:8000/api/cart \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"product_id":1,"quantity":2}'
```

## Security

See [docs/security.md](docs/security.md) for comprehensive security documentation.

Key security features:
- CSRF protection
- XSS prevention
- SQL injection prevention
- Password hashing (bcrypt)
- Token-based API authentication
- Role-based access control
- Secure session management

## Technologies Used

- **Laravel 12** - PHP framework
- **Laravel Jetstream** - Authentication scaffolding
- **Laravel Livewire** - Dynamic UI components
- **Laravel Sanctum** - API authentication
- **Tailwind CSS** - Utility-first CSS framework
- **MySQL** - Database
- **Alpine.js** - Lightweight JavaScript framework

## Troubleshooting

### Database Connection Issues
- Verify MySQL is running
- Check `.env` database credentials
- Ensure database exists

### Migration Errors
- Run `php artisan migrate:fresh` to reset
- Check database user permissions

### Asset Compilation Issues
- Run `npm install` to reinstall dependencies
- Clear cache: `php artisan view:clear`

### Permission Issues
- Ensure `storage/` and `bootstrap/cache/` are writable
- Run `chmod -R 775 storage bootstrap/cache`

## Contributing

1. Follow Laravel coding standards
2. Write tests for new features
3. Update documentation as needed
4. Ensure all tests pass before submitting

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues or questions, please refer to the documentation or contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: 2026-01-07
