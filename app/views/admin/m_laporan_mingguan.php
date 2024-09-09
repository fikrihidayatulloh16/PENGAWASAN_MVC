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

<?php include "../app/views/modals/modal_add/operator/laporan_mingguan_add.php"; ?>

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
        
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable ">
              <thead>
                <tr>
                    <!--<th>No.</th>-->
                    <th>Minggu Ke-</th>
                    <th>Rencana Progres</th>
                    <th>Rencana Progres Kumulatif</th>
                    <th>Realisasi Progres</th>
                    <th>Realisasi Progress Kumulatif</th>
                    <th class="col-2">Aksi</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $nomor = 1;
                if (!empty($data['all_laporan_mingguan'])):
                    $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);
                    $mingguKeData = [];
                    $rencanaKumulatifData = [];
                    $realisasiKumulatifData = [];
                    foreach ($data['all_laporan_mingguan'] as $laporan) :    
                        $tanggal_laporan = new DateTime($laporan['tanggal_mulai']);

                        // Menghitung selisih hari antara tanggal laporan dan tanggal mulai proyek
                        $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;

                        $minggu_ke = floor($selisih_hari / 7) + 1;

                        // Mengumpulkan data untuk chart
                        $mingguKeData[] = "$minggu_ke";
                        $rencanaKumulatifData[] = $laporan['rencana_progres_kumulatif'];
                        $realisasiKumulatifData[] = $laporan['realisasi_progres_kumulatif'];
                ?>
                <tr>
                     <!--<td class="text-center align-middle nomor"></td>-->
                    <td class="text-center align-middle" style="color: #464F60;">
                        <a>Minggu ke-<?= $minggu_ke ?></a>
                    </td>
                    <td class="text-center align-middle"><?= $laporan['rencana_progres'] ?>%</td>
                    <td class="text-center align-middle"><?= $laporan['rencana_progres_kumulatif'] ?>%</td>
                    <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres']) ? $laporan['realisasi_progres'] . '%' : '-' ?></td>
                    <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres_kumulatif']) ? $laporan['realisasi_progres_kumulatif'] . '%' : '-' ?></td>
                    <td>
                        <a href="#" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#lm-hapus-<?=$laporan['id_laporan_mingguan']?>">
                            <i class='bx bxs-trash-alt' ></i><span class="span-aksi"> Delete</span>
                        </a>
                        <a href="#" class="btn btn-warning text-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#lm-ubah-<?=$laporan['id_laporan_mingguan']?>">
                            <i class='bx bxs-edit-alt' > </i><span class="span-aksi">Edit</span>
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
          <!-- End Table with stripped rows -->

        </div>
      </div>
    </div>
  </div>
</section>


<script src="<?= PUBLICURL ?>/assets/js/"></script>