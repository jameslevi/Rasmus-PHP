<?php

namespace Raccoon\Util;

class Arr
{
    /**
     * Sort array in descending order.
     */

    public static function desc(array $array, bool $byKey = false)
    {
        if($byKey)
        {
            krsort($array);
        }
        else
        {
            rsort($array);
        }
        return $array;
    }

    /**
     * Sort array in ascending order.
     */

    public static function asc(array $array, bool $byKey = false)
    {
        if($byKey)
        {
            ksort($array);
        }
        else
        {
            asort($array);
        }
        return $array;
    }

    /**
     * Test if array is multidimensional or not.
     */

    public static function multidimensional(array $array)
    {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }

    /**
     * Return last item in the array.
     */

    public static function last(array $array)
    {
        return $array[sizeof($array) - 1];
    }

}