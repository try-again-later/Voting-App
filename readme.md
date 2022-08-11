# Voting App

## Run locally

```sh
# Build frontend assets
npm i
npm run build

# Copy the .env file
cp .env.example .env

# Install backend dependencies
composer install

# Start the database service
docker-compose -f ./compose.dev.yaml up -d

# Migrate and seed the database
php artisan migrate
php artisan db:seed

# Start the app dev server
php artisan serve
```
