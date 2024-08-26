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


<script>
            document.addEventListener("DOMContentLoaded", function() {
                // Helper function to validate dates
                function validateDates(startDate, endDate, additionalDate, startError, endError, additionalError) {
                    var today = new Date().toISOString().split('T')[0];

                    // Clear previous errors
                    startError.style.display = 'none';
                    endError.style.display = 'none';
                    additionalError.style.display = 'none';

                    var isValid = true;

                    /*
                    // Validate start date
                    if (startDate.value < today) {
                        startError.style.display = 'block';
                        isValid = false;
                    } 
                    */

                    // Validate end date
                    if (endDate.value <= startDate.value) {
                        endError.style.display = 'block';
                        isValid = false;
                    }

                    if (additionalDate.value !== '') {
                        const additionalDateValue = new Date(additionalDate.value);
                        const endDateValue = new Date(endDate.value);

                        if (additionalDateValue <= endDateValue) {
                            additionalError.style.display = 'block';
                            isValid = false; // Assuming isValid is a boolean flag used for form validation
                        } else {
                            additionalError.style.display = 'none';
                        }
                    }
                    return isValid;
                }

                // Add event listener for "Tambah" form submission
                document.getElementById('form_tambah').addEventListener('submit', function(event) {
                    var startDate = document.getElementById('tanggal_mulai_tambah');
                    var endDate = document.getElementById('tanggal_selesai_tambah');
                    var additionalDate = document.getElementById('tambahan_waktu_tambah');
                    var startError = document.getElementById('tanggalMulaiError_tambah');
                    var endError = document.getElementById('tanggalSelesaiError_tambah');
                    var additionalError = document.getElementById('tanggalTambahanError_tambah');

                    if (!validateDates(startDate, endDate, additionalDate, startError, endError, additionalError)) {
                        event.preventDefault();
                    }
                });

                <?php
                // Add event listeners for "Ubah" forms submission
                foreach ($data['projek'] as $projek) :
                ?>
                    document.getElementById('form_ubah_<?= $projek['id_projek'] ?>').addEventListener('submit', function(event) {
                        var startDate = document.getElementById('tanggal_mulai_ubah_<?=$projek['id_projek']?>');
                        var endDate = document.getElementById('tanggal_selesai_ubah_<?=$projek['id_projek']?>');
                        var additionalDate = document.getElementById('tambahan_waktu_ubah_<?=$projek['id_projek']?>');
                        var startError = document.getElementById('tanggalMulaiError_ubah_<?=$projek['id_projek']?>');
                        var endError = document.getElementById('tanggalSelesaiError_ubah_<?=$projek['id_projek']?>');
                        var additionalError = document.getElementById('tanggalTambahanError_ubah_<?=$projek['id_projek']?>');

                        if (!validateDates(startDate, endDate, additionalDate, startError, endError, additionalError)) {
                            event.preventDefault();
                        }
                    });
                <?php endforeach; ?>
            });

              function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '#';
                        preview.style.display = 'none';
                    }
                });
            }

            previewImage('logo1', 'logo1-preview');
            previewImage('logo2', 'logo2-preview');
            previewImage('logo3', 'logo3-preview');

        function previewImageUbah(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "";  // Clear the preview if no file is selected
        }
    }
        </script>