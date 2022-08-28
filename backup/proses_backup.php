<?php
require_once "model/m_database.php";
$crud = new m_database();

$aksi = $crud->backup();
if ($aksi['error'] == 1) {
    $_SESSION['message'] = $aksi['message'];
    $_SESSION['message_type'] = "warning";
    // $crud->redirect_to("index.php?page=backup");
    echo '<script>
    window.location.replace("index.php?page=backup");
</script>';
}
