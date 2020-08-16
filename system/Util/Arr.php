<?php

namespace Raccoon\Util;

class Arr
{
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