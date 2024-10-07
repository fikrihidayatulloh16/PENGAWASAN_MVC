<!-- tambah cco-->
<div class="modal fade" id="ccolm-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data CCO<?= $next_cco ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formTambahCco" action="<?= PUBLICURL ?>/laporanmingguan/tambah_cco/<?= $data['id_projek'] ?>/<?= $data['max_cco'] ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Peringatan!!</strong><br>
                        <p>Semua data yang di dalam <strong><?= $data['max_cco'] == 0 ? 'Kontrak Awal' : 'CCO' . $data['max_cco'] ?></strong> akan ditambahkan ke <strong>CCO<?= $next_cco ?></strong>
                        dan data pada <strong><?= $data['max_cco'] == 0 ? 'Kontrak Awal' : 'CCO' . $data['max_cco'] ?> tidak akan bisa diubah lagi!.</strong></p>
                        <p>Apakah anda yakin ingin menambahkan data? </p>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan">Pilih Tanggal Pengesahan CCO :</label><br><br>
                        <input type="date" id="tanggalInput" name="tanggal_selesai" data-start="<?= $data['all_laporan_mingguan'][$data['max_cco']][0]['tanggal_rubah_cco'.$data['max_cco']] ?>" 
                        data-end="<?= ($data['projek']['tambahan_waktu'] != NULL ? $data['projek']['tambahan_waktu'] : $data['projek']['tanggal_selesai']) ?>"
                        class="form-control" required>
                        <small id="tanggalError_tambahcco" class="text-danger" style="display: none;">*Tanggal harus dalam rentang dan lebih dari cco<?= $data['max_cco'] ?>.</small>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" id="submitButton" class="btn btn-success" name="lh-hapus">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>

</script>

<script src="<?= PUBLICURL ?>/assets/js/datevalidator_lm.js"></script>