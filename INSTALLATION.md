# Installation Guide - Multi-Vendor E-commerce Platform

## System Requirements

- PHP 8.2 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Composer 2.x
- Node.js 18+ & NPM
- Git

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd ecommerce
```

### 2. Install Dependencies

**Install PHP dependencies:**
```bash
composer install
```

**Install Node.js dependencies:**
```bash
npm install
```

### 3. Environment Configuration

**Copy the environment file:**
```bash
cp .env.example .env
```

**Edit .env file and configure:**

```env
# Application
APP_NAME=Ecommerce
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# ToyyibPay Configuration
TOYYIBPAY_CATEGORY_CODE=your_category_code
TOYYIBPAY_SECRET_KEY=your_secret_key

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
```

### 4. Create Database

**Create a MySQL database:**
```sql
CREATE DATABASE ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or use phpMyAdmin / MySQL Workbench to create the database.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Seed sample data including:
  - 1 Admin user
  - 3 Seller users with shops
  - 10 Customer users
  - 5 Categories
  - 15 Products
  - 2 Promotions

### 7. Create Storage Link

```bash
php artisan storage:link
```

This creates a symbolic link for product images.

### 8. Build Frontend Assets

**For development:**
```bash
npm run dev
```

**For production:**
```bash
npm run build
```

### 9. Start Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Default Login Credentials

### Admin Account
- Email: `admin@ecommerce.com`
- Password: `password`
- Access: Full system management

### Seller Accounts
1. **Tech Haven**
   - Email: `seller1@example.com`
   - Password: `password`

2. **Fashion World**
   - Email: `seller2@example.com`
   - Password: `password`

3. **Home & Living**
   - Email: `seller3@example.com`
   - Password: `password`

### Customer Accounts
- Email: `customer1@example.com` to `customer10@example.com`
- Password: `password`

## ToyyibPay Setup

### 1. Register for ToyyibPay

1. Visit [https://toyyibpay.com](https://toyyibpay.com)
2. Create an account
3. Complete KYC verification

### 2. Get API Credentials

1. Login to ToyyibPay dashboard
2. Go to Settings → API
3. Copy your:
   - Category Code
   - Secret Key

### 3. Configure in Application

Update your `.env` file:
```env
TOYYIBPAY_CATEGORY_CODE=your_actual_category_code
TOYYIBPAY_SECRET_KEY=your_actual_secret_key
```

### 4. Test Payment

For development, ToyyibPay provides a sandbox environment:
```env
# Use sandbox URL in PaymentController if testing
TOYYIBPAY_URL=https://dev.toyyibpay.com/
```

## Troubleshooting

### Issue: "Class not found" errors

**Solution:**
```bash
composer dump-autoload
```

### Issue: Permission denied on storage

**Solution:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Issue: Images not showing

**Solution:**
```bash
php artisan storage:link
```

### Issue: CSS/JS not loading

**Solution:**
```bash
npm run build
php artisan cache:clear
```

### Issue: Migration fails

**Solution:**
```bash
# Drop all tables and re-run
php artisan migrate:fresh --seed
```

### Issue: Payment callback not working

**Solution:**
- Ensure your application is accessible from the internet (use ngrok for local development)
- Configure callback URL in ToyyibPay dashboard
- Check webhook logs in ToyyibPay

## Production Deployment

### 1. Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Optimize Application

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Set Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 4. Configure Web Server

**Apache (.htaccess):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/ecommerce/public;

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
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 5. Set Up Cron Job

Add to crontab:
```bash
* * * * * cd /path/to/ecommerce && php artisan schedule:run >> /dev/null 2>&1
```

### 6. Set Up Queue Worker

```bash
php artisan queue:work --daemon
```

Or use supervisor for production.

## Additional Configuration

### Email Notifications

Configure mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Upload Limits

Edit `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

## Testing the Application

### 1. Test as Customer

1. Register a new account or login as customer1@example.com
2. Browse products
3. Add items to cart
4. Proceed to checkout
5. Make a payment (test mode)

### 2. Test as Seller

1. Login as seller1@example.com
2. Add a new product
3. Manage existing products
4. Process orders
5. Update order status

### 3. Test as Admin

1. Login as admin@ecommerce.com
2. Approve/reject pending sellers
3. Approve/reject pending products
4. View analytics
5. Manage categories

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review Laravel documentation: https://laravel.com/docs
3. Check ToyyibPay documentation: https://toyyibpay.com/apireference
4. Create an issue in the repository

## Next Steps

After installation:
1. Change all default passwords
2. Configure proper email settings
3. Set up ToyyibPay production credentials
4. Customize the design and branding
5. Add your own products and categories
6. Configure SSL certificate for production
7. Set up regular backups
8. Configure monitoring and logging

---

Installation complete! 🎉 Your multi-vendor e-commerce platform is ready to use.

