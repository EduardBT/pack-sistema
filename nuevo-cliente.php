<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

if (isset($_GET['regreso'])) {
    $regreso = $_GET['regreso'];
} else {
    $regreso = "clientes";
}
?>
<script src="js/cliente.js"></script>
<br>
<div class="card container  full-screen shadow" style="margin-top:3%">
    <form class="" method="POST" action="guardar-cliente.php" autocomplete="off">
        <div class="form-group">
            <div class="row">
                <h2 style="margin-bottom:25px"><i class="bi bi-person-plus" style="margin-right:15px"></i>AGREGAR
                    CLIENTE
                </h2>
                <hr>
                <div class="col-md-6 div-nuevo">
                    <label>Documento de Identidad:</label>
                    <input type="text" name="dni" id="dni" class='form-control' maxlength="50" required></input>
                </div>
                <div class="col-md-6 div-nuevo">
                    <label>Fecha Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class='form-control'
                        maxlength="20"></input>
                </div>
                <div class="col-md-6 div-nuevo">
                    <label>Nombre(s):</label>
                    <input type="text" name="nombre" id="nombre" class='form-control' maxlength="25" required></input>
                </div>
                <div class="col-md-6 div-nuevo">
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" id="apellidos" class='form-control' maxlength="25"
                        required></input>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6 div-nuevo">
                    <label for="direccion" class="col-sm-6 control-label">Residencia:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="col-md-6 div-nuevo">
                    <label for="calle" class="col-sm-6 control-label">Calle:</label>
                    <input type="text" class="form-control" id="calle" name="calle">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 div-nuevo">
                        <label for="entre" class="col-md-6 control-label">Entre:</label>
                        <input type="text" class="form-control" id="entre" name="entre">
                    </div>
                    <div class="col-md-3 div-nuevo">
                        <label for="num" class="col-md-6 control-label">Número:</label>
                        <input type="text" class="form-control" id="num" name="num">
                    </div>
                    <div class="col-md-3 div-nuevo">
                        <label for="edificio" class="col-md-6 control-label">Edificio:</label>
                        <input type="text" class="form-control" id="edificio" name="edificio">
                    </div>
                    <div class="col-md-3 div-nuevo">
                        <label for="apartamento" class="col-md-12 control-label">Apartamento:</label>
                        <input type="text" class="form-control" id="apartamento" name="apartamento">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 div-nuevo">
                    <label>País:</label>
                    <select id="country-select" name="pais" class="form-select" aria-label="Default select example"
                        required>
                        <?php
                        $query = "SELECT * FROM cod_pais ORDER BY descripcion ASC";
                        $result = mysqli_query($conexion, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['id_pais'] == $cod_origen) {
                                echo '<option selected="' . $cod_origen . '" value="' . $cod_origen . '">' . $rowOrg['codigo'] . '</option>';
                            } else {
                                echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . ' </option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label for="municipio-input" id="labelDept">Departamento:</label>
                    <input type="text" class="form-control" id="provincia-input" name="departamentos">
                    <select id="provincia-select" class="form-select" name="provincia-select"
                        onchange="loadMunicipios()" style="display: none;">
                        <option value="">Provincia</option>
                    </select>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label for="municipio-select" class="labelCuba" style="display: none;">Municipios:</label>
                    <select id="municipio-select" class="form-select" name="departamento" style="display: none;"
                        onchange="mostrarCodigoPostal()">
                        <option value="">Municipio</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 div-nuevo">
                    <label for="cod_postal" class="col-sm-8 control-label">Código Postal:</label>
                    <input type="text" class="form-control" id="cod_postal" name="cod_postal" required>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label for="telefono" class="col-sm-8 control-label">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono" name="tel" required>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label for="email" class="col-sm-8 control-label">Email:</label>
                    <input type="email" class="form-control" id="correo" name="correo">
                    <input type="hidden" class="form-control" id="regreso" name="regreso" value=<?php echo $regreso; ?>>
                </div>
            </div>
        </div>
        <br>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="guardar_cliente" class="btn btn-primary"><i class="bi bi-save"
                        style="margin-right:8px"></i>Guardar</button>
                <button type="button" class="btn btn-neutral" style="heigth:80px">
                    <?php if ($regreso == "remitente") { ?> <a href="multi_embarque.php">
                        <?php } else { ?> <a href="gestion.php">
                            <?php } ?> Cancelar
                        </a>
                </button>
            </div>
        </div>
    </form>
</div>
</main>