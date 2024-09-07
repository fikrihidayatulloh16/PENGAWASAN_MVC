<?php
 class Laporan_mingguan_db_model {
    private $tableprojek = 'm_projek';
    private $tablelaporan = 'laporan_harian';
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
        $id_projek = $data['id_projek'];

        $this->db->query("SELECT lm.id_laporan_mingguan, lm.id_projek, lm.tanggal_mulai, lm.tanggal_selesai, lh.tanggal, lm.rencana_progres, lm.rencana_progres_kumulatif, lm.realisasi_progres, lh.total_progres, lm.realisasi_progres_kumulatif
                            FROM laporan_mingguan AS lm
                            LEFT JOIN laporan_harian AS lh ON lh.tanggal = lm.tanggal_selesai
                            AND lh.id_projek = lm.id_projek
                            WHERE lm.id_projek = :id_projek
                            ORDER BY id_laporan_mingguan ASC");

        $this->db->bind('id_projek', $id_projek);
        return $this->db->resultSet();
    }

    
 }