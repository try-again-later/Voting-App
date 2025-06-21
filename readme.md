# Voting App

## Credentials:

__Regular user__ (can delete their own ideas and change their ideas within one hour after they've created the idea):

- Email: `someone@example.com`
- Password: `123123123`

__Admin user__ (can change ideas' statuses and delete any ideas):

- Email: `admin@example.com`
- Password: `123123123`

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
