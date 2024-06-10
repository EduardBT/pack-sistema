<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

//Buscador
$where = "";
if (isset($_POST["enviar-nombre"])) {
  $valor = $_POST['campo'];
  if (!empty($valor)) {
    $where = "AND id_manifiesto LIKE '%$valor%'";
  }
} ?>
<style>
  .form-check-input {
    margin-right: 10px;
  }
</style>
<div class="card shadow full-screen" style="padding:2%;margin-left:1px; background-color: #fff;">
  <!--Mostrar msj si existe $_SESSION['message']-->
  <?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']);
  } ?>
  <div class="card-header" style="padding:0 0 10px 0">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="mb-0"><i class="bi bi-folder" style="margin-right:10px"></i>MANIFIESTOS</h3>
      <a href="nuevo_manifiesto.php" class="btn btn-success"><i class="bi bi-plus"
          style="margin-right:5px"></i>Agregar</a>
    </div>
  </div>
  <?php
  // Mostrar registros con paginación
  $records_per_page = 2; // Número de registros a mostrar por página
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Obtener página actual
  $offset = ($current_page - 1) * $records_per_page;

  // Consulta para mostrar los registros con paginación y búsqueda aplicada
  $query = "SELECT * FROM manifiesto WHERE estado_id= 1 ORDER BY id_manifiesto DESC LIMIT  $offset, $records_per_page";
  $result = mysqli_query($conexion, $query);
  // Obtener el total de registros para la paginación
  $query_total = "SELECT COUNT(*) as total FROM manifiesto WHERE estado_id= 1";
  $result_total = mysqli_query($conexion, $query_total);
  $row_total = mysqli_fetch_assoc($result_total);
  $total_records = $row_total['total'];
  $total_pages = ceil($total_records / $records_per_page);

  // Calcular el rango de páginas a mostrar
  $max_pages_to_show = 5; // Número máximo de páginas a mostrar
  $start_page = max(1, $current_page - floor($max_pages_to_show / 2));
  $end_page = min($total_pages, $start_page + $max_pages_to_show - 1);

  ?>
  <form method="POST">
    <div class="input-group mt-3">
      <input class="form-control" type="search" id="busqueda" name="campo" placeholder="Buscar..." aria-label="Buscar"
        onkeyup="buscar()" style="border-radius:0">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="enviar-nombre" style="border-radius:0;height: 47px"><i
            class="bi bi-search"></i></button>
      </div>
    </div>
  </form>
  <div class="table-responsive">
    <table class="table table-hover table-nowrap">
      <thead class="thead-light">
        <tr>
          <th scope="col">Número Externo</th>
          <th scope="col">Destino</th>
          <th scope="col">Fecha Embarque</th>
          <th scope="col">Vuelo</th>
          <?php
          if ($_SESSION["nombre_usuario"] === "carlos") {
            ?>
            <th scope="col">Arribo Panamá</th>
            <th scope="col">Arribo Cuba</th>
            <?php
          }
          ?>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_array($result)) {

          ?>
          <tr>
            <td>
              <?php echo $row['numero']; ?>
            </td>
            <?php
            $origen = $row['cod_destino'];
            $queryOrigen = "SELECT * FROM cod_pais WHERE id_pais=$origen";
            $resultadoOrigen = mysqli_query($conexion, $queryOrigen);
            while ($rowOrigen = $resultadoOrigen->fetch_assoc()) {
              ?>
              <td>
                <?php echo $rowOrigen['codigo']; ?>
              </td>
            <?php } ?>
            <?php
            $fecha = strtotime($row['fecha']);
            $newdate = date("d-m-Y", $fecha);
            ?>
            <td>
              <?php echo $newdate; ?>
            </td>
            <td>
              <?php echo $row['vuelo']; ?>
            </td>
            <?php
            if ($_SESSION["nombre_usuario"] === "carlos") {
              ?>
              <td>
                <input type="checkbox" class="check-llegada-pan" data-id-manifiesto="<?php echo $row['id_manifiesto']; ?>"
                  <?php echo ($row['llegada_pan'] == 1) ? 'checked' : ''; ?>>
              </td>
              <td>
                <input type="checkbox" class="check-llegada-cub" data-id-manifiesto="<?php echo $row['id_manifiesto']; ?>"
                  <?php echo ($row['llegada_cub'] == 1) ? 'checked' : ''; ?>>
              </td>
              <?php
            }
            ?>
            <td>
              <a class="btn btn-sm btn-square btn-outline-primary" data-toggle="popover" title="Editar"
                href="editar-manifiesto.php?id_manifiesto=<?php echo $row['id_manifiesto']; ?>"><i
                  class="bi bi-pencil-fill"></i></a>
              <?php
              if ($_SESSION["nombre_usuario"] === "carlos") { ?>
                <a class="btn btn-sm btn-square btn-outline-danger" data-toggle="popover" title="Eliminar"
                  onclick="return  confirm('¿Desea eliminar el registro?')"
                  href="eliminar-manifiesto.php?id_manifiesto=<?php echo $row['id_manifiesto']; ?>"><i
                    class="bi bi-trash-fill"></i></a>
              <?php } ?>

              <button type="button" onclick="crearPDF(<?php echo $row['id_manifiesto']; ?>)"
                class="btn btn-sm btn-square  btn-outline-success">
                <i class="bi bi-file-earmark-spreadsheet"></i></i></button>
              <button type="button" onclick="crearXML(<?php echo $row['id_manifiesto']; ?>)"
                class="btn btn-sm btn-square   btn-neutral">
                <i class="bi bi-file-earmark-code"></i></button>
              <?php if (strlen($row['numero']) > 1) { ?>
                <a class="btn btn-sm btn-square btn-neutral" target="_black" data-toggle="popover"
                  href="reportes/pdf-manifiesto.php?id_manifiesto=<?php echo $row['id_manifiesto']; ?>&guiaAWB=<?php echo $row['numero'] ?>"><i
                    class="bi bi-printer-fill"></i></a>
              <?php } else { ?>
                <a class="btn btn-sm btn-square btn-neutral" data-toggle="popover"
                  href="javascript:AlertIt(<?php echo $row['id_manifiesto']; ?>);"><i class="bi bi-printer-fill"></i></a>
              <?php } ?>

              <?php if ($_SESSION['nombre_usuario'] === 'desarrollo') { ?>
                <a class="btn btn-sm btn-square btn-neutral" data-toggle="popover" title="Cerrar"
                  href="javascript:AlertAutorizacion(<?php echo $row['id_manifiesto']; ?>);"><i
                    class="bi bi-x-square-fill"></i></a>
              <?php } ?>
              <?php
              if ($_SESSION["nombre_usuario"] == "carlos") {
                ?>
                <a class="btn btn-sm btn-square btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                  onclick="setManifiestoValue('<?php echo $row['id_manifiesto']; ?>')">
                  <i class="bi bi-geo-fill"></i>
                </a>
                <?php
              }
              ?>
            </td>
          </tr>
        <?php } ?>
        <?php unset($_SESSION['roll']); ?>
      </tbody>
    </table>
  </div>
  <!-- Paginación -->
  <nav style="margin-top:15px">
    <ul class="pagination justify-content-center">
      <?php if ($current_page > 1) { ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo ($current_page - 1); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Anterior</span>
          </a>
        </li>
      <?php } ?>

      <?php if ($start_page > 1) { ?>
        <li class="page-item">
          <a class="page-link" href="?page=1">1</a>
        </li>
        <li class="page-item disabled">
          <span class="page-link">...</span>
        </li>
      <?php } ?>

      <?php for ($i = $start_page; $i <= $end_page; $i++) { ?>
        <li class="page-item <?php if ($i == $current_page)
          echo 'active'; ?>">
          <a class="page-link bg-primary text-white" href="?page=<?php echo $i; ?>">
            <?php echo $i; ?>
          </a>
        </li>
      <?php } ?>

      <?php if ($end_page < $total_pages) { ?>
        <li class="page-item disabled">
          <span class="page-link">...</span>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo $total_pages; ?>">
            <?php echo $total_pages; ?>
          </a>
        </li>
      <?php } ?>

      <?php if ($current_page < $total_pages) { ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo ($current_page + 1); ?>" aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Siguiente</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </nav>
</div>
</main>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          onclick="limpiarFormulario()"></button>
      </div>
      <div class="modal-body">
        <form class="" method="POST" action="consulta_rastreo.php" autocomplete="off" id="formulario">
          <table class="table">
            <thead>
              <tr>
                <th>Fecha - Hora</th>
                <th>Hito</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="datetime-local" name="fecha1" class="form-control"></td>
                <td id="hito1" value="ENVIO SOLICITADO POR LA WEB"><input type="checkbox" name="hito1"
                    class="form-check-input" value="ENVIO SOLICITADO POR LA WEB">ENVIO SOLICITADO POR LA WEB
                </td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha2" class="form-control"></td>
                <td id="hito2" value="PARTIENDO DE ORIGEN O PUNTO DE TRÁNSITO - MVD"><input type="checkbox" name="hito2"
                    class="form-check-input" value="PARTIENDO DE ORIGEN O PUNTO DE TRÁNSITO - MVD">PARTIENDO DE ORIGEN O
                  PUNTO DE TRÁNSITO - MVD</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha3" class="form-control"></td>
                <td id="hito3" value="RECIBIDO EN PUNTO DE TRÁNSITO - PTY"><input type="checkbox" name="hito3"
                    value="RECIBIDO EN PUNTO DE TRÁNSITO - PTY" class="form-check-input">RECIBIDO EN PUNTO DE
                  TRÁNSITO - PTY</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha4" class="form-control"></td>
                <td id="hito4" value="PARTIENDO DE ORIGEN O PUNTO DE TRÁNSITO - PTY"><input type="checkbox" name="hito4"
                    value="PARTIENDO DE ORIGEN O PUNTO DE TRÁNSITO - PTY" class="form-check-input">PARTIENDO DE ORIGEN O
                  PUNTO
                  DE TRÁNSITO - PTY</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha5" class="form-control"></td>
                <td id="hito5" value="RECIBIDO EN DESTINO - HAV"><input type="checkbox" name="hito5"
                    value="RECIBIDO EN DESTINO - HAV" class="form-check-input">RECIBIDO EN DESTINO - HAV</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha6" class="form-control"></td>
                <td id="hito6" value="LLEGO AL CENTRO DE DISTRIBUCION"><input type="checkbox" name="hito6"
                    value="LLEGO AL CENTRO DE DISTRIBUCION" class="form-check-input">LLEGO AL CENTRO DE
                  DISTRIBUCION</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha7" class="form-control"></td>
                <td id="hito7" value="EN PROCESO DE ADUANA"><input type="checkbox" name="hito7"
                    value="EN PROCESO DE ADUANA" class="form-check-input">EN PROCESO DE ADUANA</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha8" class="form-control"></td>
                <td id="hito8" value="LIBERADO POR ADUANA"><input type="checkbox" name="hito8"
                    value="LIBERADO POR ADUANA" class="form-check-input">LIBERADO POR ADUANA</td>
              </tr>
              <tr>
                <td><input type="datetime-local" name="fecha9" class="form-control"></td>
                <td id="hito9" value="ENVÍO ENTREGADO - HAV"><input type="checkbox" name="hito9"
                    value="ENVÍO ENTREGADO - HAV" class="form-check-input">ENVÍO ENTREGADO - HAV</td>
              </tr>
            </tbody>
          </table>
          <div class="modal-footer">
            <div class="form-group">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                onclick="limpiarFormulario()">Cerrar</button>
              <button type="submit" name="guardar_rastreo" class="btn btn-primary">Guardar cambios</button>
              <input type="text" id="id_manifiestoModal" name="id_manifiesto" hidden>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script src="js/main.js"></script>
<script src="js/xlsx.full.min.js"></script>
<script src="js/xlsx.bundle.js"></script>
<script src="js/manifiesto.js"></script>
<?php
$queryrast = "SELECT manifiesto_id, fecha_hora, hito FROM rastreo";
$resultrast = mysqli_query($conexion, $queryrast);
$rastreosAgrupados = array();

while ($rowRastreo = mysqli_fetch_array($resultrast)) {
  $manifiesto_id = $rowRastreo['manifiesto_id'];
  if (!isset($rastreosAgrupados[$manifiesto_id])) {
    $rastreosAgrupados[$manifiesto_id] = array();
  }
  $rastreo = array(
    'fecha_hora' => $rowRastreo['fecha_hora'],
    'hito' => $rowRastreo['hito']
  );
  $rastreosAgrupados[$manifiesto_id][] = $rastreo;
}

// Convertir $rastreosAgrupados a formato JSON
$rastreosAgrupadosJson = json_encode($rastreosAgrupados);
?>
<script>
  function limpiarFormulario() {
    document.getElementById("id_manifiestoModal").value = "";
    var formulario = document.getElementById("formulario");
    formulario.reset();
  }
  function setManifiestoValue(id_manifiesto) {
    document.getElementById('id_manifiestoModal').value = id_manifiesto;
    let rastreos = JSON.parse('<?php echo $rastreosAgrupadosJson; ?>');

    for (var clave in rastreos) {
      if (rastreos.hasOwnProperty(clave)) {
        var rastreo = rastreos[clave];

        if (clave === id_manifiesto) {
          for (var i = 0; i < rastreo.length; i++) {
            var fechaHora = rastreo[i].fecha_hora;
            var hito = rastreo[i].hito;
            var hitoElement = document.getElementById('hito' + (i + 1));
            console.log(fechaHora);

            if (hitoElement !== null) {
              if (hitoElement.getAttribute('value') === rastreo[i].hito) {
                document.getElementsByName('fecha' + (i + 1))[0].value = fechaHora;
                document.getElementsByName('hito' + (i + 1))[0].checked = true;
              }
            } else {
              console.log('No se encontró el elemento con id: ' + 'hito' + (i + 1));
            }
          }
        }
      }
    }
  }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    $('.check-llegada-pan').change(function () {
      var idManifiesto = $(this).data('id-manifiesto');
      var llegadaPan = $(this).prop('checked') ? 1 : 0;

      $.ajax({
        url: 'actualizar_rastreo.php',
        method: 'POST',
        data: {
          id_manifiesto: idManifiesto,
          llegada_pan: llegadaPan
        },
        success: function (response) {
          console.log('Actualización de llegada_pan exitosa');
        },
        error: function (xhr, status, error) {
          console.error('Error en la actualización de llegada_pan');
        }
      });
    });

    $('.check-llegada-cub').change(function () {
      var idManifiesto = $(this).data('id-manifiesto');
      var llegadaCub = $(this).prop('checked') ? 1 : 0;

      $.ajax({
        url: 'actualizar_rastreo.php',
        method: 'POST',
        data: {
          id_manifiesto: idManifiesto,
          llegada_cub: llegadaCub
        },
        success: function (response) {
          console.log('Actualización de llegada_cub exitosa');
        },
        error: function (xhr, status, error) {
          console.error('Error en la actualización de llegada_cub');
        }
      });
    });
  });
</script>