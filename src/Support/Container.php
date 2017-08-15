<?php

namespace StephaneCoinon\IDrive\Support;

use League\Container\Container as DefaultContainer;

class Container
{
    /** @var League\Container\Container */
    protected static $container = null;

    public static function isBooted()
    {
        return ! is_null(static::$container);
    }

    /**
     * Get the underlaying container instance.
     *
     * @return League\Container\Container
     */
    public static function instance()
    {
        return static::$container;
    }

    /**
     * Boot container.
     *
     * By default the container is booted only if not already booted.
     *
     * @param  boolean $force if true, force boot even if already booted
     */
    public static function boot($force = false)
    {
        if ($force || is_null(static::$container)) {
            static::$container = new DefaultContainer;
        }
    }

    /**
     * Force container boot.
     */
    public static function forceBoot()
    {
        static::boot(true);
    }

    public static function destroy()
    {
        static::$container = null;
    }

    /**
     * Store a value in the container.
     *
     * @param string $key
     * @param mixed  $value
     */
    public static function add($key, $value)
    {
        static::$container->add($key, $value);
    }

    /**
     * Resolve a key out of the container.
     *
     * If the key is an existing class path and it is not in the container,
     * then a new instance of this class will be returned.
     *
     * @param  string $key
     * @param  array $args arguments to pass when a new instance is resolved
     * @return mixed
     * @throws League\Container\Exception\NotFoundException
     */
    public static function get($key, $args = [])
    {
        if (! static::$container->has($key) && class_exists($key)) {
            static::add($key, $key);
        }

        return static::$container->get($key, $args);
    }
}
