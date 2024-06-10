<?php
include "conexion.php";
include_once "includes/header.php";

$valorSelect = $_POST["valorSelect"]; //recojemos lo seleccionado
$query = "SELECT * FROM personas where id_persona= $valorSelect";
$result = mysqli_query($conexion, $query);


/*$query=mysqli_query($conn,"SELECT * FROM boletin WHERE Departamento = '" . $valorSelect . "'");*/

$row = mysqli_fetch_array($result);


$query_pais = "SELECT * FROM cod_pais WHERE id_pais = " . $row['pais'];
$result_pais = mysqli_query($conexion, $query_pais);
$row_pais = mysqli_fetch_assoc($result_pais);

?>
<h3 class="text-primary" style="margin-top:15px">Datos del remitente:</h3><br>
<form>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="nombreApellidos" class="form-label">Documento de Identificación:</label>
            <input type="text" class="form-control" id="dni" value="<?php echo $row['dni']; ?>" readonly>
        </div>
        <div class="mb-3 col-md-6">
            <label for="nombreApellidos" class="form-label">Nombre y Apellidos:</label>
            <input type="text" class="form-control" id="nombreApellidos"
                value="<?php echo $row['nombre'] . ' ' . $row['apellidos']; ?>" readonly>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" value="<?php echo $row['direccion']; ?>" readonly>
        </div>
        <div class="mb-3  col-md-6">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" value="<?php echo $row['tel']; ?>" readonly>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="correo" class="form-label">País:</label>
            <input type="email" class="form-control" id="pais" value="<?php echo $row_pais['descripcion']; ?>" readonly>
        </div>
        <div class="mb-3  col-md-6">
            <label for="correo" class="form-label">Departamento:</label>
            <input type="email" class="form-control" id="cod_postal" value="<?php echo $row['departamento']; ?>"
                readonly>
        </div>
    </div>
    <div class="row">
        <div class="mb-3  col-md-6">
            <label for="correo" class="form-label">Código Postal:</label>
            <input type="email" class="form-control" id="cod_postal" value="<?php echo $row['cod_postal']; ?>" readonly>
        </div>
        <div>
</form>