# Taggers CMS Events Module

## Installation

First, you'll need to install the package via Composer:

```shell
composer require taggers/events
```

Then, update `config/app.php` by adding an entry for the service provider.

```php
'providers' => [
    // ...
    Taggers\Events\EventsServiceProvider::class,
];
```

Finally, from the command line again, publish the migrations:

```shell
php artisan vendor:publish
php artisan migrate
```