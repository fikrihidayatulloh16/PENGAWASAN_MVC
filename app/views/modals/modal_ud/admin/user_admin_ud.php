<!-- Ubah Modal -->
<div class="modal fade" id="user-admin-ubah<?=$user['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/admin/ubah_user_admin/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id" value="<?=$user['id']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id" class="form-label"><?=$user['id']?></h5>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']?>" placeholder="Masukkan Nama Bahan" required><br>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kata Sandi)</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= $user['password']?>" placeholder="Masukkan Satuan"required><br>
                        </div>
                        <label for="password" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="<?= $user['role']?>" disabled selected><?= $user['role']?></option>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning text-dark" name="bahan_ubah">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Modal -->
<div class="modal fade" id="user-admin-hapus<?=$user['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-danger text-dark">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= PUBLICURL ?>/admin/hapus_user_admin/<?= $data['id_projek'] ?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="id" value="<?=$user['id']?>">
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <h5 for="id" class="form-label" id="id" name="id" value="<?= $user['id']?>"><?=$user['id']?></h5>
                    <label for="username" class="form-label">Username</label>
                    <h5 for="username" class="form-label text-danger"><?=$user['username']?></h5>
                </div>
            </div>
        
            <div class="modal-footer">
            <button type="submit" class="btn btn-danger" name="bahan_hapus">Hapus</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
    </div>
</div>