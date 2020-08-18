<?php

namespace Database\Service;

use Raccoon\Database\Service;

class User extends Service
{
    /**
     * Return true if user and password is valid.
     */

    protected function isValidCredential(string $email, string $password)
    {
        return !$this->select('id')
                    ->equal('email', $email)
                    ->equal('password', $password)
                    ->get()
                    ->empty();
    }

    /**
     * Update log field to notify application that user is active.
     */

    protected function setActive(int $id)
    {
        return $this->setById($id, 'log', 'NOW()');
    }

}