<?php

namespace App\Controller;

use Raccoon\App\Controller;
use Raccoon\Http\Request;

class HttpController extends Controller
{

    /**
     * Return http status response.
     */

    protected function index(Request $request)
    {
        $code = $request->status();
        $errors = $request->errors() ?? [];
        $message = label('statuscode::status.code.' . $code);
        
        /**
         * Return json message.
         */

        if($request->isAjax())
        {
            return $this->byAjax($code, $message, $errors);
        }
        else {
            if($request->status() !== 404)
            {
                if($request->route('ajax'))
                {
                    return $this->byAjax($code, $message, $errors);
                }
            }
        }

        /**
         * Return HTML view.
         */

        return view('http.response', [

            'code' => $code,

            'message' => $message,

        ]);
    }

    /**
     * Return json message when route is requested
     * using ajax or must be ajax.
     */

    private function byAjax(int $code, string $message, array $errors)
    {
        return json([

            'status' => $code,

            'message' => $message,

            'success' => $code === 200,

            'errors' => $errors,

        ]);     
    }

}