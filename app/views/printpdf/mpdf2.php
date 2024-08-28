<?php

require_once __DIR__ . '../../../../public/assets/vendor/autoload.php';

// Di server, setelah mendapatkan gambar dari canvas
$index = 0; // Inisialisasi indeks untuk array timeIntervals

// Bagi data menjadi 6 kelompok, setiap kelompok berisi 4 baris data
$chunks = array_chunk($data['cuaca'], 12);

// Menyimpan setiap chunk dalam array
$chunksArray = [];
foreach ($chunks as $index => $chunk) {
    $chunksArray["chunk_" . ($index + 1)] = $chunk;
}

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0; /* Margin ditangani oleh mPDF atau DomPDF */
    padding-left: 10px;
    padding-right: 10px;
}
.header, .footer {
    border: 1px solid #333; /* Uniform border thickness for all sections */
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    text-align: center;
}

.custom-img {
        width: 50px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 50px;
    }

.image-rekap {
        width: 200px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 100px;
    }

.image-caption {
    font-size: 11px; /* Ukuran teks keterangan */
    margin-top: 5px; /* Jarak antara gambar dan keterangan */
}

.section-title {
    font-size: 12px;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #f4f4f4;
    margin-bottom: 0; /* Remove extra margin */
    border-left: 1px solid #333; /* Uniform border thickness */
    border-right: 1px solid #333;
}

.table-container {
    padding: 0; /* Remove extra padding */
    border: 1px solid #333; /* Uniform border thickness */
}

table {
    width: 100%;
    border-spacing: 0; /* No space between borders */
    border: 1px solid #333; /* Uniform border thickness for the table */
    border-collapse: collapse; /* Collapse borders into one */
    margin-bottom: 0px;
}

th, td {
    padding: 8px;
    text-align: center;
    font-size: 11px;
    border: 1px solid #333; /* Uniform border thickness for table cells */
}

th {
    font-size: 12px;
    font-weight: normal;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #e9ecef;
    margin-bottom: 0; /* Remove extra margin */
}

.image-container {
    border: none; /* Menghilangkan border di sekitar gambar */
    padding: 0; /* Menghilangkan padding */
}

