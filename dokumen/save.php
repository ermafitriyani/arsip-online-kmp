<?php
session_start();
require_once "../model/m_dokumen.php";
$crud = new m_dokumen();

if (!empty($_POST)) {

    $query_result = $crud->create();
    if ($query_result === true) {
        $_SESSION['message'] = "Data berhasil di simpan";
        $_SESSION['message_type'] = "success";
        $crud->redirect_to("../index.php?page=dokumen");
    } else {
        $_SESSION['message'] = $query_result;
        $crud->redirect_to("../index.php?page=dokumen&aksi=add");
    }
}
