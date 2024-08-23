                            <!-- Ubah Modal -->
                            <div class="modal fade" id="mpekerja-ubah-<?=$data_m_pekerja['id_m_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Pekerja</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/ubah_m_pekerja/<?= $data['id_projek'] ?>" method="POST">
                                        <input type="hidden" name="id_m_pekerja" value="<?=$data_m_pekerja['id_m_pekerja']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_pekerjaan" class="form-label"><?=$data_m_pekerja['id_m_pekerja']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <input type="text" class="form-control" id="jenis_pekerja" name="jenis_pekerja" value="<?= $data_m_pekerja['jenis_pekerja']?>" placeholder="Masukkan Jenis Pekerja" required><br><br>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="bubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="mpekerja-hapus-<?=$data_m_pekerja['id_m_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Pekerja</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/hapus_m_pekerja/<?= $data['id_projek'] ?>" method="POST">
                                    <input type="hidden" name="id_m_pekerja" value="<?=$data_m_pekerja['id_m_pekerja']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID</label>
                                                <h5 for="id_m_pekerjaan" class="form-label" id="id_m_pekerja" name="id_m_pekerja" value="<?= $data_m_pekerja['id_m_pekerja']?>"><?=$data_m_pekerja['id_m_pekerja']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <h5 for="id_m_pekerjaan" class="form-label text-danger"><?=$data_m_pekerja['jenis_pekerja']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="bhapus">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>