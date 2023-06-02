<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements
- **[Docker - version  23.0.3](https://www.docker.com//)**
- **[Docker Compose - version v2.3.3](https://docs.docker.com/compose/)**

## Installation

### Run these steps for installation:
- Get a clone from repository:
```shell
git clone https://github.com/majid-seifi/simple-shop/
```
- Go inside the directory:
```shell
cd simple-shop
```
- If you have composer installed in your OS and all requirements are enabled, run:
```shell
composer install
```
- Otherwise, use install it with these commands:
```shell
docker compose up -d
docker exec simple_shop_laravel composer install
docker compose down
```
- Now, Sail is installed, up it with this:
```shell
./vendor/bin/sail up -d
```
- For install node packages run this command:
```shell
docker exec simple_shop_laravel yarn install
```
- Migrate the database:
```shell
./vendor/bin/sail artisan migrate
```
- Seed Data:
```shell
./vendor/bin/sail artisan db:seed
```
## Run
- For run front and see it in browser run this:
```shell
docker exec simple_shop_laravel yarn dev
```
- Then go to this address http://localhost:4000 in browser.
- If you want another port change APP_PORT in .env file and restart Sail.
- For login use these credentials:
#### Administrator:
- Email: admin@example.test
- Password: admin123
#### User(s):
- Email: user1@example.test
- Password: admin123
- There are 5 users which generated, and you can log in with them.(user1, user2, ...)

## Test
```shell
./vendor/bin/sail artisan test
```