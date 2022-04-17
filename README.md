composer install
copy .env.example .env
php artisan key:generate
create database namely 'boarding'
php artisan migrate
php artisan db:seed
php artisan serve (if u want to run the app)
php artisan test (if u want to test the app)


