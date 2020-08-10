<?php

namespace Rasmus\Database;

class UpdateBuilder extends WhereBuilder
{
    protected $tablename;
    protected $data = [];

    public function __construct(string $tablename, array $data = [])
    {
        $this->tablename = $tablename;
        $this->data = $data;
    }

}