<!-- Modal -->
<div class="modal fade" id="user-admin-tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/admin/tambah_user_admin/<?= $data['id_projek'] ?>" method="POST">
            <input type="hidden" name="id_projek" value="<?= $data['id_projek']?>"> 
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username"required><br>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Kata Sandi)</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Satuan"required><br>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="bahan_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>