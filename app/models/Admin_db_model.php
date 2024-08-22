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
 }

?>