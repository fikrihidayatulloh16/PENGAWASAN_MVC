<?php
// Inisialisasi session


// Mengecek apakah session 'id_laporan_harian' sudah diset
if (empty($_SESSION['id_laporan_harian'])) {
    // Ambil parameter dari URL jika ada
    if (isset($_GET['id_laporan_harian'], $_GET['tanggal_laporan'], $_GET['nomor'])) {
        $id_laporan_harian = $_GET['id_laporan_harian'];
        $tanggal_laporan = $_GET['tanggal_laporan'];
        $nomor = $_GET['nomor'];

        // Menyimpan ke dalam session
        $_SESSION['id_laporan_harian'] = $id_laporan_harian;
        $_SESSION['tanggal_laporan'] = $tanggal_laporan;
        $_SESSION['nomor'] = $nomor;
    }
}

// Mengambil id_laporan_harian dari session
$id_laporan_harian = $_SESSION['id_laporan_harian'] ?? null;

// Mengambil data pekerjaan harian
$nomor = 1;
$id_sub = array_column($data['pekerjaan_harian'], null);
?>

<style>
.nav-tabs {
    flex-wrap: nowrap;
    overflow-x: auto;
    white-space: nowrap;
}

.nav-tabs .nav-link {
    background-color: white;
    color: black;
    border-color: grey;
}

.nav-tabs .nav-link.active {
    background-color: grey;
    color: white;
}

.nav-tabs::-webkit-scrollbar { 
    display: none; /* Safari and Chrome */
}

.nav-tabs .nav-link:not(.active):hover {
    background-color: grey;
    color: white;
}
</style>

