<p align="center"><img src="./resources/assets/img/api.png"></p>

## Overview
API for project [Tiler](https://github.com/DAMAGEx1/tiler) base on [Laravel 5.5](https://laravel.com/).

## Requirements
- [PHP 7.0+](http://php.net/)
- [MySQL 5.6](https://dev.mysql.com/downloads/mysql/5.6.html)
- [Composer](https://getcomposer.org/)

## Getting started
- [Configuration Laravel](https://laravel.com/docs/5.4/installation#configuration)
- Generate key for [Laravel Passport](https://laravel.com/docs/5.5/passport) `php artisan passport:keys`
- [Install](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) php dependencies `composer install`
- Create databases, default names is `tiler` - required, `tiler_test` - for using tests
- [Run migration](https://laravel.com/docs/5.4/migrations#running-migrations) `php artisan migrate`
- You can use [Seed](https://laravel.com/docs/5.5/seeding#running-seeders) but is not required `php artisan db:seed`
- [Install](https://docs.npmjs.com/cli/install) js/css dependencies  `npm install`
- [Run script](https://docs.npmjs.com/cli/run-script) `npm run production` or `npm run dev`
- Read [API docs](api.tiler/docs) `api.tiler/docs`

## Default data
> Login: `admin@gmail.com`

> Password: `admin`

## Social authorization
###### Available social networks - keys
* Google - `google`
###### Guide
- Make redirect to url `/socialite/{key}?auth_url={your_callback_page_for_token}&registration_url={your_callback_page_for_user_data}`
- After all redirects and authorization in social network, browser return to your callback page with parameters 
- If exists `token` use it in `Authorization` header
- If `token` not exists, use other params like `email`, `name` for registration

## Additional API parameters
All params use in `GET` api, like [url parameters](https://en.wikipedia.org/wiki/Query_string#Structure)
- `relations` - some API by default return relations, you can disable it with `relations=0` flag
- `size` - use it flag in api with pagination to set items to per page count