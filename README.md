# Art & Stationery Multi-Vendor E-Commerce Platform

## 📋 Table of Contents
- [Overview](#overview)
- [Screenshots](#screenshots)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Security Features](#security-features)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [User Roles](#user-roles)
- [Security Best Practices](#security-best-practices)
- [Out of Scope](#out-of-scope)
- [Contributing](#contributing)
- [License](#license)

---

## 🎨 Overview

**Art & Stationery** is a comprehensive multi-vendor e-commerce platform built with PHP and MySQL. The platform enables artists and stationery suppliers to sell their products online while providing buyers with a seamless shopping experience. The system supports three distinct user roles: **Buyers**, **Sellers**, and **Admins**, each with tailored dashboards and functionalities.

### Key Highlights
- **Multi-vendor marketplace** with seller verification
- **Enterprise-grade security** with CSRF protection, XSS prevention, and SQL injection safeguards
- **Role-based access control** (RBAC) for buyers, sellers, and administrators
- **Responsive design** with modern UI/UX
- **Comprehensive product management** with categories, inventory tracking, and reviews
- **Secure authentication** with bcrypt password hashing and session management
- **Rate limiting** to prevent brute-force attacks

---

## 📸 Screenshots

### Homepage
![Homepage](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_homepage_png_1764351126993.png)
*The main landing page featuring hero section, featured products, and navigation*

### Products Catalog
![Products Page](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_products_png_1764351190600.png)
*Browse all available products with category filters and search functionality*

### Product Details
![Product Detail Page](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_product_detail_png_1764351318322.png)
*Detailed product view with description, pricing, seller information, and add to cart option*

### User Authentication
![Login Page](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_login_png_1764351407168.png)
*Secure login page with CSRF protection and rate limiting*

![Registration Page](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_register_png_1764351519664.png)
*User registration with buyer/seller selection and password strength validation*

### Informational Pages
![About Us](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_about_png_1764351680896.png)
*About page with company information and mission statement*

![Contact Us](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_contact_png_1764351791536.png)
*Contact form with Google Maps integration for location*

![FAQ](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_faq_png_1764351891988.png)
*Frequently asked questions with expandable answers*

![Locations](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_locations_png_1764352009012.png)
*Store locations with interactive map and contact details*

### Admin Panel
![Admin Login](file:///C:/Users/User/.gemini/antigravity/brain/e8184923-6c7c-4268-9337-ddc83e652f07/c_users_user_desktop_art_stationery_assets_screenshots_admin_login_png_1764352100310.png)
*Admin authentication portal with enhanced security*

---

## ✨ Features

### For Buyers
- 🛒 **Shopping Cart** - Add products to cart and manage quantities
- 💳 **Checkout System** - Secure order placement with shipping address
- 📦 **Order Tracking** - View order history and status
- ⭐ **Product Reviews** - Rate and review purchased products
- 💬 **Seller Communication** - Direct messaging with sellers
- 🔍 **Product Search** - Browse by categories and search products
- 📧 **Newsletter Subscription** - Stay updated with latest offerings

### For Sellers
- 📊 **Seller Dashboard** - Comprehensive analytics and sales overview
- ➕ **Product Management** - Add, edit, and delete products
- 📦 **Inventory Management** - Track stock levels and availability
- 🚚 **Order Management** - Process and fulfill customer orders
- 💼 **Business Profile** - Manage business information and verification documents
- 📈 **Sales Analytics** - View sales performance and trends

### For Administrators
- 👥 **User Management** - Manage buyers, sellers, and admins
- ✅ **Seller Verification** - Approve/reject seller applications
- 📊 **Platform Analytics** - Monitor overall platform performance
- 🛡️ **Security Logs** - Review security events and suspicious activities
- 🏷️ **Category Management** - Create and manage product categories
- 🔧 **System Configuration** - Platform-wide settings and controls

### General Features
- 🔐 **Secure Authentication** - Login/registration with CSRF protection
- 🔒 **Session Management** - Automatic timeout and session regeneration
- 📱 **Responsive Design** - Mobile-friendly interface
- 🎨 **Modern UI** - Clean, professional design with smooth animations
- 📄 **Informational Pages** - About Us, Contact, FAQ, Locations
- 🔔 **Flash Messages** - User-friendly notifications and alerts

---

## 🛠️ Technology Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL 5.7+** - Relational database management
- **PDO** - Database abstraction layer with prepared statements

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with gradients, animations, and flexbox
- **JavaScript** - Client-side interactivity
- **Google Fonts** - Typography (Inter, Roboto)

### Security
- **bcrypt** - Password hashing (cost factor: 12)
- **CSRF Tokens** - Cross-Site Request Forgery protection
- **XSS Prevention** - Input sanitization and output escaping
- **SQL Injection Protection** - Parameterized queries with PDO
- **Security Headers** - X-Frame-Options, X-XSS-Protection, CSP

---

## 📁 Project Structure

```
ART_STATIONERY/
├── admin/                  # Admin panel files
│   ├── index.php          # Admin dashboard
│   ├── includes/          # Admin-specific includes
│   ├── css/               # Admin styles
│   └── js/                # Admin scripts
├── assets/                # Static resources
│   ├── css/               # Stylesheets
│   ├── images/            # Site images
│   ├── products/          # Product images
│   └── uploads/           # User-uploaded files
├── config/                # Configuration files
│   ├── database.php       # Database connection
│   ├── security.php       # Security functions and headers
│   ├── init_db.php        # Database initialization script
│   └── schema.sql         # Database schema
├── controllers/           # Business logic controllers
│   ├── auth.php           # Authentication controller
│   ├── cart_controller.php
│   ├── order_controller.php
│   └── product_controller.php
├── includes/              # Reusable components
│   └── functions.php      # Helper functions
├── seller/                # Seller panel files
│   ├── dashboard.php      # Seller dashboard
│   ├── products.php       # Product management
│   ├── orders.php         # Order management
│   └── inventory.php      # Inventory tracking
├── user/                  # User-specific pages
│   ├── cart.php
│   ├── checkout.php
│   └── orders.php
├── views/                 # View templates
├── index.php              # Homepage
├── login.php              # Login page
├── register.php           # Registration page
├── products.php           # Product listing
├── product.php            # Product details
├── cart.php               # Shopping cart
├── checkout.php           # Checkout page
├── about.php              # About Us page
├── contact.php            # Contact page
├── faq.php                # FAQ page
├── locations.php          # Store locations
├── .env                   # Environment variables (not in repo)
├── .gitignore             # Git ignore rules
└── README.md              # This file
```

---

## 🔒 Security Features

This platform implements **enterprise-grade security measures** to protect against common web vulnerabilities and attacks.

### 1. **SQL Injection Prevention**
- ✅ **Prepared Statements** - All database queries use PDO prepared statements with parameter binding
- ✅ **Input Validation** - Strict type checking and sanitization
- ✅ **No Dynamic SQL** - Queries are never constructed from user input

**Implementation:**
```php
// All queries use prepared statements
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

### 2. **Cross-Site Scripting (XSS) Protection**
- ✅ **Input Sanitization** - `htmlspecialchars()` with `ENT_QUOTES` and UTF-8 encoding
- ✅ **Output Escaping** - All user-generated content is escaped before display
- ✅ **Content Security Policy** - CSP headers restrict script sources
- ✅ **X-XSS-Protection Header** - Browser-level XSS filtering enabled

**Implementation:**
```php
// Input sanitization
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Output escaping
function escape_html($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
```

### 3. **Cross-Site Request Forgery (CSRF) Protection**
- ✅ **CSRF Tokens** - Unique tokens generated for each session
- ✅ **Token Validation** - All form submissions require valid CSRF token
- ✅ **Token Expiry** - Tokens expire after 1 hour
- ✅ **Timing Attack Prevention** - `hash_equals()` for token comparison

**Implementation:**
```php
// Token generation (1-hour expiry)
function generate_csrf_token() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME]) || token_expired()) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        $_SESSION[CSRF_TOKEN_TIME_NAME] = time();
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Token validation (timing-attack resistant)
function validate_csrf_token($token) {
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}
```

### 4. **Secure Password Management**
- ✅ **bcrypt Hashing** - Industry-standard password hashing (cost: 12)
- ✅ **Password Strength Requirements**:
  - Minimum 8 characters
  - At least one uppercase letter
  - At least one lowercase letter
  - At least one number
  - At least one special character
- ✅ **No Password Storage** - Only hashed passwords are stored

**Implementation:**
```php
// Password hashing with bcrypt (cost factor: 12)
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

// Password verification
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}
```

### 5. **Session Security**
- ✅ **HttpOnly Cookies** - Prevents JavaScript access to session cookies
- ✅ **SameSite Attribute** - Set to 'Strict' to prevent CSRF
- ✅ **Session Timeout** - Automatic logout after 30 minutes of inactivity
- ✅ **Session Regeneration** - ID regenerated every 30 minutes and on login
- ✅ **Strict Mode** - Prevents session fixation attacks

**Configuration:**
```php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
// ini_set('session.cookie_secure', 1); // Enable for HTTPS
```

### 6. **Rate Limiting & Brute-Force Protection**
- ✅ **Login Attempt Tracking** - Maximum 5 failed attempts
- ✅ **Account Lockout** - 15-minute lockout after max attempts
- ✅ **IP-based Tracking** - Prevents distributed attacks
- ✅ **Progressive Delays** - Increasing delays between attempts

**Implementation:**
```php
// Rate limiting constants
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// Check and record login attempts
check_login_attempts($identifier);
record_login_attempt($identifier, $success);
```

### 7. **Security Headers**
All pages automatically include security headers:

| Header | Value | Purpose |
|--------|-------|---------|
| `X-Frame-Options` | `SAMEORIGIN` | Prevents clickjacking |
| `X-XSS-Protection` | `1; mode=block` | Enables browser XSS filter |
| `X-Content-Type-Options` | `nosniff` | Prevents MIME sniffing |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | Controls referrer information |
| `Content-Security-Policy` | Restrictive policy | Prevents unauthorized scripts |
| `Strict-Transport-Security` | `max-age=31536000` | Forces HTTPS (production) |

### 8. **File Upload Security**
- ✅ **MIME Type Validation** - Verifies actual file type, not just extension
- ✅ **File Size Limits** - Maximum 5MB per file
- ✅ **Extension Whitelist** - Only allowed extensions (jpg, jpeg, png, gif, webp)
- ✅ **Filename Sanitization** - Prevents directory traversal

### 9. **Security Logging**
- ✅ **Event Tracking** - All security events are logged
- ✅ **Audit Trail** - User ID, IP address, user agent, timestamp
- ✅ **Logged Events**:
  - Login success/failure
  - Registration attempts
  - CSRF validation failures
  - Account lockouts
  - Admin actions

**Database Table:**
```sql
CREATE TABLE security_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_type VARCHAR(50) NOT NULL,
    description TEXT,
    user_id INT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 10. **Additional Security Measures**
- ✅ **Remember Me Tokens** - Secure token storage with SHA-256 hashing
- ✅ **Email Validation** - Server-side email format verification
- ✅ **Input Type Validation** - Separate sanitization for emails, URLs, integers, floats
- ✅ **Error Handling** - Generic error messages (no information disclosure)
- ✅ **Database Transactions** - ACID compliance for critical operations

---

## 🗄️ Database Schema

The platform uses a normalized MySQL database with the following tables:

### Core Tables

#### `users`
Stores all user accounts (buyers and sellers)
- `id` - Primary key
- `full_name` - User's full name
- `email` - Unique email address
- `password` - bcrypt hashed password
- `user_type` - ENUM('buyer', 'seller')
- `created_at`, `updated_at` - Timestamps

#### `admins`
Stores administrator accounts
- `id` - Primary key
- `username` - Unique username
- `email` - Unique email address
- `password` - bcrypt hashed password
- `created_at` - Timestamp

#### `seller_details`
Extended information for sellers
- `user_id` - Foreign key to users
- `business_name` - Business name
- `business_address` - Business address
- `identity_proof` - Path to uploaded ID document
- `payment_proof` - Path to payment verification
- `is_approved` - Boolean approval status
- `created_at` - Timestamp

#### `categories`
Product categories
- `id` - Primary key
- `name` - Unique category name
- `description` - Category description
- `created_at` - Timestamp

#### `products`
Product listings
- `id` - Primary key
- `seller_id` - Foreign key to users
- `category_id` - Foreign key to categories
- `name` - Product name
- `description` - Product description
- `price` - Decimal(10,2)
- `stock_quantity` - Integer
- `image_url` - Product image path
- `created_at`, `updated_at` - Timestamps

#### `orders`
Order summaries
- `id` - Primary key
- `user_id` - Foreign key to users
- `total_amount` - Decimal(10,2)
- `status` - ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled')
- `shipping_address` - Text
- `created_at`, `updated_at` - Timestamps

#### `order_items`
Individual items within orders
- `id` - Primary key
- `order_id` - Foreign key to orders
- `product_id` - Foreign key to products
- `seller_id` - Foreign key to users (denormalized)
- `quantity` - Integer
- `price` - Decimal(10,2) (snapshot at purchase time)

#### `cart`
Shopping cart items
- `id` - Primary key
- `user_id` - Foreign key to users
- `product_id` - Foreign key to products
- `quantity` - Integer
- `created_at` - Timestamp
- Unique constraint on (user_id, product_id)

#### `reviews`
Product reviews and ratings
- `id` - Primary key
- `product_id` - Foreign key to products
- `user_id` - Foreign key to users
- `rating` - Integer (1-5)
- `comment` - Text
- `created_at` - Timestamp

#### `messages`
Buyer-seller communication
- `id` - Primary key
- `sender_id` - Foreign key to users
- `receiver_id` - Foreign key to users
- `message` - Text
- `is_read` - Boolean
- `created_at` - Timestamp

#### `security_logs`
Security event logging
- `id` - Primary key
- `event_type` - VARCHAR(50)
- `description` - Text
- `user_id` - Foreign key to users (nullable)
- `ip_address` - VARCHAR(45)
- `user_agent` - Text
- `created_at` - Timestamp

#### `remember_tokens`
Persistent login tokens
- `id` - Primary key
- `user_id` - Foreign key to users
- `token` - SHA-256 hashed token
- `expires_at` - Timestamp

---

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional, for dependencies)

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd ART_STATIONERY
   ```

2. **Configure Database**
   
   Edit `config/database.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'art_stationery_db');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

3. **Initialize Database**
   
   Run the initialization script to create tables and default data:
   ```bash
   php config/init_db.php
   ```
   
   Or manually import the schema:
   ```bash
   mysql -u your_username -p art_stationery_db < config/schema.sql
   ```

4. **Set Up Environment Variables** (Optional)
   
   Create a `.env` file in the root directory:
   ```env
   DB_HOST=localhost
   DB_NAME=art_stationery_db
   DB_USER=your_username
   DB_PASS=your_password
   ```

5. **Configure File Permissions**
   
   Ensure upload directories are writable:
   ```bash
   chmod 755 assets/uploads
   chmod 755 assets/products
   ```

6. **Start the Application**
   
   Using PHP built-in server:
   ```bash
   php -S localhost:8000
   ```
   
   Or configure Apache/Nginx to point to the project directory.

7. **Access the Application**
   
   Open your browser and navigate to:
   - **Homepage**: `http://localhost:8000/`
   - **Admin Panel**: `http://localhost:8000/admin/`
   - **Login**: `http://localhost:8000/login.php`

### Default Credentials

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

> ⚠️ **Important**: Change the default admin password immediately after first login!

---

## ⚙️ Configuration

### Security Configuration

Edit `config/security.php` to customize security settings:

```php
// CSRF token expiry (seconds)
define('CSRF_TOKEN_EXPIRY', 3600); // 1 hour

// Session timeout (seconds)
define('SESSION_TIMEOUT', 1800); // 30 minutes

// Login rate limiting
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// Password requirements
define('PASSWORD_MIN_LENGTH', 8);
```

### HTTPS Configuration

For production environments with HTTPS, uncomment these lines in `config/security.php`:

```php
// Force HTTPS
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

// Secure cookies
ini_set('session.cookie_secure', 1);
```

### File Upload Limits

Adjust file upload limits in `config/security.php`:

```php
function validate_file_upload($file, 
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], 
    $max_size = 5242880 // 5MB
)
```

---

## 📖 Usage

### For Buyers

1. **Registration**
   - Navigate to `/register.php`
   - Select "Buyer" as user type
   - Fill in required information
   - Submit to create account

2. **Shopping**
   - Browse products on homepage or `/products.php`
   - Click on products to view details
   - Add items to cart
   - Proceed to checkout

3. **Order Management**
   - View order history at `/orders.php`
   - Track order status
   - Leave reviews for purchased products

### For Sellers

1. **Registration**
   - Navigate to `/register.php`
   - Select "Seller" as user type
   - Provide business information
   - Wait for admin approval

2. **Product Management**
   - Access seller dashboard at `/seller/dashboard.php`
   - Add new products via `/seller/add_product.php`
   - Edit/delete existing products
   - Manage inventory levels

3. **Order Fulfillment**
   - View incoming orders at `/seller/orders.php`
   - Update order status
   - Track sales analytics

### For Administrators

1. **Login**
   - Navigate to `/admin/`
   - Use admin credentials

2. **Platform Management**
   - Approve/reject seller applications
   - Manage users and products
   - View security logs
   - Monitor platform analytics

---

## 👥 User Roles

### Buyer
- Browse and search products
- Add items to cart
- Place orders
- Track order status
- Leave product reviews
- Message sellers

### Seller
- List and manage products
- Track inventory
- Process orders
- View sales analytics
- Communicate with buyers
- Requires admin approval

### Administrator
- Full platform access
- User management
- Seller verification
- Security monitoring
- System configuration
- Analytics and reporting

---

## 🛡️ Security Best Practices

### For Developers

1. **Never Trust User Input**
   - Always sanitize and validate all user inputs
   - Use prepared statements for database queries
   - Escape output before displaying

2. **Keep Dependencies Updated**
   - Regularly update PHP and MySQL
   - Monitor security advisories

3. **Use HTTPS in Production**
   - Obtain SSL/TLS certificate
   - Enable secure cookie flags
   - Force HTTPS redirects

4. **Regular Security Audits**
   - Review security logs regularly
   - Monitor failed login attempts
   - Check for suspicious activities

5. **Backup Regularly**
   - Implement automated database backups
   - Store backups securely off-site
   - Test backup restoration procedures

### For Administrators

1. **Change Default Credentials**
   - Update default admin password immediately
   - Use strong, unique passwords

2. **Monitor Security Logs**
   - Review `security_logs` table regularly
   - Investigate suspicious patterns

3. **Seller Verification**
   - Thoroughly verify seller documents
   - Check business legitimacy

4. **Regular Updates**
   - Keep the platform updated
   - Apply security patches promptly

---

## 🚫 Out of Scope

The following features are **NOT** included in the current version:

### Payment Processing
- ❌ **Payment Gateway Integration** - No Stripe, PayPal, or other payment processors
- ❌ **Transaction Processing** - Orders are recorded but payments are not processed
- ❌ **Refund Management** - No automated refund system
- ❌ **Invoice Generation** - No PDF invoice creation

### Advanced Features
- ❌ **Email Notifications** - No automated email system (registration, order confirmations, etc.)
- ❌ **SMS Notifications** - No SMS alerts for orders or updates
- ❌ **Real-time Chat** - Messaging system exists but not real-time (no WebSockets)
- ❌ **Advanced Search** - No full-text search or filtering by multiple criteria
- ❌ **Wishlist** - No product wishlist functionality
- ❌ **Product Comparison** - No side-by-side product comparison
- ❌ **Multi-language Support** - English only
- ❌ **Multi-currency Support** - Single currency (USD)

### Shipping & Logistics
- ❌ **Shipping Integration** - No integration with shipping carriers (FedEx, UPS, etc.)
- ❌ **Shipping Rate Calculation** - No automated shipping cost calculation
- ❌ **Tracking Number Integration** - Manual tracking number entry only
- ❌ **Print Shipping Labels** - No label printing functionality

### Analytics & Reporting
- ❌ **Advanced Analytics** - Basic analytics only, no Google Analytics integration
- ❌ **Export Reports** - No CSV/PDF export functionality
- ❌ **Sales Forecasting** - No predictive analytics
- ❌ **Inventory Alerts** - No low-stock notifications

### Social Features
- ❌ **Social Media Integration** - No sharing to Facebook, Twitter, etc.
- ❌ **Social Login** - No OAuth login (Google, Facebook)
- ❌ **User Profiles** - Basic profiles only, no public user pages
- ❌ **Follow Sellers** - No seller following functionality

### Mobile
- ❌ **Native Mobile Apps** - Web-responsive only, no iOS/Android apps
- ❌ **Progressive Web App (PWA)** - No offline functionality

### Advanced Security
- ❌ **Two-Factor Authentication (2FA)** - Not implemented
- ❌ **OAuth 2.0** - No third-party authentication
- ❌ **API Rate Limiting** - No API (no rate limiting needed)
- ❌ **DDoS Protection** - Requires infrastructure-level solution
- ❌ **Web Application Firewall (WAF)** - Requires infrastructure-level solution

### API
- ❌ **RESTful API** - No API endpoints for external integrations
- ❌ **GraphQL API** - No GraphQL support
- ❌ **Webhooks** - No webhook system

### Content Management
- ❌ **Blog System** - No blog or news section
- ❌ **CMS** - No content management system for pages
- ❌ **SEO Tools** - Basic meta tags only, no advanced SEO features

---

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. **Fork the Repository**
2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Commit Your Changes**
   ```bash
   git commit -m "Add: Description of your feature"
   ```
4. **Push to Your Branch**
   ```bash
   git push origin feature/your-feature-name
   ```
5. **Open a Pull Request**

### Code Standards
- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Comment complex logic
- Write secure code (sanitize inputs, use prepared statements)
- Test thoroughly before submitting

---

## 📄 License

This project is licensed under the **MIT License**.

```
MIT License

Copyright (c) 2025 Art & Stationery Platform

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📞 Support

For questions, issues, or feature requests:

- **GitHub Issues**: [Create an issue](https://github.com/your-repo/issues)
- **Email**: support@artstationery.com
- **Documentation**: See `docs.md` for additional technical details

---

## 🙏 Acknowledgments

- **PHP Community** - For excellent documentation and resources
- **Security Researchers** - For OWASP guidelines and best practices
- **Open Source Contributors** - For inspiration and code examples

---

**Built with ❤️ for artists and stationery enthusiasts**