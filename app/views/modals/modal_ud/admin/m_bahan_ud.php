                            <!-- Ubah Modal -->
                            <div class="modal fade" id="modalUbah<?=$data_m_bahan['id_m_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Master Bahan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/ubah_m_bahan/<?= $data['id_projek'] ?>" method="POST">
                                        <input type="hidden" name="id_m_bahan" value="<?=$data_m_bahan['id_m_bahan']?>">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_m_bahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_bahan" class="form-label"><?=$data_m_bahan['id_m_bahan']?></h5>
                                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                                <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" value="<?= $data_m_bahan['nama_bahan']?>" placeholder="Masukkan Nama Bahan" required><br><br>
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $data_m_bahan['satuan']?>" placeholder="Masukkan satuan" required><br><br>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="bahan_ubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data_m_bahan['id_m_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Master Bahan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/hapus_m_bahan/<?= $data['id_projek'] ?>" method="POST">
                                    <input type="hidden" name="id_m_bahan" value="<?=$data_m_bahan['id_m_bahan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_bahan" class="form-label">ID</label>
                                                <h5 for="id_m_bahan" class="form-label" id="id_m_bahan" name="id_m_bahan" value="<?= $data_m_bahan['id_m_bahan']?>"><?=$data_m_bahan['id_m_bahan']?></h5>
                                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                                <h5 for="nama_bahan" class="form-label text-danger"><?=$data_m_bahan['nama_bahan']?></h5>
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <h5 for="satuan" class="form-label text-danger"><?=$data_m_bahan['satuan']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="bahan_hapus">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>