<?php

namespace App\Middleware;

use Raccoon\App\Middleware;
use Raccoon\Http\Request;
use Raccoon\Validation\Validate;

class ValidationMiddleware extends Middleware
{

    protected function handle(Request $request)
    {
        $validate = $request->route('validate');

        /**
         * If request parameters are required.
         */

        if(!is_null($validate))
        {
            if(is_string($validate))
            {
                $validate = str_replace('.', '\\', $validate);
                $validator = 'App\Validator\\' . $validate . 'Validator';
                $instance = new $validator();
            
                if(!$instance->validate($request))
                {
                    emit('errors', $instance->getErrors());

                    return http(500);           
                }
            }
            else if(is_array($validate))
            {
                $n = 0;
                $errors = [];

                foreach($validate as $key => $param)
                {
                    $data = $param->getData()->toArray();

                    /**
                     * Get parameter value.
                     */

                    if(!is_null($data['method']))
                    {
                        if($data['method'] === 'post')
                        {
                            $value = $request->post($key, $data['default']);
                        } 
                        else
                        {
                            $value = $request->get($key, $data['default']);
                        }
                    }
                    else
                    {
                        $resource = $request->resource()->{$key} ?? null;

                        if(!is_null($resource))
                        {
                            $value = $resource;
                        }
                        else
                        {
                            if($request->method() === 'post')
                            {
                                $value = $request->post($key, $data['default']);
                            }
                            else
                            {
                                $value = $request->get($key, $data['default']);
                            }
                        }
                    }

                    /**
                     * Validate here.
                     */

                    $validation = new Validate($data['name'], $data['type'], $data['optional']);
                    $test = $validation->test($value);

                    if($test->code !== 0)
                    {
                        $n++;
                        $errors[] = $test->message;
                    }
                }

                if($n !== 0 && !empty($errors))
                {
                    emit('errors', $errors);

                    return http(500);
                }
            }
        }

        return next();
    }

}