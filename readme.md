<p align="center"><img src="./resources/assets/img/api.png"></p>

## Overview
API for project [Tiler]() base on [Laravel 5.5](https://laravel.com/).

## Requirements
- [PHP 7.0+](http://php.net/)
- [MySQL 5.6](https://dev.mysql.com/downloads/mysql/5.6.html)
- [Composer](https://getcomposer.org/)

## Getting started
- [Configuration Laravel](https://laravel.com/docs/5.4/installation#configuration)
- [Install](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) php dependencies `composer install`
- Create databases, default names is `tiler` - required, `tiler_test` - for using tests
- [Run migration](https://laravel.com/docs/5.4/migrations#running-migrations) `php artisan migrate`
- Create symbolic link to upload images `php artisan storage:link`
- Read [API docs](api.tiler/docs) `api.tiler/docs/index.html`

## Default data
> Login: `admin@gmail.com`

> Password: `admin`

## Authorization
#### API authorization
- Send your `login` and `password` to auth api
- Save `token` from api response
- Attach your `token` to all next requests in `Authorization` header
- Example - `Authorization: Bearer your_token_here`

#### Swagger Authorization
- Make auth request
- Copy `token` from response
- In `Authorization` modal window paste string `Bearer your_token_here`

#### Social authorization 
###### Available social networks - keys
* Google - `google`
###### Guide
- Make redirect to url `/api/v1/auth/{key}?callback_url={your_callback_page}`
- After all redirects and authorization in social network, browser return to your callback page with token in url parameters
- Use it token in api authorization