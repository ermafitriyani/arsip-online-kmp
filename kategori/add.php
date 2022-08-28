<section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori Dokumen</li>
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
                        <form method="POST" action="kategori/save.php">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama Kategori</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_kategori" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="status" required id="RadioDefault1" value="Aktif">
                                      <label class="form-check-label" for="RadioDefault1">
                                        Aktif
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="status" required id="RadioDefault2" value="Tidak">
                                      <label class="form-check-label" for="RadioDefault2">
                                        Tidak
                                      </label>
                                    </div>
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
