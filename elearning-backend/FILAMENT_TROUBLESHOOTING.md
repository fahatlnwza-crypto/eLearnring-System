# 🔧 Filament Troubleshooting Guide

## Common Issues & Solutions

### Issue 1: "Command not found: php artisan"
**Solution:** Make sure you're inside the Docker container or using `docker-compose exec app`:
```bash
# ✅ Correct
docker-compose exec app php artisan migrate

# ❌ Wrong
php artisan migrate  # (unless PHP is installed locally)
```

### Issue 2: "SQLSTATE[HY000]: General error: 1030 Got error..."
**Solution:** This usually means the database connection failed. Check:
```bash
# 1. Ensure MySQL container is running
docker-compose ps

# 2. Check database credentials in .env match docker-compose.yml
# DB_HOST=mysql
# DB_DATABASE=elearning
# DB_USERNAME=laravel
# DB_PASSWORD=password123

# 3. Try running migrations again
docker-compose exec app php artisan migrate
```

### Issue 3: "Class 'App\Filament\Panels\AdminPanelProvider' not found"
**Solution:** Make sure the file was created correctly:
```bash
# Check if the file exists
docker-compose exec app ls -la app/Filament/Panels/AdminPanelProvider.php

# Run this to regenerate the autoloader
docker-compose exec app composer dump-autoload
```

### Issue 4: "No application encryption key has been set"
**Solution:** The app needs an encryption key:
```bash
docker-compose exec app php artisan key:generate
```

### Issue 5: "Admin panel not accessible at localhost:1880/admin"
**Troubleshooting steps:**
```bash
# 1. Check if containers are running
docker-compose ps

# 2. Check Laravel is listening on port 8000 (mapped to 1880)
docker-compose logs app

# 3. Check routes were registered
docker-compose exec app php artisan route:list | grep admin

# 4. Clear Laravel cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:cache
```

### Issue 6: "Can't login with admin@admin.com"
**Solution:** Database might not be seeded:
```bash
# Run migrations first
docker-compose exec app php artisan migrate

# Then seed with admin user
docker-compose exec app php artisan db:seed
```

### Issue 7: "password: Class 'Illuminate\Support\Str' not found"
**Solution:** Update the EditUser.php file to use proper namespace:
```bash
# This would be handled automatically - just ensure you're using
# \Illuminate\Support\Str::isNotEmpty() or similar
```

## Verification Checklist

Before assuming something is broken, verify:

- [ ] Docker is installed and running
- [ ] All containers started: `docker-compose ps` (should show all ↑)
- [ ] Database migrated: `docker-compose exec app php artisan migrate:status`
- [ ] Admin user exists: `docker-compose exec app php artisan tinker` then `User::where('email', 'admin@admin.com')->first()`
- [ ] No PHP errors: `docker-compose logs app` (check for errors)
- [ ] Port 1880 is not in use: `netstat -ano | findstr :1880` (Windows)

## Debug Commands

```bash
# Check if admin panel provider is registered
docker-compose exec app php artisan config:show app.providers | grep AdminPanelProvider

# List all routes (search for /admin)
docker-compose exec app php artisan route:list | grep -i admin

# Check User model and database
docker-compose exec app php artisan tinker
>>> User::all()
>>> exit

# View application logs
docker-compose logs -f app

# Enter the container directly
docker-compose exec app bash

# Check file permissions
docker-compose exec app ls -la app/Filament/

# Manually run migrations with verbose output
docker-compose exec app php artisan migrate --verbose
```

## Reset Everything

If you need to start from scratch:

```bash
# Stop and remove all containers
docker-compose down

# Remove volumes (WARNING: deletes database)
docker-compose down -v

# Rebuild containers
docker-compose build

# Start fresh
docker-compose up -d

# Run migrations and seeds
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

## Docker Compose Not Found?

If `docker-compose` command doesn't work:

```bash
# Try the newer format
docker compose up -d

# Or install docker-compose
# Visit: https://docs.docker.com/compose/install/
```

## Still Having Issues?

### Check these files exist:
- [ ] `app/Filament/Panels/AdminPanelProvider.php`
- [ ] `app/Filament/Resources/UserResource.php`
- [ ] `app/Filament/Resources/UserResource/Pages/ListUsers.php`
- [ ] `app/Filament/Resources/UserResource/Pages/CreateUser.php`
- [ ] `app/Filament/Resources/UserResource/Pages/EditUser.php`
- [ ] `database/seeders/DatabaseSeeder.php`
- [ ] `config/auth.php`

### Check config/app.php includes:
```php
'providers' => [
    // ... other providers
    App\Filament\Panels\AdminPanelProvider::class,
],
```

### Run these diagnostic commands:
```bash
docker-compose exec app php artisan config:cache
docker-compose exec app composer dump-autoload
docker-compose exec app php artisan migrate:fresh --seed
```

## Getting Help

1. **Check Filament Docs:** https://filamentphp.com/docs
2. **GitHub Issues:** https://github.com/filamentphp/filament/issues
3. **Discord:** https://discord.gg/brooke-pc
4. **Stack Overflow:** Tag with `filament-php`

---

**Last Updated:** February 15, 2026