.image-container img {
        width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

.chart-container {
    width: max-content;
    height: 300px;
    margin: 1% auto;
}

.legend-container {
    text-align: center;
    margin-top: 50px;
}
.legend-item {
    display: inline-flex;
    align-items: center;
    margin-right: 20px;
}
.legend-color {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border-radius: 50%;
}
.legend-label {
    font-size: 14px;
}

.card-header{
    display: none;
}

.card, .mt-3 {
    margin-top: 0px;
}

.footer {
    font-size: 16px;
    padding: 20px;
}

h3 {
    font-size: 18px;
}

.rincian-pekerjaan-header {
    border: 1px solid #333;
    background-color: #e9ecef;
    text-align: center;
    padding: 8px;
}

.cuaca-title {
    font-size: 12px;
    text-align: center;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #f4f4f4;
    margin-bottom: 0; /* Remove extra margin */
    border-left: 1px solid #333; /* Uniform border thickness */
    border-right: 1px solid #333;
}

</style>

<body>
    <table>
        <tr>
            <td class="text-center" style="border-right: 0px;">
                <img src="' . PUBLICURL . '/assets/img/uploads/logo/'.  $data['logo']['logo_pemilik'] . '" alt="logo_pemilik" class="img-fluid custom-img">
            </td>
            <td class="text-center">
                ' . $data['logo']['pemilik_pekerjaan'] . '
            </td>
            <td class="text-center">
                Konsultan Pengawas
                <br>
                <img src="' . PUBLICURL . '/assets/img/uploads/logo/' . $data['logo']['logo_pengawas'] . '" alt="logo_pengawas" class="img-fluid custom-img">
                <br>
                ' . $data['logo']['pengawas'] . '
            </td>
            <td class="text-center"> 
                Kontraktor Pelaksana
                <br>
                <img src="' . PUBLICURL . '/assets/img/uploads/logo/' . $data['logo']['logo_kontraktor'] . '" alt="logo_kontrakor" class="img-fluid custom-img">
                <br>
                ' . $data['logo']['kontraktor'] . '
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="2" rowspan="4">
            ' . $data['projek']['nama_projek'] . '
            </td>
            <td class="text-center">
                TANGGAL
            </td>
            <td>
                ' .  $data['tanggal'] . '
            </td>
        </tr>
        <tr>
            <td class="text-center" rowspan="4">LAMPIRAN</td>
            <td>1. Dokumentasi</td>
        </tr>
        <tr>
        <td>2. Site Instruction</td>
        </tr>
        <tr>
        <td>3. Lain-lain</td>
        </tr>
    </table>

    <div class="cuaca-title text-center" style="border-bottom: 1px solid #333;">Laporan Harian PENGAWAS</div>

    <div class="section-title text-center" style="border-bottom: 1px solid #333;">Progres : ' . $data['laporan']['progress_harian'] .'%</div>
    
    <div class="section-title">A. Cuaca</div>
    <div class="table-container">

    <div class="card mt-5">
        <h5 class="card-header">Data Cuaca</h5>
            <div class="cuaca-title" style="text-align: center;">AM (Malam s/d Siang)</div>
                <table class="table table-striped tabel-cuaca">
                    <thead>
                        <tr class="text-center">
                            <th class="weather-column align-middle" >Jam</th>';
                                 foreach ($chunksArray['chunk_1'] as $row) : ;$html .= '
                                    <th class="text-center align-middle" style="border-right: black solid;">' . $row['jam_mulai'] . ' - ' . $row['jam_selesai'] . '</th>';
                                 endforeach; $html .= '
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr class="text-center align-middle">
                            <th class="weather-column">Cuaca</th>';
                            foreach ($chunksArray['chunk_1'] as $row) : ;$html .= '
                                <td class="text-center align-middle' . $row['kondisi'] . '" style="border-right: black solid;">'
                                    . $row['kondisi'] .
                                '</td>';
                            endforeach ;$html .= '
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card mt-5">
            <div class="cuaca-title" style="text-align: center;">PM (Siang s/d Malam)</div>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped tabel-cuaca">
                    <thead>
                        <tr class="text-center">
                            <th class="weather-column" >Jam</th>';
                            foreach ($chunksArray['chunk_1'] as $row) : ;$html .= '
                                <!-- Menampilkan jam_mulai di baris pertama dan jam_selesai di baris kedua dalam kolom yang sama -->
                                <th class="text-center align-middle" style="border-right: black solid;">'
                                    . $row['jam_mulai'] . ' - ' . $row['jam_selesai'] .
                                '</th>';
                            endforeach ;$html .= '
                        </tr>

                    </thead>
                    <tbody class="table-group-divider">
                        <tr class="text-center align-middle">
                            <th class="weather-column">Cuaca</th>';
                            foreach ($chunksArray['chunk_2'] as $row) : ; $html .= '
                                <td class="text-center align-middle' . $row['kondisi'] . '" style="border-right: black solid;">'
                                    . $row['kondisi'] .
                                '</td>';
                            endforeach; 
                        $html .= '</tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section-title">B. Rincian Pekerjaan</div>
    <div>
    <table class="table table-thick-border-pekerjaan table-bordered" style="margin-bottom: 0px;">
            <thead>
                <tr class="text-center">
                    <th class="text-center align-middle rincian-pekerjaan-header" rowspan="2" style="background-color: #e9ecef; border-bottom: 1px solid ; border-top: 1px solid">Sub Pekerjaan</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" colspan="2" style="background-color: #e9ecef; border-bottom: 1px solid; border-top: 1px solid">Pekerja</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" colspan="2" style="background-color: #e9ecef; border-bottom: 1px solid; border-top: 1px solid">Peralatan</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" colspan="2" style="background-color: #e9ecef; border-bottom: 1px solid; border-top: 1px solid">Bahan</th>
                </tr>
                <tr class="text-center">
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Jenis Pekerja</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Jumlah Pekerja</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Nama Alat</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Jumlah Peralatan</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Nama Bahan</th>
                    <th class="text-center align-middle rincian-pekerjaan-header" style="background-color: #e9ecef; border-bottom: 1px solid">Jumlah Bahan</th>
                </tr>
            </thead>
            <tbody>';
        
        // Mulai kode PHP
        if (!empty($data['sub_pekerjaan'])) {
            $id_laporan_harian = $data['id_laporan_harian'];
            foreach ($data['sub_pekerjaan'] as $sub_pekerjaan) {
                $id_m_sub_pekerjaan = $sub_pekerjaan['id_m_sub_pekerjaan'];
                // Filter data berdasarkan ID sub_pekerjaan
                $pekerja_rekap = $this->model('Rekap_db_model')->getPekerjaByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);
                $peralatan_rekap = $this->model('Rekap_db_model')->getPeralatanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);
                $bahan_rekap = $this->model('Rekap_db_model')->getBahanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan);

                // Cari jumlah baris maksimum di antara ketiga data
                $max_rows = max(count($pekerja_rekap), count($peralatan_rekap), count($bahan_rekap));

                for ($i = 0; $i < $max_rows; $i++) {
                    $bottom_border = ($i == $max_rows - 1) ? '1px solid black' : '0px solid black';

                    // Cek apakah baris saat ini kosong
                    $isEmptyRow = empty($pekerja_rekap[$i]) && empty($peralatan_rekap[$i]) && empty($bahan_rekap[$i]);
                    
                    $html .= '<tr class="text-center align-middle">';
                    
                    if ($i == 0) {
                        $html .= '<td rowspan="' . $max_rows . '" class="text-center kolom-sub" style="border-bottom: 1px solid black;">' . htmlspecialchars($sub_pekerjaan['nama_sub_pekerjaan']) . '</td>';
                    }
                    
                    if ($isEmptyRow) {
                        $html .= '<td colspan="6" class="text-center" style="border-bottom: ' . $bottom_border . ';">Tidak ada data</td>';
                    } else {
                        // Pekerja
                        $html .= '<td class="text-center kolom-pekerja" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($pekerja_rekap[$i]['jenis_pekerja']) ? htmlspecialchars($pekerja_rekap[$i]['jenis_pekerja']) : '-') . 
                                 '</td>';
                        $html .= '<td class="text-center kolom-pekerja" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($pekerja_rekap[$i]['jumlah_pekerja']) ? htmlspecialchars($pekerja_rekap[$i]['jumlah_pekerja']) : '-') . 
                                 '</td>';

                        // Peralatan
                        $html .= '<td class="text-center kolom-alat" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($peralatan_rekap[$i]['nama_alat']) ? htmlspecialchars($peralatan_rekap[$i]['nama_alat']) : '-') . 
                                 '</td>';
                        $html .= '<td class="text-center kolom-alat" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($peralatan_rekap[$i]['jumlah_peralatan']) ? htmlspecialchars($peralatan_rekap[$i]['jumlah_peralatan']) : '-') . 
                                 (isset($peralatan_rekap[$i]['satuan']) ? ' ' . htmlspecialchars($peralatan_rekap[$i]['satuan']) : '') . 
                                 '</td>';

                        // Bahan
                        $html .= '<td class="text-center kolom-bahan" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($bahan_rekap[$i]['nama_bahan']) ? htmlspecialchars($bahan_rekap[$i]['nama_bahan']) : '-') . 
                                 '</td>';
                        $html .= '<td class="text-center kolom-bahan" style="border-bottom: ' . $bottom_border . ';">' . 
                                 (isset($bahan_rekap[$i]['jumlah_bahan']) ? htmlspecialchars($bahan_rekap[$i]['jumlah_bahan']) : '-') . 
                                 (isset($bahan_rekap[$i]['satuan']) ? ' ' . htmlspecialchars($bahan_rekap[$i]['satuan']) : '') . 
                                 '</td>';
                    }
                    
                    $html .= '</tr>';
                }
            }
        }

