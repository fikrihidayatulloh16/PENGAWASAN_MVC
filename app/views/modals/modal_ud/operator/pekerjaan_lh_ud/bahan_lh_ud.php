<!-- Ubah Peralatan Modal -->
<div class="modal fade" id="ph-bahan-ubah-<?=$data_bahan['id_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Bahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/ubah_bahan_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_bahan" value="<?=$data_bahan['id_bahan']?>">
                <input type="hidden" name="id_m_bahan" value="<?=$data_bahan['id_m_bahan']?>">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label for="dropdown-bahan" class="form-label">Nama Bahan:</label>
                            <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_bahan['nama_bahan']?></h5>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-bahan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-bahan" name="jumlah_bahan" value="<?=$data_bahan['jumlah_bahan']?>" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $data['id_laporan_harian']?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $sub['id_m_sub_pekerjaan']?>">
                    </div>
                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-light" name="ph-bahan-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus bahan-->
<div class="modal fade" id="ph-bahan-hapus-<?=$data_bahan['id_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Bahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_bahan_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_bahan" value="<?=$data_bahan['id_bahan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_bahan" class="form-label">ID</label>
                        <h5 for="id_bahan" class="form-label" id="id_bahan" name="id_bahan" value="<?=$data_bahan['id_bahan']?>"><?=$data_bahan['id_bahan']?></h5>
                        <label for="nama_bahan" class="form-label">Nama Peralatan</label>
                        <h5 for="nama_bahan" class="form-label text-danger"><?=$data_bahan['nama_bahan']?></h5>
                        <label for="jumlah_bahan" class="form-label">Jumlah</label>
                        <h5 for="jumlah_bahan" class="form-label text-danger"><?=$data_bahan['jumlah_bahan']?> <?=$data_bahan['satuan']?></h5>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-bahan-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>