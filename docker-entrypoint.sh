#!/bin/bash
set -e

echo "🚀 Starting Laravel application setup..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 10

# Check if .env exists, if not copy from .env.example
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Install/update composer dependencies
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --optimize-autoloader
fi

# Install/update npm dependencies
if [ ! -d "node_modules" ]; then
    echo "📦 Installing NPM dependencies..."
    npm install
fi

# Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

# Set proper permissions
echo "🔒 Setting proper permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run database migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Cache configuration (skip in development for better debugging)
if [ "${APP_ENV:-local}" != "local" ]; then
    echo "⚡ Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "⚡ Development mode - skipping cache optimization"
fi

echo "✅ Laravel application setup complete!"
echo "🌐 Application will be available at http://localhost:8002"

# Execute the main command
exec "$@"
