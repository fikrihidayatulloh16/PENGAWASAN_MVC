    <h1 class="text-center mt-5">(temp)Data Master Projek untuk operator</h1>
        <div class="container mt-5">
            <div class="card">
                <h5 class="card-header">Data Master Projek</h5>

                    <table class="table-thick-border">
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek	</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Pemilik Pekerjaan</th>
                        <th>Pengawas</th>
                        <th>Kontraktor</th>
                        <th>Tambahan Waktu</th>
                        <th>Aksi</th>
                    </tr>
                        <?php
                            //menampilkan data projek
                            foreach ($data['projek'] as $projek) : 
                        ?>
                                <tr>
                                    <td><?= $projek['id_projek']?></td>
                                    <td><?= $projek['nama_projek']?></td>
                                    <td><?= $projek['tanggal_mulai']?></td>
                                    <td><?= $projek['tanggal_selesai']?></td>
                                    <td><?= $projek['pemilik_pekerjaan']?></td>
                                    <td><?= $projek['pengawas']?></td>
                                    <td><?= $projek['kontraktor']?></td>
                                    <td><?= $projek['tambahan_waktu']?></td> 
                                    <td>
                                        <a href="<?= PUBLICURL ?>/operator/laporan_harian_list/<?=$projek['id_projek']?>" class="btn btn-primary text-white" id="projek_pilih_op" name="projek_pilih_op">Pilih</i></button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
</body>