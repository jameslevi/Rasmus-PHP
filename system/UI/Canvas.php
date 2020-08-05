<?php

namespace Rasmus\UI;

use Rasmus\App\Config;
use Rasmus\App\Request;
use Rasmus\File\Reader;
use Rasmus\Resource\Lang\Lang;
use Rasmus\Util\Collection;
use Rasmus\Util\String\Str;

class Canvas
{
    /**
     * Store data emitted from the controller.
     */

    private static $inital_emit = [];

    /**
     * Component stylesheets.
     */

    private static $stylesheet = [];

    /**
     * Component javascripts.
     */

    private static $javascript = [];

    /**
     * Store the template name.
     */

    private $template;

    /**
     * Store emitted data.
     */

    private $emitted = [];

    /**
     * Store output string.
     */

    private $output = '';

    private function __construct()
    {
        foreach(static::$inital_emit as $key => $data)
        {
            $this->emit($key, $data);
        }
    }

    /**
     * Set template location.
     */

    public function template(string $template)
    {
        if(is_null($this->template))
        {
            $this->template = str_replace('.', '/', $template);
        }
    }

    /**
     * Emit or return value.
     */

    public function emit(string $name, $value)
    {
        $this->emitted[$name] = $value;
    }

    /**
     * Initial data emission.
     */

    public static function init(array $emit)
    {
        static::$inital_emit = $emit;
    }

    /**
     * Append raw html.
     */

    public function raw(string $html)
    {
        $this->output .= $html;
    }

    /**
     * Include raw html from file.
     */

    public function include(string $component)
    {
        $file = 'resource/view/components/';

        foreach(explode('.', $component) as $dir)
        {
            $file .= ucfirst($dir) . '/';
        }

        if(Str::endWith($file, '/'))
        {
            $file = Str::move($file, 0, 1);
        }

        $file .= '.html';

        $reader = new Reader($file);

        if($reader->exist())
        {
            $html = Str::break($reader->contents(), '</template>')[0];
        
            if(Str::has($html, '<template>'))
            {
                $this->output .= Str::break($html, '<template>')[1];
            }
        }
        else
        {
            $this->output .= $component;
        }
    }

    /**
     * Append new component to canvas.
     */

    public function append($component)
    {
        if(is_object($component))
        {
            if(get_parent_class($component) === 'Rasmus\UI\Component')
            {
                $this->output .= $component->draw();
            }
        }
    }

    /**
     * Add stylesheet from components.
     */

    public static function addStylesheet(string $component, string $stylesheet)
    {
        if(!in_array($component, static::$stylesheet))
        {
            static::$stylesheet[$component] = $stylesheet;
        }
    }

    /**
     * Add javascript from components.
     */

    public static function addJavascript(string $component, string $javascript)
    {
        if(!in_array($component, static::$javascript))
        {
            static::$javascript[$component] = $javascript;
        }
    }

    /**
     * Return html output.
     */

    public function html()
    {
        if(!is_null($this->template))
        {
            $reader = new Reader('resource/view/template/' . $this->template . '.php');          

            if($reader->exist())
            {

                $html = $this->replaceTemplates($reader->contents());
                $html = $this->replaceTags($html);
                $html = $this->replaceUtilty($html);
                $html = $this->replaceTemplates($html);
                
                return $html;
            }
        }

        return $this->output;
    }

    /**
     * Replace all css utility to minimize class length.
     */

