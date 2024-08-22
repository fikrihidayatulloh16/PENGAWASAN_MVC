<?php

class Home extends Controller {
    //function untuk menyimpan data id laporan harian dan id projek
    private function prepareData($id_laporan_harian, $id_projek) {
        return [
            'id_laporan_harian' => $id_laporan_harian,
            'id_projek' => $id_projek
        ];
    }

    public function index()
    {
        $id_projek = 'PRJ001';
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
        $this->view('layouts/layout_user/layout_user_laporan', $data);
        $this->view('operator/l_harian/rekap/logo_rekap', $data);
        $this->view('home/index', $data);
        $this->view('layouts/footer_a');
    }

    public function rekap_user($id_laporan_harian, $id_projek) {
        $data = $this->prepareData($id_laporan_harian, $id_projek);

        $data['laporan'] = $this->model('Operator_db_model')->getLaporanById($id_laporan_harian);
        $data['tanggal'] = $this->model('Operator_crud_model')->dateConverter($data['laporan']['tanggal']);
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);
        $data['cuaca'] = $this->model('Rekap_db_model')->getCuacaByLaporanId($id_laporan_harian);
        $data['sub_pekerjaan'] = $this->model('Rekap_db_model')->getSubPekerjaanByLaporanId($id_laporan_harian);
        $data['permasalahan'] = $this->model('Rekap_db_model')->getPermasalahanByLaporanId($id_laporan_harian);
        $data['foto_kegiatan'] = $this->model('Rekap_db_model')->getFotoKegiatanByLaporanId($id_laporan_harian);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByLaporanId($id_projek);
        $data['hari_ke'] = $this->model('Operator_db_model')->getHariKeByLaporanId($id_laporan_harian, $id_projek);
        $data['pekerjaan_rekap'] = $this->model('Rekap_db_model')->rekapPekerjaan($id_laporan_harian);
        

        $this->view('layouts/layout_user/layout_user_pekerjaan', $data);
        $this->view('home/user_lh_rekap/logo_rekap', $data);
        $this->view('home/user_lh_rekap/cuaca_rekap', $data);
        $this->view('home/user_lh_rekap/pekerjaan_rekap', $data);
        $this->view('home/user_lh_rekap/permasalahan_rekap', $data);
        $this->view('home/user_lh_rekap/foto_kegiatan_rekap', $data);
        
        $this->view('layouts/footer_a');
    }

    public function login() 
    {
        $this->view('home/login');
    }

    public function user_auth()
    {
        $userModel = $this->model('User_model');

        // Cek jika autentikasi berhasil
        if ($userModel->userAuth()) {
            // Ambil id_projek dari session
            $id_projek = $_SESSION['id_projek_op'];

            // Redirect ke halaman tertentu setelah login berhasil
            header('Location: ' . PUBLICURL . '/operator/laporan_harian_list/' . $id_projek); // Ganti '/dashboard' dengan URL tujuan setelah login berhasil
            exit;
        } else {
            // Jika autentikasi gagal, arahkan kembali ke halaman login dengan pesan kesalahan
            header('Location: ' . PUBLICURL); // Menambahkan parameter query untuk pesan kesalahan
            exit;
        }
    }

    public function log_out()
    {
        // Hapus semua sesi
        session_unset();

        // Hancurkan sesi
        session_destroy();
        // Cek jika autentikasi berhasil

        header('Location: ' . PUBLICURL ); // Ganti '/dashboard' dengan URL tujuan setelah login berhasil

    }
} 