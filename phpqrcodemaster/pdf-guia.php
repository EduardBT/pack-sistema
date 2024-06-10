<?php
include_once '../vendor/autoload.php' ;
require_once '../dompdf/autoload.inc.php';
include_once "/phpqrcodemaster/qrlib.php"; 
include_once "/phpqrcodemaster/index.php"; 
include "/phpqrcodemaster/qrlib.php"; 
include "/phpqrcodemaster/index.php";

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
    <title>Sistema Administrativo Pack</title>
    <meta name="keywords" content="">
    <meta name="description" content="Gestión de Cheques">
    <meta name="author" content="Carolina Ayelen Calviño">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <!--iconos-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
      
   .guia{

      text-align: center;
   }
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
  p{
      font-size:10px;
  }
  hr{
    page-break-after: always;
    border:0;
    margin:0;
    padding:0;
}

</style>
</head>
<body>
<br>
<div class="container">
    <div class="row" style="border:solid 1px black;">
        <div class="col-xs-3">
            <img src="http://<?php echo $_SERVER['HTTP_HOST'];  ?>/pack-sistema/img/logo.png" style="max-width: 150px; margin-top:15px" alt="logo pack">
            <br>
            <p><strong>Cliente: </strong>Pack Express Uruguay S.A.S (COMVD07341)</p>
            <p><strong>Origen: </strong>Aeropuerto de Carrasco, Montevideo (MVD)</p>
            <p><strong>Dirección: </strong> Carlos Quijano 1258 Esq. Soriano, Centro. Montevideo, Uruguay</p>
            <p><strong>Tel.: </strong>(+598) 2902 7227 / (+598) 93 594 297</p>
            <p><strong>Email: </strong>packexpress2021@gmail.com</p>
        </div>
        <div class="col-xs-4" style="border:solid 1px black; text-align:center">
            <?php
                $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_origen";
                $resultadoPais= mysqli_query($conexion, $queryPais);
                while ($rowPais = $resultadoPais->fetch_assoc()) {?>
                    <div>
                        <h5>Destino: <?php $codPais = $rowPais['codigo'];
                        echo $codPais; ?>
                        </h5> 
                        <?php
                        $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
                        $codPais = $rowPais['codigo'];
                        $length = 9;
                        $string = substr(str_repeat(0, $length).$id_guia, - $length);
                        $secoundrow= 'CU';
                        $segoundrow= 'UY';
                        $codigoBarra= $secoundrow. $string.$segoundrow;
                        echo $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128);
                         echo $codigoBarra;
                        ?>
                    </div> <?php
                } 
            ?>
            <?php
    echo "<h1>PHP QR Code</h1><hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
    //config form
    echo '<form action="index.php" method="post">
        Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
        ECC:&nbsp;<select name="level">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
        </select>&nbsp;
        Size:&nbsp;<select name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
   // QRtools::timeBenchmark();    
    ?>
        </div>
        <div class="col-xs-5">
            <h5><u>Remitente</u></h5>
            <?php
                $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                while ($rowEnv = $resultadoEnv->fetch_assoc()) {?>
                    <p><strong>Nombre: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                    <p><strong>Dirección: </strong><?php echo $rowEnv['direccion'] . '<br>' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?></p>
                    <p><strong>Tel.: </strong><?php echo $rowEnv['tel']; ?></p>
                    <?php
                }?>
            
            <h5><u>Destinatario</u></h5>

            <?php

            $queryDest = "SELECT * FROM personas  WHERE id_persona =$destinatario";
            $resultadoDest = mysqli_query($conexion, $queryDest);
            while ($rowDest = $resultadoDest->fetch_assoc()) {?>
                <p><strong>Nombre: </strong><?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?></p>
                <p><strong>Dirección: </strong><?php echo $rowDest['direccion'] . '<br>' . $rowDest['pais'] . ' ' . $rowDest['departamento']; ?></p>
                <p><strong>Tel.: </strong><?php echo $rowDest['tel']; ?></p>
            <?php
            }?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row" style="border-left:solid 1px black; border-right:solid 1px black;">
        <div class="col-xs-12" style="text-align:center">
            <h5><u>Información de Envío</u></h5>
            <br>
        </div>
    </div>
    <div class="row" style="border-bottom:solid 1px black;border-left:solid 1px black; border-right:solid 1px black;">
        <div class="col-xs-4">
            <p><strong>Origen: </strong>Montevideo, Uruguay</p>
            <p><strong>Fecha: <?php echo $row['fecha']; ?></strong></p>
            <p><strong>Fecha embarque: <?php echo $row['fecha_emb']; ?></strong></p>
            <p><strong>Valor mercancía (USD): <?php echo $row['valor_mercancia']; ?></strong></p>
        </div>
        <div class="col-xs-4">
            <p><strong>Peso (Kg): <?php echo $row['peso_real']; ?></strong></p>
            <p><strong>Descripción: <?php echo $row['descripcion']; ?></strong></p>
            <p><strong>Tipo de bulto: <?php echo $row['tipo_bulto']; ?></strong></p>
            <p><strong>Cond. Entrega: <?php echo $row['incotem']; ?></strong></p>
        </div>
        <div class="col-xs-4">
            <p><strong>Producto: IES</strong></p>
            <p><strong>Bultos: <?php echo $row['cantidad_bulto']; ?></strong></p>
            <?php
                if ($peso_real > $peso_volumetrico) {?>
                    <p><strong>Peso a cobrar: <?php echo $peso_real; ?></strong></p>
                <?php
                } else {?>
                    <p><strong>Peso a cobrar: <?php echo $peso_volumetrico; ?> </strong></p>
                <?php }?>
            <p><strong>Status: </strong></p>
        </div>
    </div>
