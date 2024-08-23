<style>
    .hidden {
        display: none;
    }
</style>

<!-- Tambah Modal -->
<div class="modal fade" id="lh_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Laporan Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/operator/tambah_laporan_harian/<?= $data['id_projek'] ?>" method="POST">
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
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                <small id="tanggalError_tambah" class="text-danger" style="display: none;">*Tanggal harus dalam rentang.</small>
                                <small id="tanggalError2_tambah" class="text-danger" style="display: none;">*Tanggal sudah dipilih.</small>
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
                            <div id="checkboxes" class="form-group">
                                <?php
                                $current_pekerjaan_id = null;
                                foreach ($data['mp_sp'] as $mpsp) :
                                    if ($mpsp['id_m_pekerjaan'] !== $current_pekerjaan_id) {
                                        if ($current_pekerjaan_id !== null) {
                                            echo '</div>';
                                        }
                                        echo '<div id="' . $mpsp['id_m_pekerjaan'] . '" class="hidden">';
                                        $current_pekerjaan_id = $mpsp['id_m_pekerjaan'];
                                    }
                                ?>
                                <div class="mt-3">
                                    <input class="form-check-input" type="checkbox" name="box_sp[]" value="<?= $mpsp['id_m_sub_pekerjaan']?>" require>
                                    <label for="<?= $mpsp['id_m_sub_pekerjaan']?>"><?= $mpsp['nama_sub_pekerjaan']?></label><br>
                                </div>
                                <?php endforeach;
                                if ($current_pekerjaan_id !== null) {
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <br>
                            <small id="checkboxError" class="text-danger" style="display: none;">Data Pekerjaan Wajib di isi.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$list_tanggal_laporan = $data['all_tanggal_laporan'];
$tanggal_mulai = $data['projek']['tanggal_mulai'];
$tanggal_selesai = $data['projek']['tanggal_selesai'];
$tambahan_waktu = $data['projek']['tambahan_waktu'];

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Mengambil list tanggal laporan dari PHP
    var existingDates = <?= json_encode($list_tanggal_laporan); ?>;
    
    // Fungsi untuk memvalidasi tanggal
    function validateDateRange(startDate, endDate, additionalDate, inputDate, errorElement) {
        var startDateValue = new Date(startDate);
        var endDateValue = new Date(endDate);
        var inputDateValue = new Date(inputDate.value);
        var additionalDateValue = additionalDate ? new Date(additionalDate) : null;

        errorElement.style.display = 'none';

        // Validasi apakah tanggal dalam rentang yang diperbolehkan
        if (inputDateValue < startDateValue || (additionalDateValue ? inputDateValue > additionalDateValue : inputDateValue > endDateValue)) {
            errorElement.style.display = 'block';
            return false;
        }

        return true;
    }

    // Fungsi untuk memvalidasi apakah tanggal sudah ada
    function validateUniqueDate(inputDate, errorElement) {
        var inputDateValue = inputDate.value;

        errorElement.style.display = 'none';

        if (existingDates.includes(inputDateValue)) {
            errorElement.style.display = 'block';
            return false;
        }

        return true;
    }

    document.getElementById('lh_tambah').addEventListener('submit', function(event) {
        var startDate = "<?= $tanggal_mulai ?>";
        var endDate = "<?= $tanggal_selesai ?>";
        var additionalDate = "<?= $tambahan_waktu ?>";
        var inputDate = document.getElementById('tanggal');
        var dateErrorElement = document.getElementById('tanggalError_tambah');
        var uniqueDateErrorElement = document.getElementById('tanggalError2_tambah');
        var checkboxErrorElement = document.getElementById('checkboxError');
        var checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');

        // Validasi checkbox
        let isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        if (!isChecked) {
            event.preventDefault();
            checkboxErrorElement.style.display = 'block';
        } else {
            checkboxErrorElement.style.display = 'none';
        }

        // Validasi tanggal dalam rentang yang diperbolehkan
        if (!validateDateRange(startDate, endDate, additionalDate, inputDate, dateErrorElement)) {
            event.preventDefault();
        }

        // Validasi tanggal tidak duplikat
        if (!validateUniqueDate(inputDate, uniqueDateErrorElement)) {
            event.preventDefault();
        }
    });

    // JS Check Box
    document.getElementById('dropdown').addEventListener('change', function() {
        var selectedOption = this.value;
        var checkboxes = document.getElementById('checkboxes').children;

        Array.from(checkboxes).forEach(checkbox => checkbox.classList.add('hidden'));
        if (selectedOption) {
            document.getElementById(selectedOption).classList.remove('hidden');
        }
    });

    // Saat halaman dimuat, sembunyikan semua opsi checkbox kecuali yang pertama dipilih
    var selectedOption = document.getElementById('dropdown').value;
    var checkboxes = document.getElementById('checkboxes').children;
    Array.from(checkboxes).forEach(checkbox => checkbox.classList.add('hidden'));
    if (selectedOption) {
        document.getElementById(selectedOption).classList.remove('hidden');
    }
});

</script>
