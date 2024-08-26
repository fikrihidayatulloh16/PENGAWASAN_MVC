<!-- Modal Ubah Foto Kegiatan -->
<div class="modal fade" id="ftm-ubah<?= $foto_masalah['id'] ?>" tabindex="-1" aria-labelledby="fk_tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="fk_tambahLabel">Ubah Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PUBLICURL ?>/operator/ubah_foto_masalah/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $foto_masalah['id'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="file" class="form-control" id="foto-ubah-<?= $foto_masalah['id']?>" name="foto" accept="image/*">
                    </div>
                    <!-- Preview Gambar -->
                    <div class="mb-3">
                        <img id="preview-image-ubah-<?= $foto_masalah['id']?>" src="<?= PUBLICURL ?>/assets/img/uploads/foto_masalah/<?= $foto_masalah['foto_masalah'] ?>" alt="Preview Foto" style="max-width: 100%; height: auto;">
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="foto-ubah">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus foto kegiatan modal-->
<div class="modal fade" id="ftm-hapus<?= $foto_masalah['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Foto Kegiatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= PUBLICURL ?>/operator/hapus_foto_masalah/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" method="POST">
                <input type="hidden" name="id" value="<?=$foto_masalah['id']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_foto_masalah" class="form-label">Anda yakin ingin Hapus Foto?.</label>
                        <img id="foto" src="<?= PUBLICURL ?>/assets/img/uploads/foto_masalah/<?= $foto_masalah['foto_masalah'] ?>" alt="Preview Foto" style="max-width: 100%; height: auto;">
                    </div>
                </div>
                                    
                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="foto-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto-ubah-<?= $foto_masalah['id']?>').onchange = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview-image-ubah-<?= $foto_masalah['id']?>');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
