<?php
include_once '../vendor/autoload.php' ;
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
        $fecha_hoy = $row['fecha'];
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
      font-size:12px;
  }
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h4 style="text-align:center"><u>NOTA DE DESCARGO DE RESPONSABILIDAD</u></h4>
            <br>
            <p>Por este medio certificamos que deslindamos de cualquier responsabilidad, sobre valor total, de los artículos embarcados bajo la guía <?php $length = 5;
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
            echo date("F") . " " . date("m") . ", " . date("Y"); ?></p>

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
