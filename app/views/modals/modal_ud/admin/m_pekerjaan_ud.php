<!-- Ubah Modal -->
<div class="modal fade" id="modalUbah<?=$data['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                        <input type="hidden" name="id_m_pekerjaan" value="<?=$data['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_pekerjaan" class="form-label"><?=$data['id_m_pekerjaan']?></h5>
                                                <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                                <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="<?= $data['nama_pekerjaan']?>" placeholder="Masukkan Nama Pekerjaan" required><br><br>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="pekerjaan_ubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                    <input type="hidden" name="id_m_pekerjaan" value="<?=$data['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID</label>
                                                <h5 for="id_m_pekerjaan" class="form-label" id="id_m_pekerjaan" name="id_m_pekerjaan" value="<?= $data['id_m_pekerjaan']?>"><?=$data['id_m_pekerjaan']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <h5 for="id_m_pekerjaan" class="form-label text-danger"><?=$data['nama_pekerjaan']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="pekerjaan_hapus">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>