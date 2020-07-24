<?php

namespace App\Controller
{

    use Rasmus\App\Request;
    use Rasmus\Cache\Cache;
    use Rasmus\Resource\Lang\Lang;
    use Rasmus\Util\Collection;

    /**
     * Return canvas factory object to generate view.
     */

    function view(string $canvas, array $emit = [])
    {   
        if(!empty($emit))
        {
            
        }

        $cache = Cache::html(Request::uri(), $canvas);

        if(!is_null($cache))
        {
            return $cache;
        }

        return $canvas;
    }

    /**
     * Return json formatted response.
     */

    function json($data)
    {
        if(!is_array($data) && $data instanceof Collection)
        {
            $data = $data->toArray();
        }

        return json_encode($data);
    }

    /**
     * Return label translation.
     */

    function label(string $key, array $template = [])
    {
        return Lang::get($key, $template);
    }

}