<?php
 class Admin_db_model {
    private $tableprojek = 'm_projek';
    private $tablelaporan = 'laporan_harian';
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    public function getAllMpekerjaanByIdProjek($id_projek)
    {
        $this->db->query("SELECT id_m_pekerjaan, nama_pekerjaan 
                            FROM m_pekerjaan AS pk, m_projek AS pj 
                            WHERE pk.id_projek = :id_projek
                            AND pj.id_projek = :id_projek
                            ORDER BY id_m_pekerjaan ASC");

        $this->db->bind('id_projek', $id_projek);
        return $this->db->resultSet();
    }

    public function getAllSubpekerjaanByIdMP($id_pekerjaan)
    {
        $this->db->query("SELECT sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                                FROM m_sub_pekerjaan AS sp
                                JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                                JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                                WHERE sp.id_m_pekerjaan = :id_pekerjaan
                                AND pk.id_m_pekerjaan = :id_pekerjaan
                                AND pk.id_projek = pj.id_projek
                                ORDER BY sp.id_m_sub_pekerjaan ASC");

        $this->db->bind('id_pekerjaan', $id_pekerjaan);

        return $this->db->resultSet();
    }

    public function getAllPekerjaanNSubByIdProjek($id_projek)
    {
        $this->db->query("SELECT pk.id_m_pekerjaan, pk.nama_pekerjaan
                        FROM m_pekerjaan AS pk
                        JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                        WHERE pk.id_projek = :id_projek
                        ORDER BY pk.id_m_pekerjaan ASC");
        $this->db->bind(':id_projek', $id_projek);
        $pekerjaanList = $this->db->resultSet(); // Ambil semua pekerjaan

        $pekerjaanData = [];

        foreach ($pekerjaanList as $pekerjaan) {
            // Dapatkan id_m_pekerjaan
            $id_pekerjaan = $pekerjaan['id_m_pekerjaan'];

            // Query untuk mendapatkan sub pekerjaan terkait
            $this->db->query("SELECT sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                            FROM m_sub_pekerjaan AS sp
                            WHERE sp.id_m_pekerjaan = :id_pekerjaan
                            ORDER BY sp.id_m_sub_pekerjaan ASC");
            $this->db->bind(':id_pekerjaan', $id_pekerjaan);
            $subPekerjaanList = $this->db->resultSet(); // Ambil semua sub pekerjaan

            // Format sub pekerjaan menjadi array sesuai kebutuhan
            $subPekerjaanArray = [];
            foreach ($subPekerjaanList as $subPekerjaan) {
                $subPekerjaanArray[] = [
                    'id' => $subPekerjaan['id_m_sub_pekerjaan'],
                    'name' => $subPekerjaan['nama_sub_pekerjaan']
                ];
            }

            // Tambahkan data pekerjaan beserta sub pekerjaan ke array akhir
            $pekerjaanData[] = [
                'id_m_pekerjaan' => $pekerjaan['id_m_pekerjaan'],
                'nama_pekerjaan' => $pekerjaan['nama_pekerjaan'],
                'sub_pekerjaan' => $subPekerjaanArray
            ];
        }

        // Output akhir
        return $pekerjaanData;
    }

    public function getAllMPekerjaByIdProjek($id_projek)
    {
        $this->db->query("SELECT id_m_pekerja, jenis_pekerja FROM m_pekerja AS mp, m_projek AS pj WHERE mp.id_projek = :id_projek AND pj.id_projek = :id_projek ORDER BY id_m_pekerja ASC");

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getAllMPeralatanByIdProjek($id_projek)
    {
        $this->db->query("SELECT id_m_peralatan, nama_alat, satuan FROM m_peralatan AS pl, m_projek AS pj WHERE pl.id_projek = :id_projek AND pj.id_projek = :id_projek ORDER BY id_m_peralatan ASC");

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    }

    public function getAllMBahanByIdProjek($id_projek)
    {
        $this->db->query("SELECT id_m_bahan, nama_bahan, satuan FROM m_bahan AS mb, m_projek AS mp WHERE mb.id_projek = :id_projek AND mp.id_projek = :id_projek ORDER BY id_m_bahan ASC");

        $this->db->bind('id_projek', $id_projek);

        return $this->db->resultSet();
    } 
 }

?>