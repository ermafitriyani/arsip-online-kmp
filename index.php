<?php
// error_reporting(E_ERROR | E_PARSE);
session_start();
if (empty($_SESSION['login'])) {
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aplikasi Arsip Dokumen</title>
    <link rel="shortcut icon" href="assets/favicon.ico?v=1.4" type="image/x-icon">
    <link rel="icon" href="assets/favicon.ico?v=1.4" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="assets/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="assets/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php include 'template/sidebar.php'?><!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
            <?php include 'template/header.php'?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
<?php
$page = empty($_GET['page']) ? '' : $_GET['page'];
$aksi = empty($_GET['aksi']) ? '' : $_GET['aksi'];

if ($page == "") {
    include "beranda/index.php";
} else {
    if (empty($aksi)) {
        include "$page/index.php";
    } else {
        include "$page/$aksi.php";
    }
}
?>
                </div>
            </div>
            <!-- Footer -->
            <?php include 'template/footer.php'?>
            <!-- End of Footer -->
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/sbadmin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- DataTable -->
        <!-- <script src="assets/libs/jquery/jquery-3.6.0.js"></script> -->
    <!-- <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script> -->

    <script src="assets/sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>

    <!-- Page level custom scripts -->


</body>

</html>