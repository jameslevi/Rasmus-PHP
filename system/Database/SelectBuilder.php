<?php

namespace Rasmus\Database;

use Rasmus\Util\String\Str;

class SelectBuilder extends WhereBuilder
{
    /**
     * Table name to select.
     */

    protected $tablename;

    /**
     * Select data components.
     */

    protected $data = [

        'distinct' => false,

        'return' => '*',

        'where' => [],

        'binary' => false,

        'order' => [

            'field' => null,

            'dir' => 'desc',

        ],

        'limit' => [

            'enable' => false,

            'index' => 0,

            'length' => 1,

        ],

    ];

    public function __construct(string $tablename, $select)
    {
        $this->tablename = $tablename;
        $this->data['return'] = $select;
    }

    /**
     * Set distict to true.
     */

    public function distinct()
    {
        $this->data['distinct'] = true;
        return $this;
    }

    /**
     * Return result in random order.
     */

    public function random()
    {
        $this->data['order']['dir'] = 'random';
        return $this;
    }

    /**
     * Set result in descending order.
     */

    public function desc($fields)
    {
        $this->data['order']['dir'] = 'desc';
        $this->data['order']['field'] = $fields;
        return $this;
    }

    /**
     * Set result in ascending order.
     */

    public function asc($fields)
    {
        $this->data['order']['dir'] = 'asc';
        $this->data['order']['field'] = $fields;
        return $this;
    }

    /**
     * Set result limit.
     */

    public function limit(int $index, int $length)
    {
        $this->data['limit']['enable'] = true;
        $this->data['limit']['index'] = $index;
        $this->data['limit']['length'] = $length;
        return $this;
    }

    /**
     * Generate SQL query for SELECT operation.
     */

    public function sql()
    {
        $sql = 'SELECT ';

        /**
         * DISTINCT
         */

        if($this->data['distinct'])
        {
            $sql .= 'DISTINCT ';
        }

        $return =  $this->data['return'];

        /**
         * SELECT FIELDS
         */

        if(is_string($return))
        {
            if($return === '*')
            {
                $return = '*';
            }
            else
            {
                if(Str::endWith($return, ','))
                {
                    $return = Str::move($return, 0, 1);
                }
            }

            $sql .= $return . ' ';
        }
        else if(is_array($return))
        {
            $sql .= implode(',', $return) . ' ';
        }

        $sql .= 'FROM ' . $this->tablename . ' ';

        /**
         * WHERE
         */

        if(!empty($this->data['where']))
        {
            $sql .= 'WHERE ';
        }

        /**
         * ORDER BY
         */

        $dir = $this->data['order']['dir'];

        if(strtolower($dir) === 'random')
        {
            $sql .= ' ORDER BY RAND()';
        }
        else
        {
            $fields = $this->data['order']['field'];

            if(!is_null($fields))
            {
                if($dir === 'desc' || $dir === 'asc')
                {
                    $sql .= 'ORDER BY ';
                    
                    if(is_string($fields))
                    {
                        if(Str::endWith($fields, ','))
                        {
                            $fields = Str::move($fields, 0, 1);
                        }

                        $sql .= $fields . ' ' . strtoupper($dir) . ' ';
                    }
                    else if(is_array($fields))
                    {
                        $sql .= implode(',', $fields) . ' ' . strtoupper($dir) . ' ';
                    }
                }
            }
        }

        /**
         * LIMIT
         */

        if($this->data['limit']['enable'])
        {
            $sql .= 'LIMIT ' . $this->data['limit']['index'] . ', ' . $this->data['limit']['length'];
        }

        if(Str::endWith($sql, ' '))
        {
            $sql .= Str::move($sql, 0, 1);
        }

        return $sql;
    }

    /**
     * Evaluate SQL build and return resulting object.
     */

    public function get()
    {
        $sql = $this->sql();

        return $this;
    }

}