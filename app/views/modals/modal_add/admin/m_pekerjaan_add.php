<!-- Modal Tambah M Pekerjaan -->
<div class="modal fade" id="mpekerjaan-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Pekerjaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/admin/tambah_m_pekerjaan/<?= $data['id_projek'] ?>" method="POST">
            <input type="hidden" name="id_projek" value="<?=  $data['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_pekerjaan dari database
                        $new_id = $this->model('Admin_crud_model')->newIdGenerator('id_m_pekerjaan', 'm_pekerjaan', 'P', 4);
                        ?>
                        <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerjaan" class="form-label"><?=$new_id?></h5>
                        <input type="hidden" name="id_m_pekerjaan" value="<?=  $new_id?>">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" placeholder="Masukkan Nama Pekerjaan"required><br><br>
                    </div>
                </div>
                
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="pekerjaan_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>