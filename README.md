## Implementing Laravel Multi-Tenancy
Simple implementation laravel tenancy with isolated databases.

## Prerequisites
- `php8+`
- `mysql8+`
- `node version 16 up`

## Technologies Used
- [Laravel@10.48.7]()
- [Vue@3.2.7]()
- [vue-tailwind@2.5.1]()
- [tailwindcss@^3.4.3]()

## Packages used in backend

- [spatie/laravel-medialibrary@^11.4]()
- [spatie/laravel-query-builder@^5.8]()
- [stancl/tenancy]()
- [ext-intl]()

## To Setup
- `cp .env.example .env`
- `php artisan key:generate`
- `composer i or composer install`
- `php artisan migrate:fresh`
- `npm i or npm install`
- `npm run dev`
- Update `.env` APP_DOMAIN to what you're using
- Update `.env` DB_ configurations

## To setup tenancy
- `php artisan tenancy:install`
- `php artisan app:create-tenant {domain} {admin-email?} {admin-password?}`
- First argument is for domain name to be used
- Second argument is for admin username
- Third argument is for admin password
- The command above creates a tenant with admin account to be used during login

## When using custom local domain
- You need to make sure the custom domain is included in
- `config/tenancy.php > ln:19 central_domains`

## When creating a user for landlord
- just run `php artisan main:create-user {username} {password?}`
- this command will help you create a master user where you can add tenants
