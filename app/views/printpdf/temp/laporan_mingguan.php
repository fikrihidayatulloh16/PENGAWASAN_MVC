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
        width: 200px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 200px;
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
                Waktu Pelaksanaan
            </td>
            <td>
                ' .  $data['projek']['tanggal_mulai'] . '-'. !empty($data['projek']['tambahan_waktu']) ? $data['projek']['tambahan_waktu'] : $data['projek']['tanggal_selesai'] .
            '</td>
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

    <div class="cuaca-title text-center" style="border-bottom: 1px solid #333; font-weight: bold;">Laporan Mingguan</div>
    
    <div class="section-title">A. Grafik Progres Mingguan</div>
    
    <div>
        <table style="width: 100%;">
            <tr>
                <td class="text-center col-6" style="border-right: none; border-bottom: none;">
                    AM (Malam s/d Siang)
                    <br>
                    <img src="' . PUBLICURL . '/assets/img/operator/laporan_mingguan/Linechart_LM_'. $data['id_projek'] .'.png" alt="logo_kontrakor" class="img-fluid cuaca-img">
                </td>
            </tr>
        </table>
    </div>
</body>