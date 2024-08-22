<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header.php";
    
?>

<body>
    <div class="container mt-3">
            <button type="button-center" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#form"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="btambah"></i>Tambah</button>
            <a href="m_pekerjaan.php" class="btn btn-secondary align-item-right" ><i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali</a>
            
        <div class="card">
            <h5 class="card-header bg-primary text-white">Data Master Sub Pekerjaan</h5>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nama pekerjaan</th>
                        <th class="col-2">Aksi</th>
                    </tr>

                    <?php
                    //menampilkan data
                    //$id_projek = $_SESSION['id_projek'];
                    //$id_pekerjaan = $_SESSION['id_m_pekerjaan'];
                    //$nama_pekerjaan = $_SESSION['nama_pekerjaan'];

                    //Membuat tabel  berdasarkan kueri
                    $tampil = $this->model('Admin_db_model')->getAllMSPByIdPekerjaan($id_pekerjaan);
                    while ($data = mysqli_fetch_array($tampil)) :
                ?>

                <tr>
                    <td><?= $data['id_m_sub_pekerjaan']?></td>
                    <td><?= $data['nama_sub_pekerjaan']?></td>
                    <td>
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_m_sub_pekerjaan']?>"><i class='bx bxs-trash-alt' style="margin-right: 8px;"></i><span class="span-aksi">Delete</span></a>
                        <a href="#" class="btn btn-warning text-dark"  data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_m_sub_pekerjaan']?>"><i class='bx bxs-edit-alt'></i><span class="span-aksi">Edit</span></a>
                    </td>
                </tr>
                <?php include "modal.admin/sub_modal.php"; ?>
                <?php endwhile; ?>
                </table>
                
            </div>
        </div>
    </div>
</body>

<?php
    include "../../public/layout/admin/header2.php";
?>