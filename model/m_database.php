<?php
require_once "dbconfig.php";

class M_database extends Db_config
{
    public $table = 'tbl_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function redirect_to($new_location)
    {
        header("Location:" . $new_location);
        exit;
    }

    /**
     * Fungsi backup database.
     */
    public function backup($tables = "*")
    {
        //untuk koneksi database
        $isi_file_backup = "";
        $link = mysqli_connect(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASS"), constant("DB_NAME"));

        //backup semua tabel database
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            //backup tabel tertentu
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        //looping table
        foreach ($tables as $table) {
            $result = mysqli_query($link, 'SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);

            $isi_file_backup .= 'DROP TABLE ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
            $isi_file_backup .= "\n\n" . $row2[1] . ";\n\n";

            //looping field table
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $isi_file_backup .= 'INSERT INTO ' . $table . ' VALUES(';

                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\n", $row[$j]);

                        if (isset($row[$j])) {
                            $isi_file_backup .= '"' . $row[$j] . '"';
                        } else {
                            $isi_file_backup .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $isi_file_backup .= ',';
                        }
                    }
                    $isi_file_backup .= ");\n";
                }
            }
            $isi_file_backup .= "\n\n\n";
        }

        $target_dir = "uploads/db_backup/";
        $filecount = 0;
        $urutan_file = 1;
        $files = glob($target_dir . "*");
        if ($files) {
            $filecount = count($files);
            $urutan_file = $filecount + 1;
        }
        // $filename = $urutan_file . '_' . constant("DB_NAME") . '_' . date("Y-m-d_His") . '.sql';
        $filename = constant("DB_NAME") . '_' . date("Y-m-d_His") . '.sql';
        // Jika folder tidak ada buat folder
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
            chmod($target_dir, 0777);
        }
        $target_file = $target_dir . $filename;
        if (!file_exists($target_dir)) {
            return array("message" => "The Folder is not exists", "error" => 1);
        }
        if (!is_writable(dirname($target_file))) {
            return array("message" => "The Folder is not writable", "error" => 1);
        }

        $handle = fopen($target_file, 'w+');
        // if (!$handle = fopen($filename, 'a')) {
        if (!$handle) {
            return array("message" => "Cannot open file ($filename)", "error" => 1);
        }
        if (!is_writable($filename)) {
            return array("message" => "The File is not writable", "error" => 1);
        }
        if (fwrite($handle, $isi_file_backup) === false) {
            return array("message" => "Cannot write to file ($filename)", "error" => 1);
        }
        fclose($handle);
        if (file_exists($target_file)) {
            // error_reporting(0); //Errors may corrupt download
            // ob_start();
            header('Content-Disposition: attachment; filename=' . $filename);
            ob_clean();
            flush(); //Modify flush() to ob_end_flush();
            readfile($target_file);
            unlink($target_file);
            exit;
        }
    }

    public function restore()
    {
        if (empty($_FILES['file']['name'])) {
            return array("message" => "File wajib diisi", "error" => 1);
        }
        $koneksi = mysqli_connect(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASS"), constant("DB_NAME"));

        $target_dir = "../uploads/db_backup/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

        $password = $_POST['password'];
        $username = $_SESSION['username'];

        $query = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username='$username' AND password=MD5('$password')");
        if (mysqli_num_rows($query) < 1) {
            return array("message" => "Password anda salah.", "error" => 1);
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            return array("message" => $msg, "error" => 1);
        }

        // Check file size
        // MAXIMAL FILE in
        if ($_FILES["file"]["size"] > 500000) {
            $msg = "Sorry, your file is too large.";
            return array("message" => $msg, "error" => 1);
        }

        // Allow certain file formats
        if ($fileType != "sql") {
            $msg = "Sorry, only SQL files are allowed.";
            return array("message" => $msg, "error" => 1);
        }
        if (!file_exists($target_dir)) {
            $msg = "The directory $target_dir is not exists";
            return array("message" => $msg, "error" => 1);
        }
        if (!is_writable(dirname($target_file))) {
            $msg = "Folder must writable";
            return array("message" => $msg, "error" => 1);
        }
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $templine = '';
            $lines = file($target_file);

            foreach ($lines as $line) {
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }

                $templine .= $line;

                if (substr(trim($line), -1, 1) == ';') {
                    mysqli_query($koneksi, $templine);
                    $templine = '';
                }
            }

            unlink($target_file);
            $msg = "Proses restore " . htmlspecialchars(basename($_FILES["file"]["name"])) . " telah berhasil.";
            return array("message" => $msg, "error" => 0);
        } else {
            $msg = "Sorry, there was an error uploading your file.";
            return array("message" => $msg, "error" => 1);
        }
    }

}
