<?php
include_once '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';


use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
include "../conexion.php";
require_once('phpqrcodemaster/qrlib.php');
// Replace with the actual directory path
$directory = "../phpqrcodemaster/temp/";


// Fetch the list of files in the directory
$fileList = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);



// Sort the file list in descending order by file modified time
usort($fileList, function ($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Get the last image file
$lastImage = reset($fileList);



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
            width: 930px;
            margin-left: auto;
            margin-right: auto;
            font-size: 30px;
            font-family: Calibri, Arial, sans-serif;
            text-align: left;
            vertical-align: middle;
            font-weight: bold;
            height: 530px;
            table-layout: fixed;
            border-collapse: collapse;
            border: 2px solid black;
            margin: 0 auto;
        }

        td {
            padding: 0;
            text-align: center;
            vertical-align: middle;
            margin-left: 5mm;
        }

        td p {
            font-weight: bold;
            font-size: 25px;
            margin: 0;
            margin-left: 5mm;
        }

        th,
        td {
            border: 2px solid black;
            padding: 0px;
            font-family: Calibri, Arial, sans-serif;
            padding: 0;
            text-align: center;
            vertical-align: middle;
            margin: 0;
        }

        th {
            background-color: #f2f2f2;
        }

        .guia {
            text-align: center;
        }

        .bd-placeholder-img {
            font-size: 1.225rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            font-family: Calibri, Arial, sans-serif;
            border: 0;
            margin: 0;
            padding: -2;
        }

        @media (min-width: 130px) {
            .bd-placeholder-img-lg {
                font-size: 3.8rem;
            }
        }

        @media print {
            #image-container {
                display: block !important;
            }
        }

        p {
            font-size: 60px;
            text-align: left;
            font-family: Calibri, Arial, sans-serif;
            border: 0;
            margin: 0;
            padding: -2;
        }

        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: -2;
        }

        #image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130px;
        }

        #qrcode {
            margin-left: 150px;
        }

        #image-container img {
            max-width: 100%;
            max-height: 200%;
        }

        .page-break {
            page-break-before: always;
        }

        .centered-cell {
            font-weight: bold;
            font-size: 25px;
            text-align: center;
            vertical-align: middle;
            vertical-align: top center;
        }

        .barcode {
            color: black;
            font-weight: bold;
            font-size: 45px;
            text-align: center;
            vertical-align: middle;
            align-items: middle;
        }

        .info-container {
            display: flex;
            align-items: center;
            font-size: 42px;
            font-weight: bold;
            color: black;
            text-align: left;
            vertical-align: top;
            margin-left: 2mm;

        }

        .info-container p {
            margin: 0;
            margin-left: 2mm;
        }
    </style>



</head>

