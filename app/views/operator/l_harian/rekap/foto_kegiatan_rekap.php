<style>
    .image-container {
    max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
    height: 350px; /* Menjaga rasio aspek gambar */
    
}

.image-container .image-rekap {
    max-width: max-content; /* Gambar akan menyesuaikan dengan lebar kontainer */
    height: 300px; /* Menjaga rasio aspek gambar */
    
}
</style>

<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        Data Lampiran Foto Kegiatan
        <a href="<?= PUBLICURL ?>/operator/foto_kegiatan/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
    <div class="card-body">
        <div class="container">
            <?php
                if (count($data['foto_kegiatan']) > 0) {
                    $num_row = 0;
                    foreach ($data['foto_kegiatan'] as $foto_kegiatan) {
                        if ($num_row % 2 == 0) {
                            // Mulai baris baru untuk setiap dua gambar
                            echo '<div class="row mt-lg-3">';
                        }
            ?>
            <div class="image-container text-center col-lg-6 col-sm-12">
                <img src="<?= PUBLICURL ?>/assets/img/uploads/foto_kegiatan/<?= $foto_kegiatan['foto'] ?>" alt="Foto Kegiatan" class="img-fluid image-rekap mt-3"><br><?= $foto_kegiatan['keterangan'] ?>
            </div>
            <?php
                        $num_row++;
                        if ($num_row % 2 == 0) {
                            // Tutup baris setelah dua gambar
                            echo '</div>';
                        }
                    }
                    if ($num_row % 2 != 0) {
                        // Tutup baris jika ada gambar ganjil
                        echo '</div>';
                    }
                } else {
            ?>
            <div class="row">
                <div class="col-12 text-center">Tidak ada data Foto Kegiatan.</div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/laporan_harian_list/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>
<hr class="separator">
</div>
