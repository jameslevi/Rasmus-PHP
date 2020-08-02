<?php

namespace Rasmus\App;

use Rasmus\Http\Request;
use Rasmus\Util\Collection;

abstract class Controller
{

    /**
     * Indicate whether controller already booted.
     */

    private $booted = false;

    /**
     * If controller successfully return response.
     */

    private $success = false;

    /**
     * Store controller response.
     */

    private $response;

    /**
     * Store route data.
     */

    private $route;

    /**
     * Interface the controller child to
     * your application.
     */

    public function init(string $method, Collection $route)
    {
        if(!$this->booted)
        {
            $this->booted = true;
            $this->route = $route;
            
            if(method_exists($this, $method))
            {
                $fetch = $this->{$method}($this->makePackage());
                
                if(!is_null($fetch))
                {
                    $this->success = true;

                    if(is_string($fetch))
                    {
                        $this->response = $fetch;
                    }
                    else if(is_int($fetch))
                    {
                        $this->response = $fetch . '';
                    }
                    else if(is_array($fetch))
                    {
                        $this->response = json_encode($fetch);
                    }
                    else if($fetch instanceof Collection)
                    {
                        $this->response = $fetch->toJson();
                    }
                    else
                    {
                        $this->response = $fetch;
                    }
                }
            }

            return $this;
        }
    }

    /**
     * Return true if controller successfully return
     * response.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Create request object.
     */

    private function makePackage()
    {
        return new Request([

            'route' => $this->route,

        ]);
    }

    /**
     * Return response data.
     */

    public function response()
    {
        return $this->response;
    }

    /**
     * Can be override by the controller.
     */

    protected function index(Request $request)
    {

    }

}