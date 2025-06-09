# Laravel Inventory Management System

## Overview
This project is a focused module for managing inventory, dynamic pricing, and transaction processing. It includes time-based and quantity-based pricing rules with concurrency-safe transactions and audit logging.

---

## Features
- ✅ Inventory Management API
- ✅ Time-based and Quantity-based Pricing
- ✅ Transaction-safe Sales Handling
- ✅ Audit Logging for Every Transaction

---

> **Note:**  
> If you are using **XAMPP**, please update the paths in your `public/index.php` and `.htaccess` files accordingly.  
> You may need to add `/..` in the URLs inside `index.php` to correctly reference resources, due to how XAMPP handles the document root.  
> For example, change references like `require __DIR__.'/../vendor/autoload.php';` if needed, depending on your setup.

---

## Installation

```bash
git clone https://github.com/ProfessorMoaz/inventory-module.git
cd inventory-module
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve