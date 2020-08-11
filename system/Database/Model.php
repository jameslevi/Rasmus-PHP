<?php

namespace Rasmus\Database;

use Rasmus\Util\String\Str;

abstract class Model
{
    /**
     * Methods not table columns.
     */

    private $except = [
        '__construct',
        'id',
        'created',
        'updated',
        'deleted',
        'create',
        'drop',
        'getName',
        'getFields',
    ];

    /**
     * List of table fields represented
     * by class methods.
     */

    private $fields = [];

    /**
     * Evaluate model fields.
     */

    public function __construct()
    {
        $methods = get_class_methods($this);
        $fields = [];

        foreach($methods as $method)
        {
            if(!in_array($method, $this->except))
            {
                $fields[] = $method;
            }
        }

        $this->fields = $fields;
    }

    /**
     * Return table name.
     */

    public function getName()
    {
        $split = explode('\\', get_class($this));

        return $split[sizeof($split) - 1];
    }

    /**
     * Return table fields.
     */

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Create new model table.
     */

    public function create()
    {
        if(!empty($this->fields))
        {
            array_unshift($this->fields, 'id');
            $this->fields[] = 'created';
            $this->fields[] = 'updated';
            $this->fields[] = 'deleted';

            $sql = 'CREATE TABLE ' . strtolower($this->getName()) . ' (';
            $primary_key = null;

            foreach($this->fields as $field)
            {
                $parse = $this->{$field}(new Field($field))->getData();
                $sql .= $field . ' ';

                if(!is_null($parse['type']))
                {
                    $sql .= strtoupper($parse['type']);

                    if(!is_null($parse['value']))
                    {
                        $sql .= '(' . $parse['value'] . ')';
                    }
                }

                if(!empty($parse['optional']))
                {
                    $sql .= ' ';

                    foreach($parse['optional'] as $optional)
                    {
                        if($optional !== 'PRIMARY KEY')
                        {
                            $sql .= strtoupper($optional) . ' ';
                        }
                        else
                        {
                            $primary_key = $field;
                        }
                    }

                    if(Str::endWith($sql, ' '))
                    {
                        $sql = Str::move($sql, 0, 1);
                    }
                }

                $sql .= ', ';
            }

            $sql .= 'PRIMARY KEY(' . $primary_key . '))';

            return DB::query($sql);
        }
    }

    /**
     * Drop table.
     */

    public function drop()
    {
        return DB::table($this->getName())->drop();
    }

    /**
     * Default row id.
     */

    protected function id(Field $field)
    {
        $field->int();
        $field->autoIncrement();
        $field->primaryKey();

        return $field;
    }

    /**
     * Date and time when row is created.
     */

    protected function created(Field $field)
    {
        $field->dateTime();
        $field->notNull();
        $field->default();
        $field->currentTimestamp();

        return $field;
    }

    /**
     * Update datetime each time data is updated.
     */

    protected function updated(Field $field)
    {
        $field->dateTime();
        $field->notNull();
        $field->onUpdate();
        $field->currentTimestamp();
        
        return $field;
    }

    /**
     * Date and time indicating that row is already deleted.
     */

    protected function deleted(Field $field)
    {
        $field->dateTime();
        $field->notNull();

        return $field;
    }

}