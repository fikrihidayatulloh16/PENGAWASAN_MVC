<?php
/*
    if (empty($_SESSION['id_laporan_harian'])) {
        if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
            $id_laporan_harian = $_GET['id_laporan_harian'];
            $tanggal_laporan = $_GET['tanggal_laporan'];
            $nomor = $_GET['nomor'];

            $_SESSION['id_laporan_harian'] = $id_laporan_harian;
            $_SESSION['tanggal_laporan'] = $tanggal_laporan;
            $_SESSION['nomor'] = $nomor;
        }
    }
    */
?>
    
<?php include '../app/views/modals/modal_add/operator/tim_pengawas_lh_add.php'; ?>

<div class="container mt-5">
    <div class="card mt-3">
        <h5 class="card-header">
            Data Tim Pengawas
            <button type="button-center" class="btn btn-tambah ms-3 mt-3" data-bs-toggle="modal" data-bs-target="#pengawas-tambah">
                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="pengawas_tambah"></i> Tambah
            </button>
        </h5>
        <table class="table-thick-border">
            <tr>
                <th>Tim Pengawas</th>
                <th>Tim Leader</th>
                <th class="col-2">Aksi</th>
            </tr>
            <?php
                $nomor_masalah = 1;

                if (count( $data['tim_pengawas']) > 0) {
                    foreach ( $data['tim_pengawas'] as $tim_pengawas) : 
            ?>
            <tr>
                <td class="text-center"><?= $tim_pengawas['tim_pengawas'] ?></td>
                <td class="text-center"><?= $tim_pengawas['tim_leader'] ?></td>
                <td class="text-center">
                    <form action="../../script/projek_pilih.php" method="POST">
                        <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#pengawas-hapus-<?= $tim_pengawas['id_tim_pengawas'] ?>">
                        <i class='bx bx-trash' ></i>
                        </a>
                        <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#pengawas-ubah-<?= $tim_pengawas['id_tim_pengawas'] ?>">
                            <i class='bx bxs-edit-alt'></i>
                        </a>
                        <input type="hidden" name="id_laporan" value="<?= $tim_pengawas['id_tim_pengawas'] ?>">
                    </form>
                </td>
            </tr>
            <?php 
                $nomor_masalah++; 
                include '../app/views/modals/modal_ud/operator/tim_pengawas_lh_ud.php';
                endforeach;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <a href="" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>
