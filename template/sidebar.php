<?php $page = empty($_GET['page']) ? '' : $_GET['page']?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(180deg,#ae3ac1 10%,#224abe 100%) !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="assets/img/logo.png" style="width: 25px;">
        </div>
        <div class="sidebar-brand-text mx-3">Arsip Online <sup>KMP</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $page == 'beranda' || $page == '' ? 'active' : '' ?>">
        <a class="nav-link" href="?page=beranda">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Input Data</span>
        </a>
        <div id="collapseTwo" class="collapse <?php echo $page == 'dokumen' || $page == 'kategori' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo $page == 'dokumen' ? 'active' : '' ?>" href="?page=dokumen">Dokumen</a>
                <a class="collapse-item <?php echo $page == 'kategori' ? 'active' : '' ?>" href="?page=kategori">Kategori Dokumen</a>
            </div>
        </div>
    </li>

    <?php if ($_SESSION['level'] == 'Admin'): ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span>
        </a>
        <div id="collapseUtilities" class="collapse <?php echo $page == 'user' || $page == 'backup' || $page == 'restore' ? 'show' : '' ?>" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo $page == 'user' ? 'active' : '' ?>" href="?page=user">User</a>
                <!-- <a class="collapse-item <?php echo $page == 'backup' ? 'active' : '' ?>" href="?page=backup">Backup Database</a>
                <a class="collapse-item <?php echo $page == 'restore' ? 'active' : '' ?>" href="?page=restore">Restore Database</a> -->
            </div>
        </div>
    </li>
    <?php endif?>

    <!-- <li class="nav-item <?php echo $page == 'kmp' ? 'active' : '' ?>">
        <a class="nav-link" href="?page=kmp">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>KMP</span></a>
    </li> -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
