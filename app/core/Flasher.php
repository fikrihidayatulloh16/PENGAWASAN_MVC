<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe
        ];
    }

    public static function flash()
    {
        if( isset($_SESSION['flash'])) {
            echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] .' alert-dismissible position-fixed top-0 start-50 translate-middle-x mt-5 fade show" role="alert">
                        <strong>' . $_SESSION['flash']['pesan'] .'</strong> ' . $_SESSION['flash']['aksi'] .'.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        // Menyembunyikan alert setelah 5 detik
                        setTimeout(function() {
                        var alertEl = document.querySelector(".alert");
                        var alert = new bootstrap.Alert(alertEl);
                        alert.close();
                        }, 1500);
                    </script>';

            unset($_SESSION['flash']);
        }
    }
}