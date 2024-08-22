<div class="container">
<div class="card mt-3">
        <h5 class="card-header ">
            Data Tim Pengawas
            
        </h5>
        <table class="table-thick-border">
            <tr>
                <th class="col-6">Tim Pengawas</th>
                <th class="col-6">Tim Leader</th>
            </tr>
            <?php
                $nomor_masalah = 1;
                if (count( $data['tim_pengawas']) > 0) {
                    foreach ($data['tim_pengawas'] as $tim_pengawas) : 
            ?>
            <tr>
                <td class="text-center col-6"><?= $tim_pengawas['tim_pengawas'] ?></td>
                <td class="text-center col-6"><?= $tim_pengawas['tim_leader'] ?></td>
            </tr>
            <?php 
                endforeach;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>