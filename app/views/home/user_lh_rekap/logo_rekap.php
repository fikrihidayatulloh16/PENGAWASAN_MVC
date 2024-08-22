<style>
    .custom-img {
        max-width: 150px;
        height: 150px;
    }
    
    .flex-column-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%; /* Sesuaikan jika diperlukan */
    }

    .flex-column-center h4, .flex-column-center img, .flex-column-center span {
        margin-bottom: 10px; /* Spasi antara elemen */
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center flex-column-center">
            <h4>Pemilik Pekerjaan</h4>
            <img src="<?= PUBLICURL ?>/assets/img/uploads/logo/<?= $data['logo']['logo_pemilik'] ?>" alt="logo_pemilik" class="img-fluid custom-img">
            <span><?= $data['logo']['pemilik_pekerjaan'] ?></span>
        </div>
        <div class="col-md-4 text-center flex-column-center">
            <h4>Konsultan Pengawas</h4>
            <img src="<?= PUBLICURL ?>/assets/img/uploads/logo/<?= $data['logo']['logo_pengawas'] ?>" alt="logo_pengawas" class="img-fluid custom-img">
            <span><?= $data['logo']['pengawas'] ?></span>
        </div>
        <div class="col-md-4 text-center flex-column-center">
            <h4>Kontraktor Pelaksana</h4>
            <img src="<?= PUBLICURL ?>/assets/img/uploads/logo/<?= $data['logo']['logo_kontraktor'] ?>" alt="logo_kontrakor" class="img-fluid custom-img">
            <span><?= $data['logo']['kontraktor'] ?></span>
        </div>
    </div>
</div>

<hr class="container separator">