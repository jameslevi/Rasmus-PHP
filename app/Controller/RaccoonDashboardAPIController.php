<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Cache\Cache;
use Raccoon\File\Directory;
use Raccoon\File\Reader;
use Raccoon\Http\Request;
use Raccoon\Util\Str;

class RaccoonDashboardAPIController extends Controller
{
    /**
     * Generate API key by registering developer email account.
     */

    protected function generateAPIKey(Request $request)
    {
        $email = $request->post('email');
        $key = Str::random(10);
        $env = new Reader('.env');

        if($env->exist())
        {
            $content = str_replace('API_KEY=null', 'API_KEY=' . $key, $env->contents());
            $content = str_replace('API_TIMESTAMP=null', 'API_TIMESTAMP=' . date('Y-m-d H:i:s'), $content);
            $env->overwrite($content);

            return json([

                'success' => true,

                'email' => $email,
    
                'key' => $key,
    
            ]);
        }

        return http(500);
    }

    /**
     * Set application mode.
     */

    protected function setMode(Request $request)
    {
        $env = new Reader('.env');
        $mode = $request->resource()->mode;
        
        if(!in_array($mode, ['up', 'down']))
        {
            $mode = 'down';
        }

        if($env->exist())
        {
            
        }

        return json([

            'success' => true,

        ]);
    }

    /**
     * Clear all caches from storage.
     */

    protected function cacheClear(Request $request)
    {
        $this->deleteStaticCache();
        $this->deleteCSSCache();
        $this->deleteJSCache();
        $this->deleteHTMLCache();
        $this->deleteRouteCache();

        return json([

            'success' => true,

        ]);
    }

    /**
     * Clear UI caches including css, js and html cache files.
     */

    protected function uiCacheClear(Request $request)
    {
        $this->deleteCSSCache();
        $this->deleteJSCache();
        $this->deleteHTMLCache();

        return json([

            'success' => true,

        ]);
    }

    /**
     * Delete config cache.
     */

    protected function configCacheClear(Request $request)
    {
        $static = $this->getStaticCache();

        if($static)
        {
            $static = json_decode($static, true);

            if(array_key_exists('config', $static))
            {
                $env = $static['config']['env'];

                unset($static['config']);
                $static['config'] = [

                    'env' => $env,

                ];

                $reader = new Reader(Cache::getFile());

                if($reader->exist())
                {
                    $reader->overwrite(json_encode($static));
                }
            }
        }

        return json([

            'success' => true,

        ]);
    }

    /**
     * Delete assets cache.
     */

    protected function assetsCacheClear(Request $request)
    {
        $static = $this->getStaticCache();

        if($static)
        {
            $static = json_decode($static, true);

            if(array_key_exists('assets', $static))
            {
                unset($static['assets']);
                $static['assets'] = [];

                $reader = new Reader(Cache::getFile());

                if($reader->exist())
                {
                    $reader->overwrite(json_encode($static));
                }
            }
        }

        return json([

            'success' => true,

        ]);
    }

    /**
     * Delete routes cache.
     */

    protected function routesCacheClear(Request $request)
    {
        $static = $this->getStaticCache();

        if($static)
        {
            $static = json_decode($static, true);

            if(array_key_exists('routes', $static))
            {
                unset($static['routes']);
                $static['routes'] = [];

                $reader = new Reader(Cache::getFile());

                if($reader->exist())
                {
                    $reader->overwrite(json_encode($static));
                }
            }
        }

        return json([

            'success' => true,

        ]);
    }

    /**
     * Return static cache containing config, assets
     * and routes map.
     */

    private function getStaticCache()
    {
        $reader = new Reader(Cache::getFile());

        if($reader->exist())
        {
            return $reader->contents();
        }

        return false;
    }

    /**
     * Delete static cache.
     */

    private function deleteStaticCache()
    {
        $reader = new Reader(Cache::getFile());

        if($reader->exist())
        {
            $reader->delete();
        }
    }

    /**
     * Delete all .xcss files.
     */

    private function deleteCSSCache()
    {
        $files = new Directory('storage/cache/css');

        if($files->valid())
        {
            foreach($files->files() as $file)
            {
                if($file !== '.gitkeep')
                {
                    $xcss = new Reader('storage/cache/css/' . $file);

                    if($xcss->exist())
                    {
                        $xcss->delete();
                    }
                }
            }
        }
    }

    /**
     * Delete all .xjs files.
     */

    private function deleteJSCache()
    {
        $files = new Directory('storage/cache/js');

        if($files->valid())
        {
            foreach($files->files() as $file)
            {
                if($file !== '.gitkeep')
                {
                    $xjs = new Reader('storage/cache/js/' . $file);

                    if($xjs->exist())
                    {
                        $xjs->delete();
                    }
                }
            }
        }
    }

    /**
     * Delete all .html cache files.
     */

    private function deleteHTMLCache()
    {
        $files = new Directory('storage/cache/html');

        if($files->valid())
        {
            foreach($files->files() as $file)
            {
                if($file !== '.gitkeep')
                {
                    $xhtml = new Reader('storage/cache/html/' . $file);

                    if($xhtml->exist())
                    {
                        $xhtml->delete();
                    }
                }
            }
        }
    }

    /**
     * Delete all routes.
     */

    private function deleteRouteCache()
    {
        $files = new Directory('storage/cache/routes');

        if($files->valid())
        {
            foreach($files->files() as $file)
            {
                if($file !== '.gitkeep')
                {
                    $json = new Reader('storage/cache/routes/' . $file);

                    if($json->exist())
                    {
                        $json->delete();
                    }
                }
            }
        }
    }

    /**
     * Return all routes.
     */

    protected function routesGroup(Request $request)
    {
        $routes = Cache::routes();
        $group = $request->resource()->group;
        $success = false;

        if(array_key_exists($group, $routes))
        {
            $success = true;
        }

        return json([

            'data' => $success ? $routes[$group] : [],

            'success' => $success,

        ]);
    }

    /**
     * Return routes data.
     */

    protected function routesProfile(Request $request)
    {
        $id = $request->resource()->id;

        return json([

            'success' => true,

        ]);
    }

}