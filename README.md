\# IMS - Inventory Management System



A multi-tenant warehouse and logistics management platform built with Laravel 10. Designed for 3PL (Third-Party Logistics) providers, warehouses, and distribution centers managing multiple companies' products in a shared facility.



\## About This Project



IMS helps warehouse operators manage:

\- Multiple companies storing products in one warehouse

\- Product intake, storage locations (racks/floors), and inventory tracking

\- Order fulfillment with picker task assignments

\- Stock returns and restocking workflows

\- Delivery order processing with PDF invoices



\### Who Is This For?



\- \*\*Warehouse Operators\*\* - Manage inventory for multiple clients

\- \*\*3PL Providers\*\* - Track products across different companies

\- \*\*Distribution Centers\*\* - Handle order fulfillment and deliveries

\- \*\*Students/Developers\*\* - Learn Laravel with a real-world project



\## Features



\### Multi-Role Access Control

|

&nbsp;Role 

|

&nbsp;Access Level 

|

|

------

|

--------------

|

|

\*\*

Admin

\*\*

|

&nbsp;Full system access - manage users, companies, products, reports 

|

|

\*\*

Warehouse Staff

\*\*

|

&nbsp;Picker tasks, product handling, warehouse operations 

|

|

\*\*

Company/Customer

\*\*

|

&nbsp;View own products, request deliveries, track orders 

|



\### Core Modules



\- \*\*Product Management\*\* - Add products with dimensions, weights, carton quantities, and pricing

\- \*\*Warehouse Locations\*\* - Organize storage with rack and floor locations with capacity tracking

\- \*\*Delivery Orders\*\* - Create outbound deliveries with sender/receiver details and PDF invoices

\- \*\*Picker Tasks\*\* - Assign and track warehouse staff collecting products for orders

\- \*\*Return Stock\*\* - Process returns with reracking, refurbishing, or disposal options

\- \*\*Restock Requests\*\* - Companies can request additional inventory

\- \*\*Reporting\*\* - Weekly and monthly inventory movement reports



\### Workflow Overview





Company submits product request

↓

Admin approves \& assigns rack/floor location

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





\## Tech Stack



| Layer | Technology |

|-------|------------|

| Backend | Laravel 10 (PHP 8.1+) |

| Frontend | Blade Templates, Bootstrap 5 |

| Database | MySQL |

| Build Tool | Vite |

| PDF Generation | DomPDF, Snappy |

| Authentication | Laravel Sanctum |



\## Requirements



\- PHP >= 8.1

\- Composer

\- Node.js \& NPM

\- MySQL

\- XAMPP/WAMP/MAMP (or standalone MySQL server)



\## Quick Start



```bash

\# Clone repository

git clone https://github.com/syafiqaiman/ims.git

cd ims



\# Install dependencies

composer install



\# Setup environment

cp .env.example .env        # Linux/Mac

copy .env.example .env      # Windows



\# Generate app key

php artisan key:generate



\# Configure database in .env file, then:

php artisan migrate



\# Start server

php artisan serve



Visit: http://localhost:8000



Creating an Admin User

php artisan tinker



App\\Models\\User::create(\[

&nbsp;   'name' => 'Admin',

&nbsp;   'email' => 'admin@test.com',

&nbsp;   'password' => bcrypt('password'),

&nbsp;   'role' => 1

]);



Type exit to leave tinker.



Login credentials:



Email: admin@test.com

Password: password

User Roles

Role	Value	Description

Admin	1	Full system access

Warehouse Staff	2	Picker tasks, warehouse operations

Company/Customer	3	Own products, delivery requests

Initial Setup (After First Login)

Add Companies - Create company profiles for your clients

Add Rack/Floor Locations - Set up warehouse storage locations via phpMyAdmin or tinker:

DB::table('rack\_locations')->insert(\['location\_code' => 'RACK-A1', 'capacity' => 1000, 'occupied' => 0]);

DB::table('floor\_locations')->insert(\['location\_codes' => 'FLOOR-1', 'capacity' => 5000, 'occupied' => 0]);



Approve Product Requests - Review and assign locations to incoming products

Troubleshooting

Database Connection Error

Ensure MySQL is running (check XAMPP control panel)

Verify credentials in .env file

Missing PHP Extensions

Required: pdo\_mysql, mysqli, mbstring, xml, curl, zip, fileinfo



Clear All Caches

php artisan config:clear

php artisan cache:clear

php artisan view:clear



License

This project is open-sourced under the MIT License.



Acknowledgments

Built with Laravel

UI powered by AdminLTE / Bootstrap 5

