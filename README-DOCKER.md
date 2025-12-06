# Docker Setup Guide - Laravel Tool App

Complete guide for running the Laravel Tool App using Docker.

## Prerequisites

- Docker Engine 20.10 or higher
- Docker Compose v2.0 or higher

## Quick Start

### 1. Start the Application

```bash
# Build and start all containers
docker compose up -d

# View logs
docker compose logs -f app
```

### 2. Access the Application

- **Laravel App**: http://localhost:8002
- **phpMyAdmin**: http://localhost:8080
  - Username: `toolapp_user` (or value from .env)
  - Password: `user_password` (or value from .env)

### 3. Stop the Application

```bash
# Stop containers
docker compose down

# Stop and remove volumes (WARNING: This deletes database data)
docker compose down -v
```

## Available Services

| Service | Port | Description |
|---------|------|-------------|
| app | 8002 | Laravel application |
| mysql | 3306 | MySQL 8.0 database |
| phpmyadmin | 8080 | Database management tool |

## Common Commands

### Container Management

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# Restart containers
docker compose restart

# View container status
docker compose ps

# View logs
docker compose logs -f
docker compose logs -f app
docker compose logs -f mysql
```

### Laravel Commands

```bash
# Run artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:list

# Run composer
docker compose exec app composer install
docker compose exec app composer update

# Run npm
docker compose exec app npm install
docker compose exec app npm run build
docker compose exec app npm run dev
```

### Database Commands

```bash
# Access MySQL CLI
docker compose exec mysql mysql -u toolapp_user -p

# Backup database
docker compose exec mysql mysqldump -u toolapp_user -p toolapp > backup.sql

# Restore database
docker compose exec -T mysql mysql -u toolapp_user -p toolapp < backup.sql

# Check database connection
docker compose exec app php artisan migrate:status
```

## Environment Configuration

The application uses environment variables from `.env` file. Key variables for Docker:

```env
# Database Configuration (must match docker-compose.yml)
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=toolapp
DB_USERNAME=toolapp_user
DB_PASSWORD=user_password
DB_ROOT_PASSWORD=root_password

# Application
APP_URL=http://localhost:8002
```

## Rebuilding Containers

If you make changes to `Dockerfile` or dependencies:

```bash
# Rebuild without cache
docker compose build --no-cache

# Rebuild and start
docker compose up -d --build
```

## Troubleshooting

### Container won't start

```bash
# Check logs
docker compose logs app

# Check all container status
docker compose ps -a
```

### Database connection errors

```bash
# Verify MySQL is running
docker compose ps mysql

# Check MySQL health
docker compose exec mysql mysqladmin ping -h localhost -u root -p

# Restart MySQL
docker compose restart mysql
```

### Permission errors

```bash
# Fix storage permissions
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

### Clear all caches

```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

### Reset everything (WARNING: Deletes all data)

```bash
# Stop and remove all containers and volumes
docker compose down -v

# Remove images
docker compose down --rmi all

# Start fresh
docker compose up -d --build
```

## Development Workflow

### Making Code Changes

Code changes are automatically reflected because of volume mounting. No restart needed for most changes.

### Installing New Dependencies

```bash
# PHP dependencies
docker compose exec app composer require package/name

# JavaScript dependencies
docker compose exec app npm install package-name

# Rebuild assets
docker compose exec app npm run build
```

### Database Migrations

```bash
# Create migration
docker compose exec app php artisan make:migration create_table_name

# Run migrations
docker compose exec app php artisan migrate

# Rollback
docker compose exec app php artisan migrate:rollback
```

## Production Deployment

For production, modify `docker-compose.yml`:

1. Change `APP_ENV=production` in environment
2. Set `APP_DEBUG=false`
3. Use strong passwords
4. Remove phpMyAdmin service
5. Use proper reverse proxy (nginx/traefik)
6. Set up SSL/TLS certificates

## Additional Resources

- [Docker Documentation](https://docs.docker.com/)
- [Laravel Documentation](https://laravel.com/docs)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

## Important Notes

⚠️ **Use `docker compose` (with space) not `docker-compose` (with hyphen)**

The old `docker-compose` command is deprecated and may not work with newer systems.
