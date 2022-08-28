<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "arsip-kmp");

class Db_config
{

    protected $connection;

    public function __construct()
    {
        if (!isset($this->connection)) {
            // $this->connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_dbname);
            $this->connection = new mysqli(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASS"), constant("DB_NAME"));
            if (!$this->connection) {
                echo "Error connecting database server";
            }
        }
        return $this->connection;
    }
}
