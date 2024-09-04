<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<?php include "../app/views/modals/modal_add/operator/laporan_mingguan_add.php"; ?>

<!-- Menampilkan flash -->
<?php Flasher::flash() ?>

<div class="container mt-5">
    <div class="card mt-100">
        <h5 class="card-header text-white d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <form>
                <label for="row_count">Tampilkan Baris:</label>
                <select id="row_count" name="row_count" onchange="updateTable()">
                    <option value="15" selected>15</option>
                    <option value="30">30</option>
                    <option value="60">60</option>
                    <option value="all">Semua</option>
                </select>
            </form>
            </div>
            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#lm_tambah">
                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>ADD
            </button>
        </h5>

    <div class="table-responsive">
        <table id="myTable" class="table-thick-border" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. <i id="icon0" class="fas fa-sort sort-icon" onclick="sortTable(0)"></i></th>
                    <th>Minggu Ke- <i id="icon1" class="fas fa-sort sort-icon" onclick="sortTable(1)"></i></th>
                    <th>Rencana Progres<i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(2)"></i></th>
                    <th>Rencana Progres Kumulatif<i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(3)"></i></th>
                    <th>Realisasi Progres<i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(4)"></i></th>
                    <th>Realisasi Progress Kumulatif<i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(5)"></i></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $nomor = 1;
                if (!empty($data['all_laporan_mingguan'])):
                    $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);
                    $mingguKeData = [];
                    $rencanaKumulatifData = [];
                    $realisasiKumulatifData = [];
                    foreach ($data['all_laporan_mingguan'] as $laporan) :    
                        $tanggal_laporan = new DateTime($laporan['tanggal_mulai']);

                        // Menghitung selisih hari antara tanggal laporan dan tanggal mulai proyek
                        $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;

                        $minggu_ke = floor($selisih_hari / 7) + 1;

                        // Mengumpulkan data untuk chart
                        $mingguKeData[] = "$minggu_ke";
                        $rencanaKumulatifData[] = $laporan['rencana_progres_kumulatif'];
                        $realisasiKumulatifData[] = $laporan['realisasi_progres_kumulatif'];
                ?>
                <tr>
                    <td class="text-center align-middle nomor"></td>
                    <td class="text-center align-middle" style="color: #464F60;">
                        <a href="">Minggu ke-<?= $minggu_ke ?></a>
                    </td>
                    <td class="text-center align-middle"><?= $laporan['rencana_progres'] ?>%</td>
                    <td class="text-center align-middle"><?= $laporan['rencana_progres_kumulatif'] ?>%</td>
                    <td class="text-center align-middle"><?= $laporan['realisasi_progres'] ?>%</td>
                    <td class="text-center align-middle"><?= $laporan['realisasi_progres_kumulatif'] ?>%</td>
                    <td>
                        <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#lm-hapus-<?=$laporan['id_laporan_mingguan']?>">
                            <i class='bx bx-trash'></i>
                        </a>
                        <a href="#" class="btn btn-aksi mt-1" data-bs-toggle="modal" data-bs-target="#lm-ubah-<?=$laporan['id_laporan_mingguan']?>">
                            <i class='bx bx-edit-alt'></i>
                        </a>
                        <!--<a href=" ?= PUBLICURL ?>/printpdf/mpdf/ ?= $data['projek']['id_projek'] ?>/ ?= $laporan['id_laporan_mingguan'] ?>/ ?= $laporan['tanggal_laporan'] ?>" target="_blank" class="btn btn-aksi mt-1"><i class="bx bx-download"></i></a>-->
                    </td>
                </tr>
                <?php 
                include "../app/views/modals/modal_ud/operator/laporan_mingguan_ud.php";
                $nomor++; 
                endforeach; 
                else:
                ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data Laporan Mingguan!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end mt-3 me-3" id="pagination">
                <!-- Pagination dynamically generated by JavaScript -->
            </ul>
        </nav>
    </div>

    <hr class="container separator">

    <div class="card">
        <h5 class="card-header">
            Grafik Progres Kumulatif
        </h5>

        <canvas id="myChart" width="400" height="200"></canvas>
    </div>

    
</div>

<?php
/*
$mingguKeData = 
$rencanaKumulatifData = $data['all_laporan_mingguan']['rencana_progres_kumulatif'];
$realisasiKumulatifData = $data['all_laporan_mingguan']['realisasi_progres_kumulatif'];
*/
?>

<script>
    // Menggunakan PHP untuk menghasilkan data
    var labels = <?= json_encode($mingguKeData) ?>; // Data label Minggu ke-
    var rencanaKumulatifData = <?= json_encode($rencanaKumulatifData) ?>; // Data rencana kumulatif
    var realisasiKumulatifData = <?= json_encode($realisasiKumulatifData) ?>; // Data realisasi kumulatif
    
    //untuk diubah jadi gambar
    
    //var imgData = canvas.toDataURL('image/png');

    //url untuk js
    const PUBLICURL = '<?= PUBLICURL ?>';
    const ID_PROJEK = '<?= $data['id_projek'] ?>';
</script>

<script src="<?= PUBLICURL ?>/assets/js/laporan_harian_list.js"></script>
<script src="<?= PUBLICURL ?>/assets/js/linechart_laporan_mingguan.js"></script>