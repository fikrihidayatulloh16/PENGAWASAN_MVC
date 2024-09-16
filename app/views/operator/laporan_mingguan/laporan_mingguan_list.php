    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <?php

    $next_cco = $data['max_cco'] + 1; 

    include "../app/views/modals/modal_add/operator/cco_lm_add.php"; ?>

    <!-- Menampilkan flash -->
    <?php Flasher::flash() ?>



    <div class="container mt-5">
        <!-- Tab -->
        <nav>
            <div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
                <?php foreach ($data['all_laporan_mingguan'] as $index => $laporan): ?>
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                        id="nav-cco<?= $index ?>-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#nav-cco<?= $index ?>" 
                        type="button" 
                        role="tab" 
                        aria-controls="nav-cco<?= $index ?>" 
                        aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                        <?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </nav>

        <div class="tab-content background-color-dark" id="nav-tabContent">
            <?php 
            $ccoData = [];
            
            $rencanaKumulatifData = [];
            $realisasiKumulatifData = [];
            
            foreach ($data['all_laporan_mingguan'] as $index => $laporan): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="nav-cco<?= $index ?>" role="tabpanel" aria-labelledby="nav-cco<?= $index ?>-tab">
                    <h4 class="ms-5 mt-5"><?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?></h4>
                    <?php include '../app/views/modals/modal_add/operator/pekerjaan_harian_lh_add.php' ?>

                    <!--
                    <hr class="separator mt-5">

                    <div class="container">
                        <div class="card mt-3">
                            <h5 class="card-header">
                                <div>
                                    Keterangan : ?= !empty($sub['keterangan']) ? $sub['keterangan'] : 'Tidak ada Keterangan!' ?>
                                </div>

                                <a class="btn btn-edit ms-2 mt-0" data-bs-toggle="modal" data-bs-target="#ph-keterangan-tambah- ?= $index ?>"><i class='bx bxs-edit-alt'></i>EDIT</a>
                            </h5>
                        </div>
                    </div>
                    -->
                    <hr class="separator mt-3">

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
                            
                            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ccolm-tambah">
                                
                                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>CREATE CCO-<?= $next_cco ?>
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
                                        <th>Deviasi<i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(6)"></i></th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <?php
                                    $nomor = 1;
                                    if (!empty($data['all_laporan_mingguan'])):
                                        $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);
                                        foreach ($laporan as $laporan) :    
                                            $tanggal_laporan = new DateTime($laporan['tanggal_mulai']);

                                            // Menghitung selisih hari antara tanggal laporan dan tanggal mulai proyek
                                            $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;

                                            $minggu_ke = floor($selisih_hari / 7) + 1;

                                            // Mengumpulkan data untuk setiap CCO
                                            // Simpan data dalam array
                                            $ccoKey = 'cco' . $index;
                                            
                                            
                                            $rencanaKumulatifData[$ccoKey][] = $laporan['rencana_progres_kumulatif_cco' . $index];
                                            $realisasiKumulatifData[$ccoKey][] = $laporan['realisasi_progres_kumulatif_cco' . $index];
                                            
                                    ?>
                                    <tr>
                                        <td class="text-center align-middle nomor"></td>
                                        <td class="text-center align-middle" style="color: #464F60;">
                                            <a href="<?= PUBLICURL ?>/laporanmingguan/weekly_laporan_harian/<?= $data['projek']['id_projek']?>/<?= $laporan['tanggal_mulai'] ?>/<?= $laporan['tanggal_selesai'] ?>/<?= $minggu_ke?>">Minggu ke-<?= $minggu_ke ?></a>
                                        </td>
                                        <td class="text-center align-middle"><?= $laporan['rencana_progres_cco'. $index] ?>%</td>
                                        <td class="text-center align-middle"><?= $laporan['rencana_progres_kumulatif_cco'. $index] ?>%</td>
                                        <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres_cco'. $index]) ? $laporan['realisasi_progres_cco'. $index] . '%' : '-' ?></td>
                                        <td class="text-center align-middle"><?= !empty($laporan['realisasi_progres_kumulatif_cco'. $index]) ? $laporan['realisasi_progres_kumulatif_cco'. $index] . '%' : '-' ?></td>
                                        <td class="text-center align-middle border-deviasi 
                                            <?php 
                                            $deviasi = $laporan['realisasi_progres_kumulatif_cco'. $index] - $laporan['rencana_progres_kumulatif_cco'. $index]; 
                                            echo ($deviasi >= 0) ? 'text-bright-green' : 'text-red'; 
                                            ?>">
                                            <?php if (empty($laporan['realisasi_progres_kumulatif_cco'. $index])) {
                                                $deviasi = '-';
                                            } 
                                            ?>
                                            <?= $deviasi >= 0 ? '+'. $deviasi : $deviasi ?>
                                        </td>
                                        <td>
                                            <!--
                                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#lm-hapus-<?=$laporan['id_laporan_mingguan']?>">
                                                <i class='bx bx-trash'></i>
                                            </a>
                                            -->
                                            <a href="#" class="btn btn-aksi mt-1" data-bs-toggle="modal" data-bs-target="#lm-ubah-<?=$index?>-<?= $laporan['id_laporan_mingguan']?>">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <!--<a href=" ?= PUBLICURL ?>/printpdf/mpdf/ ?= $data['projek']['id_projek'] ?>/ ?= $laporan['id_laporan_mingguan'] ?>/ ?= $laporan['tanggal_laporan'] ?>" target="_blank" class="btn btn-aksi mt-1"><i class="bx bx-download"></i></a>-->
                                        </td>
                                    </tr>
                                    <?php 
                                    include "../app/views/modals/modal_ud/operator/laporan_mingguan_ud.php";
                                    $nomor++; 
                                    endforeach; 
                                    $ccoData[] = $ccoKey;
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

                </div>
            <?php endforeach; 
            ?>
        </div>

        <hr class="container separator">

        <div class="card">
            <h5 class="card-header">
                Grafik Progres Kumulatif
            </h5>

            <canvas id="myChart" width="400" height="200"></canvas>

            <div class="tabel-responsive">
                <table class="table table-striped tabel-cuaca">
                    <thead>
                        <!-- Baris Judul Minggu -->
                        <tr class="text-center">
                            <th class="weather-column align-middle" rowspan="2">Nama</th>
                            <th class="weather-column align-middle" rowspan="2">CCO-</th>
                            <th class="text-center align-middle" colspan="<?= count($data['all_minggu_data']) ?>" style="border-right: black solid;">
                                Minggu Ke-
                            </th>
                        </tr>

                        <tr class="text-center">
                            <?php foreach ($data['all_laporan_mingguan'][$data['max_cco']] as $index => $week_data) :
                                $tanggal_laporan = new DateTime($week_data['tanggal_mulai']);
                                $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;
                                $minggu_ke = floor($selisih_hari / 7) + 1;
                            ?>
                                <th class="text-center align-middle" style="border-right: black solid;">
                                    <?= $minggu_ke ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider">
                        <?php foreach ($data['all_laporan_mingguan'] as $index => $laporan) : ?>

                            <!-- Baris Rencana Progres -->
                            <tr class="text-center">
                                <th class="weather-column align-middle">Rencana Progres</th>
                                <th class="weather-column align-middle" rowspan="5">
                                    <?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?>
                                </th>
                                <?php foreach ($laporan as $week_data) : ?>
                                    <th class="text-center align-middle" style="border-right: black solid;">
                                        <?= isset($week_data['rencana_progres_cco' . $index]) ? $week_data['rencana_progres_cco' . $index] . '%' : '-' ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                            <!-- Baris Rencana Progres Kumulatif -->
                            <tr class="text-center">
                                <th class="weather-column align-middle">Rencana Progres Kumulatif</th>
                                <?php foreach ($laporan as $week_data) : ?>
                                    <th class="text-center align-middle" style="border-right: black solid;">
                                        <?= isset($week_data['rencana_progres_kumulatif_cco' . $index]) ? $week_data['rencana_progres_kumulatif_cco' . $index] . '%' : '-' ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                            <!-- Baris Realisasi Progres -->
                            <tr class="text-center">
                                <th class="weather-column align-middle">Realisasi Progres</th>
                                <?php foreach ($laporan as $week_data) : ?>
                                    <th class="text-center align-middle" style="border-right: black solid;">
                                        <?= isset($week_data['realisasi_progres_cco' . $index]) ? $week_data['realisasi_progres_cco' . $index] . '%' : '-' ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                            <!-- Baris Realisasi Progres Kumulatif -->
                            <tr class="text-center">
                                <th class="weather-column align-middle">Realisasi Progres Kumulatif</th>
                                <?php foreach ($laporan as $week_data) : ?>
                                    <th class="text-center align-middle" style="border-right: black solid;">
                                        <?= isset($week_data['realisasi_progres_kumulatif_cco' . $index]) ? $week_data['realisasi_progres_kumulatif_cco' . $index] . '%' : '-' ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                            <!-- Baris Deviasi -->
                            <tr class="text-center">
                                <th class="weather-column align-middle">Deviasi</th>
                                <?php foreach ($laporan as $week_data) : ?>
                                    <th style="border-right: black solid;" class="text-center align-middle border-deviasi 
                                        <?php 
                                        if (isset($week_data['realisasi_progres_kumulatif_cco'. $index])) {
                                            $deviasi = $week_data['realisasi_progres_kumulatif_cco' . $index] - $week_data['rencana_progres_kumulatif_cco' . $index];
                                            echo ($deviasi >= 0) ? 'text-bright-green' : 'text-red';
                                        } else {
                                            $deviasi = '-';
                                        }
                                        ?>">
                                        <?= is_numeric($deviasi) && $deviasi >= 0 ? '+' . $deviasi : $deviasi ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <?php
    // Konversi array PHP menjadi JSON
    $jsonlabels = json_encode($data['all_minggu_data']); // Data label Minggu ke-
    $jsonrencanaKumulatif = json_encode($rencanaKumulatifData); // Data rencana kumulatif
    $jsonrealisasiKumulatif = json_encode($realisasiKumulatifData); // Data realisasi kumulatif
    ?>



    <script>
        // Menggunakan PHP untuk menghasilkan data

        const labels = <?php echo $jsonlabels ?>; // Data label Minggu ke-
        const rencanaKumulatifData = <?php echo $jsonrencanaKumulatif ?>; // Data rencana kumulatif
        const realisasiKumulatifData = <?php echo $jsonrealisasiKumulatif ?>; // Data realisasi kumulatif

        //url untuk js
        const PUBLICURL = '<?= PUBLICURL ?>';
        const ID_PROJEK = '<?= $data['id_projek'] ?>';
    </script>

    <script src="<?= PUBLICURL ?>/assets/js/laporan_harian_list.js"></script>
    <script src="<?= PUBLICURL ?>/assets/js/linechart_laporan_mingguan.js"></script>