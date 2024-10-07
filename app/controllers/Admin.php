<?php

class Admin extends Controller {
    // Konstruktor untuk validasi sesi
    public function __construct() {
        // Pastikan sesi sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah pengguna telah login
        if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'admin')) {
            Flasher::setFlash('Gagal', 'Anda tidak memiliki izin untuk akses halaman tersebut', 'danger');
            header('Location: ' . PUBLICURL . '/home/login');
            exit();
        }
    }
    //function untuk menyimpan data id laporan harian dan id projek
    private function prepareData($id_laporan_harian, $id_projek) 
    {
        return [
            'id_laporan_harian' => $id_laporan_harian,
            'id_projek' => $id_projek
        ];
    }

    public function index()
    {
        $role = $_SESSION['role'];
        $data['id_projek'] = $_SESSION['id_projek'];
        if ($role != 'superadmin'){
            header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
            exit;
        }

        $data['projek'] = $this->model('Operator_db_model')->getAllProjek();

        $this->view('layouts/layout_admin/layout_admin_projek', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_pekerjaan($id_projek) {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['m_pekerjaan'] = $this->model('Admin_db_model')->getAllMpekerjaanByIdProjek($id_projek);
        $data['m_pekerjaan2'] = $this->model('Admin_db_model')->getAllPekerjaanNSubByIdProjek($id_projek);
        

        $this->view('layouts/layout_admin/header_admin', $data);
        
        $this->view('admin/m_pekerjaan', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_pekerja($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['m_pekerja'] = $this->model('Admin_db_model')->getAllMPekerjaByIdProjek($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_pekerja', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_peralatan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['m_peralatan'] = $this->model('Admin_db_model')->getAllMPeralatanByIdProjek($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_peralatan', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_bahan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['m_bahan'] = $this->model('Admin_db_model')->getAllMBahanByIdProjek($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_bahan', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_laporan_mingguan($id_projek) {
        
        //inisiasi data untuk header
        $data['judul_laporan'] = 'LAPORAN MINGGUAN';
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['logo'] = $this->model('Rekap_db_model')->getLogoById($id_projek);

        // Memanggil fungsi dateConverter
        $data['tanggal_mulai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_mulai']);
        $data['tanggal_selesai_projek'] = $this->model('Operator_crud_model')->dateConverter($data['projek']['tanggal_selesai']);
        $data['tambahan_waktu_projek'] = !empty($data['projek']['tambahan_waktu']) ? $this->model('Operator_crud_model')->dateConverter($data['projek']['tambahan_waktu']) : '-';

        $data['all_laporan_harian'] = $this->model('Operator_db_model')->getAllLaporanByIdProjek($id_projek);
        $data['max_cco'] = $this->model('Laporan_mingguan_db_model')->getMaxCCO($data);
        $data['all_laporan_mingguan'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($data);
        $data['all_tanggal_laporan'] = $this->model('Operator_db_model')->getAllTanggalLaporanByIprojek($id_projek);
        $data['all_minggu'] = $this->model('Laporan_mingguan_crud_model')->getWeeklyRanges($data['projek']);

        $data['m_pekerjaan'] = $this->model('Operator_db_model')->getMPekerjaanByIdProjek($id_projek);
        $data['mp_sp'] = $this->model('Operator_db_model')->getMPSPByIdProjek($id_projek);

        //update progres kumulatif
        $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($data);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_laporan_mingguan', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function m_cco($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['max_cco'] = $this->model('Laporan_mingguan_db_model')->getMaxCCO($data);
        $data['all_laporan_mingguan'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($data);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_cco', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function tim_pengawas($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['list_tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByProjekId($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/tim_pengawas_admin', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    public function user_admin($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['user'] = $this->model('Admin_db_model')->getAllUserByIdProjek($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/user_admin', $data);
        $this->view('layouts/layout_admin/footer_admin');
    }

    //crud controller
    public function tambah_projek()
    {
        if ($this->model('Admin_crud_model')->tambahProjek($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/index');
            exit;
        }
    }

    public function ubah_projek()
    {
        $this->model('Admin_crud_model')->ubahProjek($_POST);
        header('Location: ' . PUBLICURL . '/admin/index');
        exit;
    }

    public function hapus_projek()
    {
        $this->model('Admin_crud_model')->hapusProjek($_POST);
        header('Location: ' . PUBLICURL . '/admin/index');
        exit;
    }

    public function tambah_m_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahMPekerjaan($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_m_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahMPekerjaan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
        exit;

    }

    public function hapus_m_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusMPekerjaan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
        exit;

    }

    public function tambah_sub_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahSubPekerjaan($_POST) > 0) {
            // Simpan ID accordion yang akan dibuka ke dalam session
            /* cadangan untuk accordion tetap terbuka dengan menggunakan session
            $_SESSION['openAccordion'] = $_POST['id_m_pekerjaan'];
            */
            // Redirect ke halaman pekerjaan
            header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_sub_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahSubPekerjaan($_POST);
        // Redirect ke halaman pekerjaan
        header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
        exit;
    }
    
    public function hapus_sub_pekerjaan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusSubPekerjaan($_POST);
        // Redirect ke halaman pekerjaan
        header('Location: ' . PUBLICURL . '/admin/m_pekerjaan/' . $data['id_projek']);
        exit;
    }

    public function tambah_m_pekerja($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahMPekerja($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/m_pekerja/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_m_pekerja($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahMPekerja($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_pekerja/' . $data['id_projek']);
        exit;

    }

    public function hapus_m_pekerja($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusMPekerja($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_pekerja/' . $data['id_projek']);
        exit;
    }

    public function tambah_m_peralatan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahMperalatan($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/m_peralatan/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_m_peralatan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahMperalatan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_peralatan/' . $data['id_projek']);
        exit;

    }

    public function hapus_m_peralatan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusMperalatan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_peralatan/' . $data['id_projek']);
        exit;

    }
    
    public function tambah_m_bahan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahMBahan($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/m_bahan/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_m_bahan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahMBahan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_bahan/' . $data['id_projek']);
        exit;

    }

    public function hapus_m_bahan($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusMBahan($_POST);
        header('Location: ' . PUBLICURL . '/admin/m_bahan/' . $data['id_projek']);
        exit;

    }

    public function ubah_laporan_mingguan($id_projek) {
        $data['id_projek'] = $id_projek;
        $data['max_cco'] = $_POST['cco'];
        $result = $this->model('Laporan_mingguan_crud_model')->ubahLaporanMingguan($_POST);

        if ($result === TRUE) {
            Flasher::setFlash('Sukses', 'Data Laporan Mingguan Berhasil Diubah', 'success');

            //update progres kumulatif
            $this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($data);

            header('Location: ' . PUBLICURL . '/admin/m_laporan_mingguan/'. $id_projek);
            exit;
        } else {
            header('Location: ' . PUBLICURL . '/admin/m_laporan_mingguan/'. $id_projek);
            exit;
        }
    }

    public function hapus_cco($id_projek, $cco)
    {
        $data['max_cco'] = $cco;
        $data['id_projek'] = $id_projek;
        $data['all_laporan_mingguan'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($data);
        $result = $this->model('Laporan_mingguan_crud_model')->hapusCCO($data);

        if ($result === TRUE) {
            Flasher::setFlash('Sukses', 'Data COO Terbaru Berhasil Dibuat', 'success');

            //update progres kumulatif
            //$this->model('Laporan_mingguan_crud_model')->ubahProgresKumulatifLM($id_projek);

            header('Location: ' . PUBLICURL . '/admin/m_cco/'. $id_projek);
            exit;
        } else {
            header('Location: ' . PUBLICURL . '/admin/m_cco/'. $id_projek);
            exit;
        }
    }

    public function tambah_user_admin($id_projek)
    {
        $data['id_projek'] = $id_projek;
        if ($this->model('Admin_crud_model')->tambahUserAdmin($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/user_admin/' . $data['id_projek']);
            exit;
        }
    }

    public function ubah_user_admin($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->ubahUserAdmin($_POST);
        header('Location: ' . PUBLICURL . '/admin/user_admin/' . $data['id_projek']);
        exit;

    }

    public function hapus_user_admin($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $this->model('Admin_crud_model')->hapusUserAdmin($_POST);
        header('Location: ' . PUBLICURL . '/admin/user_admin/' . $data['id_projek']);
        exit;

    }

    public function tambah_tim_pengawas($id_projek)
    {
        if ($this->model('Operator_crud_model')->tambahTimPengawas($_POST) > 0) {
            header('Location: ' . PUBLICURL . '/admin/tim_pengawas/'. $id_projek);
            exit;
        }
    }

    public function ubah_tim_pengawas($id_projek)
    {
        $this->model('Operator_crud_model')->ubahTimPengawas($_POST);
        header('Location: ' . PUBLICURL . '/admin/tim_pengawas/'. $id_projek);
        exit;
    }

    public function hapus_tim_pengawas($id_projek)
    {
        $this->model('Operator_crud_model')->hapusTimPengawas($_POST);
        header('Location: ' . PUBLICURL . '/admin/tim_pengawas/'. $id_projek);
        exit;

    }
}

/* Cadangan Kode
cadangan untuk accordion tetap terbuka dengan menggunakan session
        // Hapus session setelah digunakan
        if (isset($_SESSION['openAccordion'])) {
            unset($_SESSION['openAccordion']);
        }
*/


?>