    private function replaceUtilty(string $html)
    {
        $classes = [];
        $length = strlen($html);
        $pos = strpos($html, 'class="');

        if(!$pos)
        {
            $pos = $length;
        }
        
        while($pos < $length)
        {
            $str = Str::break(substr($html, $pos + 7, $length), '"')[0];
            
            foreach(explode(' ', $str) as $class)
            {
                if($class !== '')
                {
                    $classes[] = $class;
                }
            }

            $pos = strpos($html, 'class="', ($pos + 7) + (strlen($str) + 1));

            if(!$pos)
            {
                $pos = $length;
            }
        }

        $classes = array_unique($classes);
        $pseudos = ['hover', 'active', 'focus'];
        $media = [];
        $css = [];

        if(!empty($classes))
        {
            $utility = new CSSUtility();

            foreach($classes as $class)
            {
                if(Str::startWith($class, 'v-'))
                {
                    $class = Str::move($class, 2);
                    $colon = Str::break($class, ':');
                    
                    if(sizeof($colon) === 2)
                    {
                        $pseudo = $colon[0];
                        $dash = explode('-', $colon[1]);
                        $value = $dash[sizeof($dash) - 1];

                        if(sizeof($dash) > 1)
                        {
                            array_pop($dash);
                            
                            $method = implode('_', $dash);
                        }
                        else
                        {
                            $method = $value;
                        }

                        if(in_array($pseudo, $pseudos))
                        {
                            if($utility->hasDirectMethod($colon[1]))
                            {
                                $make = $utility->makeDirectCall($colon[1], $pseudo);
                            }
                            else
                            {
                                $make = $utility->make($method, $value, $pseudo);
                            }

                            if(!is_null($make))
                            {
                                $css[] = $make;
                            }
                        }
                        else
                        {
                            $name = strtolower(Str::break($pseudo, '-')[0]);

                            if($name === 'media' && Str::has($pseudo, '-'))
                            {
                                if($utility->hasDirectMethod($colon[1]))
                                {
                                    $make = $utility->makeDirectCall($colon[1], $pseudo);
                                }
                                else
                                {
                                    $make = $utility->make($method, $value, $pseudo);
                                }

                                if(!is_null($make))
                                {
                                    if(array_key_exists($pseudo, $media))
                                    {
                                        $media[$pseudo][] = $make;
                                    }
                                    else
                                    {
                                        $media[$pseudo] = [$make];
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $dash = explode('-', $class);
                        $value = $dash[sizeof($dash) - 1];

                        if(sizeof($dash) > 1)
                        {
                            array_pop($dash);

                            $method = implode('_', $dash);
                        }
                        else
                        {
                            $method = $value;
                        }

                        if($utility->hasDirectMethod($class))
                        {
                            $make = $utility->makeDirectCall($class);
                        }
                        else
                        {
                            $make = $utility->make($method, $value);
                        }

                        if(!is_null($make))
                        {
                            $css[] = $make;
                        }
                    }
                }
            }
        }

        $c = 0;

        for($i = 0; $i <= (sizeof($css) - 1); $i++)
        {
            $class = Str::move(Str::break($css[$i], '{')[0], 1);
            $new_class = '.v-' . $c;
            $pseudo = '';

            if(Str::has($class, ':'))
            {
                $break = Str::break($class, ':');
                $class = 'v-' . $break[1] . ':' . Str::break($break[0], '-')[1];
                $pseudo = ':' . $break[1];
            }

            if(Str::has($html, $class))
            {
                $html = str_replace($class . '!', Str::move($new_class, 1), $html);
                $html = str_replace($class, Str::move($new_class, 1), $html);
                $c++;
            }

            $css[$i] = $new_class . $pseudo . '{' . Str::break($css[$i], '{')[1];
        }

        foreach($media as $key => $data)
        {
            $str = '@media only screen and (max-width:' . Str::break($key, '-')[1] . '){';

            for($i = 0; $i <= (sizeof($data) - 1); $i++)
            {
                $class = 'v-' . $key . ':' . Str::break(Str::move($data[$i], 3), '{')[0];
                
                if(Str::has($html, $class))
                {
                    $html = str_replace($class . '!', 'v-' . $c, $html);
                    $html = str_replace($class, 'v-' . $c, $html);
                    $str .= '.v-' . $c . '{' . Str::break($data[$i], '{')[1];
                    $c++;
                }
            }

            $str .= '}';
            $css[] = $str;
        }

        $imploded = implode('', $css);

        /**
         * Inject the link tag of cached stylesheet.
         */

        if(!empty(static::$stylesheet))
        {
            foreach(static::$stylesheet as $css)
            {
                $imploded .= $css;
            }
        }

        /**
         * Cache component's stylesheets.
         */

        if($imploded !== '' && Str::has($html, '</head>'))
        {
            $uri = Request::uri();
            $file = 'storage/cache/css/' . md5($uri) . '.xcss';
            $reader = new Reader($file);
            $reader->delete();

            if(!$reader->exist())
            {
                $handle = fopen($file, 'a+');
                fwrite($handle, $imploded);
                fclose($handle);
            }

            $segments = Str::break($html, '</head>');
            $url = Config::app()->url;

            if(!Str::endWith($url, '/'))
            {
                $url .= '/';
            }

            $uri = md5(Request::uri());

            $link = '<link rel="stylesheet" href="' . $url . 'resource/static/css/' . $uri . '.xcss" type="text/css" />';

            $html = $segments[0] . $link . '</head>' . $segments[1];
        }

        /**
         * Cache component's javascript.
         */

        if(!empty(static::$javascript) && Str::has($html, '</body>'))
        {
            $js = implode(' ', static::$javascript);
            $uri = Request::uri();
            $file = 'storage/cache/js/' . md5($uri) . '.xjs';
            $reader = new Reader($file);
            $reader->delete();

            if(!$reader->exist())
            {
                $handle = fopen($file, 'a+');
                fwrite($handle, $js);
                fclose($handle);
            }

            $segments = Str::break($html, '</body>');
            $url = Config::app()->url;

            if(!Str::endWith($url, '/'))
            {
                $url .= '/';
            }

            $uri = md5(Request::uri());

            $script = '<script type="text/javascript" src="' . $url . 'resource/static/js/' . $uri . '.xjs"></script>';
        
            $html = $segments[0] . $script . '</body>' . $segments[1];
        }

        return $html;
    }

    /**
     * Replace all component's custom tags.
     */

    private function replaceTags(string $html)
    {
        $length = strlen($html);
        $pos = strpos($html, '<v-');

        if(!$pos)
        {
            $pos = $length;
        }

        while($pos < $length)
        {
            $begin = substr($html, 0, $pos);
            $str = substr($html, $pos + 3, $length);
            $tag = Str::break($str, '>')[0];
            $name = Str::break($tag, ' ')[0];
            $end = strpos($str, '</v-' . $name . '>');
            $props = Str::move($tag, strlen($name));
            $span = substr($html, $pos, $length);
            $content = null;
            $data = [];

            if($end)
            {
                $content = Str::break(Str::break($str, '>')[1], '</v-' . $name . '>')[0];
                $span = Str::break($span, '</v-' . $name . '>')[0] . '</v-' . $name . '>';
            }
            else
            {
                $props = Str::move($props, 0, 1);
                if($props === ' ')
                {
                    $props = Str::move($props, 0, 1);
                }
                else
                {
                    if(!Str::endWith($props, ' '))
                    {
                        $props .= ' ';
                    }
                }
                $span = Str::break($span, '/>')[0] . '/>';
            }

            $ending = substr($html, $pos + strlen($span), $length);
            
            if(!empty($props))
            {
                foreach(explode('" ', $props) as $prop)
                {
                    if($prop !== '')
                    {
                        $split = Str::break($prop, '="');
                        $key = str_replace(' ', '', $split[0]);
                        $value = $split[1];

                        if(Str::endWith($value, '"'))
                        {
                            $value = Str::move($value, 0, 1);
                        }

                        if(Str::startWith($key, ':'))
                        {
                            $key = Str::move($key, 1);

                            if(Str::startWith($value, '$'))
                            {
                                $var = Str::move($value, 1);

                                if(Str::has($var, '[') && Str::endWith($var, ']'))
                                {
                                    $arr = strtolower(Str::break($var, '[')[0]);
                                    $val = Str::move(Str::break($var, '[')[1], 1, 3);

                                    if($arr === 'emit')
                                    {
                                        if(array_key_exists($val, $this->emitted))
                                        {
                                            $value = $this->emitted[$val];
                                        }
                                    }
                                    else if($arr === 'label')
                                    {
                                        $label = Lang::get($val);

                                        if($label !== $val)
                                        {
                                            $value = $label;
                                        }
                                    }
                                }
                            }
                        }

                        $data[$key] = $value;
                    }
                }
            }
            
            $refs = Config::components();
            $ref = $refs->{$name};
            $output = $span;
            $instance = new $ref();

            if(!is_null($content))
            {
                $instance->slot(Str::trim($content));
            }
                
            foreach($data as $prop => $value)
            {
                if($value === 'true')
                {
                    $value = true;
                }
                else if($value === 'false')
                {
                    $value = false;
                }
                else if(is_numeric($value) || is_int($value))
                {
                    $value = (int)$value;
                }
                else if(Str::startWith($value, '$') && Str::has($value, '[') && Str::has($value, ']'))
                {
                    $value = Str::move($value, 1, 2);
                    $break = Str::break($value, '[');
                    $name = strtolower($break[0]);
                    $val = Str::move($break[1], 1, 2);
                    
                    if($name === 'emit')
                    {
                        if(array_key_exists($val, $this->emitted) && !is_null($this->emitted[$val]))
                        {
                            $value = $this->emitted[$val];
                        }
                    }
                    else if($name === 'label')
                    {
                        $label = Lang::get($value);

                        if($label !== $value)
                        {
                            $value = $label;
                        }
                    }
                }

                $instance->{$prop} = $value;
            }

            $output = $instance->draw();
            $this->rendered = true;
            
            $html = $begin . $output . $ending;
            $length = strlen($html);
            $pos = strpos($html, '<v-');

            if(!$pos)
            {
                $pos = $length;
            }
        }

        return $html;
    }

    /**
     * Replace all template string from template file.
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
                    $break = Str::break($directive, '[');
                    $name = $break[0];
                    $value = Str::move($break[1], 1, 3);
                    
                    if($name === 'emit')
                    {
                        /**
                         * Replace template by emitted values.
                         */

                        if(array_key_exists($value, $this->emitted) && !is_null($this->emitted[$value]))
                        {
                            $str .= $this->emitted[$value] . Str::break($segment, '}}')[1];
                        }
                        else
                        {
                            $str .= '{{' . $segment;
                        }
                    }
                    else if($name === 'label')
                    {

                        /**
                         * Replace template by labels.
                         */

                        $label = Lang::get($value);
                    
                        if($label !== $value)
                        {
                            $str .= $label . Str::break($segment, '}}')[1];
                        }
                        else
                        {
                            $str .= '{{' . $segment;
                        }
                    }
                    else
                    {
                        $str .= '{{' . $segment;
                    }
                }
                else
                {
                    if($directive === 'content')
                    {
                        /**
                         * Replace content template.
                         */

                        $str .= $this->output . Str::break($segment, '}}')[1];
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
            else
            {
                $str .= $segment;
            }
        }

        return $str;
    }

    /**
     * Return canvas closure.
     */

    public static function draw($closure)
    {
        return $closure(new self(), new Collection(static::$inital_emit));
    }

}