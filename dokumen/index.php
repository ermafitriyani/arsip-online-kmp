<?php
require_once "model/m_dokumen.php";
require_once "model/m_kategori.php";

$crud = new m_dokumen();
$dokumen = $crud->read();
$get_tahun_dokumen = $crud->get_tahun_dokumen();

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
    <div class="">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-12 mb-2">
                <div class="card">

                    <div class="card-body">
                        <h4>Pencarian</h4>
                        <form method="POST" action="">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Kategori Arsip</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="id_kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($row = mysqli_fetch_assoc($kategori)): ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo @$_POST['id_kategori'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['nama_kategori'] ?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Tahun Arsip</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="tahun_dokumen" required>
                                        <?php foreach ($get_tahun_dokumen as $key => $value): ?>
                                            <option value="<?php echo $value['tahun'] ?>" <?php echo @$_POST['tahun_dokumen'] == $value['tahun'] ? 'selected' : '' ?>><?php echo $value['tahun'] ?></option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Kata</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="nama_dokumen" required placeholder="Cari Nama Dokumen dengan Algoritma KMP" value="<?php echo @$_POST['nama_dokumen'] ?>">
                                </div>
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                    <div class="card-header">
                        <a href="?page=dokumen&aksi=add" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th width="15%">Nomor</th>
                                    <th>Nama dokumen</th>
                                    <th>Detail dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dokumen['datas'] as $key => $value): ?>
                                <tr>
                                    <td class="text-center"><?php echo $value['no']; ?></td>
                                    <td><?php echo $value["nama_dokumen"]; ?></td>
                                    <td>
                                        Kategori : <?php echo $value["nama_kategori"]; ?>
                                        <br>Tahun : <?php echo $value["tahun"]; ?>
                                        <br>Nomor : <?php echo $value["nomor"]; ?>
                                        <br>Keterangan : <?php echo $value["keterangan"]; ?>
                                        <br>
                                        <?php if (!empty($value['file'])): ?>
                                        <a class="btn btn-danger btn-sm" href="uploads/dokumen/<?php echo $value["file"]; ?>" target="_blank"><i class="fas fa-file"></i> File</a>
                                        <?php else: ?>
                                        <button class="btn btn-danger btn-sm" disabled><i class="fas fa-file"></i> File Tidak Ada</button>
                                        <?php endif?>
                                    </td>
                                    <td>
                                        <a href="?page=dokumen&aksi=edit&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="?page=dokumen&aksi=delete&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini..?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                            <nav class="float-right">
                              <ul class="pagination">
                                <li class="page-item <?php echo $dokumen['halaman'] > 1 ? '' : 'disabled' ?>">
                                  <a class="page-link" href="<?php echo $dokumen['halaman'] > 1 ? "?page=dokumen&halaman=$dokumen[previous]" : '#' ?>" tabindex="-1">Previous</a>
                                </li>
                                <?php for ($x = 1; $x <= $dokumen['total_halaman']; $x++): ?>
                                    <li class="page-item <?php echo $dokumen['halaman'] == $x ? 'active' : '' ?>"><a class="page-link" href="?page=dokumen&halaman=<?php echo $x ?>"><?php echo $x ?></a></li>
                                <?php endfor?>
                                <li class="page-item <?php echo $dokumen['total_halaman'] == $dokumen['halaman'] ? 'disabled' : '' ?>">
                                  <a class="page-link" href="<?php echo $dokumen['total_halaman'] == $dokumen['halaman'] ? '#' : "?page=dokumen&halaman=$dokumen[next]" ?>">Next</a>
                                </li>
                              </ul>
                            </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
