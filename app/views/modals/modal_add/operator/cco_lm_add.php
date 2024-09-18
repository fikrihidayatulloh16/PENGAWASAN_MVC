<!-- tambah cco-->
<div class="modal fade" id="ccolm-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data CCO<?= $next_cco ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/laporanmingguan/tambah_cco/<?= $data['id_projek'] ?>/<?= $data['max_cco'] ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Peringatan!!</strong><br>
                        <p>Semua data yang di dalam <strong><?= $data['max_cco'] == 0 ? 'Kontrak Awal' : 'CCO' . $data['max_cco'] ?></strong> akan ditambahkan ke <strong>CCO<?= $next_cco ?></strong>
                        dan data pada <strong><?= $data['max_cco'] == 0 ? 'Kontrak Awal' : 'CCO' . $data['max_cco'] ?> tidak akan bisa diubah lagi!.</strong></p>
                        <p>Apakah anda yakin ingin menambahkan data? </p>
                    </div>

                    <div class="form-group">
                        <label for="pekerjaan">Pilih Tanggal Pengesahan CCO :</label><br><br>
                        <input type="date" id="tanggal" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-success" name="lh-hapus">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('dropdown').addEventListener('change', function () {
        var selectedValue = this.value;
        if (selectedValue) {
            var dates = JSON.parse(selectedValue);
            document.getElementById('tanggal_mulai').innerText = new Date(dates.start).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            document.getElementById('tanggal_selesai').innerText = new Date(dates.end).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

            // Set the hidden input values
            document.getElementById('hidden_tanggal_mulai').value = dates.start;
            document.getElementById('hidden_tanggal_selesai').value = dates.end;
        }
    });
</script>