<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
return [
    'default' => [
        'driver' => FriendsOfHyperf\Lock\driver\RedisLock::class,
    ],
    'co' => [
        'driver' => FriendsOfHyperf\Lock\driver\CoroutineMemoryLock::class,
    ],
    'file' => [
        'driver' => FriendsOfHyperf\Lock\driver\FileSystemLock::class,
    ],
    'cache' => [
        'driver' => FriendsOfHyperf\Lock\driver\CacheLock::class,
    ],
];
