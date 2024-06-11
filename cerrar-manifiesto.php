<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id_manifiesto'])) {
    $id_manifiesto = $_GET['id_manifiesto'];

    $query = "UPDATE manifiesto set estado_id = '2'  WHERE id_manifiesto = $id_manifiesto";
    $resultado = mysqli_query($conexion, $query);
    if (!$resultado) {
        die("Query failed");
    } else {
        // seleccionar todos los numeros de guia contenidos en el manifiesto, y con ciclo mientras ponerle a cada uno estdo en 3. cerrado

    }
    $query_guias_anteriores = "SELECT * FROM manif_embarq WHERE manifiesto_id=$id_manifiesto";
    $result_guias = mysqli_query($conexion, $query_guias_anteriores);

    //recorrer tabla
    while ($rowG = mysqli_fetch_array($result_guias)) {
        $guia = $rowG['guia_id'];
        $query = "UPDATE guia_embarque set estado_id = '3'  WHERE id_guia = $guia";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die("Query failed");
        } else {
            $_SESSION['message'] = "Registro modificado con exito";
            $_SESSION['message-type'] = 'success';
            header('Location: manifiesto.php');
        }

        $_SESSION['message'] = "Registro modificado con exito";
        $_SESSION['message-type'] = 'success';
        header('Location: manifiesto.php');
    }
}
?>