<!-- Modal -->
<div class="modal fade" id="malat-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Peralatan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/admin/tambah_m_peralatan/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_projek" value="<?= $data['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_pekerja dari database
                        $new_id = $this->model('Admin_crud_model')->newIdGenerator('id_m_peralatan', 'm_peralatan', 'MPRLTN', 3);
                        ?>
                        <label for="id_m_peralatan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_peralatan" class="form-label"><?= $new_id ?></h5>
                        <input type="hidden" name="id_m_peralatan" value="<?= $new_id?>">
                        <label for="nama_alat" class="form-label">Nama Alat</label>
                        <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="Masukkan Nama Alat"required><br><br>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Masukkan Satuan"required><br><br>
                    </div>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="alat_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>