</div>
<hr>
<!--Nota de descargo-->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h4 style="text-align:center"><u>NOTA DE DESCARGO DE RESPONSABILIDAD</u></h4>
            <br>
            <p style="text-align: justify;">Por este medio certificamos que deslindamos de cualquier responsabilidad, sobre valor total, de los artículos embarcados bajo la guía <?php $length = 5;
              $guia = substr(str_repeat(0, $length).$row['id_guia'], - $length);
              echo $guia; ?> a los Señores de Copa Airlines Courier, dado que los productos declarados están fuera del cuadro de artículos permitidos para el transporte por esta empresa o presentan un embalaje inadecuado para su transporte.</p>
            <br>
            <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona= mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) {?>
                    <p>Persona: <?php echo $rowPersona['nombre'] . " " . $rowPersona['apellidos']; ?></p>
                    <?php
                } 
            ?>
            <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona= mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) {?>
                    <p>C.I: <?php echo $rowPersona['dni'];?></p>
                    <?php
                } 
            ?>
            <p>Firma:</p>
            <p>Fecha: <?php 
             echo date('F j, Y');  ?></p>

        </div>
    </div>
</div>
<hr>
<!--declaracion general-->
<div class="container">
    <div class="row">
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
            <p>Montevideo, <?php 
           ?>
            </p> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <p><u> Presente</u></p>
            <p>Mediante la presente, yo </p>
            <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona= mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) {?>
                    <p>CI Nro.: <?php echo $rowPersona['dni'];?></p>
                    <?php
                } 
            ?>
        </div>
        <div class="col-xs-6">
            <p>Ref.    Nro.   Guía / <?php $length = 5;
              $guia = substr(str_repeat(0, $length).$row['id_guia'], - $length);
              echo $guia; ?> </p>
            <?php
                $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoPersona= mysqli_query($conexion, $queryPersona);
                while ($rowPersona = $resultadoPersona->fetch_assoc()) {?>
                    <p><?php echo $rowPersona['nombre'] . " " . $rowPersona['apellidos']; ?></p>
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
            <p>“Certifico que este embarque no contiene ningún producto explosivo, mercancías peligrosas o aparato destructivo <strong> NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES.</strong> Estoy consciente de que este embarque está sujeto a los respectivos controles de seguridad Aérea y otras Regulaciones Gubernamentales: Asimismo, soy consciente que esta declaración y firma original así como el resto de los documentos de este embarque se mantendrán en archivo hasta que el embarque sea entregado al consignatario.”</p>
            <p>“Soy consciente y acepto que dada la emergencia sanitaria, existen retrasos en los envíos, siendo indefinido el arribo de la misma a su destino final”</p>
            <p>“Adicionalmente autorizo al personal de Feriban S.A. a realizar cualquier gestión en nuestro nombre ante la Dirección de Aduanas del Uruguay”</p>
            <br>
            <br>
            <p>Firma/Signature   y   Sello/Seal</p>
            <br>
            <p><strong> Nota:</strong> El firmante debe adjuntar a la presente fotocopia de un documento de identidad con su fotografía y presentar el original para la verificación de su firma.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="text-align:center; margin:0px">
        <br>
            <p style="color:#767676"> FERIBAN S.A. <br>Aeropuerto Int´l. de Carrasco<br>TCU of 116<br>Tel./Fax:  (598) 26009915 - 26002118<br>Montevideo - Uruguay</p>
        </div>
    </div>
</div>




<input type="hidden" name="guia" id="guia" generarFactura()value=<?php echo $id_guia;?>>
 <!----------fin guia de embarque----------->


                <?php
$html = ob_get_clean();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$dompdf->stream("reportes.pdf", array("Attachment"=>false));
?>
    

</body>
</html>
