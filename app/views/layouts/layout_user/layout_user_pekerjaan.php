<?php
$navBrands = '<a class="navbar-brand" href="' . PUBLICURL . '">GUEST</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="' . PUBLICURL . '/home/">
            LAPORAN HARIAN
        </a>
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
          <a class="nav-link nav-head ms-lg-3 text-center" id="pdf" aria-current="page" href="" target="_blank" style="display: none;">
            UNDUH
            <i class="bx bx-download"></i>
          </a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5 text-center" href="' . PUBLICURL . '/home/login/"><i class="bx bxs-user-circle" style="font-size: 24px;"></i> Login</a>
    </li>
    ';
    
include '../app/views/layouts/header.php';
?>

<div class="container" >
      <div class="container header-laporan text-center mt-3">
        <h3 style="color : #818181;">LAPORAN HARIAN</h3>
        <h4 class="roboto-text">PENGAWASAN <?= $data['projek']['nama_projek'] ?></h4>
        <h4 class="roboto-text">
            Hari ke-<?= isset($data['hari_ke']) ? $data['hari_ke'] : 'Data tidak tersedia'; ?> | <?= $data['tanggal'] ?>
        </h4>
    </div>
    <hr class="container separator-header">
</div>