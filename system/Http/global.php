<?php

namespace App\Middleware {

    use Rasmus\Http\Emitter;
    use Rasmus\Http\Response;

    /**
     * Return http response code.
     */

    function http(int $code)
    {
        return new Response('http', $code);
    }

    /**
     * Display message and forcing to stop
     * runtime. Equivalent to die function.
     */

    function dump(string $message)
    {
        return new Response('dump', $message);
    }

    /**
     * Bypass middleware iteration.
     */

    function bypass()
    {
        return new Response('bypass');
    }

    /**
     * Go to the next middleware.
     */

    function next()
    {
        return new Response('next');
    }

    /**
     * Redirect to new route.
     */

    function redirect(string $uri)
    {
        return new Response('redirect', $uri);
    }

    /**
     * Emit data that can are accessible with
     * other middlewares and the controller.
     */

    function emit(string $name, $data = null)
    {
        if(!is_null($data))
        {
            Emitter::emit($name, $data);
        }
        else
        {
            return Emitter::get($name);
        }
    }

}