<?php

namespace core;
use \PDO;
use \PDOException;

class Database{
    static protected $instance;
    public $pdo;

    /**
    * @var PDO
    */
    protected $connection;

    protected function __construct() {
        // create pdo instance and assign to $this->pdo
        $this->pdo = new PDO("mysql:dbname=".$_ENV['DB_NAME'].";charset=utf8;host=".$_ENV['HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    }

    public static function getInstance() {
        if(!self::$instance) {
            // get the arguments to the constructor from configuration somewhere
            self::$instance = new self();
        }

        return self::$instance;
    }

    // proxy calls to non-existant methods on this class to PDO instance
    public function __call($method, $args) {
        $callable = array($this->pdo, $method);
        if(is_callable($callable)) {
            return call_user_func_array($callable, $args);
        }
    }
}
?>