<?php
require_once "model/m_dokumen.php";

$crud = new m_dokumen();

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query_result = $crud->delete($id);
    if ($query_result === true) {
        $_SESSION['message'] = "Data berhasil di hapus";
        $_SESSION['message_type'] = "success";
        // $crud->redirect_to("index.php?page=dokumen");
        echo '<script>
    window.location.replace("index.php?page=dokumen");
</script>';
    } else {
        $_SESSION['message'] = $query_result;
        $_SESSION['message_type'] = "warning";
        // $crud->redirect_to("index.php?page=dokumen");
        echo '<script>
    window.location.replace("index.php?page=dokumen");
</script>';
    }
}
