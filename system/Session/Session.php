<?php

namespace Rasmus\Session;

use Rasmus\Util\Collection;

class Session
{

    /**
     * Name of session model.
     */

    private $name;

    private function __construct(string $name, array $data = [])
    {
        $this->name = $name;

        if(!$this->exist($name))
        {
            $_SESSION[$name] = [];
        
            if(!empty($data))
            {
                foreach($data as $key => $value)
                {
                    $this->add($key, $value);
                }
            }
        }
    }

    /**
     * If session model exist.
     */

    private function exist(string $name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Return session data.
     */

    private function data()
    {
        return $_SESSION[$this->name];
    }

    /**
     * Dynamically attach session data as properties.
     */

    public function __get(string $name)
    {
        if($this->has($name))
        {
            return $_SESSION[$this->name][$name];
        }
    }

    /**
     * Prevent overriding to session data.
     */

    public function __set(string $name, $value)
    {

    }

    /**
     * Return all session data.
     */

    public function all()
    {
        return new Collection($this->data());
    }
    
    /**
     * Return session data in array.
     */

    public function toArray()
    {
        return $this->all()->toArray();
    }

    /**
     * Return all session keys.
     */

    public function keys()
    {
        return array_keys($this->data());
    }

    /**
     * Return session model size.
     */

    public function size()
    {
        return sizeof($this->keys());
    }

    /**
     * If session model is empty.
     */

    public function empty()
    {
        return $this->size() === 0;
    }

    /**
     * Test if property exist.
     */

    public function has(string $name)
    {
        return array_key_exists($name, $this->data());
    }

    /**
     * Add new session data.
     */

    public function add(string $name, $value)
    {
        if(!$this->has($name))
        {
            $_SESSION[$this->name][$name] = $value;
        }
    }

    /**
     * Set session data value.
     */

    public function set(string $name, $value)
    {
        if($this->has($name))
        {
            $_SESSION[$this->name][$name] = $value;
        }
    }

    /**
     * Remove session data.
     */

    public function remove(string $name)
    {
        if($this->has($name))
        {
            unset($_SESSION[$this->name][$name]);
        }
    }

    /**
     * Delete session.
     */

    public function delete()
    {
        if($this->exist($this->name))
        {
            unset($_SESSION[$this->name]);
        }
    }

    /**
     * Make session model.
     */

    public static function make(string $name, array $data = [])
    {
        return new self($name, $data);
    }

    /**
     * Read session data.
     */

    public static function read(string $name)
    {
        $instance = new self($name);

        return $instance->all();
    }

    /**
     * Return session model instance.
     */

    public static function get(string $name)
    {
        if(isset($_SESSION[$name]))
        {
            return new self($name);
        }
    }

    /**
     * Reset all session data.
     */

    public static function destroy()
    {
        session_destroy();
    }

}