<?php

namespace Raccoon\Util;

class Str
{

    /**
     * Return the first character of string.
     */

    public static function first(string $string)
    {
        return substr($string, 0, 1);
    }

    /**
     * Return the last character of string.
     */

    public static function last(string $string)
    {
        return substr($string, strlen($string) - 1, strlen($string));
    }

    /**
     * Return true if string start with key.
     */

    public static function startWith(string $string, string $key)
    {
        return substr($string, 0, strlen($key)) === $key;
    }

    /**
     * Return true if string end with key.
     */

    public static function endWith(string $string, string $key)
    {
        return substr($string, strlen($string) - strlen($key), strlen($string)) === $key;
    }    

    /**
     * Move string index.
     */

    public static function move(string $string, int $start = 0, int $end = -1)
    {
        $length = strlen($string);
        if($end !== -1)
        {
            $length -= $end;
        }

        return substr($string, $start, $length);
    }    

    /**
     * Return position of first occurance of key in string.
     */

    public static function pos(string $string, string $key)
    {
        return strpos($string, $key);
    }

    /**
     * Test if string contains a specific key.
     */

    public static function has(string $string, string $key)
    {
        return static::pos($string, $key) !== false;       
    }

    /**
     * Test if string contains substring from array.
     */

    public static function contains(string $string, array $keys)
    {
        foreach($keys as $key)
        {
            if(static::has($string, $key))
            {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Split the string in two segments.
     */

    public static function break(string $string, string $key)
    {
        if(static::has($string, $key))
        {
            $first = substr($string, 0, static::pos($string, $key));
            $second = substr($string, static::pos($string, $key) + strlen($key), strlen($string));           
            
            return [
                $first,
                $second,
            ];
        }

        return [$string];
    }

    /**
     * Remove all white spaces, line breaks and carriage return.
     */

    public static function trim(string $string)
    {
        $string = str_replace(['\r', '\n'], ' ', $string);
        $string = preg_replace('!\s+!', ' ', $string);

        return trim($string);
    }

    /**
     * Count the number of words in string.
     */

    public static function wordCount(string $string)
    {
        $words = 0;
        $string = static::trim($string);
        $split = explode(' ', $string);

        foreach($split as $word)
        {
            if($word !== '')
            {
                $words++;
            }           
        }

        return $words;
    }

    /**
     * Count the number of lines in string.
     */

    public static function lineCount(string $string)
    {
        return substr_count($string, '\n') + 1;
    }

    /**
     * Count the number of occurance of numbers in string.
     */

    public static function numberCount(string $string)
    {
        return count(preg_grep('~^[0-9]$~', str_split($string)));
    }

    /**
     * Count the number of letters in string.
     */

    public static function letterCount(string $string)
    {
        $count = 0;
        $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $split = str_split(strtolower($string));
       
        foreach($split as $char)
        {
            if(in_array($char, $letters))
            {
                $count++;
            }           
        }       

        return $count;
    }

    /**
     * Count all uppercase letters in string.
     */

    public static function uppercaseCount(string $string)
    {
        return strlen(preg_replace('![^A-Z]+!', '', $string));
    }

    /**
     * Count all lowercase letters in string.
     */

    public static function lowercaseCount(string $string)
    {
        return strlen(preg_replace('![^a-z]+!', '', $string));
    }

    /**
     * Count all non letters and numbers in string.
     */

    public static function nonAlphaNumericCharacterCount(string $string)
    {
        return strlen($string) - (static::numberCount($string) + static::letterCount($string));
    }

}