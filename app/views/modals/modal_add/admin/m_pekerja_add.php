<!-- Input Modal -->
<div class="modal fade" id="mpekerja-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5 " id="exampleModalLabel">Tambah Master Pekerja</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/admin/tambah_m_pekerja/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_projek" value="<?= $data['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                    <?php
                        // Ambil nilai terakhir id_m_pekerja dari database
                        $new_id = $this->model('Admin_crud_model')->newIdGenerator('id_m_pekerja', 'm_pekerja', 'PJM', 3)
                    ?>
                        <label for="id_m_pekerja" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerja" class="form-label"><?= $new_id?></h5>
                        <input type="hidden" name="id_m_pekerja" value="<?= $new_id?>">
                        <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                        <input type="text" class="form-control" id="jenis_pekerja" name="jenis_pekerja" placeholder="Masukkan Jenis Pekerja" required><br><br>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>