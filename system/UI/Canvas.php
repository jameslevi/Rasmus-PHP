<?php

namespace Raccoon\UI;

use Raccoon\App\Config;
use Raccoon\App\Request;
use Raccoon\Cache\Cache;
use Raccoon\File\Reader;
use Raccoon\Resource\Lang\Lang;
use Raccoon\Util\Collection;
use Raccoon\Util\Str;

class Canvas
{
    /**
     * Canvas object to evaluate.
     */

    private static $canvas;

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

            /**
             * Return html template.
             */
        
            if(Str::has($html, '<template>'))
            {
                $output = Str::break($html, '<template>')[1];
            
                if(Str::has($output, '<!--') && Str::has($output, '-->') && Config::app()->minify)
                {
                    $parsed = '';

                    foreach(explode('<!--', $output) as $comment)
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

                    $output = $parsed;
                }

                $this->output .= $output;
            }
            
            $html = $reader->contents();

            /**
             * Return stylesheet data.
             */

            if(Str::has($html, '<style') && Str::has($html, '</style>'))
            {
                $style = Str::break(Str::break(Str::break($html, '<style')[1], '</style>')[0], '>')[1];

                if(Config::app()->minify)
                {
                    $css = str_replace(' {', '{', Str::trim($style));
                    $css = str_replace('{ ', '{', $css);
                    $css = str_replace(' }', '}', $css);
                    $css = str_replace('} ', '}', $css);
                    $css = str_replace('; ', ';', $css);
                    $css = str_replace(' ;', ';', $css);
                    $css = str_replace(', ', ',', $css);
                    $css = str_replace(' ,', ',', $css);
                    $css = str_replace(': ', ':', $css);
                    $style = Str::trim($css);
                }

                if(!empty($style))
                {
                    if(!array_key_exists($component, static::$stylesheet))
                    {
                        static::$stylesheet[$component] = $style;
                    }
                }
            }

            /**
             * Return javascript data.
             */

            if(Str::has($html, '<script') && Str::has($html, '</script>'))
            {
                $script = Str::break(Str::break(Str::break($html, '<script')[1], '</script>')[0], '>')[1];

                if(Config::app()->minify)
                {
                    $script = Str::trim($script);
                    $js = '';

                    foreach(explode('/**', $script) as $line)
                    {
                        if(Str::has($line, '*/'))
                        {
                            $js .= Str::break($line, '*/')[1];
                        }
                        else
                        {
                            $js .= $line;
                        }
                    }

                    $script = $js;
                }

                if(!empty($script))
                {
                    if(!array_key_exists($component, static::$javascript))
                    {
                        static::$javascript[$component] = $script;
                    }
                }
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
            if(get_parent_class($component) === 'Raccoon\UI\Component')
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
            $reader = new Reader('resource/view/template/' . $this->template . '.html');          

            if($reader->exist())
            {
                $html = $this->replaceTemplates($reader->contents());
                $html = $this->replaceSelfClosingTags($html);
                $html = $this->replaceAttributes($html);
                $html = $this->replaceTags($html);
                $html = $this->replaceUtilty($html);
                $html = $this->replaceTemplates($html);

                return $html;
            }
        }

