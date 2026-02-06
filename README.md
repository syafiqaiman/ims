# IMS - Inventory Management System

A multi-tenant warehouse and logistics management platform built with Laravel 10. Designed for 3PL (Third-Party Logistics) providers, warehouses, and distribution centers managing multiple companies' products in a shared facility.

## About This Project

IMS helps warehouse operators manage:
- Multiple companies storing products in one warehouse
- Product intake, storage locations (racks/floors), and inventory tracking
- Order fulfillment with picker task assignments
- Stock returns and restocking workflows
- Delivery order processing with PDF invoices

## Features

- **Multi-Role Access Control** - Admin, Warehouse Staff, and Company/Customer roles
- **Product Management** - Add products with dimensions, weights, carton quantities
- **Warehouse Locations** - Rack and floor storage with capacity tracking
- **Delivery Orders** - Create deliveries with PDF invoices
- **Picker Tasks** - Assign and track warehouse staff
- **Return Stock** - Process returns with reracking or disposal
- **Reporting** - Weekly and monthly inventory reports

## Tech Stack

- Laravel 10 (PHP 8.1+)
- Blade Templates, Bootstrap 5
- MySQL
- Vite, DomPDF

## Quick Start

    git clone https://github.com/syafiqaiman/ims.git
    cd ims
    composer install
    copy .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan serve

Visit: http://localhost:8000

## Create Admin User

    php artisan tinker
    App\Models\User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'role' => 1]);

## License

MIT License
