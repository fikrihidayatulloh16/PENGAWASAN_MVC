<?php

class Operator extends Controller{
    // Konstruktor untuk validasi sesi
    public function __construct() {
        // Pastikan sesi sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah pengguna telah login
        if (!isset($_SESSION['id_projek'])) {
            Flasher::setFlash('Gagal', 'Anda belum memiliki izin untuk akses halaman tersebut', 'danger');
            // Jika tidak ada sesi login, arahkan ke halaman login
            header('Location: ' . PUBLICURL . '/home/login');
            exit();
        } else {

        }
    }

    //function untuk menyimpan data id laporan harian dan id projek
    private function prepareData($id_laporan_harian, $id_projek) {
        return [
            'id_laporan_harian' => $id_laporan_harian,
            'id_projek' => $id_projek
        ];
    }
    /*
    echo '<pre>';
    print_r($data['bahan']);
    echo '</pre>';
    */

    public function index() {
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data['id_projek'] = 'PRJ001';
        header('Location: ' . PUBLICURL . '/operator/laporan_harian_list/' . $data['id_projek']);
        exit;
        $data['judul'] = '(temp) Pilih projek untuk operator';
        $data['projek'] = $this->model('Operator_db_model')->getAllProjek();
        $this->view('layouts/layout_admin/layout_admin_projek', $data);
        $this->view('operator/index', $data);
        $this->view('layouts/footer_a');
    }

    public function laporan_harian_list($id_projek) {
        
        //Flasher::setFlash('Pilih Laporan', 'Berhasil', 'success');
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);

