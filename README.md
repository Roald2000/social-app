<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# A Simple laravel app

# Make Sure you have this installed

- [Node JS](https://nodejs.org/en)
- [Composer](https://getcomposer.org/)

## Inside the app directory

- Run this commands in the terminal
  - npm install -- for installing dependencies
    - after that run ``npm run dev``
  - composer require -- for installing laravel dev dependencies
    - make sure you have a mysql server running. see the .env file for configurations
    - then run the migrations ``php artisan migrate``
    - after that run php artisan serve
