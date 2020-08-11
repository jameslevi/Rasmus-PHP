<?php

namespace Rasmus\Database;

use Rasmus\Util\Str;

class InsertBuilder
{
    /**
     * Current table.
     */

    private $tablename;

    /**
     * Data collection to insert.
     */

    private $data = [];

    public function __construct(string $tablename, array $data)
    {
        $this->tablename = $tablename;
        $this->data[] = $data;
    }

    /**
     * Insert new data set.
     */

    public function insert(array $data)
    {
        $this->data[] = $data;
        return $this;
    }

    /**
     * Return SQL build.
     */

    public function sql()
    {
        $sql = [];

        foreach($this->data as $data)
        {
            $build = 'INSERT INTO ' . $this->tablename . ' (';

            foreach($data as $key => $value)
            {
                $build .= '`' . $key . '`,';
            }

            if(Str::endWith($build, ','))
            {
                $build = Str::move($build, 0, 1);
            }

            $build .= ') VALUES(';

            foreach($data as $value)
            {
                if(is_int($value) || is_bool($value))
                {
                    $build .= DB::sanitize($value) . ',';
                }
                else
                {
                    $build .= "'" . DB::sanitize($value) . "',";
                }
            }

            if(Str::endWith($build, ','))
            {
                $build = Str::move($build, 0, 1);
            }

            $build .= ')';

            $sql[] = $build;
        }

        if(sizeof($this->data) > 1)
        {
            return $sql;
        }
        else
        {
            return $sql[0];
        }
    }

    /**
     * Save data to insert.
     */

    public function exec()
    {
       $sql = $this->sql();
       $num = 0;

       if(is_string($sql))
       {
           $sql = [$sql];
       }

       foreach($sql as $item)
       {
           $exec = DB::query($item);

           if($exec)
           {
               $num++;
           }
       }

       if($num === sizeof($sql))
       {
           return true;
       }

       return false;
    }

}