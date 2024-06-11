<?php
include ("session.php");
include ("conexion.php");

//trae los datos de la base
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM personas WHERE id_persona = $id";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);

        $dni = $row['dni'];
        $nombre = $row['nombre'];
        $apellidos = $row['apellidos'];
        $direccion = $row['direccion'];
        $pais = $row['pais'];
        $departamento = $row['departamento'];
        $provincia = $row['provincia'];
        $cod_postal = $row['cod_postal'];
        $tel = $row['tel'];
        $correo = $row['correo'];
    }
}
if (isset($_GET['regreso'])) {
    $regreso = $_GET['regreso'];
} else {
    $regreso = "clientes";
}
//actualizar datos
if (isset($_POST['update'])) {

    $id = $_GET['id'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $pais = $_POST['pais'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $cod_postal = $_POST['cod_postal'];
    $tel = $_POST['tel'];
    $correo = $_POST['correo'];
    $regreso = $_POST['regreso'];

    $query = "UPDATE personas set dni = '$dni',nombre = '$nombre', apellidos='$apellidos', direccion='$direccion', pais='$pais', departamento='$departamento', cod_postal='$cod_postal', tel='$tel', correo='$correo', provincia = '$provincia' WHERE id_persona = $id";
    mysqli_query($conexion, $query);

    $_SESSION['message'] = "Registro modificado con  éxito";
    $_SESSION['message-type'] = 'success';
    if ($regreso == "remitente") {
        header('Location: multi_embarque.php');
    } else {
        header('Location: destinatario.php');
    }
}
?>

<?php
include_once ("includes/header.php");
include_once ("includes/sidebar.php");
?>
<br>
<div class="card container  full-screen shadow" style="margin-top:5%">
    <form class="form-horizontal" method="POST" action="editar-destinatario.php?id=<?php echo $_GET['id']; ?>"
        autocomplete="off">
        <div class="form-group">
            <div class="row">
                <h2><i class="bi bi-pencil-square" style="margin-right:15px"></i>EDITAR
                    DESTINATARIO</h2>
                <hr style=";margin-top:10px">
                <div class="col-md-4 div-nuevo">
                    <label>DNI</label>
                    <input type="text" name="dni" id="dni" class='form-control' maxlength="50" required
                        value="<?php echo $dni; ?>"></input>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label>Nombres</label>
                    <input type="text" name="nombre" id="nombre" class='form-control' maxlength="50" required
                        value="<?php echo $nombre; ?>"></input>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class='form-control' maxlength="50" required
                        value="<?php echo $apellidos; ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 div-nuevo">
                    <label>Dirección</label>
                    <input type="text" name="direccion" id="direccion" class='form-control' maxlength="2000"
                        value="<?php echo $direccion; ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 div-nuevo">
                    <label>Cod de origen</label> <!--Llenado pais actual y todos -->
                    <select name="pais" class="form-select" aria-label="Default select example" required>
                        <?php
                        $query = "SELECT * FROM cod_pais  ORDER BY descripcion ASC";
                        $result = mysqli_query($conexion, $query);
                        while ($rowOrg = mysqli_fetch_array($result)) {
                            if ($rowOrg['id_pais'] == $pais) {
                                ;
                                echo '<option selected = "' . $pais . '"value="' . $pais . '">' . $rowOrg['descripcion'] . '</option>';
                            } else {
                                echo '<option value="' . $rowOrg['id_pais'] . '">' . $rowOrg['descripcion'] . ' </option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label>Provincia</label>
                    <input type="text" name="provincia" id="provincia" class='form-control' maxlength="50"
                        value="<?php echo $provincia; ?>"></input>
                    <input type="hidden" name="regreso" id="regreso" class='form-control' maxlength="50" required
                        value="<?php echo $regreso; ?>"></input>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label>Municipio</label>
                    <input type="text" name="departamento" id="departamento" class='form-control' maxlength="50"
                        value="<?php echo $departamento; ?>"></input>
                    <input type="hidden" name="regreso" id="regreso" class='form-control' maxlength="50" required
                        value="<?php echo $regreso; ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 div-nuevo">
                    <label>Cód Postal</label>
                    <input type="text" name="cod_postal" id="cod_postal" class='form-control' maxlength="50" required
                        value="<?php echo $cod_postal; ?>"></input>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label>Teléfono</label>
                    <input type="text" name="tel" id="tel" class='form-control' maxlength="50"
                        value="<?php echo $tel; ?>"></input>
                </div>
                <div class="col-md-4 div-nuevo">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>">
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="update" class="btn btn-primary"><i class="bi bi-pencil-square"
                        style="margin-right:8px"></i>Editar</button>
                <button type="button" class="btn btn-neutral ">
                    <?php if ($regreso == "destinatario") { ?> <a href="multi_embarque.php">
                        <?php } else { ?> <a href="destinatario.php">
                            <?php } ?> Regresar
                        </a>
                </button>
            </div>
        </div>
    </form>
</div>
</main>
<?php include_once ("includes/footer.php"); ?>