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

    public function mpdf($id_projek, $id_laporan_harian, $tanggal_laporan)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($tanggal_laporan);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);

        $this->view('printpdf/mpdf2', $data);
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

        $this->view('printpdf/jspdf', $data);
    }
}

?>