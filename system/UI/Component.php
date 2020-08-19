<?php

namespace Raccoon\UI;

use Raccoon\App\Config;
use Raccoon\File\Reader;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Util\Collection;
use Raccoon\Util\Str;

abstract class Component
{

    /**
     * If component class already instantiated.
     */

    private $init = false;

    /**
     * Component inner html content.
     */

    protected $slot;

    /**
     * Set slot content.
     */

    public function slot(string $slot)
    {
        $this->slot = $slot;
    }

    /**
     * Component data.
     */

    protected $data = [];

    /**
     * Component properties.
     */

    protected $prop = [];

    /**
     * Call init method each time component is instantiated.
     */

    public function __construct()
    {
        if(!$this->init)
        {
            $this->init = true;

            if(method_exists($this, 'init'))
            {
                $this->init();
            }
        }        
    }

    /**
     * Overridable methods.
     */

    protected function init()
    {

    }

    protected function change()
    {

    }

    protected function render()
    {

    }

    /**
     * Dynamically get prop data.
     */

    public function __get(string $key)
    {
        if(array_key_exists($key, $this->prop))
        {
            return $this->prop[$key];
        }
        else if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
    }

    /**
     * Dynamically set prop data and reactively
     * call prop function.
     */

    public function __set(string $key, $value)
    {
        $this->change();
        if(array_key_exists($key, $this->prop))
        {
            $this->prop[$key] = $value;
            if(method_exists($this, $key))
            {
                $this->{$key}($value);
            }
        }
        else if(array_key_exists($key, $this->data))
        {
            $this->data[$key] = $value;
        }
        else
        {
            if(strtolower($key) === 'id')
            {
                $this->prop['id'] = $value;
                if(method_exists($this, 'id'))
                {
                    $this->{'id'}($value);
                }
            }
        }
    }

    /**
     * Return slot child data.
     */

    protected function getChild(string $name, array $keys = [])
    {
        $slot = $this->slot;
        $count = 0;
        $explode = explode('<' . $name, $slot);
        $items = [];

        foreach($explode as $slot)
        {
            if(Str::has($slot, '</' . $name) && Str::has($slot, '>'))
            {
                $count++;
            }
        }

        if($count !== 0)
        {
            foreach($explode as $slot)
            {
                if(Str::has($slot, '</' . $name) && Str::has($slot, '>'))
                {
                    $slot = Str::break($slot, '</' . $name . '>')[0];
                    $break = Str::break($slot, '>');
                    $attr = $break[0];
                    $html = $break[1];
                    $data = $keys;
                    $data['content'] = $html;
                    
                    foreach(explode(' ', $attr) as $prop)
                    {
                        if(!empty($prop) && $prop !== '')
                        {
                            $attr_name = Str::break($prop, '="')[0];
                            $attr_val = Str::move(Str::break($prop, '="')[1], 0, 1);
                            
                            if(array_key_exists($attr_name, $keys))
                            {
                                $data[$attr_name] = $attr_val;
                            }
                        }
                    }

                    $items[] = new Collection($data);
                }
            }
        }

        return $items;
    }

    /**
     * Render html components.
     */

