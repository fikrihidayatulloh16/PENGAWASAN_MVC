<style>
    .hidden {
        display: none;
    }
</style>
<!-- 
Ubah Laporan Harian
<div class="modal fade" id="lh-ubah-<?= $laporan['id_laporan_harian'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Laporan Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/operator/ubah_laporan_harian/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_projek" value="<?= $data['projek']['id_projek'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $data['projek']['nama_projek']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" id="tanggal" name="tanggal" value="<?= $laporan['tanggal_laporan']?>" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan :</label>
                                <select id="dropdown" name="id_m_pekerjaan" class="form-select form-select-lg" aria-label="Pilih Pekerjaan">
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    <?php if (!empty($data['m_pekerjaan'])): ?>
                                        <?php foreach ($data['m_pekerjaan'] as $m_pekerjaan) : ?>
                                            <option class="dropdown-item mt-3" value="<?= $m_pekerjaan['id_m_pekerjaan'] ?>"><?= $m_pekerjaan['nama_pekerjaan'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <br>
                            <div id="checkboxes" require>
                            <?php
                                $current_pekerjaan_id = null;
                                foreach ($data['mp_sp'] as $mpsp) :
                                    // Jika pekerjaan baru, buat div baru
                                    if ($mpsp['id_m_pekerjaan'] !== $current_pekerjaan_id) {
                                        // Tutup div sebelumnya jika ada
                                        if ($current_pekerjaan_id !== null) {
                                            echo '</div>';
                                        }
                                        // Buka div baru untuk pekerjaan baru
                                        echo '<div id="' . $mpsp['id_m_pekerjaan'] . '" class="hidden">';
                                        $current_pekerjaan_id = $mpsp['id_m_pekerjaan'];
                                    }
                                ?>
                                <div class="mt-3">
                                        <input class="form-check-input" type="checkbox" name="box_sp[]" value="<?= $data_sp['id_m_sub_pekerjaan']?>" require>
                                        <label class="" for="<?= $data_sp['id_m_sub_pekerjaan']?>"><?= $data_sp['nama_sub_pekerjaan']?></label><br>
                                    </div>
                                <?php endforeach;
                                // Tutup div terakhir setelah selesai looping
                                if ($current_pekerjaan_id !== null) {
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="lh_simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
 -->

<script>
    /*
    document.getElementById('dropdown').addEventListener('change', function() {
        var selectedOption = this.value;
        var checkboxes = document.getElementById('checkboxes').children;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].classList.add('hidden');
        }

        document.getElementById(selectedOption).classList.remove('hidden');
    });

    // Saat halaman dimuat, sembunyikan semua opsi checkbox kecuali yang pertama dipilih
    window.addEventListener('DOMContentLoaded', function() {
        var selectedOption = document.getElementById('dropdown').value;
        var checkboxes = document.getElementById('checkboxes').children;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].classList.add('hidden');
        }

        document.getElementById(selectedOption).classList.remove('hidden');
    });
    */
</script>

<!-- Hapus laporan harian-->
<div class="modal fade" id="lh-hapus-<?=$laporan['id_laporan_harian']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-dark">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Laporan Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_laporan_harian/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id_laporan_harian" value="<?=$laporan['id_laporan_harian']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_laporan_harian" class="form-label">ID</label>
                        <h5 for="id_laporan_harian" class="form-label" id="id_laporan_harian" name="id_laporan_harian" value="<?=$laporan['id_laporan_harian']?>"><?=$laporan['id_laporan_harian']?></h5>
                        <label for="tanggal_laporan" class="form-label">Tanggal</label>
                        <h5 for="tanggal_laporan" class="form-label text-danger"><?=$laporan['tanggal_laporan']?></h5>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="lh-hapus">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
                            