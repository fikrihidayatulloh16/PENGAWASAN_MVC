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

<?php include '../app/views/modals/modal_add/admin/tim_pengawas_admin_add.php' ?>

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
            <h5 class="card-title">Data Tim Pengawas Projek</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pengawas-tambah">
              <i class='bx bx-plus-medical'></i> Add
            </button>
          </div>
        
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable">
              <thead>
                <tr>
                    <th>Tim Pengawas</th>
                    <th>Tim Leader</th>
                    <th class="col-2">Aksi</th>
                </tr>
              </thead>
              <?php
                  $nomor_masalah = 1;

                  if (count( $data['tim_pengawas']) > 0) {
                      foreach ( $data['tim_pengawas'] as $tim_pengawas) : 
              ?>
              <tbody>
              <tr>
                  <td class="text-center"><?= $tim_pengawas['tim_pengawas'] ?></td>
                  <td class="text-center"><?= $tim_pengawas['tim_leader'] ?></td>
                  <td class="text-center">
                      <form action="../../script/projek_pilih.php" method="POST">
                          <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#pengawas-hapus-<?= $tim_pengawas['id_tim_pengawas'] ?>">
                          <i class='bx bx-trash' ></i>
                          </a>
                          <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#pengawas-ubah-<?= $tim_pengawas['id_tim_pengawas'] ?>">
                              <i class='bx bxs-edit-alt'></i>
                          </a>
                          <input type="hidden" name="id_laporan" value="<?= $tim_pengawas['id_tim_pengawas'] ?>">
                      </form>
                  </td>
              </tr>
              <?php 
                  $nomor_masalah++; 
                  include '../app/views/modals/modal_ud/admin/tim_pengawas_admin_ud.php';
                  endforeach;
                  } else { 
              ?>
              </tbody>
              <tr>
                  <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
              </tr>
              <?php } ?>
            </table>
          </div>
          <!-- End Table with stripped rows -->

        </div>
      </div>
    </div>
  </div>
</section>


<script src="<?= PUBLICURL ?>/assets/js/"></script>