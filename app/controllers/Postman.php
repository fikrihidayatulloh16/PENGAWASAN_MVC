<?php
class Postman extends Controller {
    //route untuk postman
    public function get_postman($id_projek)
    {
        $data['max_cco'] = 1;
        $data['id_projek'] = $id_projek;
        $data['getdata'] = $this->model('Laporan_mingguan_db_model')->getAllLMByIdProjek($data);
        echo '<pre>';
    print_r($data['getdata']);
    echo '</pre>';
    }
}


?>