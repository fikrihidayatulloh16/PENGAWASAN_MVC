<!-- Hapus Modal -->
<div class="modal fade" id="cco-hapus-<?=$index?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-danger text-dark">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Master Bahan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= PUBLICURL ?>/admin/hapus_cco/<?= $data['id_projek'] ?>/<?= $index ?>" method="POST">
        <input type="hidden" name="cco" value="<?=$index?>">
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Peringatan!!</strong><br>
                    <p>Semua data yang di dalam <strong><?= $index == 0 ? 'Kontrak Awal' : 'CCO' . $index ?></strong> akan terhapus. </p>
                    <p>Apakah anda yakin ingin menghapus? </p><br>
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