    public function draw()
    {
        $this->render();
        $class = str_replace('\\', '/', get_called_class());
        $template = 'resource/view/c' . Str::move($class, 1) . '.html';
        $reader = new Reader($template);

        if($reader->exist())
        {
            $html = $reader->contents();
            $str = '';

            /**
             * Export component stylesheet to cache css file.
             */

            if(Str::has($html, '<style') && Str::has($html, '</style>'))
            {
                $css = Str::trim(Str::move(Str::break(Str::break($html, '<style')[1], '</style>')[0], 1));

                if(Config::app()->minify)
                {
                    $css = str_replace(' {', '{', $css);
                    $css = str_replace('{ ', '{', $css);
                    $css = str_replace(' }', '}', $css);
                    $css = str_replace('} ', '}', $css);
                    $css = str_replace('; ', ';', $css);
                    $css = str_replace(' ;', ';', $css);
                    $css = str_replace(', ', ',', $css);
                    $css = str_replace(' ,', ',', $css);
                    $css = str_replace(': ', ':', $css);
                }

                Canvas::addStylesheet($template, $css);
            }

            /**
             * Export component javascript to cache javascript file.
             */

            if(Str::has($html, '<script') && Str::has($html, '</script>'))
            {
                $js = Str::trim(Str::move(Str::break(Str::break($html, '<script')[1], '</script>')[0], 1));
                $script = '';

                if(Config::app()->minify)
                {
                    foreach(explode('/**', $js) as $line)
                    {
                        if(Str::has($line, '*/'))
                        {
                            $script .= Str::break($line, '*/')[1];
                        }
                        else
                        {
                            $script .= $line;
                        }
                    }
                }

                Canvas::addJavascript($template, $script);
            }

            /**
             * Extract template from component html file.
             */

            if(Str::has($html, '<template>') && Str::has($html, '</template>'))
            {

            $html = Str::break(Str::break($html, '<template>')[1], '</template>')[0];

            if(Str::has($html, '<!--') && Str::has($html, '-->') && Config::app()->minify)
            {
                $parsed = '';

                foreach(explode('<!--', $html) as $comment)
                {
                    if(Str::has($comment, '-->'))
                    {
                        $parsed .= Str::break($comment, '-->')[1];
                    }
                    else
                    {
                        $parsed .= $comment;
                    }
                }

                $html = $parsed;
            }

            foreach(explode('<', $html) as $tag)
            {
                if(!Str::startWith($tag, '/') && $tag !== '')
                {
                    if(Str::has($tag, '>'))
                    {
                    $str .= '<';
                    $pos = strpos($tag, ' ');
                    $props = $pos ? Str::move(Str::break($tag, '>')[0], $pos) : '';
                    $content = Str::break($tag, '>')[1] ?? null;
                    $str .= Str::break(Str::break($tag, '>')[0], ' ')[0] . ' ';
                    $tagname = Str::break($tag, ' ')[0];
                    
                    while(Str::startWith($props, ' '))
                    {
                        $props = Str::move($props, 1);
                    }
                    
                    if(!Str::endWith($props, ' '))
                    {
                        $props .= ' ';
                    }

                    $attrs = explode('" ', $props);
                    $has_show = false;
                    $has_style = false;
                    $attr_style = null;
                    $style_value = null;
                    $styled = false;

                    /**
                     * Evaluate all tag attributes.
                     */

                    if(sizeof($attrs) > 1)
                    {

                    foreach($attrs as $attr)
                    {
                        if($attr !== '' && $attr !== ' ')
                        {
                            $name = Str::break($attr, '=')[0];
                            $value = Str::move(Str::break($attr, '=')[1], 1);

                            if(Str::startWith($name, ':'))
                            {
                                $name = Str::move($name, 1);
                                
                                if($name === 'id')
                                {
                                    if(Str::startWith($value, '$'))
                                    {
                                        $var = Str::move($value, 1);
                                        
                                        if(strtolower($var) === 'id')
                                        {
                                            $value = $this->prop['id'] ?? null;
                                        }
                                        else
                                        {
                                            if(array_key_exists($var, $this->data) && strtolower($var) !== 'id')
                                            {
                                                $value = $this->data[$var];
                                            }
                                            else if(array_key_exists($var, $this->prop) && strtolower($var) !== 'id')
                                            {
                                                $value = $this->prop[$var];           
                                            }
                                        }
                                    }

                                    if(!is_null($value))
                                    {
                                        $str .= $name . '="' . $value . '" ';
                                    }
                                }
                                else if($name === 'show')
                                {
                                    if(Str::endWith($value, ')') && Str::has($value, '('))
                                    {
                                        $func = Str::break($value, '(')[0];
                                        $val = Str::break($value, '(')[1] ?? null;
                                        
                                        if(!is_null($val))
                                        {
                                            $val = Str::move($val, 0, 1);
                                            
                                            if(strtolower($val) === 'true')
                                            {
                                                $val = true;
                                            }
                                            else if(strtolower($val) === 'false')
                                            {
                                                $val = false;
                                            }
                                            else if(is_numeric($val) || is_int($val))
                                            {
                                                $val = (int)$val;
                                            }
                                            else
                                            {
                                                if(Str::startWith($val, '$'))
                                                {
                                                    $key = Str::move($val, 1);

                                                    if(array_key_exists($key, $this->data))
                                                    {
                                                        $val = $this->data[$key];
                                                    }
                                                    else if(array_key_exists($key, $this->prop))
                                                    {
                                                        $val = $this->prop[$key];
                                                    }
                                                }
                                            }
                                        }

                                        if(method_exists($this, $func))
                                        {
                                            if(is_null($val))
                                            {
                                                $value = $this->{$func}();
                                            }
                                            else
                                            {
                                                $value = $this->{$func}($val);
                                            }
                                        }
                                    }
                                    else if(Str::startWith($value, '$'))
                                    {
                                        $value = Str::move($value, 1);

                                        if(array_key_exists($value, $this->data))
                                        {
                                            $value = $this->data[$value];
                                        }
                                        else if(array_key_exists($value, $this->prop))
                                        {
                                            $value = $this->prop[$value];
                                        }
                                    }
                                    else if(array_key_exists($value, $this->data) && is_bool($value))
                                    {
                                        $value = $this->data[$value];
                                    }
                                    else if(array_key_exists($value, $this->prop) && is_bool($value))
                                    {
                                        $value = $this->prop[$value];
                                    }
                                    else if($value === 'true')
                                    {
                                        $value = true;
                                    }
                                    else if($value === 'false')
                                    {
                                        $value = false;
                                    }

                                    if(Str::startWith($tagname, 'v-'))
                                    {
                                        $str .= $name . '="' . ($value ? 'true' : 'false') . '" ';
                                    }
                                    else
                                    {
                                        if($value === false)
                                        {
                                            $has_show = true;
                                        }
                                    }
                                }
                                else if($name === 'style')
                                {
                                    $has_style = true;
                                    $attr_style = $value;
                                }
                                else if($name === 'class')
                                {
                                    $classes = explode(' ', $value);
                                    $class = '';

                                    foreach($classes as $css)
                                    {
                                        if(Str::startWith($css, '$'))
                                        {
                                            $css = Str::move($css, 1);
                                            
                                            if(array_key_exists($css, $this->data))
                                            {
                                                $val = $this->data[$css];
                                                
                                                if(is_array($val))
                                                {
                                                    if(!empty($val))
                                                    {
                                                        $class .= implode(' ', array_unique($val)) . ' ';
                                                    }
                                                }
                                                else
                                                {
                                                    $class .= $val . ' ';
                                                }
                                            }
                                            else if(array_key_exists($css, $this->prop))
                                            {
                                                $val = $this->prop[$css];

                                                if(is_array($val))
                                                {
                                                    $class .= implode(' ', $val) . ' ';
                                                }
                                                else
                                                {
                                                    $class .= $val . ' ';
                                                }
                                            }
                                            else if(method_exists($this, $css))
                                            {
                                                $val = $this->{$css}();
                                            }
                                            else
                                            {
                                                $class .= '$' . $css . ' ';
                                            }
                                        }
                                        else
                                        {
                                            $class .= $css . ' ';
                                        }
                                    }

                                    if(Str::endWith($class, ' '))
                                    {
                                        $class = Str::move($class, 0, 1);
                                    }

                                    $str .= $name . '="' . $class . '" ';
                                }
                                else
                                {
                                    if(Str::startWith($value, '$'))
                                    {
                                        $value = Str::move($value, 1);

                                        if(strtolower($value) === 'slot')
                                        {
                                            $str .= $name . '="' . $this->slot . '" ';
                                        }
                                        else
                                        {
                                            if(array_key_exists($value, $this->data))
                                            {
                                                $value = $this->data[$value];
                                            }
                                            else if(array_key_exists($value, $this->prop))
                                            {
                                                $value = $this->prop[$value];
                                            }

                                            if(is_bool($value))
                                            {
                                                if($value)
                                                {
                                                    $str .= $name . ' ';
                                                }
                                            }
                                            else
                                            {
                                                if(!is_null($value))
                                                {
                                                    $str .= $name . '="' . $value . '" ';
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $str .= $name . '="' . $value . '" ';
                                    }
                                }
                            }
                            else
                            {
                                if($name !== 'style')
                                {
                                    $str .= $attr . '" ';
                                }
                                else
                                {
                                    $style_value = $attr;
                                }
                            }
                        }                       
                    }

                    }

                    if(($has_show || $has_style || !is_null($style_value)) && !$styled)
                    {
                        $styled = true;
                        $css = '';
                        
                        if(!is_null($style_value))
                        {
                            $css = Str::move($style_value, 7);

                            if(!Str::endWith($str, ';'))
                            {
                                $css .= ';';
                            }
                        }

                        if($has_style)
                        {
                            $css .= $attr_style;
                        }

                        if(Str::endWith($css, ';'))
                        {
                            $css = Str::move($css, 0, 1);
                        }

                        if($css !== '')
                        {
                            $str .= ' style="';
                            $has_display = false;

                            foreach(explode(';', $css) as $rule)
                            {
                                if($rule !== '' && !empty($rule))
                                {
                                    $name = Str::break($rule, ':')[0];
                                
                                    if($name === 'display')
                                    {
                                        $has_display = true;

                                        if($has_show)
                                        {
                                            $str .= 'display: block';
                                        }
                                        else
                                        {
                                            $str .= 'display: ' . Str::break($rule, ':')[1];
                                        }
                                        $str .= '; ';
                                    }
                                    else
                                    {
                                        $str .= $rule . '; ';
                                    }
                                }
                            }

                            if(!$has_display)
                            {
                                if($has_show)
                                {
                                    $str .= 'display: none';
                                }
                            }

                            if(Str::endWith($str, ' '))
                            {
                                $str = Str::move($str, 0, 1);
                            }

                            $str .= '" ';
                        }
                        else
                        {
                            if($has_show)
                            {
                                $str .= 'style="display: none"';    
                            }
                        }
                    }
                    else
                    {
                        if($has_show)
                        {
                            $str .= 'style="display: none"';
                        }
                    }

                    if(Str::endWith($str, ' '))
                    {
                        $str = Str::move($str, 0, 1);
                    }

                    $str .= '>';

                    if(!is_null($content))
                    {
                        $str .= $content;
                    }
                }
                else
                {
                    $str .= $tag;
                }
                }
                else if($tag !== '')
                {
                    $str .= '<' . $tag;
                }
            }    
            
            }

            return $this->replaceTemplates($str);
        }

        return '';
    }    

    /**
     * Parse and replace all template string.
     */

    private function replaceTemplates(string $html)
    {
        $split = explode('{{', $html);
        $str = '';

        foreach($split as $segment)
        {
            $temp = str_replace(' ', '', Str::break($segment, '}}')[0]);

            if(Str::startWith($temp, '$'))
            {
                $directive = strtolower(Str::move($temp, 1));

                if(Str::has($directive, '[') && Str::has($directive, ']'))
                {
                    $name = strtolower(Str::break($directive, '[')[0]);
                    $value = Str::move(Str::break($directive, '[')[1], 1, 3);

                    if($name === 'label')
                    {
                        $label = Lang::get($value);

                        if($label !== $value)
                        {
                            $str .= $label . Str::break($segment, '}}')[1];
                        }
                        else
                        {
                            $str .= '' . Str::break($segment, '}}')[1];
                        }
                    }
                }
                else if($directive === 'slot')
                {
                    $str .= $this->slot . Str::break($segment, '}}')[1];
                }
                else
                {
                    if(array_key_exists($directive, $this->data))
                    {
                        $val = $this->data[$directive];

                        if(is_bool($val))
                        {
                            $val = $val ? 'true' : 'false';
                        }

                        $str .= $this->data[$directive] . Str::break($segment, '}}')[1];
                    }
                    else if(array_key_exists($directive, $this->prop))
                    {
                        $val = $this->prop[$directive];

                        if(is_bool($val))
                        {
                            $val = $val ? 'true' : 'false';
                        }

                        $str .= $val . Str::break($segment, '}}')[1];
                    }
                    else
                    {
                        $str .= '{{' . $segment;
                    }
                }
            }
            else if(Str::startWith($temp, '--') && Str::endWith($temp, '--'))
            {
                $str .= '' . Str::break($segment, '}}')[1];
            }
            else if(Str::has($segment, '}}'))
            {
                $str .= '{{' . $segment . Str::break($segment, '}}')[1];
            }
            else {
                $str .= $segment;
            }
        }

        return $str;
    }

}