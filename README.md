# Laravel Event Store

[![Latest Version on Packagist](https://img.shields.io/packagist/v/antwerpes/laravel-event-store.svg?style=flat-square)](https://packagist.org/packages/antwerpes/laravel-event-store)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/antwerpes/laravel-event-store/lint.yml?branch=master)](https://github.com/antwerpes/laravel-event-store/actions?query=workflow%3Alint+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/antwerpes/laravel-event-store.svg?style=flat-square)](https://packagist.org/packages/antwerpes/laravel-event-store)

Simple store for tracking events (e.g. for Google Tag Manager) in Laravel. Fire events from anywhere in your 
application and later retrieve them in your frontend.

## Installation

You can install the package via composer:

```bash
composer require antwerpes/laravel-event-store
```

You must also add the middleware to your `web` group, at the end of the stack:

```php
protected $middlewareGroups = [
    'web' => [
        ...
        \Antwerpes\LaravelEventStore\Middleware\FlashEventStore::class,
    ],
];
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-event-store-config"
```

This is the contents of the published config file:

```php
return [
    'session_key' => '_eventStore',
];
```

## Usage

From anywhere in your application, you can fire events like this:

```php
use Antwerpes\LaravelEventStore\Facades\EventStore;

EventStore::push('event-name');
// Or with additional data
EventStore::push('event-name', ['foo' => 'bar']);
```

Events that you don't retrieve during the current request cycle will be flashed to the session and made available
to the next request. That way, you can also fire events and retrieve them after a redirect.

```php
// This will work
EventStore::push('event-name');
return view('some-view');

// This will also work
EventStore::push('event-name');
return redirect()->route('some-route');
```

In your frontend, you can dump the events like this:

```php
{!! EventStore::dumpForGTM() !!}
```

which will output something like this:

```html
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'event': 'event-name',
        'foo': 'bar'
    });
</script>
```

In case you want to use a different variable name, you can pass it as a parameter:

```php
{!! EventStore::dumpForGTM('myDataLayer') !!}
```

You can also pull the events as an array and use them however you like:

```php
EventStore::pullEvents();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are welcome! Leave an issue on GitHub, or create a Pull Request.

## Credits

- [Elisha Witte](https://github.com/chiiya)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
