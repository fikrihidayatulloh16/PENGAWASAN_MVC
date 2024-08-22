<?php
$navBrands = '<a class="navbar-brand" href="../../page/operator/laporanharian.php">ADMIN</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link active nav-head" aria-current="page" href="#" style="font-size: 2;">LAPORAN HARIAN</a>
    </li>

    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">HOME</a>
    </li>
      <li class="nav-item dropdown">
          <a class="nav-link nav-head dropdown-toggle ms-lg-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            MASTER PAGE
            <i class="bx bx-caret-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../page/operator/operator.pekerjaan.php">Master Pekerjaan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/cuaca.php">Master Pekerja</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.permasalahan.php">Master Peralatan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/fotokegiatan.php">Master Bahan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.timPengawas.php">Tim Pengawas</a></li>
          </ul>
        </li>
    ';
    
    include '../app/views/layouts/header.php';

?>

<!-- Content of Page -->
