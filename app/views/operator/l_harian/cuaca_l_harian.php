
<div class="container mt-5">
    <div class="card">
        <form method="POST" action="<?= PUBLICURL ?>/operator/ubah_cuaca/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>">
        <h5 class="card-header">
            Daftar Cuaca
        <div class="text-left pb-3">
            <button type="submit" class="btn btn-tambah" name="cuaca_ubah"><i class='bx bx-download'></i>Save</button>
        </div>
        </h5>
            <div class="table-responsive">
                    <table class="table-thick-border table-sm text-center" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Kondisi Cuaca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['cuaca'] as $cuaca) : ?>
                                <tr>
                                    <td><?= $cuaca['jam_mulai'] ?></td>
                                    <td><?= $cuaca['jam_selesai'] ?></td>
                                    <td style="align-items: middle;">
                                        <input type="hidden" name="id_cuaca[]" value="<?= $cuaca['id_cuaca'] ?>">
                                        <select class="form-select text-center" name="kondisi[]">
                                            <option value="cerah" <?= ($cuaca['kondisi'] == 'cerah') ? 'selected' : '' ?>>Cerah</option>
                                            <option value="gerimis" <?= ($cuaca['kondisi'] == 'gerimis') ? 'selected' : '' ?>>Gerimis</option>
                                            <option value="hujan" <?= ($cuaca['kondisi'] == 'hujan') ? 'selected' : '' ?>>Hujan</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/rekap/<?=$data['id_laporan_harian']?>/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>
