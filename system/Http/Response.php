<?php

namespace Raccoon\Http;

class Response
{

    /**
     * What type of http response to expect.
     */

    private $type;
    private $value;

    public function __construct(string $type, $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Return response type.
     */

    public function getType()
    {
        return $this->type;
    }

    /**
     * Return response data.
     */

    public function getData()
    {
        return $this->value;
    }

}