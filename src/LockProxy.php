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

/**
 * @method mixed get(callable $callback = null)
 * @method bool block(int $seconds, callable $callback = null)
 * @method bool release()
 * @method string owner()
 * @method void forceRelease()
 */
class LockProxy
{
    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param string $name
     * @param int $seconds
     * @param null|string $owner
     * @param string $driver
     */
    public function __construct(...$arguments)
    {
        $this->arguments = $arguments;
    }

    public function __call($name, $arguments)
    {
        return LockFactory::make(...$this->arguments)->{$name}(...$arguments);
    }
}
