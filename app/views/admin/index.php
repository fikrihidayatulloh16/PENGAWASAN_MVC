<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<?php include '../app/views/modals/modal_add/admin/projek_add.php' ?>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mprojek">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Data Projek</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#projek-tambah">
              <i class='bx bx-plus-medical'></i> Add
            </button>
          </div>
        
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Proyek</th>
                  <th data-type="date" data-format="DD/MM/YY">Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Pemilik Pekerjaan</th>
                  <th>Pengawas</th>
                  <th>Kontraktor</th>
                  <th>Tambahan Waktu</th>
                  <th class="col-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Menampilkan data projek
                foreach ($data['projek'] as $projek) :
                ?>
                  <tr>
                    <td><?= $projek['id_projek'] ?></td>
                    <td><?= $projek['nama_projek'] ?></td>
                    <td><?= $projek['tanggal_mulai'] ?></td>
                    <td><?= $projek['tanggal_selesai'] ?></td>
                    <td><?= $projek['pemilik_pekerjaan'] ?></td>
                    <td><?= $projek['pengawas'] ?></td>
                    <td><?= $projek['kontraktor'] ?></td>
                    <td><?= $projek['tambahan_waktu'] ?></td>
                    <td>
                      <a href="#" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#projek-hapus-<?= $projek['id_projek'] ?>"><i class='bx bxs-trash-alt'></i><span class="span-aksi">Hapus</span></a>
                      <a href="#" class="btn btn-warning rounded-pill text-dark mt-1" data-bs-toggle="modal" data-bs-target="#projek-ubah<?= $projek['id_projek'] ?>"><i class='bx bxs-edit-alt'></i><span class="span-aksi">Ubah</span></a>
                      <a href="<?= PUBLICURL ?>/admin/m_pekerjaan/<?=$projek['id_projek']?>" class="btn btn-primary rounded-pill text-white mt-1" id="projek_pilih_op" name="projek_pilih_op"><i class='bx bxs-right-arrow-circle'></i><span class="span-aksi">Pilih</span></button>
                    </td>
                  </tr>
                <?php 
                include '../app/views/modals/modal_ud/admin/projek_ud.php';
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