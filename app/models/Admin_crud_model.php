<?php

class Admin_crud_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    public function newIdGenerator($id, $table, $format, $digit)
    {
        // Generate ID baru
        $sql_get_last_id = "SELECT MAX($id) AS last_id FROM $table";
        $this->db->query($sql_get_last_id);
        $row = $this->db->single(); // Memanggil metode single() langsung pada objek db
        $last_id = $row['last_id'];

        // Menghasilkan ID baru dengan format yang diinginkan
        if ($last_id) {
            $num = intval(substr($last_id, strlen($format))) + 1; // Mengambil bagian numerik dari ID
        } else {
            $num = 1;
        }
        $new_id = $format . str_pad($num, $digit, '0', STR_PAD_LEFT); // Menggabungkan format dengan nomor yang dihasilkan

        return $new_id;
    }

    public function tambahProjek()
    {
        // Ambil data dari POST
        $id_projek = $_POST['id_projek'];
        $nama_projek = $_POST['nama_projek'];
        $tanggal_mulai = $_POST['tanggal_mulai_tambah'];
        $tanggal_selesai = $_POST['tanggal_selesai_tambah'];
        $pemilik_pekerjaan = $_POST['pemilik_pekerjaan'];
        $pengawas = $_POST['pengawas'];
        $kontraktor = $_POST['kontraktor'];
        $tambahan_waktu = !empty($_POST['tambahan_waktu_tambah']) ? $_POST['tambahan_waktu_tambah'] : NULL;

        // Handling file upload
        $logo1_name = $_FILES['logo1']['name'];
        $logo2_name = $_FILES['logo2']['name'];
        $logo3_name = $_FILES['logo3']['name'];

        $logo1_new_name = NULL;
        $logo2_new_name = NULL;
        $logo3_new_name = NULL;

        // Kondisi untuk logo1
        if (!empty($logo1_name)) {
            $logo1_ext = pathinfo($logo1_name, PATHINFO_EXTENSION);
            $logo1_new_name = $id_projek . '_logo1.' . $logo1_ext;
            $logo1_temp = $_FILES['logo1']['tmp_name'];
            $logo1_path = '../public/assets/img/uploads/logo/' . $logo1_new_name;
            move_uploaded_file($logo1_temp, $logo1_path);
        }

        // Kondisi untuk logo2
        if (!empty($logo2_name)) {
            $logo2_ext = pathinfo($logo2_name, PATHINFO_EXTENSION);
            $logo2_new_name = $id_projek . '_logo2.' . $logo2_ext;
            $logo2_temp = $_FILES['logo2']['tmp_name'];
            $logo2_path = '../public/assets/img/uploads/logo/' . $logo2_new_name;
            move_uploaded_file($logo2_temp, $logo2_path);
        }

        // Kondisi untuk logo3
        if (!empty($logo3_name)) {
            $logo3_ext = pathinfo($logo3_name, PATHINFO_EXTENSION);
            $logo3_new_name = $id_projek . '_logo3.' . $logo3_ext;
            $logo3_temp = $_FILES['logo3']['tmp_name'];
            $logo3_path = '../public/assets/img/uploads/logo/' . $logo3_new_name;
            move_uploaded_file($logo3_temp, $logo3_path);
        }

        // SQL untuk memasukkan data ke dalam tabel m_projek
        $sql_m_projek = "INSERT INTO m_projek (id_projek, nama_projek, tanggal_mulai, tanggal_selesai, pemilik_pekerjaan, pengawas, kontraktor, logo_pemilik, logo_pengawas, logo_kontraktor, tambahan_waktu)
        VALUES (:id_projek, :nama_projek, :tanggal_mulai, :tanggal_selesai, :pemilik_pekerjaan, :pengawas, :kontraktor, :logo_pemilik, :logo_pengawas, :logo_kontraktor, :tambahan_waktu)";

        $this->db->query($sql_m_projek);

        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('nama_projek', $nama_projek);
        $this->db->bind('tanggal_mulai', $tanggal_mulai);
        $this->db->bind('tanggal_selesai', $tanggal_selesai);
        $this->db->bind('pemilik_pekerjaan', $pemilik_pekerjaan);
        $this->db->bind('pengawas', $pengawas);
        $this->db->bind('kontraktor', $kontraktor);
        $this->db->bind('logo_pemilik', $logo1_new_name);
        $this->db->bind('logo_pengawas', $logo2_new_name);
        $this->db->bind('logo_kontraktor', $logo3_new_name);

        // Kondisi bind tambahan_waktu
        if ($tambahan_waktu !== NULL) {
            $this->db->bind('tambahan_waktu', $tambahan_waktu);
        } else {
            $this->db->bind('tambahan_waktu', NULL);
        }

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahProjek()
{
    $id_projek = $_POST['id_projek'];
    $nama_projek = $_POST['nama_projek'];
    $tanggal_mulai = $_POST['tanggal_mulai_ubah'];
    $tanggal_selesai = $_POST['tanggal_selesai_ubah'];
    $pemilik_pekerjaan = $_POST['pemilik_pekerjaan'];
    $pengawas = $_POST['pengawas'];
    $kontraktor = $_POST['kontraktor'];
    $tambahan_waktu = !empty($_POST['tambahan_waktu_ubah']) ? $_POST['tambahan_waktu_ubah'] : NULL;

    // Handling file upload
    $logo1_name = $_FILES['logo1']['name'];
    $logo2_name = $_FILES['logo2']['name'];
    $logo3_name = $_FILES['logo3']['name'];

    $logo1_new_name = NULL;
    $logo2_new_name = NULL;
    $logo3_new_name = NULL;

    try {
        // Kondisi untuk logo1
        if (!empty($logo1_name)) {
            $logo1_ext = pathinfo($logo1_name, PATHINFO_EXTENSION);
            $logo1_new_name = $id_projek . '_logo1.' . $logo1_ext;
            $logo1_temp = $_FILES['logo1']['tmp_name'];
            $logo1_path = '../public/assets/img/uploads/logo/' . $logo1_new_name;
            if (!move_uploaded_file($logo1_temp, $logo1_path)) {
                return "Error uploading logo1.";
            }
        }

        // Kondisi untuk logo2
        if (!empty($logo2_name)) {
            $logo2_ext = pathinfo($logo2_name, PATHINFO_EXTENSION);
            $logo2_new_name = $id_projek . '_logo2.' . $logo2_ext;
            $logo2_temp = $_FILES['logo2']['tmp_name'];
            $logo2_path = '../public/assets/img/uploads/logo/' . $logo2_new_name;
            if (!move_uploaded_file($logo2_temp, $logo2_path)) {
                return "Error uploading logo2.";
            }
        }

        // Kondisi untuk logo3
        if (!empty($logo3_name)) {
            $logo3_ext = pathinfo($logo3_name, PATHINFO_EXTENSION);
            $logo3_new_name = $id_projek . '_logo3.' . $logo3_ext;
            $logo3_temp = $_FILES['logo3']['tmp_name'];
            $logo3_path = '../public/assets/img/uploads/logo/' . $logo3_new_name;
            if (!move_uploaded_file($logo3_temp, $logo3_path)) {
                return "Error uploading logo3.";
            }
        }

        // Inisialisasi SQL untuk memperbarui data di tabel m_projek
        $sql_m_projek = "UPDATE m_projek SET 
                            nama_projek = :nama_projek,
                            tanggal_mulai = :tanggal_mulai,
                            tanggal_selesai = :tanggal_selesai,
                            pemilik_pekerjaan = :pemilik_pekerjaan,
                            pengawas = :pengawas,
                            kontraktor = :kontraktor";

        // Update logo jika ada
        if (!empty($logo1_new_name)) {
            $sql_m_projek .= ", logo_pemilik = :logo1_new_name";
        }
        if (!empty($logo2_new_name)) {
            $sql_m_projek .= ", logo_pengawas = :logo2_new_name";
        }
        if (!empty($logo3_new_name)) {
            $sql_m_projek .= ", logo_kontraktor = :logo3_new_name";
        }

        // Tambahkan nilai tambahan_waktu jika ada
        if ($tambahan_waktu !== NULL) {
            $sql_m_projek .= ", tambahan_waktu = :tambahan_waktu";
        } else {
            $sql_m_projek .= ", tambahan_waktu = NULL";
        }

        $sql_m_projek .= " WHERE id_projek = :id_projek";

        // Query preparation
        $this->db->query($sql_m_projek);

        // Bind parameters
        $this->db->bind('nama_projek', $nama_projek);
        $this->db->bind('tanggal_mulai', $tanggal_mulai);
        $this->db->bind('tanggal_selesai', $tanggal_selesai);
        $this->db->bind('pemilik_pekerjaan', $pemilik_pekerjaan);
        $this->db->bind('pengawas', $pengawas);
        $this->db->bind('kontraktor', $kontraktor);
        $this->db->bind('id_projek', $id_projek);

        if (!empty($logo1_new_name)) {
            $this->db->bind('logo1_new_name', $logo1_new_name);
        }
        if (!empty($logo2_new_name)) {
            $this->db->bind('logo2_new_name', $logo2_new_name);
        }
        if (!empty($logo3_new_name)) {
            $this->db->bind('logo3_new_name', $logo3_new_name);
        }
        if ($tambahan_waktu !== NULL) {
            $this->db->bind('tambahan_waktu', $tambahan_waktu);
        }

        // Eksekusi query untuk m_projek
        $projek_update = $this->db->execute();
        if ($projek_update) {
            return "Update successful!";
        } else {
            return "Update failed. No changes were made.";
        }
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}



    public function hapusProjek()
    {
        // Menyimpan data baru
        $id_projek = $_POST['id_projek'];
        $hapus = ("DELETE FROM m_projek WHERE id_projek = :id_projek");

        $this->db->query($hapus);

        $this->db->bind('id_projek', $id_projek);

        $this->db->execute();

        return;
    }

    public function tambahMPekerjaan()
    {
        // Menyimpan data baru
        $id_projek = $_POST['id_projek'];
        $id_m_pekerjaan = $_POST['id_m_pekerjaan'];
        $nama_pekerjaan = $_POST['nama_pekerjaan'];
        $simpan = ("INSERT INTO m_pekerjaan(id_m_pekerjaan, id_projek, nama_pekerjaan) VALUES (:id_m_pekerjaan, :id_projek, :nama_pekerjaan)");

        $this->db->query($simpan);

        $this->db->bind('id_m_pekerjaan', $id_m_pekerjaan);
        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('nama_pekerjaan', $nama_pekerjaan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahMPekerjaan()
    {
        // Menyimpan data baru
        $id_m_pekerjaan = $_POST['id_m_pekerjaan'];
        $nama_pekerjaan = $_POST['nama_pekerjaan'];
        $ubah = ("UPDATE m_pekerjaan SET nama_pekerjaan = :nama_pekerjaan WHERE id_m_pekerjaan = :id_m_pekerjaan");

        $this->db->query($ubah);

        $this->db->bind('id_m_pekerjaan', $id_m_pekerjaan);
        $this->db->bind('nama_pekerjaan', $nama_pekerjaan);

        $this->db->execute();

        return;
    }

    public function hapusMPekerjaan()
    {
        // Menyimpan data baru
        $id_m_pekerjaan = $_POST['id_m_pekerjaan'];
        $hapus = ("DELETE FROM m_pekerjaan WHERE id_m_pekerjaan = :id_m_pekerjaan");

        $this->db->query($hapus);

        $this->db->bind('id_m_pekerjaan', $id_m_pekerjaan);

        $this->db->execute();

        return;
    }

    public function tambahSubPekerjaan()
    {
        // Menyimpan data baru
        $id_m_sub_pekerjaan = $_POST['id_m_sub_pekerjaan'];
        $id_m_pekerjaan = $_POST['id_m_pekerjaan'];
        $nama_sub_pekerjaan = $_POST['nama_sub_pekerjaan'];
        $simpan = ("INSERT INTO m_sub_pekerjaan(id_m_sub_pekerjaan, id_m_pekerjaan, nama_sub_pekerjaan) VALUES (:id_m_sub_pekerjaan, :id_m_pekerjaan, :nama_sub_pekerjaan)");

        $this->db->query($simpan);

        $this->db->bind('id_m_sub_pekerjaan', $id_m_sub_pekerjaan);
        $this->db->bind('id_m_pekerjaan', $id_m_pekerjaan);
        $this->db->bind('nama_sub_pekerjaan', $nama_sub_pekerjaan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahSubPekerjaan()
    {
        // Menyimpan data baru
        $id_m_sub_pekerjaan = $_POST['id_m_sub_pekerjaan'];
        $nama_sub_pekerjaan = $_POST['nama_sub_pekerjaan'];
        $ubah = ("UPDATE m_sub_pekerjaan SET nama_sub_pekerjaan = :nama_sub_pekerjaan WHERE id_m_sub_pekerjaan = :id_m_sub_pekerjaan");

        $this->db->query($ubah);

        $this->db->bind('id_m_sub_pekerjaan', $id_m_sub_pekerjaan);
        $this->db->bind('nama_sub_pekerjaan', $nama_sub_pekerjaan);

        $this->db->execute();

        return;
    }

    public function hapusSubPekerjaan()
    {
        // Menyimpan data baru
        $id_m_sub_pekerjaan = $_POST['id_m_sub_pekerjaan'];
        $hapus = ("DELETE FROM m_sub_pekerjaan WHERE id_m_sub_pekerjaan = :id_m_sub_pekerjaan");

        $this->db->query($hapus);

        $this->db->bind('id_m_sub_pekerjaan', $id_m_sub_pekerjaan);


        $this->db->execute();

        return;
    }

    public function tambahMPekerja()
    {
        // Menyimpan data baru
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $id_projek = $_POST['id_projek'];
        $jenis_pekerja = $_POST['jenis_pekerja'];
        
        $simpan = ("INSERT INTO m_pekerja(id_m_pekerja, id_projek, jenis_pekerja) VALUES (:id_m_pekerja, :id_projek, :jenis_pekerja)");

        $this->db->query($simpan);

        $this->db->bind('id_m_pekerja', $id_m_pekerja);
        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('jenis_pekerja', $jenis_pekerja);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahMPekerja()
    {
        // Menyimpan data baru
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $jenis_pekerja = $_POST['jenis_pekerja'];
        $ubah = ("UPDATE m_pekerja SET jenis_pekerja = :jenis_pekerja WHERE id_m_pekerja = :id_m_pekerja"); 

        $this->db->query($ubah);

        $this->db->bind('id_m_pekerja', $id_m_pekerja);
        $this->db->bind('jenis_pekerja', $jenis_pekerja);

        $this->db->execute();

        return;
    }

    public function hapusMPekerja()
    {
        // Menyimpan data baru
        $id_m_pekerja = $_POST['id_m_pekerja'];
        $hapus = ("DELETE FROM m_pekerja WHERE id_m_pekerja = :id_m_pekerja");

        $this->db->query($hapus);

        $this->db->bind('id_m_pekerja', $id_m_pekerja);


        $this->db->execute();

        return;
    }

    public function tambahMperalatan()
    {
        // Menyimpan data baru
        $id_m_peralatan = $_POST['id_m_peralatan'];
        $id_projek = $_POST['id_projek'];
        $nama_alat = $_POST['nama_alat'];
        $satuan = $_POST['satuan'];
        

        // SQL untuk memasukkan data ke dalam tabel m_peralatan
        $simpan = "INSERT INTO m_peralatan (id_m_peralatan, id_projek, nama_alat, satuan) VALUES (:id_m_peralatan, :id_projek, :nama_alat, :satuan)";


        $this->db->query($simpan);

        $this->db->bind('id_m_peralatan', $id_m_peralatan);
        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('nama_alat', $nama_alat);
        $this->db->bind('satuan', $satuan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahMperalatan()
    {
        // Menyimpan data baru
        $id_m_peralatan = $_POST['id_m_peralatan'];
        $nama_alat = $_POST['nama_alat'];
        $satuan = $_POST['satuan'];

        $ubah = ("UPDATE m_peralatan SET nama_alat = :nama_alat, satuan = :satuan WHERE id_m_peralatan = :id_m_peralatan"); 

        $this->db->query($ubah);

        $this->db->bind('id_m_peralatan', $id_m_peralatan);
        $this->db->bind('nama_alat', $nama_alat);
        $this->db->bind('satuan', $satuan);

        $this->db->execute();

        return;
    }

    public function hapusMperalatan()
    {
        // Menyimpan data baru
        $id_m_peralatan = $_POST['id_m_peralatan'];

        $hapus = ("DELETE FROM m_peralatan WHERE id_m_peralatan = :id_m_peralatan");

        $this->db->query($hapus);

        $this->db->bind('id_m_peralatan', $id_m_peralatan);

        $this->db->execute();

        return;
    }

    public function tambahMBahan()
    {
        // Menyimpan data baru
        $id_m_bahan = $_POST['id_m_bahan'];
        $id_projek = $_POST['id_projek'];
        $nama_bahan = $_POST['nama_bahan'];
        $satuan = $_POST['satuan'];
        
        // SQL untuk memasukkan data ke dalam tabel m_peralatan
        $simpan = "INSERT INTO m_bahan (id_m_bahan, id_projek, nama_bahan, satuan) VALUES (:id_m_bahan, :id_projek, :nama_bahan, :satuan)";

        $this->db->query($simpan);

        $this->db->bind('id_m_bahan', $id_m_bahan);
        $this->db->bind('id_projek', $id_projek);
        $this->db->bind('nama_bahan', $nama_bahan);
        $this->db->bind('satuan', $satuan);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function ubahMBahan()
    {
        // Menyimpan data baru
        $id_m_bahan = $_POST['id_m_bahan'];
        $nama_bahan = $_POST['nama_bahan'];
        $satuan = $_POST['satuan'];

        $ubah = ("UPDATE m_bahan SET nama_bahan = :nama_bahan, satuan = :satuan WHERE id_m_bahan = :id_m_bahan"); 

        $this->db->query($ubah);

        $this->db->bind('id_m_bahan', $id_m_bahan);
        $this->db->bind('nama_bahan', $nama_bahan);
        $this->db->bind('satuan', $satuan);

        $this->db->execute();

        return;
    }

    public function hapusMBahan()
    {
        // Menyimpan data baru
        $id_m_bahan = $_POST['id_m_bahan'];

        $hapus = ("DELETE FROM m_bahan WHERE id_m_bahan = :id_m_bahan");

        $this->db->query($hapus);

        $this->db->bind('id_m_bahan', $id_m_bahan);

        $this->db->execute();

        return;
    }
}




?>