<body>



    <table>
        <tr>
            <td style="text-align: center; vertical-align: top; font-weight: bold;">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img src="../img/iso2.png" style="max-width: 80px; margin-right: 15px;">
                    <h1 style="font-size:50px"><strong>PACK EXPRESS URUGUAY</strong></h1>
                </div>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: top; font-weight: bold;">
                <div id="image-container">
                    <?php
                    $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                    $resultadoDest = mysqli_query($conexion, $queryDest);
                    //$codPais = $rowPais['codigo'];
                    $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
                    // $codPais = $rowPais['codigo'];
                    $length = 9;
                    $secoundrow = 'CU';
                    $segoundrow = 'UY';
                    $string = substr(str_repeat(0, $length) . $id_guia, -$length);
                    $codigoBarra = $secoundrow . $string . $segoundrow;
                    echo '<p style="color: black; text-align: center; vertical-align: top; font-weight: bold; font-size: 75px;"><strong>' . $codigoBarra . '</strong></p>';
                    ?>
                    <div style="text-align: center;">
                        <div id="image-container">
                            <div id="qrcode"></div>
                        </div>

                    </div>
                </div>

            </td>
        </tr>
        <tr>
            <td style="text-align: left; vertical-align: top; font-weight: bold; font-size: 42px;color: black;">
                <div>
                    <?php
                    $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                    $resultadoDest = mysqli_query($conexion, $queryDest);
                    while ($rowDest = $resultadoDest->fetch_assoc()) {
                        ?>
                        <?php echo '<p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 45px;"><strong>' . $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?></strong>
                        </p>
                        <div class="info-container">
                            <p
                                style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 45px;">
                                CI: <strong>
                                    <?php echo '<p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 45px;"><strong>' . $rowDest['dni']; ?>
                                </strong></p>
                        </div> <br> <!-- Add a line break here -->
                        <p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 42px;">
                            Teléfono: <strong>
                                <?php echo $rowDest['tel']; ?>
                            </strong></p>
                        <br> <!-- Add a line break here -->

                        <p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 42px;">
                            Dirección: <strong>
                                <?php echo $rowDest['direccion'] . '
                 &nbsp;&nbsp;' . $rowDest['departamento']; ?>
                            </strong></p>
                        <p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 42px;">
                            Código Postal: <strong>
                                <?php echo $rowDest['cod_postal']; ?>
                            </strong></p>
                    </div>
                <?php } ?>
                </div>
            </td>
        </tr>

        <tr>
            <td style="text-align: left; vertical-align: left; font-weight: bold;font-size: 36px;">
                <div>
                    <p><strong>
                            <?php
                            $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                            $resultadoDest = mysqli_query($conexion, $queryDest);
                            while ($rowDest = $resultadoDest->fetch_assoc()) {
                                echo '<span style="color: black; text-align: left; vertical-align: left; font-weight: bold; font-size: 36px;"><strong>' . $rowDest['departamento'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['numero'];
                            } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>

                    </strong>
                </div>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; vertical-align: top; font-weight: bold;font-size: 36px;">
                <div>
                    <?php
                    $queryEnvia = "SELECT * FROM personas WHERE id_persona = $remitente";
                    $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                    while ($rowEnv = $resultadoEnv->fetch_assoc()) {
                        ?>
                        <p><strong
                                style="color: black; font-family: Arial, sans-serif; font-size: 30px;">Remitente:</strong>
                            <?php echo '<p style="color: black; text-align: left; vertical-align: top; font-weight: bold; font-size: 38px;"><strong>' . $rowEnv['nombre'] . ' ' . $rowEnv['apellidos'];
                            ?>
                        </p>
                        <div>
                </td>
            </tr>

            <tr>
                <td style="text-align: center;color: black; vertical-align: top; font-weight: bold; font-size: 32px;">
                    <div>
                        <p><strong style="color: black; font-family: Arial, sans-serif; font-size: 32px;">Peso(kg):</strong>
                            <?php echo '<span style="color: black;  font-weight: bold; vertical-align: top; font-size: 32px;"><strong>' . $row['peso_real'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . '<span style="color: black;text-align: right;  font-weight: bold; vertical-align: top; font-size: 36px;"><strong>' . $row['descripcion'];
                    } ?>
                    </p>



                    </strong></p>
                </div>
            </td>
        </tr>
        </strong></p>';


        </div>
        </td>
        </tr>
        <tr>
            <td class="centered-cell"
                style="width:270px;
    height:150px;
    margin-left:320px;text-align: center; vertical-align: middle; font-weight: bold; font-size: 5px; table-layout: fixed; border-collapse: collapse; border: 2px solid black; margin: 0 auto;">
                <div style="display: flex; flex-direction: column; align-items: center;width:610px;
    height:150px;
    margin-left:320px;">
                    <?php
                    $queryPais = "SELECT * FROM cod_pais WHERE id_pais = $cod_origen";
                    $resultadoPais = mysqli_query($conexion, $queryPais);
                    while ($rowPais = $resultadoPais->fetch_assoc()) {
                        ?>
                        <div style="text-align: center;">
                            <?php
                            $codPais = $rowPais['codigo'];
                            $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
                            $codPais = $rowPais['codigo'];
                            $length = 9;
                            $secoundrow = 'CU';
                            $segoundrow = 'UY';
                            $string = substr(str_repeat(0, $length) . $id_guia, -$length);
                            $codigoBarra = $secoundrow . $string . $segoundrow;
                            ?>

                            <p class="image-container img"
                                style="FONT-WEIGHT: 100;font-size:100;position:relative;width:612px;height: 60px;">
                                <?php echo $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128) . $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128); ?>
                            </p>

                        </div>


                    </div>
                    <?php echo '<span style="color: black; text-align: center; vertical-align: center; font-weight: bold; font-size: 45px;"><strong>' . $codigoBarra;
                    } ?>
                </p>

            </td>
        </tr>
    </table>


    <tr>
        <td>
            <?php echo '<a href="http://packexpress.com.uy/pack-sistema/phpqrcodemaster/index.php? ">Genera QR</a>';



            ?>
        <td>
    <tr>
        <script src="../js/qrcode.js"></script>
        <script type="text/javascript">
            <?php
            $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
            $resultadoDest = mysqli_query($conexion, $queryDest);
            if ($resultadoDest) {
                $rowDest = mysqli_fetch_assoc($resultadoDest);
                $dni = $rowDest['dni'];
                $nombre = $rowDest['nombre'];
                $apellido = $rowDest['apellidos'];
                $direccion = $rowDest['direccion'];
                $codigoPostal = $rowDest['cod_postal'];
                $telefono = $rowDest['tel'];
                $departamento = $rowDest['departamento'];
            }

            $queryRem = "SELECT * FROM personas WHERE id_persona = $remitente";
            $resultadoRem = mysqli_query($conexion, $queryRem);
            if ($resultadoRem) {
                $rowRem = mysqli_fetch_assoc($resultadoRem);
                $nombrerem = $rowRem['nombre'];
                $apellidorem = $rowRem['apellidos'];
            }

            ?>
            let dni = "<?php echo isset($dni) ? $dni : ''; ?>";
            let nombre = "<?php echo isset($nombre) ? $nombre : ''; ?>";
            let apellido = "<?php echo isset($apellido) ? $apellido : ''; ?>";
            let direccion = "<?php echo isset($direccion) ? $direccion : ''; ?>";
            let codigoPostal = "<?php echo isset($codigoPostal) ? $codigoPostal : ''; ?>";
            let telefono = "<?php echo isset($telefono) ? $telefono : ''; ?>";
            let departamento = "<?php echo isset($departamento) ? $departamento : ''; ?>";
            let peso_real = "<?php echo isset($peso_real) ? $peso_real : ''; ?>";
            let descripcion = "<?php echo isset($descripcion) ? $descripcion : ''; ?>";

            let nombrerem = "<?php echo isset($nombrerem) ? $nombrerem : ''; ?>";
            let apellidorem = "<?php echo isset($apellidorem) ? $apellidorem : ''; ?>";


            let texto = `Dest.: ${nombre} ${apellido}\nCI: ${dni}\nTel.: ${telefono}\nDir.: ${direccion}\nDpto.: ${departamento}\nCódigo Postal: ${codigoPostal}\nPeso(Kg): ${peso_real}\nDesc.:${descripcion}\nRemit.:${nombrerem}`;
            // let texto = `Dest.: ${nombre} ${apellido}\nCI: ${dni}\nTel.: ${telefono}\nDir.: ${direccion}\nDpto.: ${departamento}\nCódigo Postal: ${codigoPostal}\nPeso(Kg): ${peso_real}\nDesc.:${descripcion}\nRemit.:${nombrerem} ${apellidorem}`;
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: texto,
                width: 128,
                height: 128,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        </script>
</body>

</html>