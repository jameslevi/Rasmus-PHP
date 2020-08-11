<?php

namespace Raccoon\App;

use Raccoon\Http\Request;
use Raccoon\Http\Response;

abstract class Middleware
{

    /**
     * Make the init method accessible
     * to parent class only.
     */

    private $booted = false;

    /**
     * Skip middleware iteration.
     */

    protected $skip = false;

    /**
     * Return if filtering is successfull.
     */

    private $success = false;

    /**
     * Store middleware response.
     */

    private $response;

    /**
     * Handle request filtering logic.
     */

    protected abstract function handle(Request $request);

    /**
     * Log each failed handler.
     */

    protected function log()
    {
        
    }

    /**
     * Initiate middleware testing.
     */

    public function init(Request $package)
    {
        if(!$this->skip && !$this->booted)
        {
            $this->booted = true;
            $test = $this->handle($package);
         
            if($test instanceof Response)
            {
                $this->log();
                $this->success = true;
                $this->response = $test;
            }
        }

        return $this;
    }

    /**
     * Return true if successfull.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Return middleware response.
     */

    public function response()
    {
        return $this->response;
    }

}