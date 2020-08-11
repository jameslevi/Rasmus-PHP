<?php

namespace Rasmus\Database;

use Rasmus\Util\Str;

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

    /**
     * Check if field value is less than input value.
     */

    private function lessThanFactory(string $name, bool $or, $value)
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
                    $build .= $name . " < '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . ' < ' . DB::sanitize($item) . ' ';
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
            $build .= $name . ' < ' . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " < '" . DB::sanitize($value) . "'";
        }

        $this->data['where']['items'][] = $build . ' ';

        return $this;
    }

    /**
     * If field value is less than input value.
     */

    public function lessThan(string $name, $value)
    {
        return $this->lessThanFactory($name, false, $value);
    }

    /**
     * Check if field is less than input value.
     */

    public function orLessThan(string $name, $value)
    {
        return $this->lessThanFactory($name, true, $value);
    }

    /**
     * If field value is greater than the input value.
     */

    private function greaterThanFactory(string $name, bool $or, $value)
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
                    $build .= $name . " > '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . " > " . DB::sanitize($item) . " ";
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
            $build .= $name . " > " . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " > '" . DB::sanitize($value) . "'";
        }

        $this->data['where']['items'][] = $build . ' ';

        return $this;
    }

    /**
     * Check if field value is greater than input value.
     */

    public function greaterThan(string $name, $value)
    {
        return $this->greaterThanFactory($name, false, $value);
    }

    /**
     * Same with ->greaterThan() but using OR instead of AND operator.
     */

    public function orGreaterThan(string $name, $value)
    {
        return $this->greaterThanFactory($name, true, $value);
    }

    /**
     * Less than or equal input value.
     */

    private function lessThanEqualFactory(string $name, bool $or, $value)
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
                    $build .= $name . " <= '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . " <= " . DB::sanitize($item) . " ";
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
            $build .= $name . " <= " . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " <= '" . DB::sanitize($value) . "'";
        }

        $this->data['where']['items'][] = $build . ' ';

        return $this;
    }

    /**
     * Check if field value is less than or equal input value.
     */

    public function lessThanEqual(string $name, $value)
    {
        return $this->lessThanEqualFactory($name, false, $value);
    }

    /**
     * Append OR instead of AND when testing if field is less than or
     * equal the input value.
     */

    public function orLessThanEqual(string $name, $value)
    {
        return $this->lessThanEqualFactory($name, true, $value);
    }

    /**
     * Greater than or equal the input value.
     */

    private function greaterThanEqualFactory(string $name, bool $or, $value)
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
                    $build .= $name . " >= '" . DB::sanitize($item) . "' ";
                }
                else if(is_int($item) || is_bool($item))
                {
                    $build .= $name . " >= " . DB::sanitize($item) . " ";
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
            $build .= $name . " >= " . DB::sanitize($value);
        }
        else
        {
            $build .= $name . " >= '" . DB::sanitize($value) . "'";
        }

        $this->data['where']['items'][] = $build . ' ';

        return $this;
    }

    /**
     * Test if field value is greater than or equal input value.
     */

    public function greaterThanEqual(string $name, $value)
    {
        return $this->greaterThanEqualFactory($name, false, $value);
    }

    /**
     * Test if field value is greater than or equal input value but
     * append OR instead of AND.
     */

    public function orGreaterThanEqual(string $name, $value)
    {
        return $this->greaterThanEqualFactory($name, true, $value);
    }

}