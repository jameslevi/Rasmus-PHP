<?php

namespace Database\Model;

use Raccoon\Database\Field;
use Raccoon\Database\Model;

class User extends Model
{
    /**
     * User field can be username or email. You can
     * adjust the values length depending on your
     * needs.
     */

    protected function user(Field $field)
    {
        $field->varChar(60);
        $field->notNull();
    }

    /**
     * This is very straight forward.
     */

    protected function password(Field $field)
    {
        $field->varChar(30);
        $field->notNull();
    }

    /**
     * Updated each time page is requested.
     */

    protected function log(Field $field)
    {
        $field->dateTime();
        $field->notNull();
    }

}