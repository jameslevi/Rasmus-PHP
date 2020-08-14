<?php

namespace Raccoon\UI;

class Color
{
    private static $colors = [];

    /**
     * Store color id.
     */

    private $id;

    /**
     * Store color data.
     */

    private $data = [

        'default' => null,

        'hover' => null,

        'active' => null,

    ];

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Return color id.
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set color data.
     */

    private function color(int $R, int $G, int $B, int $A = null)
    {
        return [

            'R' => $R,

            'G' => $G,

            'B' => $B,

            'A' => $A,

        ];
    }

    /**
     * Return color data.
     */

    public function data()
    {
        return $this->data;
    }

    /**
     * Set default color.
     */

    public function default(int $R, int $G, int $B, int $A = null)
    {
        $this->data['default'] = $this->color($R, $G, $B, $A);
        return $this;
    }

    /**
     * Set hover color.
     */

    public function hover(int $R, int $G, int $B, int $A = null)
    {
        $this->data['hover'] = $this->color($R, $G, $B, $A);
        return $this;
    }

    /**
     * Set active color. 
     */

    public function active(int $R, int $G, int $B, int $A = null)
    {
        $this->data['active'] = $this->color($R, $G, $B, $A);
        return $this;   
    }

    /**
     * Instantiate color object and set color id.
     */

    public static function id(string $id)
    {
        $instance = new self($id);
        static::$colors[] = $instance;

        return $instance;
    }

    /**
     * Return list of colors.
     */

    public static function getColors()
    {
        return static::$colors;
    }

    /**
     * If no color registered.
     */

    public static function empty()
    {
        return sizeof(static::getColors()) === 0;
    }

    /**
     * Clear colors array value.
     */

    public static function clear()
    {
        static::$colors = [];
    }

}