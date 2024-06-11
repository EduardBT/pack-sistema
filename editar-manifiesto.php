<?php
include("session.php");
include("conexion.php");

//trae los datos de la base
if (isset($_GET['id_manifiesto'])) {
  $id_manifiesto = $_GET['id_manifiesto'];
  $query = "SELECT * FROM manifiesto WHERE id_manifiesto = $id_manifiesto";
  $resultado = mysqli_query($conexion, $query);

  if (mysqli_num_rows($resultado) == 1) {
    $row = mysqli_fetch_array($resultado);
    $numero = $row['numero'];
    $fecha_arribo = $row['fechaArribo'];
    $vuelo = $row['vuelo'];
    $cod_origen = $row['cod_origen'];
    $cod_destino = $row['cod_destino'];
    $expedidor = $row['expedidor'];
    $consignatario = $row['consignatario'];
    $electronico = $row['electronico'];
  }
}

//actualizar datos
if (isset($_POST['update'])) {
  $id_manifiesto = $_GET['id_manifiesto'];
  $numero = $_POST['numero'];
  $vuelo = $_POST['vuelo'];
  $fechaArribo = $_POST['fechaarribo'];
  $expedidor = $_POST['expedidor'];
  $consignatario = $_POST['consignatario'];

  $query = "UPDATE manifiesto set numero = '$numero',vuelo = '$vuelo', expedidor = '$expedidor',consignatario = '$consignatario', fechaArribo ='$fechaArribo' WHERE id_manifiesto = $id_manifiesto";
  mysqli_query($conexion, $query);
  $query_guias_anteriores = "SELECT guia_id,manifiesto_id FROM manif_embarq WHERE manifiesto_id=$id_manifiesto";
  $result_guias = mysqli_query($conexion, $query_guias_anteriores);

  while ($rowG = mysqli_fetch_array($result_guias)) {
    $guia = $rowG['guia_id'];
    $query = "UPDATE guia_embarque set estado_id = 1  WHERE id_guia = $guia";
    $resultado = mysqli_query($conexion, $query);
    if (!$resultado) {
      die("Query failed modificando la guia");
    } else {
      $entre = 'modifique';
    }
  }
  $query = "DELETE FROM manif_embarq WHERE manifiesto_id=$id_manifiesto";
  $resultado = mysqli_query($conexion, $query);
  if (!$resultado) {
    die("Query failed modificando la guia");
  }

  foreach ($_POST['guia'] as $id_guia) {
    $query = "INSERT INTO manif_embarq(manifiesto_id,guia_id ) VALUES ('$id_manifiesto','$id_guia')";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
      die("Query failed di error insetando en manif embarq ");
    } else {

      $query = "UPDATE guia_embarque set estado_id = '2' WHERE id_guia = $id_guia";
      mysqli_query($conexion, $query);
      if (!$resultado) {
        die("Query failed modificando la guia");
      } else {
        $_SESSION['message'] = "Registro modificado con éxito";
        $_SESSION['message-type'] = 'success';
        header('Location: manifiesto.php');
      }
    }
  }
}
?>

<?php
include_once("includes/header.php");
include_once("includes/sidebar.php");
?>