$html .= '
        </tbody>
    </table>
    </div>

    <div class="section-title">C. Permasalahan dan Tindak Lanjut</div>
    <div>
    <table>
            <tr>
                <th class="col-1 text-center" style="width: 8%;">No.</th>
                <th class="col-5 text-center" style="width: 50%;">Permasalahan</th>
                <th class="col-5 text-center" style="width: 45%;">Saran</th>
            </tr>';
            
                $nomor_masalah = 1;
                if (count($data['permasalahan']) > 0) {
                    foreach ($data['permasalahan'] as $permasalahan) : 
            ; $html .= '
            <tr>
                <td class="text-center">' . $nomor_masalah . '</td>
                <td style="text-align: justify;">' . (!empty($permasalahan['permasalahan']) ? $permasalahan['permasalahan'] : '-') . '</td>
                <td style="text-align: justify;">' . (!empty($permasalahan['saran']) ? $permasalahan['saran'] : '-')  . '</td>
            </tr>';
            
                $nomor_masalah++; 
                endforeach;
                } else { 
            $html .= '
            <tr>
                <td colspan="4" class="text-center">Tidak ada data permasalahan.</td>
            </tr>';
                } $html .= '
        </table>
    </div>

    <div>
        <table>';
                $nomor_masalah = 1;
                if (count( $data['tim_pengawas']) > 0) {
                    foreach ($data['tim_pengawas'] as $tim_pengawas) : 
            $html .= '
            <tr>
                <td class="text-center col-6" style="border-right: none;">
                    Disusun/ Dibuat Oleh
                    <br>
                    ' . $data['logo']['pengawas'] . '
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    ' . $tim_pengawas['tim_pengawas'] . '
                    <br>
                    Tim Pengawas
                </td>
                <td class="text-center col-6" style="border-left: none;">
                    Diperiksa
                    <br>
                    ' . $data['logo']['pengawas'] . '
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    ' . $tim_pengawas['tim_leader'] . '
                    <br>
                    Tim Leader
                </td>
            </tr>';
                endforeach;
                } else { 
            $html .= '
            <tr>
                <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
            </tr>';
             } $html .= '
        </table>
        </div>

    <div class="section-title text-center">Dokumentasi Harian</div>
    <div >
        <div class="container">';
            if (count($data['foto_kegiatan']) > 0) {
                $html .= '<table style="width: 100%; border-collapse: collapse;">';
                $html .= '<tbody>';
                $num_row = 0;
                foreach ($data['foto_kegiatan'] as $foto) {
                    if ($num_row % 2 == 0) {
                        // Mulai baris baru setiap dua gambar
                        $html .= '<tr>';
                    }

                    // Tambahkan gambar dalam kolom
                    $html .= '
                    <td style="width: 50%; text-align: center; vertical-align: top; padding: 10px;">
                        <img src="' . PUBLICURL . '/assets/img/uploads/foto_kegiatan/' . $foto['foto'] . '" alt="Foto Kegiatan" class="image-rekap">
                        <br>
                        <div class="image-caption" style="font: size 11px;">' . $foto['keterangan'] . '</div>
                    </td>';
                    
                    $num_row++;
                    if ($num_row % 2 == 0) {
                        // Tutup baris setelah dua gambar
                        $html .= '</tr>';
                    }
                }
                if ($num_row % 2 != 0) {
                    // Jika jumlah gambar ganjil, tambahkan satu kolom kosong
                    $html .= '<td style="width: 50%;"></td></tr>';
                }
                $html .= '</tbody>';
                $html .= '</table>';
            } else {
                $html .= '
                <div class="row">
                    <div class="col-12 text-center">Tidak ada data Foto Kegiatan.</div>
                </div>';
            }
            $html .= '
        </div>
    </div>

    <div class="section-title text-center">Lampiran Foto Permasalahan</div>
    <div >
        <div class="container">';
            if (count($data['foto_masalah']) > 0) {
                $html .= '<table style="width: 100%; border-collapse: collapse;">';
                $html .= '<tbody>';
                $num_row = 0;
                foreach ($data['foto_masalah'] as $foto_masalah) {
                    if ($num_row % 2 == 0) {
                        // Mulai baris baru setiap dua gambar
                        $html .= '<tr>';
                    }

                    // Tambahkan gambar dalam kolom
                    $html .= '
                    <td style="width: 50%; text-align: center; vertical-align: top; padding: 10px;">
                        <img src="' . PUBLICURL . '/assets/img/uploads/foto_masalah/' . $foto_masalah['foto_masalah'] . '" alt="Foto Masalah" class="image-rekap">
                        <br>
                        <div class="image-caption" style="font: size 11px;">' . $foto_masalah['permasalahan'] . '</div>
                    </td>';
                    
                    $num_row++;
                    if ($num_row % 2 == 0) {
                        // Tutup baris setelah dua gambar
                        $html .= '</tr>';
                    }
                }
                if ($num_row % 2 != 0) {
                    // Jika jumlah gambar ganjil, tambahkan satu kolom kosong
                    $html .= '<td style="width: 50%;"></td></tr>';
                }
                $html .= '</tbody>';
                $html .= '</table>';
            } else {
                $html .= '
                <div class="row">
                    <div class="col-12 text-center">Tidak ada data Foto Kegiatan.</div>
                </div>';
            }
            $html .= '
        </div>
    </div>
</body>
</html>';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_left' => 10,
    'margin_right' => 10,
]);

$mpdf->WriteHTML($html);
$mpdf->Output('output.pdf', 'I');