<?php
include("session.php");
include("conexion.php");

if (isset($_POST['manifiesto'])) { //Validacion de envio de formulario
    if (!empty($_POST['guia'])) { // si al menos hay una guia seleccionada, CREA EL MANIFIESTO
        $vuelo = $_POST['vuelo'];
        $numero = $_POST['numero'];
        $expedidor = $_POST['expedidor'];
        $consignatario = $_POST['consignatario'];
        $fecha = '2022-02-14';
        $cod_origen = $_POST['cod_origen'];
        $cod_destino = $_POST['cod_destino'];

        foreach ($_POST['guia'] as $guia) { // Ciclo para mostrar las casillas checked checkbox. IMPORTANTE: asigna a la variable id_guia los distintos valores de las guia a incluir en el manifiesto
            //echo $id_guia."</br>";// Imprime resultados
            $query = "SELECT * FROM guia_embarque WHERE id_guia = $guia";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) == 1) {
                $rowTipo = mysqli_fetch_array($resultado);
                $tipo = $rowTipo['electronico'];
            }
        }

    $query = "INSERT INTO manifiesto(numero,vuelo,cod_origen,cod_destino, expedidor, consignatario, electronico,estado_id,fechaArribo ) VALUES ('$numero','$vuelo','$cod_origen','$cod_destino', '$expedidor', '$consignatario','$tipo',1,'$fecha_arribo')";
        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            die("Query failed");
        } else {
            $manifiesto = "SELECT  max(id_manifiesto) as id_manifiesto FROM manifiesto WHERE cod_origen='$cod_origen' and cod_destino='$cod_destino' ";
            $rowManifiesto = mysqli_query($conexion, $manifiesto);
            if (mysqli_num_rows($rowManifiesto) == 1) {
                $rowManif = mysqli_fetch_array($rowManifiesto);
                $Manif = $rowManif['id_manifiesto'];

                foreach ($_POST['guia'] as $id_guia) {
                    $query = "INSERT INTO manif_embarq(manifiesto_id,guia_id ) VALUES ('$Manif','$id_guia')";
                    $resultado = mysqli_query($conexion, $query);

                    if (!$resultado) {
                        die("Query failed di error insetando en manif embarq ");
                    } else {

                        $query = "UPDATE guia_embarque set estado_id = '2' WHERE id_guia = $id_guia";
                        mysqli_query($conexion, $query);
                        if (!$resultado) {
                            die("Query failed modificando la guia");
                        }
                    }

                }
            }
            $_SESSION['message'] = "Registro actualizado con éxito";
            $_SESSION['message-type'] = 'success';
            header('Location: manifiesto.php');
        }
    }
}
?>