# WrenchWorks Auto Repair Management

A Laravel application for managing an auto repair shop's customers, vehicles, mechanics, repair jobs, and parts.

## Requirements

- PHP 8.2 or newer
- Composer
- SQLite (default) or another database supported by Laravel

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

On Windows PowerShell, copy the environment template with:

```powershell
Copy-Item .env.example .env
```

The default database connection is SQLite. Laravel uses `database/database.sqlite`; create the file if it does not exist. To reset the database and load sample records, run `php artisan migrate:fresh --seed`.

## Application modules

The five project tables are:

1. `customers` — customer contact information.
2. `vehicles` — vehicles owned by customers.
3. `mechanics` — technicians and their specialties.
4. `repair_jobs` — repair work for a vehicle, assigned to a mechanic.
5. `parts` — parts and quantities used on a repair job.

The relationships are Customer → Vehicles → Repair Jobs → Parts, with Mechanics → Repair Jobs. Customer, vehicle, and mechanic records cannot be deleted while related repair history exists. Deleting a repair job also deletes its part line items.

Laravel's default infrastructure migrations may create framework support tables in addition to these five project tables.

## Features

- Dashboard with shop totals and recent repair activity.
- Create, read, update, and delete pages for all five modules.
- Server-side validation, unique vehicle plates/VINs and customer/mechanic emails, and foreign-key checks.
- Responsive Bootstrap 5 interface, success/error messages, and delete confirmations.
- Factories and related sample data through `php artisan db:seed`.

Run the automated tests with `php artisan test`.
