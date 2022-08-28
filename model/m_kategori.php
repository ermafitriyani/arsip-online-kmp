<?php
require_once "dbconfig.php";

class M_kategori extends Db_config
{
    public $table = 'tbl_kategori_dokumen';

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

    public function read($where = array())
    {
        $query = "SELECT * FROM $this->table";
        $conditions = [];
        if (!empty($where['status'])) {
            if (!empty($where['or_id_kategori'])) {
                $conditions[] = "(status = '$where[status]' OR id = '$where[or_id_kategori]')";
            } else {
                $conditions[] = "status = '$where[status]'";
            }
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $result = $this->connection->query($query);
        return $result;
    }

    public function read_by_id($id)
    {
        $safe_id = $this->mysql_prep($id);
        $query = "SELECT * FROM $this->table WHERE id = '{$safe_id}'";
        $result = $this->connection->query($query);
        return $result;
    }

    public function update()
    {
        $safe_id = $this->mysql_prep($_POST['id']);
        $nama_kategori = $this->mysql_prep($_POST['nama_kategori']);
        $status = $this->mysql_prep($_POST['status']);
        $query = "UPDATE $this->table set ";
        $query .= "nama_kategori = '{$nama_kategori}'";
        $query .= ",status = '{$status}'";
        $query .= "WHERE id = '{$safe_id}' LIMIT 1";
        $result = $this->connection->query($query);
        if (!$result) {
            $msg = "Failed " . mysqli_error($this->connection);
            return $msg;
        } else {
            return $result;
        }
    }

    public function delete($id)
    {
        $safe_id = $this->mysql_prep($id);
        $query = "DELETE FROM $this->table WHERE id = '{$safe_id}'";
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
            $values .= "'{$prep}'";
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
