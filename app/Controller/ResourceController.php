<?php

namespace App\Controller;

use Rasmus\App\Config;
use Rasmus\App\Controller;
use Rasmus\File\Reader;
use Rasmus\Http\Request;

class ResourceController extends Controller
{

    protected function stylesheet(Request $request)
    {
        $css = '';
        $reader = new Reader('storage/cache/css/' . $request->resource()->css);

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

}