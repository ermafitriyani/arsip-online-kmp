<?php
require_once "dbconfig.php";

class M_login extends Db_config
{
    public $table = 'tbl_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function mysql_prep($string)
    {
        return $this->connection->real_escape_string($string);
    }

    public function cek_login()
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = "SELECT * FROM $this->table WHERE username = '{$username}' AND password = '{$password}'";
        $result = $this->connection->query($query);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

}
