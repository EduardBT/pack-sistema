<?php
include("session.php");
include("conexion.php");

//Trae los datos de la base
if (isset($_GET['id_manifiesto'])) {
    $id_manifiesto = $_GET['id_manifiesto'];
    //Actualizar datos
    $query_guias_anteriores = "SELECT guia_id,manifiesto_id FROM manif_embarq WHERE manifiesto_id=$id_manifiesto";
    $result_guias = mysqli_query($conexion, $query_guias_anteriores);
    //Recorrer tabla
    while ($rowG = mysqli_fetch_array($result_guias)) {
        $guia = $rowG['guia_id'];
        $query = "UPDATE guia_embarque set estado_id = 1  WHERE id_guia = $guia";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die("Query failed eliminando el manifiesto");
        } else {
        }
    }
    $query = "DELETE FROM manif_embarq WHERE manifiesto_id=$id_manifiesto";
    $resultado = mysqli_query($conexion, $query);
    
    $queryR = "DELETE FROM rastreo WHERE manifiesto_id=$id_manifiesto";
    $resultadoR = mysqli_query($conexion, $queryR);
    
    if (!$resultado) {
        die("Query failed elimando las guis asociadas");
    } else {
        $query = "DELETE FROM manifiesto WHERE id_manifiesto=$id_manifiesto";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die("Query failed eliminando el manifiesto");
        } else {
            $_SESSION['message'] = "Registro eliminado con éxito";
            $_SESSION['message-type'] = 'success';
            header('Location: manifiesto.php');
        }
    }
} ?>
<?php
include_once("includes/header.php");
include_once("includes/sidebar.php");
?>