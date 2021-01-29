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

use Hyperf\Cache\Driver\FileSystemDriver;

class FileSystemLock extends AbstractLock
{
    /**
     * The Redis factory implementation.
     *
     * @var FileSystemDriver
     */
    protected $store;

    /**
     * Create a new lock instance.
     *
     * @param string $name
     * @param int $seconds
     * @param null|string $owner
     */
    public function __construct(FileSystemDriver $store, $name, $seconds, $owner = null)
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
        $this->store->delete($this->name);
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
