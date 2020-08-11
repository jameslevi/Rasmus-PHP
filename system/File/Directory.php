<?php

namespace Raccoon\File;

class Directory
{

    /**
     * Directory path.
     */

    private $path;

    public function __construct(string $path)
    {
        $this->path = './' . $path;
    }

    /**
     * Return path.
     */

    public function getPath()
    {
        return $this->path;
    }

    /**
     * Return true if path is a valid directory.
     */

    public function valid()
    {
        return is_dir($this->path);
    }

    /**
     * Return array of files.
     */

    public function files()
    {
        return array_diff(scandir($this->path), array('.', '..'));
    }

    /**
     * Return array of folder names.
     */

    public function folders()
    {
        
    }

    /**
     * Return how many files the directory contain.
     */

    public function count()
    {
        return sizeof($this->files());       
    }

}