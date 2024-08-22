<!-- Modal -->
<div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Pekerjaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/insert.php" method="POST">
            <input type="hidden" name="id_projek" value="<?= $_SESSION['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_pekerjaan dari database
                        $sql_get_last_id = "SELECT MAX(id_m_pekerjaan) AS last_id FROM m_pekerjaan";
                        $result = $conn->query($sql_get_last_id);
                        $row = $result->fetch_assoc();
                        $last_id = $row['last_id'];
                    
                        // Menghasilkan id_m_pekerjaan baru dengan format PJM001, PJM002, ...
                        if ($last_id) {
                            $num = intval(substr($last_id, 3)) + 1;
                        } else {
                            $num = 1;
                        }
                        $new_id = 'P' . str_pad($num, 4, '0', STR_PAD_LEFT); //$new_id_m_pekerjaan = 'PJM' . str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
                        ?>
                        <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerjaan" class="form-label"><?=$new_id?></h5>
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" placeholder="Masukkan Nama Pekerjaan"required><br><br>
                    </div>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="pekerjaan_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>