<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Lock;

use FriendsOfHyperf\Lock\Drivers\LockInterface;
use FriendsOfHyperf\Lock\Drivers\RedisLock;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Utils\ApplicationContext;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class LockFactory
{
    /**
     * Get a lock instance.
     *
     * @param string $name
     * @param int $seconds
     * @param null|string $owner
     * @param string $driver
     */
    public static function make($name, $seconds = 0, $owner = null, $driver = 'default'): LockInterface
    {
        $driver = $driver ?: 'default';
        /** @var ContainerInterface $container */
        $container = ApplicationContext::getContainer();
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);

        if (! $config->has("lock.{$driver}")) {
            throw new InvalidArgumentException(sprintf('The lock config %s is invalid.', $driver));
        }

        $driverClass = $config->get("lock.{$driver}.driver", RedisLock::class);
        $constructor = $config->get("lock.{$driver}.constructor", ['config' => []]);

        return make($driverClass, [
            'name' => $name,
            'seconds' => $seconds,
            'owner' => $owner,
            'constructor' => $constructor,
        ]);
    }
}
