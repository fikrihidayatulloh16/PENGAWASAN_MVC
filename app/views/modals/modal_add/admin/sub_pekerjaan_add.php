<!-- Tambah Modal -->
<div class="modal fade" id="sub-tambah-<?= $item['id_m_pekerjaan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Sub Pekerjaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/admin/tambah_sub_pekerjaan/<?= $data['id_projek'] ?>" method="POST">
            <input type="hidden" name="id_m_pekerjaan" value="<?= $item['id_m_pekerjaan']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_sub_pekerjaan dari database
                        $new_id = $this->model('Admin_crud_model')->newIdGenerator('id_m_sub_pekerjaan', 'm_sub_pekerjaan', 'SP', 6);
                        ?>
                        <label for="id_m_sub_pekerjaan" class="form-label">ID Sub Pekerjaan (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_sub_pekerjaan" class="form-label"><?= $new_id ?></h5>
                        <input type="hidden" name="id_m_sub_pekerjaan" value="<?= $new_id?>">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <h5 for="nama_pekerjaan" class="form-label">Sub <?= $item['nama_pekerjaan'] ?></h5>
                        <label for="nama_sub_pekerjaan" class="form-label">Nama Sub Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_sub_pekerjaan" name="nama_sub_pekerjaan" placeholder="Masukkan Nama Sub Pekerjaan"required><br><br>
                    </div>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="sub_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>