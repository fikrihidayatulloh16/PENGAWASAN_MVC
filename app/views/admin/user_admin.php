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

<?php include '../app/views/modals/modal_add/admin/user_admin_add.php' ?>

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
            <h5 class="card-title">Data User</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mbahan-tambah">
              <i class='bx bx-plus-medical'></i> Add
            </button>
          </div>
        
          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table datatable ">
              <thead>
                <tr>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Projek</th>
                    <th class="col-2">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // menampilkan data
                foreach ($data['user'] as $user) :
                ?>
                    <tr>
                        <td><?= $user['id']?></td>
                        <td><?= $user['username']?></td>
                        <td><?= $user['password']?></td>
                        <td><?= $user['id_projek']?></td>
                        <td>
                            <a href="#" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$user['id']?>"><i class='bx bxs-trash-alt'></i><span class="span-aksi"> Delete</span></a>
                            <a href="#" class="btn btn-warning text-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$user['id']?>"><i class='bx bxs-edit-alt'></i><span class="span-aksi">Edit</span></a>
                        </td>
                    </tr>
                <?php 
                include '../app/views/modals/modal_ud/admin/user_admin_ud.php';
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