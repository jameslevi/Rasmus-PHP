<?php

namespace Raccoon\UI;

class Scheme
{
    /**
     * Store list of schemes.
     */

    private static $schemes = [];

    /**
     * Scheme id.
     */

    private $id;
    private $colors = [];

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Return scheme id.
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set closure to call.
     */

    public function set($closure)
    {
        $closure();

        if(!Color::empty())
        {
            foreach(Color::getColors() as $color)
            {
                $this->colors[$color->getId()] = $color->data();
            }

            Color::clear();
        }
    }

    /**
     * Return colors.
     */

    public function colors()
    {
        return $this->colors;
    }

    /**
     * Instantiate scheme object and set id.
     */

    public static function id(string $id)
    {
        $instance = new self($id);
        static::$schemes[$id] = $instance;

        return $instance;
    }

    /**
     * Return list of schemes.
     */

    public static function get()
    {
        return static::$schemes;
    }

    /**
     * Return true if scheme array has no value.
     */

    public static function empty()
    {
        return sizeof(static::get()) === 0;
    }

}