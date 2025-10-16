# Multi-Vendor E-commerce Platform

A comprehensive multi-vendor e-commerce web application built with Laravel 11, featuring role-based access control, ToyyibPay payment integration, and a modern responsive UI with Tailwind CSS.

## 🚀 Features

### User Roles
- **Admin**: Complete system management and oversight
- **Seller**: Manage products, orders, and shop
- **Customer**: Browse, purchase, and review products

### Core Features

#### 🔐 Authentication & Authorization
- Register, Login, Logout
- Role-based redirects (Admin → Dashboard, Seller → Seller Panel, Customer → Home)
- Forgot/Reset password functionality
- Profile management

#### 🛒 Customer Features
- Browse and search products by category or keyword
- View detailed product information (images, price, seller info)
- Shopping cart management (add, update, remove items)
- Secure checkout with ToyyibPay payment gateway
- Order history and tracking
- Delivery status tracking
- Wishlist functionality
- Product reviews and ratings
- Seller profile/shop pages
- Support ticket system

#### 🏪 Seller Features
- Seller registration (requires admin approval)
- Shop profile management (name, description, banner)
- Product CRUD operations
- Stock and pricing management
- Order processing and management
- Order status updates (processing, shipped, delivered)
- Sales summary and earnings dashboard
- Customer message/ticket responses

#### 🧑‍💼 Admin Features
- User management (approve sellers, suspend accounts)
- Product approval and management
- Order oversight and status updates
- Payment verification (ToyyibPay transactions)
- Category, tag, and attribute management
- Coupon/discount/promotion management
- Review and rating moderation
- Support ticket management
- Analytics dashboard (sales, top sellers, top products)
- System settings management

### 💳 Payment Integration
- ToyyibPay payment gateway integration
- Secure payment redirection
- Automatic order and payment status updates
- Payment reference tracking
- Email notifications for customers and sellers

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Breeze
- **Payment Gateway**: ToyyibPay
- **Architecture**: MVC with Repository Pattern

## 📦 Database Schema

### Tables
- `users` - User accounts with role-based access
- `sellers` - Seller profiles and shop information
- `categories` - Product categories (hierarchical)
- `products` - Product listings with images and details
- `carts` - Shopping cart management
- `cart_items` - Cart item details
- `orders` - Order information
- `order_items` - Order line items
- `payments` - Payment transaction records
- `reviews` - Product reviews and ratings
- `promotions` - Discount codes and promotions
- `tickets` - Customer support tickets
- `notifications` - User notifications
- `wishlists` - User wishlists

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd ecommerce
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install
```

4. **Configure environment**
```bash
cp .env.example .env
```

5. **Update .env file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=your_password

TOYYIBPAY_CATEGORY_CODE=your_category_code
TOYYIBPAY_SECRET_KEY=your_secret_key
```

6. **Generate application key**
```bash
php artisan key:generate
```

7. **Run migrations and seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Create storage link**
```bash
php artisan storage:link
```

9. **Build assets**
```bash
npm run build
```

10. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 👥 Default Users

After running seeders, you can login with these accounts:

### Admin
- Email: `admin@ecommerce.com`
- Password: `password`

### Sellers
- Email: `seller1@example.com` / `seller2@example.com` / `seller3@example.com`
- Password: `password`

### Customers
- Email: `customer1@example.com` through `customer10@example.com`
- Password: `password`

## 🔧 Configuration

### ToyyibPay Setup

1. Register at [ToyyibPay](https://toyyibpay.com)
2. Get your Category Code and Secret Key
3. Update `.env` file with your credentials:
```env
TOYYIBPAY_CATEGORY_CODE=your_category_code
TOYYIBPAY_SECRET_KEY=your_secret_key
```

### File Storage

Product images are stored in `storage/app/public/products`. Ensure the storage link is created:
```bash
php artisan storage:link
```

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Seller/         # Seller controllers
│   │   └── ...             # Public controllers
│   └── Middleware/
│       ├── AdminMiddleware.php
│       ├── SellerMiddleware.php
│       └── CustomerMiddleware.php
├── Models/                 # Eloquent models
database/
├── migrations/            # Database migrations
└── seeders/              # Database seeders
resources/
├── views/
│   ├── admin/            # Admin views
│   ├── seller/           # Seller views
│   ├── products/         # Product views
│   ├── cart/             # Cart views
│   └── ...
routes/
└── web.php               # Application routes
```

## 🎨 Key Features Implementation

### Role-Based Access Control
Middleware protects routes based on user roles:
- `admin` - Admin only routes
- `seller` - Seller only routes
- `customer` - Customer only routes

### Multi-Vendor Order System
Orders are automatically split by seller, allowing:
- Independent order processing per seller
- Separate payment tracking
- Individual seller analytics

### Payment Flow
1. Customer places order
2. Redirected to ToyyibPay
3. Payment processed
4. Callback updates order status
5. Email notifications sent

## 🧪 Testing

Run PHPUnit tests:
```bash
php artisan test
```

## 🔒 Security Features

- CSRF protection on all forms
- XSS protection via Blade templating
- SQL injection prevention via Eloquent ORM
- Password hashing with bcrypt
- Role-based authorization
- Secure payment processing

## 📱 Responsive Design

The application is fully responsive using Tailwind CSS, supporting:
- Desktop
- Tablet
- Mobile devices

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 🐛 Known Issues

None at the moment. Please report any issues you encounter.

## 📞 Support

For support, please create a ticket through the support system or contact the administrator.

## 🎯 Future Enhancements

- [ ] Real-time notifications using WebSockets
- [ ] Advanced analytics and reporting
- [ ] Multi-language support
- [ ] Mobile app (React Native/Flutter)
- [ ] Social media integration
- [ ] Advanced search with filters
- [ ] Product variants and options
- [ ] Bulk product import/export
- [ ] Seller subscription plans
- [ ] Advanced shipping options

---

Built with ❤️ using Laravel 11
