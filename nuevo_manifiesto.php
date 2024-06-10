<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";
//buscador
$where = "";
if (isset($_POST["enviar-pais"])) {
  $cod_origen = $_POST['cod_origen'];
  $cod_destino = $_POST['cod_destino'];
  $fecha_desde = $_POST['fecha_desde'];
  $fecha_hasta = $_POST['fecha_hasta'];

  if (!empty($cod_origen) && !empty($cod_destino)) { // Es obligatorio seleccionar un origen y destino
    $where = "WHERE (cod_origen = '$cod_origen' AND cod_destino = '$cod_destino'";
    if (!empty($fecha_desde) && !empty($fecha_hasta)) {
      $where .= " AND fecha_emb BETWEEN '$fecha_desde' AND '$fecha_hasta'";
    } elseif (!empty($fecha_desde)) {
      $where .= " AND fecha_emb >= '$fecha_desde'";
    } elseif (!empty($fecha_hasta)) {
      $where .= " AND fecha_emb <= '$fecha_hasta'";
    } else {
      $fecha_actual = date('Y-m-d');
      $where .= " AND fecha_emb <= '$fecha_actual'";
    }
    $where .= ")";
  }
}
?>
<!--Mostrar msj si existe $_SESSION['message']-->
<?php if (isset($_SESSION['message'])) { ?>
  <div class="alert alert-<?= $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert">
    <?= $_SESSION['message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['message']);
} ?>
<div class="card container  full-screen shadow" style="margin-top:5%">
  <div class="text-center">
    <h3>Selección de Guías</h3>
  </div>
  <hr>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <div class="col-md-12">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="cod_destino">País de Origen:</label>
              <select id="cod_origen" name="cod_origen" class="form-select" aria-label="Default select example">
                <option value="0">Seleccione...</option>
                <?php
                $query = "SELECT * FROM cod_pais";
                $result = mysqli_query($conexion, $query);
                while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="cod_destino">País de Destino:</label>
              <select id="cod_destino" name="cod_destino" class="form-select" aria-label="Default select example">
                <option value="0">Seleccione...</option>
                <?php
                $query = "SELECT * FROM cod_pais";
                $result = mysqli_query($conexion, $query);
                while ($row = mysqli_fetch_array($result)) {
                  echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="fecha_desde">Fecha Desde:</label>
              <input type="date" id="fecha_desde" name="fecha_desde" class="form-control"
                aria-label="Default select example">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="fecha_hasta">Fecha Hasta:</label>
              <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control"
                aria-label="Default select example">
            </div>
          </div>
          <div class="col-md-2" style="margin-top:25px">
            <button type="submit" class="btn btn-primary" name="enviar-pais" value="Buscar">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (!empty($cod_origen) and !empty($cod_destino)) { ?>

    <form action="guardar_manifiesto.php" method="post">
      <div class="table-responsive">
        <button id="checkAllButton">Seleccionar todo</button>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Número de guía</th>
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
            $query = "SELECT * FROM guia_embarque $where";
            $result = mysqli_query($conexion, $query);
            //recorrer tabla
            while ($row = mysqli_fetch_array($result)) {
              $datos = 'si'; ?>
              <tr>
                <td>
                  <?php
                  $length = 9;
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
                  <?php echo $row['peso_real']; ?>
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
            <div class="col-md-4 div-nuevo">
              <label>FLIGHT</label>
              <input type="text" name="vuelo" id="vuelo" class='form-control' maxlength="50" required></input>
            </div>
            <div class="col-md-4 div-nuevo">
              <label>NÚMERO EXTERNO</label>
              <input type="text" name="numero" id="numero" class='form-control' maxlength="50" required></input>
            </div>
            <div class="col-md-4 div-nuevo">
              <label>Fecha Arribo:</label>
              <input type="datetime-local" name="fechaarribo" id="fechaarribo" class="form-control" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 div-nuevo">
              <label>SHIPPER</label>
              <select class="form-select" aria-label="Default select example" id="expedidor" name="expedidor">
                <option selected>Seleccione:</option>
                <option value="FERIBAN S.A. Aeropuerto Int´l. de Carrasco TCU of 116 Montevideo - Uruguay">Ferriban</option>
                <option value="DOX">DOX</option>
                <option value="ENA">ENA</option>
              </select>

            </div>
            <div class="col-md-6 div-nuevo">
              <label>CONSIGNEE</label>
              <input name="consignatario" id="consignatario" class='form-control' required></input>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 div-nuevo">

              <input type="hidden" name="cod_origen" id="cod_origen" class='form-control' maxlength="20" value=<?php echo $cod_origen; ?>></input>
            </div>
            <div class="col-md-4 div-nuevo">

              <input type="hidden" name="cod_destino" id="cod_destino" class='form-control' maxlength="25" value=<?php echo $cod_destino; ?>></input>
            </div>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" name="manifiesto" value="Generar manifiesto" />
      <?php } ?>
  </div>
  </form>
<?php } ?>
</main>
</div>
</div>
</div>
<script src="js/main.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var checkAllButton = document.getElementById('checkAllButton');
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var isChecked = false;

    function toggleCheckboxes() {
      for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = isChecked;
      }
    }

    function updateButtonLabel() {
      if (isChecked) {
        checkAllButton.textContent = 'Deseleccionar todo';
      } else {
        checkAllButton.textContent = 'Seleccionar todo';
      }
    }

    checkAllButton.addEventListener('click', function () {
      isChecked = !isChecked;
      toggleCheckboxes();
      updateButtonLabel();
    });
  });
</script>