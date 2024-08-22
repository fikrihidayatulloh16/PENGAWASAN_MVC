<?php
$navBrands = '<a class="navbar-brand" href="#">GUEST</a>';

$navItems = '
    <li class="nav-item dropdown">
          <a class="nav-link nav-head dropdown-toggle ms-lg-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            LAPORAN
            <i class="bx bx-caret-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../page/operator/operator.pekerjaan.php">LAPORAN HARIAN</a></li>
            <li><a class="dropdown-item" href="../../page/operator/cuaca.php">LAPORAN MINGGUAN</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.permasalahan.php">LAPORAN BULANAN</a></li>
            <li><a class="dropdown-item" href="../../page/operator/fotokegiatan.php">LAPORAN EKSEKUTIF</a></li>
          </ul>
        </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="' . PUBLICURL . '/home/login/"><i class="bx bxs-user-circle" style="font-size: 24px;"></i> Login</a>
    </li>
    ';
    
include '../app/views/layouts/header.php';
?>

<!-- Content of Page -->
<div class="container">
    <div class="container header-laporan text-center mt-3">
        <h3 style="color : #818181;">LAPORAN HARIAN</h3>
        <h4 class="roboto-text">PENGAWASAN <?= $data['projek']['nama_projek'] ?></h4>
        <h4 class="roboto-text">Waktu Pelaksanaan : <?= $data['tanggal_mulai_projek'] ?> - <?= $data['tanggal_selesai_projek'] ?></h4>
        <h4 class="roboto-text">Tambahan Waktu : <?= $data['tambahan_waktu_projek'] ?></h4>
        </div>
    <hr class="container separator-header">
</div>

<!-- 
<li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN MINGGUAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN BULANAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN EKSEKUTIF</a>
    </li>
-->