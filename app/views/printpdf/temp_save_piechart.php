<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<link href="<?= PUBLICURL ?>/assets/css/stylesRekap.css" rel="stylesheet">

<style>

    .image-container {
        max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

    .image-container img {
        width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }
</style>



<div class="container">
<div class="card mt-3">
    <h5 class="card-header">
        Data Cuaca Harian
        <a href="<?= PUBLICURL ?>/operator/cuaca_l_harian/<?= $data['id_laporan_harian'] ?>/<?= $data['id_projek'] ?>" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
    <div class="row">
        <div class="col-lg-6">
            <div class="title text-center chart-container">
                <h4>AM <small>(Malam s/d Siang)</small></h4>
                <canvas id="chart1" width="400" height="400"></canvas>
            </div>
            <!--
            <div class="card mt-5 mx-5">
                <h5 class="card-header">Data Cuaca</h5>
                <div class="tabel-cuaca-container">
                    <table class="table table-striped tabel-cuaca">
                        <thead>
                            <tr class="text-center">
                                <th class="weather-column">Jam</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <th class="text-center align-middle" style="border-right: black solid;"><?= $row['jam_mulai'] ?></th>
                                <?php }; ?>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr class="text-center align-middle">
                                <th class="weather-column">Cuaca</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                                        <?= $row['kondisi'] ?>
                                    </td>
                                <?php }; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                                -->
        </div>
        
        

        <div class="col-lg-6">
        <div class="title text-center chart-container">
                <h4>PM <small>(Siang s/d Malam)</small></h4>
                <canvas id="chart2" width="400" height="400"></canvas>
            </div>
<!--
            <div class="card mt-5 mx-5">
                <h5 class="card-header">Data Cuaca</h5>
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-striped tabel-cuaca">
                        <thead>
                            <tr class="text-center">
                                <th class="weather-column">Jam</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <th class="text-center align-middle" style="border-right: black solid;"><?= $row['jam_mulai'] ?></th>
                                <?php }; ?>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr class="text-center align-middle ">
                                <th class="weather-column">Cuaca</th>
                                <?php foreach ($chunksArray['chunk_2'] as $row) { ?>
                                    <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                                        <?= $row['kondisi'] ?>
                                    </td>
                                <?php }; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                                -->
        </div>
    </div>

<!--
        <div class="card mt-5">
                <h5 class="card-header">Data Cuaca</h5>
                <div class="tabel-cuaca-container">
                    <table class="table table-striped tabel-cuaca">
                        <thead>
                            <tr class="text-center">
                                <th class="weather-column align-middle" rowspan="2">Jam</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <th class="text-center align-middle" style="border-right: black solid;"><?= $row['jam_mulai'] ?>-</th>
                                <?php }; ?>
                            </tr>
                            <tr class="text-center">
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                     Menampilkan jam_mulai di baris pertama dan jam_selesai di baris kedua dalam kolom yang sama 
                                    <th class="text-center align-middle" style="border-right: black solid;">
                                        <?= $row['jam_selesai'] ?>
                                    </th>
                                <?php }; ?>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr class="text-center align-middle">
                                <th class="weather-column">Cuaca</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                                        <?= $row['kondisi'] ?>
                                    </td>
                                <?php }; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="card mt-5">
    <h5 class="card-header">Data Cuaca</h5>
    <div class="table-responsive" style="overflow-x: auto;">
        <table class="table table-striped tabel-cuaca">
            <thead>
                <tr class="text-center">
                    <th class="weather-column" rowspan="2">Jam</th>
                    <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                        Menampilkan jam_mulai di baris pertama dan jam_selesai di baris kedua dalam kolom yang sama 
                        <th class="text-center align-middle" style="border-right: black solid;">
                            <?= $row['jam_mulai'] ?>-
                        </th>
                    <?php }; ?>
                </tr>
                <tr class="text-center">
                    <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                        Menampilkan jam_mulai di baris pertama dan jam_selesai di baris kedua dalam kolom yang sama 
                        <th class="text-center align-middle" style="border-right: black solid;">
                            <?= $row['jam_selesai'] ?>
                        </th>
                    <?php }; ?>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr class="text-center align-middle">
                    <th class="weather-column">Cuaca</th>
                    <?php foreach ($chunksArray['chunk_2'] as $row) { ?>
                        <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                            <?= $row['kondisi'] ?>
                        </td>
                    <?php }; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
-->


     <!-- Custom Legend -->
     <div class="legend-container">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #FF9705;"></div>
                <div class="legend-label">Cerah</div>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #7C7C7C;"></div>
                <div class="legend-label">Hujan</div>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #B1B1B1;"></div>
                <div class="legend-label">Gerimis</div>
            </div>
        </div>
</div>
</div>

<div class="container d-flex justify-content-end">
    <a href="<?= PUBLICURL ?>/operator/laporan_harian_list/<?=$data['id_projek']?>" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>

<script src="<?= PUBLICURL ?>/assets/js/piechart_cuaca_lh_save.js"></script>

<script>
    const TANGGAL_LAPORAN = '<?= $data['tanggal_laporan'] ?>';
    setTimeout(function() {
        // URL redirect
        window.location.href = `${PUBLICURL}/printpdf/mpdf_print/${ID_LAPORAN_HARIAN}/${ID_PROJEK}/${TANGGAL_LAPORAN}`;
    }, 3000); // 3000ms = 3 detik
</script>