<?php

namespace Rasmus\Cache;

use Rasmus\File\Directory;
use Rasmus\File\Reader;
use Rasmus\Resource\Lang\Locale;
use Rasmus\Route\Route;
use Rasmus\UI\Canvas;
use Rasmus\Util\String\Str;
use Rasmus\Validation\Form;

class Cache
{

    /**
     * Store cache data in to this variable
     * to prevent caching process everytime
     * accessing cache data.
     */

    private static $config_cache = [];
    private static $routes_cache = [];
    private static $assets_cache = [];

    /**
     * Type of cached resource to return. 
     */

    private $type;

    /**
     * Path of cache files.
     */

    public static $path = 'storage/cache/';

    /**
     * Caching file extension.
     */

    public static $ext = '.json';

    /**
     * Secret key to name cache files.
     */

    public static $secret = 'ilovenica';

    /**
     * Return true if caching is enabled.
     */

    private static $enabled = true;

    /**
     * Return true if env is already setted.
     */

    private static $env = false;

    /**
     * Return true if html content needs to be minified.
     */

    private static $minify = true;

    /**
     * Set cache type from the constructor.
     */

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Dynamically call config modules.
     */

    public function __call(string $module, array $args)
    {
        $type = $this->type;

        if($type === 'config')
        {
            return $this->getConfig($module);
        }
        else if($type === 'asset')
        {
            return $this->getAssets($module);
        }
    }

    /**
     * Return cache HTML.
     */

    public function getHtml(string $uri, string $canvas, array $emit = [])
    {
        $html = null;
        $file = static::$path . 'html/' . static::serialize($uri) . '.html';
        $reader = new Reader($file);

        if($reader->exist() && static::$enabled)
        {
            $html = $reader->contents();
            
            if(static::$minify)
            {
                $html = $this->htmlMinify($html);
            }
        }
        else
        {
            $location = '././resource/view/canvas/' . str_replace('.', '/', $canvas) . '.php';
            $read = new Reader($location);
            
            if($read->exist())
            {
                Canvas::init($emit);

                function loadCanvas(string $location)
                {
                    $object = require $location;
                    return $object->html();
                }
                $html = loadCanvas($location);

                if(static::$minify)
                {
                    $html = $this->htmlMinify($html);
                }  
            }

            if(static::$enabled && !is_null($html))
            {
                $handle = fopen($file, 'a+');
                fwrite($handle, $html);
                fclose($handle);
            }
        }

        return $html;
    }

    /**
     * Minify html before returning or saving.
     */

    private function htmlMinify(string $html)
    {
        return str_replace('> <', '><', Str::trim($html));
    }

    /**
     * Return assets data.
     */

    public function getAssets(string $module)
    {
        $modules = [
            'locale',
        ];

        if(in_array($module, $modules))
        {
            if(empty(static::$assets_cache) || !array_key_exists($module, static::$assets_cache))
            {
                if($this->cached() && static::$enabled)
                {
                    static::$assets_cache = $this->load()['assets'];

                    if(!array_key_exists($module, static::$assets_cache))
                    {
                        if($module === 'locale')
                        {
                            $this->parseLocale();
                        }
                        else
                        {
                            $this->parseAssets($module);
                        }    
                    }
                }
                else
                {
                    if($module === 'locale')
                    {
                        $this->parseLocale();
                    }
                    else
                    {
                        $this->parseAssets($module);
                    }            
                }
            }

            return static::$assets_cache[$module];
        }
    }

    /**
     * Parse language translation.
     */

    private function parseLocale()
    {
        $path = 'resource/lang/';
        $dir = new Directory($path);
        $locales = [];

        if($dir->valid())
        {
            foreach($dir->files() as $file)
            {
                $name = Str::break($file, '.')[0];
                $file = $path . $file;
                $reader = new Reader($file);

                if($reader->exist() && $reader->type() === 'php')
                {
                    $data = [];
                    $load = require $file;
                    
                    if(!Locale::empty())
                    {
                        foreach(Locale::getLocales() as $locale)
                        {
                            $data[$locale->getId()] = $locale->getData();
                        }
                        $locales[$name] = $data;
                        Locale::clear();
                    }
                }
            }
        }

        if(!empty($locales))
        {
            static::$assets_cache['locale'] = $locales;
        
            if(static::$enabled)
            {
                $this->saveCache('assets', static::$assets_cache);
            }
        }
    }

    /**
     * Retrieve assets data except locale.
     */

    private function parseAssets(string $module)
    {
        $path = 'resource/';
        $dir = new Directory($path);
        $res = [];

        if($dir->valid())
        {
            foreach($dir->files() as $file)
            {
                $name = Str::break($file, '.')[0];
                $file = $path . $file;
                $reader = new Reader($file);


            }
        }
    }

    /**
     * Return list of routes.
     */

