<?php

namespace Raccoon\Database;

use Raccoon\Util\Arr;
use Raccoon\Util\Str;

abstract class Model
{
    /**
     * Store current model to evaluate.
     */

    private $current_model;

    /**
     * Methods not table columns.
     */

    private $except = [
        '__construct',
        '__callStatic',
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
        return strtolower(Arr::last(explode('\\', get_class($this))));
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
            array_push($this->fields, 'created', 'updated', 'deleted');

            $sql = 'CREATE TABLE ' . $this->getName() . ' (';
            $primary_key = null;

            foreach($this->fields as $field)
            {
                $this->current_model = new Field($field);
                $this->{$field}($this->current_model);
                
                if(method_exists($this, $field))
                {
                    $parse = $this->current_model->getData();
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

    private function id(Field $field)
    {
        $field->int();
        $field->autoIncrement();
        $field->primaryKey();
    }

    /**
     * Date and time when row is created.
     */

    private function created(Field $field)
    {
        $field->dateTime();
        $field->notNull();
        $field->default();
        $field->currentTimestamp();
    }

    /**
     * Update datetime each time data is updated.
     */

    private function updated(Field $field)
    {
        $field->dateTime();
        $field->notNull();
        $field->onUpdate();
        $field->currentTimestamp();
    }

    /**
     * Date and time indicating that row is already deleted.
     */

    private function deleted(Field $field)
    {
        $field->dateTime();
        $field->notNull();
    }

    /**
     * Call dynamic static services methods.
     */

    public static function __callStatic(string $name, $arguments)
    {
        $class = 'Database\Service\\' . Arr::last(explode('\\', static::class));
        $instance = new $class();
        
        return $instance->call($name, $arguments);
    }

}