<!-- cadangan untuk accordion tetap terbuka dengan menggunakan session -->
<!-- Daftar Sub Pekerjaan Dengan Accordion -->

<?php include '../app/views/modals/modal_add/admin/sub_pekerjaan_add.php'; ?>

<tr>
    <td class="p-0" colspan="3">
        <div id="collapseOne<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>" class="accordion-collapse collapse <?= (isset($_SESSION['openAccordion']) && $_SESSION['openAccordion'] == $data_m_pekerjaan['id_m_pekerjaan']) ? 'show' : '' ?>" data-bs-parent="#accordionExample">
            <div class="accordion-body p-0">
                <div class="card ">
                    <h5 class="card-header bg-info text-dark mt-0 d-flex justify-content-between align-items-center">
                        <span style="font-weight: bold;">Sub <?= $data_m_pekerjaan['nama_pekerjaan'] ?></span>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sub-tambah-<?= $data_m_pekerjaan['id_m_pekerjaan'] ?>">
                            <i class='bx bx-plus-medical' width='500px' name="btambah"></i> <span class="span-aksi">Add</span>
                        </button>
                    </h5>
                    
                    <table class="table bg-light table-striped table-borderless m-0">
                        <thead>
                            <tr class="bg-light">
                                <th class=" align-middle  col-2">ID</th>
                                <th class="align-middle">Nama Sub pekerjaan</th>
                                <th class="align-middle col-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //menampilkan data
                            $id_pekerjaan = $data_m_pekerjaan['id_m_pekerjaan'];
                            $tampil_sub = $this->model('Admin_db_model')->getAllSubpekerjaanByIdMP($id_pekerjaan);
                            foreach ($tampil_sub as $data_sub) :
                            ?>
                            <tr class="bg-light">
                                <td class="align-middle bg-light"><?= $data_sub['id_m_sub_pekerjaan'] ?></td>
                                <td class="align-middle bg-light"><?= $data_sub['nama_sub_pekerjaan'] ?></td>
                                <td class="align-middle bg-light">
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#subHapus<?= $data_sub['id_m_sub_pekerjaan']?>"><i class='bx bxs-trash-alt'></i><span class="span-aksi"> Delete</span></a>
                                    <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#subUbah<?= $data_sub['id_m_sub_pekerjaan'] ?>"><i class='bx bxs-edit-alt'></i><span class="span-aksi"> Edit</span></a>
                                </td>
                            </tr>
                            
                            <?php //include "modal.admin/modalUD_sub.php";?>
                            <?php endforeach; ?>
                            <tr><td class="bg-info" colspan="3"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>