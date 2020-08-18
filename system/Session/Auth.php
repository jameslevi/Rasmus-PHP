<?php

namespace Raccoon\Session;

use Raccoon\App\Config;
use Raccoon\Util\Collection;

class Auth
{
    /**
     * Session model name.
     */

    private static $modelname = 'auth';

    /**
     * Store auth instance.
     */

    private static $instance;

    /**
     * Store session model object.
     */

    private $model;

    /**
     * Idle configuration object.
     */

    private $idle;

    private function __construct()
    {
        $this->model = Session::make(static::$modelname, [

            'status' => false,

            'id' => null,

            'email' => null,

            'timein' => null,

            'timestamp' => null,

        ]);
        
        $this->idle = new Collection(Config::auth()->idle);
    }

    /**
     * Test if session has authentication.
     */

    public function authenticated()
    {
        return !is_null($this->model) && $this->model->status && !is_null($this->model->id) && !is_null($this->model->email);
    }

    /**
     * Update timestamp.
     */

    public function update()
    {
        $this->model->set('timestamp', time());
    }

    /**
     * Return true if user is active.
     */

    public function isActive()
    {
        $idle = $this->idle;

        if($idle->enable)
        {
            $expiration = $idle->expire;
            $timestamp = $this->get('timestamp');

            return true;
        }

        return false;
    }

    /**
     * Authenticate user.
     */

    public function register(string $id, string $email)
    {
        $this->model->set('status', true);
        $this->model->set('id', $id);
        $this->model->set('email', $email);
        $this->model->set('timein', time());
        $this->model->set('timestamp', time());
    }

    /**
     * Reset session data to default.
     */

    public function reset()
    {
        $this->model->set('status', false);
        $this->model->set('id', null);
        $this->model->set('email', null);
        $this->model->set('timein', null);
        $this->model->set('timestamp', null);
    }

    /**
     * Return session model data.
     */

    public function get(string $name)
    {
        return $this->model->{$name};
    }

    /**
     * Delete authentication model.
     */

    public function destroy()
    {
        $this->model->delete();
    }

    /**
     * Initiate authentication service.
     */

    public static function init()
    {
        return static::instantiate();
    }

    /**
     * Instantiate authentication class.
     */

    private static function instantiate()
    {
        if(is_null(static::$instance))
        {
            static::$instance = new self();           
        }

        return static::$instance;
    }

    /**
     * Return auth instance.
     */

    public static function context()
    {
        return static::$instance;
    }

}