        return $this->output;
    }

    /**
     * Replace all self closing tags.
     */

    private function replaceSelfClosingTags(string $html)
    {
        $str = '';

        foreach(explode('<', $html) as $tag)
        {
            if(!Str::startWith($tag, '/') && $tag !== '')
            {
                if(Str::has($tag, '>'))
                {
                    $tagname = Str::break(Str::break($tag, ' ')[0], '>')[0];
                    
                    if(Str::startWith($tag, 'v-'))
                    {
                        $str .= '<';
                        $this_tag = Str::break($tag, '>')[0];

                        if(Str::endWith($this_tag, ' /'))
                        {
                            $this_tag = Str::move($this_tag, 0, 2);
                            $str .= $this_tag . '></' . $tagname . '>';
                        }
                        else
                        {
                            $str .= $tag;
                        }
                    }
                    else
                    {
                        $str .= '<';
                        $this_tag = Str::break($tag, '>')[0];

                        if(Str::endWith($this_tag, ' /'))
                        {
                            $this_tag = Str::move($this_tag, 0, 2);
                            $str .= $this_tag . '>';
                        }
                        else
                        {
                            $str .= $tag;
                        }
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

        return $str;
    }

    /**
     * Replace dynamic attributes from native html tags.
     */

    private function replaceAttributes(string $html)
    {   
        $str = '';

        foreach(explode('<', $html) as $tag)
        {
            if(!Str::startWith($tag, '/') && $tag !== '')
            {
                if(Str::has($tag, '>'))
                {
                    $str .= '<';
                    $pos = strpos($tag, ' ');
                    $props = $pos ? Str::move(Str::break($tag, '>')[0], $pos) : '';
                    $str .= Str::break(Str::break($tag, '>')[0], ' ')[0] . ' ';
                    $content = Str::break($tag, '>')[1] ?? null;

                    while(Str::startWith($props, ' '))
                    {
                        $props = Str::move($props, 1);
                    }

                    if(!Str::endWith($props, ' '))
                    {
                        $props .= ' ';
                    }

                    $attrs = explode('" ', $props);
                    
                    if(sizeof($attrs) > 1)
                    {
                        foreach($attrs as $attr)
                        {
                            if($attr !== '' && $attr !== ' ')
                            {
                                if(Str::startWith($attr, ':'))
                                {
                                    $tag_name = Str::move(Str::break($attr, '=')[0], 1);
                                    $value = Str::break($attr, '="')[1];
                                    $val = null;

                                    if(Str::startWith($value, '$'))
                                    {
                                        $directive = strtolower(Str::move(Str::break($value, '[')[0], 1));
                                        
                                        if(Str::has($value, "['") && Str::has($value, "']"))
                                        {
                                            $index = Str::move(Str::break($value, "['")[1], 0, 2);
                                            
                                            if(Str::eq($directive, 'emit'))
                                            {
                                                if(array_key_exists($index, $this->emitted) && !is_null($this->emitted[$index]))
                                                {
                                                    $val = $this->emitted[$index];
                                                }
                                            }
                                            else if(Str::eq($directive, 'label'))
                                            {
                                                $lang = Lang::get($index);
                                            
                                                if($lang !== $index)
                                                {
                                                    $val = $lang;
                                                }
                                            }
                                            else if(Str::eq($directive, 'assets'))
                                            {
                                                $url = Config::app()->url;

                                                if(!Str::startWith($index, '/'))
                                                {
                                                    $index = '/' . $index;
                                                }

                                                $path = '/resource/assets' . $index;

                                                if(Str::endWith($url, '/'))
                                                {
                                                    $url = Str::move($url, 0, 1);
                                                }

                                                $val = $url . $path;
                                            }
                                            else if(Str::eq($directive, 'url'))
                                            {
                                                $url = Config::app()->url;

                                                if(Str::endWith($url, '/'))
                                                {
                                                    $url = Str::move($url, 0, 1);
                                                }

                                                if(!Str::startWith($index, '/'))
                                                {
                                                    $index = '/' . $index;
                                                }

                                                $val = $url . $index;
                                            }
                                        }
                                    }

                                    if(!is_null($val))
                                    {
                                        $str .= $tag_name . '="' . $val . '" ';
                                    }
                                }
                                else
                                {
                                    $str .= $attr . '" ';
                                }
                            }
                        }
                    }
                    else
                    {
                        if(sizeof($attrs) === 1 && $attrs[0] !== '' && $attrs[0] !== ' ')
                        {
                            $str .= $attrs[0];
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

        return $str;
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

            if(Str::has($html, $class . ' ') || Str::has($html, $class . '! '))
            {
                $html = str_replace($class . '! ', Str::move($new_class, 1) . ' ', $html);
                $html = str_replace($class . ' ', Str::move($new_class, 1). ' ', $html);
                $c++;
            }
            
            if(Str::has($html, $class . '"') || Str::has($html, $class . '!"'))
            {
                $html = str_replace($class . '!"', Str::move($new_class, 1) . '"', $html);
                $html = str_replace($class . '"', Str::move($new_class, 1). '"', $html);
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
            $file = 'storage/cache/css/' . md5($uri) . '.css';
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

            $link = '<link rel="stylesheet" href="' . $url . 'resource/static/css/' . $uri . '.css" type="text/css" />';

            $html = $segments[0] . $link . '</head>' . $segments[1];
        }

        /**
         * Cache component's javascript.
         */

        if(!empty(static::$javascript) && Str::has($html, '</body>'))
        {
            /**
             * Wrap all javascripts in jquery ready method.
             */

            $js = '$(document).ready(function(){' . implode(' ', static::$javascript) . '});';
            $uri = Request::uri();
            $file = 'storage/cache/js/' . md5($uri) . '.js';
            $reader = new Reader($file);
            $reader->delete();

            /**
             * Include jquery library for native components.
             */

            if(Str::has($js, '$(') || Str::has($js, '$.ajax'))
            {
                $jquery = Config::dependency()->jQuery;
                $read_jquery = new Reader($jquery);

                if($read_jquery->exist())
                {
                    $contents = $read_jquery->contents();
                    
                    if(!empty($contents))
                    {
                        $js = $contents . $js;
                    }

                    $core = 'resource/assets/js/core.js';
                    $read_core = new Reader($core);

                    if($read_core->exist())
                    {
                        $get_core = Str::trim($read_core->contents());
                        $s = '';

                        if(Str::endWith($js, '});'))
                        {
                            $js = Str::move($js, 0, 3);
                        }

                        foreach(explode('/**', $get_core) as $script)
                        {
                            if(Str::has($script, '*/'))
                            {
                                $s .= Str::break($script, '*/')[1];
                            }
                            else
                            {
                                $s .= $script;
                            }
                        }

                        $js .= $s;
                        $js .= 'function url(uri){return "' . Config::app()->url . '" + uri;}';
                    }

                    /**
                     * Include API routes data array.
                     */

                    $routes = Cache::routes();
                    
                    if(!empty($routes))
                    {
                        $xhr = [];

                        foreach($routes as $group)
                        {
                            foreach($group as $route)
                            {
                                if($route['ajax'])
                                {
                                    $s = "{type:'" . $route['verb'] . "',uri:'" . $route['uri'] . "',dataType:'json',cache:false";

                                    $s .= '}';
                                    $xhr[] = $s;
                                }
                            }
                        }

                        $array = "const routes = [" . implode(',', $xhr) . "];";

                        if(Str::endWith($js, '});'))
                        {
                            $js = Str::move($js, 0, 3);
                        }

                        $js .= $array . '});';
                    }
                }
            }

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

            $script = '<script type="text/javascript" src="' . $url . 'resource/static/js/' . $uri . '.js"></script>';
        
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
                while(Str::startWith($content, ' ') || Str::startWith($content, "\n"))
                {
                    $content = Str::move($content, 1);
                }

                while(Str::endWith($content, ' ') || Str::endWith($content, "\n"))
                {
                    $content = Str::move($content, 0, 1);
                }

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

            if(Config::app()->minify)
            {
                $output = str_replace('/n', ' ', Str::trim($output));
            }

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
                            $str .= htmlspecialchars($this->emitted[$value]) . Str::break($segment, '}}')[1];
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
        $canvas = new self();
        
        if(is_null(static::$canvas))
        {
            static::$canvas = $canvas;
        }

        $closure($canvas, new Collection(static::$inital_emit));
    
        return true;
    }

    /**
     * Return canvas to render.
     */

    public static function getCanvas()
    {
        return static::$canvas;
    }

}