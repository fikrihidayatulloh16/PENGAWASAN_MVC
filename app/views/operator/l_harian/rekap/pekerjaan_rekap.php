<?php
    if (empty($_SESSION['id_laporan_harian'])) {
        // Ambil parameter id_laporan_harian dari URL
        if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
            $id_laporan_harian = $_GET['id_laporan_harian'];
            $tanggal_laporan = $_GET['tanggal_laporan'];
            $nomor = $_GET['nomor'];
    
            // Menyimpan ke dalam session
            $_SESSION['id_laporan_harian'] = $id_laporan_harian;
            $_SESSION['tanggal_laporan'] = $tanggal_laporan;
            $_SESSION['nomor'] = $nomor;
        }
    }

    $id_laporan_harian = $_SESSION['id_laporan_harian'];
?>
<link href="<?= PUBLICURL ?>/assets/css/pekerjaan_rekap.css" rel="stylesheet">

<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        Data Pekerjaan Harian
        <a href="<?= PUBLICURL ?>/operator/pekerjaan_l_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" class="btn btn-edit text-white ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
    <div class="table-responsive">
        <table class="table table-thick-border-pekerjaan table-bordered">
            <thead>
                <tr class="text-center">
                    <th class="text-center align-middle" rowspan="2">Sub Pekerjaan</th>
                    <th class="text-center align-middle" colspan="2">Pekerja</th>
                    <th class="text-center align-middle" colspan="2">Peralatan</th>
                    <th class="text-center align-middle" colspan="2">Bahan</th>
                </tr>
                <tr class="text-center">
                    <th class="text-center align-middle">Jenis Pekerja</th>
                    <th class="text-center align-middle">Jumlah Pekerja</th>
                    <th class="text-center align-middle">Nama Alat</th>
                    <th class="text-center align-middle">Jumlah Peralatan</th>
                    <th class="text-center align-middle">Nama Bahan</th>
                    <th class="text-center align-middle">Jumlah Bahan</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php if (!empty($data['sub_pekerjaan'])): 
                    $id_laporan_harian = $data['id_laporan_harian'];
                    foreach ($data['sub_pekerjaan'] as $sub_pekerjaan): 
                        $id_m_sub_pekerjaan = $sub_pekerjaan['id_m_sub_pekerjaan'];
                        // Filter data berdasarkan ID sub_pekerjaan
                        $pekerja_rekap = $this->model('Rekap_db_model')->getPekerjaByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);
                        $peralatan_rekap = $this->model('Rekap_db_model')->getPeralatanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);
                        $bahan_rekap = $this->model('Rekap_db_model')->getBahanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);

                        // Cari jumlah baris maksimum di antara ketiga data
                        $max_rows = max(count($pekerja_rekap), count($peralatan_rekap), count($bahan_rekap));

                        for ($i = 0; $i < $max_rows; $i++): 
                            $bottom_border = ($i == $max_rows - 1) ? '1px solid black' : '0px solid black';

                            // Cek apakah baris saat ini kosong
                            $isEmptyRow = empty($pekerja_rekap[$i]) && empty($peralatan_rekap[$i]) && empty($bahan_rekap[$i]);
                            ?>
                            <tr class="text-center align-middle">
                                <?php if ($i == 0): ?>
                                    <td rowspan="<?= $max_rows ?>" class="text-center kolom-sub" style="border-bottom: 1px solid black;"><?= htmlspecialchars($sub_pekerjaan['nama_sub_pekerjaan']) ?></td>
                                <?php endif; ?>
                                
                                <?php if ($isEmptyRow): ?>
                                    <td colspan="6" class="text-center" style="border-bottom: <?= $bottom_border ?>;">Tidak ada data</td>
                                <?php else: ?>
                                    <!-- Pekerja -->
                                    <td class="text-center kolom-pekerja" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($pekerja_rekap[$i]['jenis_pekerja']) ? htmlspecialchars($pekerja_rekap[$i]['jenis_pekerja']) : '-' ?>
                                    </td>
                                    <td class="text-center kolom-pekerja" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($pekerja_rekap[$i]['jumlah_pekerja']) ? htmlspecialchars($pekerja_rekap[$i]['jumlah_pekerja']) : '-' ?>
                                    </td>

                                    <!-- Peralatan -->
                                    <td class="text-center kolom-alat" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($peralatan_rekap[$i]['nama_alat']) ? htmlspecialchars($peralatan_rekap[$i]['nama_alat']) : '-' ?>
                                    </td>
                                    <td class="text-center kolom-alat" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($peralatan_rekap[$i]['jumlah_peralatan']) ? htmlspecialchars($peralatan_rekap[$i]['jumlah_peralatan']) : '-' ?> <?= isset($peralatan_rekap[$i]['satuan']) ? htmlspecialchars($peralatan_rekap[$i]['satuan']) : '' ?>
                                    </td>

                                    <!-- Bahan -->
                                    <td class="text-center kolom-bahan" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($bahan_rekap[$i]['nama_bahan']) ? htmlspecialchars($bahan_rekap[$i]['nama_bahan']) : '-' ?>
                                    </td>
                                    <td class="text-center kolom-bahan" style="border-bottom: <?= $bottom_border ?>;">
                                        <?= isset($bahan_rekap[$i]['jumlah_bahan']) ? htmlspecialchars($bahan_rekap[$i]['jumlah_bahan']) : '-' ?> <?= isset($bahan_rekap[$i]['satuan']) ? htmlspecialchars($bahan_rekap[$i]['satuan']) : '' ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>


</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/laporan_harian_list/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>