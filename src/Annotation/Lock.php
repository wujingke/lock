<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-lock.
 *
 * @link     https://github.com/friendsofhyperf/lock
 * @document https://github.com/friendsofhyperf/lock/blob/main/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Lock\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Lock extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $seconds = 0;

    /**
     * @var string
     */
    public $owner;

    /**
     * @var string
     */
    public $driver = 'default';

    public function __construct($value = null)
    {
        parent::__construct($value);
    }
}
