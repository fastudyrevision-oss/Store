# Art & Stationery Platform Documentation

## System Overview
This platform is a multi-vendor e-commerce application built with PHP and MySQL. It supports two user roles: **Buyers** and **Sellers**.

## Core Functions (`includes/functions.php`)

### `sanitize($data)`
Sanitizes input data by removing HTML tags and special characters to prevent XSS.

### `redirect($url)`
Redirects the user to the specified URL and exits the script.

### `set_flash_message($type, $message)`
Sets a session-based flash message to be displayed on the next page load.
- `$type`: 'success', 'error', 'warning', 'info'
- `$message`: The text content of the message.

### `get_flash_message()`
Retrieves and clears the current flash message from the session.

### `is_logged_in()`
Checks if a user session exists. Returns `true` or `false`.

### `require_login()`
Enforces authentication. Redirects to `login.php` if the user is not logged in.

### `require_seller()`
Enforces seller privileges. Redirects if the user is not logged in or is not a seller.

### `format_price($amount)`
Formats a number as a currency string (e.g., "$10.00").

### `generate_csrf_token()` / `verify_csrf_token($token)`
(Planned) Functions to handle CSRF protection for forms.

## Database Schema
The database `art_stationery_db` consists of the following key tables:
- `users`: Stores login credentials and user type.
- `seller_details`: Stores business info and verification proofs for sellers.
- `products`: Stores product listings linked to sellers and categories.
- `orders`: Stores order summaries.
- `order_items`: Stores individual items within an order, linked to products and sellers.
- `cart`: Temporary storage for items added by buyers.

## Setup Instructions
1. Configure database credentials in `config/database.php`.
2. Run `config/init_db.php` to initialize the schema.
3. Ensure `assets/uploads` directory exists and is writable.
