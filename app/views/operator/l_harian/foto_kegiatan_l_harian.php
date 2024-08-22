<?php
/*
//mengambil nilai sesi
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

<style>
        .image {
            max-width: 638px; /* Batas maksimum lebar gambar sesuai dengan kontainer */
            height: 358.875px; /* Menjaga rasio aspek gambar */
        
        }
</style>

<?php include '../app/views/modals/modal_add/operator/foto_kegiatan_lh_add.php' ?>

<div class="container mt-5">
    <div class="card mt-3">
        <h5 class="card-header">
            Data Foto Kegiatan 
            <button type="button-center" class="btn btn-tambah ms-3 mt-3" data-bs-toggle="modal" data-bs-target="#fk_tambah">
            <i class='bx bx-plus-medical' style="margin-right: 5px;"></i>ADD
            </button>
        </h5>
        <div class="table-responsive">
            <table class="table-thick-border" style="width: 100%;">
                <tr>
                    <th class="col-1">No.</th>
                    <th class="col-4">Foto</th>
                    <th class="col-3">Keterangan</th>
                    <th class="col-2">Aksi</th>
                </tr>
                <?php
                    
                    $nomor = 1;

                    if (count($data['foto_kegiatan']) > 0) {
                        foreach ($data['foto_kegiatan'] as $foto_kegiatan) : 
                ?>
                <tr>
                    <td class="text-center"><?= $nomor ?></td>
                    <td class="text-center"><img class="image" src="<?= PUBLICURL ?>/assets/img/uploads/foto_kegiatan/<?= $foto_kegiatan['foto'] ?>" alt="Foto Kegiatan"></td>
                    <td class="text-center"><?= $foto_kegiatan['keterangan'] ?></td>
                    <td class="text-center">
                        <form action="../../script/operator_crud.php" method="POST">
                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#fk_hapus<?= $foto_kegiatan['id_foto_kegiatan'] ?>">
                                <i class='bx bx-trash' ></i>
                            </a>
                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#fk_ubah<?= $foto_kegiatan['id_foto_kegiatan'] ?>">
                                <i class='bx bxs-edit-alt'></i>
                            </a>
                            <input type="hidden" name="id_laporan_harian" value="<?= $foto_kegiatan['id_laporan_harian'] ?>">
                        </form>
                    </td>
                </tr>
                <?php 
                    $nomor++; 
                    include "../app/views/modals/modal_ud/operator/foto_kegiatan_lh_ud.php";
                    endforeach;
                    } else { 
                ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data Foto Kegiatan.</td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <a href="<?= PUBLICURL ?>/operator/rekap/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali 
    </a>
</div>