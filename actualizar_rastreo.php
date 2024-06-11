<?php
include "session.php";
include "conexion.php";


$idManifiesto = $_POST['id_manifiesto'];
$query = "SELECT m.id_manifiesto, m.numero, m.llegada_pan, m.llegada_cub
          FROM manifiesto AS m
          INNER JOIN manif_embarq AS me ON m.id_manifiesto = me.manifiesto_id";
$result = mysqli_query($conexion, $query);
while ($rowManif = mysqli_fetch_assoc($result)) {
    print_r($rowManif);
}

if (isset($_POST['llegada_pan'])) {
    $llegadaPan = $_POST['llegada_pan'];
    $query = "UPDATE manifiesto SET llegada_pan = '$llegadaPan' WHERE id_manifiesto = $idManifiesto";
    mysqli_query($conexion, $query);
}

if (isset($_POST['llegada_cub'])) {
    $llegadaCub = $_POST['llegada_cub'];
    $query = "UPDATE manifiesto SET llegada_cub = '$llegadaCub' WHERE id_manifiesto = $idManifiesto";
    mysqli_query($conexion, $query);
}


?>