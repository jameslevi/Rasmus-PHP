<?php

namespace Raccoon\Http;

class Emitter
{

    private static $emitted = [];

    /**
     * Add new emitted data.
     */

    public static function emit(string $name, $value)
    {
        static::$emitted[$name] = $value;
    }

    /**
     * Return emitted value.
     */

    public static function get(string $name)
    {
        return array_key_exists($name, static::$emitted) ? static::$emitted[$name] : null;
    }

    /**
     * Empty emitted data.
     */

    public static function clear()
    {
        static::$emitted = [];
    }

}