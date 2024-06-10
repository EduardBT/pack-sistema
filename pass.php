<?php
include("session.php");
include("conexion.php");
include_once("includes/header.php");
include_once("includes/sidebar.php");
include_once("includes/footer.php");
?>
<?php

if (isset($_POST['editar-pass'])) {
    $passwordActual = $_SESSION['pass'];
    $passwordNueva = $_POST['pass-nueva'];
    $passwordConfirm = $_POST['pass-confirm'];

    $query = "SELECT pass FROM usuario WHERE id_usuario = '" . $_SESSION['id_usuario'] . "'";
    $resultado = mysqli_query($conexion, $query);
    $row = mysqli_fetch_array($resultado);

    if ($row['pass'] == $passwordActual) {
        //si coincide
        if ($passwordNueva == $passwordConfirm) {
            $update = "UPDATE usuario SET pass = '$passwordNueva' WHERE id_usuario = '" . $_SESSION['id_usuario'] . "'";
            $result = mysqli_query($conexion, $update);
            if ($update) {
                $_SESSION['message'] = 'Contraseña actualizada';
                $_SESSION['message-type'] = 'success';

            } else {
                $_SESSION['message'] = 'La contraseña nueva no coincide ';
                $_SESSION['message-type'] = 'warning';

            }
        }
        //si no coincide
    } else {
        $_SESSION['message'] = 'Tu contraseña actual no coincide';
        $_SESSION['message-type'] = 'warning';

    }

}


?>

<div class="container" style="background-color:#fff">

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }
    ; ?>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-md-12">
            <h2>Cambiar contraseña</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 div-form">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="passwordActual" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="passwordActual" name="pass-actual" required>
                    <span id="usuario"></span>
                </div>
                <div class="mb-3">
                    <label for="passwordNueva" class="form-label">Contraseña nueva</label>
                    <input type="password" class="form-control" id="passwordNueva" name="pass-nueva" required>
                    <span id="usuario"></span>
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmar" class="form-label">Repetir contraseña nueva</label>
                    <input type="password" class="form-control" id="passwordConfirmar" name="pass-confirm" required>
                    <span id="usuario"></span>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" name="editar-pass" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
</div>