<div class="container">
    <nav>
        <div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
            <?php foreach ($id_sub as $index => $sub): ?>
                <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="nav-<?= $sub['id_m_sub_pekerjaan'] ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= $sub['id_m_sub_pekerjaan'] ?>" type="button" role="tab" aria-controls="nav-<?= $sub['id_m_sub_pekerjaan'] ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                    <?= $sub['nama_sub_pekerjaan'] ?>
                </button>
            <?php endforeach; ?>
        </div>
    </nav>
    <div class="tab-content background-color-dark" id="nav-tabContent">
        <?php foreach ($id_sub as $index => $sub): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="nav-<?= $sub['id_m_sub_pekerjaan'] ?>" role="tabpanel" aria-labelledby="nav-<?= $sub['id_m_sub_pekerjaan'] ?>-tab">
                <h2 class="ms-5 mt-5">Sub: <?= $sub['nama_sub_pekerjaan'] ?></h2>
                <?php include '../app/views/modals/modal_add/operator/pekerjaan_harian_lh_add.php' ?>

                <!-- Data Pekerja -->
                <div class="container mt-3">
                    <div class="card mt-3">
                        <h5 class="card-header">
                            Data Pekerja
                            <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-pekerja-tambah-<?= $sub['id_m_sub_pekerjaan'] ?>">
                                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i> ADD
                            </button>
                        </h5>
                        <table class="table-thick-border">
                            <tr>
                                <th class="col-3">Nama</th>
                                <th>Jumlah</th>
                                <th class="kolom-aksi-pekerjaan col-2 text-center">Aksi</th>
                            </tr>
                            <?php if (!empty($data['pekerja'][$sub['id_m_sub_pekerjaan']])): ?>
                                <?php foreach ($data['pekerja'][$sub['id_m_sub_pekerjaan']] as $data_pekerja): ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($data_pekerja['jenis_pekerja']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($data_pekerja['jumlah_pekerja']) ?> Orang</td>
                                        <td class="text-center">
                                            <form action="../../script/projek_pilih.php" method="POST">
                                                <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-pekerja-hapus-<?= $data_pekerja['id_pekerja'] ?>"><i class='bx bx-trash'></i></a>
                                                <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-pekerja-ubah-<?= $data_pekerja['id_pekerja'] ?>"><i class='bx bxs-edit-alt'></i></a>
                                                <input type="hidden" name="id_laporan" value="<?= htmlspecialchars($id_laporan_harian) ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php 
                                include '../app/views/modals/modal_ud/operator/pekerjaan_lh_ud/pekerja_lh_ud.php';
                                endforeach; 
                                ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data Pekerja!</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <hr class="separator mt-5">

                <!-- Data Peralatan -->
                <div class="card mt-5">
                    <h5 class="card-header">
                        Data Peralatan
                        <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-peralatan-tambah-<?=$index?>">
                            <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i> ADD
                        </button>
                    </h5>
                    <table class="table-thick-border">
                        <tr>
                            <th class="col-3">Nama</th>
                            <th>Jumlah</th>
                            <th class="kolom-aksi-pekerjaan col-2">Aksi</th>
                        </tr>
                        <?php if (!empty($data['peralatan'][$sub['id_m_sub_pekerjaan']])): ?>
                            <?php foreach ($data['peralatan'][$sub['id_m_sub_pekerjaan']] as $data_peralatan): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($data_peralatan['nama_alat']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($data_peralatan['jumlah_peralatan']) ?> <?= htmlspecialchars($data_peralatan['satuan']) ?></td>
                                    <td class="text-center">
                                        <form action="../../script/projek_pilih.php" method="POST">
                                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-peralatan-hapus-<?=$data_peralatan['id_peralatan']?>"><i class='bx bx-trash'></i></a>
                                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-peralatan-ubah-<?=$data_peralatan['id_peralatan']?>"><i class='bx bxs-edit-alt'></i></a>
                                            <input type="hidden" name="id_peralatan" value="<?= htmlspecialchars($data_peralatan['id_peralatan']) ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            include '../app/views/modals/modal_ud/operator/pekerjaan_lh_ud/peralatan_lh_ud.php';
                            endforeach; 
                            ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data Peralatan.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <hr class="separator mt-5">

                <!-- Data Bahan -->
                <div class="card mt-5">
                    <h5 class="card-header">
                        Data Bahan
                        <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-bahan-tambah-<?=$index?>">
                            <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i> ADD
                        </button>
                    </h5>
                    <table class="table-thick-border">
                        <tr>
                            <th class="col-3">Nama</th>
                            <th>Jumlah</th>
                            <th class="kolom-aksi-pekerjaan col-2">Aksi</th>
                        </tr>
                        <?php if (!empty($data['bahan'][$sub['id_m_sub_pekerjaan']])): ?>
                            <?php foreach ($data['bahan'][$sub['id_m_sub_pekerjaan']] as $data_bahan): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($data_bahan['nama_bahan']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($data_bahan['jumlah_bahan']) ?> <?= htmlspecialchars($data_bahan['satuan']) ?></td>
                                    <td class="text-center">
                                        <form action="../../script/projek_pilih.php" method="POST">
                                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-bahan-hapus-<?=$data_bahan['id_bahan']?>"><i class='bx bx-trash'></i></a>
                                            <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-bahan-ubah-<?=$data_bahan['id_bahan']?>"><i class='bx bxs-edit-alt'></i></a>
                                            <input type="hidden" name="id_laporan" value="<?= htmlspecialchars($data['id_laporan_harian']) ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            include '../app/views/modals/modal_ud/operator/pekerjaan_lh_ud/bahan_lh_ud.php';
                            endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data Bahan.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="pekerjaan.php" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i> Kembali
    </a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            var tabButton = document.querySelector('#' + activeTab + '-tab');
            var tabPane = document.querySelector('#' + activeTab);

            if (tabButton && tabPane) {
                var currentlyActiveButton = document.querySelector('.nav-link.active');
                var currentlyActivePane = document.querySelector('.tab-pane.show.active');

                if (currentlyActiveButton) currentlyActiveButton.classList.remove('active');
                if (currentlyActivePane) currentlyActivePane.classList.remove('show', 'active');

                tabButton.classList.add('active');
                tabPane.classList.add('show', 'active');
            }
        }

        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.getAttribute('data-bs-target').substring(1));
            });
        });
    });
</script>
