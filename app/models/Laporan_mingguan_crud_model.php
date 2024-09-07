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

    public function tambahLaporanMinguan()
    {
        //mengambil data dari input
        $id_projek = $_POST['id_projek'];
        $id_laporan_mingguan = $_POST['id_laporan_mingguan'];
        $rencana_progres = $_POST['rencana_progres'];
        $realisasi_progres = $_POST['realisasi_progres'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];

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
        $laporan_mingguan_query = "INSERT INTO laporan_mingguan (id_laporan_mingguan, id_projek, tanggal_mulai, tanggal_selesai, rencana_progres, realisasi_progres) 
                                    VALUES (:id_laporan_mingguan, :id_projek, :tanggal_mulai, :tanggal_selesai, :rencana_progres, :realisasi_progres)";

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
        $rencana_progres = $_POST['rencana_progres'];
        $realisasi_progres = $_POST['realisasi_progres'];

        if ($realisasi_progres == 0){
            $realisasi_progres = NULL;
        }

        $this->db->query("UPDATE laporan_mingguan SET rencana_progres = :rencana_progres, realisasi_progres = :realisasi_progres WHERE id_laporan_mingguan = :id_laporan_mingguan");
        
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

    public function ubahProgresKumulatifLM($id_projek)
    {
        // Ambil semua data laporan mingguan berdasarkan id_projek
        $this->db->query("SELECT * FROM laporan_mingguan WHERE id_projek = :id_projek ORDER BY tanggal_mulai ASC");
        $this->db->bind(':id_projek', $id_projek);
        $laporanMingguan = $this->db->resultSet();

        $rencanaKumulatif = 0; // Inisialisasi variabel untuk progres kumulatif rencana
        $realisasiKumulatif = 0; // Inisialisasi variabel untuk progres kumulatif realisasi

        // Iterasi melalui setiap laporan mingguan dan update progres kumulatif
        foreach ($laporanMingguan as $laporan) {
            // Tambahkan progres minggu ini ke dalam kumulatif
            if ($laporan['realisasi_progres'] == 0) {
                $realisasiKumulatif = NULL;
            } else {
                $realisasiKumulatif += $laporan['realisasi_progres'];
            }
            $rencanaKumulatif += $laporan['rencana_progres'];
            
            // Update progres kumulatif dalam tabel
            $this->db->query("UPDATE laporan_mingguan SET 
                rencana_progres_kumulatif = :rencana_kumulatif, 
                realisasi_progres_kumulatif = :realisasi_kumulatif
                WHERE id_laporan_mingguan = :id_laporan_mingguan");

            $this->db->bind(':rencana_kumulatif', $rencanaKumulatif);
            $this->db->bind(':realisasi_kumulatif', $realisasiKumulatif);
            $this->db->bind(':id_laporan_mingguan', $laporan['id_laporan_mingguan']);

            $this->db->execute();
        }

        return true;
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