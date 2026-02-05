# IMS - Inventory Management System

A multi-tenant warehouse and logistics management platform built with Laravel 10. Designed for 3PL (Third-Party Logistics) providers, warehouses, and distribution centers managing multiple companies' products in a shared facility.

## About This Project

IMS helps warehouse operators manage:
- Multiple companies storing products in one warehouse
- Product intake, storage locations (racks/floors), and inventory tracking
- Order fulfillment with picker task assignments
- Stock returns and restocking workflows
- Delivery order processing with PDF invoices

### Who Is This For?

- **Warehouse Operators** - Manage inventory for multiple clients
- **3PL Providers** - Track products across different companies
- **Distribution Centers** - Handle order fulfillment and deliveries
- **Students/Developers** - Learn Laravel with a real-world project

## Features

### Multi-Role Access Control
| Role | Access Level |
|------|--------------|
| **Admin** | Full system access - manage users, companies, products, reports |
| **Warehouse Staff** | Picker tasks, product handling, warehouse operations |
| **Company/Customer** | View own products, request deliveries, track orders |

### Core Modules

- **Product Management** - Add products with dimensions, weights, carton quantities, and pricing
- **Warehouse Locations** - Organize storage with rack and floor locations with capacity tracking
- **Delivery Orders** - Create outbound deliveries with sender/receiver details and PDF invoices
- **Picker Tasks** - Assign and track warehouse staff collecting products for orders
- **Return Stock** - Process returns with reracking, refurbishing, or disposal options
- **Restock Requests** - Companies can request additional inventory
- **Reporting** - Weekly and monthly inventory movement reports

### Workflow Overview

```
Company submits product request
        ↓
Admin approves & assigns rack/floor location
        ↓
Product added to inventory
        ↓
Company creates delivery order
        ↓
Admin assigns picker tasks
        ↓
Warehouse staff collects items
        ↓
Order fulfilled, invoice generated
```

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 10 (PHP 8.1+) |
| Frontend | Blade Templates, Bootstrap 5 |
| Database | MySQL |
| Build Tool | Vite |
| PDF Generation | DomPDF, Snappy |
| Authentication | Laravel Sanctum |

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL
- XAMPP/WAMP/MAMP (or standalone MySQL server)

## Quick Start

```bash
# Clone repository
git clone https://github.com/syafiqaiman/ims.git
cd ims

# Install dependencies
composer install

# Setup environment
cp .env.example .env        # Linux/Mac
copy .env.example .env      # Windows

# Generate app key
php artisan key:generate

# Configure database in .env file, then:
php artisan migrate

# Start server
php artisan serve
```

Visit: **http://localhost:8000**

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/syafiqaiman/ims.git
cd ims
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Create Environment File

```bash
# Linux/Mac
cp .env.example .env

# Windows
copy .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ims
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Create Database and Run Migrations

Create a MySQL database named `ims` (via phpMyAdmin or command line), then run:

```bash
php artisan migrate
```

### 7. Install Frontend Dependencies (Optional)

```bash
npm install
npm run build
```

### 8. Start the Development Server

```bash
php artisan serve
```

## Creating Users

### Create an Admin User

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => 1
]);
```

Type `exit` to leave tinker.

**Login credentials:**
- Email: admin@test.com
- Password: password

### User Roles

| Role | Value | Description |
|------|-------|-------------|
| Admin | 1 | Full system access |
| Warehouse Staff | 2 | Picker tasks, warehouse operations |
| Company/Customer | 3 | Own products, delivery requests |

## Initial Setup (After First Login)

1. **Add Companies** - Create company profiles for your clients
2. **Add Rack/Floor Locations** - Set up warehouse storage locations via phpMyAdmin or tinker:
   ```php
   DB::table('rack_locations')->insert(['location_code' => 'RACK-A1', 'capacity' => 1000, 'occupied' => 0]);
   DB::table('floor_locations')->insert(['location_codes' => 'FLOOR-1', 'capacity' => 5000, 'occupied' => 0]);
   ```
3. **Approve Product Requests** - Review and assign locations to incoming products

## Useful Commands

| Command | Description |
|---------|-------------|
| `php artisan serve` | Start development server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh` | Reset and re-run all migrations |
| `php artisan tinker` | Interactive PHP shell |
| `php artisan route:list` | List all routes |
| `php artisan cache:clear` | Clear application cache |
| `npm run dev` | Start Vite dev server (hot reload) |
| `npm run build` | Build assets for production |

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running (check XAMPP control panel)
- Verify credentials in `.env` file

### Missing PHP Extensions
Required: `pdo_mysql`, `mysqli`, `mbstring`, `xml`, `curl`, `zip`, `fileinfo`

**Windows:** Edit `php.ini` and uncomment the extension lines
**Mac:** `brew install php` (includes most extensions)
**Linux:** `sudo apt install php-mysql php-mbstring php-xml php-curl php-zip`

### Permission Issues (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Project Structure

```
ims/
├── app/
│   ├── Http/Controllers/backend/   # Main controllers
│   └── Models/                     # Eloquent models
├── database/migrations/            # Database schema
├── resources/views/backend/        # Blade templates
├── routes/web.php                  # Route definitions
└── public/                         # Public assets
```

## Contributing

Contributions are welcome! Feel free to:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced under the [MIT License](LICENSE).

## Acknowledgments

- Built with [Laravel](https://laravel.com/)
- UI powered by [AdminLTE](https://adminlte.io/) / Bootstrap 5
- PDF generation by [DomPDF](https://github.com/barryvdh/laravel-dompdf)
