# Ladmin - Easy Admin Panel for Laravel

Ladmin is a library designed to make it easy to create admin panels for Laravel applications.

## Features

* __CRUD Operations:__ With just a few lines of code added to your `routes/web.php` file, you can have a fully functional CRUD (Create, Read, Update, Delete) interface for your models. For example, to set up a CRUD for the User model, you can simply do:

```
use LowB\Ladmin\Route\Facades\LadminRoute;

LadminRoute::auth();
LadminRoute::dashboard();
LadminRoute::profile();
LadminRoute::crud(User::class);
```

* __Customizable Frontend:__ Ladmin is built with the aim of making it easy to customize the frontend of your admin panel. You can tailor the look and feel to match your application's branding and style.

## Installation
To get started with Ladmin, you can install it via Composer. Simply run the following command:
```
composer require lowb/ladmin
```
