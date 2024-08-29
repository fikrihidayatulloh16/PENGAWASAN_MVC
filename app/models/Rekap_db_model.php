<?php 

class Rekap_db_model{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLogoById($data)
    {
        $this->db->query("SELECT *
                               FROM m_projek
                               WHERE id_projek = :id_projek");

        $this->db->bind('id_projek', $data);

        return $this->db->single();
    }

    public function getCuacaByLaporanId($id_laporan_harian) {
        $this->db->query("SELECT c.id_cuaca, c.jam_mulai, c.jam_selesai, c.kondisi 
                          FROM cuaca AS c 
                          JOIN laporan_harian AS lh ON c.id_laporan_harian = lh.id_laporan_harian
                          WHERE c.id_laporan_harian = :id_laporan_harian
                          ORDER BY c.id_cuaca ASC");
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);
    
        $result = $this->db->resultSet();
    
        // Memproses data jam_mulai dan jam_selesai
        foreach ($result as &$row) {
            $row['jam_mulai'] = date('H:i', strtotime($row['jam_mulai']));
            $row['jam_selesai'] = date('H:i', strtotime($row['jam_selesai']));
        }
    
        return $result;
    }
    
    public function getSubPekerjaanByLaporanId($id_laporan_harian){
        // Mengambil data sub pekerjaan
        $this->db->query("SELECT msp.id_m_sub_pekerjaan, msp.nama_sub_pekerjaan, ph.keterangan
                                                    FROM m_sub_pekerjaan AS msp
                                                    JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = msp.id_m_sub_pekerjaan
                                                    WHERE ph.id_laporan_harian = :id_laporan_harian");

        $this->db->bind(':id_laporan_harian', $id_laporan_harian);

        return $this->db->resultSet();
    }

    public function getPekerjaByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan) {
        $this->db->query("SELECT mpj.jenis_pekerja, pj.jumlah_pekerja
                        FROM pekerja AS pj
                        JOIN m_pekerja AS mpj ON pj.id_m_pekerja = mpj.id_m_pekerja
                        WHERE pj.id_laporan_harian = :id_laporan_harian AND pj.id_m_sub_pekerjaan = :id_m_sub_pekerjaan");
        
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);
        $this->db->bind(':id_m_sub_pekerjaan', $id_m_sub_pekerjaan);

        return $this->db->resultSet();
    }

    public function getPeralatanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan) {
        $this->db->query("SELECT mpl.nama_alat, pl.jumlah_peralatan, mpl.satuan
                        FROM peralatan AS pl
                        JOIN m_peralatan AS mpl ON pl.id_m_peralatan = mpl.id_m_peralatan
                        WHERE pl.id_laporan_harian = :id_laporan_harian AND pl.id_m_sub_pekerjaan = :id_m_sub_pekerjaan");
        
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);
        $this->db->bind(':id_m_sub_pekerjaan', $id_m_sub_pekerjaan);

        return $this->db->resultSet();
    }

    public function getBahanByIdLaporanMSub($id_laporan_harian, $id_m_sub_pekerjaan) {
        $this->db->query("SELECT mbh.nama_bahan, bh.jumlah_bahan, mbh.satuan
                        FROM bahan AS bh
                        JOIN m_bahan AS mbh ON bh.id_m_bahan = mbh.id_m_bahan
                        WHERE bh.id_laporan_harian = :id_laporan_harian
                        AND bh.id_m_sub_pekerjaan = :id_m_sub_pekerjaan");
        
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);
        $this->db->bind(':id_m_sub_pekerjaan', $id_m_sub_pekerjaan);

        return $this->db->resultSet();
    }

    public function rekapPekerjaan()
    {
        
    }

    public function getPermasalahanByLaporanId($id_laporan_harian) 
    {
        $this->db->query("SELECT ps.id_permasalahan, ps.id_laporan_harian, ps.permasalahan, ps.saran
                                               FROM permasalahan AS ps
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = ps.id_laporan_harian
                                               WHERE ps.id_laporan_harian = :id_laporan_harian
                                               AND lh.id_laporan_harian = :id_laporan_harian
                                               ORDER BY ps.id_laporan_harian ASC");
        
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);

        return $this->db->resultSet();
    }

    public function getFotoKegiatanByLaporanId($id_laporan_harian)
    {
        $this->db->query("SELECT fk.id_foto_kegiatan, fk.id_laporan_harian, fk.foto, fk.keterangan
                                               FROM foto_kegiatan AS fk
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = fk.id_laporan_harian
                                               WHERE fk.id_laporan_harian = :id_laporan_harian
                                               AND lh.id_laporan_harian = :id_laporan_harian
                                               ORDER BY fk.id_laporan_harian ASC");
        
        $this->db->bind(':id_laporan_harian', $id_laporan_harian);

        return $this->db->resultSet();
    }

    public function getTimPengawasByProjekId($id_projek)
    {
        $this->db->query("SELECT tp.id_tim_pengawas, tp.tim_pengawas , tp.tim_leader
                                               FROM tim_pengawas AS tp
                                               JOIN m_projek AS mp ON mp.id_projek = tp.id_projek
                                               WHERE tp.id_projek = :id_projek
                                               ORDER BY tp.id_projek ASC");
        
        $this->db->bind(':id_projek', $id_projek);

        return $this->db->resultSet();
    }
}