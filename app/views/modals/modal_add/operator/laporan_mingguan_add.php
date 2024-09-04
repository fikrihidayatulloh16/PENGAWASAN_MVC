<style>
    .hidden {
        display: none;
    }
</style>

<!-- Tambah Modal -->
<div class="modal fade" id="lm_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Laporan Mingguan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/laporanmingguan/tambah_laporan_mingguan/<?= $data['id_projek'] ?>" method="POST">
                <!-- membuat id baru -->
                <?php $new_id = $this->model('Admin_crud_model')->newIdGenerator('id_laporan_mingguan', 'laporan_mingguan', 'LM', 6); ?>
                <input type="hidden" name="id_projek" value="<?= $data['id_projek'] ?>">
                <input type="hidden" name="id_laporan_mingguan" value="<?= $new_id ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $data['projek']['nama_projek']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan">Minggu Ke- :</label>
                                <select id="dropdown" name="id_m_pekerjaan" class="form-select form-select-lg" aria-label="Pilih Pekerjaan" required>
                                    <option value="" disabled selected>Pilih Minggu Ke-</option>
                                    <?php if (!empty($data['all_minggu'])): ?>
                                        <?php 
                                            $nomor = 1;
                                            foreach ($data['all_minggu'] as $minggu) : ?>
                                            <option class="dropdown-item mt-3" 
                                                    value='<?= json_encode(["start" => $minggu["start"], "end" => $minggu["end"]]) ?>'>
                                                Minggu Ke-<?= $nomor ?>
                                            </option>
                                        <?php 
                                            $nomor++;
                                            endforeach; 
                                        ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <br>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="rencana_progres">Rencana Progres:</label>

                                    <div class="input-group">
                                        <input type="number" id="rencana_progres" name="rencana_progres" class="form-control" placeholder="Masukkan Persentase" step="0.1" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="realisasi_progres">Realisasi Progres:</label>

                                    <div class="input-group">
                                        <input type="number" id="realisasi_progres" name="realisasi_progres" class="form-control" placeholder="Masukkan Persentase" step="0.1" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <h5 id="tanggal_mulai">-</h5>
                                <input type="hidden" name="tanggal_mulai" id="hidden_tanggal_mulai">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai:</label>
                                <h5 id="tanggal_selesai">-</h5>
                                <input type="hidden" name="tanggal_selesai" id="hidden_tanggal_selesai">
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
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
