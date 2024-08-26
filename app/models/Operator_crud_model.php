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
            return "Peringatan!! Tanggal sudah ada untuk proyek ini, silakan pilih tanggal lain.";
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

        return true;
    }


    public function hapusLaporanHarian()
    {
        $hapus = ("DELETE FROM laporan_harian WHERE id_laporan_harian = '$_POST[id_laporan_harian]'" );

        $this->db->query($hapus);
        $this->db->execute();

    }

    public function ubahProgresLH()
{
    $id_projek = $_POST['id_projek'];
    $id_laporan_harian = $_POST['id_laporan_harian'];
    $progress_harian = $_POST['progress_harian'];
    $tanggal = $_POST['tanggal'];

    // Query to get the total progress up to the specified date
    $sumQuery = "SELECT SUM(progress_harian) as total_progress 
                 FROM laporan_harian 
                 WHERE id_projek = :id_projek 
                 AND tanggal < :tanggal";

    // Prepare and execute the sum query
    $this->db->query($sumQuery);
    $this->db->bind(':id_projek', $id_projek);
    $this->db->bind(':tanggal', $tanggal);
    $this->db->execute();

    // Fetch the result from the SUM query
    $result = $this->db->single();
    $total_progress_before_today = $result['total_progress'] ?? 0;

    // Calculate new total progress
    $new_total_progres = $total_progress_before_today + $progress_harian;

    // Update the report with new progress values
    $updateQuery = "UPDATE laporan_harian 
                    SET progress_harian = :progress_harian, 
                        total_progres = :total_progres 
                    WHERE id_laporan_harian = :id_laporan_harian
                    AND tanggal = :tanggal";

    // Prepare, bind, and execute the update query
    $this->db->query($updateQuery);
    $this->db->bind(':id_laporan_harian', $id_laporan_harian);
    $this->db->bind(':progress_harian', $progress_harian);
    $this->db->bind(':total_progres', $new_total_progres);
    $this->db->bind(':tanggal', $tanggal);

    $this->db->execute();

    return;
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
        $ubah = ("UPDATE pekerja SET id_m_pekerja = '$_POST[id_m_pekerja]', jumlah_pekerja = '$_POST[jumlah_pekerja]' WHERE id_pekerja = '$_POST[id_pekerja]'");

        $this->db->query($ubah);
        $this->db->execute();
    }

    public function hapusPekerjaLH()
    {
        $hapus = ("DELETE FROM pekerja WHERE id_pekerja = '$_POST[id_pekerja]'");

        $this->db->query($hapus);
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
        $ubah = ("UPDATE peralatan SET id_m_peralatan = '$_POST[id_m_peralatan]', jumlah_peralatan = '$_POST[jumlah_peralatan]' WHERE id_peralatan = '$_POST[id_peralatan]'" );

        $this->db->query($ubah);
        $this->db->execute();
    }

    public function hapusPeralatanLH()
    {
        $hapus = ("DELETE FROM peralatan WHERE id_peralatan = '$_POST[id_peralatan]'" );

        $this->db->query($hapus);
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
        $ubah = ("UPDATE bahan SET id_m_bahan = '$_POST[id_m_bahan]', jumlah_bahan = '$_POST[jumlah_bahan]' WHERE id_bahan = '$_POST[id_bahan]'" );

        $this->db->query($ubah);
        $this->db->execute();
    }

    public function hapusBahanLH()
    {
        $hapus = ("DELETE FROM bahan WHERE id_bahan = '$_POST[id_bahan]'" );

        $this->db->query($hapus);
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
        $ubah = ("UPDATE permasalahan SET permasalahan = '$_POST[permasalahan]', saran = '$_POST[saran]' WHERE id_permasalahan = '$_POST[id_permasalahan]'" );

        $this->db->query($ubah);
        $this->db->execute();

    }

    public function hapusPermasalahan()
    {
        $hapus = ("DELETE FROM permasalahan WHERE id_permasalahan = '$_POST[id_permasalahan]'" );

        $this->db->query($hapus);
        $this->db->execute();

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
        $ubah = ("UPDATE tim_pengawas SET tim_pengawas = '$_POST[tim_pengawas]', tim_leader = '$_POST[tim_leader]' WHERE id_tim_pengawas = '$_POST[id_tim_pengawas]'" );

        $this->db->query($ubah);
        $this->db->execute();

    }

    public function hapusTimPengawas()
    {
        $hapus = ("DELETE FROM tim_pengawas WHERE id_tim_pengawas = '$_POST[id_tim_pengawas]'" );

        $this->db->query($hapus);
        $this->db->execute();

    }
}