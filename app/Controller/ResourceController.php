<?php

namespace App\Controller;

use Rasmus\App\Config;
use Rasmus\App\Controller;
use Rasmus\File\Reader;
use Rasmus\Http\Request;

class ResourceController extends Controller
{

    /**
     * Cached stylesheet method.
     */

    protected function stylesheet(Request $request)
    {
        $css = '';
        $path = 'storage/cache/css/' . $request->resource()->css;
        $reader = new Reader($path);

        if($reader->exist())
        {
            $css .= $reader->contents();
        }

        if(!Config::app()->cache)
        {
            $reader->delete();
        }

        return $css;
    }

    /**
     * Cached javascript method.
     */

    protected function javascript(Request $request)
    {
        $js = '';
        $path = 'storage/cache/js/' . $request->resource()->js;
        $reader = new Reader($path);

        if($reader->exist())
        {
            $js .= $reader->contents();
        }

        if(!Config::app()->cache)
        {
            $reader->delete();
        }

        return $js;
    }

}