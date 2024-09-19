<?php
 class Laporan_mingguan_crud_model {
    private $tableprojek = 'm_projek';
    private $tablelaporan = 'laporan_harian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getWeeklyRanges($dataprojek) 
    {
        $weeks = [];
        $startDate = $dataprojek['tanggal_mulai'];

        //memerika apakah ada tambahan waktu
        if (!empty($dataprojek['tambahan_waktu'])) {
            $endDate = $dataprojek['tambahan_waktu'];
        } else {
            $endDate = $dataprojek['tanggal_selesai'];
        }

        $current = strtotime($startDate);
        $end = strtotime($endDate);
    
        while ($current <= $end) {
            // Tentukan awal dan akhir minggu
            $weekStart = $current;
            $weekEnd = strtotime("+6 days", $weekStart);
    
            // Pastikan akhir minggu tidak melebihi tanggal selesai
            if ($weekEnd > $end) {
                $weekEnd = $end;
            }
    
            // Simpan rentang minggu dalam format yang diinginkan
            $weeks[] = [
                'start' => date("Y-m-d", $weekStart),
                'end' => date("Y-m-d", $weekEnd),
            ];
    
            // Pindah ke minggu berikutnya
            $current = strtotime("+1 week", $current);
        }
    
        return $weeks;
    }

    public function getAllWeekData($data)
    {
        $mingguKeData = [];
        $tanggal_mulai_projek = new DateTime($data['projek']['tanggal_mulai']);

        foreach ($data['all_laporan_mingguan'][$data['max_cco']] as $laporan) { 
            $tanggal_laporan = new DateTime($laporan['tanggal_mulai']);

            // Menghitung selisih hari antara tanggal laporan dan tanggal mulai proyek
            $selisih_hari = $tanggal_mulai_projek->diff($tanggal_laporan)->days;

            $minggu_ke = floor($selisih_hari / 7) + 1;
                
            $mingguKeData[] = $minggu_ke;
        }
        return $mingguKeData;
    }

    public function tambahLaporanMinguan()
    {
        //mengambil data dari input
        $cco = $_POST['cco'];
        $id_projek = $_POST['id_projek'];
        $id_laporan_mingguan = $_POST['id_laporan_mingguan'];
        $rencana_progres = $_POST['rencana_progres_cco'.$cco];
        //$realisasi_progres = $_POST['realisasi_progres_cco'.$cco];
        $realisasi_progres = NULL;
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];

        if ($realisasi_progres == 0){
            $realisasi_progres = NULL;
        }

        // Cek apakah sudah ada laporan harian dengan tanggal yang sama untuk proyek yang sama
        $cek_tanggal_query = "SELECT COUNT(*) as count FROM laporan_mingguan WHERE id_projek = :id_projek AND tanggal_mulai = :tanggal_mulai";
        $this->db->query($cek_tanggal_query);
        $this->db->bind(':id_projek', $id_projek);
        $this->db->bind(':tanggal_mulai', $tanggal_mulai);
        $this->db->execute();
        $result = $this->db->single();
        
        if ($result['count'] > 0) {
            // Jika sudah ada tanggal yang sama, kembalikan nilai atau pesan error
            
            return Flasher::setFlash('Gagal', 'Minggu yang dipilih sudah ada!', 'danger');
        }

        // Insert ke tabel mingguan
        $laporan_mingguan_query = 'INSERT INTO laporan_mingguan (id_laporan_mingguan, id_projek, tanggal_mulai, tanggal_selesai, rencana_progres_cco'. $cco .', realisasi_progres_cco'. $cco .') 
                                    VALUES (:id_laporan_mingguan, :id_projek, :tanggal_mulai, :tanggal_selesai, :rencana_progres, :realisasi_progres)';

        $this->db->query($laporan_mingguan_query);
        $this->db->bind(':id_laporan_mingguan', $id_laporan_mingguan);
        $this->db->bind(':id_projek', $id_projek);
        $this->db->bind(':tanggal_mulai', $tanggal_mulai);
        $this->db->bind(':tanggal_selesai', $tanggal_selesai);
        $this->db->bind(':rencana_progres', $rencana_progres);
        $this->db->bind(':realisasi_progres', $realisasi_progres);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahLaporanMingguan()
    {
        $id_laporan_mingguan = $_POST['id_laporan_mingguan'];
        $cco = $_POST['cco'];
        $rencana_progres = $_POST['rencana_progres_cco'.$cco];
        $realisasi_progres = $_POST['realisasi_progres_cco'.$cco];

        if ($realisasi_progres == 0 || $realisasi_progres == NULL){
            $realisasi_progres = NULL;
        }

        $this->db->query('UPDATE laporan_mingguan SET rencana_progres_cco'. $cco .' = :rencana_progres, realisasi_progres_cco'. $cco .' = :realisasi_progres 
                            WHERE id_laporan_mingguan = :id_laporan_mingguan');
        
        $this->db->bind(':rencana_progres', $rencana_progres);
        $this->db->bind(':realisasi_progres', $realisasi_progres);
        $this->db->bind(':id_laporan_mingguan', $id_laporan_mingguan);
        
        $this->db->execute();

        return TRUE;
    }

    public function hapusLaporanMingguan()
    {
        $id_laporan_mingguan = $_POST['id_laporan_mingguan'];

        $this->db->query("DELETE FROM laporan_mingguan WHERE id_laporan_mingguan = :id_laporan_mingguan");

        $this->db->bind(':id_laporan_mingguan', $id_laporan_mingguan);

        $this->db->execute();

        return TRUE;
    }

    public function ubahProgresKumulatifLM($data)
    {
        $id_projek = $data['id_projek'];
        $max_cco = $data['max_cco'];

        // Ambil semua data laporan mingguan berdasarkan id_projek
        $this->db->query("SELECT * FROM laporan_mingguan WHERE id_projek = :id_projek ORDER BY tanggal_mulai ASC");
        $this->db->bind(':id_projek', $id_projek);
        $laporanMingguan = $this->db->resultSet();

        $rencanaKumulatif = 0; // Inisialisasi variabel untuk progres kumulatif rencana
        $realisasiKumulatif = 0; // Inisialisasi variabel untuk progres kumulatif realisasi

        // Iterasi melalui setiap laporan mingguan dan update progres kumulatif
        foreach ($laporanMingguan as $laporan) {
            // Tambahkan progres minggu ini ke dalam kumulatif
            if ($laporan['realisasi_progres_cco'.$max_cco] == 0) {
                $realisasiKumulatif = NULL;
            } else {
                $realisasiKumulatif += $laporan['realisasi_progres_cco'.$max_cco];
            }

            if ($laporan['rencana_progres_cco'.$max_cco] == 0) {
                $rencanaKumulatif = NULL;
            } else {
                $rencanaKumulatif += $laporan['rencana_progres_cco'.$max_cco];
            }
            
            // Update progres kumulatif dalam tabel
            $this->db->query('UPDATE laporan_mingguan SET 
                rencana_progres_kumulatif_cco'. $max_cco .' = :rencana_kumulatif, 
                realisasi_progres_kumulatif_cco'. $max_cco .' = :realisasi_kumulatif
                WHERE id_laporan_mingguan = :id_laporan_mingguan');

            $this->db->bind(':rencana_kumulatif', $rencanaKumulatif);
            $this->db->bind(':realisasi_kumulatif', $realisasiKumulatif);
            $this->db->bind(':id_laporan_mingguan', $laporan['id_laporan_mingguan']);

            $this->db->execute();
        }

        return true;
    }

    public function tambahCCO($data)
    {
        $max_cco = $data['max_cco'];   // Maximum CCO value
        $new_cco = $max_cco + 1;       // Increment the CCO value
        $id_projek = $data['id_projek']; // Project ID
        $tanggal_rubah = $data['tanggal_rubah']; // Project ID

        // Ensure that $new_cco does not exceed the limit (assuming 10 is the limit)
        if ($new_cco <= 10) {
            // Loop through the weekly reports for the current max_cco
            foreach ($data['all_laporan_mingguan'][$max_cco] as $laporan) {
                // Check if the required progress data exists
                if (!empty($laporan['rencana_progres_cco'.$max_cco]) || !empty($laporan['realisasi_progres_cco'.$max_cco])) {
                    // Update the cumulative progress for the new CCO in the database
                    $this->db->query('UPDATE laporan_mingguan SET 
                        tanggal_rubah_cco' . $new_cco . ' = :tanggal_rubah,
                        rencana_progres_cco' . $new_cco . ' = :rencana_progres,
                        rencana_progres_kumulatif_cco' . $new_cco . ' = :rencana_kumulatif, 
                        realisasi_progres_cco' . $new_cco . ' = :realisasi_progres,
                        realisasi_progres_kumulatif_cco' . $new_cco . ' = :realisasi_kumulatif
                        WHERE id_laporan_mingguan = :id_laporan_mingguan');

                    // Bind parameters using the existing data from the previous CCO
                    $this->db->bind(':tanggal_rubah', $tanggal_rubah);
                    $this->db->bind(':rencana_progres', $laporan['rencana_progres_cco' . $max_cco]);
                    $this->db->bind(':rencana_kumulatif', $laporan['rencana_progres_kumulatif_cco' . $max_cco]);
                    $this->db->bind(':realisasi_progres', $laporan['realisasi_progres_cco' . $max_cco]);
                    $this->db->bind(':realisasi_kumulatif', $laporan['realisasi_progres_kumulatif_cco' . $max_cco]);
                    $this->db->bind(':id_laporan_mingguan', $laporan['id_laporan_mingguan']);

                    // Execute the query
                    $this->db->execute();
                }
            }

            return true;  // Success response
        } else {
            Flasher::setFlash('Gagal', 'Data CCO Sudah Melebihi Batas', 'danger');
            return false;
        }

        return false;  // Return false if CCO exceeds the limit or no data
    }

    public function hapusCCO($data)
    {
        $cco = $data['max_cco'];   // Maximum CCO value
        $null_value = NULL;   // Maximum CCO value
        $id_projek = $data['id_projek']; // Project ID

        // Ensure that $new_cco does not exceed the limit (assuming 10 is the limit)
        if ($cco <= 10) {
            // Loop through the weekly reports for the current max_cco
            foreach ($data['all_laporan_mingguan'][$cco] as $laporan) {
                // Check if the required progress data exists
                if (!empty($laporan['rencana_progres_cco'.$cco]) || !empty($laporan['realisasi_progres_cco'.$cco])) {
                    // Update the cumulative progress for the new CCO in the database
                    $this->db->query('UPDATE laporan_mingguan SET 
                        rencana_progres_cco' . $cco . ' = :null_value, 
                        rencana_progres_kumulatif_cco' . $cco . ' = :null_value, 
                        realisasi_progres_cco' . $cco . ' = :null_value,
                        realisasi_progres_kumulatif_cco' . $cco . ' = :null_value
                        WHERE id_laporan_mingguan = :id_laporan_mingguan');

                    // Bind parameters using the existing data from the previous CCO
                    $this->db->bind(':null_value', $null_value);
                    $this->db->bind(':id_laporan_mingguan', $laporan['id_laporan_mingguan']);

                    // Execute the query
                    $this->db->execute();
                }
            }

            return true;  // Success response
        }

        return false;  // Return false if CCO exceeds the limit or no data
    }

    public function filterLM($data)
    {
        // Loop through each set of data
        $tanggalTampil = []; // Array untuk menyimpan tanggal yang sudah ditampilkan

        // Loop through each set of data
        foreach ($data as $index => $laporanSet) {
            // Iterasi setiap laporan mingguan
            foreach ($laporanSet as $laporan) {
                // Check apakah ada tanggal rubah CCO
                $tanggalRubahField = 'tanggal_rubah_cco' . $index; // Menggunakan index untuk menentukan field
                if (!empty($laporan[$tanggalRubahField]) && ($laporan[$tanggalRubahField] >= $laporan['tanggal_mulai'] && $laporan[$tanggalRubahField] <= $laporan['tanggal_selesai'])) {
                    $tanggalRubah = $laporan['tanggal_selesai'];
                    
                    // Cek apakah tanggal ini sudah pernah ditampilkan
                    if (!in_array($tanggalRubah, $tanggalTampil)) {
                        // Simpan tanggal yang belum pernah ditampilkan
                        $tanggalTampil[] = $tanggalRubah;
                    }
                }
            }
        }
        
        foreach ($data as $index => $laporanSet) {
            // Tentukan batasan untuk indeks CCO
            // Loop kedua untuk mereset nilai progres jika syarat dipenuhi
            foreach ($data as $index => &$laporanSet) {
                foreach ($laporanSet as &$laporan) {
                    // Logika perbandingan tanggal_selesai dengan tanggalTampil berdasarkan index
                    
                    // Jika index 0 dan tanggal_selesai lebih besar dari tanggalTampil[index]
                    if (($index == 0 && isset($tanggalTampil[$index])) && $laporan['tanggal_selesai'] > $tanggalTampil[$index]) {
                        // Reset nilai progres
                        $laporan['rencana_progres_cco'.$index] = NULL;
                        $laporan['rencana_progres_kumulatif_cco'.$index] = NULL;
                        $laporan['realisasi_progres_cco'.$index] = NULL;
                        $laporan['realisasi_progres_kumulatif_cco'.$index] = NULL;

                    // Jika index 9 dan tanggal_selesai lebih kecil dari tanggalTampil[index]
                    } elseif ($index == 9 && $laporan['tanggal_selesai'] < $tanggalTampil[$index]) {
                        // Reset nilai progres
                        $laporan['rencana_progres_cco'.$index] = NULL;
                        $laporan['rencana_progres_kumulatif_cco'.$index] = NULL;
                        $laporan['realisasi_progres_cco'.$index] = NULL;
                        $laporan['realisasi_progres_kumulatif_cco'.$index] = NULL;

                    // Untuk semua index lain, jika tanggal_selesai <= tanggalTampil[$index-1] dan >= tanggalTampil[$index]
                    } elseif (($index != 0 && $index != 9 && isset($tanggalTampil[$index])) && ($laporan['tanggal_selesai'] < $tanggalTampil[$index-1] || $laporan['tanggal_selesai'] > $tanggalTampil[$index])) {
                        // Reset nilai progres
                        $laporan['rencana_progres_cco'.$index] = NULL;
                        $laporan['rencana_progres_kumulatif_cco'.$index] = NULL;
                        $laporan['realisasi_progres_cco'.$index] = NULL;
                        $laporan['realisasi_progres_kumulatif_cco'.$index] = NULL;
                    } elseif (($index != 0 && $index != 9 ) && ($laporan['tanggal_selesai'] <= $tanggalTampil[$index-1])) {
                        // Reset nilai progres
                        $laporan['rencana_progres_cco'.$index] = NULL;
                        $laporan['rencana_progres_kumulatif_cco'.$index] = NULL;
                        $laporan['realisasi_progres_cco'.$index] = NULL;
                        $laporan['realisasi_progres_kumulatif_cco'.$index] = NULL;
                    }
                }
            } 
        }
        return $data; // Pastikan data dikembalikan
    }


    public function saveLineChart($data)
    {
        if (isset($_POST['image'])) {
            // Proses penyimpanan gambar
            $data = $_POST['image'];
            $id_projek = $_POST['id_projek'];
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);
        
            $folderPath = '../public/assets/img/operator/laporan_mingguan/';
            $fileName = 'Linechart_LM_'. $id_projek . '.png';
            $filePath = $folderPath . $fileName;
        
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
        
            if (file_put_contents($filePath, $data)) {
                // Jika berhasil menyimpan, set flasher dan kirim respons JSON
                Flasher::setFlash('Sukses', 'Linechart Berhasil Dibuat dan Disimpan', 'success');
                echo json_encode(['status' => 'success', 'message' => 'Linechart Berhasil Dibuat dan Disimpan']);
            } else {
                // Jika gagal menyimpan, set flasher dan kirim respons JSON
                Flasher::setFlash('Gagal', 'Linechart Gagal Disimpan', 'danger');
                echo json_encode(['status' => 'error', 'message' => 'Linechart Gagal Disimpan']);
            }
        } else {
            // Jika tidak ada data gambar, set flasher dan kirim respons JSON
            Flasher::setFlash('Gagal', 'Tidak Ada Data Gambar yang Diterima', 'danger');
            echo json_encode(['status' => 'error', 'message' => 'Tidak Ada Data Gambar yang Diterima']);
        }
    }
 }