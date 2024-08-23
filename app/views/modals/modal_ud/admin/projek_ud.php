                                <!-- Ubah Modal -->
                                <div class="modal fade" id="projek-ubah-<?=$projek['id_projek']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Projek</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="form_ubah" action="../../script/insert.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="id_projek" value="<?=$projek['id_projek']?>">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id_projek" class="form-label">ID Proyek</label>
                                                    <h5 for="id_projek" class="form-label"><?=$projek['id_projek']?></h5>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_projek" class="form-label">Nama Proyek</label>
                                                    <input type="text" class="form-control" id="nama_projek_ubah_<?=$projek['id_projek']?>" name="nama_projek" value="<?= $projek['nama_projek']?>" placeholder="Masukkan Nama Projek" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_mulai_ubah" class="form-label">Tanggal Mulai</label>
                                                    <input type="date" class="form-control" id="tanggal_mulai_ubah_<?=$projek['id_projek']?>" name="tanggal_mulai_ubah" value="<?= $projek['tanggal_mulai']?>" required>
                                                    <small id="tanggalMulaiError_ubah_<?=$projek['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal mulai tidak boleh lebih awal dari hari ini.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_selesai_ubah" class="form-label">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" id="tanggal_selesai_ubah_<?=$projek['id_projek']?>" name="tanggal_selesai_ubah" value="<?= $projek['tanggal_selesai']?>" required>
                                                    <small id="tanggalSelesaiError_ubah_<?=$projek['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal selesai tidak boleh kurang dari tanggal mulai.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pemilik_pekerjaan_ubah_<?=$projek['id_projek']?>" name="pemilik_pekerjaan" value="<?= $projek['pemilik_pekerjaan']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo1" class="form-label">Logo Pemilik</label>
                                                    <input type="file" class="form-control" id="logo1-ubah-<?=$projek['logo_pemilik']?>" name="logo1" accept="image/*" onchange="previewImageUbah(this, 'logo1-preview-ubah-<?=$projek['logo_pemilik']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo1-preview-ubah-<?=$data['logo_pemilik']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$data['logo_pemilik']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengawas" class="form-label">Pengawas</label>
                                                    <input type="text" class="form-control" id="pengawas_ubah_<?=$projek['id_projek']?>" name="pengawas" value="<?= $projek['pengawas']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo2" class="form-label">Logo Pengawas</label>
                                                    <input type="file" class="form-control" id="logo2-ubah-<?=$projek['logo_pengawas']?>" name="logo2" accept="image/*" onchange="previewImageUbah(this, 'logo2-preview-ubah-<?=$projek['logo_pengawas']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo2-preview-ubah-<?=$projek['logo_pengawas']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$projek['logo_pengawas']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kontraktor" class="form-label">Kontraktor</label>
                                                    <input type="text" class="form-control" id="kontraktor_ubah_<?=$projek['id_projek']?>" name="kontraktor" value="<?= $projek['kontraktor']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo3" class="form-label">Logo Kontraktor</label>
                                                    <input type="file" class="form-control" id="logo3-ubah-<?=$projek['logo_kontraktor']?>" name="logo3" accept="image/*" onchange="previewImageUbah(this, 'logo3-preview-ubah-<?=$projek['logo_kontraktor']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo3-preview-ubah-<?=$projek['logo_kontraktor']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$projek['logo_kontraktor']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="tambahan_waktu_ubah" class="form-label">Tambahan Waktu</label>
                                                    <input type="date" class="form-control" id="tambahan_waktu_ubah_<?=$projek['id_projek']?>" name="tambahan_waktu_ubah" value="<?= $projek['tambahan_waktu']?>">
                                                    <small id="tanggalTambahanError_ubah_<?=$projek['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal Tambahan tidak boleh kurang dari tanggal selesai!.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-warning" name="projek_ubah">Ubah</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="projek-hapus-<?=$projek['id_projek']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Projek</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?= PUBLICURL ?>/admin/hapus_projek" method="POST">
                                            <input type="hidden" name="id_projek" value="<?=$projek['id_projek']?>">
                                            <div class="modal-body">
                                                <p>Apakah anda yakin ingin menghapus data <br><strong><?=$projek['nama_projek']?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" name="projek_hapus">Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>