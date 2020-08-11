<?php

namespace Raccoon\Resource\Lang;

class Locale extends Translations
{

    /**
     * Store locale instances.
     */

    private static $locales = [];

    /**
     * Locale id.
     */

    private $id;

    /**
     * Translation data.
     */

    private $data = [];

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Dynamically call translation method.
     */

    public function __call(string $key, $value)
    {
        if(array_key_exists($key, $this->languages))
        {
            $this->data[$key] = $value[0];
            return $this;
        }
    }

    /**
     * Return locale id.
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Return translation data.
     */

    public function getData()
    {
        return $this->data;
    }

    /**
     * Locale instance factory.
     */

    public static function id(string $id)
    {
        $instance = new self($id);
    
        if(!array_key_exists($id, static::$locales))
        {
            static::$locales[$id] = $instance;
        }       

        return $instance;
    }

    /**
     * Return all registered locales.
     */

    public static function getLocales()
    {
        return static::$locales;
    }

    /**
     * Return true if no locale is registered.
     */

    public static function empty()
    {
        return sizeof(static::$locales) === 0;
    }

    /**
     * Delete all registered locales.
     */

    public static function clear()
    {
        static::$locales = [];
    }

}