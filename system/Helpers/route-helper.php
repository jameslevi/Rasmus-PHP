<?php

namespace Raccoon\Route {

    use Raccoon\App\Request;
    use Raccoon\App\Response;
    use Raccoon\Cache\Cache;
    use Raccoon\Resource\Lang\Lang;
    use Raccoon\Util\Collection;

    /**
     * Return canvas generated html.
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
     * Transform resource values.
     */

    function transform(array $array)
    {

        return json_encode($array);
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