    public function getRoutes()
    {
        if(empty(static::$routes_cache))
        {
            if($this->cached() && static::$enabled)
            {
                static::$routes_cache = $this->load()['routes'];
                
                if(empty(static::$routes_cache))
                {
                    $this->extractRoutes();
                }
            }
            else
            {
                $this->extractRoutes();
            }
        }

        return static::$routes_cache;
    }

    /**
     * Load route files.
     */

    private function extractRoutes()
    {
        $path = 'routes/';
        $dir = new Directory($path);
        $routes = [];
        
        if($dir->valid())
        {
            foreach($dir->files() as $file)
            {
                $file = $path . $file;
                $reader = new Reader($file);

                if($reader->exist() && $reader->type() === 'php')
                {
                    $data = [];
                    $load = require $file;

                    foreach(Route::all() as $route)
                    {
                        $data[] = $route->getData();
                    }

                    Route::clear();
                    $routes[$reader->name()] = $data;
                }
            }
        }

        if(sizeof($routes) !== 0)
        {
            static::$routes_cache = $routes;

            if(!empty(static::$config_cache))
            {
                if(!static::$config_cache['app']['cache'])
                {
                    static::$enabled = false;
                }
            }

            if(static::$enabled)
            {
                $this->saveCache('routes', static::$routes_cache);
            }
        }
    }

    /**
     * Return data from config files.
     */

    private function getConfig(string $module)
    {
        $modules = [
            'app',
            'auth',
            'components',
            'cors',
            'database',
            'dependency',
            'form',
            'middleware',
            'scheme',
        ];

        $withEnv = [
            'app',
            'auth',
            'cors',
            'middleware',
        ];

        if(in_array($module, $modules))
        {
            if(empty(static::$config_cache) || !array_key_exists($module, static::$config_cache))
            {
                /**
                 * If config module already cached.
                 */

                if($this->cached() && static::$enabled)
                {
                    static::$config_cache = $this->load()['config'];

                    if(!array_key_exists($module, static::$config_cache))
                    {
                        $this->parseConfig($module, $withEnv);
                    }
                }
                else 
                {             
                    $this->parseConfig($module, $withEnv);
                }
            }

            if($module === 'app')
            {
                if(array_key_exists($module, static::$config_cache))
                {
                    static::$enabled = static::$config_cache[$module]['cache'];
                    static::$minify = static::$config_cache[$module]['minify'];
                }
            }

            return static::$config_cache[$module];
        }   
    }

    /**
     * Parse and save cache file.
     */

    private function parseConfig(string $module, array $withEnv)
    {
        $path = '././config/';
        $file = $path . $module . '.php';
        
        if(in_array($module, $withEnv) && !static::$env)
        {
            static::$env = true;
            require '././system/App/env.php';
        }

        if(file_exists($file))
        {
            if($module === 'form')
            {
                $data = [];
                require $file;

                if(!Form::empty())
                {
                    foreach(Form::all() as $form)
                    {
                        $data[$form->getName()] = $form->getData();
                    }
                }

                static::$config_cache[$module] = $data;
            }
            else
            {
                static::$config_cache[$module] = require $file;
            }
        }

        if($module === 'app')
        {
            if(!static::$config_cache[$module]['cache'])
            {
                static::$enabled = false;
            }
        }

        if(static::$enabled)
        {
            $this->saveCache('config', static::$config_cache);
        }
    }

    /**
     * Create or save cache data.
     */

    private function saveCache(string $module, array $data)
    {
        $content = [
            'assets' => static::$assets_cache,
            'config' => static::$config_cache,
            'routes' => static::$routes_cache,
        ];

        $content[$module] = $data;
        $toJson = json_encode($content);
        $file = static::getFile();

        if(file_exists($file))
        {
            unlink($file);
        }

        $handle = fopen($file, 'a+');
        fwrite($handle, $toJson);
        fclose($handle);
    }

    /**
     * Load cache file and return array of data.
     */

    private function load()
    {
        if($this->cached())
        {
            return json_decode(file_get_contents($this->getFile()), true);
        }
    }

    /**
     * Return cache file location.
     */

    public static function getFile()
    {
        return static::$path . static::serialize(static::$secret) . static::$ext;
    }

    /**
     * Return true if module is cached.
     */

    private function cached()
    {
        return file_exists(static::getFile());
    }

    /**
     * Serialize string using md5 hashing.
     */

    public static function serialize(string $string)
    {
        return md5($string);
    }

    /**
     * Return data from config files.
     */

    public static function config()
    {
        return new self('config');
    }

    /**
     * Return data from asset files.
     */

    public static function assets()
    {
        return new self('asset');
    }

    /**
     * Return data from route files.
     */

    public static function routes()
    {
        $instance = new self('routes');
        return $instance->getRoutes();
    }

    /**
     * Return html caching data.
     */

    public static function html(string $uri, string $canvas, array $emit)
    {
        $instance = new self('html');
        return $instance->getHtml($uri, $canvas, $emit);       
    }

    /**
     * Return true if caching is enabled.
     */

    public static function enabled()
    {
        return static::$enabled;
    }

}