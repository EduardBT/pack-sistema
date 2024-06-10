<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo Pack</title>
    <meta name="keywords" content="">
    <meta name="description" content="Gestión de Cheques">
    <meta name="author" content="Carolina Ayelen Calviño">
    <!--Css-->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href='../css/style.css'>
    <link href="../css/dashboard.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
    <!--iconos-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
      
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
</style>


</head>
<?php


include "../session.php";
include "../conexion.php";
include "../includes/header.php";
include "../includes/sidebar.php";
include "../includes/footer.php";
$id_factura = $_GET["id_factura"];
$id_guia = $_GET["id_guia"];
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
if ($peso_real>=$peso_volumetrico)
  $peso=$peso_real;
else
  $peso=$peso_volumetrico;

$queryPer = "SELECT * FROM personas WHERE id_persona = $remitente";
$resultadoPer = mysqli_query($conexion, $queryPer);

if (mysqli_num_rows($resultadoPer) == 1) {
  $rowPer = mysqli_fetch_array($resultadoPer);
  $dni=$rowPer['dni'];
  $nombre = $rowPer['nombre'];
  $apellidos = $rowPer['apellidos'];
}

$queryFact = "SELECT * FROM factura WHERE id_factura = $id_factura";
$resultadoFact = mysqli_query($conexion, $queryFact);

if (mysqli_num_rows($resultadoFact) == 1) {
  $rowFact = mysqli_fetch_array($resultadoFact);
  $fecha = $rowFact['fecha'];
  $precio_tipo=$rowFact['precio_tipo'];
  $importe_tipo = $rowFact['importe_tipo'];
  $importe_empaquetado = $rowFact['importe_empaquetado'];
  $importe_tarifario=$rowFact['importe_tarifario'];
  $precio_excedenteKg= $rowFact['precio_excedenteKg'];
  $dif_x_peso=$rowFact['dif_x_peso'];  
}

?>
<html>

    <body>
      <div id="imp1"> <!-- Bloque que llama a una funcion JavaScript para imprimir solo el contenido de la factura, no botones ni otros-->
        CONTENIDO FACTURA
        NUM FACTURA <?php echo $id_factura?> <br>
        RUT<?php echo $dni;?><br>
        NOMBRES <?php echo $nombre ;?><br>
        APELLIDOS <?php echo $apellidos; ?> <br>
        FECHA <?php echo $fecha;?> <br>
        <?php
          switch($tipo_bulto){
            case 'APX': /* Si el tipo de bulto es acompañado */
              $tipo_fact ='FUEL';
              if ($dif_x_peso >0) {$pesos_exceso=$peso-30;};
                break;
            case 2:  /* Si el tipo de bulto es documento */
              $tipo_fact ='DOCUMENTO';
                if ($dif_x_peso >0) {$pesos_exceso=$peso-30;};
                break;
            default:
            $tipo_fact= 'TRAMITE ADUANAL';  
             if ($dif_x_peso >0) {$pesos_exceso=$peso-40;}    
        }?>
        DETALLE FACTURA <br>
        <?php echo $tipo_fact;?> 
        precio: 
        <?php echo $precio_tipo;?>
        importe:
        <?php echo $importe_tipo;?> <br>
        <?php
        if ($empaquetado==1 or $empaquetado==2) {
          echo "PACKAGING:";
          echo $importe_empaquetado;
        }
        if ($dif_x_peso >0) 
        echo 'PESO EXCEDENTE';
        echo $pesos_exceso;
        echo $precio_excedenteKg;
        echo $dif_x_peso ?>

        </div>
        <div> 
          <!--<a href="javascript:window.print()"><img src="ruta-imagen" alt="">imprimir</a>-->
          <button type="button" onclick="imprimir(imp1);">Imprimir</button>
        </div>
        <script src="../js/main.js"></script>
    </body>
</html>