<div
  class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom card container full-screen shadow"
  style="margin-top:2%">

  <?php
  if (!empty($cod_origen) and !empty($cod_destino)) { ?>
    <div style="padding-bottom:4%">
      <form action="editar-manifiesto.php?id_manifiesto=<?php echo $_GET['id_manifiesto']; ?>" method="post">

        <div class="table-responsive">
          <div class="text-center">
            <h3>Editar Guías de Manifiesto</h3>
          </div>
          <hr>
          <table class="table table-striped table-sm" style="margin-top: 5%; margin-bottom:3%">
            <thead>
              <tr>
                <th scope="col">Número de Guía</th>
                <th scope="col">Remitente</th>
                <th scope="col">Destinatario</th>
                <th scope="col">Destino</th>
                <th scope="col">Fecha Embarque</th>
                <th scope="col">Piezas</th>
                <th scope="col">Peso</th>
                <th scope="col">Electrónicos</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT DISTINCT
              g.id_guia,
              g.personasEnv_id,
              g.cod_destino,
              g.personasDest_id,
              g.tipo_bulto,
              g.fecha_emb,
              g.cantidad_bulto,
              g.peso_real,
              g.empaquetado,
              g.numero,
              g.peso_volumetrico,
              g.electronico
          FROM
              guia_embarque AS g
              INNER JOIN manif_embarq AS m ON g.id_guia = m.guia_id
          WHERE
              m.manifiesto_id = '$id_manifiesto'";

              $result = mysqli_query($conexion, $query);

              while ($row = mysqli_fetch_array($result)) {
                $datos = 'si' ?>
                <tr>
                  <td>
                    <?php
                    $length = 5;
                    $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length); ?>
                    <input type="checkbox" checked="checked" name="guia[]" value=<?php echo $guia; ?>><?php echo $guia; ?></input>
                  </td>
                  <?php
                  $envia = $row['personasEnv_id'];
                  $queryEnvia = "SELECT * FROM personas WHERE id_persona =$envia";
                  $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                  while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                    </td>
                    <?php
                  }
                  $destinatario = $row['personasDest_id'];
                  $queryDest = "SELECT * FROM personas  WHERE id_persona =$destinatario";
                  $resultadoDest = mysqli_query($conexion, $queryDest);
                  while ($rowDest = $resultadoDest->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?>
                    </td>
                    <?php
                  }
                  $origen = $row['cod_destino'];
                  $queryOrigen = "SELECT * FROM cod_pais WHERE id_pais=$origen";
                  $resultadoOrigen = mysqli_query($conexion, $queryOrigen);
                  while ($rowOrigen = $resultadoOrigen->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowOrigen['codigo']; ?>
                    </td>
                  <?php }
                  ?>
                  <td>
                    <?php echo $row['fecha_emb']; ?>
                  </td>
                  <td>
                    <?php echo $row['cantidad_bulto']; ?>
                  </td>
                  <td>
                    <?php echo $row['peso_real']; ?>
                  </td>
                  <td>
                    <?php echo $row['electronico'];
                    $elec = $row['electronico']; ?>
                  </td>

                </tr>
              <?php }
              /* CONSULTA SI HAY GUIAS NO ATADAS A NINGUN MANIFIESTO QUE TENGAN EL MISMO ORIGEN Y DESTINO Y LAS ANEXA A LA LISTA*/
              ?>
              <?php
              $query = "SELECT DISTINCT
              g.id_guia,
              g.personasEnv_id,
              g.cod_destino,
              g.personasDest_id,
              g.tipo_bulto,
              g.fecha_emb,
              g.cantidad_bulto,
              g.peso_real,
              g.empaquetado,
              g.numero,
              g.peso_volumetrico,
              g.electronico
          FROM
              guia_embarque AS g
              INNER JOIN manif_embarq AS m ON g.id_guia = m.guia_id
          WHERE
              m.manifiesto_id = '$id_manifiesto'";
              $result2 = mysqli_query($conexion, $query);

              while ($row = mysqli_fetch_array($result2)) {
                ?>
                <tr>
                  <td>
                    <?php
                    $length = 5;
                    $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length); ?>
                    <input type="checkbox" name="guia[]" value=<?php echo $guia; ?>><?php echo $guia; ?></input>
                  </td>

                  <?php
                  $envia = $row['personasEnv_id'];
                  $queryEnvia = "SELECT * FROM personas WHERE id_persona =$envia";
                  $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                  while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                    </td>
                    <?php
                  }
                  $destinatario = $row['personasDest_id'];
                  $queryDest = "SELECT * FROM personas  WHERE id_persona =$destinatario";
                  $resultadoDest = mysqli_query($conexion, $queryDest);
                  while ($rowDest = $resultadoDest->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?>
                    </td>
                    <?php
                  }
                  $origen = $row['cod_destino'];
                  $queryOrigen = "SELECT * FROM cod_pais WHERE id_pais=$origen";
                  $resultadoOrigen = mysqli_query($conexion, $queryOrigen);
                  while ($rowOrigen = $resultadoOrigen->fetch_assoc()) { ?>
                    <td>
                      <?php echo $rowOrigen['codigo']; ?>
                    </td>
                  <?php }
                  ?>
                  <td>
                    <?php echo $row['fecha_emb']; ?>
                  </td>
                  <td>
                    <?php echo $row['cantidad_bulto']; ?>
                  </td>
                  <td>
                    <?php echo $row['peso_volumetrico']; ?>
                  </td>
                  <td>
                    <?php echo $row['electronico']; ?>
                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- Datos complementarios del manifiesto-->
        <?php if (!empty($datos)) { ?>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6 div-nuevo">
                <label>NÚMERO EXTERNO</label>
                <input type="text" name="numero" id="numero" value=<?php echo $numero ?> class='form-control' maxlength="50"
                  required></input>
              </div>
              <div class="col-md-6 div-nuevo">
                <label>FLIGHT</label>
                <input type="text" name="vuelo" id="vuelo" value="<?php echo isset($vuelo) ? $vuelo : ''; ?>"
                  class="form-control" maxlength="500" required>
              </div>
              <div class="col-md-6 div-nuevo">
                <label>FECHA ARRIBO</label>
                <input type="datetime-local" name="fechaarribo" id="fechaarribo"
                  value="<?php echo isset($fecha_arribo) ? $fecha_arribo : ''; ?>" class="form-control" maxlength="500"
                  required>
              </div>
              <div class="col-md-6 div-nuevo">
                <label>SHIPPER</label>
                <input type="text" name="expedidor" id="expedidor" class="form-control" required
                  value="<?php echo isset($expedidor) ? $expedidor : ''; ?>" />
              </div>
              <div class="col-md-6 div-nuevo">
                <label>CONSIGNEE</label>
                <input type="text" name="consignatario" id="consignatario" class='form-control' required
                  value="<?php echo isset($consignatario) ? $consignatario : ''; ?>" />
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 div-nuevo">
                <input type="hidden" name="cod_origen" id="cod_origen" class='form-control' maxlength="20" value=<?php echo $cod_origen; ?> />
              </div>
              <div class="col-md-4 div-nuevo">
                <input type="hidden" name="cod_destino" id="cod_destino" class='form-control' maxlength="25" value=<?php echo $cod_destino; ?> />
              </div>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" name="update" value="Guardar manifiesto" />
        <?php } ?>
      </form>
    </div>
  <?php } ?>
  </main>
</div>
</div>
<script src="js/main.js"></script>