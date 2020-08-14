<?php

namespace Raccoon\File;

class Reader
{

    /**
     * Location of file.
     */

    protected $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Return string content.
     */

    public function contents()
    {
        return file_get_contents($this->file);
    }

    /**
     * Overwrite file content.
     */

    public function overwrite(string $data)
    {
        file_put_contents($this->file, $data);
    }

    /**
     * Append data at the end of file content.
     */

    public function append(string $data)
    {
        file_put_contents($this->file, $data, FILE_APPEND);
    }

    /**
     * Return file name.
     */

    public function name()
    {
        return pathinfo($this->file)['filename'];
    }

    /**
     * Return true if file exist.
     */

    public function exist()
    {
        return file_exists($this->file);
    }

    /**
     * Return true if file is readable.
     */

    public function readable()
    {
        return is_readable($this->file);
    }

    /**
     * Return file type.
     */

    public function type()
    {
        if($this->exist())
        {
            return pathinfo($this->file)['extension'];
        }
    }

    /**
     * Return file size in bites.
     */

    public function size()
    {
        return filesize($this->file);
    }

    /**
     * Delete file.
     */

    public function delete()
    {
        if($this->exist())
        {
            unlink($this->file);
        }
    }

}