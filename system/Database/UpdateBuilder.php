<?php

namespace Raccoon\Database;

use Raccoon\Util\Str;

class UpdateBuilder extends WhereBuilder
{
    /**
     * Name of table to update.
     */

    protected $tablename;

    /**
     * Data to update.
     */

    protected $data = [

        'set' => [],

        'where' => [

            'enable' => false,

            'raw' => null,

            'items' => [],

        ],

    ];

    public function __construct(string $tablename, array $data)
    {
        $this->tablename = $tablename;
        $this->data['set'] = $data;
    }

    /**
     * Return UPDATE query sql.
     */

    public function sql()
    {
        $sql = 'UPDATE ' . $this->tablename . ' SET ';

        if(!empty($this->data['set']))
        {
            foreach($this->data['set'] as $key => $val)
            {
                if(is_string($val))
                {
                    $sql .= $key . " = '" . DB::sanitize($val) . "', ";
                }
                else if(is_int($val) || is_bool($val))
                {
                    $sql .= $key . " = " . DB::sanitize($val) . ", ";
                }
            }

            if(Str::endWith($sql, ', '))
            {
                $sql = Str::move($sql, 0, 2) . ' ';
            }
        }

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

        if(Str::endWith($sql, ' '))
        {
            $sql = Str::move($sql, 0, 1);
        }

        return $sql;
    }

    /**
     * Execute UPDATE query.
     */

    public function exec()
    {
        return DB::query($this->sql());
    }

}