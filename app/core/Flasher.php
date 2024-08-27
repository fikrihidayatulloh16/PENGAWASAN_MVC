<?php

class Flasher {
    public static function setFlash($aksi, $pesan, $tipe)
    {
        $_SESSION['flash'] = [
            'message' => $pesan,
            'action' => $aksi,
            'type' => $tipe
        ];
    }

    public static function flash()
    {

        if (isset($_SESSION['flash'])): 
            echo '  <div id="flashMessage" class="alert alert-' . $_SESSION['flash']['type']. ' alert-dismissible fade show fixed-top" role="alert">
                        <strong>' . $_SESSION['flash']['action'] . '!</strong>  ' . $_SESSION['flash']['message'] . 
                '           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            
            <script src="' . PUBLICURL . '/assets/js/flasher.js"></script>';
            unset($_SESSION['flash']); 
        endif; 
    }
}