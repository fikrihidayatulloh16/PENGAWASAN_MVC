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
                    <th class="col-2">ID</th>
                    <th>Nama Pekerjaan</th>
                    <th class="col-2">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // menampilkan data
                foreach ($data['m_pekerjaan'] as $data_m_pekerjaan) :
                ?>
                  <tr>
                    <td><?= $data_m_pekerjaan['id_m_pekerjaan'] ?></td>
                    <td>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>" aria-expanded="false" aria-controls="collapseOne<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>">
                                        <?= $data_m_pekerjaan['nama_pekerjaan'] ?>
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>">
                            <i class='bx bxs-trash-alt'><span class="span-aksi"> Hapus</span></i>
                        </a>
                        <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>">
                            <i class='bx bxs-edit-alt'><span class="span-aksi"> Ubah</span></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
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