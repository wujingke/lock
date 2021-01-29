# Lock

[![Latest Stable Version](https://poser.pugx.org/friendsofhyperf/lock/version.png)](https://packagist.org/packages/friendsofhyperf/lock)
[![Total Downloads](https://poser.pugx.org/friendsofhyperf/lock/d/total.png)](https://packagist.org/packages/friendsofhyperf/lock)
[![GitHub license](https://img.shields.io/github/license/friendsofhyperf/lock)](https://github.com/friendsofhyperf/lock)

Lock component for hyperf.

## Installation

- Request

```bash
composer require "friendsofhyperf/lock"
```

- Publish

```bash
php bin/hyperf.php vendor:publish friendsofhyperf/lock
```

## Usage

你可以使用 `Lock::make()` 方法来创建和管理锁：

```php
use FriendsOfHyperf\Lock\Lock;

$lock = Lock::make($name = 'foo', $seconds = 10, $owner = null);

if ($lock->get()) {
    // 获取锁定10秒...

    $lock->release();
}
```

`get` 方法也可以接收一个闭包。在闭包执行之后，将会自动释放锁：

```php
Lock::make('foo')->get(function () {
    // 获取无限期锁并自动释放...
});
```

如果你在请求时锁无法使用，你可以控制等待指定的秒数。如果在指定的时间限制内无法获取锁，则会抛出 `FriendsOfHyperf\Lock\Exception\LockTimeoutException`

```php
use FriendsOfHyperf\Lock\Exception\LockTimeoutException;
use FriendsOfHyperf\Lock\Lock;

$lock = Lock::make('foo', 10);

try {
    $lock->block(5);

    // 等待最多5秒后获取的锁...
} catch (LockTimeoutException $e) {
    // 无法获取锁...
} finally {
    optional($lock)->release();
}

Lock::make('foo', 10)->block(5, function () {
    // 等待最多5秒后获取的锁...
});
```
