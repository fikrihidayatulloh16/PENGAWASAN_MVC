<!-- Ubah Modal -->
<div class="modal fade" id="mpekerjaan-ubah-<?=$item['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/ubah_m_pekerjaan/<?= $data['id_projek'] ?>" method="POST">
                                        <input type="hidden" name="id_m_pekerjaan" value="<?=$item['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_pekerjaan" class="form-label"><?=$item['id_m_pekerjaan']?></h5>
                                                <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                                <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="<?= $item['nama_pekerjaan']?>" placeholder="Masukkan Nama Pekerjaan" required><br><br>
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
                            <div class="modal fade" id="mpekerjaan-hapus-<?=$item['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= PUBLICURL ?>/admin/hapus_m_pekerjaan/<?= $data['id_projek'] ?>" method="POST">
                                    <input type="hidden" name="id_m_pekerjaan" value="<?=$item['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID</label>
                                                <h5 for="id_m_pekerjaan" class="form-label" id="id_m_pekerjaan" name="id_m_pekerjaan" value="<?= $item['id_m_pekerjaan']?>"><?=$item['id_m_pekerjaan']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <h5 for="id_m_pekerjaan" class="form-label text-danger"><?=$item['nama_pekerjaan']?></h5>
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