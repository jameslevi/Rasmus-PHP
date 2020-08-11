<?php

namespace Rasmus\Validation\Util;

use Rasmus\App\Config;
use Rasmus\Resource\Lang\Lang;
use Rasmus\Util\Str;

class PasswordStrength
{

    /**
     * Value to test.
     */

    private $value;

    /**
     * Testing score.
     */

    private $score = 0;

    /**
     * Return password strength message.
     */

    private $message;

    /**
     * Passing score.
     */

    private $passing = 70;

    /**
     * Minimum number of characters.
     */

    private $minLength = 8;

    /**
     * Minimum number of letters.
     */

    private $minLetter = 4;

    /**
     * Minimum number of digits.
     */

    private $minNumber = 2;

    /**
     * Minimum number of uppercase letters.
     */

    private $minUcase = 2;

    /**
     * Minimum number of lowercase letters.
     */

    private $minLcase = 2;

    public function __construct(string $value, int $passing)
    {
        $this->value = $value;
        $this->passing = $passing;
        $this->parseFormParameters();
        $this->test();
    }

    /**
     * Test password strength.
     */

    private function test()
    {
        $score = 0;
        $value = $this->value;
        $length = strlen($value);
        $min = $this->minLength;
        $chars = str_split($value);

        /**
         * Add bonus score by how long the
         * password value.
         */

        $score += $length;

        /**
         * Add score depending of password length.
         */

        if($length >= $min && $length < ($min + 4))
        {
            $score += 5;
        }
        else if($length >= ($min + 4) && $length < ($min + 8))
        {
            $score += 10;
        }
        else if($length >= ($min + 8) && $length < ($min + 12))
        {
            $score += 12;
        }
        else if($length >= ($min + 12) && $length < ($min + 15))
        {
            $score += 15;
        }
        else if($length >= ($min + 15) && $length < ($min + 18))
        {
            $score += 18;
        }
        else if($length >= ($min + 18) && $length < ($min + 20))
        {
            $score += 20;
        }
        else if($length >= ($min + 20) && $length < ($min + 24))
        {
            $score += 24;
        }

        /**
         * Add bonus if number of digit is greater than
         * the minimum.
         */

        if(Str::numberCount($value) > $this->minNumber)
        {
            $score += 5;
        }

        /**
         * Add bonus if number of letter is greater than
         * the minimum.
         */

        if(Str::letterCount($value) > $this->minLetter)
        {
            $score += 3;
        }

        /**
         * Add bonus if number of uppercase letter is greater
         * than the minimum.
         */

        if(Str::uppercaseCount($value) > $this->minUcase)
        {
            $score += 5;
        }

        /**
         * Add bonus if number of lowercase letter is greater
         * than the minimum.
         */

        if(Str::lowercaseCount($value) > $this->minLcase)
        {
            $score += 2;
        }

        /**
         * Multiply how many number by 3 then add to score.
         */

        $score += (Str::numberCount($value) * 3);

        /**
         * Multiply how many letter by 1 then add to score.
         */

        $score += (Str::letterCount($value) * 1);

        /**
         * Multiply how many uppercase letter by 4 then add to score.
         */

        $score += (Str::uppercaseCount($value) * 4);

        /**
         * Multiply how many lowercase letter by 2 then add to score.
         */

        $score += (Str::lowercaseCount($value) * 2);

        /**
         * Subtract how many times a character is repeated and multiply
         * it by two.
         */

        $stash = [];
        $n = 0;

        foreach($chars as $char)
        {
            if(!in_array($char, $stash))
            {
                $count = substr_count($value, $char);
                
                if($count > 1)
                {
                    $stash[] = $char;
                    $score -= $count;
                }
                else
                {
                    $n++;
                }
            }
        }

        /**
         * Subtract the difference between length and sizeof stash.
         */

        if($length != $n)
        {
            $score -= ($length - $n);
        }

        /**
         * If score is more than 100, set value to 100.
         */

        if($score > 100)
        {
            $score = 100;
        }

        /**
         * If score is less than the passing score, return
         * the error message.
         */

        if($score < $this->passing)
        {
            $this->message = Lang::get('validation::message.strength.weak', [

                'name' => 'Password',

            ]);
        }

        $this->score = $score;
    }

    /**
     * Return true if password strength is more
     * than or equal the passing value.
     */

    public function passed()
    {
        return $this->score >= $this->passing;
    }

    /**
     * Return password strength score.
     */

    public function getScore()
    {
        return $this->score;
    }

    /**
     * Return password strength message.
     */

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Parse the current password form configuration.
     */

    private function parseFormParameters()
    {
        $form = Config::form()->password;
        
        $this->minLength = $this->coalesce($form['min-length'], 8);       
        $this->minNumber = $this->coalesce($form['min-number'], 2);
        $this->minLetter = $this->coalesce($form['min-letter'], 4);
        $this->minUcase = $this->coalesce($form['min-ucase'], 2);
        $this->minLcase = $this->coalesce($form['min-lcase'], 2);
    }

    /**
     * Prevent returning -1 value to minimum parameters.
     */

    private function coalesce(int $value, int $default)
    {
        return $value !== -1 ? $value : $default;
    }   

}