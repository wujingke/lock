<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Lock\Drivers;

use Hyperf\Cache\Driver\CoroutineMemoryDriver;

class CoroutineMemoryLock extends AbstractLock
{
    /**
     * @var CoroutineMemoryDriver
     */
    protected $store;

    public function __construct($name, $seconds, $owner = null, array $config = [])
    {
        parent::__construct($name, $seconds, $owner);

        $this->store = make(CoroutineMemoryDriver::class, ['config' => $config]);
    }

    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire()
    {
        if ($this->store->has($this->name)) {
            return false;
        }

        return $this->store->set($this->name, $this->owner, $this->seconds) == true;
    }

    /**
     * Release the lock.
     *
     * @return bool
     */
    public function release()
    {
        return $this->forceRelease();
    }

    /**
     * Releases this lock in disregard of ownership.
     */
    public function forceRelease()
    {
        return $this->store->delete($this->name);
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
