<?php
require_once "dbconfig.php";

class M_dokumen extends Db_config
{
    public $table = 'tbl_dokumen';
    public $tbl_kategori = 'tbl_kategori_dokumen';

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

    public function get_tahun_dokumen()
    {
        $query = "SELECT tahun FROM $this->table GROUP BY tahun";
        $result = $this->connection->query($query);
        $datas = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $datas[] = $row;
        }
        return $datas;
    }

    public function read()
    {
        // PAGINATION
        $batas = 10;
        $halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
        $previous = $halaman - 1;
        $next = $halaman + 1;

        $query = "SELECT a.*,b.nama_kategori
        FROM $this->table a
        LEFT JOIN $this->tbl_kategori b ON a.id_kategori=b.id";

        $conditions = array();
        if (!empty($_POST['id_kategori'])) {
            $conditions[] = "a.id_kategori = '$_POST[id_kategori]'";
        }
        if (!empty($_POST['tahun_dokumen'])) {
            $conditions[] = "a.tahun = '$_POST[tahun_dokumen]'";
        }
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $result = $this->connection->query($query);
        // jumlah data sebelum ada limit, dan ada query where
        $jumlah_data = mysqli_num_rows($result);
        $total_halaman = ceil($jumlah_data / $batas);
        $no = $halaman_awal + 1;

        $query .= " LIMIT $halaman_awal, $batas";
        $result = $this->connection->query($query);

        $datas = array();
        $hasilFungsiPinggiran = '';
        while ($row = mysqli_fetch_assoc($result)) {
            // Jika ada data nama_dokumen mulai pencarian KMP
            if (!empty($_POST['nama_dokumen'])) {
                // Penerapan Algoritma KMP
                $pencarianKMP = $this->SearchTextKMP($row['nama_dokumen'], $_POST['nama_dokumen']);
                $hasilFungsiPinggiran = $pencarianKMP['preKmp'];
                // Jika ada data / data ditemukan
                if (!empty($pencarianKMP['hasilArrayKmp'])) {
                    // masukan data yang ditemukan ke arr
                    $row['no'] = $no++;
                    $row['nama_dokumen'] = str_replace($_POST['nama_dokumen'], "<font color='blue'>$_POST[nama_dokumen]</font>", $row['nama_dokumen']);
                    foreach ($pencarianKMP as $key => $value) {
                        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                        $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
                    }
                    $datas[] = $row;
                }
            } else {
                $row['no'] = $no++;
                $datas[] = $row;
            }
        }
        $arr = array(
            'previous' => $previous,
            'next' => $next,
            'halaman' => $halaman,
            'total_halaman' => $total_halaman,
            'halaman' => $halaman,
            'datas' => $datas,
            'hasilFungsiPinggiran' => $hasilFungsiPinggiran,
        );
        return $arr;
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
        $id_kategori = $this->mysql_prep($_POST['id_kategori']);
        $nama_dokumen = $this->mysql_prep($_POST['nama_dokumen']);
        $tahun = $this->mysql_prep($_POST['tahun']);
        $nomor = $this->mysql_prep($_POST['nomor']);
        $keterangan = $this->mysql_prep($_POST['keterangan']);

        $query = "UPDATE $this->table set ";
        $query .= "id_kategori = '{$id_kategori}', ";
        $query .= "nama_dokumen = '{$nama_dokumen}', ";
        $query .= "tahun = '{$tahun}', ";
        $query .= "nomor = '{$nomor}', ";
        $query .= "keterangan = '{$keterangan}'";
        if (!empty($_FILES['file']['name'])) {
            $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            $new_file_name = $id_kategori . '_' . date('YmdHis') . '.' . $fileType;
            $uploaded = $this->upload_file($new_file_name);
            if ($uploaded['error'] == 1) {
                return $uploaded['message'];
            }
            $this->delete_file($_POST['old_file']);
            $query .= ", file = '{$new_file_name}'";
        }
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
        $data_before = mysqli_fetch_assoc($this->read_by_id($id));
        $file_before = $data_before['file'];
        $query = "DELETE FROM $this->table WHERE id = '{$safe_id}'";
        $result = $this->connection->query($query);
        if (!$result) {
            $msg = "Failed " . mysqli_error($this->connection);
            return $msg;
        } else {
            $this->delete_file($file_before, 'delete');
            return $result;
        }
    }

    public function create()
    {
        $query = "INSERT INTO $this->table ";
        $fields = "";
        $values = "";
        $i = 0;
        $new_file_name = "";
        $id_kategori = $_POST['id_kategori'];
        if (!empty($_FILES['file']['name'])) {
            $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            $new_file_name = $id_kategori . '_' . date('YmdHis') . '.' . $fileType;
            $uploaded = $this->upload_file($new_file_name);
            if ($uploaded['error'] == 1) {
                return $uploaded['message'];
            }
        }
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
                if (!empty($new_file_name)) {
                    $fields .= ",file";
                    $values .= ",'$new_file_name'";
                }
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

    public function upload_file($new_file_name)
    {
        $target_dir = "../uploads/dokumen/";
        // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if ($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg") {
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
                // echo "File is an image - " . $check["mime"] . ".";
                // $uploadOk = 1;
            } else {
                $msg = "File is not an image.";
                return array("message" => $msg, "error" => 1);
                // $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            return array("message" => $msg, "error" => 1);
            // $uploadOk = 0;
        }

        // Check file size
        // MAXIMAL FILE in
        if ($_FILES["file"]["size"] > 5 * 1024 * 1024) {
            $msg = "Sorry, your file is too large.";
            return array("message" => $msg, "error" => 1);
            // $uploadOk = 0;
        }

        // Allow certain file formats
        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "doc" && $fileType != "docx" && $fileType != "pdf") {
            $msg = "Sorry, only JPG, JPEG, PNG, DOC, DOCX, PDF files are allowed.";
            return array("message" => $msg, "error" => 1);
            // $uploadOk = 0;
        }
        if (!file_exists($target_dir)) {
            $msg = "The directory $target_dir is not exists";
            return array("message" => $msg, "error" => 1);
        }
        if (!is_writable(dirname($target_file))) {
            $msg = "Folder must writable";
            return array("message" => $msg, "error" => 1);
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = "Sorry, your file was not uploaded.";
            return array("message" => $msg, "error" => 0);
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // $msg = "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
                $msg = "The file $new_file_name has been uploaded.";
                return array("message" => $msg, "error" => 0);
            } else {
                $msg = "Sorry, there was an error uploading your file.";
                return array("message" => $msg, "error" => 1);
            }
        }
    }

    public function delete_file($nama_file, $action = '')
    {
        $target_dir = "../uploads/dokumen/";
        if ($action == 'delete') {
            $target_dir = "uploads/dokumen/";
        }
        $target_file = $target_dir . $nama_file;
        if (file_exists($target_file)) {
            unlink($target_file);
        }
    }

    // referensi http://journal-computing.org/index.php/journal-sea/article/view/49/40
    /*
    Langkah  awal  dalam  penerapan  algoritma  KMP  adalah
    perhitungan  fungsi pinggiran  dari  sebuah  pattern  (P)
    dapat  disebut  processing  (proses  awal).
    Tujuan dari processing ini adalah menentukan seberapa banyak loncatan atau
    pergeseran yang akan dilakukan ketika pencocokan pattern dengan teks yang tidak diperlukan.

    1 .Menentukan dahulu pattern(P)  dan text(T).  Dalam  studi  kasus  ini pattern dan text yang ingin dicari adalah sebagai berikut.
    P = Yeyen
    T = Eka Yesi Yeyen

    2. Perhitungan fungsi pinggiran Keterangan :
    J = Panjang karakter yang diberikan pattern
    P(J) = Karakter ke-j pada pattern
    F(J) = Nilai fungsi pinggiran dari pattern
     */
    public function prosesAwalKmp($pattern, $panjangPattern)
    {
        // karena awal dari fungsi pinggiran ditetepkan dengan nilai 0
        $nilai = 0;
        $patternNext = 1;

        // nilai awal 0
        $preKmp[0] = 0;

        // Looping Panjang karakter yang diberikan pattern
        while ($patternNext < $panjangPattern) {
            // jika $pattern[$nilai] (karakter pada pattern sebelumnnya) cocok dengan $pattern[$patternNext] karakter pada pattern selanjutnya. Contoh y == y
            if ($pattern[$nilai] == $pattern[$patternNext]) {
                // preKmp diisi jika ditemukan cocok
                // nilai bertambah 1
                $nilai++;
                $preKmp[$patternNext] = $nilai;
                $patternNext++;
            } else {
                // jika tidak cocok
                // nilai kembali ke 0
                $nilai = 0;
                // dan P(J) menjadi 0
                $preKmp[$patternNext] = 0;
                $patternNext++;
            }
        }
        return $preKmp;

    }

    public function SearchTextKMP($text, $pattern)
    {
        $hasilArrayKmp = array();
        $panjangPattern = strlen($pattern);
        $panjangText = strlen($text);
        $indexText = 0;
        $indexPattern = 0;

        $preKmp = $this->prosesAwalKmp($pattern, $panjangPattern);

        // Looping Panjang karakter yang diberikan Text/Text
        while ($indexText < $panjangText) {
            // Jika karakter pattern dan karakter text cocok. Contoh y == y
            if ($pattern[$indexPattern] == $text[$indexText]) {
                // lakukan pencocokan selanjutnya
                $indexPattern++;
                $indexText++;
            }
            // Jika semua pattern sudah terdeteksi(banyaknya indexPattern == banyaknya panjangPattern)
            if ($indexPattern == $panjangPattern) {
                $test = $indexText - $indexPattern;
                // echo "Found pattern at index " . $test . "_<br>";
                // simpan hasil ke array $hasilArrayKmp
                array_push($hasilArrayKmp, $indexText - $indexPattern);
                $indexPattern = $preKmp[$indexPattern - 1];
            } else if ($indexText < $panjangText && $pattern[$indexPattern] != $text[$indexText]) {
                // else if jika masih ada pengecekan && karakter tidak cocok
                if ($indexPattern != 0) {
                    $indexPattern = $preKmp[$indexPattern - 1];
                } else {
                    $indexText = $indexText + 1;
                }

            }
        }
        // return $hasilArrayKmp;

        $formatHasil['preKmp'] = $preKmp;
        $formatHasil['hasilArrayKmp'] = $hasilArrayKmp;
        return $formatHasil;
    }
}
