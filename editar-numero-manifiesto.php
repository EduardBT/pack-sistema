<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id_manifiesto'])) {
    $id_manifiesto = $_GET['id_manifiesto'];
    $guiaAWB=$_GET['guiaAWB'];

    $query = "UPDATE manifiesto set numero = '$guiaAWB'  WHERE id_manifiesto = $id_manifiesto";
    $resultado= mysqli_query($conexion, $query);
    if (!$resultado) {
        die("Query failed");
    } else {

        $_SESSION['message'] = "Registro modificado con exito";
        $_SESSION['message-type'] = 'success';
        header('Location: manifiesto.php');
    }
}    
?>