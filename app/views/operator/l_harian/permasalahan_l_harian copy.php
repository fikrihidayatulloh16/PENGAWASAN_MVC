<?php Flasher::flash() ?>

<div class="container mt-5">

<?php include "../app/views/modals/modal_add/operator/permasalahan_lh_add.php"; ?>
    
    <div class="card mt-3">
        <h5 class="card-header">
            Data Permasalahan Harian
            <button type="button-center" class="btn btn-tambah ms-3 mt-3" data-bs-toggle="modal" data-bs-target="#ph-tambah">
                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="masalah_tambah"></i><span>ADD</span>
            </button>
        </h5>
        
        <table class="table-thick-border">
            <tr>
                <th>No.</th>
                <th class="col-5">Permasalahan</th>
                <th class="col-5">Saran</th>
                <th class="col-2">Aksi</th>
            </tr>
            <?php

                $nomor_masalah = 1;

                if (count($data['permasalahan']) > 0) {
                    foreach ($data['permasalahan'] as $permasalahan) : 
            ?>
            <tr>
                <td class="text-center"><?= $nomor_masalah ?></td>
                <td style="text-align: justify; vertical-align: top;"><?= $permasalahan['permasalahan'] ?></td>
                <td style="text-align: justify; vertical-align: top;"><?= $permasalahan['saran'] ?></td>
                <td class="text-center">
                    <form action="<?= PUBLICURL ?>/operator/tambah_permasalahan/<?= $data['id_projek'] ?>" method="POST">
                        <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-hapus<?= $permasalahan['id_permasalahan'] ?>">
                            <i class='bx bx-trash' ></i>     
                        </a>
                        <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-ubah<?= $permasalahan['id_permasalahan'] ?>">
                            <i class='bx bxs-edit-alt'></i> 
                        </a>
                        <input type="hidden" name="id_laporan" value="<?= $permasalahan['id_laporan_harian'] ?>">
                    </form>
                </td>
            </tr>
            <?php 
                include "../app/views/modals/modal_ud/operator/permasalahan_lh_ud.php";
                $nomor_masalah++; 
                
                endforeach;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data permasalahan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/rekap/<?=$data['id_laporan_harian']?>/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>
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