<?php

namespace Raccoon\File;

class ReadLine
{

    private $accepted_ext = ['txt', 'env'];

    /**
     * File to read.
     */

    protected $file;

    /**
     * Indicate if reading is successfull.
     */

    protected $success = false;

    /**
     * Store all lines from file reading.
     */

    private $line = [];

    /**
     * Check if file exist and readable and
     * start loading and reading the file.
     */

    public function __construct(string $file)
    {
        $this->file = $file;

        $reader = new Reader($file);

        if($reader->exist() && $reader->readable() && in_array($reader->type(), $this->accepted_ext))
        {
            $this->load();
        }
    }

    /**
     * Load file and return string line by line.
     */

    private function load()
    {
        $handle = fopen($this->file, 'r');
        
        if($handle)
        {

            while(!feof($handle))
            {
                $this->line[] = fgets($handle);                
            }

            fclose($handle);
            $this->success = true;
        }       
    }

    /**
     * Return true if reading is success.
     */

    public function success()
    {
        return $this->success;
    }

    /**
     * Return all lines.
     */

    public function all()
    {
        return $this->line;
    }

    /**
     * Return string from line number.
     */

    public function get(int $n)
    {
        return $this->line[$n];
    }

    /**
     * Return the first line.
     */

    public function first()
    {
        return $this->get(0);
    }

    /**
     * Return the last line.
     */

    public function last()
    {
        return $this->get($this->length() - 1);
    }

    /**
     * Return how many lines the file has.
     */

    public function length()
    {
        return sizeof($this->line);       
    }   

}