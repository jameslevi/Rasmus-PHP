<?php

namespace Rasmus\Util;

class Arr
{
    /**
     * Test if array is multidimensional or not.
     */

    public static function multidimensional(array $array)
    {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }

}