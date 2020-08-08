<?php

namespace Rasmus\Database;

use Rasmus\App\Config;
use Rasmus\Application;
use Rasmus\Util\Collection;
use Rasmus\Util\String\Str;

class DB
{
    /**
     * Return true if connection is established.
     */

    private static $connected = false;

    /**
     * Connection object.
     */

    private static $connection;

    /**
     * Tablename of the current request.
     */

    private $tablename;
    private $conn;

    private function __construct(string $tablename, $conn)
    {
        $this->tablename = $tablename;
        $this->conn = $conn;
    }

    /**
     * Execute an SQL query.
     */

    public function select($select = null)
    {
        if(is_null($select))
        {
            $select = '*';
        }

        return new SelectBuilder($this->tablename, $select);
    }

    /**
     * Return total rows of the table.
     */

    public function totalRows()
    {
        return DB::query('SELECT COUNT(*) AS total FROM ' . $this->tablename)->first()->total;
    }

    /**
     * Execute UPDATE SQL query.
     */

    public function update(array $data)
    {

    }

    /**
     * Execute INSERT SQL query.
     */

    public function insert(array $data)
    {

    }

    /**
     * Execute DELETE SQL query.
     */

    public function delete()
    {

    }

    /**
     * Truncate table.
     */

    public function truncate()
    {
        $test = DB::query('SELECT * FROM ' . $this->tablename);

        if(!$test->empty())
        {
            DB::query('TRUNCATE TABLE `' . $this->tablename . '`');
            $this->reset();
        }
    }

    /**
     * Reset table autoincrement.
     */

    public function reset()
    {
        DB::query('ALTER TABLE ' . $this->tablename . ' AUTO_INCREMENT = 1');
    }

    /**
     * If connection to database is established.
     */

    public static function connected()
    {
        return static::$connected;
    }

    /**
     * Return database connection data.
     */

    public static function data()
    {
        return Config::database();
    }

    /**
     * Return SQL driver.
     */

    public static function driver()
    {
        return static::data()->driver;
    }

    /**
     * Return server connection.
     */

    public static function host()
    {
        return static::data()->host;
    }

    /**
     * Return current database name.
     */

    public static function name()
    {
        return static::data()->database;
    }

    /**
     * Return authentication credentials.
     */

    public static function credentials()
    {
        return new Collection([

            'username' => static::data()->username,

            'password' => static::data()->password,

        ]);
    }

    /**
     * Return connection instance.
     */

    public static function context()
    {
        return static::$connection;
    }

    /**
     * Check if connection is established, if not
     * create a new connection.
     */

    private static function testConnection()
    {
        if(!static::connected() && is_null(static::$connection) && in_array(static::driver(), ['mysql', 'odbc']))
        {
            $make = static::makeConnection(static::driver(), static::host(), static::name(), static::credentials());

            if(!$make)
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Make new connection.
     */

    private static function makeConnection(string $driver, string $host, string $name, Collection $credentials)
    {
        $conn = null;

        if(strtolower($driver) === 'mysql')
        {
            $conn = mysqli_connect($host, $credentials->username, $credentials->password, $name);
        
            if(!$conn && !mysqli_ping($conn) && !mysqli_connect_errno($conn))
            {
                return false;
            }
        }

        static::$connected = true;
        static::$connection = $conn;

        Application::context()->database = true;

        return true;
    }

    /**
     * SQL select claus method.
     */

    public static function table(string $tablename)
    {
        if(static::testConnection())
        {
            return new self($tablename, static::context());
        }
    }

    /**
     * Execute SQL query.
     */

    public static function query(string $string)
    {
        if(static::testConnection())
        {
            $query = null;
            $conn = static::context();
            $driver = strtolower(static::driver());
            $start_time = microtime(true);
            
            if($driver === 'mysql')
            {
                $query = mysqli_query($conn, $string);
            }

            $end_time = microtime(true);

            if($query)
            {
                $select = false;

                if(Str::startWith(strtolower($string), 'select'))
                {
                    $select = true;
                }

                return new Response($start_time, $end_time, $driver, $select, $query, $conn);
            }
        }
    }

    /**
     * Sanitize string to prevent SQL injection.
     */

    public static function sanitize(string $string)
    {
        if(static::testConnection())
        {
            $driver = strtolower(static::driver());

            if($driver === 'mysql')
            {
                return mysqli_real_escape_string(static::context(), $string);
            }
        }
    }

    /**
     * Close database connection.
     */

    public static function close()
    {
        if(static::testConnection())
        {
            $driver = strtolower(static::driver());

            if($driver === 'mysql')
            {
                mysqli_close(static::context());
            }
        }
    }

}