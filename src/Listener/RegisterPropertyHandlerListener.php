<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Lock\Listener;

use FriendsOfHyperf\Lock\Annotation\Lock;
use FriendsOfHyperf\Lock\LockProxy;
use Hyperf\Di\Definition\PropertyHandlerManager;
use Hyperf\Di\ReflectionManager;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Utils\ApplicationContext;

class RegisterPropertyHandlerListener implements ListenerInterface
{
    /**
     * @return string[] returns the events that you want to listen
     */
    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * Handle the Event when the event is triggered, all listeners will
     * complete before the event is returned to the EventDispatcher.
     */
    public function process(object $event)
    {
        PropertyHandlerManager::register(Lock::class, function ($object, $currentClassName, $targetClassName, $property, $annotation) {
            if ($annotation instanceof Lock && ApplicationContext::hasContainer()) {
                $reflectionProperty = ReflectionManager::reflectProperty($currentClassName, $property);
                $reflectionProperty->setAccessible(true);

                $name = $annotation->name;
                $seconds = (int) $annotation->seconds;
                $owner = $annotation->owner;
                $driver = $annotation->driver;

                $reflectionProperty->setValue($object, new LockProxy($name, $seconds, $owner, $driver));
            }
        });
    }
}
