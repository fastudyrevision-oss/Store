# Art Stationery Project

## Overview
The Art Stationery project is a web application designed to manage products, orders, and customers for an online stationery store. It provides functionalities for listing, adding, editing, and deleting products, as well as managing customer information and processing orders.

## Project Structure
The project is organized into several directories and files, each serving a specific purpose:

- **config/**: Contains configuration files, including database settings.
- **includes/**: Contains reusable components such as headers, footers, and navigation bars.
- **models/**: Contains classes that represent the core entities of the application, such as products, orders, and customers.
- **controllers/**: Contains classes that handle the business logic and user requests.
- **views/**: Contains the presentation layer, including HTML files for displaying products, orders, and customers.
- **assets/**: Contains static files such as CSS, JavaScript, and images.
- **index.php**: The entry point of the application.

## Setup Instructions
1. **Clone the repository**:
   ```
   git clone <repository-url>
   cd art_stationery
   ```

2. **Install dependencies**:
   Make sure you have Composer installed, then run:
   ```
   composer install
   ```

3. **Configure the database**:
   Edit the `config/db.php` file to set your database connection parameters.

4. **Set up environment variables**:
   Create a `.env` file in the root directory and define your environment variables.

5. **Run the application**:
   You can use a local server like XAMPP or MAMP, or use PHP's built-in server:
   ```
   php -S localhost:8000
   ```

## Usage
- Navigate to the homepage to view the available products.
- Use the navigation bar to access different sections of the application, such as products, orders, and customers.
- Follow the prompts to add, edit, or delete entries as needed.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.