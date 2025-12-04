<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Prerequisites
Make sure you have installed:
- PHP >= 8.1  
- Composer ([https://getcomposer.org](https://getcomposer.org))  
- MySQL (included in XAMPP/WAMP)
---

## Install Dependencies

```bash
composer install
```

## Configure Environment
```bash
cp .env.example .env
```

### Update .env with your database credentials
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

## Generate Application Key
```bash
php artisan key:generate
```

## Create Database
-Open phpMyAdmin: http://localhost/phpmyadmin
-Create a database matching DB_DATABASE in .env.

## Run Migrations and Seeders
```bash
php artisan migrate
php artisan db:seed   # optional
```