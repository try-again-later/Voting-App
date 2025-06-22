# Voting App

## Данные для входа / Credentials

__Обычный пользователь__ (может оставлять комментарии, создавать и удалять (свои собственные) предложения, а также изменять их в течение одного часа после создания):

- Почта: `someone@example.com`
- Пароль: `123123123`

__Админ__ (может менять статусы предложений, а также удалять любые созданные предложения):

- Email: `admin@example.com`
- Password: `123123123`

---

__Regular user__ (can delete their own ideas and change their ideas within one hour after they've created the idea):

- Email: `someone@example.com`
- Password: `123123123`

__Admin user__ (can change ideas' statuses and delete any ideas):

- Email: `admin@example.com`
- Password: `123123123`

## Deploy for production

```sh
git clone https://github.com/try-again-later/Voting-App
cd Voting-App

cp .env.example .env
docker-compose -f ./compose.prod.yaml up -d --build

# When running for the first time:
docker-compose -f ./compose.prod.yaml exec voting-app-php-fpm php artisan key:generate
docker-compose -f ./compose.prod.yaml exec voting-app-php-fpm php artisan config:cache
docker-compose -f ./compose.prod.yaml exec voting-app-php-fpm php artisan db:seed
```

The app will be available at [localhost](http://localhost).

## Run locally for development

```sh
git clone https://github.com/try-again-later/Voting-App
cd Voting-App

# Copy the ".env" file.
# Set APP_DEBUG to "true", if needed.
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

# Start the app dev server:
php artisan serve --host=0.0.0.0
```

The app will be available at [localhost:8000](http://localhost:8000).

### Tooling

```sh
# Run tests with
php artisan test
# or
./vendor/bin/paratest

# Run linter with
./vendor/bin/phpstan

# Start the frontend HMR server with
npm run dev
```
