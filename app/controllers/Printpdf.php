<?php

class Printpdf extends Controller {
    //function untuk menyimpan data id laporan harian dan id projek
    private function prepareData($id_laporan_harian, $id_projek) {
        return [
            'id_laporan_harian' => $id_laporan_harian,
            'id_projek' => $id_projek
        ];
    }

    public function print_laporan_harian($id_projek, $id_laporan_harian, $tanggal_laporan)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($tanggal_laporan);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);

        $this->view('printpdf/print_laporan_harian', $data);
    }

    public function print_laporan_mingguan($id_projek)
    {
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN MINGGUAN';
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        

        // Memanggil fungsi dateConverter
        $data['tanggal_mulai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_mulai']);
        $data['tanggal_selesai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_selesai']);
        $data['tambahan_waktu_projek'] = !empty($data['projek']['tambahan_waktu']) ? $this->model('Operator_crud_model')->dateConverter($data['projek']['tambahan_waktu']) : '-';

        $data['max_cco'] = $this->model('Laporan_mingguan_db_model')->getMaxCCO($data);
        $data['all_laporan_mingguan'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($data);
        $data['filter_laporan_mingguan'] = $this->model('Laporan_mingguan_crud_model')->filterLM($data['all_laporan_mingguan']);
        $data['all_tanggal_laporan'] = $this->model('Operator_db_model')->getAllTanggalLaporanByIprojek($id_projek);
        $data['all_minggu'] = $this->model('Laporan_mingguan_crud_model')->getWeeklyRanges($data['projek']);
        $data['all_minggu_data'] = $this->model('Laporan_mingguan_crud_model')->getAllWeekData($data);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByProjekId($id_projek);

        $this->view('printpdf/laporan_mingguan_pdf', $data);
    }

    public function mpdf($id_projek, $id_laporan_harian, $tanggal_laporan)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($tanggal_laporan);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        //$this->model('Rekap_db_model')->prepareChartCuaca($data);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByProjekId($id_projek);
        $data['foto_masalah'] = $this->model('Operator_db_model')->getAllFotoMasalahByIDLaporan($id_laporan_harian);

        //$this->view('printpdf/temp_save_piechart', $data);
        $this->view('printpdf/laporan_harian_pdf', $data);
    }

    public function mpdf_temp($id_projek, $id_laporan_harian, $tanggal_laporan)
{
    $data = $this->prepareData($id_laporan_harian, $id_projek);
    $data['tanggal_laporan'] = $tanggal_laporan;
    $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
    $this->model('Rekap_db_model')->prepareChartCuaca($data);

    // Render view ke dalam output buffer
    $this->view('printpdf/temp_save_piechart', $data);
}


    public function jspdf($id_projek, $id_laporan_harian, $tanggal_laporan)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($tanggal_laporan);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);

        $this->view('printpdf/jspdf', $data, $id_projek, $id_laporan_harian, $tanggal_laporan);
    }
}

?>