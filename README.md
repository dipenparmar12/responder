# Extend Json response method in laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dipenparmar12/Responder.svg?style=flat-square)](https://packagist.org/packages/dipenparmar12/Responder)
[![Total Downloads](https://img.shields.io/packagist/dt/dipenparmar12/Responder.svg?style=flat-square)](https://packagist.org/packages/dipenparmar12/Responder)

## Installation

You can install the package via composer:

```bash
composer require dipenparmar12/responder
```

## Usage

Syntax for success response
> `response()->success( $message [, $data = null, $subStatus = 200, $finalStatus = 200])`

Syntax for error response
> `return response()->error( $message [, $data = null, $subStatus = 400, $finalStatus = 200])`


Example

> `return response()->success( 'data inserted', $data, 200, 200)`

```php
[
    'success' => true,
    'message' => "data inserted",
    'status' => 200,
    'path' => '/uri-segment',
    'results' => $your_data,
    'metadata' => [
        'auth_id' => 'loged_in_user_id or null',
        'url' => 'url'
    ]
]
```

> `return response()->error( 'error occured', request()->all(), 401, 500)`

```php
[
    'success' => false,
    'message' => "error occured",
    'status' => 401,
    'path' => '/uri-segment',
    'results' => $your_data,
    'metadata' => [
        'auth_id' => 'loged_in_user_id or null',
        'url' => 'url'
    ]
]
```
### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dipenparmar12@gmail.com instead of using the issue tracker.

## Credits

-   [Dipen Parmar](https://github.com/dipenparmar12)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
