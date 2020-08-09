<?php

namespace Rasmus\Database;

abstract class WhereBuilder
{
    /**
     * Test if field value is equal with value.
     */
    
    public function equal(string $name, $value)
    {
        $build = '';

        if(is_array($value))
        {
            $build .= '(';

            foreach($value as $item)
            {
                if(is_string($item))
                {
                    $build .= $name . " = '" . DB::sanitize($item) . "'";
                }
                else
                {
                    $build .= $name . " = " . DB::sanitize($item);
                }
            }

            $build .= ')';
        }
        else if(is_int($value))
        {
            $build .= $name . " = " . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " = '" . DB::sanitize($value) . "'";
        }
        
        $this->data['where']['items'][] = $build;
        
        return $this;
    }

    public function notEqual()
    {

    }

}