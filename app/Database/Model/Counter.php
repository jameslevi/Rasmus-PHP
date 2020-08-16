<?php

namespace Database\Model;

use Raccoon\Database\Field;
use Raccoon\Database\Model;

class Counter extends Model
{
    /**
     * Visitor user-agent.
     */

    protected function user_agent(Field $field)
    {
        $field->text();
        $field->notNull();
    }

    /**
     * Visitor ip address.
     */

    protected function ip_address(Field $field)
    {
        $field->varChar(30);
        $field->notNull();
    }

}