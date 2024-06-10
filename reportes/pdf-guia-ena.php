<?php
include_once '../vendor/autoload.php' ;
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

ob_start();
include "../conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $guiaAWB=$_GET['guiaAWB'];
    $query = "SELECT * FROM guia_embarque  WHERE id_guia = $id";
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
        
        $modf_numero = "UPDATE guia_embarque set numero = '$guiaAWB'  WHERE id_guia = $id";
        $resultado= mysqli_query($conexion, $modf_numero);
        if (!$resultado) {
           echo 'error guardando numero externo';
        } 

       
    }
    $query3 = "SELECT * FROM cod_pais  WHERE id_pais = $cod_origen ";
    $resultado3 = mysqli_query($conexion, $query3);

    if (mysqli_num_rows($resultado3) == 1) {
        $row3 = mysqli_fetch_array($resultado3);
        $pais_origen=$row3['descripcion'];
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

   /* th{
        font-size: 6px;
        border-right:0.5px solid black;
    }
    td{
        border-right:0.5px solid black;
        /*border-bottom:0.5px solid black;*/
   /*     font-size:7px;
    }*/
    .espacio{
        width:100%;
        height:90px;
    }
    .nombre{
        font-size:10px;
        line-height:0.1em;
        margin-left:5px;
    }
    html {
	margin-top: 0px;
    }
    @page {
    margin:0px;
    margin-right:10px;

    }
    .tabla{
        margin:0px!important;
        padding: 0;
    }

    .centrar{
        margin=0;
        text-align:center;
    }
    .codigoB{
        font-size: 13px;
        border-right:0.5px solid black;
        margin:0px;
        text-align:left;
        width: 4px;
    
    }
    .codigoC{
        font-size: 13px;  
        border: right 0px;
    }
    .principal{
        width:100%;
        margin:0px!important;
        padding: 0;
    }
    .codigoA{
        width: 4px;
        font-size: 13px;
        border-right:0.5px solid black
    }
    .codigoD{
        font-size: 13px;  
        border: right 0px;
        text-align:center;
    }
    .bordes{
        border:0.5px solid black; width: 100%;  

    }
    .bordes_der{border-right:0.5px solid black; width: 25%;

    }
    .bordes_center{
        border:0.5px solid black; 
        width: 25%; Background:#c0c0c0;
    }
    .centrar{ text-align:center;border-right:0.5px solid black }
    .bordes_der_notNeg{ border-right:0px; border-bottom:0px solid black; width: 13%; margin-left:3px; }
    .centrar_copa{ text-align:center;border-right:0.5px solid black; width: 37%; }
    .margen{
        margin-left:3px;
    }
    .copies{
        border:0.5px solid black;
    }
    .lineas_pegadas{
        margin-top:0.2em;
        margin-bottom:0em;
        line-height:0.6em;
    }
    .justificado{
        text-align:justify;
    }
    .sin_borde_inferior{
        border-bottom:0px solid black;
    }
    </style>
</head>
<body>
<br>


    <table class="principal">
        <thead >
            <tr >
                <th class="codigoA">230</th>
                <th class="codigoB">MTV</th>
                <th class="codigoC"><?php echo $guiaAWB;?></th>
                <th class="codigoD">230 - <?php echo " ".$guiaAWB;?></th>
                              
            </tr>  
        </thead>

    </table>
    <table class="bordes">
        <tbody>
            <tr >
                <th class="bordes_der"><p style="font-size: 8px">Shipper´s Name and Address</p><br></th>
                <th class="bordes_center"><p style="font-size: 8px">Shipper´s Account Number</p><br></th>
                <th class="bordes_der_notNeg lineas"><p class="margen "style="font-size: 8px">Not Negotiable</p>            <h6 class="margen"> Air Waybill</h6>
                                            </th>
                <th class="centrar_copa"><p>COPA AIRLINES <br>Compañia Panameñia de Aviación, S.A.</p></th>
                              
            </tr>  

            <tr >
            <?php
                $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
                $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                while ($rowEnv = $resultadoEnv->fetch_assoc()) {?>


                <th class="lineas"><p class="nombre"><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                    <p class="nombre"><?php echo $rowEnv['direccion'] . ' ' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?></p>
                    <p class="nombre">Tel.:<?php echo $rowEnv['tel']; ?></p>
                </th>
                <th ></th>
                <th class="bordes_der_notNeg linea">     
                                            <p class="margen" style="font-size: 8px">Issued by</p> </th>
                <th class="centrar_copa"><p> P.O.BOX 1572 <br>PANAMA 1,PANAMA</p></th>
                <?php
            }
            ?>              
            </tr> 
            <tr>
                <th></th>
                <th></th>
                <td colspan="2" class="copies"><p style="font-size: 8px">Copies 1, 2 and 3 of this Air Waybill are originals and have the same validity</p></td>
                
                
            <tr>           
        </tbody>

    </table>

    <!--REVERSE HEREOF, ALL GOODS MAY BE CARRIED BY ANY OTHER MEANS INCLUDING ROAD OR ANY OTHER CARRIER UNLESS
            SPECIFIC CONTRARY INSTRUCTIONS ARE GIVEN HEREON BY THE SHIPPER, AND SHIPPER AGREES TAHT THE SHIPMENT MAY BE CARRIED VIA
            INTERMEDIATE STOPPING PLACES WICH THE CARRIER DEEMS APPROPRIATE. THE SHIPPER´S ATTENTION IS DRAWN TO THE NOTICE CONCERNING
            CARRIER´S LIMITATION OF LIABILITY. Shipper may increase such limitation of liability by declaring a higher value for carriage and paying a supplemental charge if
            required.-->
    <table class="bordes">
        <tbody>
            <tr class=" lineas_pegadas" >
                <th class="bordes_der lineas_pegadas"><p style="font-size: 8px">By</p></th>
                <th class="bordes_center lineas_pegadas"><p style="font-size: 8px">Consignee´s Account Number</p></th>
                <td class=" justificado copies sin_borde_inferior" style="font-size: 9.3px"  > 
                It is agreed that the goods described herein are accepted in apparent good order an condition (except as noted) for carriage SUBJECT TO THE CONDITIONS OF
            CONTRACT ON THE </td>
                
            
             
            </tr> 
            <tr class=" lineas_pegadas" >
                <th class="bordes_der lineas_pegadas"><br></th>
                <th><br></th>
                <td class="justificado" style="font-size: 9.3px" >
                REVERSE HEREOF, ALL GOODS MAY BE CARRIED BY ANY OTHER MEANS INCLUDING ROAD OR ANY OTHER CARRIER UNLESS
            SPECIFIC CONTRARY INSTRUCTIONS ARE GIVEN HEREON BY THE SHIPPER, AND SHIPPER AGREES TAHT THE SHIPMENT MAY BE CARRIED VIA
            INTERMEDIATE STOPPING PLACES WICH THE CARRIER DEEMS APPROPRIATE. THE SHIPPER´S ATTENTION IS DRAWN TO THE NOTICE CONCERNING
            CARRIER´S LIMITATION OF LIABILITY. Shipper may increase such limitation of liability by declaring a higher value for carriage and paying a supplemental charge if
            required.</td>
                
            
             
            </tr> 

            </tbody>

    </table>


    <table >
 <tr>
  <td colspan="2" rowspan="2">Celda cs2 rs2</td>
  <td>Celda aaa</td>
 </tr>
 <tr>
  <td>Celda</td>
 </tr>
 <tr>
  <td>Celda xx</td>
  <td>Celda yy</td>
  <td>Celdazz</td>
 </tr>
</table>
    <div class="container">
    <div class="row" style="border:solid black 0.5px";>
        <div class="col-xs-6">
            <h5 class ="centrar">230-MTV- <?php echo $guiaAWB;?></h5>
        </div>
        <div class="col-xs-6">
            <h5 class ="centrar">230-MTV <?php echo $guiaAWB;?></h5>
        </div>
    </div>


    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px;">
            <p style="font-size: 8px">Shipper´s Name and Address</p>
            <?php
            $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
            $resultadoEnv = mysqli_query($conexion, $queryEnvia);
            while ($rowEnv = $resultadoEnv->fetch_assoc()) {?>
                
                <p class="nombre"><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                <p class="nombre"><?php echo $rowEnv['direccion'] . ' ' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?></p>
                <p class="nombre">Tel.:<?php echo $rowEnv['tel']; ?></p>
                <?php
            }
            ?>
        </div>
        <div class="col-xs-2">
            <p style="font-size: 8px">Not Negotiable</p>
            <h6>Air Waybill</h6>
            <p style="font-size: 8px">Issued by</p>
        </div>
        <div class="col-xs-6" style="text-align:center">
            <h6>COPA AIRLINES<br>Compañia Panameñia de <br> Aviación, S.A.<br> P.O.BOX 1572 PANAMA 1,<br> PANAMA</h6>
            <p style="font-size: 8px">Copies 1, 2 and 3 of this Air Waybill are <br>originals and have the same validity</p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4">
            <p style="font-size: 8px">Consignee´s Name and Address</p>
            <?php
            $queryDest = "SELECT * FROM personas  WHERE id_persona =$destinatario";
            $resultadoDest = mysqli_query($conexion, $queryDest);
            while ($rowDest = $resultadoDest->fetch_assoc()) {?>
                <p class="nombre"><?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?></p>
                <p class="nombre"><?php echo $rowDest['direccion'] . ' ' . $rowDest['pais'] . ' ' . $rowDest['departamento']; ?></p>
                <p class="nombre">Tel.: <?php echo $rowDest['tel']; ?></p>
            <?php
            }?>
        </div>
        <div class="col-xs-8" style="border-left:solid black 0.5px;">
            <p style="font-size: 7px">It is agreed that the goods described herein are accepted in apparent good order an condition (except as noted) for carriage SUBJECT <br>TO THE CONDITIONS OF
            CONTRACT ON THE REVERSE HEREOF, ALL GOODS MAY BE CARRIED BY ANY OTHER MEANS<br> INCLUDING ROAD OR ANY OTHER CARRIER UNLESS
            SPECIFIC CONTRARY INSTRUCTIONS ARE GIVEN HEREON BY THE<br> SHIPPER, AND SHIPPER AGREES TAHT THE SHIPMENT MAY BE CARRIED VIA
            INTERMEDIATE STOPPING PLACES WICH THE <br>CARRIER DEEMS APPROPRIATE. THE SHIPPER´S ATTENTION IS DRAWN TO THE NOTICE CONCERNING
            CARRIER´S<br> LIMITATION OF LIABILITY. Shipper may increase such limitation of liability by declaring a higher value for carriage and paying a <br>supplemental charge if
            required. </p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px;">
            <div style="border-bottom:solid black 0.5px">
                <p style="font-size: 8px">Issuing Carrier´s Agent Name and City</p>
                <p class="nombre">FERIBAN - MONTEVIDEO URUGUAY </p>
            </div>
            <table class="tabla">
                <tbody>
                    <tr>
                        <td>Agent´s IATA Code</td>
                        <td style="border-right:none">Account No.</td>
                    </tr>
                </tbody>
            </table>
            <p style="font-size: 8px; border-top:solid black 0.5px;"> Airport of Departure (Addr. Of First Carrier) and Requested Routing </p>
            <p class="nombre" style="text-align:center"><?php echo $pais_origen; ?> </p>
        </div>
        <div class="col-xs-8">
            <p style="font-size: 8px">Accounting Information</p>
            <p class="nombre">FREIGHT PREPAID</p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-12">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>By First Carrier</th>
                        <th>To</th>
                        <th>By</th>
                        <th>To</th>
                        <th>By</th>
                        <th>Currency</th>
                        <th>CHGS Code</th>
                        <th>WT/VAL</th>
                        <th>Other</th>
                        <th>Declared Value for Carriage</th>
                        <th style="border:none">Declared Value for Customs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PTY</td>
                        <td>COPA AIRLINES</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>USD</td>
                        <td>PP</td>
                        <td>PPD</td>
                        <td>PPD</td>
                        <td>NVD</td>
                        <td style="border-right:none">NVD</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-3">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Airport of Destination</th>
                        <th>Fligth/Date</th>
                        <th>Fligth/Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>HABANA</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-9">
        <table class="tabla">
                <thead>
                    <tr>
                        <th>Amount of Insurance</th>
                        <th style="border:none">INSURANCE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>N I L</td>
                        <td style="border-right:none; font-size: 8px">If carrier offers insurance, and such insurance is
                        requested in accordance with conditions thereof, <br>indicate amount
                        to be insured in figures in box marked "Amount of Insurance".
                        </td>                    
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-6">
            <p style="font-size: 8px">Handling Information</p>
            <p class="nombre">** EQUIPAJE NO ACOMPAÑADO - EFECTOS PERSONALES**</p>
        </div>
        <div class="col-xs-4"> 
            <p style="font-size: 8px">Diversion contrary to U.S. Law prohibited</p>
        </div>
        <div class="col-xs-2" style="border-left:solid black 0.5px;">
            <p style="font-size: 8px">SCI</p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-12">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>No. Of Pieces RCP</th>
                        <th>Gross Weight</th>
                        <th>Kg</th>
                        <th>Commodity Item No.</th>
                        <th>Chargeable Weight</th>
                        <th>Rate/Charge</th>
                        <th>Total</th>
                        <th style="border:none">Nature and Quantity of Goods(incl. Dimensions or <br>Volume)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>5</td>
                        <td>80,00</td>
                        <td>Kg</td>
                        <td></td>
                        <td>80,00</td>
                        <td></td>
                        <td>AS AGREED</td>
                        <td style="border-right:none; font-size: 9px">EQUIPAJE NO ACOMPAÑADO <br>EFECTOS PERSONALES
                        </td>                    
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Prepaid</th>
                        <th>Weight Charge</th>
                        <th style="border-right:none">Collect</th>
                    </tr>
                </thead>
            </table>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="border-top:none">0,00</th>
                        <th style="border-top:none; border-right:none">0,00</th>
                    </tr>
                </tbody>
            </table>
            <p class="nombre" style="text-align:center;">Valuation Charge</p>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th></th>
                        <th style="border-right:none"></th>
                    </tr>
                </tbody>
            </table>
            <p class="nombre" style="text-align:center;">Tax</p>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th></th>
                        <th style="border-right:none"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-8">
            <p style="font-size: 8px">Other Charges</p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px">
            <p class="nombre" style="text-align:center;">Total Other Charges Due Agent</p>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th>0,00</th>
                        <th style="border-right:none">0,00</th>
                    </tr>
                </tbody>
            </table>
            <p class="nombre" style="text-align:center;">Total Other Charges Due Carrier</p>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="visbility:hidden">0,00</th>
                        <th style="border-right:none">0,00</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-8">
            <p style="font-size: 8px">Shipper certifies that the particulars on the face hereof are correct and that insofar as any part<br> of the consignment contains dangerous goods, such part is properly described by name and is<br> in proper condition for carriage by air according to the applicable  Dangerous Goods Regularions.</p>
            <p style="text-align:center">---------------------------------------</p>
            <p style="font-size: 8px;text-align:center">Signature of Shipper or its Agent</p>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Total Prepaid</th>
                        <th style="border-right:none">Total Collect</th>
                    </tr>
                </thead>
            </table>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="border-top:none">AS AGREED</th>
                        <th style="border-top:none; border-right:none">0,00</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-8">
            <table class="tabla">
                <tbody>
                    <tr>
                        <td style="border:none">16 de Marzo de 2022</td>
                        <td style="border:none"></td>
                        <td style="border:none">DM</td>
                    </tr>
                    <tbody>
                    <tr>
                        <th style="border:none">date</th>
                        <th style="border:none">at(place)</th>
                        <th style="border:none">Signature of Issuing Carrier <br>or its Agent</th>
                    </tr>
                </tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="border:solid black 0.5px;">
        <div class="col-xs-4" style="border-right:solid black 0.5px">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Currency Conversion Rates</th>
                        <th style="border-right:none">CC Charges in Dest. Currency</th>
                    </tr>
                </thead>
            </table>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="border-top:none"></th>
                        <th style="border-top:none; border-right:none"></th>
                    </tr>
                </tbody>
            </table>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>For Carriers Use only at Destination</th>
                        <th style="border-right:none">Charges at Destination</th>
                    </tr>
                </thead>
            </table>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="border-top:none"></th>
                        <th style="border:none"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-8">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Total Collect Charges</th>
                    </tr>
                </thead>
            </table>
            <table class="tabla">
                <tbody>
                    <tr>
                        <th style="border-top:none"></th>
                    </tr>
                </tbody>
            </table>
            <h5>230- <?php echo $guiaAWB;?></h5>
        </div>
    </div>
</div>

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
