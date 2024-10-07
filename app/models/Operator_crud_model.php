<?php

class Operator_crud_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    private function newIdGenerator($id, $table, $format, $digit)
    {
        // Generate ID baru
        $sql_get_last_id = "SELECT MAX($id) AS last_id FROM $table";
        $this->db->query($sql_get_last_id);
        $row = $this->db->single(); // Memanggil metode single() langsung pada objek db
        $last_id = $row['last_id'];

        // Menghasilkan ID baru dengan format yang diinginkan
        if ($last_id) {
            $num = intval(substr($last_id, strlen($format))) + 1; // Mengambil bagian numerik dari ID
        } else {
            $num = 1;
        }
        $new_id = $format . str_pad($num, $digit, '0', STR_PAD_LEFT); // Menggabungkan format dengan nomor yang dihasilkan

        return $new_id;
    }

    public function dateConverter($data_tanggal)
    {
    $nama_hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    
    $nama_bulan = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    

    // Cek apakah $data_tanggal valid
    $timestamp = strtotime($data_tanggal);
    if (!$timestamp) {
        return 'Tanggal tidak valid';
    }

    $hari = $nama_hari[date('l', $timestamp)];
    $tanggal = date('d', $timestamp);
    $bulan = $nama_bulan[date('F', $timestamp)];
    $tahun = date('Y', $timestamp);
    
    $tanggal_new = "$hari, $tanggal $bulan $tahun";
    return $tanggal_new;
    }

    // Function to convert images to WebP format
    private function convertToWebP($filePath, $originalExt, $quality = 75)
    {
        switch ($originalExt) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $image = imagecreatefrompng($filePath);
                break;
            case 'gif':
                $image = imagecreatefromgif($filePath);
                break;
            default:
                echo "Error: Format file tidak didukung untuk konversi ke WebP.";
                return false;
        }

        // Save the image as WebP
        imagewebp($image, $filePath, $quality);
        imagedestroy($image);

        return true;
    }


    public function tambahLaporanHarian($data)
    {
        // Ambil data dari form
        $id_projek = $data['id_projek'];
        $tanggal = $data['tanggal'];

        // Cek apakah sudah ada laporan harian dengan tanggal yang sama untuk proyek yang sama
        $cek_tanggal_query = "SELECT COUNT(*) as count FROM laporan_harian WHERE id_projek = :id_projek AND tanggal = :tanggal";
        $this->db->query($cek_tanggal_query);
        $this->db->bind(':id_projek', $id_projek);
        $this->db->bind(':tanggal', $tanggal);
        $this->db->execute();
        $result = $this->db->single();
        
        if ($result['count'] > 0) {
            // Jika sudah ada tanggal yang sama, kembalikan nilai atau pesan error
            return FALSE;
        }

        // Generate ID baru
        $new_id = $this->newIdGenerator('id_laporan_harian', 'laporan_harian', 'L', 6);

        // Insert ke tabel laporan_harian
        $laporan_harian_query = "INSERT INTO laporan_harian (id_laporan_harian, id_projek, tanggal, progress_harian) 
                        VALUES (:new_id, :id_projek, :tanggal, 0)";

        $this->db->query($laporan_harian_query);
        $this->db->bind(':new_id', $new_id);
        $this->db->bind(':id_projek', $id_projek);
        $this->db->bind(':tanggal', $tanggal);
        $this->db->execute();

        // Proses checkbox yang dipilih
        $checkbox_values = $data['box_sp'];
        foreach ($checkbox_values as $id_m_sub_pekerjaan) {
            $pekerjaan_harian_query = "INSERT INTO pekerjaan_harian (id_laporan_harian, id_m_sub_pekerjaan)
                                VALUES (:new_id, :id_m_sub_pekerjaan)";
            $this->db->query($pekerjaan_harian_query);
            $this->db->bind(':new_id', $new_id);
            $this->db->bind(':id_m_sub_pekerjaan', $id_m_sub_pekerjaan);
            $this->db->execute();
        }

        // Insert data cuaca
        $cuaca_data = [
            ['00:00', '01:00', 'cerah'],
            ['01:00', '02:00', 'cerah'],
            ['02:00', '03:00', 'cerah'],
            ['03:00', '04:00', 'cerah'],
            ['04:00', '05:00', 'cerah'],
            ['05:00', '06:00', 'cerah'],
            ['06:00', '07:00', 'cerah'],
            ['07:00', '08:00', 'cerah'],
            ['08:00', '09:00', 'cerah'],
            ['09:00', '10:00', 'cerah'],
            ['10:00', '11:00', 'cerah'],
            ['11:00', '12:00', 'cerah'],
            ['12:00', '13:00', 'cerah'],
            ['13:00', '14:00', 'cerah'],
            ['14:00', '15:00', 'cerah'],
            ['15:00', '16:00', 'cerah'],
            ['16:00', '17:00', 'cerah'],
            ['17:00', '18:00', 'cerah'],
            ['18:00', '19:00', 'cerah'],
            ['19:00', '20:00', 'cerah'],
            ['20:00', '21:00', 'cerah'],
            ['21:00', '22:00', 'cerah'],
            ['22:00', '23:00', 'cerah'],
            ['23:00', '00:00', 'cerah']
        ];

        $sql_cuaca = "INSERT INTO cuaca (id_laporan_harian, jam_mulai, jam_selesai, kondisi) 
                    VALUES (:id_laporan_harian, :jam_mulai, :jam_selesai, :kondisi)";

        foreach ($cuaca_data as $cuaca) {
            $this->db->query($sql_cuaca);
            $this->db->bind(':id_laporan_harian', $new_id);
            $this->db->bind(':jam_mulai', $cuaca[0]);
            $this->db->bind(':jam_selesai', $cuaca[1]);
            $this->db->bind(':kondisi', $cuaca[2]);
            $this->db->execute();
        }

        return $new_id;
    }


    public function hapusLaporanHarian()
    {
        $id_laporan_harian = $_POST['id_laporan_harian'];

        $hapus = ("DELETE FROM laporan_harian WHERE id_laporan_harian = :id_laporan_harian" );

        $this->db->query($hapus);

        $this->db->bind('id_laporan_harian', $id_laporan_harian);

        $this->db->execute();

        return TRUE;
    }

    public function ubahProgresLH($postData, $laporanData)
    {
        $id_projek = $postData['id_projek'];
        $id_laporan_harian = $postData['id_laporan_harian'];
        $progress_harian = $postData['progress_harian'];
        $tanggal = $postData['tanggal'];

        // Update the report with new progress values
        $updateQuery = "UPDATE laporan_harian 
                        SET progress_harian = :progress_harian
                        WHERE id_laporan_harian = :id_laporan_harian
                        AND tanggal = :tanggal";

        // Prepare, bind, and execute the update query
        $this->db->query($updateQuery);
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);
        $this->db->bind(':progress_harian', $progress_harian);
        $this->db->bind(':tanggal', $tanggal);

        $this->db->execute();


        // Update semua total progress
        foreach ($laporanData as $laporan) {
            // Query to get the total progress up to the specified date
            $sumQuery = "SELECT SUM(progress_harian) as total_progress 
                        FROM laporan_harian 
                        WHERE id_projek = :id_projek 
                        AND tanggal <= :tanggal";

            // Prepare and execute the sum query
            $this->db->query($sumQuery);
            $this->db->bind(':id_projek', $id_projek);
            $this->db->bind(':tanggal', $laporan['tanggal_laporan']);
            $result = $this->db->single();

            // Use null coalescing operator to handle cases where the result might be null
            $total_progress_before_today = $result['total_progress'] ?? 0;

            // Calculate new total progress and update it
            $updateTotalProgressQuery = "UPDATE laporan_harian
                                        SET total_progres = :total_progress_before_today
                                        WHERE id_laporan_harian = :id_laporan_harian";

            $this->db->query($updateTotalProgressQuery);
            $this->db->bind(':total_progress_before_today', $total_progress_before_today);
            $this->db->bind(':id_laporan_harian', $laporan['id_laporan_harian']);

            $this->db->execute();

        }

        return TRUE; // Indicate success
    }



    public function ubahCuaca()
    {
        // Handle form submission untuk perubahan data cuaca
            $id_cuaca_value = $_POST['id_cuaca'];
            $kondisi_value = $_POST['kondisi'];
        
            // Loop through each pair of id_cuaca and kondisi
            for ($i = 0; $i < count($id_cuaca_value); $i++) {
                $id_cuaca = $id_cuaca_value[$i];
                $kondisi = $kondisi_value[$i];
        
                // Update data cuaca in the database
                $this->db->query("UPDATE cuaca SET kondisi = :kondisi WHERE id_cuaca = :id_cuaca"); ;

                $this->db->bind('kondisi', $kondisi);
                $this->db->bind('id_cuaca', $id_cuaca);

                $this->db->execute();
            }

        return TRUE;
    }

    public function savePieChart()
    {
        if (isset($_POST['image1']) && isset($_POST['image2'])) {
            // Mendapatkan data gambar dari POST request
            $id_laporan_harian = $_POST['id_laporan_harian'];
            $id_projek = $_POST['id_projek'];
            $data1 = $_POST['image1'];
            $data2 = $_POST['image2'];
        
            // Menghapus header data URL
            $data1 = str_replace('data:image/png;base64,', '', $data1);
            $data1 = str_replace(' ', '+', $data1);
        
            $data2 = str_replace('data:image/png;base64,', '', $data2);
            $data2 = str_replace(' ', '+', $data2);
        
            // Decode base64 data
            $data1 = base64_decode($data1);
            $data2 = base64_decode($data2);
        
            // Tentukan path folder penyimpanan
            $folderPath = '../public/assets/img/operator/laporan_harian/piechart_cuaca/';
            
            // Pastikan folder ada
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
        
            // Tentukan nama file
            $fileName1 = 'piechart_AM_'. $id_projek .'_'. $id_laporan_harian .'.png'; // Nama file untuk chart1
            $fileName2 = 'piechart_PM_'. $id_projek .'_'. $id_laporan_harian .'.png'; // Nama file untuk chart2
        
            // Simpan gambar ke file
            file_put_contents($folderPath . $fileName1, $data1);
            file_put_contents($folderPath . $fileName2, $data2);
        
            echo "Gambar berhasil disimpan sebagai $fileName1 dan $fileName2";
        } else {
            echo "Tidak ada data gambar yang diterima.";
        }
    }

    public function ubahKeteranganSPLH()
    {
        //mengambil data dari input
        $id_m_sub_pekerjaan = $_POST['id_m_sub_pekerjaan'];
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $keterangan = $_POST['keterangan'];

        //membuat kueri
        $this->db->query("UPDATE pekerjaan_harian SET keterangan = :keterangan WHERE id_laporan_harian = :id_laporan_harian AND id_m_sub_pekerjaan = :id_m_sub_pekerjaan");

        $this->db->bind('keterangan', $keterangan);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_m_sub_pekerjaan', $id_m_sub_pekerjaan);

        $this->db->execute();

        return TRUE;
    }

    public function tambahPekerjaLH()
    {
        //generate id baru
        $new_id = $this->newIdGenerator('id_pekerja', 'pekerja', 'PKJ', 6);

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_pekerja = $_POST['jumlah_pekerja'];

        //menyimpan ke database
        $pekerja_query = "INSERT INTO pekerja (id_pekerja ,id_laporan_harian, id_m_sub_pekerjaan , id_m_pekerja , jumlah_pekerja) 
                        VALUES (:new_id, :id_laporan_harian, :id_sub_pekerjaan, :id_m_pekerja, :jumlah_pekerja)";

        $this->db->query($pekerja_query);
        
        $this->db->bind('new_id', $new_id);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        $this->db->bind('id_m_pekerja', $id_m_pekerja);
        $this->db->bind('jumlah_pekerja', $jumlah_pekerja);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahPekerjaLH()
    {
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $id_pekerja = $_POST['id_pekerja'];
        $jumlah_pekerja = $_POST['jumlah_pekerja'];

        $ubah = ("UPDATE pekerja SET id_m_pekerja = :id_m_pekerja, jumlah_pekerja = :jumlah_pekerja WHERE id_pekerja = :id_pekerja");

        $this->db->query($ubah);

        $this->db->bind('id_m_pekerja', $id_m_pekerja);
        $this->db->bind('jumlah_pekerja', $jumlah_pekerja);
        $this->db->bind('id_pekerja', $id_pekerja);

        $this->db->execute();
    }

    public function hapusPekerjaLH()
    {
        $id_pekerja = $_POST['id_pekerja'];

        $hapus = ("DELETE FROM pekerja WHERE id_pekerja = :id_pekerja");

        $this->db->query($hapus);
        $this->db->bind('id_pekerja',$id_pekerja);
        $this->db->execute();
    }

    public function tambahPeralatanLH()
    {
        //generate id baru
        $new_id = $this->newIdGenerator('id_peralatan', 'peralatan', 'PRLTN', 6);
        
        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_peralatan = $_POST['id_m_peralatan'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_peralatan = $_POST['jumlah_peralatan'];

        //menyimpan ke database
        $peralatan = "INSERT INTO 
                            peralatan (id_peralatan ,id_laporan_harian, id_m_sub_pekerjaan , id_m_peralatan , jumlah_peralatan) 
                            VALUES (:new_id, :id_laporan_harian, :id_sub_pekerjaan, :id_m_peralatan, :jumlah_peralatan)";

        $this->db->query($peralatan);

        $this->db->bind('new_id', $new_id);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        $this->db->bind('id_m_peralatan', $id_m_peralatan);
        $this->db->bind('jumlah_peralatan', $jumlah_peralatan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahPeralatanLH()
    {
        $id_m_peralatan = $_POST['id_m_peralatan'];
        $jumlah_peralatan = $_POST['jumlah_peralatan'];
        $id_peralatan = $_POST['id_peralatan'];

        $ubah = ("UPDATE peralatan SET id_m_peralatan = :id_m_peralatan, jumlah_peralatan = :jumlah_peralatan WHERE id_peralatan = :id_peralatan" );

        $this->db->query($ubah);

        $this->db->bind('id_m_peralatan', $id_m_peralatan);
        $this->db->bind('jumlah_peralatan', $jumlah_peralatan);
        $this->db->bind('id_peralatan', $id_peralatan);

        $this->db->execute();
    }

    public function hapusPeralatanLH()
    {
        $id_peralatan = $_POST['id_peralatan'];

        $hapus = ("DELETE FROM peralatan WHERE id_peralatan = :id_peralatan" );

        $this->db->query($hapus);
        $this->db->bind('id_peralatan', $id_peralatan);
        $this->db->execute();
    }

    public function tambahBahanLH()
    {
        //generate id baru
        $new_id = $this->newIdGenerator('id_bahan', 'bahan', 'BHN', 6);
        
        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $id_m_bahan = $_POST['id_m_bahan'];
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'];

        $jumlah_bahan = $_POST['jumlah_bahan'];

        //menyimpan ke database
        $bahan = "INSERT INTO 
                            bahan (id_bahan ,id_laporan_harian, id_m_sub_pekerjaan , id_m_bahan , jumlah_bahan) 
                            VALUES (:new_id,:id_laporan_harian, :id_sub_pekerjaan, :id_m_bahan,:jumlah_bahan)";

        $this->db->query($bahan);

        $this->db->bind('new_id', $new_id);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        $this->db->bind('id_m_bahan', $id_m_bahan);
        $this->db->bind('jumlah_bahan', $jumlah_bahan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahBahanLH()
    {
        $id_m_bahan = $_POST['id_m_bahan'];
        $jumlah_bahan = $_POST['jumlah_bahan'];
        $id_bahan = $_POST['id_bahan'];

        $ubah = ("UPDATE bahan SET id_m_bahan = :id_m_bahan, jumlah_bahan = :jumlah_bahan WHERE id_bahan = :id_bahan" );

        $this->db->query($ubah);
        $this->db->bind('id_m_bahan', $id_m_bahan);
        $this->db->bind('jumlah_bahan', $jumlah_bahan);
        $this->db->bind('id_bahan', $id_bahan);
        $this->db->execute();
    }

    public function hapusBahanLH()
    {
        $id_bahan = $_POST['id_bahan'];

        $hapus = ("DELETE FROM bahan WHERE id_bahan = :id_bahan" );

        $this->db->query($hapus);
        $this->db->bind('id_bahan', $id_bahan);
        $this->db->execute();
    }

    public function tambahPermasalahan()
    {
        //generate id baru
        $new_id = $this->newIdGenerator('id_permasalahan', 'permasalahan', 'MSL', 6);

        // Ambil data dari form
        $id_laporan_harian = $_POST['id_laporan_harian'];
        $permasalahan = $_POST['permasalahan'];
        $saran = $_POST['saran'];

        //menyimpan ke database
        $permasalahan_query = "INSERT INTO permasalahan (id_permasalahan ,id_laporan_harian, permasalahan , saran) 
                            VALUES ( :new_id, :id_laporan_harian, :permasalahan, :saran)";

        $this->db->query($permasalahan_query);

        $this->db->bind('new_id', $new_id);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('permasalahan', $permasalahan);
        $this->db->bind('saran', $saran);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahPermasalahan()
    {
        $permasalahan = $_POST['permasalahan'];
        $saran = $_POST['saran'];
        $id_permasalahan = $_POST['id_permasalahan'];

        $ubah = ("UPDATE permasalahan SET permasalahan = :permasalahan, saran = :saran WHERE id_permasalahan = :id_permasalahan" );

        $this->db->query($ubah);

        $this->db->bind('permasalahan', $permasalahan);
        $this->db->bind('saran', $saran);
        $this->db->bind('id_permasalahan', $id_permasalahan);

        $this->db->execute();

    }

    public function hapusPermasalahan()
    {
        $id_permasalahan = $_POST['id_permasalahan'];

        $hapus = ("DELETE FROM permasalahan WHERE id_permasalahan = :id_permasalahan" );

        $this->db->query($hapus);
        $this->db->bind('id_permasalahan', $id_permasalahan);
        $this->db->execute();
    }

    public function tambahFotoMasalah()
{
    // Menyimpan post ke variabel
    $id_permasalahan = $_POST['id_permasalahan'];

    // Handling file upload
    $foto_temp = $_FILES['foto']['tmp_name'];
    $foto_error = $_FILES['foto']['error'];

    // Mendapatkan ekstensi file asli
    $foto_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $foto_name = uniqid() . '.webp'; // Ubah ekstensi menjadi .webp
    $foto_path = '../public/assets/img/uploads/foto_masalah/' . $foto_name;

    // Periksa apakah tidak ada error saat upload
    if ($foto_error === UPLOAD_ERR_OK) {
        // Pindahkan file dari temporary location ke lokasi yang ditentukan
        if (move_uploaded_file($foto_temp, $foto_path)) {
            // Mengubah dan mengompres gambar ke format WebP
            $this->convertToWebP($foto_path, $foto_ext);

            // Menyimpan ke database
            $sql_foto_masalah = "INSERT INTO foto_masalah (id_permasalahan, foto_masalah) 
                                VALUES (:id_permasalahan, :foto)";

            $this->db->query($sql_foto_masalah);
            $this->db->bind('id_permasalahan', $id_permasalahan);
            $this->db->bind('foto', $foto_name); // Changed 'foto_name' to 'foto'

            if ($this->db->execute()) {
                return $this->db->rowCount(); // Return the number of affected rows
            } else {
                echo "Error: Gagal memperbarui database.";
                return false; // Return false to indicate failure
            }

        } else {
            echo "Error: File tidak dapat dipindahkan.";
            // Error tambahan untuk membantu troubleshooting
            if (!file_exists('../public/assets/img/uploads/foto_masalah/')) {
                echo "Error: Direktori tujuan tidak ditemukan.";
            } else if (!is_writable('../public/assets/img/uploads/foto_masalah/')) {
                echo "Error: Direktori tujuan tidak memiliki izin tulis.";
            }
            return false; // Return false to indicate failure
        }
    } else {
        // Menangani berbagai kesalahan upload file
        switch ($foto_error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Error: Ukuran file terlalu besar.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "Error: File hanya ter-upload sebagian.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Error: Tidak ada file yang di-upload.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Error: Folder temporary tidak ditemukan.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Error: Gagal menulis file ke disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                break;
            default:
                echo "Error: Terjadi kesalahan yang tidak diketahui.";
                break;
        }
        return false; // Return false to indicate failure
    }
}




    public function ubahFotoMasalah()
    {
        // Dapatkan nilai dari form
        $id = $_POST['id'];

        // Mengambil nama file lama dari database
        $sql_get_foto = "SELECT foto_masalah FROM foto_masalah WHERE id = :id";
        $this->db->query($sql_get_foto);
        $this->db->bind('id', $id);
        $result = $this->db->single();

        if ($result) {
            $old_foto_name = $result['foto_masalah'];
            $old_foto_path = '../public/assets/img/uploads/foto_masalah/' . $old_foto_name;

            // Periksa apakah ada file baru yang diupload
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $foto_error = $_FILES['foto']['error'];
                $foto_name = $_FILES['foto']['name'];
                $foto_temp = $_FILES['foto']['tmp_name'];

                if ($foto_error === UPLOAD_ERR_OK) {
                    // Menghapus file lama dari server
                    if (file_exists($old_foto_path)) {
                        unlink($old_foto_path);
                    }

                    // Menentukan nama file baru
                    $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
                    $foto_new_name = uniqid() . '.' . $foto_ext;
                    $foto_path = '../public/assets/img/uploads/foto_masalah/' . $foto_new_name;

                    // Pindahkan file dari temporary location ke lokasi yang ditentukan
                    if (move_uploaded_file($foto_temp, $foto_path)) {
                        // Mengubah dan mengompres gambar ke format WebP
                        $this->convertToWebP($foto_path, $foto_ext);

                        // Update database dengan nama file baru
                        $sql_update_foto = "UPDATE foto_masalah SET foto_masalah = :foto_masalah WHERE id = :id";
                        $this->db->query($sql_update_foto);
                        $this->db->bind('foto_masalah', $foto_new_name);
                        $this->db->bind('id', $id);

                        if ($this->db->execute()) {
                            return;
                        } else {
                            echo "Error: Gagal memperbarui database.";
                        }
                    } else {
                        echo "Error: File tidak dapat dipindahkan.";
                        if (!file_exists('../public/assets/img/uploads/foto_masalah/')) {
                            echo "Error: Direktori tujuan tidak ditemukan.";
                        } else if (!is_writable('../public/assets/img/uploads/foto_masalah/')) {
                            echo "Error: Direktori tujuan tidak memiliki izin tulis.";
                        }
                    }
                } else {
                    switch ($foto_error) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            echo "Error: Ukuran file terlalu besar.";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            echo "Error: File hanya ter-upload sebagian.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            echo "Error: Tidak ada file yang di-upload.";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            echo "Error: Folder temporary tidak ditemukan.";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            echo "Error: Gagal menulis file ke disk.";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                            break;
                        default:
                            echo "Error: Terjadi kesalahan yang tidak diketahui.";
                            break;
                    }
                }
            } 
        } else {
            echo "Error: Foto tidak ditemukan.";
        }
    }

    public function hapusFotoMasalah()
    {
        $id = $_POST['id'];
        
            // Mengambil nama file dari database
            $sql_get_foto = "SELECT foto_masalah FROM foto_masalah WHERE id = :id";
            $this->db->query($sql_get_foto);
            $this->db->bind('id', $id);
        
            $row = $this->db->single();
        
            if ($row) {
                $foto_name = $row['foto_masalah'];
                $foto_path = '../public/assets/img/uploads/foto_masalah/' . $foto_name;
        
                // Menghapus file dari server
                if (file_exists($foto_path)) {
                    unlink($foto_path);
                } else {
                    echo "Error: File tidak ditemukan di server.";
                }
        
                // Menghapus entri dari database
                $sql_delete_foto = "DELETE FROM foto_masalah WHERE id = :id";
                $this->db->query($sql_delete_foto);
                $this->db->bind('id', $id);
        
                if ($this->db->execute()) {
                    return;
                } else {
                    echo "Error: Gagal menghapus entri dari database.";
                }
            } else {
                echo "Error: Foto tidak ditemukan di database.";
            }
    }

    public function tambahFotoKegiatan()
    {
    // Generate id baru
    $new_id = $this->newIdGenerator('id_foto_kegiatan', 'foto_kegiatan', 'FTO', 6);
    
    // Menyimpan post ke variabel
    $id_laporan_harian = $_POST['id_laporan_harian'];
    $keterangan = $_POST['keterangan'];

    // Handling file upload
    $foto_temp = $_FILES['foto']['tmp_name'];
    $foto_error = $_FILES['foto']['error'];
    
    // Mendapatkan ekstensi file asli
    $foto_ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    
    // Menentukan nama file baru dengan id yang dihasilkan
    $foto_name = $new_id . '.' . $foto_ext;
    $foto_path = '../public/assets/img/uploads/foto_kegiatan/' . $foto_name;

    // Periksa apakah tidak ada error saat upload
    if ($foto_error === UPLOAD_ERR_OK) {
        // Pindahkan file dari temporary location ke lokasi yang ditentukan
        if (move_uploaded_file($foto_temp, $foto_path)) {
            // Mengubah dan mengompres gambar ke format WebP
            $this->convertToWebP($foto_path, $foto_ext);

            // Menyimpan ke database
            $sql_foto = "INSERT INTO foto_kegiatan (id_foto_kegiatan, id_laporan_harian, foto, keterangan) 
                        VALUES (:new_id, :id_laporan_harian, :foto_name, :keterangan)";

            $this->db->query($sql_foto);
            $this->db->bind('new_id', $new_id);
            $this->db->bind('id_laporan_harian', $id_laporan_harian);
            $this->db->bind('foto_name', $foto_name);
            $this->db->bind('keterangan', $keterangan);

            if ($this->db->execute()) {
                return  $this->db->rowCount();
            } else {
                echo "Error: Gagal memperbarui database.";
            }

        } else {
            echo "Error: File tidak dapat dipindahkan.";
            // Error tambahan untuk membantu troubleshooting
            if (!file_exists('../public/assets/img/uploads/foto_kegiatan/')) {
                echo "Error: Direktori tujuan tidak ditemukan.";
            } else if (!is_writable('../public/assets/img/uploads/foto_kegiatan/')) {
                echo "Error: Direktori tujuan tidak memiliki izin tulis.";
            }
        }
    } else {
        // Menangani berbagai kesalahan upload file
        switch ($foto_error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Error: Ukuran file terlalu besar.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "Error: File hanya ter-upload sebagian.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Error: Tidak ada file yang di-upload.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Error: Folder temporary tidak ditemukan.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Error: Gagal menulis file ke disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                break;
            default:
                echo "Error: Terjadi kesalahan yang tidak diketahui.";
                break;
        }
    }
}

    
    public function ubahFotoKegiatan()
    {
        // Dapatkan nilai dari form
        $id_foto_kegiatan = $_POST['id_foto_kegiatan'];
        $keterangan = $_POST['keterangan'];

        // Mengambil nama file lama dari database
        $sql_get_foto = "SELECT foto FROM foto_kegiatan WHERE id_foto_kegiatan = :id_foto_kegiatan";
        $this->db->query($sql_get_foto);
        $this->db->bind('id_foto_kegiatan', $id_foto_kegiatan);
        $result = $this->db->single();

        if ($result) {
            $old_foto_name = $result['foto'];
            $old_foto_path = '../public/assets/img/uploads/foto_kegiatan/' . $old_foto_name;

            // Periksa apakah ada file baru yang diupload
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $foto_error = $_FILES['foto']['error'];
                $foto_name = $_FILES['foto']['name'];
                $foto_temp = $_FILES['foto']['tmp_name'];

                if ($foto_error === UPLOAD_ERR_OK) {
                    // Menghapus file lama dari server
                    if (file_exists($old_foto_path)) {
                        unlink($old_foto_path);
                    }

                    // Menentukan nama file baru
                    $foto_ext = pathinfo($foto_name, PATHINFO_EXTENSION);
                    $foto_new_name = $id_foto_kegiatan . '.' . $foto_ext;
                    $foto_path = '../public/assets/img/uploads/foto_kegiatan/' . $foto_new_name;

                    // Pindahkan file dari temporary location ke lokasi yang ditentukan
                    if (move_uploaded_file($foto_temp, $foto_path)) {
                        // Mengubah dan mengompres gambar ke format WebP
                        $this->convertToWebP($foto_path, $foto_ext);

                        // Update database dengan nama file baru
                        $sql_update_foto = "UPDATE foto_kegiatan SET foto = :foto, keterangan = :keterangan WHERE id_foto_kegiatan = :id_foto_kegiatan";
                        $this->db->query($sql_update_foto);
                        $this->db->bind('foto', $foto_new_name);
                        $this->db->bind('keterangan', $keterangan);
                        $this->db->bind('id_foto_kegiatan', $id_foto_kegiatan);

                        if ($this->db->execute()) {
                            return;
                        } else {
                            echo "Error: Gagal memperbarui database.";
                        }
                    } else {
                        echo "Error: File tidak dapat dipindahkan.";
                        if (!file_exists('../public/assets/img/uploads/foto_kegiatan/')) {
                            echo "Error: Direktori tujuan tidak ditemukan.";
                        } else if (!is_writable('../public/assets/img/uploads/foto_kegiatan/')) {
                            echo "Error: Direktori tujuan tidak memiliki izin tulis.";
                        }
                    }
                } else {
                    switch ($foto_error) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            echo "Error: Ukuran file terlalu besar.";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            echo "Error: File hanya ter-upload sebagian.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            echo "Error: Tidak ada file yang di-upload.";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            echo "Error: Folder temporary tidak ditemukan.";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            echo "Error: Gagal menulis file ke disk.";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            echo "Error: Upload file dihentikan oleh ekstensi PHP.";
                            break;
                        default:
                            echo "Error: Terjadi kesalahan yang tidak diketahui.";
                            break;
                    }
                }
            } else {
                // Tidak ada file baru, hanya perbarui keterangan
                $sql_update_foto = "UPDATE foto_kegiatan SET keterangan = :keterangan WHERE id_foto_kegiatan = :id_foto_kegiatan";
                $this->db->query($sql_update_foto);
                $this->db->bind('keterangan', $keterangan);
                $this->db->bind('id_foto_kegiatan', $id_foto_kegiatan);

                if ($this->db->execute()) {
                    return;
                } else {
                    echo "Error: Gagal memperbarui database.";
                }
            }
        } else {
            echo "Error: Foto tidak ditemukan.";
        }
    }

    public function hapusFotoKegiatan()
    {
            $id_foto_kegiatan = $_POST['id_foto_kegiatan'];
        
            // Mengambil nama file dari database
            $sql_get_foto = "SELECT foto FROM foto_kegiatan WHERE id_foto_kegiatan = :id_foto_kegiatan";
            $this->db->query($sql_get_foto);
            $this->db->bind('id_foto_kegiatan', $id_foto_kegiatan);
        
            $row = $this->db->single();
        
            if ($row) {
                $foto_name = $row['foto'];
                $foto_path = '../public/assets/img/uploads/foto_kegiatan/' . $foto_name;
        
                // Menghapus file dari server
                if (file_exists($foto_path)) {
                    unlink($foto_path);
                } else {
                    echo "Error: File tidak ditemukan di server.";
                }
        
                // Menghapus entri dari database
                $sql_delete_foto = "DELETE FROM foto_kegiatan WHERE id_foto_kegiatan = :id_foto_kegiatan";
                $this->db->query($sql_delete_foto);
                $this->db->bind('id_foto_kegiatan', $id_foto_kegiatan);
        
                if ($this->db->execute()) {
                    return;
                } else {
                    echo "Error: Gagal menghapus entri dari database.";
                }
            } else {
                echo "Error: Foto tidak ditemukan di database.";
            }
    }

    

    public function tambahTimPengawas()
    {
        if (isset($_POST['pengawas_simpan'])) {
            //generate id baru
            $new_id = $this->newIdGenerator('id_tim_pengawas', 'tim_pengawas', 'TPG', 6);
    
            // Ambil data dari form
            $id_projek = $_POST['id_projek'];
            $timpengawas = $_POST['timpengawas'];
            $timleader = $_POST['timleader'];
    
            //menyimpan ke database
            $pengawas = "INSERT INTO tim_pengawas (id_tim_pengawas ,id_projek, tim_pengawas , tim_leader) 
                        VALUES (:new_id, :id_projek, :timpengawas, :timleader)";

            $this->db->query($pengawas); 

            $this->db->bind('new_id', $new_id);  
            $this->db->bind('id_projek', $id_projek);  
            $this->db->bind('timpengawas', $timpengawas);  
            $this->db->bind('timleader', $timleader); 

            $this->db->execute();

            return $this->db->rowCount();
        }
    }

    public function ubahTimPengawas()
    {
        $tim_pengawas = $_POST['tim_pengawas'];
        $tim_leader = $_POST['tim_leader'];
        $id_tim_pengawas = $_POST['id_tim_pengawas'];

        $ubah = ("UPDATE tim_pengawas SET tim_pengawas = :tim_pengawas, tim_leader = :tim_leader WHERE id_tim_pengawas = :id_tim_pengawas" );

        $this->db->query($ubah);

        $this->db->bind('tim_pengawas', $tim_pengawas);  
        $this->db->bind('tim_leader', $tim_leader); 
        $this->db->bind('id_tim_pengawas', $id_tim_pengawas); 

        $this->db->execute();

    }

    public function hapusTimPengawas()
    {
        $id_tim_pengawas = $_POST['id_tim_pengawas'];

        $hapus = ("DELETE FROM tim_pengawas WHERE id_tim_pengawas = :id_tim_pengawas" );

        $this->db->query($hapus);
        $this->db->bind('id_tim_pengawas', $id_tim_pengawas); 
        $this->db->execute();

    }
    
    public function lastreport($id_projek, $tabel, $kolom_tanggal)
    {
        $select_tanggal = $this->db->query('SELECT '. $kolom_tanggal .
                        ' FROM '. $tabel .
                        ' WHERE id_projek = :id_projek');

        $this->db->query($select_tanggal);

        $this->db->bind('id_projek', $id_projek); 

        $list_tanggal = $this->db->resultSet();

        echo '<pre>';
    print_r($list_tanggal);
    echo '</pre>';
    }
}

