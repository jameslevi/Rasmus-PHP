<?php

namespace Rasmus\Validation;

use Rasmus\App\Config;
use Rasmus\Resource\Lang\Lang;
use Rasmus\Util\Collection;
use Rasmus\Util\String\Str;

class Validate
{

    /**
     * Store form validation data.
     */

    private static $cache;

    /**
     * Name of form to use.
     */

    private $name;

    /**
     * Form type declared from form config.
     */

    private $type;

    /**
     * Set to true if validation is optional.
     */

    private $optional = false;

    /**
     * Store validation parameters.
     */

    private $data;

    public function __construct(string $name, string $type, bool $optional)
    {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;

        if(is_null(static::$cache))
        {
            static::$cache = Config::form();
        }

        $this->data = static::$cache->{$type};
    }

    /**
     * Return parameter data.
     */

    private function get(string $name)
    {
        return $this->data[$name];
    }

    /**
     * Get validation error messages.
     */

    private function getMessage(int $code, array $replace = [], bool $extend = false)
    {
        $lang = 'validation::message.code.' . $code;

        if($extend)
        {
            $lang .= 'b';
        }
        
        return Lang::get($lang, $replace);
    }

    /**
     * Get plural string.
     */

    private function getPlural(string $key)
    {
        return $this->get($key) > 1 ? 's' : '';
    }

    /**
     * Test a value to validate.
     */

