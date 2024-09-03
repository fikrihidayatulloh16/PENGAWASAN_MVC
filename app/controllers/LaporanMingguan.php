<?php

class LaporanMingguan extends Controller {
    private $judul_laporan;

    // Konstruktor untuk validasi sesi
    public function __construct() {
        // Pastikan sesi sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah pengguna telah login
        if (!isset($_SESSION['role']) == 'operator') {
            Flasher::setFlash('Gagal', 'Anda tidak memiliki izin untuk akses halaman tersebut', 'danger');
            header('Location: ' . PUBLICURL . '/home/login');
            exit();
        }

        
        $this->judul_laporan = 'LAPORAN MINGGUAN'; // Set judul laporan
    }

    //function untuk menyimpan data id laporan harian dan id projek
    private function prepareData($id_laporan_harian, $id_projek) 
    {
        return [
            'id_laporan_harian' => $id_laporan_harian,
            'id_projek' => $id_projek
        ];
    }

        public function laporan_mingguan_list($id_projek) {
        
            //inisiasi data untuk header
            $data['judul_laporan'] = 'LAPORAN MINGGUAN';
            $data['id_projek'] = $id_projek;
            $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
            $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);

            // Memanggil fungsi dateConverter
            $data['tanggal_mulai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_mulai']);
            $data['tanggal_selesai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_selesai']);
            $data['tambahan_waktu_projek'] = !empty($data['projek']['tambahan_waktu']) ? $this->model('Operator_crud_model')->dateConverter($data['projek']['tambahan_waktu']) : '-';

            $data['all_laporan_mingguan'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($id_projek);
            $data['all_tanggal_laporan'] = $this->model('Operator_db_model')->getAllTanggalLaporanByIprojek($id_projek);
            $data['all_minggu'] = $this->model('Laporan_mingguan_crud_model')->getWeeklyRanges($data['projek']);

            $data['m_pekerjaan'] = $this->model('Operator_db_model')->getMPekerjaanByIdProjek($id_projek);
            $data['mp_sp'] = $this->model('Operator_db_model')->getMPSPByIdProjek($id_projek);

            //update progres kumulatif
            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            $this->view('layouts/layout_operator/layout_operator_laporan', $data);
            $this->view('operator/l_harian/rekap/logo_rekap', $data);
            $this->view('operator/laporan_mingguan/laporan_mingguan_list', $data);
            $this->view('layouts/footer_b');
        }

    public function tambah_laporan_mingguan($id_projek) {

        if ($this->model('Laporan_mingguan_crud_model')->tambahLaporanMinguan($_POST) > 0) {

            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            Flasher::setFlash('Sukses', 'Data Laporan Mingguan Berhasil Ditambahkan', 'success');

            //update progres kumulatif
            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        } else {
            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        }
    }

    public function ubah_laporan_mingguan($id_projek) {
        $result = $this->model('Laporan_mingguan_crud_model')->ubahLaporanMingguan($_POST);

        if ($result === TRUE) {
            Flasher::setFlash('Sukses', 'Data Laporan Mingguan Berhasil Diubah', 'success');

            //update progres kumulatif
            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        } else {
            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        }
    }

    public function hapus_laporan_mingguan($id_projek) {

        $result = $this->model('Laporan_mingguan_crud_model')->hapusLaporanMingguan($_POST);

        if ($result === TRUE) {
            Flasher::setFlash('Sukses', 'Data Laporan Mingguan Berhasil Dihapus', 'success');

            //update progres kumulatif
            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        } else {
            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        }
    }

    public function save_linechart($id_projek)
    {
        $_POST['id_projek'] = $id_projek;
        $result = $this->model('Laporan_mingguan_crud_model')->saveLineChart($_POST);

        if ($result === TRUE) {
            Flasher::setFlash('Sukses', 'Linechart Berhasil Dibuat dan simpan', 'success');

            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;

        } else {
            header('Location: ' . PUBLICURL . '/laporanmingguan/laporan_mingguan_list/'. $id_projek);
            exit;
        }
    }
}

?>