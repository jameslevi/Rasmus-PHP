<?php

namespace Rasmus\Database;

use Rasmus\Util\Str;

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

        'where' => [

            'enable' => false,

            'raw' => null,

            'items' => [],

        ],

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
     * Set raw SQL WHERE claus.
     */

    public function where(string $raw = null)
    {
        if(!is_null($raw))
        {
            $this->data['where']['raw'] = $raw;
        }
        
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

        $where = $this->data['where'];

        if(!is_null($where['raw']))
        {
            $sql .= 'WHERE ' . $this->data['where']['raw'] . ' ';
        }
        else if(!empty($where['items']))
        {
            $sql .= 'WHERE ';

            foreach($where['items'] as $data)
            {
                if(!$where['enable'])
                {
                    $where['enable'] = true;
                    $this->data['where']['enable'] = true;
                    if(Str::startWith($data, 'AND '))
                    {
                        $data = Str::move($data, 4);
                    }
                }

                $sql .= $data;
            }
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
            $sql = Str::move($sql, 0, 1);
        }

        return $sql;
    }

    /**
     * Return only the first result.
     */

    public function first()
    {
        return $this->limit(0, 1)->get();
    }

    /**
     * Return random result.
     */

    public function pick()
    {
        return $this->random()->limit(0, 1)->get();
    }

    /**
     * Evaluate SQL build and return resulting object.
     */

    public function get()
    {
        return DB::query($this->sql());
    }

}