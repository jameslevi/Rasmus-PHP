<?php

namespace Raccoon\Route;

use Raccoon\Util\Collection;

class Param
{
    /**
     * Store parameter data.
     */

    private $data = [

        'type' => null,

        'name' => null,

        'optional' => false,

        'method' => null,

        'default' => null,

    ];

    private function __construct(string $type, string $name)
    {
        $this->data['type'] = $type;
        $this->data['name'] = $name;
    }

    /**
     * Set request method to get.
     */

    public function get()
    {
        $this->data['method'] = 'get';
        return $this;
    }

    /**
     * Set request method to post.
     */

    public function post()
    {
        $this->data['method'] = 'post';
        return $this;
    }

    /**
     * Set paramater as optional.
     */

    public function optional()
    {
        $this->data['optional'] = true;
        return $this;
    }

    /**
     * Set default value if null or empty.
     */

    public function default($value)
    {
        $this->data['default'] = $value;
        return $this;
    }

    /**
     * Return parameter data.
     */

    public function getData()
    {
        return new Collection($this->data);
    }

    /**
     * Set dynamic form type.
     */

    public static function __callStatic(string $type, $arguments)
    {
        $name = $arguments[0] ?? 'text';

        return new self($type, $name);
    }

}