# IMS - Inventory Management System

A multi-tenant warehouse and logistics management platform built with Laravel 10. Handles product inventory, order fulfillment, and warehouse operations across multiple companies.

## Features

- **Multi-Role User Management** - Admin, Warehouse Staff, and Company/Customer roles
- **Inventory Management** - Track products with quantities, dimensions, weights, and warehouse locations
- **Delivery Orders** - Create outbound deliveries with order tracking and PDF invoices
- **Picker Tasks** - Assign warehouse staff to collect products with status tracking
- **Return Stock** - Process returns with reracking, refurbishing, or disposal workflows
- **Restock Requests** - Companies can request additional inventory
- **Reporting** - Weekly and monthly reports showing inventory movements

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/syafiqaiman/ims.git
cd ims
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create environment file

```bash
# Linux/Mac
cp .env.example .env

# Windows
copy .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Configure database

Edit `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ims
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Create database and run migrations

Create a MySQL database named `ims`, then run:

```bash
php artisan migrate
```

### 7. Install frontend dependencies (optional)

```bash
npm install
npm run build
```

### 8. Start the development server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

## Creating an Admin User

```bash
php artisan tinker
```

Then run:

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

## User Roles

| Role | Value | Access |
|------|-------|--------|
| Admin | 1 | Full system access |
| Warehouse Staff | 2 | Picker tasks, warehouse operations |
| Company/Customer | 3 | Own products, delivery requests |

## Useful Commands

| Command | Description |
|---------|-------------|
| `php artisan serve` | Start development server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh` | Reset and re-run all migrations |
| `php artisan db:seed` | Seed database with test data |
| `php artisan tinker` | Interactive PHP shell |
| `php artisan route:list` | List all routes |
| `php artisan cache:clear` | Clear application cache |
| `npm run dev` | Start Vite dev server (hot reload) |
| `npm run build` | Build assets for production |

## Troubleshooting

### Database connection error
- Ensure MySQL is running
- Verify credentials in `.env` file

### Missing PHP extensions
Required extensions: `pdo_mysql`, `mysqli`, `mbstring`, `xml`, `curl`, `zip`, `fileinfo`

**Windows:** Edit `php.ini` and uncomment the extension lines
**Mac:** `brew install php` (includes most extensions)
**Linux:** `sudo apt install php-mysql php-mbstring php-xml php-curl php-zip`

### Permission issues (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### Clear all caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Tech Stack

- **Backend:** Laravel 10 (PHP 8.1+)
- **Frontend:** Blade templates, Bootstrap 5
- **Build Tool:** Vite
- **Database:** MySQL
- **PDF Generation:** DomPDF, Snappy

## License

MIT License
