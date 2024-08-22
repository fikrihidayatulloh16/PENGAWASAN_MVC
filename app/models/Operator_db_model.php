<?php

class Operator_db_model {
    private $tableprojek = 'm_projek';
    private $tablelaporan = 'laporan_harian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    public function getAllProjek()
    {
        $this->db->query('SELECT * FROM ' . $this->tableprojek .  ' ORDER BY id_projek ASC');

        return $this->db->resultSet();
    }

    public function getAllLaporanByIdProjek($id_projek)
    {
        $this->db->query('SELECT lp.id_laporan_harian , lp.tanggal AS tanggal_laporan, lp.progress_harian, pj.tanggal_mulai, pj.tanggal_selesai
                                                                    FROM ' . $this->tablelaporan . ' AS lp
                                                                    JOIN ' . $this->tableprojek . '  AS pj ON lp.id_projek = pj.id_projek
                                                                    WHERE lp.id_projek=:id_projek
                                                                    ORDER BY lp.id_laporan_harian  ASC');

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getAllTanggalLaporanByIprojek($id_projek)
    {
        $this->db->query('SELECT lp.tanggal
                        FROM ' . $this->tablelaporan . ' AS lp
                        JOIN ' . $this->tableprojek . '  AS pj ON lp.id_projek = pj.id_projek
                        WHERE lp.id_projek=:id_projek');

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getProjekById($id_projek)
    {
        $this->db->query('SELECT * FROM ' . $this->tableprojek . ' WHERE id_projek=:id_projek');

        $this->db->bind('id_projek', $id_projek);

        return $this->db->single();
    }

    public function getLaporanById($id_laporan_harian)
    {
        $this->db->query('SELECT * FROM ' . $this->tablelaporan . ' WHERE id_laporan_harian = :id_laporan_harian');

        $this->db->bind('id_laporan_harian', $id_laporan_harian);

        return $this->db->single();
    }

    public function getMPekerjaanByIdProjek($id_projek)
    {
        $this->db->query('SELECT id_m_pekerjaan, nama_pekerjaan 
                            FROM m_pekerjaan AS pk, m_projek AS pj 
                            WHERE pk.id_projek = :id_projek AND pj.id_projek = :id_projek 
                            ORDER BY id_m_pekerjaan ASC');

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getMPekerjaanByIdLaporan($id_laporan_harian)
    {
        $this->db->query("SELECT ms.id_m_sub_pekerjaan, mp.nama_pekerjaan
                                            FROM m_pekerjaan AS mp
                                            JOIN m_sub_pekerjaan AS ms ON ms.id_m_pekerjaan  = mp.id_m_pekerjaan 
                                            JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                            WHERE ph.id_laporan_harian = :id_laporan_harian");

        $this->db->bind('id_laporan_harian', $id_laporan_harian);

        return $this->db->resultSet();
    }

    public function getMSPFromPekerjaanHarianByIdLaporan($id_laporan_harian)
    {
        $this->db->query("SELECT ph.id_laporan_harian, ph.id_m_sub_pekerjaan, ms.nama_sub_pekerjaan
                                          FROM pekerjaan_harian AS ph
                                          JOIN m_sub_pekerjaan AS ms ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                          JOIN laporan_harian AS lh ON lh.id_laporan_harian = ph.id_laporan_harian
                                          WHERE ph.id_laporan_harian = :id_laporan_harian ");

        $this->db->bind('id_laporan_harian', $id_laporan_harian);

        $data = $this->db->resultSet();

        return $data;
    }

    public function getMPSPByIdProjek($id_projek)
    {
        $this->db->query('SELECT pk.id_m_pekerjaan, pk.nama_pekerjaan, sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                            FROM m_sub_pekerjaan AS sp
                            JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                            JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                            WHERE pk.id_projek = :id_projek
                            AND pj.id_projek = :id_projek
                            ORDER BY pk.id_m_pekerjaan ASC');

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getPekerjaFromPHByIdLHSP($id_laporan_harian, $data)
    {
        $id_sub = [];
        $result = []; // Array untuk menyimpan hasil query

        // Mengisi $id_sub dengan data pekerjaan_harian
        foreach ($data['pekerjaan_harian'] as $data_pekerjaan_harian) {
            $id_sub[] = $data_pekerjaan_harian;
        }

        // Mengiterasi setiap sub pekerjaan
        foreach ($id_sub as $sub) {
            $id_sub_pekerjaan = $sub['id_m_sub_pekerjaan'];

            // Query untuk mendapatkan data pekerja berdasarkan id_laporan_harian dan id_sub_pekerjaan
            $this->db->query("SELECT pj.id_pekerja, mpj.id_m_pekerja, mpj.jenis_pekerja, pj.jumlah_pekerja, ph.id_m_sub_pekerjaan
                            FROM pekerja AS pj
                            JOIN pekerjaan_harian AS ph ON pj.id_laporan_harian = ph.id_laporan_harian AND pj.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                            JOIN m_pekerja AS mpj ON pj.id_m_pekerja = mpj.id_m_pekerja
                            WHERE pj.id_laporan_harian = :id_laporan_harian
                            AND pj.id_m_sub_pekerjaan = :id_sub_pekerjaan");

            $this->db->bind('id_laporan_harian', $id_laporan_harian);
            $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
            
            // Menyimpan hasil query dalam array yang diindeks oleh id_m_sub_pekerjaan
            $result[$id_sub_pekerjaan] = $this->db->resultSet();
        }

        return $result; // Mengembalikan hasil query
    }

    public function getPekerjaByIdLHSP($id_laporan_harian, $id_sub_pekerjaan)
    {
        $this->db->query("SELECT id_m_pekerja FROM pekerja WHERE id_laporan_harian = :id_laporan_harian AND id_m_sub_pekerjaan = :id_sub_pekerjaan");
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        return $this->db->resultSet();
    }

    public function getpekerjaByIdProjek($id_projek)
    {
        $this->db->query("SELECT *
                            FROM m_pekerja AS mp
                            WHERE mp.id_projek = :id_projek
                            ORDER BY mp.id_m_pekerja ASC");
        
        $this->db->bind('id_projek', $id_projek);
        return $this->db->resultSet();
    }

    public function getPeralatanFromPHByIdLHSP ($id_laporan_harian, $data) 
    {
        $id_sub = [];
        $result = []; // Array untuk menyimpan hasil query

        // Mengisi $id_sub dengan data pekerjaan_harian
        foreach ($data['pekerjaan_harian'] as $data_pekerjaan_harian) {
            $id_sub[] = $data_pekerjaan_harian;
        }

        // Mengiterasi setiap sub pekerjaan
        foreach ($id_sub as $sub) {
            $id_sub_pekerjaan = $sub['id_m_sub_pekerjaan'];

            // Query untuk mendapatkan data pekerja berdasarkan id_laporan_harian dan id_sub_pekerjaan
            $this->db->query("SELECT pl.id_peralatan,mp.id_m_peralatan, mp.nama_alat, pl.jumlah_peralatan, mp.satuan
                                FROM peralatan AS pl
                                JOIN m_peralatan AS mp ON pl.id_m_peralatan = mp.id_m_peralatan
                                JOIN pekerjaan_harian AS ph ON pl.id_laporan_harian = ph.id_laporan_harian 
                                AND pl.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                WHERE pl.id_laporan_harian = :id_laporan_harian
                                AND pl.id_m_sub_pekerjaan = :id_sub_pekerjaan");

            $this->db->bind('id_laporan_harian', $id_laporan_harian);
            $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
            
            // Menyimpan hasil query dalam array yang diindeks oleh id_m_sub_pekerjaan
            $result[$id_sub_pekerjaan] = $this->db->resultSet();
        }

        return $result; // Mengembalikan hasil query
    }

    public function getPeralatanByIdLHSP($id_laporan_harian, $id_sub_pekerjaan)
    {
        $this->db->query("SELECT id_m_peralatan FROM peralatan WHERE id_laporan_harian = :id_laporan_harian AND id_m_sub_pekerjaan = :id_sub_pekerjaan");
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        return $this->db->resultSet();
    }

    public function getPeralatanByIdProjekLH($id_projek, $id_laporan_harian)
    {
        $this->db->query("SELECT mp.id_m_peralatan, mp.nama_alat, mp.satuan 
                            FROM laporan_harian AS lh
                            JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                            JOIN m_peralatan AS mp ON mp.id_projek = pj.id_projek
                            WHERE lh.id_projek = :id_projek
                            AND lh.id_laporan_harian = :id_laporan_harian
                            ORDER BY id_m_peralatan ASC");

        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        return $this->db->resultSet();
    }
    
    public function getBahanFromPHByIdLHSP($id_laporan_harian, $data)
    {
        $id_sub = [];
        $result = []; // Array untuk menyimpan hasil query

        // Mengisi $id_sub dengan data pekerjaan_harian
        foreach ($data['pekerjaan_harian'] as $data_pekerjaan_harian) {
            $id_sub[] = $data_pekerjaan_harian;
        }

        // Mengiterasi setiap sub pekerjaan
        foreach ($id_sub as $sub) {
            $id_sub_pekerjaan = $sub['id_m_sub_pekerjaan'];

            // Query untuk mendapatkan data pekerja berdasarkan id_laporan_harian dan id_sub_pekerjaan
            $this->db->query("SELECT bh.id_bahan, mb.id_m_bahan, mb.nama_bahan, bh.jumlah_bahan, mb.satuan
                                FROM bahan AS bh
                                JOIN m_bahan AS mb ON bh.id_m_bahan = mb.id_m_bahan
                                JOIN pekerjaan_harian AS ph ON bh.id_laporan_harian = ph.id_laporan_harian AND bh.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                WHERE bh.id_laporan_harian = :id_laporan_harian
                                AND ph.id_m_sub_pekerjaan = :id_sub_pekerjaan");

            $this->db->bind('id_laporan_harian', $id_laporan_harian);
            $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
            
            // Menyimpan hasil query dalam array yang diindeks oleh id_m_sub_pekerjaan
            $result[$id_sub_pekerjaan] = $this->db->resultSet();
        }

        return $result; // Mengembalikan hasil query
    }

    public function getBahanByIdLHSP($id_laporan_harian, $id_sub_pekerjaan)
    {
        $this->db->query("SELECT id_m_bahan FROM bahan WHERE id_laporan_harian = :id_laporan_harian AND id_m_sub_pekerjaan = :id_sub_pekerjaan");
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        $this->db->bind('id_sub_pekerjaan', $id_sub_pekerjaan);
        return $this->db->resultSet();
    }

    public function getBahanByIdProjekLH($id_projek, $id_laporan_harian)
    {
        $this->db->query("SELECT lh.id_laporan_harian, lh.id_projek, mb.id_m_bahan, mb.nama_bahan, mb.satuan 
                            FROM laporan_harian AS lh
                            JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                            JOIN m_bahan AS mb ON mb.id_projek = pj.id_projek
                            WHERE lh.id_projek = :id_projek
                            AND lh.id_laporan_harian = :id_laporan_harian
                            ORDER BY id_m_bahan ASC");

        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('id_laporan_harian', $id_laporan_harian);
        return $this->db->resultSet();
    }

    public function getPermasalahanByLaporanID($id_laporan_harian)
    {
        $this->db->query("SELECT ps.id_permasalahan, ps.id_laporan_harian, ps.permasalahan, ps.saran
                                        FROM permasalahan AS ps
                                        JOIN laporan_harian AS lh ON lh.id_laporan_harian = ps.id_laporan_harian
                                        WHERE ps.id_laporan_harian = :id_laporan_harian
                                        AND lh.id_laporan_harian = :id_laporan_harian
                                        ORDER BY ps.id_laporan_harian ASC");

        $this->db->bind('id_laporan_harian', $id_laporan_harian);

        return $this->db->resultSet();
    }

    public function getHariKeByLaporanId($id_laporan_harian, $id_projek)
    {
        $projek = $this->getProjekById($id_projek);
        $laporan = $this->getLaporanById($id_laporan_harian);

        // Menghitung selisih hari
        $datetime1 = new DateTime($projek['tanggal_mulai']);
        $datetime2 = new DateTime($laporan['tanggal']); 
        $interval = $datetime1->diff($datetime2);
        $hari_ke = $interval->days + 1; // Ditambah 1 karena hari pertama adalah hari ke-1

        return $hari_ke;
    }
}