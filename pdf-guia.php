<?php
include_once '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';


use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
include "../conexion.php";
require_once('phpqrcodemaster/qrlib.php');


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
    .guia {
      text-align: left;
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

    p {
      font-size: 14px;
    }

    hr {
      page-break-after: always;
      border: 0;
      margin: 0;
      padding: 0;
    }
  </style>

</head>

<body>
  <br>

  <table style="margin: 0 auto; width: 100%; font-size: 14px;">
    <tr>
      <td style="text-align: center;">
        <div class="col-xs-5">

        </div>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;">
        <div class="col-xs-5">
          <?php

          $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
          $resultadoDest = mysqli_query($conexion, $queryDest);
          $codPais = $rowPais['codigo'];

          $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
          $codPais = $rowPais['codigo'];
          $length = 9;
          $secoundrow = 'CU';
          $segoundrow = 'UY';
          $string = substr(str_repeat(0, $length) . $id_guia, -$length);
          $codigoBarra = $secoundrow . $string . $segoundrow;
          echo '<p style="color: black;"><strong>' . $codigoBarra . '</strong></p>';

          include "qrlib.php";
          require_once('phpqrcodemaster/qrlib.php');
          include "index.php";


          $directory = '/phpqrcodemaster/temp'; // Directory path
          $extension = 'png'; // File extension
          
          // Get all files in the directory
          $files = scandir($directory, SCANDIR_SORT_DESCENDING);

          // Find the first file with the specified extension
          $newestFile = null;
          foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === $extension) {
              $newestFile = $file;
              break;
            }
          }

          // Check if a file was found
          if ($newestFile !== null) {
            $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $directory . '/' . $newestFile;
            echo '<img src="' . $imageUrl . '" style="max-width: 20px; margin-top: 8px;">';
          } else {

            echo '<img src="http://' . $_SERVER['HTTP_HOST'] . '/' . $directory . '/' . 'test83db8ec406d864525bfdb3d281b080ec.png" style="max-width: 40px; margin: top 20px;" >';

          }
          ?>
          <h5><u>___________________________</u></h5>
          <?php
          $queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
          $resultadoDest = mysqli_query($conexion, $queryDest);
          while ($rowDest = $resultadoDest->fetch_assoc()) { ?>

            <p><strong>Nombre: </strong>
              <?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?>
            </p>
            <p><strong>Dirección: </strong>
              <?php echo $rowDest['direccion'] . '<br>' . $rowDest['pais'] . ' ' . $rowDest['departamento']; ?>
            </p>
            <p><strong>Tel.: </strong>
              <?php echo $rowDest['tel']; ?>
            </p>
            <p><strong>carnet de identidad: </strong>
              <?php echo $rowDest['dni']; ?>
            </p>
            <p><strong>Peso (Kg):
                <?php echo $row['peso_real']; ?>
              </strong></p>
            <p><strong>Descripción:
                <?php echo $row['descripcion']; ?>
              </strong></p>
            <?php echo $rowDest['departamento']; ?>
            </p>
            <p><strong>
                <?php echo $rowDest['correo']; ?>
              </strong></p>
            <h5><u>___________________________</u></h5>
            <h5><u>Remitente:</u></h5>
            <?php
            $queryEnvia = "SELECT * FROM personas WHERE id_persona = $remitente";
            $resultadoEnv = mysqli_query($conexion, $queryEnvia);
            while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
              <p><strong>Nombre: </strong>
                <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
              </p>

              <?php
            } ?>
            <?php
          } ?>
          <?php
          $queryPais = "SELECT * FROM cod_pais WHERE id_pais = $cod_origen";
          $resultadoPais = mysqli_query($conexion, $queryPais);
          while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
            <div>
              <?php
              $codPais = $rowPais['codigo'];

              $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
              $codPais = $rowPais['codigo'];
              $length = 9;
              $secoundrow = 'CU';
              $segoundrow = 'UY';
              $string = substr(str_repeat(0, $length) . $id_guia, -$length);
              $codigoBarra = $secoundrow . $string . $segoundrow;
              echo $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128);
              echo '<br>___________________________<br>';
              echo $codigoBarra;
              echo '<br>___________________________<br>';
              echo ' <a href="/phpqrcodemaster/index.php?$codigoBarra=">click aca para QR</a>';
          }
          ?>
          </div>

          <?php

          ?>
        </div>
      </td>
    </tr>



  </table>


  <hr>
  <!--Nota de descargo-->
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h4 style="text-align:center"><u>NOTA DE DESCARGO DE RESPONSABILIDAD</u></h4>
        <br>
        <p style="text-align: justify;">Por este medio certificamos que deslindamos de cualquier responsabilidad, sobre
          valor total, de los artículos embarcados bajo la guía
          <?php $length = 5;
          $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length);
          echo $guia; ?> a los Señores de Copa Airlines Courier, dado que los productos declarados están fuera del
          cuadro de artículos permitidos para el transporte por esta empresa o presentan un embalaje inadecuado para su
          transporte.
        </p>
        <br>
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
        <p>Firma:</p>
        <p>Fecha:
          <?php
          echo date('F j, Y'); ?>
        </p>

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
        <p>Montevideo,
          <?php
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
          <?php $length = 5;
          $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length);
          echo $guia; ?>
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
          destructivo <strong> NO AUTORIZADO, ASI COMO MERCANCIAS ILEGALES.</strong> Estoy consciente de que este
          embarque está sujeto a los respectivos controles de seguridad Aérea y otras Regulaciones Gubernamentales:
          Asimismo, soy consciente que esta declaración y firma original así como el resto de los documentos de este
          embarque se mantendrán en archivo hasta que el embarque sea entregado al consignatario.”</p>
        <p>“Soy consciente y acepto que dada la emergencia sanitaria, existen retrasos en los envíos, siendo indefinido
          el arribo de la misma a su destino final”</p>
        <p>“Adicionalmente autorizo al personal de Feriban S.A. a realizar cualquier gestión en nuestro nombre ante la
          Dirección de Aduanas del Uruguay”</p>
        <br>
        <br>
        <p>Firma/Signature y Sello/Seal</p>
        <br>
        <p><strong> Nota:</strong> El firmante debe adjuntar a la presente fotocopia de un documento de identidad con su
          fotografía y presentar el original para la verificación de su firma.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12" style="text-align:center; margin:0px">
        <br>
        <p style="color:#767676"> FERIBAN S.A. <br>Aeropuerto Int´l. de Carrasco<br>TCU of 116<br>Tel./Fax: (598)
          26009915 - 26002118<br>Montevideo - Uruguay</p>
      </div>
    </div>
  </div>




  <input type="hidden" name="guia" id="guia" generarFactura()value=<?php echo $id_guia; ?>>
  <!----------fin guia de embarque----------->


  <?php
  $html = ob_get_clean();

  $options = $dompdf->getOptions();
  $options->set(array('isRemoteEnabled' => true));
  $dompdf->setOptions($options);

  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'portrait');

  $dompdf->render();
  $dompdf->stream("reportes.pdf", array("Attachment" => false));
  ?>


</body>

</html>