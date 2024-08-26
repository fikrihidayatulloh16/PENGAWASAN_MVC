<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<?php include '../app/views/modals/modal_add/admin/m_pekerjaan_add.php'; ?>

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
            <h5 class="card-title">Data Master Pekerjaan</h5>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mpekerjaan-tambah">
              <i class='bx bx-plus-medical'></i> <span class="span-aksi"> Add</span> 
            </button>
          </div>
        
          <!-- Table with stripped rows -->
          <div class="container mt-5">

    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="col-1">ID</th>
                <th scope="col">Pekerjaan</th>
                <th scope="col" class="col-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['m_pekerjaan2'] as $index => $item) : ?>
                <tr>
                    <td><?= $item['id_m_pekerjaan'] ?></td>
                    <td>
                        <!-- Accordion Button -->
                        <div class="accordion" id="accordionExample<?= $index ?>">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $index ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                        <?= $item['nama_pekerjaan'] ?>
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#mpekerjaan-hapus-<?= $item['id_m_pekerjaan'] ?>">
                            <i class='bx bxs-trash-alt'></i><span class="span-aksi">Delete</span>
                        </button>
                        <button class="btn btn-warning  rounded-pill mt-1" data-bs-toggle="modal" data-bs-target="#mpekerjaan-ubah-<?= $item['id_m_pekerjaan'] ?>">
                          <i class='bx bxs-edit-alt'></i><span class="span-aksi">Edit</span>
                        </button>

                    </td>
                    
                </tr>
                <?php 
                include '../app/views/modals/modal_ud/admin/m_pekerjaan_ud.php'; 
                include "m_sub_pekerjaan.php";
                endforeach; ?>
        </tbody>
    </table>

</div>
          <!-- End Table with stripped rows -->

        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simpan status accordion saat tombol diklik
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function() {
            const accordionId = this.getAttribute('data-bs-target');
            const isOpen = this.classList.contains('collapsed');
            localStorage.setItem(accordionId, isOpen ? 'collapsed' : 'expanded');
        });
    });

    // Baca status dari localStorage saat halaman dimuat
    document.querySelectorAll('.accordion-collapse').forEach(accordion => {
        const accordionId = accordion.getAttribute('id');
        const status = localStorage.getItem('#' + accordionId);
        if (status === 'expanded') {
            accordion.classList.add('show');
        }
    });
});
</script>
