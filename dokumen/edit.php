<?php
require_once "model/m_dokumen.php";
require_once "model/m_kategori.php";
$crud = new m_dokumen();
$result_set = $crud->read_by_id($_GET["id"]);
$result = mysqli_fetch_assoc($result_set);

$crud_kategori = new m_kategori();
$kategori = $crud_kategori->read(array('status' => 'Aktif', 'or_id_kategori' => $result['id_kategori']));
?>
<section>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
				<li class="breadcrumb-item active" aria-current="page"> Dokumen</li>
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
						<form method="POST" action="dokumen/update.php" enctype="multipart/form-data">
							<div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Kategori dokumen</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($row = mysqli_fetch_assoc($kategori)): ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo $result['id_kategori'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['nama_kategori'] ?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama dokumen</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_dokumen" required value="<?php echo $result['nama_dokumen'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="tahun" required value="<?php echo $result['tahun'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nomor</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor" required value="<?php echo $result['nomor'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="keterangan"><?php echo $result['keterangan'] ?></textarea>
                                </div>
                            </div>
							<div class="mb-3 row">
								<label for="formFile" class="col-sm-2 form-label">File</label>
								<div class="col-sm-10">
									<input class="form-control" type="file" id="formFile" name="file">
									<small class="text-danger">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB</small>
									<br><small class="text-danger">Kosongkan jika tidak ingin mengupdate file</small>
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $result['id'] ?>">
							<input type="hidden" name="old_file" value="<?php echo $result['file'] ?>">
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