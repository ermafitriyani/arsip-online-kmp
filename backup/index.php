<section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Backup Database</li>
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
                    	<h4>Backup Database</h4>
                        <p>Lakukan backup database secara berkala untuk membuat cadangan database yang bisa direstore kapan saja ketika dibutuhkan. Silakan klik tombol <strong>"Backup"</strong> untuk memulai proses backup data. Setelah proses backup selesai, silakan download file backup database tersebut dan simpan di lokasi yang aman.<span class="red-text"><strong>*</strong></span></p><br/>

                        <strong class="text-danger">* Tidak disarankan menyimpan file backup database dalam my documents / Local Disk C.</strong>
                        <hr>
                        <a href="?page=backup&aksi=proses_backup" class="btn btn-primary btn-lg"><i class="fas fa-server"></i> Download Database</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
