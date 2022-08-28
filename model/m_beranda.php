<?php
require_once "dbconfig.php";

class M_beranda extends Db_config
{
    public $kategori = 'tbl_kategori_dokumen';
    public $dokumen = 'tbl_dokumen';
    public $user = 'tbl_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function jm_all()
    {
        $query = "SELECT COUNT(*) jm_kategori FROM $this->kategori";
        $jm_kategori = mysqli_fetch_assoc($this->connection->query($query))['jm_kategori'];
        $query = "SELECT COUNT(*) jm_dokumen FROM $this->dokumen";
        $jm_dokumen = mysqli_fetch_assoc($this->connection->query($query))['jm_dokumen'];
        $query = "SELECT COUNT(*) jm_user FROM $this->user";
        $jm_user = mysqli_fetch_assoc($this->connection->query($query))['jm_user'];
        return array(
            'jm_kategori' => $jm_kategori,
            'jm_dokumen' => $jm_dokumen,
            'jm_user' => $jm_user,
        );
    }

}
