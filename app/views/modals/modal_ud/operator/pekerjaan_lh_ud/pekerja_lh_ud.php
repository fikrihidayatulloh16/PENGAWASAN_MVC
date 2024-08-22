<!-- Ubah Pekerja Modal -->
<div class="modal fade" id="ph-pekerja-ubah-<?=$data_pekerja['id_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Pekerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/ubah_pekerja_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_pekerja" value="<?=$data_pekerja['id_pekerja']?>">
                <input type="hidden" name="id_m_pekerja" value="<?=$data_pekerja['id_m_pekerja']?>">
                <div class="modal-body">
                <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $_SESSION['nama_projek_op']?></h5>
                                <h5><?= $_SESSION['id_projek_op']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerja :</label>
                                <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_pekerja['jenis_pekerja']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="jumlah_pekerja">Jumlah :</label>
                                <input class="form-control" type="number" name="jumlah_pekerja" value="<?= $data_pekerja['jumlah_pekerja'] ?>" placeholder="Masukkan jumlah " required>
                            </div>
                        
                             <!-- input tambahan yang diperlukan -->
                            <div class="form-group">
                                <input type="hidden" name="id_laporan_harian" value="<?= $data['id_laporan_harian']?>">
                                <input type="hidden" name="id_sub_pekerjaan" value="<?= $sub['id_m_sub_pekerjaan']?>">
                                
                            </div>
                        
                        </div>
                    </div>
                </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white" name="ph-pekerja-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Modal Pekerja-->
<div class="modal fade" id="ph-pekerja-hapus-<?=$data_pekerja['id_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Pekerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_pekerja_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_pekerja" value="<?=$data_pekerja['id_pekerja']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_pekerja" class="form-label">ID</label>
                        <h5 for="id_pekerja" class="form-label" id="id_pekerja" name="id_pekerja" value="<?= $data_pekerja['id_pekerja']?>"><?=$data_pekerja['id_pekerja']?></h5>
                        <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                        <h5 for="nama_sub_pekerjaan" class="form-label text-danger"><?=$data_pekerja['jenis_pekerja']?></h5>
                        <label for="jenis_pekerja" class="form-label">Jumlah</label>
                        <h5 for="nama_sub_pekerjaan" class="form-label text-danger"><?=$data_pekerja['jumlah_pekerja']?> Orang</h5>
                    </div>
                </div>
                                    
                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-pekerja-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>