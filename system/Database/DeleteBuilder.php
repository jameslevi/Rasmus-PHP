<?php

namespace Raccoon\Database;

use Raccoon\Util\Str;

class DeleteBuilder extends WhereBuilder
{
    /**
     * Table to execute delete query.
     */

    private $tablename;

    protected $data = [

        'where' => [

            'enable' => false,

            'raw' => null,

            'items' => [],

        ],

    ];

    public function __construct(string $tablename)
    {
        $this->tablename = $tablename;
    }

    /**
     * Return DELETE sql query.
     */

    public function sql()
    {
        $sql = 'DELETE FROM ' . $this->tablename . ' ';

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
     * Execute DELETE query.
     */

    public function exec()
    {
        return DB::query($this->sql());
    }

}