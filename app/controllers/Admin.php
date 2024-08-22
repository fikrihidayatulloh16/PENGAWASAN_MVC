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
        $data['m_pekerjaan'] = $this->model('Admin_db_model')->getAllMpekerjaanByIdProjek($id_projek);

        $this->view('layouts/layout_admin/header_admin', $data);
        $this->view('admin/m_pekerjaan', $data);
        $this->view('layouts/layout_admin/footer_admin');
    
    }

}

?>