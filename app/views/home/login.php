<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
    <link rel="stylesheet" href="<?= PUBLICURL ?>/assets/css/login.css">
</head>
<body>

    <!-- Menampilkan flash -->
    <?php Flasher::flash() ?>

    <div class="background-wrap">
        <div class="background"></div>
    </div>

    <form id="accesspanel" action="<?= PUBLICURL ?>/home/user_auth" method="post">
        <h1 id="litheader">LOGIN</h1>
        <div class="inset">
            <p>
                <input type="text" name="username" id="username" placeholder="User Name">
            </p>
            <p>
                <input type="password" name="password" id="password" placeholder="Password">
            </p>
            
            <input class="loginLoginValue" type="hidden" name="service" value="login" />
        </div>
        <p class="p-container">
            <input type="submit" name="Login" id="go" value="Login">
        </p>
    </form>

    <script src="<?= PUBLICURL ?>/assets/js/login/login.js"></script>
</body>
</html>