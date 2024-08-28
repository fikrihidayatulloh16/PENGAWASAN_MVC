<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        Data Permasalahan Harian
        
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

    <hr class="separator">
</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>