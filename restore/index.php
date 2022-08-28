<section>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
				<li class="breadcrumb-item active" aria-current="page">Restore Database</li>
			</ol>
		</nav>
	<div class="">
		<div class="row gx-5 align-items-center">
			<div class="col-lg-12">
				<?php $message = empty($_SESSION['message']) ? '' : $_SESSION['message'];unset($_SESSION['message'])?>
				<?php $message_type = empty($_SESSION['message_type']) ? '' : $_SESSION['message_type'];unset($_SESSION['message_type'])?>
				<?php if (!empty($message)): ?>
				<div class="alert alert-<?php echo $message_type ?> alert-dismissible fade show" role="alert">
					<?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
				</div>
				<?php endif?>
				<div class="card">
					<div class="card-body">
						<h4>Restore Database</h4>
						<p>Silakan pilih file database lalu klik tombol <strong>"Restore"</strong> untuk melakukan restore database dari hasil backup yang telah dibuat sebelumnya. Jika belum ada file database hasil backup, silakan lakukan backup terlebih dahulu melalui menu <strong><a href="?page=backup">"Backup Database"</a>.</strong></p><br/>
						<p><span class="text-danger"><i class="fas fa-exclamation-circle"></i> <strong>PERINGATAN!</strong></span><br/>Berhati - hatilah ketika merestore database karena<span class="text-danger"><strong> data yang ada akan diganti dengan data yang baru</strong></span>. Pastikan bahwa file database yang akan digunakan untuk merestore adalah <strong>"benar - benar"</strong> file backup database yang telah dibuat sebelumnya sehingga sistem dapat berjalan dengan normal dan tidak mengalami error.</p>
						<form method="POST" action="restore/proses.php" enctype="multipart/form-data">
							<h4>Form Restore Database</h4>
							<div class="mb-3 row">
								<div class="col-sm-6">
									<input class="form-control" type="file" id="formFile" name="file" required>
									<small class="text-danger">*Format file yang diperbolehkan *.SQL</small>
								</div>
								<div class="col-sm-6">
									<div class="input-group mb-3">
										<span class="input-group-text" id="basic-addon1"><i class="fas fa-unlock"></i></span>
										<input class="form-control" type="password" placeholder="Masukan Password Anda" aria-describedby="basic-addon1" required name="password">
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary"><i class="fas fa-redo"></i> Restore</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>