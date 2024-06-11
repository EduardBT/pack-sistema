<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $consultaPersona = "SELECT * FROM guia_embarque WHERE personasEnv_id='$id' or personasDest_id='$id' ";
    $consulta = mysqli_query($conexion, $consultaPersona);
    if (mysqli_num_rows($consulta) == 0) // si no existe guia de embaque asociada 
    {
        $query = "DELETE FROM personas WHERE id_persona = $id";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            $_SESSION['message'] = "No se puede eliminar el cliente, envíos registrados a su nombre.";
            $_SESSION['message-type'] = 'warning';

            header("Location: gestion.php");
        } else {
            $_SESSION['message'] = 'Registro eliminado con éxito';
            $_SESSION['message-type'] = 'success';

            header("Location: gestion.php");
        }
    } else {
        $_SESSION['message'] = "No se puede eliminar el cliente, envios registrados a su nombre.";
        $_SESSION['message-type'] = 'warning';

        header("Location: gestion.php");
    }
}

?>