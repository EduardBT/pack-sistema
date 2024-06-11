<?php
include("session.php");
include("conexion.php");

if (isset($_GET['id'])) {
    $id_guia = $_GET['id'];
    $query = "SELECT * FROM guia_embarque WHERE id_guia = $id_guia";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $peso_real = $row['peso_real'];
        $cod_origen = $row['cod_origen'];
        $cod_destino = $row['cod_destino'];
        $fecha = $row['fecha_emb'];
        $valor = $row['valor_mercancia'];
        $tipo_bulto = $row['tipo_bulto'];
        $num_bulto = $row['cantidad_bulto'];
        $empaquetado = $row['empaquetado'];
        $peso_volumetrico = $row['peso_volumetrico'];
        $icontem = $row['incotem'];
        $destinatario = $row['personasDest_id'];
        $remitente = $row['personasEnv_id'];
        $descripcion = $row['descripcion'];
    }

    if ($peso_real >= $peso_volumetrico)
        $peso = $peso_real;
    else
        $peso = $peso_volumetrico;

    switch ($empaquetado) {
        case 1: /* si el envio será retractilado. Se cobra 1.78 dolares por bulto  */
            $importe_empaquetado = 1.78 * $num_bulto;
            break;
        case 2: /* si es empaquetado, quiere decir que llevará además de retractitado, caja y/o bolsa con el nilon fin.  Se cobra 2.89 dolares por bulto */
            $importe_empaquetado = 2.89 * $num_bulto;
            break;
        default:
            $importe_empaquetado = 0; /* no consume empaquetado */
    }

    if ($tipo_bulto == 'APX' or $tipo_bulto == 'DOX') {    /* Si el tipo de bulto es acompañado o documento */

        if ($peso <= 30) /* si el peso supera los 3o kilos, toma la tarifa de 30*/{
            $queryTarifaPais = "SELECT * FROM  cod_pais INNER JOIN  tarifario ON cod_pais.zona=tarifario.zona WHERE cod_pais.id_pais='$cod_destino' AND tarifario.kg>= $peso LIMIT 1";
            $precio_excedenteKg = 0;
            $dif_x_peso = 0;
        } else {
            $queryTarifaPais = "SELECT * FROM  cod_pais INNER JOIN  tarifario ON cod_pais.zona=tarifario.zona WHERE cod_pais.id_pais='$cod_destino' AND tarifario.kg>= 30 LIMIT 1";
            /* se busca en tarifario el precio de excedente por kilo segun zona de envio y se multiplica por el numero de jilos q se excede */
            $queryTarifaExceso = "SELECT * FROM  cod_pais INNER JOIN  tarifario ON cod_pais.zona=tarifario.zona WHERE cod_pais.id_pais='$cod_destino' AND tarifario.kg = 0 ";
            $resultadoTarifaExceso = mysqli_query($conexion, $queryTarifaExceso);
            if (mysqli_num_rows($resultadoTarifaExceso) == 1) {
                $rowTarifaExceso = mysqli_fetch_array($resultadoTarifaExceso);
                $precio_excedenteKg = $rowTarifaExceso['precio'];
                $dif_x_peso = ($peso - 30) * $precio_excedenteKg;
            } else { // si no se consigue valor en el tarifario
                $_SESSION['message'] = 'No se encuentra  tarifario para este destino';
                $_SESSION['message-type'] = 'warning';

                header("Location: guia.php");
            }
        }
        $resultadoTarifa = mysqli_query($conexion, $queryTarifaPais);
        if (mysqli_num_rows($resultadoTarifa) == 1) {
            $rowTarifa = mysqli_fetch_array($resultadoTarifa);
            if ($cod_destino <> 6) { /* si el pais es distinto de CUB, aplica porcetaje de ganacia adicional */
                $precio_tipo = 0.07; /* porcentaje de ganancia q se aplica actualmente*/
                $importe_tarifario = $rowTarifa['precio'];
                $importe_tipo = $importe_tarifario * $precio_tipo; /* el porcentaje de ganancia q se aplica actualmente, puede ser cambiar pero el la tabla factura queda guardado el caálculo q se tomó en ese momento */
            } else { /* si el pais es Cuba */
                $precio_tipo = 0; /* porcentaje de ganancia q se aplica actualmente*/
                $importe_tarifario = $rowTarifa['precio'];
                $importe_tipo = $importe_tarifario; /* actualmete el pordentaje de ganancia ya esta aplicado en la tabla tarifario*/

            }
            $consultaFactura = "SELECT * FROM factura WHERE guia_id='$id_guia' ";
            $consultaFact = mysqli_query($conexion, $consultaFactura);
            if (mysqli_num_rows($consultaFact) == 0) // si no se encuentra registrada la persona, lo registra
            {
                $query = "INSERT INTO factura(fecha,precio_tipo,importe_tipo, importe_empaquetado, importe_tarifario, precio_excedenteKg ,dif_x_peso,guia_id,usuario_id) VALUES ('$fecha','$precio_tipo','$importe_tipo','$importe_empaquetado','$importe_tarifario','$precio_excedenteKg','$dif_x_peso','$id_guia',1)";

                //almacenar valores
                $resultado = mysqli_query($conexion, $query);

                if (!$resultado) {
                    die("Query failed");
                } else {
                    $Factura = "SELECT * FROM factura WHERE guia_id='$id_guia' ";
                    $rowFactura = mysqli_query($conexion, $Factura);
                    if (mysqli_num_rows($rowFactura) == 1) {
                        $rowFact = mysqli_fetch_array($rowFactura);
                        $fact = $rowFact['id_factura'];
                        /* $_SESSION['message']= 'Factura guardada'; $_SESSION['message-type'] = 'success'; header('Location: guia.php');*/
                        header("Location: reportes/factura.php?id_guia='$id_guia'&id_factura='$fact'");
                    }
                }
            } else { // si la guia ya posee una factura registrada, envía mensaje de que ya existe
                $_SESSION['message'] = "La guia ya posee una factura registrada";
                $_SESSION['message-type'] = 'warning';

                header("Location: guia.php");
            }
        } else { // si no se consigue valor en el tarifario
            $_SESSION['message'] = 'No se encuentra  tarifario para este destino';
            $_SESSION['message-type'] = 'warning';

            header("Location: guia.php");

        }

    } else {  /* Si el tipo de emarque es acompañado */
        $precio_tipo = 100; /*dolares */
        $importe_tipo = $precio_tipo; /*dolares */
        $importe_tarifario = 350; /*dolares */
        $precio_excedenteKg = 0; /*dolares si no hay excedente, no se muestra valor */
        if ($peso > 40) {
            $precio_excedenteKg = 9;
            $dif_x_peso = ($peso - 40) * $precio_excedenteKg;
        }
        $consultaFactura = "SELECT * FROM factura WHERE guia_id='$id_guia' ";
        $consultaFact = mysqli_query($conexion, $consultaFactura);
        if (mysqli_num_rows($consultaFact) == 0) // si no se encuentra registrada la persona, lo registra
        {
            $query = "INSERT INTO factura(fecha,precio_tipo,importe_tipo, importe_empaquetado, importe_tarifario, precio_excedenteKg ,dif_x_peso,guia_id,usuario_id) VALUES ('$fecha','$precio_tipo','$importe_tipo','$importe_empaquetado','$importe_tarifario','$precio_excedenteKg','$dif_x_peso','$id_guia',1)";

            //almacenar valores
            $resultado = mysqli_query($conexion, $query);

            if (!$resultado) {
                die("Query failed");
            } else {
                /*la factura a sido generada y se buscará su numero para imprimirla */
                $Factura = "SELECT * FROM factura WHERE guia_id='$id_guia' ";
                $rowFactura = mysqli_query($conexion, $Factura);
                if (mysqli_num_rows($rowFactura) == 1) {
                    $rowFact = mysqli_fetch_array($rowFactura);
                    $fact = $rowFact['id_factura'];
                    /* $_SESSION['message']= 'Factura guardada'; $_SESSION['message-type'] = 'success'; header('Location: guia.php');*/
                    header("Location: reportes/factura.php?id_guia='$id_guia'&id_factura='$fact'");
                }
            }
        } else { // si la guia ya posee una factura registrada, envía mensaje de que ya existe
            $_SESSION['message'] = "La guia ya posee una factura registrada";
            $_SESSION['message-type'] = 'warning';

            header("Location: guia.php");
        }

    }

}

?>