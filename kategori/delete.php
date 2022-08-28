<?php
require_once "model/m_kategori.php";

$crud = new m_kategori();

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query_result = $crud->delete($id);
    if ($query_result === true) {
        $_SESSION['message'] = "Data berhasil di hapus";
        $_SESSION['message_type'] = "success";
        // $crud->redirect_to("index.php?page=kategori");
        echo '<script>
    window.location.replace("index.php?page=kategori");
</script>';
    } else {
        $_SESSION['message'] = $query_result;
        $_SESSION['message_type'] = "warning";
        // $crud->redirect_to("index.php?page=kategori");
        echo '<script>
    window.location.replace("index.php?page=kategori");
</script>';
    }
}
