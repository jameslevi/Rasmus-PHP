<?php

namespace Raccoon\Util;

class Collection
{

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Dynamically attach object property from
     * array values.
     */

    public function __get(string $key)
    {
        if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }       
    }

    /**
     * Prevent overriding of dynamic object
     * properties.
     */

    public function __set(string $key, $value)
    {

    }

    /**
     * Return number of values.
     */

    public function size()
    {
        return sizeof($this->keys());
    }

    /**
     * Return collection keys.
     */

    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * Return collection array.
     */

    public function toArray()
    {
        return $this->data;
    }

    /**
     * Return json data.
     */

    public function toJson()
    {
        return json_encode($this->data);
    }

}