<?php

namespace App\Controller;

use Raccoon\App\Config;
use Raccoon\App\Controller;
use Raccoon\File\Reader;
use Raccoon\Http\Request;

class ResourceController extends Controller
{
    /**
     * Path where to locate cached resources.
     */

    private $path = 'storage/cache/';

    /**
     * Cached stylesheet method.
     */

    protected function stylesheet(Request $request)
    {
        $css = '';
        $path = $this->path . 'css/' . $request->resource()->css;
        $reader = new Reader($path);

        if($reader->exist())
        {
            $css .= $reader->contents();
        }

        if(!Config::app()->cache)
        {
            $reader->delete();
        }

        if(!empty($css))
        {
            return $css;
        }

        return http(404);
    }

    /**
     * Cached javascript method.
     */

    protected function javascript(Request $request)
    {
        $js = '';
        $path = $this->path . 'js/' . $request->resource()->js;
        $reader = new Reader($path);

        if($reader->exist())
        {
            $js .= $reader->contents();
        }

        if(!Config::app()->cache)
        {
            $reader->delete();
        }

        if(!empty($js))
        {
            return $js;
        }

        return http(404);
    }

}