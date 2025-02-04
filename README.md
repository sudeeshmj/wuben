# E-Commerce API with Laravel

This is a simple e-commerce platform built using Laravel and Laravel Sanctum for authentication.

## 🚀 Features

- User authentication (Register, Login, Logout) using Laravel Sanctum.
- CRUD operations for products.
- Add/remove products from the cart.
- Checkout and create orders.
- View order history.
- Uses MySQL database.
- API-based implementation with proper validation.

## 📌 Installation & Setup

### Prerequisites
- PHP 8.x
- MySQL
- Composer
- Laravel 11
- Git
- Postman (or any API testing tool)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/sudeeshmj/wuben.git
   cd webaune
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the environment variables:
   - Copy `.env.example` to `.env`:
     ```bash
     copy .env.example .env
     ```
   - Update the `.env` file with database credentials.

4. Generate key:
   ```bash
   php artisan key:generate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

