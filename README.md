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

## Installation

```bash
git clone https://github.com/ProfessorMoaz/inventory-module.git
cd inventory-module
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
