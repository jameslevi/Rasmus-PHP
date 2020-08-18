<?php

namespace Database\Model;

use Raccoon\Database\Field;
use Raccoon\Database\Model;

class User extends Model
{
    /**
     * USER NAME
     * -----------------------------------------------
     * User name will be saved in just one column
     * but you can modify user model to have two
     * separate columns for first name and last
     * name.
     */

    protected function name(Field $field)
    {
        $field->varChar(60)->notNull();
    }

    /**
     * EMAIL
     * -----------------------------------------------
     * This field must be unique to avoid conflict in
     * authentication.
     */

    protected function email(Field $field)
    {
        $field->varChar(60)->unique()->notNull();
    }

    /**
     * PASSWORD
     * -----------------------------------------------
     * This is very straight forward.
     */

    protected function password(Field $field)
    {
        $field->varChar(32)->notNull();
    }

    /**
     * ACTIVE LOG
     * ----------------------------------------------- 
     * Update datetime each time web page is requested.
     */

    protected function active(Field $field)
    {
        $field->dateTime()->notNull();
    }

}