<?php
session_start();
require_once "model/m_login.php";
$crud = new m_login();
if (!empty($_POST)) {
    $result = $crud->cek_login();
    if ($result != false) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION["login"] = true;
        $_SESSION["username"] = $data['username'];
        $_SESSION["nama"] = $data['nama'];
        $_SESSION["level"] = $data['level'];
        echo "<script>window.location.href = \"index.php\" </script>";
    } else {
        echo "<script>window.location.href = \"login.php?message=Username atau Password anda salah&message_type=warning\" </script>";
    }
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

    <title>Login</title>
    <link rel="shortcut icon" href="assets/favicon.ico?v=1.4" type="image/x-icon">
    <link rel="icon" href="assets/favicon.ico?v=1.4" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="assets/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="assets/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6">
				                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistem Arsip Dokumen dengan Metode KMP</h1>
                                    </div>
					                <p class="mb-0 text-justify">Sistem informasi yang mampu melakukan pengelolaan pengarsipan dokumen, pencarian arsip, menyediakan arsip berbasis web.</p>
					            </div>
            				</div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistem Arsip Dokumen<br>Tiyuh Daya Asri</h1>
                                    </div>
                <?php $message = empty($_GET['message']) ? '' : $_GET['message']?>
                <?php $message_type = empty($_GET['message_type']) ? '' : $_GET['message_type']?>
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif?>
                                    <form class="user" method="POST" action="">
                  <p>Please login to your account</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                name="username" id="username" type="text" placeholder="Enter your username.." required value="admin">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="password" placeholder="Enter your password.." required value="admin">
                                        </div>
                                        <button type="submit" href="index.html" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>
