<?php

namespace Rasmus\Database;

class Field
{
    /**
     * Column data.
     */

    private $data = [
        'name' => null,
        'type' => 'varchar',
        'value' => null,
        'optional' => [],
    ];

    /**
     * Just set field name.
     */

    public function __construct(string $name)
    {
        $this->data['name'] = $name;
    }

    /**
     * Set field type to int.
     */

    public function int(int $size = null)
    {
        $this->data['type'] = 'INT';
        $this->data['value'] = $size;

        return $this;
    }

    /**
     * Same as int.
     */

    public function integer(int $size = null)
    {
        return $this->int($size);
    }

    /**
     * Set field type to char.
     */

    public function char(int $length = 1)
    {
        $this->data['type'] = 'CHAR';
        $this->data['value'] = $length;
        
        return $this;
    }

    /**
     * Set field type to varchar.
     */

    public function varChar(int $length = 255)
    {
        $this->data['type'] = 'VARCHAR';
        $this->data['value'] = $length;
        
        return $this;
    }

    /**
     * Set field type to binary.
     */

    public function binary(int $length = 1)
    {
        $this->data['type'] = 'BINARY';
        $this->data['value'] = $length;
        
        return $this;
    }

    /**
     * Set field type to varbinary.
     */

    public function varBinary(int $length = 255)
    {
        $this->data['type'] = 'VARBINARY';
        $this->data['value'] = $length;
        
        return $this;
    }

    /**
     * Set field type to tiny blob.
     */

    public function tinyBlob()
    {
        $this->data['type'] = 'TINYBLOB';
        return $this;
    }

    /**
     * Set field type to tiny text.
     */

    public function tinyText()
    {
        $this->data['type'] = 'TINYTEXT';
        return $this;
    }

    /**
     * Set field type to text.
     */

    public function text()
    {
        $this->data['type'] = 'TEXT';
        return $this;
    }

    /**
     * Set field type to blob.
     */

    public function blob()
    {
        $this->data['type'] = 'BLOB';
        return $this;
    }

    /**
     * Set field type to medium text.
     */

    public function mediumText()
    {
        $this->data['type'] = 'MEDIUMTEXT';
        return $this;
    }

    /**
     * Set field type to medium blob.
     */

    public function mediumBlob()
    {
        $this->data['type'] = 'MEDIUMBLOB';
        return $this;
    }

    /**
     * Set field type to long text.
     */

    public function longText()
    {
        $this->data['type'] = 'LONGTEXT';
        return $this;
    }

    /**
     * Set field type to long blob.
     */

    public function longBlob()
    {
        $this->data['type'] = 'LONGBLOB';
        return $this;
    }

    /**
     * Set field type to bit.
     */

    public function bit(int $size = 1)
    {
        $this->data['type'] = 'BIT';
        $this->data['value'] = $size;
        
        return $this;
    }

    /**
     * Set field type to tiny int.
     */

    public function tinyInt(int $size)
    {
        $this->data['type'] = 'TINYINT';
        $this->data['value'] = $size;
        
        return $this;
    }

    /**
     * Set field type to bool.
     */

    public function bool()
    {
        $this->data['type'] = 'BOOL';
        return $this;
    }

    /**
     * Set field type to boolean.
     */

    public function boolean()
    {
        $this->bool();
        return $this;
    }

    /**
     * Set field type to small int.
     */

    public function smallInt(int $size)
    {
        $this->data['type'] = 'SMALLINT';
        $this->data['value'] = $size;
        
        return $this;
    }

    /**
     * Set field type to medium int.
     */

    public function mediumInt(int $size)
    {
        $this->data['type'] = 'MEDIUMINT';
        $this->data['value'] = $size;
        
        return $this;
    }

    /**
     * Set field type to big int.
     */

    public function bigInt(int $size)
    {
        $this->data['type'] = 'BIGINT';
        $this->data['value'] = $size;

        return $this;
    }

    /**
     * Set field type to date.
     */

    public function date()
    {
        $this->data['type'] = 'DATE';

        return $this;
    }

    /**
     * Set field type to datetime.
     */

    public function dateTime()
    {
        $this->data['type'] = 'DATETIME';

        return $this;
    }

    /**
     * Set field type to timestamp.
     */

    public function timeStamp()
    {
        $this->data['type'] = 'TIMESTAMP';

        return $this;
    }

    /**
     * Set field type to time.
     */

    public function time()
    {
        $this->data['type'] = 'TIME';

        return $this;
    }

    /**
     * Set field type to year.
     */

    public function year()
    {
        $this->data['type'] = 'YEAR';

        return $this;
    }

    /**
     * Set numeric type fields to unsigned.
     */

    public function unsigned()
    {
        $this->data['optional'][] = 'UNSIGNED';
        return $this;
    }

    /**
     * Set field as unique.
     */

    public function unique()
    {
        $this->data['optional'][] = 'UNIQUE';
        return $this;
    }

    /**
     * Set field as not null.
     */

    public function notNull()
    {
        $this->data['optional'][] = 'NOT NULL';
        return $this;
    }

    /**
     * Set integer value to automatically increment.
     */

    public function autoIncrement()
    {
        $this->data['optional'][] = 'AUTO_INCREMENT';
        return $this;
    }

    /**
     * Set date and time to current timestamp.
     */

    public function currentTimestamp()
    {
        $this->data['optional'][] = 'CURRENT_TIMESTAMP';
        return $this;
    }

    /**
     * Set default value when no value is passed.
     */

    public function default()
    {
        $this->data['optional'][] = 'DEFAULT';
        return $this;
    }

    /**
     * Update value when row is changed.
     */

    public function onUpdate()
    {
        $this->data['optional'][] = 'ON UPDATE';
        return $this;
    }

    /**
     * Set field as primary key.
     */

    public function primaryKey()
    {
        $this->data['optional'][] = 'PRIMARY KEY';
        return $this;
    }

    /**
     * Return field data.
     */

    public function getData()
    {
        return $this->data;
    }

}