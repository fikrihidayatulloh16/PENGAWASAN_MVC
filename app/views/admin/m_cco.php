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

<?php include '../app/views/modals/modal_add/admin/m_bahan_add.php' ?>

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
            <h5 class="card-title">Data CCO</h5>
            <!--<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mbahan-tambah">
              <i class='bx bx-plus-medical'></i> Add
            </button>-->
          </div>
        
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable ">
              <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Indeks CCO</th>
                    <th class="col-2">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $nomor = 1;
                // menampilkan data
                foreach ($data['all_laporan_mingguan'] as $index => $laporan_mingguan) :
                ?>
                    <tr>
                        <td><?= $nomor?></td>
                        <td><?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?></td>
                        <td>
                            <a href="#" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#cco-hapus-<?=$index?>"><i class='bx bxs-trash-alt'></i><span class="span-aksi"> Delete</span></a>
                        </td>
                    </tr>
                <?php 
                $nomor++;
                include '../app/views/modals/modal_ud/admin/m_cco_ud.php';
              endforeach; 
              ?>
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