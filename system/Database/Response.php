<?php

namespace Raccoon\Database;

use Raccoon\Util\Arr;
use Raccoon\Util\Collection;

class Response
{
    /**
     * Time query execution started.
     */

    private $start_time;

    /**
     * Time query execution ended.
     */

    private $end_time;

    /**
     * Return number of rows returned.
     */

    private $num = 0;

    private $affected_rows = 0;

    /**
     * Query result array.
     */

    private $result = [];

    /**
     * If query is success.
     */

    private $success = false;

    /**
     * Store query object.
     */

    private $object;

    public function __construct(float $start_time, float $end_time, string $driver, bool $select, $query, $conn)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->object = $query;

        if($query)
        {
            $this->success = true;
        }

        if($driver === 'mysql')
        {
            if($select)
            {
                $this->num = mysqli_num_rows($query);
                $this->affected_rows = mysqli_affected_rows($conn);

                if($this->num > 0)
                {
                    if($this->num === 1)
                    {
                        $this->result[] = mysqli_fetch_assoc($query);
                    }
                    else
                    {
                        while($row = mysqli_fetch_assoc($query))
                        {
                            $this->result[] = $row;
                        }
                    }
                }

                mysqli_free_result($query);
            }
        }
    }

    /**
     * Return query object.
     */

    public function getQueryObject()
    {
        return $this->object;
    }

    /**
     * Return true if query is success.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Return query result in array.
     */

    public function toArray()
    {
        return $this->result;
    }

    /**
     * Return query result in json format.
     */

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Return query result in array of collection object.
     */

    public function all()
    {
        $collections = [];

        if(!$this->empty())
        {
            foreach($this->toArray() as $result)
            {
                $collections[] = new Collection($result);
            }
        }

        if(sizeof($collections) === 1)
        {
            return $collections[0];
        }
        else
        {
            return $collections;
        }
    }

    /**
     * Return the very first result.
     */

    public function first()
    {
        if(!$this->empty())
        {
            return new Collection($this->toArray()[0]);
        }
    }

    /**
     * Return the very last result.
     */

    public function last()
    {
        if(!$this->empty())
        {
            return new Collection(Arr::last($this->toArray()));
        }
    }

    /**
     * Return result from specific index number.
     */

    public function get(int $index)
    {
        return new Collection($this->toArray()[$index]);
    }

    /**
     * Return results where field has value.
     */

    public function where(string $field, $value)
    {
        $results = [];

        foreach($this->all() as $result)
        {
            $val = $result->{$field};

            if($val === $value)
            {
                $results[] = $result;
            }
        }

        return $results;
    }

    /**
     * Return num rows.
     */

    public function numRows()
    {
        return $this->num;
    }

    /**
     * Return true if query has no result.
     */

    public function empty()
    {
        return $this->numRows() === 0;
    }

    /**
     * Return number of affected rows.
     */

    public function affectedRows()
    {
        return $this->affected_rows;
    }

    /**
     * Return how much time it takes for query
     * to execute.
     */

    public function duration()
    {
        $subtract = $this->end_time - $this->start_time;
    }

}