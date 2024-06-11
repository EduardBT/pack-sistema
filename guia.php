<script type="text/javascript">
  function AlertIt(id) {
    let guiaAWB = prompt('Introduzca el número de guía:');
    var win = window.open('reportes/pdf-guia-ena.php?id=' + id + "&" + "guiaAWB=" + guiaAWB, '_blank')
    win.focus();
  }
</script>
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
    $where = " WHERE ( id_guia LIKE '%$valor%')";
  }
}
?>
<div class="card shadow full-screen" style="margin-left:1px; background-color: #fff;">
  <!--Mostrar msj si existe $_SESSION['message']-->
  <?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert"
      style="z-index: 999999; text-aling: center">
      <?= $_SESSION['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']);
  } ?>
  <div class="card-header" style="padding:0 0 10px 0">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="mb-0"><i class="bi bi-list-check"></i>GUÍAS DE EMBARQUE</h3>
      <a href="multi_embarque.php" class="btn btn-success"><i class="bi bi-plus"
          style="margin-right:5px"></i>Agregar</a>
    </div>
  </div>
  <?php
  // Mostrar registros con paginación
  $records_per_page = 25; // Número de registros a mostrar por página
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Obtener página actual
  $offset = ($current_page - 1) * $records_per_page;

  // Consulta para mostrar los registros con paginación y búsqueda aplicada
  $query = "SELECT * FROM guia_embarque ORDER BY id_guia DESC LIMIT  $offset, $records_per_page";
  $result = mysqli_query($conexion, $query);
  // Obtener el total de registros para la paginación
  $query_total = "SELECT COUNT(*) as total FROM guia_embarque $where";
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
        style="border-radius:0">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="enviar-nombre" style="border-radius:0; height:47px;"><i
            class="bi bi-search"></i></button>
      </div>
    </div>
  </form>
  <div class="table-responsive" style="width:100%;">
    <table class="table table-hover table-nowrap">
      <!-- Encabezados de la tabla -->
      <thead class="thead-light">
        <tr>
          <th scope="col">Guía</th>
          <th scope="col">Remitente</th>
          <th scope="col">Destinatario</th>
          <th scope="col">Destino</th>
          <th scope="col">Fecha</th>
          <th scope="col">Piezas</th>
          <th scope="col">Peso (kg)</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php

        //Recorrer tabla
        while ($row = mysqli_fetch_array($result)) { ?>
          <tr>
            <td>
              <?php
              $length = 9;
              $guia = substr(str_repeat(0, $length) . $row['id_guia'], -$length);
              echo $guia; ?>
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
            <?php $tipo = $row['tipo_bulto']; ?>
            <td>
              <?php echo $row['cantidad_bulto']; ?>
            </td>
            <td>
              <?php echo $row['peso_real']; ?>
            </td>
            <td>
              <a class="btn btn-sm btn-square btn-outline-primary"
                href="editar-guia.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-pencil-fill"></i></a>
              <a class="btn btn-sm btn-square btn-outline-danger"
                onclick="return  confirm('¿Desea eliminar el registro?')"
                href="eliminar-guia.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-trash-fill"></i></a>
              <?php
              if ($row['tipo_bulto'] == 'ENA') {
                if (strlen($row['numero']) > 1) {
                  ?> <a class="btn btn-sm btn-square btn-outline-danger" target="_black" data-toggle="popover"
                    href="reportes/pdf-guia-ena.php?id=<?php echo $row['id_guia']; ?>&guiaAWB=<?php echo $row['numero'] ?>"><i
                      class="bi bi-printer-fill"></i></a>

                <?php } else { ?>
                  <a class="btn btn-sm btn-square btn-outline-dark" data-toggle="popover"
                    href="javascript:AlertIt(<?php echo $row['id_guia']; ?>);"><i class="bi bi-printer-fill"></i></a>

                  <?php
                }
              } else { ?>
                <a class="btn btn-sm btn-square btn-outline-dark" target="_black" data-toggle="popover"
                  href="reportes/generarGuia.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-printer-fill"></i></a>
                <a class="btn btn-sm btn-square btn-outline-dark" target="_black"
                  href="reportes/pdf-guiaa.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-printer-fill"></i></a>
                <?php
              } ?>
              <a class="btn btn-sm btn-square btn-outline-dark" target="_black" data-toggle="popover"
                href="reportes/pdfContrato.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-file-text"></i></a>

              <a class="btn btn-sm btn-square btn-outline-primary" target="_black" data-toggle="popover"
                href="nueva-declaracion.php?id=<?php echo $row['id_guia']; ?>"><i class="bi bi-clipboard-check"></i></a>
            </td>
          </tr>
        <?php } ?>
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
<!--------------------------- SCRIPTS --------------------------------------------------------------------------->
<script a src="js/main.js"></script>
<script>
  $(document).ready(function () {
    $('#busqueda').on('keyup', function () {
      var value = $(this).val().toLowerCase();
      $('tbody tr').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>