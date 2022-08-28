<?php
require_once "dbconfig.php";

class M_user extends Db_config
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

    public function redirect_to($new_location)
    {
        header("Location:" . $new_location);
        exit;
    }

    public function read()
    {
        $query = "SELECT * FROM $this->table";
        $result = $this->connection->query($query);
        return $result;
    }

    public function read_by_id($username)
    {
        $safe_id = $this->mysql_prep($username);
        $query = "SELECT * FROM $this->table WHERE username = '{$safe_id}'";
        $result = $this->connection->query($query);
        return $result;
    }

    public function update()
    {
        $safe_id = $this->mysql_prep($_POST['username']);
        $nama = $this->mysql_prep($_POST['nama']);
        $level = $this->mysql_prep($_POST['level']);
        $query = "UPDATE $this->table set ";
        $query .= "nama = '{$nama}'";
        $query .= ", level = '{$level}'";
        if (!empty($_POST['password'])) {
            $password = md5($this->mysql_prep($_POST['password']));
            $query .= ", password = '{$password}'";
        }
        $query .= "WHERE username = '{$safe_id}' LIMIT 1";
        $result = $this->connection->query($query);
        if (!$result) {
            $msg = "Failed " . mysqli_error($this->connection);
            return $msg;
        } else {
            return $result;
        }
    }

    public function delete($username)
    {
        $safe_id = $this->mysql_prep($username);
        $query = "DELETE FROM $this->table WHERE username = '{$safe_id}'";
        $result = $this->connection->query($query);
        if (!$result) {
            $msg = "Failed " . mysqli_error($this->connection);
            return $msg;
        } else {
            return $result;
        }
    }

    public function create()
    {
        $query = "INSERT INTO $this->table ";
        $fields = "";
        $values = "";
        $i = 0;
        foreach ($_POST as $key => $value) {
            if ($i === 0) // first loop
            {
                $fields .= '(';
                $values .= '(';
            }
            $fields .= "$key";
            $prep = $this->mysql_prep($value);
            if ($key == 'password') {
                $prep = md5($prep);
                $values .= "'{$prep}'";
            } else {
                $values .= "'{$prep}'";
            }
            if (count($_POST) - 1 != $i) //not last loop
            {
                $fields .= ',';
                $values .= ',';
            }
            if (count($_POST) - 1 == $i) //last loop
            {
                $fields .= ')';
                $values .= ')';
            }
            $i++;
        }
        $query .= $fields;
        $query .= " VALUES ";
        $query .= $values;
        $result = $this->connection->query($query);
        if (!$result) {
            $msg = "Failed " . mysqli_error($this->connection);
            return $msg;
        } else {
            return $result;
        }
    }

}
