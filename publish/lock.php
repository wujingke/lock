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
        'driver' => FriendsOfHyperf\Lock\Drivers\RedisLock::class,
        'constructor' => [
            'pool' => 'default',
        ],
    ],
    'file' => [
        'driver' => FriendsOfHyperf\Lock\Drivers\FileSystemLock::class,
        'constructor' => [
            'config' => ['prefix' => 'lock:'],
        ],
    ],
    'database' => [
        'driver' => FriendsOfHyperf\Lock\Drivers\DatabaseLock::class,
        'constructor' => [
            'pool' => 'default',
            'table' => 'locks',
        ],
    ],
];
