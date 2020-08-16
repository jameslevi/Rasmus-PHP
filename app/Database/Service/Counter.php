<?php

namespace Database\Service;

use Raccoon\Database\Service;

class Counter extends Service
{
    /**
     * Insert new visit count.
     */

    protected function log(string $userAgent, string $ipAddress)
    {
        return $this->insert([

            'user_agent' => $userAgent,

            'ip_address' => $ipAddress,

        ]);
    }

}