<style>
    @media (min-width: 1024px) {
        .kolom-aksi {
            columns: 5;
        }
    }

    @media (max-width: 768px) {
        .kolom-aksi {
            width: 33.3333%; /* 4 dari 12 kolom */
        }
        .span-aksi {
            display: none;
        }
    }
</style>

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<?php 
$next_cco = $data['max_cco'] + 1;
include "../app/views/modals/modal_add/operator/laporan_mingguan_add.php"; 
?>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mprojek">
        <div class="card-body">
          <div class="text-center">
            <h4 class="project-title mt-3">Projek :</h4>
            <h4 class="project-title"><?= $data['projek']['nama_projek'] ?></h4>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Data Master Laporan Mingguan</h5>
            <button type="button" class="btn btn-success btn-tambah" data-bs-toggle="modal" data-bs-target="#lm_tambah">
                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>ADD
            </button>
          </div>
        
          <!-- Tab -->
          <nav>
              <div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
                  <?php foreach ($data['all_laporan_mingguan'] as $index => $laporan): ?>
                      <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                          id="nav-cco<?= $index ?>-tab" 
                          data-bs-toggle="tab" 
                          data-bs-target="#nav-cco<?= $index ?>" 
                          type="button" 
                          role="tab" 
                          aria-controls="nav-cco<?= $index ?>" 
                          aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                          <?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?>
                      </button>
                  <?php endforeach; ?>
              </div>
          </nav>

          <div class="tab-content background-color-dark" id="nav-tabContent">
        <?php 
        $mingguKeData = [];
        $rencanaKumulatifData = [];
        $realisasiKumulatifData = [];
        
        foreach ($data['all_laporan_mingguan'] as $index => $laporan): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="nav-cco<?= $index ?>" role="tabpanel" aria-labelledby="nav-cco<?= $index ?>-tab">
                <h4 class="ms-5 mt-5"><?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?></h4>
                <?php //include '../app/views/modals/modal_add/operator/pekerjaan_harian_lh_add.php' ?>

                <!--
                <hr class="separator mt-5">

                <div class="container">
                    <div class="card mt-3">
                        <h5 class="card-header">
                            <div>
                                Keterangan : ?= !empty($sub['keterangan']) ? $sub['keterangan'] : 'Tidak ada Keterangan!' ?>
                            </div>

                            <a class="btn btn-edit ms-2 mt-0" data-bs-toggle="modal" data-bs-target="#ph-keterangan-tambah- ?= $index ?>"><i class='bx bxs-edit-alt'></i>EDIT</a>
                        </h5>
                    </div>
                </div>
                -->
                <hr class="separator mt-3">

                <div class="card mt-100">
                    <div class="table-responsive">
                      <table class="table datatable" style="width: 100%;">
                          <thead>
                              <tr>
                                  <th>No. </th>
                                  <th>Minggu Ke-</th>
                                  <th>Rencana Progres</th>
                                  <th>Rencana Progres Kumulatif</th>
                                  <th>Realisasi Progres</th>
                                  <th>Realisasi Progress Kumulatif</th>
                                  <th>Deviasi</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody id="table-body">
                              <?php
                              $nomor = 1;
                              if (!empty($data['all_laporan_mingguan'])):
                                  $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);
                                  foreach ($laporan as $laporan) :    
                                      $tanggal_laporan = new DateTime($laporan['tanggal_mulai']);

                                      // Menghitung selisih hari antara tanggal laporan dan tanggal mulai proyek
                                      $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;

                                      $minggu_ke = floor($selisih_hari / 7) + 1;

                                      // Mengumpulkan data untuk setiap CCO
                                      // Simpan data dalam array
                                      $ccoKey = 'cco' . $index;
                                      $mingguKeData[$ccoKey][] = $minggu_ke;
                                      $rencanaKumulatifData[$ccoKey][] = $laporan['rencana_progres_kumulatif_cco' . $index];
                                      $realisasiKumulatifData[$ccoKey][] = $laporan['realisasi_progres_kumulatif_cco' . $index];
                                      
                              ?>
                              <tr>
                                  <td class="text-center align-middle"><?= $nomor ?></td>
                                  <td class="text-center align-middle" style="color: #464F60;">
                                      <a href="<?= PUBLICURL ?>/laporanmingguan/weekly_laporan_harian/<?= $data['projek']['id_projek']?>/<?= $laporan['tanggal_mulai'] ?>/<?= $laporan['tanggal_selesai'] ?>/<?= $minggu_ke?>">Minggu ke-<?= $minggu_ke ?></a>
                                  </td>
                                  <td class="text-center align-middle"><?= $laporan['rencana_progres_cco'. $index] ?>%</td>
                                  <td class="text-center align-middle"><?= $laporan['rencana_progres_kumulatif_cco'. $index] ?>%</td>
                                  <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres_cco'. $index]) ? $laporan['realisasi_progres_cco'. $index] . '%' : '-' ?></td>
                                  <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres_kumulatif_cco'. $index]) ? $laporan['realisasi_progres_kumulatif_cco'. $index] . '%' : '-' ?></td>
                                  <td class="text-center align-middle 
                                      <?php 
                                      $deviasi = $laporan['realisasi_progres_kumulatif_cco'. $index] - $laporan['rencana_progres_kumulatif_cco'. $index]; 
                                      echo ($deviasi >= 0) ? 'text-bright-green' : 'text-red'; 
                                      ?>">
                                      <?= $deviasi >= 0 ? '+'. $deviasi : $deviasi ?>
                                  </td>
                                  <td>
                                      <a href="#" class="btn btn-danger rounded-pill btn-aksi" data-bs-toggle="modal" data-bs-target="#lm-hapus-<?=$index?>-<?= $laporan['id_laporan_mingguan']?>">
                                          <i class='bx bxs-trash-alt' ></i>
                                      </a>
                                      <a href="#" class="btn btn-warning btn-aksi rounded-pill mt-1" data-bs-toggle="modal" data-bs-target="#lm-ubah-<?=$index?>-<?= $laporan['id_laporan_mingguan']?>">
                                      <i class='bx bxs-edit-alt'></i>
                                      </a>
                                      <!--<a href=" ?= PUBLICURL ?>/printpdf/mpdf/ ?= $data['projek']['id_projek'] ?>/ ?= $laporan['id_laporan_mingguan'] ?>/ ?= $laporan['tanggal_laporan'] ?>" target="_blank" class="btn btn-aksi mt-1"><i class="bx bx-download"></i></a>-->
                                  </td>
                              </tr>
                              <?php 
                              include "../app/views/modals/modal_ud/admin/laporan_mingguan_ud.php";
                              $nomor++; 
                              endforeach; 
                              else:
                              ?>
                              <tr>
                                  <td colspan="7" class="text-center">Tidak ada data Laporan Mingguan!</td>
                              </tr>
                              <?php endif; ?>
                          </tbody>
                      </table>
                  </div>
              </div>

          </div>
      <?php endforeach; ?>
  </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="<?= PUBLICURL ?>/assets/js/"></script>