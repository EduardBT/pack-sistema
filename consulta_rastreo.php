<?php
include "session.php";
include "conexion.php";

$queryrast = "SELECT id, manifiesto_id, fecha_hora, hito FROM rastreo";
$resultrast = mysqli_query($conexion, $queryrast);

$rastreosAgrupados = array();

while ($rowRastreo = mysqli_fetch_array($resultrast)) {
    $manifiesto_id = $rowRastreo['manifiesto_id'];

    if (!isset($rastreosAgrupados[$manifiesto_id])) {
        $rastreosAgrupados[$manifiesto_id] = array();
    }

    $rastreosAgrupados[$manifiesto_id][] = array(
        'id' => $rowRastreo['id'],
        'fecha_hora' => $rowRastreo['fecha_hora'],
        'hito' => $rowRastreo['hito']
    );
}

$response = array(
    'rastreosAgrupados' => $rastreosAgrupados
);

header('Content-Type: application/json');
// echo json_encode($response);

if (isset($_POST['guardar_rastreo'])) {

     $manifiestoId = $_POST['id_manifiesto'];
     $ultimoManifiesto = end($rastreosAgrupados);
     $ultimoID = end($ultimoManifiesto)['id'];
     $newID = $ultimoID + 1;

     $query_verificar = "SELECT COUNT(*) AS existencia FROM rastreo WHERE manifiesto_id = '$manifiestoId'";
     $resultado_verificar = mysqli_query($conexion, $query_verificar);
     $row_verificar = mysqli_fetch_assoc($resultado_verificar);
     $existencia_manifiesto = $row_verificar['existencia'];
        
    if ($existencia_manifiesto > 0) {
        $queryDelete = "DELETE FROM rastreo WHERE manifiesto_id = '$manifiestoId'";
        $resultadoDelete = mysqli_query($conexion, $queryDelete);
    }
    

    for ($i = 1; $i <= 9; $i++) {
        $fechaHora = $_POST['fecha' . $i];
        $hito = $_POST['hito' . $i];

        if ($existencia_manifiesto > 0) {
            if ($fechaHora != null && $hito != null) {
                
                $query = "INSERT INTO rastreo (id, manifiesto_id, fecha_hora, hito) VALUES ('$newID', '$manifiestoId', '$fechaHora', '$hito')";
                $resultado = mysqli_query($conexion, $query);
            }
        } else {
            if ($fechaHora != null && $hito != null) {
                $query = "INSERT INTO rastreo (id, manifiesto_id, fecha_hora, hito) VALUES ('$newID', '$manifiestoId', '$fechaHora', '$hito')";
                $resultado = mysqli_query($conexion, $query);
            }
        }

    }
   header('Location: manifiesto.php');
}

?>