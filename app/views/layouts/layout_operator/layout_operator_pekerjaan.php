<?php
$navBrands = '<a class="navbar-brand" href=" ' . PUBLICURL . '/operator/laporan_harian_list/' . $data['id_projek'] . '">OPERATOR</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link nav-head" aria-current="page" href=" ' . PUBLICURL . '/operator/rekap/' . $data['id_laporan_harian'] . '/' . $data['id_projek'] . '" style="font-size: 2;">LAPORAN HARIAN</a>
    </li>

    <li class="nav-item dropdown">
          <a class="nav-link nav-head dropdown-toggle ms-lg-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            LAINNYA
            <i class="bx bx-caret-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../page/operator/operator.pekerjaan.php">Pekerjaan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/cuaca.php">Cuaca</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.permasalahan.php">Permasalahan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/fotokegiatan.php">Lampiran Foto</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.timPengawas.php">Tim Pengawas</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-head ms-lg-3" aria-current="page" href="' . PUBLICURL . '/printpdf/print_laporan_harian/' . $data['id_projek'] . '/' . $data['id_laporan_harian'] . '/' . $data['laporan']['tanggal'] . '" target="_blank">UNDUH
          <i class="bx bx-download"></i>
          </a>
      </li>';
    
include '../app/views/layouts/header.php';
?>

<!-- Content of Page -->

<div class="container" >
      <div class="container header-laporan text-center mt-3">
        <h3 style="color : #818181;">LAPORAN HARIAN</h3>
        <h4 class="roboto-text">PENGAWASAN  <?= $data['projek']['nama_projek'] ?></h4>
        <h4 class="roboto-text">
            Hari ke-<?= isset($data['hari_ke']) ? $data['hari_ke'] : 'Data tidak tersedia'; ?> | <?= $data['tanggal'] ?>
        </h4>
    </div>
    <hr class="container separator-header">
</div>
