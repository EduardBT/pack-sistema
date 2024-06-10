<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

// Mostrar todos los registros o aplicar búsqueda
$where = "WHERE rol = 'cliente'";
$valor = isset($_POST["campo"]) ? $_POST["campo"] : ""; // Obtener el valor de búsqueda

if (!empty($valor)) {
  $where = "WHERE rol = 'cliente' AND (dni LIKE '%$valor%' OR nombre LIKE '%$valor%' OR apellidos LIKE '%$valor%' OR departamento LIKE '%$valor%')";
}

// Mostrar registros con paginación
$records_per_page = 9; // Número de registros a mostrar por página
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Obtener página actual
$offset = ($current_page - 1) * $records_per_page;

// Consulta para mostrar los registros con paginación y búsqueda aplicada
$query = "SELECT * FROM personas $where ORDER BY id_persona DESC LIMIT $offset, $records_per_page";
$result = mysqli_query($conexion, $query);

// Obtener el total de registros para la paginación
$query_total = "SELECT COUNT(*) as total FROM personas $where";
$result_total = mysqli_query($conexion, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $records_per_page);

// Calcular el rango de páginas a mostrar
$max_pages_to_show = 5; // Número máximo de páginas a mostrar
$start_page = max(1, $current_page - floor($max_pages_to_show / 2));
$end_page = min($total_pages, $start_page + $max_pages_to_show - 1);

?>

<div class="card shadow full-screen" style="padding:2%;margin-left:1px; background-color: #fff;">
  <!-- Mostrar mensaje si existe $_SESSION['message'] -->
  <?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert"
      style="position: absolute; z-index: 9999; top: 0; left: 0; right: 0;">
      <?= $_SESSION['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']);
  } ?>

  <div class="card-header" style="padding:0 0 10px 0">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="mb-0"> <i class="bi bi-people"></i> CLIENTES</h3>
      <a href="nuevo-cliente.php" class="btn btn-success">
        <i class="bi bi-plus" style="margin-right:5px"></i>Agregar
      </a>
    </div>
  </div>
  <form method="POST">
    <div class="input-group mt-3">
      <input class="form-control" type="search" id="busqueda" name="campo" placeholder="Buscar..." aria-label="Buscar"
        style="border-radius:0">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="enviar-nombre" style="border-radius:0"><i
            class="bi bi-search"></i></button>
      </div>
    </div>
  </form>
  <div class="table-responsive" style="width:100%">
    <table class="table table-hover table-nowrap">
      <thead class="thead-light">
        <tr>
          <th scope="col">Documento</th>
          <th scope="col">Nombre y Apellidos</th>
          <th scope="col">Dirección</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Departamento</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Recorrer tabla de resultados
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
              <td>
                <?php echo $row['dni']; ?>
              </td>
              <td>
                <?php echo $row['nombre'] . ' ' . $row['apellidos']; ?>
              </td>
              <td>
                <?php echo $row['direccion']; ?>
              </td>
              <td>
                <?php echo $row['tel']; ?>
              </td>
              <td>
                <?php echo $row['departamento']; ?>
              </td>
              <td class="text-end">
                <button type="button" class="btn btn-sm btn-neutral" id="btn-ver" onclick="openModal('<?php echo $row['dni']; ?>',
                                    '<?php echo $row['nombre']; ?>',
                                    '<?php echo $row['apellidos']; ?>',
                                    '<?php echo $row['tel']; ?>',
                                    '<?php echo $row['direccion']; ?>',
                                    '<?php echo $row['departamento']; ?>',
                                    '<?php echo $row['cod_postal']; ?>',
                                    '<?php echo $row['correo']; ?>')">Ver</button>
                <a href="editar-cliente.php?id=<?php echo $row['id_persona']; ?>"
                  class="btn btn-sm btn-square btn-outline-primary">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm btn-square btn-outline-danger"
                  onclick="confirmarEliminacion(<?php echo $row['id_persona']; ?>)"><i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
            <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="6" class="text-center">No se encontraron registros.</td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>

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
</div>

<!-------------------------------------------  Modal Ver Persona ----------------------------------------->

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalText">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------  SCRIPTS --------------------------------------------------------------->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/cliente.js"></script>