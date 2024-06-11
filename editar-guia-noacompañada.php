<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $guiaAWB=$_GET['guiaAWB'];

    $query = "UPDATE guia_embarque set numero = '$guiaAWB'  WHERE id_guia = $id";
    $resultado= mysqli_query($conexion, $query);
    if (!$resultado) {
        die("Query failed");
    } else {
        $_SESSION['message'] = "Registro modificado con exito";
        $_SESSION['message-type'] = 'success';
        header('Location: guia.php');
    }
}    
?>