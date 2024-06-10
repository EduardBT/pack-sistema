<?php
include_once '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';


use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
include "../conexion.php";



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM guia_embarque WHERE id_guia = $id";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $id_guia = $row['id_guia'];
        $peso_real = $row['peso_real'];
        $cod_origen = $row['cod_origen'];
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

}

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pack Express</title>
    <meta name="keywords" content="">
    <meta name="description" content="Gestión de Cheques">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--iconos-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        table {
            width: auto;
            margin-left: auto;
            margin-right: auto;
            font-size: 12px;
            font-family: Arial, sans-serif;
            /* Set the font-family to Arial */
            text-align: left;
            vertical-align: middle;
            font-weight: bold;
            border-collapse: collapse;
            border: 4px solid black;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            font-family: Arial, sans-serif;
            /* Set the font-family to Arial */
        }

        th {
            background-color: #f2f2f2;
        }

        .guia {
            text-align: center;
        }

        .bd-placeholder-img {
            font-size: 1.215rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            font-family: Arial, sans-serif;
            /* Set the font-family to Arial */
        }

        @media (max-width: 400px) {
            .bd-placeholder-img-lg {
                font-size: 3.2rem;
            }
        }

        @media print {
            #image-container {
                display: block !important;
            }
        }

        p {
            font-size: 11.8px;
            text-align: left;
            font-family: Arial, sans-serif;
            /* Set the font-family to Arial */
        }

        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }

        #image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130px;
        }

        #image-container img {
            max-width: 100%;
            max-height: 90%;

        }
    </style>



</head>

<body>
    <!-- First Page -->
    <div id="sizer" style="height: 400px; ">
        <div class="row">
            <div style="text-align: center;">
                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/pack-sistema/img/Feriban.jpg"
                    style="max-width: 150px; margin-top: 5px;">
            </div>
            <div class="col-xs-12">
                <h4 style="text-align:center"><u> Declaración General de Seguridad</u></h4>
                <br>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-6">
                <p>Señores</p>
                <p><strong>Copa Airlines/Feriban</strong></p>
            </div>
            <div class="col-xs-6">
                <p>Montevideo,
                    <?php
                    echo date('F j, Y'); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <p><u> Presente</u></p>
                <p>Mediante la presente, yo </p>
                <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona = mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) { ?>
                    <p>CI Nro.:
                        <?php echo $rowPersona['dni']; ?>
                    </p>
                    <?php
                }
                ?>
            </div>
            <div class="col-xs-6">
                <p>Ref. Nro. Guía /
                    <?php $length = 9;
                    $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length);
                    echo 'CM' . $guia . 'PK'; ?>
                </p>
                <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona = mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) { ?>
                    <p>
                        <?php echo $rowPersona['nombre'] . " " . $rowPersona['apellidos']; ?>
                    </p>
                    <?php
                }
                ?>
            </div>
        </div>
        <div style="border-top:black 1px solid">
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">
                <p>“Certifico que este embarque no contiene ningún producto explosivo, mercancías peligrosas o aparato
                    destructivo <strong> NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES.</strong> Estoy consciente de que
                    este embarque está sujeto a los respectivos controles de seguridad Aérea y otras Regulaciones
                    Gubernamentales: Asimismo, soy consciente que esta declaración y firma original así como el resto de
                    los documentos de este embarque se mantendrán en archivo hasta que el embarque sea entregado al
                    consignatario.”</p>
                <p>“Soy consciente y acepto que dada la emergencia sanitaria, existen retrasos en los envíos, siendo
                    indefinido el arribo de la misma a su destino final”</p>
                <p>“Adicionalmente autorizo al personal de Feriban S.A. a realizar cualquier gestión en nuestro nombre
                    ante la Dirección de Aduanas del Uruguay”</p>

                <br>________________________________</br>
                <p>Firma/Signature y Sello/Seal</p>

                <p><strong> Nota:</strong> El firmante debe adjuntar a la presente fotocopia de un documento de
                    identidad con su fotografía y presentar el original para la verificación de su firma.</p>
            </div>
        </div>




        <input type="hidden" name="guia" id="guia" generarFactura()value=<?php echo $id_guia; ?>>

        <div class="row">
            <div style="text-align: center;">
                <br>
                <p style="color:#767676 ;text-align: center;"> FERIBAN S.A. <br>Aeropuerto Int´l. de Carrasco<br>TCU of
                    116<br>Tel./Fax: (598) 26009915 - 26002118<br>Montevideo - Uruguay</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h4 style="text-align:center"><u>NOTA DE DESCARGO DE RESPONSABILIDAD</u></h4>
                <br>
                <div style="flex-grow: 1; border-left: black 1px solid;">
                    <?php
                    $length = 9;
                    $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length);
                    echo 'CM' . $guia . 'PK';
                    ?>
                </div>
                <div style="margin-left: 40mm;">


                    <p style="text-align: justify; border-left: 1px solid black; padding-left: 10px;">
                        Por este medio certificamos que deslindamos de cualquier responsabilidad, sobre valor total, de
                        los artículos embarcados bajo la guía
                        a los Señores de Copa Airlines Courier, dado que los productos declarados están fuera del cuadro
                        de artículos permitidos para el transporte por esta empresa o presentan un embalaje inadecuado
                        para su transporte.
                    </p>
                </div>
                <br>
                <div style="border-top:black 1px solid">
                </div>




                <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona = mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) { ?>
                    <p>Persona:
                        <?php echo $rowPersona['nombre'] . " " . $rowPersona['apellidos']; ?>
                    </p>
                    <?php
                }
                ?>
                <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona = mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) { ?>
                    <p>C.I:
                        <?php echo $rowPersona['dni']; ?>
                    </p>
                    <?php
                }
                ?>
                <p>Firma:_____________________</p>
                <p>Fecha:
                    <?php
                    echo date('F j, Y'); ?>
                </p>
                <div class="page-break"></div>
            </div>
        </div>
    </div>



    <!--declaracion general-->

    <?php
    $html = ob_get_clean();
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);

    // Set the PDF page size to match the fixed-size container
    $dompdf->setPaper('400px', '0px', 'portrait');


    $dompdf->render();
    $dompdf->stream("reportes.pdf", array("Attachment" => false));
    ?>
</body>

</html>