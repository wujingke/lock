# Lock

[![Latest Stable Version](https://poser.pugx.org/friendsofhyperf/lock/version.png)](https://packagist.org/packages/friendsofhyperf/lock)
[![Total Downloads](https://poser.pugx.org/friendsofhyperf/lock/d/total.png)](https://packagist.org/packages/friendsofhyperf/lock)
[![GitHub license](https://img.shields.io/github/license/friendsofhyperf/lock)](https://github.com/friendsofhyperf/lock)

Lock component for hyperf. [中文说明](README_CN.md)

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

You may create and manage locks using the `LockFactory::make()` method:

```php
use FriendsOfHyperf\Lock\LockFactory;

$lock = LockFactory::make($name = 'foo', $seconds = 10, $owner = null);

if ($lock->get()) {
    // Lock acquired for 10 seconds...

    $lock->release();
}
```

`get` 方法也可以接收一个闭包。在闭包执行之后，将会自动释放锁：
The get method also accepts a closure. After the closure is executed, Will automatically release the lock:

```php
LockFactory::make('foo')->get(function () {
    // Lock acquired indefinitely and automatically released...
});
```

如果你在请求时锁无法使用，你可以控制等待指定的秒数。如果在指定的时间限制内无法获取锁，则会抛出 `FriendsOfHyperf\Lock\Exception\LockTimeoutException`

If the lock is not available at the moment you request it, you may instruct the lock to wait for a specified number of seconds. If the lock can not be acquired within the specified time limit, an `FriendsOfHyperf\Lock\Exception\LockTimeoutException` will be thrown:

```php
use FriendsOfHyperf\Lock\Exception\LockTimeoutException;
use FriendsOfHyperf\Lock\LockFactory;

$lock = LockFactory::make('foo', 10);

try {
    $lock->block(5);

    // Lock acquired after waiting maximum of 5 seconds...
} catch (LockTimeoutException $e) {
    // Unable to acquire lock...
} finally {
    optional($lock)->release();
}

LockFactory::make('foo', 10)->block(5, function () {
    // Lock acquired after waiting maximum of 5 seconds...
});
```
