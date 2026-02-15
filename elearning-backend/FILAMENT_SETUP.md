# Filament Admin Setup Guide

## Overview
Your project is now configured with **Filament v3** admin panel! The Filament admin panel will be accessible on port **1880**.

## Setup Instructions

### 1. Start Docker Containers
From the `elearning-backend` directory, run:
```bash
docker-compose up -d
```

### 2. Running Migrations and Seeders
Once the containers are running, execute:

**Install dependencies (if needed):**
```bash
docker-compose exec app composer install
```

**Run migrations:**
```bash
docker-compose exec app php artisan migrate
```

**Seed the database with admin user:**
```bash
docker-compose exec app php artisan db:seed
```

### 3. Access the Admin Panel
- **URL:** http://localhost:1880/admin
- **Email:** admin@admin.com
- **Password:** admin123

## Features Available

### User Management
The User resource is already created and allows you to:
- ✅ View all users in a data table
- ✅ Create new users with validation
- ✅ Edit existing user details
- ✅ Delete users
- ✅ Search and filter users

## File Structure
```
app/Filament/
├── Panels/
│   └── AdminPanelProvider.php          # Main admin panel configuration
└── Resources/
    └── UserResource/
        ├── UserResource.php             # User resource definition
        └── Pages/
            ├── ListUsers.php            # User listing page
            ├── CreateUser.php           # Create user page
            └── EditUser.php             # Edit user page

database/seeders/
└── DatabaseSeeder.php                  # Creates admin user on seed
```

## Creating Additional Resources

To add more resources (e.g., Products, Categories, etc.), you'll want to:

1. **Create a new model** (if you haven't already):
   ```bash
   docker-compose exec app php artisan make:model Product
   ```

2. **Create a migration** (if needed):
   ```bash
   docker-compose exec app php artisan make:migration create_products_table
   ```

3. **Create a Filament resource** (once in Docker/with PHP available):
   ```bash
   docker-compose exec app php artisan make:filament-resource Product
   ```

## Useful Commands

```bash
# Create a new resource
docker-compose exec app php artisan make:filament-resource NameOfResource

# Run migrations
docker-compose exec app php artisan migrate

# Seed the database
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan cache:clear

# View logs
docker-compose logs -f app
```

## Admin Features

- 🎨 Modern dashboard with widgets
- 👤 User account management
- 🔐 Authentication required
- 📱 Responsive design
- 🔍 Built-in search and filtering
- 🎯 Bulk actions support
- 📊 Beautiful data tables

## Notes
- The admin panel is protected by authentication middleware
- Passwords are automatically hashed when created/updated
- The database connection details are in `.env`
- Default database: `elearning` on `mysql` container

## Support & Documentation
For more information about Filament, visit: https://filamentphp.com/docs
