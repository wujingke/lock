<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Lock\driver;

use Hyperf\Redis\Redis;

class RedisLock extends AbstractLock
{
    /**
     * The Redis factory implementation.
     *
     * @var Redis
     */
    protected $store;

    /**
     * Create a new lock instance.
     *
     * @param string $name
     * @param int $seconds
     * @param null|string $owner
     */
    public function __construct(Redis $store, $name, $seconds, $owner = null)
    {
        parent::__construct($name, $seconds, $owner);

        $this->store = $store;
    }

    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire()
    {
        if ($this->seconds > 0) {
            return $this->store->set($this->name, $this->owner, ['NX', 'EX' => $this->seconds]) == true;
        }

        return $this->store->setnx($this->name, $this->owner) === 1;
    }

    /**
     * Release the lock.
     *
     * @return bool
     */
    public function release()
    {
        return (bool) $this->store->eval(LuaScripts::releaseLock(), 1, $this->name, $this->owner);
    }

    /**
     * Releases this lock in disregard of ownership.
     */
    public function forceRelease()
    {
        $this->store->del($this->name);
    }

    /**
     * Returns the owner value written into the driver for this lock.
     *
     * @return string
     */
    protected function getCurrentOwner()
    {
        return $this->store->get($this->name);
    }
}
