<?php

namespace {

    /**
     * Display and enumerate data.
     */

    function dd($data)
    {
        $view = '';
        
        /**
         * Display string data.
         */
        
        if(is_string($data))
        {
            $view = '<div>' . $data . '</div>';
        }

        else if(is_numeric($data))
        {
            $view = '<div>' . $data . '</div>';
        }

        /**
         * Display array data.
         */

        else if(is_array($data))
        {

        }

        die($view);
    }

    /**
     * Log new entry to logger.
     */

    function logg()
    {
        
    }

}