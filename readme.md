# Voting App

## Credentials

__Regular user__ (can delete their own ideas and change their ideas within one hour after they've created the idea):

- Email: `someone@example.com`
- Password: `123123123`

__Admin user__ (can change ideas' statuses and delete any ideas):

- Email: `admin@example.com`
- Password: `123123123`

## Run locally for development

```sh
# Copy the ".env" file:
cp .env.example .env

# Initialize the environment and get into the workspace container:
docker-compose -f ./compose.dev.yaml up -d
docker-compose -f ./compose.dev.yaml exec -it voting-app-workspace bash

# Install backend dependencies:
composer install

# Install frontend dependencies and build frontend assets:
npm i
npm run build

# Generate application key:
php artisan key:generate

# Migrate and seed the database:
php artisan migrate:fresh --seed

# Run tests with
php artisan test
# or
./vendor/bin/paratest

# Start the app dev server:
php artisan serve --host=0.0.0.0

# You can also start the frontend HMR server:
npm run dev
```

The app will be available at [localhost:8000](http://localhost:8000).
