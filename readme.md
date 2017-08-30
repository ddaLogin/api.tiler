<p align="center"><img src="./resources/assets/img/api.png"></p>

## Overview
API for project [Tiler]() base on [Laravel 5.4](https://laravel.com/).

## Requirements
- [PHP 7.0+](http://php.net/)
- [MySQL 5.6](https://dev.mysql.com/downloads/mysql/5.6.html)
- [Composer](https://getcomposer.org/)

## Getting started
- [Configuration Laravel](https://laravel.com/docs/5.4/installation#configuration)
- [Install](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) php dependencies `composer install`
- Create database, default db name is `tiler`
- [Run migration](https://laravel.com/docs/5.4/migrations#running-migrations) `php artisan migrate`
- Create symbolic link to upload images `php artisan storage:link`
- Read [API docs](api.tiler/docs) `api.tiler/docs/index.html`

## Default data
> Login: `admin@gmail.com`

> Password: `admin`

#### Authorization
- Send your `login` and `password` to auth api
- Save `token` from api response
- Attach your `token` to all next requests in `Authorization` header
- Example - `Authorization: Bearer your_token_here`

#### Swagger Authorization
- Make auth request
- Copy `token` from response
- In `Authorization` modal window paste string `Bearer your_token_here`