<?php

namespace Raccoon\Database;

use Raccoon\Util\Arr;
use Raccoon\Util\Str;

abstract class Service
{
    /**
     * Empty date field must contain this string.
     */

    private static $empty_date = '0000-00-00 00:00:00';

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
     * Return list of columns of the table.
     */

    protected function columns()
    {
        return $this->table()->columns();
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
     * Return total rows of table.
     */

    protected function rows()
    {
        return (int)$this->select('COUNT(*) AS total_count')->get()->first()->total_count;
    }

    /**
     * If table has no records.
     */

    protected function isEmpty()
    {
        return $this->rows() === 0;
    }

    /**
     * Return row by index.
     */

    protected function get(int $index = 0, array $field = null)
    {
        return $this->select($field)->limit($index, 1)->get();
    }

    /**
     * Test if value exist from specific field.
     */

    protected function has(string $field, $value)
    {
        return !$this->select('id')->equal($field, $value)->get()->empty();
    }

    /**
     * Return paginated results.
     */

    protected function paginate(int $page, int $per_page, array $field = null)
    {
        return $this->select($field)->limit($page, $per_page)->get();
    }

    /**
     * Return the first row.
     */

    protected function first()
    {
        return $this->get(0);
    }

    /**
     * Return the very last row.
     */

    protected function last()
    {
        return $this->get($this->rows() - 1);
    }

    /**
     * Return row by id.
     */

    protected function getById(int $id = 1, array $fields = null)
    {
        return $this->select($fields)->equal('id', $id)->limit(0, 1)->get()->first();
    }

    /**
     * Return sum of selected integer field.
     */

    protected function sum(string $field)
    {
        return $this->select('SUM(' . $field . ') AS total_sum')->get()->first()->total_sum;
    }

    /**
     * Return average of selected integer field.
     */

    protected function ave(string $field)
    {
        return $this->select('AVG(' . $field . ') AS average')->get()->first()->average;
    }

    /**
     * Return the lowest numerical value.
     */

    protected function min(string $field)
    {
        return $this->select('MIN(' . $field . ') AS min_value')->get()->first()->min_value;
    }

    /**
     * Return the highest numerical value.
     */

    protected function max(string $field)
    {
        return $this->select('MAX(' . $field . ') AS max_value')->get()->first()->max_value;
    }

    /**
     * Insert new records.
     */

    protected function insert(array $data)
    {
        return $this->table()->insert($data)->exec();
    }

    /**
     * Update existing records.
     */

    protected function update(array $data)
    {
        return $this->table()->update($data);
    }

    /**
     * Update all field value.
     */

    protected function setAll(string $name, $value)
    {
        return $this->table()->update([ $name => $value ])->exec();
    }

    /**
     * Update records by id.
     */

    protected function updateById(int $id, array $data)
    {
        return $this->update($data)->equal('id', $id)->exec();
    }

    /**
     * Set single column from a single row.
     */

    protected function setById(int $id, string $name, $value)
    {
        return $this->update([ $name => $value ])->equal('id', $id)->exec();
    }

    /**
     * Delete records.
     */

    protected function delete()
    {
        return $this->table()->delete();
    }

    /**
     * Delete records by id.
     */

    protected function deleteById(int $id)
    {
        return $this->delete()->equal('id', $id)->exec();
    }

    /**
     * Test if row is already edited.
     */

    protected function isEdited(int $id)
    {
        return $this->select(['updated'])->equal('id', $id)->equal('updated', static::$empty_date)->get()->empty();
    }

    /**
     * Return list of edited rows.
     */

    protected function edited()
    {
        return $this->select(['id', 'updated'])->notEqual('updated', static::$empty_date)->get()->all();
    }

    /**
     * Test if rows is soft deleted.
     */

    protected function isDeleted(int $id)
    {
        return !$this->select(['deleted'])->equal('id', $id)->equal('deleted', static::$empty_date)->get()->empty();
    }

    /**
     * Return list of deleted rows.
     */

    protected function deleted()
    {
        return $this->select(['id', 'deleted'])->notEqual('deleted', static::$empty_date)->get()->all();
    }

    /**
     * Test if column is null.
     */

    protected function isNull(int $id, string $field)
    {
        return empty($this->select([$field])->equal('id', $id)->get()->first()->{$field});
    }

    /**
     * Mark row as deleted.
     */

    protected function softDelete(int $id)
    {
        return $this->setById($id, 'deleted', 'NOW()');
    }

    /**
     * Unmark rows as deleted.
     */

    protected function unDelete(int $id)
    {
        return $this->setById($id, 'deleted', static::$empty_date);
    }

    /**
     * Soft delete all rows.
     */

    protected function softDeleteAll()
    {
        return $this->setAll('deleted', 'NOW()');
    }

}