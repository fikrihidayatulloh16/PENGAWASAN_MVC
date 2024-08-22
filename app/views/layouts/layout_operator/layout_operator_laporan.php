<?php
$navBrands = '<a class="navbar-brand" href="../../page/operator/laporanharian.php">OPERATOR</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN HARIAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN MINGGUAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN BULANAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN EKSEKUTIF</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5 text-center" href="' . PUBLICURL . '/home/log_out/"><i class="bx bxs-user-circle" style="font-size: 24px;"></i> Logout</a>
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
