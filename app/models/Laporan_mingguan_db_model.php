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
        $id_projek = $data['id_projek'];

        $this->db->query("SELECT lm.id_laporan_mingguan, lm.id_projek, lm.tanggal_mulai, lm.tanggal_selesai, lh.tanggal, lm.rencana_progres, lm.rencana_progres_kumulatif, lm.realisasi_progres, lh.total_progres, lm.realisasi_progres_kumulatif
                            FROM laporan_mingguan AS lm
                            LEFT JOIN laporan_harian AS lh ON lh.tanggal = lm.tanggal_selesai
                            AND lh.id_projek = lm.id_projek
                            WHERE lm.id_projek = :id_projek
                            ORDER BY tanggal_selesai ASC");

        $this->db->bind('id_projek', $id_projek);
        return $this->db->resultSet();
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