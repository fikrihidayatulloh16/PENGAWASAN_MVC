<?php

require_once __DIR__ . '../../../../public/assets/vendor/autoload.php';

use Mpdf\Mpdf;

// Inisialisasi mPDF di awal
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-L', // Tambahkan 'L' setelah A4 untuk mengatur landscape
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_left' => 10,
    'margin_right' => 10,
]);

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

.cuaca-img {
        width: 1000vw; /* Paksa lebar gambar 100% dari container */
        height: auto;
    }

.legend-img {
        width: 271px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 20px;
    }

.image-rekap {
        width: 400px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 200px;
    }

.image-caption {
    font-size: 11px; /* Ukuran teks keterangan */
    margin-top: 5px; /* Jarak antara gambar dan keterangan */
}

.section-title {
    font-size: 12px;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #f4f4f4;
    margin-bottom: 0; /* Remove extra margin */
    border-left: 1px solid #333; /* Uniform border thickness */
    border-right: 1px solid #333;
}

.text-bright-green {
    color: green; /* Hijau cerah */
}

.text-red {
    color: #FF0000; /* Merah */
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
    display: inline-block;
}

.legend-item {
    display: flex; /* Menggunakan flexbox untuk menyelaraskan gambar dan teks secara vertikal */
    vertical-align: middle;
    margin-right: 20px;
}

