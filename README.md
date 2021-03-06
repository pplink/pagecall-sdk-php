# PageCall SDK For PHP  <a href="https://travis-ci.org/pplink/pagecall-sdk-php"><img src="https://travis-ci.org/pplink/pagecall-sdk-php.svg" alt="Build Status"></a>

The `PageCall` SDK for PHP makes it easy for developers to access PageCall in their PHP code.

## Prerequisites

- PHP 7.0 or above
- PHP CURL extension
- Composer

## Installation

```
composer require pplink/pagecall 
```

## Quick Examples

### Create an PageCall Instance

```php
// change path as needed
require_once __DIR__ . '/vendor/autoload.php';

$pageCall = new \PageCall\PageCall([
    'accessKey' => 'test',
    'secretKey' => 'test'
]);
```

### Bring in a PageCall
```php
// change path as needed
require_once __DIR__ . '/vendor/autoload.php';

try {
    $pageCall = new \PageCall\PageCall([
        'accessKey' => 'test',
        'secretKey' => 'test'
    ]);

    $pca = $pageCall->connectIn([
        'userId' => $_POST['userId'],
        'publicRoomId' => $_POST['publicRoomId']
    ]);
    echo $pca['html'];
} catch (\PageCall\Exceptions\PageCallSDKException $e) {

} catch (\PageCall\Exceptions\PageCallAuthenticationException $e) {

}
```

## Support

Contact us `support@pplink.net`
