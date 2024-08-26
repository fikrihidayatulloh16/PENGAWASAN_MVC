<style>
        .image {
            max-width: 638px; /* Batas maksimum lebar gambar sesuai dengan kontainer */
            height: 358.875px; /* Menjaga rasio aspek gambar */
        
        }
</style>

<?php include "../app/views/modals/modal_add/operator/foto_masalah_lh_add.php"; ?>

<!-- Accordion Content -->
<tr style="width: max-content;">
                <?php include '../app/views/modals/modal_add/admin/sub_pekerjaan_add.php'; ?>
                <td class="p-0" colspan="4">
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample<?= $index ?>">
                        <div class="accordion-body">
                            <div class="card">
                                <h5 class="card-header mt-0 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: bold;">Lampiran Foto Permasalahan</span>
                                    <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ftm-tambah-<?= $permasalahan['id_permasalahan'] ?>">
                                        <i class='bx bx-plus-medical'></i> <span class="span-aksi">ADD FOTO</span>
                                    </button>
                                </h5>
                                
                                <table class="table-thick-border m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="col-1">No</th>
                                            <th scope="col">Foto Permasalahan</th>
                                            <th scope="col" class="col-1">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $noftm = 1;
                                        $data['foto_masalah'] = $this->model('Operator_db_model')->getAllFotoMasalahByIDMasalah($permasalahan['id_permasalahan']);
                                        foreach ($data['foto_masalah'] as $foto_masalah): ?>
                                            <tr>
                                                <td><?= $noftm ?></td>
                                                <td><img class="image" src="<?= PUBLICURL ?>/assets/img/uploads/foto_masalah/<?= $foto_masalah['foto_masalah'] ?>" alt="Foto Kegiatan"></td>
                                                <td>
                                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ftm-hapus<?= $foto_masalah['id'] ?>">
                                                        <i class='bx bx-trash'></i>     
                                                    </a>
                                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ftm-ubah<?= $foto_masalah['id'] ?>">
                                                        <i class='bx bxs-edit-alt'></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $noftm++; ?>
                                            <?php include '../app/views/modals/modal_ud/operator/foto_masalah_lh_ud.php'; ?>
                                        <?php endforeach; ?>
                                        <tr><td class="bg-secondary" colspan="3"></td></tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </td>
                </tr>

