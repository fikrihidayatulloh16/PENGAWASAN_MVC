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
        $this->db->query("SELECT id_projek, role FROM user WHERE username = :username AND password = :password");
        
        // Bind parameter untuk mencegah SQL injection
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password); // Pastikan password di-hash jika menggunakan hashing

        // Eksekusi query dan ambil hasilnya
        $result = $this->db->single();

        // Pastikan hasil tidak null dan verifikasi password
        if ($result) {
            // Simpan username ke sesi sesuai dengan role
            $_SESSION['username'] = $username;
            $_SESSION['id_projek'] = $result['id_projek'];
            $_SESSION['role'] = $result['role'];

            // Pisahkan logika berdasarkan role
            switch ($result['role']) {
                case 'superadmin':
                    $_SESSION['role_sa'] = $result['role'];
                    break;
                case 'admin':
                    $_SESSION['role_ad'] = $result['role'];
                    break;
                case 'operator':
                    $_SESSION['role_op'] = $result['role'];
                    break;
                case 'user':
                    $_SESSION['role_user'] = $result['role'];
                    break;
                default:
                    // Jika role tidak dikenal, hapus sesi dan kembali ke login
                    session_unset();
                    Flasher::setFlash('Gagal', 'Role tidak dikenali', 'danger');
                    return FALSE;
            }

            return TRUE;
        } else {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan kesalahan
            Flasher::setFlash('Gagal', 'Akun tidak ditemukan, atau Username/password salah', 'danger');
            return FALSE;
        }
    }

}

?>