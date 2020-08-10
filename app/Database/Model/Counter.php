<?php

namespace Database\Model;

use Rasmus\Database\Field;
use Rasmus\Database\Model;

class Counter extends Model
{
    /**
     * Visitor user-agent.
     */

    protected function user_agent(Field $field)
    {
        $field->text();
        $field->notNull();

        return $field;
    }

    /**
     * Visitor ip address.
     */

    protected function ip_address(Field $field)
    {
        $field->varChar(30);
        $field->notNull();

        return $field;
    }

}