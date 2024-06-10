<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM guia_embarque WHERE id_guia = $id";
    $resultado = mysqli_query($conexion, $query);
    if (!$resultado) {
        $_SESSION['message'] = "No se puede eliminar el registro";
        $_SESSION['message-type'] = 'warning';
        header("Location: guia.php");
    } else {
        $_SESSION['message'] = 'Registro eliminado con éxito';
        $_SESSION['message-type'] = 'success';

        header("Location: guia.php");
    }
}
?>