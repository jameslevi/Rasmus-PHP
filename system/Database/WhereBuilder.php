<?php

namespace Rasmus\Database;

abstract class WhereBuilder
{
    /**
     * Test if field value is equal with value.
     */
    
    public function equal(string $name, $value)
    {
        
        return $this;
    }

}