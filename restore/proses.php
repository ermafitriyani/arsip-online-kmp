<?php
session_start();
require_once "../model/m_database.php";
$crud = new m_database();

$aksi = $crud->restore();
if ($aksi['error'] == 1) {
    $_SESSION['message_type'] = "warning";
} else {
    $_SESSION['message_type'] = "success";
}
$_SESSION['message'] = $aksi['message'];
// $crud->redirect_to("../index.php?page=restore");
echo '<script>
    window.location.replace("index.php?page=restore");
</script>';
