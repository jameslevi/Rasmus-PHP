<?php

namespace Rasmus\Validation;

class Form
{

    /**
     * Store all registered forms.
     */

    private static $forms = [];

    /**
     * Form validation data.
     */

    private $data = [

        'name' => null,

        'numeric' => false,

        'min-length' => 1,

        'max-length' => -1,

        'min-word' => 1,

        'max-word' => -1,

        'min-line' => 1,

        'max-line' => -1,

        'min-value' => null,

        'max-value' => null,

        'min-number' => -1,

        'max-number' => -1,

        'min-letter' => -1,

        'max-letter' => -1,

        'min-ucase' => -1,

        'max-ucase' => -1,

        'min-lcase' => -1,

        'max-lcase' => -1,

        'min-spechar' => -1,

        'max-spechar' => -1,

        'prohibit' => [],

        'start-with' => [],

        'end-with' => [],

        'contains' => [],

        'must-not' => [],

        'expect' => [],

        'pattern' => null,

    ];

    private function __construct(string $name, array $arg)
    {
        $this->set('name', $name);
    }

    /**
     * Return form name.
     */

    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * Set to true if value must be a numeric.
     */

    public function numeric(bool $numeric)
    {
        $this->set('numeric', $numeric);
        return $this;
    }

    /**
     * Set minimum length of value.
     */

    public function minLength(int $value)
    {
        $this->set('min-length', $value);
        return $this;
    }

    /**
     * Set maximum length of value.
     */

    public function maxLength(int $value)
    {
        $this->set('max-length', $value);
        return $this;
    }

    /**
     * Set minimum number of words.
     */

    public function minWord(int $value)
    {
        $this->set('min-word', $value);
        return $this;
    }

    /**
     * Set maximum number of words.
     */

    public function maxWord(int $value)
    {
        $this->set('max-word', $value);
        return $this;
    }

    /**
     * Set minimum number of line.
     */

    public function minLine(int $value)
    {
        $this->set('min-line', $value);
        return $this;
    }

    /**
     * Set maximum number of lines.
     */

    public function maxLine(int $value)
    {
        $this->set('max-line', $value);
        return $this;
    }

    /**
     * Set minimum value of numbers.
     */

    public function minValue(int $value)
    {
        $this->set('min-value', $value);
        return $this;
    }

    /**
     * Set maximum value of numbers.
     */

    public function maxValue(int $value)
    {
        $this->set('max-value', $value);
        return $this;
    }

    /**
     * Set minimum number of occurances of number in value.
     */

    public function minNumber(int $value)
    {
        $this->set('min-number', $value);
        return $this;
    }

    /**
     * Set maximum number of occurances of number in value.
     */

    public function maxNumber(int $value)
    {
        $this->set('min-number', $value);
        return $this;
    }

    /**
     * Set minimum number of occurances of letter.
     */

    public function minLetter(int $value)
    {
        $this->set('min-letter', $value);
        return $this;
    }

    /**
     * Set maximum number of occurances of letter.
     */

    public function maxLetter(int $value)
    {
        $this->set('max-letter', $value);
        return $this;
    }

    /**
     * Set minimum number of uppercase letters.
     */

    public function minUppercase(int $value)
    {
        $this->set('min-ucase', $value);
        return $this;
    }

    /**
     * Set maximum number of uppercase letters.
     */

    public function maxUppercase(int $value)
    {
        $this->set('max-ucase', $value);
        return $this;
    }

    /**
     * Set minimum number of lowercase letters.
     */

    public function minLowercase(int $value)
    {
        $this->set('min-lcase', $value);
        return $this;
    }

    /**
     * Set maximum number of lowercase letters.
     */

    public function maxLowercase(int $value)
    {
        $this->set('max-lcase', $value);
        return $this;
    }

    /**
     * Set minimum number of special characters.
     */

    public function minSpecialCharacters(int $value)
    {
        $this->set('min-spechar', $value);
        return $this;
    }

    /**
     * Set maximum number of special characters.
     */

    public function maxSpecialCharacters(int $value)
    {
        $this->set('max-spechar', $value);
        return $this;
    }
    
    /**
     * Set prohibited characters.
     */

    public function prohibit(array $string)
    {
        $this->set('prohibit', $string);
        return $this;
    }

    /**
     * Set start with keys.
     */

    public function startWith(array $keys)
    {
        $this->set('start-with', $keys);
        return $this;
    }

    /**
     * Set end with keys.
     */

    public function endWith(array $keys)
    {
        $this->set('end-with', $keys);
        return $this;
    }

    /**
     * Set contain values.
     */

    public function contains(array $keys)
    {
        $this->set('contains', $keys);
        return $this;
    }

    /**
     * Set invalid values.
     */

    public function mustNot(array $keys)
    {
        $this->set('must-not', $keys);
        return $this;
    }

    /**
     * Set expected values.
     */

    public function expect(array $keys)
    {
        $this->set('expect', $keys);
        return $this;
    }

    /**
     * Set regex pattern.
     */

    public function pattern(string $regex)
    {
        $this->set('pattern', $regex);
        return $this;
    }

    /**
     * Set validation parameter data.
     */

    private function set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Return form data.
     */

    public function getData()
    {
        return $this->data;
    }

    /**
     * Dynamically register form validation.
     */

    public static function __callStatic(string $name, array $arg)
    {
        $instance = new self($name, $arg);
        static::$forms[$name] = $instance;
        
        return $instance;
    }

    /**
     * Return all registered forms.
     */

    public static function all()
    {
        return static::$forms;
    }

    /**
     * Return true if no form is registered.
     */

    public static function empty()
    {
        return sizeof(static::$forms) === 0;
    }

}