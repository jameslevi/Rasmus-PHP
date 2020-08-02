<?php

namespace App\Controller
{

    use Rasmus\App\Request;
    use Rasmus\App\Response;
    use Rasmus\Cache\Cache;
    use Rasmus\Resource\Lang\Lang;
    use Rasmus\Util\Collection;

    /**
     * Return canvas factory object to generate view.
     */

    function view(string $canvas, array $emit = [])
    {   
        $cache = Cache::html(Request::uri(), $canvas, $emit);

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

    /**
     * Return http status error instead of returning resources.
     */

    function http(int $code)
    {
        return new Response('http', $code);
    }

    /**
     * Make redirection after controller iteration.
     */

    function redirect(string $url)
    {
        return new Response('redirect', $url);
    }

}