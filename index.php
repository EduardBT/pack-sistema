<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pack Express</title>
    <meta name="keywords" content="">
    <meta name="description" content="Gestión de Mensajeria">
    <meta name="author" content="Carolina Ayelen Calviño">
    <!--Css-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href='css/login.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="login.php" method="POST">
        <h5 class="title_login">Sistema Administrativo Pack Express Uruguay</h5>
        <div class="logo_center">
            <img src="img/iso.png" alt="Logo pack" width="150px">
        </div>

        <label for="username">Usuario</label>
        <input type="text" placeholder="Usuario" id="exampleFormControlInput1" name='usuario' required>
        <span id='usuario'></span>

        <label for="password">Contraseña</label>
        <input type="password" placeholder="*******" id="password" for="exampleFormControlInput1" name='password'
            required>

        <button type="submit"><i class="bi bi-box-arrow-in-right icono_login"></i> Acceder</button>

    </form>
    <!-- <span class='error'>
        <?php if (isset($_GET['err'])) {
            echo "Usuario y/o contraseña incorrecto";
        } ?>
    </span> -->
    </div>
    </form>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js "
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8 "
        crossorigin="anonymous "></script>
    <script src="jquery-3.1.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js "></script>

</body>