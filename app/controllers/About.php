<?php

class About extends Controller{
    public function index($nama = 'ini variabel default', $pekerja = 'ini variabel default')
    {
        $data['nama'] = $nama;
        $data['pekerja'] = $pekerja;

        $this->view('about/index', $data);

    }

    public function page(){
        $this->view('about/page');
    }
}