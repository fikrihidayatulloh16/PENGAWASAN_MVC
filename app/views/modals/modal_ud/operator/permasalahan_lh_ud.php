    <!-- Ubah Modal Permasalahan-->
    <div class="modal fade" id="ph-ubah<?= $permasalahan['id_permasalahan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Permasalahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/ubah_permasalahan/<?= $data['id_laporan_harian']?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_permasalahan" value="<?=$permasalahan['id_permasalahan']?>">
                <div class="modal-body">                    
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="id_permasalahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                            <h5 for="id_permasalahan" class="form-label"><?=$permasalahan['id_permasalahan']?></h5>
                        </div>

                        <div class="form-group">
                            <label for="permasalahan">Permasalahan:</label>
                            <textarea type="text" id="permasalahan" name="permasalahan" class="form-control"  rows="3" placeholder="Masukkan Permasalahan"><?= $permasalahan['permasalahan']?></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="saran">Saran :</label>
                            <textarea type="text" id="saran" name="saran" class="form-control"  rows="3" maxlength="255" placeholder="Masukkan Saran"><?= $permasalahan['saran']?></textarea>
                        </div>
                    </div>
                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-light" name="masalah_ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Modal Permasalahan-->
<div class="modal fade" id="ph-hapus<?= $permasalahan['id_permasalahan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Permasalahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_permasalahan/<?= $data['id_laporan_harian']?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_permasalahan" value="<?=$permasalahan['id_permasalahan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="id_permasalahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                            <h5 for="id_permasalahan" class="form-label"><?= $permasalahan['id_permasalahan'] ?></h5>
                        </div>

                        <div class="form-group">
                            <label for="permasalahan">Permasalahan:</label>
                            <h5 for="id_permasalahan" class="form-label text-danger"><?= $permasalahan['permasalahan']?></h5>
                          
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="saran">Saran :</label>
                            <h5 for="id_permasalahan" class="form-label text-danger"><?= $permasalahan['saran']?></h5>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="masalah_hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
                            