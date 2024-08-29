<!-- Menampilkan flash -->
<?php Flasher::flash() ?>

<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        <div>
            Estimasi Progres : <?=$data['laporan']['progress_harian']?>%

        </div>
    </h5>
    </div>

    <hr class="separator">
</div>

<!-- Ubah Modal Progres-->
<div class="modal fade" id="progres-lh-ubah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Progres Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/ubah_progres_lh/<?= $data['id_laporan_harian']?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                <input type="hidden" name="id_laporan_harian" value="<?=$data['id_laporan_harian']?>">
                <input type="hidden" name="tanggal" value="<?=$data['laporan']['tanggal']?>">
                <div class="modal-body">                    
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="progress_harian">Estimasi Progres:</label>
                            <div class="input-group">
                                <input type="number" id="progress_harian" name="progress_harian" class="form-control" placeholder="Masukkan Persentase" step="0.1" min="0" max="100" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success text-light" name="progress_harian_modal">Ubah</button>
                    </div>
            </form>
        </div>
    </div>
</div>