        // Memanggil fungsi dateConverter
        $data['tanggal_mulai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_mulai']);
        $data['tanggal_selesai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_selesai']);
        $data['tambahan_waktu_projek'] = !empty($data['projek']['tambahan_waktu']) ? $this->model('Operator_crud_model')->dateConverter($data['projek']['tambahan_waktu']) : '-';

        $data['laporan'] = $this->model('Operator_db_model')->getAllLaporanByIdProjek($id_projek);
        $data['all_tanggal_laporan'] = $this->model('Operator_db_model')->getAllTanggalLaporanByIprojek($id_projek);
        $data['m_pekerjaan'] = $this->model('Operator_db_model')->getMPekerjaanByIdProjek($id_projek);
        $data['mp_sp'] = $this->model('Operator_db_model')->getMPSPByIdProjek($id_projek);
        $this->view('layouts/layout_operator/layout_operator_laporan', $data);
        $this->view('operator/l_harian/rekap/logo_rekap', $data);
        $this->view('operator/l_harian/laporan_harian_list', $data);
        $this->view('layouts/footer_b');
    }

    public function rekap($id_laporan_harian, $id_projek) {
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $this->model('Rekap_db_model')->prepareChartCuaca($data['cuaca']);
        //$data['m_pekerjaan'] = $this->model('Operator_db_model')->getMPekerjaanByIdLaporanProjek($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        //$data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);
        $data['pekerjaan_rekap'] = $this->model('Rekap_db_model')->rekapPekerjaan($id_laporan_harian);
        $data['foto_masalah'] = $this->model('Operator_db_model')->getAllFotoMasalahByIDLaporan($id_laporan_harian);
        

        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        $this->view('operator/l_harian/rekap/logo_rekap', $data);
        $this->view('operator/l_harian/rekap/progres_rekap', $data);
        $this->view('operator/l_harian/rekap/cuaca_rekap', $data);
        $this->view('operator/l_harian/rekap/pekerjaan_rekap', $data);
        $this->view('operator/l_harian/rekap/permasalahan_rekap', $data);
        $this->view('operator/l_harian/rekap/foto_masalah_rekap', $data);
        $this->view('operator/l_harian/rekap/foto_kegiatan_rekap', $data);
        
        
        $this->view('layouts/footer_a');
    }

    public function cuaca_l_harian($id_laporan_harian, $id_projek)
    {
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);

        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        $this->view('operator/l_harian/cuaca_l_harian', $data);
        $this->view('layouts/footer_a');
    }

    public function pekerjaan_l_harian($id_laporan_harian, $id_projek)
    {
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['m_pekerjaan'] = $this->model('Operator_db_model')->getMPekerjaanByIdLaporan($id_laporan_harian);
        $data['pekerjaan_harian'] = $this->model('Operator_db_model')->getMSPFromPekerjaanHarianByIdLaporan($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['pekerja'] = $this->model('Operator_db_model')->getPekerjaFromPHByIdLHSP($id_laporan_harian, $data);
        $data['peralatan'] = $this->model('Operator_db_model')->getPeralatanFromPHByIdLHSP($id_laporan_harian, $data);
        $data['bahan'] = $this->model('Operator_db_model')->getBahanFromPHByIdLHSP($id_laporan_harian, $data);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);
        
        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        $this->view('operator/l_harian/pekerjaan_l_harian', $data);
        $this->view('layouts/footer_a');
    }

    public function permasalahan_l_harian($id_laporan_harian, $id_projek)
    {
        //Flasher::setFlash('Pilih Laporan', 'Berhasil', 'success');
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanID($id_laporan_harian);
        
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);

        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        
        $this->view('operator/l_harian/permasalahan_l_harian', $data);
        $this->view('layouts/footer_a');
    }

    public function foto_kegiatan($id_laporan_harian, $id_projek)
    {
        //Flasher::setFlash('Pilih Laporan', 'Berhasil', 'success');
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);

        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        $this->view('operator/l_harian/foto_kegiatan_l_harian', $data);
        $this->view('layouts/footer_b');
    }

    public function tim_pengawas($id_laporan_harian, $id_projek)
    {
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN HARIAN';
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);

        $this->view('layouts/layout_operator/layout_operator_pekerjaan', $data);
        $this->view('operator/l_harian/tim_pengawas_l_harian', $data);
        $this->view('layouts/footer_b');
    }

    public function tambah_laporan_harian($id_projek) 
    {
        $data['id_projek'] = $id_projek;
        $result = $this->model('Operator_crud_model')->tambahLaporanHarian($_POST);

        if ($result === true) {
            Flasher::setFlash('Sukses', 'Tanggal berhasil ditambahkan', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Tanggal yang dipilih sudah ada, pilih tanggal yang berbeda', 'danger');
        }

        
        header('Location: ' . PUBLICURL . '/operator/laporan_harian_list/' . $data['id_projek']);
        exit;

    }

    public function ubah_laporan_harian($id_projek)
    {
        //pending
    }

    public function hapus_laporan_harian($id_projek, $id_laporan_harian)
    {
        $data['id_projek'] = $id_projek;
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['foto_masalah'] = $this->model('Operator_db_model')->getAllFotoMasalahByIDLaporan($id_laporan_harian);

        foreach ($data['foto_kegiatan'] as $foto_kegiatan) {
            $_POST['id_foto_kegiatan'] = $foto_kegiatan['id_foto_kegiatan'];
            $this->model('Operator_crud_model')->hapusFotoKegiatan($_POST);
        }

        foreach ($data['foto_masalah'] as $foto_masalah) {
            $_POST['id'] = $foto_masalah['id'];
            $this->model('Operator_crud_model')->hapusFotoMasalah($_POST);;
        }

        $result = $this->model('Operator_crud_model')->hapusLaporanHarian($_POST);
        if ($result === true) {
            Flasher::setFlash('Sukses', 'Laporan berhasil Dihapus', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Laporan gagal Dihapus', 'danger');
        }
        header('Location: ' . PUBLICURL . '/operator/laporan_harian_list/' . $data['id_projek']);

    }

    public function ubah_progres_lh($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $data['laporan'] = $this->model('Operator_db_model')->getAllLaporanByIdProjek($id_projek);
        $result = $this->model('Operator_crud_model')->ubahProgresLH($_POST, $data['laporan']);

        if ($result === true) {
            Flasher::setFlash('Sukses', 'Progres Laporan Harian berhasil Diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Progres Laporan Harian gagal Diperbarui', 'danger');
        }

        header('Location: ' . PUBLICURL . '/operator/rekap/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        
    }

    public function ubah_cuaca($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);
        $result = $this->model('Operator_crud_model')->ubahCuaca($_POST);
        
        if ($result === true) {
            Flasher::setFlash('Sukses', 'Cuaca berhasil Diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Cuaca gagal Diperbarui', 'danger');
        }
        
        header('Location: ' . PUBLICURL . '/operator/rekap/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function ubah_keterangan_sp($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahKeteranganSPLH($_POST);

        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;

    }

    public function tambah_pekerja_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        if ($this->model('Operator_crud_model')->tambahPekerjaLH($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_pekerja_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahPekerjaLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function hapus_pekerja_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->hapusPekerjaLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function tambah_peralatan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        if ($this->model('Operator_crud_model')->tambahPeralatanLH($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_peralatan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahPeralatanLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function hapus_peralatan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->hapusPeralatanLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function tambah_bahan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        if ($this->model('Operator_crud_model')->tambahBahanLH($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_bahan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahBahanLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function hapus_bahan_harian($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->hapusBahanLH($_POST);
        header('Location: ' . PUBLICURL . '/operator/pekerjaan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function tambah_permasalahan($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        if ($this->model('Operator_crud_model')->tambahPermasalahan($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_permasalahan($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahPermasalahan($_POST);
        header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function hapus_permasalahan($id_laporan_harian, $id_projek, $id_permasalahan)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $data['foto_masalah'] = $this->model('Operator_db_model')->getAllFotoMasalahByIDMasalah($id_permasalahan);

        foreach ($data['foto_masalah'] as $foto_masalah) {
            $_POST['id'] = $foto_masalah['id'];
            $this->model('Operator_crud_model')->hapusFotoMasalah($_POST);
        }

        $this->model('Operator_crud_model')->hapusPermasalahan($_POST);
        header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
    }

    public function tambah_foto_masalah($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->tambahFotoMasalah($_POST);
        header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;
    }

    public function ubah_foto_masalah($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahFotoMasalah($_POST);
        header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;

    }

    public function hapus_foto_masalah($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->hapusFotoMasalah($_POST);
        header('Location: ' . PUBLICURL . '/operator/permasalahan_l_harian/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;

    }

    public function tambah_foto_kegiatan($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->tambahFotoKegiatan($_POST);
        header('Location: ' . PUBLICURL . '/operator/foto_kegiatan/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        /*
        if ($this->model('Operator_crud_model')->tambahFotoKegiatan($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/operator/foto_kegiatan/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
            exit;
        }
            */
    }

    public function ubah_foto_kegiatan($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->ubahFotoKegiatan($_POST);
        header('Location: ' . PUBLICURL . '/operator/foto_kegiatan/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;

    }

    public function hapus_foto_kegiatan($id_laporan_harian, $id_projek)
    {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $this->model('Operator_crud_model')->hapusFotoKegiatan($_POST);
        header('Location: ' . PUBLICURL . '/operator/foto_kegiatan/'. $data['id_laporan_harian'] . '/' . $data['id_projek']);
        exit;
    }
}