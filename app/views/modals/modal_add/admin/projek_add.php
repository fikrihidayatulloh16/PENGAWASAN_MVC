<!-- Modal Tambah Proyek -->
<div class="modal fade" id="projek-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_tambah" action="<?= PUBLICURL ?>/admin/tambah_projek/" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <?php 
                                $id_projek = $this->model('Admin_crud_model')->newIdGenerator('id_projek', 'm_projek', 'PRJ', 3);
                                ?>
                                <label for="id_projek" class="form-label">ID(tidak bisa diubah)</label>
                                <h5 for="id_projek" class="form-label"><?=$id_projek?></h5>
                                <input type="hidden" name="id_projek" value="<?= $id_projek?>">
                                <label for="nama_projek" class="form-label">Nama Proyek</label>
                                <input type="text" class="form-control" id="nama_projek" name="nama_projek" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_mulai_tambah" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai_tambah" name="tanggal_mulai_tambah" required>
                                <small id="tanggalMulaiError_tambah" class="form-text text-danger" style="display:none;">Tanggal mulai tidak boleh lebih awal dari hari ini.</small>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai_tambah" name="tanggal_selesai_tambah" required>
                                <small id="tanggalSelesaiError_tambah" class="form-text text-danger" style="display:none;">Tanggal selesai tidak boleh kurang dari tanggal mulai.</small>
                            </div>

                            <div class="mb-3">
                                <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                <input type="text" class="form-control" id="pemilik_pekerjaan" name="pemilik_pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="logo1" class="form-label">Logo Pemilik</label>
                                <input type="file" class="form-control" id="logo1" name="logo1" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo1-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pengawas" class="form-label">Pengawas</label>
                                <input type="text" class="form-control" id="pengawas" name="pengawas" required>
                            </div>
                            <div class="mb-3">
                                <label for="logo2" class="form-label">Logo Pengawas</label>
                                <input type="file" class="form-control" id="logo2" name="logo2" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo2-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kontraktor" class="form-label">Kontraktor</label>
                                <input type="text" class="form-control" id="kontraktor" name="kontraktor" required>
                            </div>
                            <div class="mb-3">
                                <label for="logo3" class="form-label">Logo Kontraktor</label>
                                <input type="file" class="form-control" id="logo3" name="logo3" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo3-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tambahan_waktu_tambah" class="form-label">Tambahan Waktu</label>
                                <input type="date" class="form-control" id="tambahan_waktu_tambah" name="tambahan_waktu_tambah">
                                <small id="tanggalTambahanError_tambah" class="form-text text-danger" style="display:none;">Tanggal Tambahan tidak boleh kurang dari tanggal selesai!.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="projek_simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>