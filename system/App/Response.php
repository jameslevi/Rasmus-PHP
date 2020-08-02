<?php

namespace Rasmus\App;

class Response
{

    /**
     * Type of task controller must do after iteration.
     */

    private $type;

    /**
     * Data to return by controller.
     */

    private $data;

    public function __construct(string $type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Return response type.
     */

    public function type()
    {
        return $this->type;
    }

    /**
     * Return response data.
     */

    public function data()
    {
        return $this->data;
    }

}