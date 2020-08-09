<?php

namespace Rasmus\Database;

use Rasmus\Util\String\Str;

abstract class WhereBuilder
{
    /**
     * Test if field value is equal with value.
     */
    
    private function equalFactory(string $name, bool $or, $value)
    {
        $build = '';

        if(!$or)
        {
            $build .= 'AND ';
        }
        else
        {
            $build .= 'OR ';
        }

        if(is_array($value))
        {
            $build .= '(';

            foreach($value as $item)
            {
                if(is_string($item))
                {
                    $build .= $name . " = '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . " = " . DB::sanitize($item) . ' ';
                }

                $build .= 'OR ';
            }

            if(Str::endWith($build, 'OR '))
            {
                $build = Str::move($build, 0, 4);
            }

            $build .= ')';
        }
        else if(is_int($value) || is_bool($value))
        {
            $build .= $name . " = " . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " = '" . DB::sanitize($value) . "'";
        }
        
        $this->data['where']['items'][] = $build . ' ';
        
        return $this;
    }

    /**
     * Compare value to field values from the table.
     */

    public function equal(string $name, $value)
    {
        return $this->equalFactory($name, false, $value);
    }

    /**
     * Same with ->equal but use OR instead of AND.
     */

    public function orEqual(string $name, $value)
    {
        return $this->equalFactory($name, true, $value);
    }

    /**
     * Test if field value is not equal from the input value.
     */

    private function notEqualFactory(string $name, bool $or, $value)
    {
        $build = '';

        if(!$or)
        {
            $build .= 'AND ';    
        }
        else
        {
            $build .= 'OR ';
        }

        if(is_array($value))
        {
            $build .= '(';

            foreach($value as $item)
            {
                if(is_string($item))
                {
                    $build .= $name . " != '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . " != " . DB::sanitize($item) . ' ';
                }

                $build .= 'OR ';
            }

            if(Str::endWith($build, 'OR '))
            {
                $build = Str::move($build, 0, 4);
            }

            $build .= ')';
        }
        else if(is_int($value) || is_bool($value))
        {
            $build .= $name . ' != ' . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " != '" . DB::sanitize($value) . "'";
        }

        $this->data['where']['items'][] = $build . ' ';

        return $this;
    }

    /**
     * If field value is not equal with input value.
     */

    public function notEqual(string $name, $value)
    {
        return $this->notEqualFactory($name, false, $value);
    }

    /**
     * Same with ->notEqual() but using OR instead of AND.
     */

    public function orNotEqual(string $name, $value)
    {
        return $this->notEqualFactory($name, true, $value);
    }

}