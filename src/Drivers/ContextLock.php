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

use Hyperf\Utils\Context;

class ContextLock extends AbstractLock
{
    public function __construct($name, $seconds, $owner = null, array $config = [])
    {
        parent::__construct($name, $seconds, $owner);
    }

    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire()
    {
        if (Context::has($this->name)) {
            return false;
        }

        Context::set($this->name, $this->owner);

        co(function () {
            sleep($this->seconds);
            Context::destroy($this->name);
        });

        return true;
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
        return Context::destroy($this->name);
    }

    /**
     * Returns the owner value written into the driver for this lock.
     *
     * @return string
     */
    protected function getCurrentOwner()
    {
        return Context::get($this->name);
    }
}
