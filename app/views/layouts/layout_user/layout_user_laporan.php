<?php
$navBrands = '<a class="navbar-brand" href="#">GUEST</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="' . PUBLICURL . '/home/">LAPORAN HARIAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="' . PUBLICURL . '/home/laporan_mingguan_user/'.$data['id_projek'].'">
            LAPORAN MINGGUAN
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Fitur Belum Tersedia">
            LAPORAN BULANAN
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Fitur Belum Tersedia">
            LAPORAN EKSEKUTIF
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5 text-center" href="' . PUBLICURL . '/home/login/">
            <i class="bx bxs-user-circle" style="font-size: 24px;"></i> 
            Login
        </a>
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