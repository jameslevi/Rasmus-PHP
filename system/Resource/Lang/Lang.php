<?php

namespace Rasmus\Resource\Lang;

use Rasmus\App\Config;
use Rasmus\Cache\Cache;
use Rasmus\Util\String\Str;

class Lang extends Translations
{

    /**
     * Store cached locales.
     */

    private static $locale_repo;

    /**
     * Store locale key.
     */

    private $key;

    /**
     * Store template array.
     */

    private $templates;

    /**
     * Locale file.
     */

    private $file;

    /**
     * Translation id.
     */

    private $id;

    private function __construct(string $key, array $templates = null)
    {
        $this->key = $key;
        $this->templates = $templates;

        if(is_null(static::$locale_repo))
        {
            static::$locale_repo = Cache::assets()->locale();
        }

        $break = Str::break($key, '::');
        $this->file = $break[0];
        $this->id = $break[1];
    }

    /**
     * Return translated locale.
     */

    public function translate(string $lang)
    {
        if(array_key_exists($this->file, static::$locale_repo))
        {
            $fetch = static::$locale_repo[$this->file];
            
            if(array_key_exists($this->id, $fetch))
            {
                if(array_key_exists($lang, $fetch[$this->id]))
                {
                    if(!is_null($this->templates))
                    {
                        return $this->template($fetch[$this->id][$lang], $this->templates);
                    }
                    else
                    {
                        return $fetch[$this->id][$lang];
                    }
                }
            }
        }    

        return $this->key;
    }

    /**
     * Replace all templates.
     */

    private function template(string $string, array $templates)
    {
        if(!empty($templates))
        {
            foreach($templates as $key => $value)
            {
                $find = '${' . $key . '}';
                $string = str_replace($find, $value, $string);
            }
        }

        return $string;
    }

    /**
     * Dynamically translate locale by creating
     * dynamic methods.
     */

    public function __call(string $key, $value)
    {
        if(array_key_exists($key, $this->languages))
        {
            return $this->translate($key);
        }
    }

    /**
     * Get translation by key.
     */

    public static function get(string $key, array $templates = null)
    {
        $instance = new self($key, $templates);
        return $instance->translate(Config::app()->locale, $templates);
    }

    /**
     * Lang object factory.
     */

    public static function id(string $key, array $templates = null)
    {
        return new self($key, $templates);
    }

}