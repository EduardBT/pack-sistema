<?php
include_once '../vendor/autoload.php' ;
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
usort($fileList, function($a, $b) {
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--iconos-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
    table {
        width: auto;
        margin-left: auto;
        margin-right: auto;
        font-size: 22px;
        font-family: Arial, sans-serif;
        text-align: left;
        vertical-align: middle;
        font-weight: bold;
        
        
        table-layout: fixed;
        border-collapse: collapse;
  border: 2px solid black;
  margin: 0 auto;
}

td {
  padding: 0;
  text-align: center;
  vertical-align: middle;
}

td p {
  font-weight: bold;
  font-size: 25px;
  margin: 0;
}

    

    th, td {
        border: 2px solid black;
        padding: 0px; /* Adjust the padding value as desired */
        font-family: Arial, sans-serif;
        padding: 0;
  text-align: center;
  vertical-align: middle;
        margin: 0;
       
    }

    th {
        background-color: #f2f2f2;
    }

    /* Other styles */

    .guia {
        text-align: center;
    }

    .bd-placeholder-img {
        font-size: 1.225rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        font-family: Arial, sans-serif;
        border: 0;
        margin: 0;
        padding: -2;
    }

    @media (min-width: 968px) {
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
        font-size: 20px;
        text-align: left;
        font-family: Arial, sans-serif;
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
        height: 150px;
    }

    #image-container img {
        max-width: 100%;
        max-height: 100%;
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
        font-size: 25px;
        text-align: center;
        vertical-align: middle;
        align-items: middle;
    }


</style>


      
    
</head>

<body>



<table >
<tr>
    
    <td style="text-align: center; vertical-align: top; font-weight: bold;"> 
    <div style="text-align: center;">
    <div id="centered-cell">
    <img src="http://<?php echo $_SERVER['HTTP_HOST'];  ?>/pack-sistema/img/logoULT.png" style="max-width: 260px; margin-top: 2px;">
</div>
  </tr>
<tr>
        <td style="text-align: center; vertical-align: top; font-weight: bold;">
            <div id="image-container">
            


                <?php
                $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                $resultadoDest = mysqli_query($conexion, $queryDest);
                $codPais = $rowPais['codigo'];
                $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
                $codPais = $rowPais['codigo'];
                $length = 9;
                $secoundrow = 'CU';
                $segoundrow = 'UY';
                $string = substr(str_repeat(0, $length).$id_guia, -$length);
                $codigoBarra = $secoundrow. $string.$segoundrow;
                echo '<p style="color: black; text-align: center; vertical-align: top; font-weight: bold; font-size: 32px;"><strong>' . $codigoBarra . '</strong></p>';

                include "/phpqrcodemaster/qrlib.php";

                $qrCodeText = $rowdest['pais'].$rowdest['nombre'].$rowdest['apellidos'].$rowdest['tel'].$rowdest['direccion'].$rowdest['dni'];// The text to encode in the QR code

                ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style="text-align: center;">
    <?php if ($lastImage !== false) : ?>
        <div id="image-container">
            <img id="last-image" src="<?php echo $lastImage; ?>" alt="Last Image">
        </div>
    <?php else : ?>
        <div>No image found.</div>
    <?php endif; ?>
</div>
            </div>

        </td>
    </tr>
    
    <tr>
        <td style="text-align: left; vertical-align: top; font-weight: bold; font-size: 20px;">
            <div >
                <?php
                $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                $resultadoDest = mysqli_query($conexion, $queryDest);
                while ($rowDest = $resultadoDest->fetch_assoc()) {
                    ?>
                    <?php echo '<p style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 20px;"><strong>' . $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?></strong></p>
                    <p>CI: <?php echo '<span style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 20px;"><strong>' . $rowDest['dni']; ?></strong></p>
                    <p>Teléfono: <?php echo '<span style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 20px;"><strong>' . $rowDest['tel']; ?></strong></p>
                    <p>Dirección: <?php echo '<span style="color: black; font-weight: bold; text-align: left; vertical-align: top; font-size: 20px;"><strong>' . $rowDest['direccion'] . '' . $rowDest['pais'] . ' ' . $rowDest['departamento'];
                    }?></strong></p>
            </div>
        </td>
    </tr>

    <tr>
        <td style="text-align: center; vertical-align: top; font-weight: bold;font-size: 25px;">
            <div >
                <?php
                $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
                $resultadoDest = mysqli_query($conexion, $queryDest);
                while ($rowDest = $resultadoDest->fetch_assoc()) { echo '<p style="color: black; text-align: center; vertical-align: top; font-weight: bold; font-size: 25px;"><strong>' . $rowDest['departamento'];?>&nbsp;&nbsp; </p>
                <p><strong><?php echo '<p style="color: black; text-align: center; font-weight: bold; vertical-align: top; font-size: 25px;"><strong>' . $rowDest['correo'];
                 } ?></strong></p>
            </div>
        </td>
    </tr>

    <tr>
        <td style="text-align: center; vertical-align: top; font-weight: bold;font-size: 25px;">
            <div >
                <?php
                $queryEnvia = "SELECT * FROM personas WHERE id_persona = $remitente";
                $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                while ($rowEnv = $resultadoEnv->fetch_assoc()) {
                    ?>
                    <p><strong>Remitente:</strong>
                    <?php echo  '<p style="color: black; text-align: left; vertical-align: top; font-weight: bold; font-size: 25px;"><strong>'.$rowEnv['nombre'] . ' ' . $rowEnv['apellidos'];
                    ?></p>
                <div>
            </td>
    </tr>

    <tr>
        <td style="text-align: center; vertical-align: top; font-weight: bold; font-size: 25px;">
            <div>
                <p><strong>Peso (Kg):<?php echo '<span style="color: black;  font-weight: bold; vertical-align: top; font-size: 25px;"><strong>' . $row['peso_real'];?></p>
                <?php echo '<p style="color: black; text-align: right; font-weight: bold; vertical-align: top; font-size: 25px;">&nbsp;&nbsp;&nbsp;<strong>'.$row['descripcion'];
                

               }?></strong></p>
            </div>
        </td>
    </tr>
</strong></p>';
                   
                   
                </div>
        </td>
    </tr>
    <tr>
    <td class="centered-cell" style="text-align: center; vertical-align: middle; font-weight: bold; font-size: 5px;table-layout: fixed;
        border-collapse: collapse; border: 2px solid black; margin: 0 auto;">
        <div style="display: flex; flex-direction: column; align-items: center;">
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
                $string = substr(str_repeat(0, $length).$id_guia, -$length);
                $codigoBarra = $secoundrow. $string.$segoundrow;
                ?>

                <p class="barcode" style="margin: 0; font-size: 20px;">
                    <?php echo $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128); ?>
                </p>
                <p class="barcode" style="margin: 0; font-size: 20px;">
                    <?php echo $codigoBarra; ?>
                </p>
            </div>
            <?php } ?>
        </div>
    </td>
</tr>





</table>


    <tr> <td>
<?php  echo '<a href="https://www.packexpress.com.uy/pack-sistema/phpqrcodemaster/index.php? ">Genera QR</a>';
                
                
              
              ?> <td> <tr>

 
 <!----------fin guia de embarque----------->


           
<!-- $html = ob_get_clean();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$dompdf->stream("reportes.pdf", array("Attachment"=>false));
?> 
    -->

</body>
</html>
