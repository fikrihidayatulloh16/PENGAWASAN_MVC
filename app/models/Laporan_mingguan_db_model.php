<?php
 class Laporan_mingguan_db_model {
    private $tableprojek = 'm_projek';
    private $tablelh = 'laporan_harian';
    private $tablelm = 'laporan_mingguan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    public function getWeeklyRanges($startDate, $endDate) {
        $weeks = [];
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

    public function getAllLMByIdProjek($data)
    {
        $max_cco = $data['max_cco'];   // Nilai maksimal CCO
        $id_projek = $data['id_projek'];
        $result = [];  // Variabel untuk menyimpan semua hasil query



        // Loop untuk setiap CCO hingga nilai maksimal
        for ($cco = 0; $cco <= $max_cco; $cco++) {
            // Query untuk mendapatkan data laporan mingguan berdasarkan CCO yang berbeda
            $this->db->query('SELECT lm.id_laporan_mingguan, lm.id_projek, lm.tanggal_mulai, lm.tanggal_selesai, 
                                    lh.tanggal, lm.rencana_progres_cco'. $cco .', lm.rencana_progres_kumulatif_cco'. $cco .', 
                                    lm.realisasi_progres_cco'. $cco .', lm.realisasi_progres_kumulatif_cco'. $cco .', 
                                    lh.total_progres
                                    FROM laporan_mingguan AS lm
                                    LEFT JOIN laporan_harian AS lh ON lh.tanggal = lm.tanggal_selesai
                                    AND lh.id_projek = lm.id_projek
                                    WHERE lm.id_projek = :id_projek
                                    ORDER BY lm.tanggal_mulai ASC');

            // Binding parameter ID proyek
            $this->db->bind('id_projek', $id_projek);

            // Menambahkan hasil query ke dalam array result
            $result[] = $this->db->resultSet();
        }

        // Mengembalikan hasil gabungan dari semua query
        return $result;
    }


    public function getMaxCCO($data)
    {
        $id_projek = $data['id_projek'];
        $max_cco = -1;

        // Cek setiap kolom CCO dari 0 hingga 10
        for ($cco = 0; $cco <= 10; $cco++) {
            // Query untuk memeriksa apakah kolom CCO memiliki data
            $this->db->query('SELECT rencana_progres_cco' . $cco . ' 
                            FROM laporan_mingguan
                            WHERE id_projek = :id_projek
                            AND rencana_progres_cco' . $cco . ' IS NOT NULL
                            LIMIT 1');

            $this->db->bind('id_projek', $id_projek);
            $result = $this->db->single(); // Mengambil satu baris saja

            // Jika ada data, perbarui $max_cco
            if ($result) {
                $max_cco = $cco;
            }
        }

        // Mengembalikan jumlah kolom CCO yang memiliki data
        return $max_cco >= 0 ? $max_cco : 0;
    }


    public function get7LHByLMDate($data)
    {
        $id_projek = $data['id_projek'];
        $tanggal_mulai = $data['tanggal_mulai'];
        $tanggal_selesai = $data['tanggal_selesai'];

        $this->db->query("SELECT lp.id_laporan_harian, lp.tanggal AS tanggal_laporan, lp.progress_harian, pj.tanggal_mulai, pj.tanggal_selesai, lp.total_progres
                    FROM " . $this->tablelh . " AS lp
                    JOIN " . $this->tableprojek . " AS pj ON lp.id_projek = pj.id_projek
                    WHERE lp.id_projek = :id_projek
                    AND tanggal >= :tanggal_mulai
                    AND tanggal <= :tanggal_selesai
                    ORDER BY lp.id_laporan_harian ASC");

        $this->db->bind('tanggal_mulai', $tanggal_mulai);
        $this->db->bind('tanggal_selesai', $tanggal_selesai);
        $this->db->bind('id_projek', $id_projek);
        return $this->db->resultSet();
    }
 }