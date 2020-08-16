<?php

namespace Raccoon\Database;

use Raccoon\Util\Arr;
use Raccoon\Util\Str;

abstract class Service
{
    /**
     * Call service methods.
     */

    public function call(string $method, array $arguments)
    {
        if(method_exists($this, $method))
        {
            $eval = null;
            $call = "$" . "eval = $" . "this->" . $method . "(";
            
            for($i = 0; $i <= (sizeof($arguments) - 1); $i++)
            {
                $call .= "$" . "arguments[" . $i . "],";
            }

            if(Str::endWith($call, ','))
            {
                $call = Str::move($call, 0, 1);
            }

            $call .= ");";

            eval($call);

            return $eval;
        }
    }

    /**
     * Return tablename.
     */
    
    protected function tablename()
    {
        $split = explode('\\', get_class($this));

        return strtolower(Arr::last($split));
    }

    /**
     * Return table instance.
     */

    protected function table()
    {
        return DB::table($this->tablename());
    }

    /**
     * Execute select query.
     */

    protected function select($select = '*')
    {
        return $this->table()->select($select);
    }

    /**
     * Return all rows.
     */

    protected function all(array $fields = null)
    {
        return $this->select($fields)->get()->all();
    }

    /**
     * Return row by id.
     */

    protected function getById(int $id = 1, array $fields = null)
    {
        return $this->select($fields)->equal('id', $id)->limit(0, 1)->get();
    }

    /**
     * Insert new records.
     */

    protected function insert(array $data)
    {
        return $this->table()->insert($data)->exec();
    }

}