    public function test($value)
    {
        $data = [];
        $message = null;
        $code = 0;
        
        /**
         * If value is numeric.
         */

        if($this->get('numeric'))
        {
            /**
             * Test if value is valid number.
             */

            if(is_numeric($value) || is_int($value) || is_integer($value))
            {
                /**
                 * Test if numeric value is more than or equal
                 * the minimum value.
                 */

                if(is_null($this->get('min-value')) || (!is_null($this->get('min-value')) && $value >= $this->get('min-value')))
                {
                    /**
                     * Test if numeric value is less than or equal
                     * the maximum value.
                     */

                    if(is_null($this->get('max-value')) || (!is_null($this->get('max-value')) && $value <= $this->get('max-value')))
                    {
                        $code = 0;
                    }
                    else
                    {
                        $code = 27;
                        $message = $this->getMessage($code, [

                            'name' => ucfirst($this->name),

                            'value' => $this->get('max-value'),

                        ]);
                    }
                }
                else
                {
                    $code = 26;
                    $message = $this->getMessage($code, [

                        'name' => ucfirst($this->name),

                        'value' => $this->get('min-value'),

                    ]);
                }
            }
            else
            {
                $code = 25;
                $message = $this->getMessage($code, [

                    'name' => ucfirst($this->name),

                ]);
            }
        }   
        else
        {
            /**
             * If value is string.
             */

            if(is_null($value) || empty($value))
            {
                $value = '';
            }

            if($value !== '' && !$this->optional)
            {
                /**
                 * Value must be greater than or equal
                 * minimum length.
                 */

                if(strlen($value) >= $this->get('min-length'))
                {
                    /** 
                     * Value must be less than or equal the
                     * maximum length. 
                     */

                    if($this->get('max-length') === -1 || ($this->get('max-length') !== -1 && strlen($value) <= $this->get('max-length')))
                    {
                        /**
                         * Value must have number of words more than or equal the minimum.
                         */
                        
                        if($this->get('min-word') === -1 || ($this->get('min-word') !== -1 && Str::wordCount($value) >= $this->get('min-word')))
                        {
                            /**
                             * Value must have number of words less than or equal the maximum.
                             */

                            if($this->get('max-word') === -1 || ($this->get('max-word') !== -1 && Str::wordCount($value) <= $this->get('max-word')))
                            {
                                /**
                                 * Value must have number of line more than or equal the minimum.
                                 */

                                if($this->get('min-line') === -1 || ($this->get('min-line') !== -1 && Str::lineCount($value) >= $this->get('min-line')))
                                {
                                    /**
                                     * Value must have number of line less than or equal the maximum.
                                     */

                                    if($this->get('max-line') === -1 || ($this->get('max-line') !== -1 && Str::lineCount($value) <= $this->get('max-line')))
                                    {
                                        /**
                                         * Value must have number of occurance of numbers
                                         * more than or equal the minimum.
                                         */

                                        if($this->get('min-number') === -1 || ($this->get('min-number') !== -1 && Str::numberCount($value) >= $this->get('min-number')))
                                        {
                                            /**
                                             * Value must have number of occurance of numbers
                                             * less than or equal the maximum.
                                             */

                                            if($this->get('max-number') === -1 || ($this->get('max-number') !== -1 && Str::numberCount($value) <= $this->get('max-number')))
                                            {
                                                /**
                                                 * Value must have number of occurancces of letter
                                                 * more than or equal the minimum.
                                                 */

                                                if($this->get('min-letter') === -1 || ($this->get('min-letter') !== -1 && Str::letterCount($value) >= $this->get('min-letter')))
                                                {
                                                    /**
                                                     * Value must have number of occurances of letter
                                                     * less than or equal the maximum.
                                                     */

                                                    if($this->get('max-letter') === - 1 || ($this->get('max-letter') !== -1 && Str::letterCount($value) <= $this->get('max-letter')))
                                                    {
                                                        /**
                                                         * Value must have number of occurances of uppercase
                                                         * letter more than or equal the minimum.
                                                         */
                                                        
                                                        if($this->get('min-ucase') === -1 || ($this->get('min-ucase') !== -1 && Str::uppercaseCount($value) >= $this->get('min-ucase')))
                                                        {
                                                            /**
                                                             * Value musut have number of occurances of uppercase
                                                             * letter less than or equal the maximum.
                                                             */

                                                            if($this->get('max-ucase') === -1 || ($this->get('max-ucase') !== -1 && Str::uppercaseCount($value) <= $this->get('max-ucase')))
                                                            {
                                                                /**
                                                                 * Value must have number of occurrances of lowercase
                                                                 * letter more than or equal minimum.
                                                                 */
                                                                
                                                                if($this->get('min-lcase') === -1 || ($this->get('min-lcase') !== -1 && Str::lowercaseCount($value) >= $this->get('min-lcase')))
                                                                {
                                                                    /**
                                                                     * Value must have number of occurrances of lowercase
                                                                     * letter less than or equal the maximum.
                                                                     */

                                                                    if($this->get('max-lcase') === -1 || ($this->get('max-lcase') !== -1 && Str::lowercaseCount($value) <= $this->get('max-lcase')))
                                                                    {
                                                                        /**
                                                                         * Value must have number of occurrances of non letter and
                                                                         * numeric characters more than or equal the minimum.
                                                                         */

                                                                        if($this->get('min-spechar') === -1 || ($this->get('min-spechar') !== -1 && Str::nonAlphaNumericCharacterCount($value) >= $this->get('min-spechar')))
                                                                        {
                                                                            /**
                                                                             * Value must have number of occurances of non letter and
                                                                             * numeric characters less than or equal the maximum.
                                                                             */

                                                                            if($this->get('max-spechar') === -1 || ($this->get('max-spechar') !== -1 && Str::nonAlphaNumericCharacterCount($value) <= $this->get('max-spechar')))
                                                                            {
                                                                                /**
                                                                                 * Test if value contains prohibited characters or substring.
                                                                                 */

                                                                                if(empty($this->get('prohibit')) || (!empty($this->get('prohibit')) && !Str::contains($value, $this->get('prohibit'))))
                                                                                {
                                                                                    /**
                                                                                     * Test if value starts with a key.
                                                                                     */
                                                                                    
                                                                                    if(empty($this->get('start-with')) || (!empty($this->get('start-with')) && $this->testStartWith($value, $this->get('start-with'))))
                                                                                    {
                                                                                        /**
                                                                                         * Test if value ends with a key.
                                                                                         */

                                                                                        if(empty($this->get('end-with')) || (!empty($this->get('end-with')) && $this->testEndWith($value, $this->get('end-with'))))
                                                                                        {
                                                                                            /**
                                                                                             * Test if value contains required keys.
                                                                                             */

                                                                                            if(empty($this->get('contains')) || (!empty($this->get('contains') && Str::contains($value, $this->get('contains')))))
                                                                                            {
                                                                                                /**
                                                                                                 * Test if value is not prohibited.
                                                                                                 */

                                                                                                if(empty($this->get('must-not')) || (!empty($this->get('must-not')) && !in_array($value, $this->get('must-not'))))
                                                                                                {
                                                                                                    /**
                                                                                                     * Test of value is included in expected
                                                                                                     * values.
                                                                                                     */

                                                                                                    if(empty($this->get('expect')) || (!empty($this->get('expect')) && in_array($value, $this->get('expect'))))
                                                                                                    {
                                                                                                        /**
                                                                                                         * Test if value must have pattern.
                                                                                                         */

                                                                                                        if(is_null($this->get('pattern')) || (!is_null($this->get('pattern')) && preg_match($this->get('pattern'), $value)))
                                                                                                        {
                                                                                                            $code = 0;
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            $code = 24;
                                                                                                            $message = $this->getMessage($code, [

                                                                                                                'name' => ucfirst($this->name),
                        
                                                                                                            ]);
                                                                                                        }
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        $code = 23;
                                                                                                        $message = $this->getMessage($code, [

                                                                                                            'name' => ucfirst($this->name),
                    
                                                                                                        ]);
                                                                                                    }
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $code = 22;
                                                                                                    $message = $this->getMessage($code, [

                                                                                                        'name' => ucfirst($this->name),
                
                                                                                                    ]);
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                $code = 21;
                                                                                                $message = $this->getMessage($code, [

                                                                                                    'name' => ucfirst($this->name),
            
                                                                                                ]);
                                                                                            }
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $code = 20;
                                                                                            $message = $this->getMessage($code, [

                                                                                                'name' => ucfirst($this->name),
        
                                                                                            ]);
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $code = 19;
                                                                                        $message = $this->getMessage($code, [

                                                                                            'name' => ucfirst($this->name),
    
                                                                                        ]);
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    $code = 18;
                                                                                    $message = $this->getMessage($code, [

                                                                                        'name' => ucfirst($this->name),

                                                                                    ]);
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                $code = 17;
                                                                                $message = $this->getMessage($code, [

                                                                                    'name' => ucfirst($this->name),

                                                                                    'length' => $this->get('max-spechar'),

                                                                                    'plural' => $this->getPlural('max-spechar'),

                                                                                ], $this->get('max-spechar') === 0);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $code = 16;
                                                                            $message = $this->getMessage($code, [

                                                                                'name' => ucfirst($this->name),

                                                                                'length' => $this->get('min-spechar'),

                                                                                'plural' => $this->getPlural('min-spechar'),

                                                                            ]);
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $code = 15;
                                                                        $message = $this->getMessage($code, [

                                                                            'name' => ucfirst($this->name),

                                                                            'length' => $this->get('max-lcase'),

                                                                            'plural' => $this->getPlural('max-lcase'),

                                                                        ], $this->get('max-lcase') === 0);
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $code = 14;
                                                                    $message = $this->getMessage($code, [

                                                                        'name' => ucfirst($this->name),

                                                                        'length' => $this->get('min-lcase'),

                                                                        'plural' => $this->getPlural('min-lcase'),

                                                                    ]);
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $code = 13;
                                                                $message = $this->getMessage($code, [

                                                                    'name' => ucfirst($this->name),

                                                                    'length' => $this->get('max-ucase'),

                                                                    'plural' => $this->getPlural('max-ucase'),

                                                                ], $this->get('max-ucase') === 0);
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $code = 12;
                                                            $message = $this->getMessage($code, [

                                                                'name' => ucfirst($this->name),

                                                                'length' => $this->get('min-ucase'),

                                                                'plural' => $this->getPlural('min-ucase'),

                                                            ]);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $code = 11;
                                                        $message = $this->getMessage($code, [

                                                            'name' => ucfirst($this->name),

                                                            'length' => $this->get('max-letter'),

                                                            'plural' => $this->getPlural('max-letter'),

                                                        ], $this->getPlural('max-letter') === 0);
                                                    }
                                                }
                                                else
                                                {
                                                    $code = 10;
                                                    $message = $this->getMessage($code, [

                                                        'name' => ucfirst($this->name),

                                                        'length' => $this->get('min-letter'),

                                                        'plural' => $this->getPlural('min-letter'),

                                                    ]);
                                                }
                                            }
                                            else
                                            {
                                                $code = 9;
                                                $message = $this->getMessage($code, [

                                                    'name' => ucfirst($this->name),

                                                    'length' => $this->get('max-number'),

                                                    'plural' => $this->getPlural('max-number'),

                                                ], $this->get('max-number') === 0);
                                            }
                                        }
                                        else
                                        {
                                            $code = 8;
                                            $message = $this->getMessage($code, [

                                                'name' => ucfirst($this->name),

                                                'length' => $this->get('min-number'),

                                                'plural' => $this->getPlural('min-number'),

                                            ], $this->get('min-number') === 0);
                                        }
                                    }
                                    else
                                    {
                                        $code = 7;
                                        $message = $this->getMessage($code, [

                                            'name' => ucfirst($this->name),
    
                                            'length' => $this->get('max-line'),
    
                                            'plural' => $this->getPlural('max-line'),
    
                                        ]);    
                                    }
                                }
                                else
                                {
                                    $code = 6;
                                    $message = $this->getMessage($code, [

                                        'name' => ucfirst($this->name),

                                        'length' => $this->get('min-line'),

                                        'plural' => $this->getPlural('min-line'),

                                    ]);
                                }
                            }
                            else
                            {
                                $code = 5;
                                $message = $this->getMessage($code, [

                                    'name' => ucfirst($this->name),

                                    'length' => $this->get('max-word'),

                                    'plural' => $this->getPlural('max-word'),

                                ]);
                            }
                        }
                        else
                        {
                            $code = 4;
                            $message = $this->getMessage($code, [

                                'name' => ucfirst($this->name),

                                'length' => $this->get('min-word'),

                                'plural' => $this->getPlural('min-word'),

                            ]);
                        }
                    }
                    else
                    {
                        $code = 3;
                        $message = $this->getMessage($code, [

                            'name' => ucfirst($this->name),

                            'length' => $this->get('max-length'),

                            'plural' => $this->getPlural('max-length'),

                        ]);
                    }
                }
                else
                {
                    $code = 2;
                    $message = $this->getMessage($code, [

                        'name' => ucfirst($this->name),

                        'length' => $this->get('min-length'),

                        'plural' => $this->getPlural('min-length'),

                    ]);
                }
            }
            else
            {
                if($this->optional)
                {
                    $code = 0;
                }
                else
                {
                    $code = 1;
                    $message = $this->getMessage($code, [

                        'name' => strtolower($this->name),

                    ]);
                }
            }
        }
        
        return new Collection([

            'code' => $code,

            'message' => $message,

        ]);
    }

    /**
     * Test if value starts with a keys.
     */

    private function testStartWith(string $value, array $keys)
    {
        foreach($keys as $key)
        {
            if(Str::startWith($value, $key))
            {
                return true;
            }           
        }

        return false;
    }

    /**
     * Test if value ends with a keys.
     */

    private function testEndWith(string $value, array $keys)
    {
        foreach($keys as $key)
        {
            if(Str::endWith($value, $key))
            {
                return true;
            }           
        }

        return false;
    }

}