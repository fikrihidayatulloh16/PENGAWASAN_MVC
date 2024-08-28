<?php

class Admin extends Controller {
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
        $data['projek'] = $this->model('Operator_db_model')->getAllProjek();

        $this->view('layouts/layout_admin/header_admin', $data);
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
    
        /* cadangan untuk accordion tetap terbuka dengan menggunakan session
        // Hapus session setelah digunakan
        if (isset($_SESSION['openAccordion'])) {
            unset($_SESSION['openAccordion']);
        }
        */
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

    public function tim_pengawas($id_projek)
    {
        $data['id_projek'] = $id_projek;
        $data['projek'] = $this->model('Operator_db_model')->getProjekById($id_projek);
        $data['tim_pengawas'] = $this->model('Rekap_db_model')->getTimPengawasByProjekId($id_projek);

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
}


?>