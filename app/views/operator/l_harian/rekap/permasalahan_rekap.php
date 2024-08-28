<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        Data Permasalahan Harian
        <a href="<?= PUBLICURL ?>/operator/permasalahan_l_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
        <table class="table-thick-border">
            <tr>
                <th class="col-1">No.</th>
                <th class="col-5">Permasalahan</th>
                <th class="col-5">Saran</th>
            </tr>
            <?php
                $nomor_masalah = 1;

                if (count($data['permasalahan']) > 0) {
                    foreach ($data['permasalahan'] as $permasalahan) : 
            ?>
            <tr>
                <td class="text-center"><?= $nomor_masalah ?></td>
                <td style="text-align: justify; vertical-align: top;"><?= !empty($permasalahan['permasalahan']) ? $permasalahan['permasalahan'] : '-' ?></td>
                <td style="text-align: justify; vertical-align: top;"><?= !empty($permasalahan['saran']) ? $permasalahan['saran'] : '-' ?></td>
            </tr>
            
            <?php 
                $nomor_masalah++; 
                //include "operator.modal/modalUD.permasalahan.php";
                endforeach;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data permasalahan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/laporan_harian_list/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>

    <hr class="separator">
</div>