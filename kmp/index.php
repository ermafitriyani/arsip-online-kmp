<?php require_once "model/m_dokumen.php";?>
<?php $crud = new m_dokumen();?>
<?php $result_set = $crud->read();?>
<section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=beranda">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
            </ol>
        </nav>
    <div class="">
        <div class="row gx-5 align-items-center">

        </div>
    </div>
</section>
