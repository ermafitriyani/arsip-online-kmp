<?php
require_once "model/m_kategori.php";
$crud_kategori = new m_kategori();
$kategori = $crud_kategori->read(array('status' => 'Aktif'));
?>
<section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
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
                        Form Tambah Data
                    </div>
                    <div class="card-body">
                        <form method="POST" action="dokumen/save.php" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Kategori dokumen</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($result = mysqli_fetch_assoc($kategori)): ?>
                                            <option value="<?php echo $result['id'] ?>"><?php echo $result['nama_kategori'] ?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama dokumen</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_dokumen" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="tahun" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nomor</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="keterangan"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="formFile" class="col-sm-2 form-label">File</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile" name="file">
                                    <small class="text-danger">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB</small>
                                </div>
                            </div>
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
