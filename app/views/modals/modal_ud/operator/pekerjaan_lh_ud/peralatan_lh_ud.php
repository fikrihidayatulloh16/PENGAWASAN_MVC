<!-- Ubah Peralatan Modal -->
<div class="modal fade" id="ph-peralatan-ubah-<?=$data_peralatan['id_peralatan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Peralatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/ubah_peralatan_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_peralatan" value="<?=$data_peralatan['id_peralatan']?>">
                <input type="hidden" name="id_m_peralatan" value="<?=$data_peralatan['id_m_peralatan']?>">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label class="form-label">Projek:</label>
                            <p class="mb-0"><?= $data['projek']['nama_projek']?></p>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown-peralatan" class="form-label">Nama Peralatan:</label>
                            <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_peralatan['nama_alat']?></h5>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-peralatan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-peralatan" name="jumlah_peralatan" value="<?=$data_peralatan['jumlah_peralatan']?>" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $data['id_laporan_harian']?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $sub['id_m_sub_pekerjaan']?>">
                    </div>
                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white" name="ph-peralatan-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Peralatan Pekerja-->
<div class="modal fade" id="ph-peralatan-hapus-<?=$data_peralatan['id_peralatan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Peralatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_peralatan_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_peralatan" value="<?=$data_peralatan['id_peralatan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_peralatan" class="form-label">ID</label>
                        <h5 for="id_peralatan" class="form-label" id="id_peralatan" name="id_peralatan" value="<?= $data_peralatan['id_peralatan']?>"><?=$data_peralatan['id_peralatan']?></h5>
                        <label for="nama_alat" class="form-label">Nama Peralatan</label>
                        <h5 for="nama_alat" class="form-label text-danger"><?=$data_peralatan['nama_alat']?></h5>
                        <label for="jumlah_peralatan" class="form-label">Jumlah</label>
                        <h5 for="jumlah_peralatan" class="form-label text-danger"><?=$data_peralatan['jumlah_peralatan']?> <?=$data_peralatan['satuan']?></h5>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-peralatan-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>