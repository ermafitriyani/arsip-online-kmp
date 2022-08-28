<?php
require_once "model/m_user.php";
require_once "model/m_user.php";
$crud = new m_user();
$result_set = $crud->read_by_id($_GET["id"]);
$result = mysqli_fetch_assoc($result_set);

$crud_kategori = new m_user();
$kategori = $crud_kategori->read();
?>
<section>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
				<li class="breadcrumb-item active" aria-current="page">User</li>
			</ol>
		</nav>
	<div class="container px-5">
		<div class="row gx-5 align-items-center">
			<div class="col-lg-12">
				<?php $message = empty($_SESSION['message']) ? '' : $_SESSION['message'];unset($_SESSION['message'])?>
				<?php if (!empty($message)): ?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<?php endif?>
				<div class="card">
					<div class="card-header">
						Form Edit Data
					</div>
					<div class="card-body">
						<form method="POST" action="user/update.php">
							<div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Level user</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="level" required>
                                        <option value="">Pilih Level</option>
                                        <option value="Admin" <?php echo $result['level'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="Lurah" <?php echo $result['level'] == 'Lurah' ? 'selected' : '' ?>>Lurah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="<?php echo $result['username'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" required value="<?php echo $result['nama'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password">
									<small class="text-danger">Kosongkan jika tidak ingin mengubah password</small>
                                </div>
                            </div>
							<input type="hidden" name="username" value="<?php echo $result['username'] ?>">
							<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
							<a class="btn btn-warning" onclick="window.history.go(-1); return false;"><i class="fas fa-times"></i> Batal</a>
						</form>
					</div>
					<div class="card-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>