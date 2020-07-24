<?php

namespace Rasmus\File;

class Json
{

    /**
     * File location.
     */

    private $file;

    /**
     * Store file reader object.
     */

    private $reader;

    /**
     * Store json data.
     */

    private $data;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->reader = new Reader($file);
    
        if($this->reader->exist() && $this->reader->readable() && $this->reader->type() === 'json')
        {
            $this->data = json_decode($this->reader->contents(), true);
        }       
    }

    /**
     * If has empty data.
     */

    public function empty()
    {
        return is_null($this->data);
    }

    /**
     * Return location.
     */

    public function location()
    {
        return $this->file;
    }

    /**
     * Return array of json data.
     */

    public function get()
    {
        return $this->data;
    }

    /**
     * Return array keys.
     */

    public function keys()
    {
        return array_keys($this->data);
    }

}