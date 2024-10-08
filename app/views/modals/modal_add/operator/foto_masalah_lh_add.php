<!-- Modal Tambah Foto Kegiatan -->
<div class="modal fade" id="ftm-tambah-<?= $permasalahan['id_permasalahan'] ?>" tabindex="-1" aria-labelledby="ftm_tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="fk_tambahLabel">Tambah Foto Masalah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="spinner-form" action="<?= PUBLICURL ?>/operator/tambah_foto_masalah/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_permasalahan" value="<?= $permasalahan['id_permasalahan'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputFoto" class="form-label">Foto </label>
                        <input type="file" class="form-control" id="foto-<?= $permasalahan['id_permasalahan'] ?>" name="foto" accept="image/*" required>
                    </div>
                    <!-- Preview Gambar -->
                    <div class="mb-3">
                        <img id="preview-image-<?= $permasalahan['id_permasalahan'] ?>" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto;">
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success spinner-button" name="foto_simpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto-<?= $permasalahan['id_permasalahan'] ?>').onchange = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview-image-<?= $permasalahan['id_permasalahan'] ?>');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
