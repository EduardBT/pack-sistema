<?php
include("session.php");
include("conexion.php");

if (isset($_POST['guardar_destinatario'])) {

    $dni = $_POST['dni'];
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $residencia = $_POST['direccion'];
    $calle = "Calle: " . $_POST['calle'] . ". ";
    $entre = "Entre: " . $_POST['entre'] . ". ";
    $no_resid = "No: " . $_POST['num'] . ". ";
    $edificio = "Edificio: " . $_POST['edificio'] . ". ";
    $apartatamento = "Apartamento: " . $_POST['apartamento'] . ". ";

    $direccion = '';

    if (!empty($_POST['calle'])) {
        $direccion .= $calle;
    }

    if (!empty($_POST['entre'])) {
        $direccion .= $entre;
    }

    if (!empty($_POST['num'])) {
        $direccion .= $no_resid;
    }

    if (!empty($_POST['edificio'])) {
        $direccion .= $edificio;
    }

    if (!empty($_POST['apartamento'])) {
        $direccion .= $apartatamento;
    }

    if (!empty($_POST['direccion'])) {
        $direccion .= $residencia;
    }

    $tel = $_POST['tel'];
    $pais = $_POST['pais'];
    $provincia = $_POST['provincia-select'];
    if ($_POST['departamento'] == "") {
        $departamento = $_POST['departamentos'];
    } else {
        $departamento = $_POST['departamento'];
    }

    $cod_postal = $_POST['cod_postal'];
    $correo = $_POST['correo'];
    $regreso = $_POST['regreso'];

    $consultaPersona = "SELECT * FROM personas WHERE dni='$dni' ";
    $consulta = mysqli_query($conexion, $consultaPersona);
    if (mysqli_num_rows($consulta) == 0) // si no se encuentra registrada la persona, lo registra
    {
        $query = "INSERT INTO personas(dni, nombre, apellidos, direccion,tel,pais,departamento,cod_postal,correo,rol,provincia,fecha_nacimiento) VALUES ('$dni', '$nombre','$apellidos','$direccion','$tel','$pais','$departamento','$cod_postal', '$correo', 'destinatario','$provincia','$fecha_nacimiento')";
        //Almacenar valores
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die("Query failed");
        } else {
            $_SESSION['message'] = '¡Registro guardado con éxito!';
            $_SESSION['message-type'] = 'success';
            if ($regreso == "destinatario") {
                header('Location: multi_embarque.php');
            } else {
                header('Location: destinatario.php');
            }
        }
    } else {
        // Si la persona se encuentra registrada con usuario, envía mensaje de que ya existe
        $_SESSION['message'] = "El destinatario ya se encuentra registrado";
        $_SESSION['message-type'] = 'warning';

        if ($regreso == "remitente") {
            header('Location: multi_embarque.php');
        } else {
            header('Location: destinatario.php');
        }
    }
}
?>