<?php

class User_model{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    // Mengambil data dari form

    public function userAuth()
    {
        // Pastikan sesi sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk memeriksa username dan password menggunakan prepared statements
        $this->db->query("SELECT id_projek FROM user WHERE username = :username AND password = :password");
        
        // Bind parameter untuk mencegah SQL injection
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password); // Pastikan password di-hash jika menggunakan hashing

        // Eksekusi query dan ambil hasilnya
        $result = $this->db->single();

        if ($result) {
            // Jika login berhasil, simpan data proyek ke sesi
            $_SESSION['id_projek_op'] = $result['id_projek'];
            return TRUE;
        } else {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan kesalahan
            echo "Username atau password salah.";
            return FALSE;
        }
    }

}

?>