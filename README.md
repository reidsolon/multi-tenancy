## Implementing Laravel Multi-Tenancy

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
- `php artisan app:create-tenant tenant-domain1 tenant-admin-email tenant-admin-password?`
- The command above creates a tenant with admin account to be used during login

## When using custom local domain
- You need to make sure the custom domain is included in
- `config/tenancy.php > ln:19 central_domains`