.legend-label {
    font-size: 11px;
    vertical-align: middle;
    padding-botom: 5px; /* Menambahkan padding atas untuk sedikit menyesuaikan posisi teks jika diperlukan */
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

.progres-title {
    font-size: 12px;
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
            <td class="text-center" style="border-right: 0px;" style="border-right: none;">
                <img src="' . PUBLICURL . '/assets/img/uploads/logo/'.  $data['logo']['logo_pemilik'] . '" alt="logo_pemilik" class="img-fluid custom-img">
            </td>
            <td class="text-center" style="border-left: none;">
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
                ' . $data['projek']['tanggal_mulai'] . ' s/d ' . (!empty($data['projek']['tambahan_waktu']) ? $data['projek']['tambahan_waktu'] : $data['projek']['tanggal_selesai'])    . '
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

    <div class="cuaca-title text-center" style="border-bottom: 1px solid #333; font-weight: bold;">Laporan Progres Mingguan</div>
    
    <div class="section-title">A. Grafik Progres Minguan</div>
    
    <div>
        <table style="width: 100%;">
            <tr>
                <td class="text-center col-6" style="border-right: none; border-bottom: none;">
                    <img src="' . PUBLICURL . '/assets/img/operator/laporan_mingguan/Linechart_LM_'. $data['id_projek'] .'.png" alt="logo_kontrakor" class="cuaca-img">
                </td>
            </tr>
        </table>
    </div>
        
    <div class="section-title">B. Tabel Kontrak</div>
    <div>
        <table class="table-striped" style="width: 100%;">
            <thead class="sticky-header">
                <tr class="text-center">
                    <th class="weather-column align-middle sticky-column" rowspan="2" style="border-left: black solid; border-top: black solid;">Nama</th>
                    <th class="weather-column align-middle sticky-column" rowspan="2" style="border-left: black solid; border-top: black solid; border-right: black solid;">Status</th>
                    <th class="text-center align-middle " colspan="'. count($data['all_minggu_data']).'" style="border-right: black solid; border-top: black solid; border-bottom: black solid;">
                        Minggu Ke-
                    </th>
                </tr>

                <tr class="text-center">';
                    $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);
                    foreach ($data['all_laporan_mingguan'][$data['max_cco']] as $index => $week_data) :
                        $tanggal_laporan = new DateTime($week_data['tanggal_mulai']);
                        $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;
                        $minggu_ke = floor($selisih_hari / 7) + 1;
                        $html .= '<th class="text-center align-middle" style="border-right: black solid;">'
                            .$minggu_ke.
                        '</th>';
                    endforeach;
                $html .= '</tr>
            </thead>

            <tbody class="table-group-divider">';
                foreach ($data['filter_laporan_mingguan'] as $index => $laporan) :
                    $html .= '<!-- Baris Rencana Progres -->
                    <tr class="text-center">
                        <td class="align-middle sticky-column" style="border-left: black solid;">Rencana Progres</td>
                        <td class="align-middle" rowspan="5" style="border-bottom: black solid; border-left: black solid; border-right: black solid;">
                            '. ($index == 0 ? 'Kontrak Awal' : 'CCO' . $index) .
                        '</td>';
                        foreach ($laporan as $week_data) :
                            $html .= '<td class="text-center align-middle" style="border-right: black solid;">
                                '. (isset($week_data['rencana_progres_cco' . $index]) ? $week_data['rencana_progres_cco' . $index] . '%' : '-') .
                            '</td>';
                        endforeach;
                    $html .= '</tr>

                    <!-- Baris Rencana Progres Kumulatif -->
                    <tr class="text-center">
                        <td class="weather-column align-middle sticky-column" style="border-left: black solid;">Rencana Progres Kumulatif</td>';
                        foreach ($laporan as $week_data) :
                            $html .= '<td class="text-center align-middle" style="border-right: black solid;">
                                '. (isset($week_data['rencana_progres_kumulatif_cco' . $index]) ? $week_data['rencana_progres_kumulatif_cco' . $index] . '%' : '-') .
                            '</td>';
                        endforeach;
                    $html .= '</tr>

                    <!-- Baris Realisasi Progres -->
                    <tr class="text-center">
                        <td class="weather-column align-middle sticky-column" style="border-left: black solid;">Realisasi Progres</td>';
                        foreach ($laporan as $week_data) :
                            $html .= '<td class="text-center align-middle" style="border-right: black solid;">'
                                . (isset($week_data['realisasi_progres_cco' . $index]) ? $week_data['realisasi_progres_cco' . $index] . '%' : '-') .
                            '</td>';
                        endforeach;
                    $html .= '</tr>

                    <!-- Baris Realisasi Progres Kumulatif -->
                    <tr class="text-center">
                        <td class="weather-column align-middle sticky-column" style="border-left: black solid;">Realisasi Progres Kumulatif</td>';
                        foreach ($laporan as $week_data) :
                            $html .= '<td class="text-center align-middle" style="border-right: black solid;">'
                                . (isset($week_data['realisasi_progres_kumulatif_cco' . $index]) ? $week_data['realisasi_progres_kumulatif_cco' . $index] . '%' : '-') .
                            '</td>';
                        endforeach;
                    $html .= '</tr>

                    <!-- Baris Deviasi -->
                    <tr class="text-center">
                        <td class="weather-column align-middle sticky-column" style="border-bottom: black solid; border-left: black solid">Deviasi</td>';
                        foreach ($laporan as $week_data) {
                            // Inisialisasi deviasi
                            $deviasi = '-';
                            $warna = '#000000'; // Default warna hitam
                            
                            if (isset($week_data['realisasi_progres_kumulatif_cco' . $index])) {
                                // Hitung deviasi
                                $deviasi = $week_data['realisasi_progres_kumulatif_cco' . $index] - $week_data['rencana_progres_kumulatif_cco' . $index];
                                
                                // Atur warna berdasarkan nilai deviasi
                                $warna = ($deviasi >= 0) ? '#008000' : '#FF0000'; // Hijau untuk positif, merah untuk negatif
                            }
                            
                            // Tambahkan hasil deviasi ke dalam variabel $html
                            $html .= '<td class="text-center align-middle border-deviasi" style="border-right: black solid; border-bottom: black solid; color:' . $warna . ';">'
                                     . (is_numeric($deviasi) && $deviasi >= 0 ? '+' . $deviasi : $deviasi) .
                                 '</td>';
                        }
                        
                        $html .= '</tr>';

                endforeach;
             $html .= '</tbody>
        </table>
    </div>
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
</body>
</html>';

$filename = 'weeklyreport_'. $data['id_projek'] .'.pdf';

$mpdf->WriteHTML($html);
$mpdf->Output($filename, 'I');