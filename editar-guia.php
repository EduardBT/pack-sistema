<?php
include "session.php";
include "conexion.php";

//trae los datos de la base
if (isset($_GET['id'])) {
$id = $_GET['id'];
$query = "SELECT * FROM guia_embarque WHERE id_guia = $id";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) == 1) {
    $row = mysqli_fetch_array($resultado);
    $guia = $row['id_guia'];
    $cod_origen = $row['cod_origen'];
    $cod_destino = $row['cod_destino'];
    $fecha = $row['fecha_emb'];
    $valor = $row['valor_mercancia'];
    $tipo_bulto = $row['tipo_bulto'];
    $num_bulto = $row['cantidad_bulto'];
    $empaquetado = $row['empaquetado'];
    $peso_volumetrico = $row['peso_volumetrico'];
    $peso_real = $row['peso_real'];
    $numero = $row['numero'];
    $icontem = $row['incotem'];
    $destinatario = $row['personasDest_id'];
    $remitente = $row['personasEnv_id'];
    $descripcion = $row['descripcion'];
    $electronico = $row['electronico'];
    $EditElectronico = "SI";
    $EditEmpaquetado = "SI";
    $numero = $row['numero'];
}
}
//actualizar datos
if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $numero = $_POST['numero'];
    $peso_real = $_POST['peso-real'];
    $cod_origen = $_POST['cod-origen'];
    $cod_destino = $_POST['cod-destino'];
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $tipo_bulto = $_POST['tipo-bulto'];
    $num_bulto = $_POST['num-bulto'];
    $empaquetado = $_POST['empaquetado'];
    $peso_real = $_POST['peso-real'];
    $peso_volumetrico = $_POST['peso-volumetrico'];
    $servicio = $_POST['servicio'];
    $icontem = $_POST['incotem'];
    $producto = $_POST['producto'];
    $destinatario = $_POST['destinatario'];
    $remitente = $_POST['remitente'];
    $descripcion = $_POST['descripcion'];
    $electronico = $_POST['electronico'];

    $query = "UPDATE guia_embarque set numero = '$numero', peso_real = '$peso_real', cod_origen='$cod_origen',cod_destino='$cod_destino', fecha_emb='$fecha', valor_mercancia='$valor', tipo_bulto='$tipo_bulto', cantidad_bulto='$num_bulto', empaquetado='$empaquetado', peso_volumetrico='$peso_volumetrico', incotem = '$icontem', personasDest_id ='$destinatario', personasEnv_id = '$remitente', descripcion = '$descripcion' , electronico='$electronico' WHERE id_guia = $id";
    mysqli_query($conexion, $query);
    if (!$resultado) {
        die("Query failed");
    } else {
        $_SESSION['message'] = "Registro modificado con exito";
        $_SESSION['message-type'] = 'success';
        header('Location: guia.php');
    }
}
?>
<?php
include_once "includes/header.php";
include_once "includes/sidebar.php";
?>
<br>
<div class="card container  full-screen shadow" style="margin-top:3%">
<div class="row">
    <div class="col-md-3">
    </div>  
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3 text-right">
    <h3 class="text-primary" style="margin-bottom:10px">Número de Guía: 
        <?php
        $length = 5;
        $numero_guia = substr(str_repeat(0, $length) . $guia, -$length);
        echo $numero_guia;
        ?>
    </h3>   
</div>
<hr>
</div>
    <div class="container">
        <form class="form-horizontal" method="POST" action="editar-guia.php?id=<?php echo $_GET['id']; ?>"
            autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    <h4>Remitente</h4> <!--Llenado remitente actual y todos -->
                    <br>
                    <select name="remitente" class="js-example-basic-single form-select"
                        aria-label="Default select example">
                        <?php
                        $query = "SELECT * FROM personas";
                        $result = mysqli_query($conexion, $query);
                        while ($rowTodos = mysqli_fetch_array($result)) {
                            if ($rowTodos['id_persona'] == $remitente) {
                                ;
                                echo '<option' . ' value="' . $remitente . '" selected="selected">' . $rowTodos['nombre'] . ' ' . $rowTodos['apellidos'] . '</option>';
                            } else {
                                echo '<option value="' . $rowTodos['id_persona'] . '">' . $rowTodos['dni'] . ', ' . $rowTodos['nombre'] . ' ' . $row['apellidos'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <h4>Destinatario </h4> <!--Llenado destinatario actual y todos -->
                    <br>
                    <select id="personal" name="destinatario" class="js-example-basic-single form-select"
                        aria-label="Default select example">
                        <?php
                        $query = "SELECT * FROM personas";
                        $result = mysqli_query($conexion, $query);
                        while ($rowTodos = mysqli_fetch_array($result)) {
                            if ($rowTodos['id_persona'] == $destinatario) {                              
                                echo '<option' . ' value="' . $destinatario . '" selected="selected">' . $rowTodos['nombre'] . ' ' . $rowTodos['apellidos'] . '</option>';
                            } else {
                                echo '<option value="' . $rowTodos['id_persona'] . '">' . $rowTodos['dni'] . ', ' . $rowTodos['nombre'] . ' ' . $row['apellidos'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group"> 
                <div class="row">
                    <h4>Datos de Envío</h4>
                    <br>
                    <div class="col-md-4 div-nuevo">
                        <label>País de Origen</label> <!--Llenado pais actual y todos -->
                        <select name="cod-origen" class="form-select" aria-label="Default select example">
                            <?php
                            $query = "SELECT * FROM cod_pais ";
                            $result = mysqli_query($conexion, $query);
                            while ($rowOrg = mysqli_fetch_array($result)) {
                                if ($rowOrg['id_pais'] == $cod_origen) {
                                    ;
                                    echo '<option selected = "' . $cod_origen . '"value="' . $cod_origen . '">' . $rowOrg['codigo'] . '</option>';
                                } else {
                                    echo '<option value="' . $rowOrg['id_pais'] . '">' . $rowOrg['codigo'] . ' </option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>País de Destino</label> <!--Llenado pais actual y todos -->
                        <select name="cod-destino" class="form-select" aria-label="Default select example">
                            <?php
                            $query = "SELECT * FROM cod_pais ";
                            $result = mysqli_query($conexion, $query);
                            while ($rowOrg = mysqli_fetch_array($result)) {
                                if ($rowOrg['id_pais'] == $cod_destino) {
                                    ;
                                    echo '<option selected = "' . $cod_destino . '"value="' . $cod_destino . '">' . $rowOrg['codigo'] . '</option>';
                                } else {
                                    echo '<option value="' . $rowOrg['id_pais'] . '">' . $rowOrg['codigo'] . ' </option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Fecha de Embarque</label>
                        <input type="date" type="date" name="fecha" id="nombre" class='form-control' maxlength="25"
                            value='<?php echo $fecha; ?>' required></input>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 div-nuevo">
                        <label>Tipo de Bulto</label>
                        <select class="form-select" value='<?php echo $tipo_bulto; ?>'
                            aria-label="Default select example" name="tipo-bulto">
                            <option selected='<?php echo $tipo_bulto; ?>'>
                                <?php echo $tipo_bulto; ?>
                            </option>
                            <option value="APX">APX</option>
                            <option value="CAR">CAR</option>
                            <option value="DOX">DOX</option>
                        </select>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Descripción</label>
                        <input type="text" value="<?php echo $descripcion; ?>" name="descripcion" 
                            class='form-control' maxlength="250" required></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Cantidad de Bultos</label>
                        <input type="text" value='<?php echo $num_bulto; ?>' name="num-bulto" id="numero"
                            class='form-control' maxlength="25" required></input>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 div-nuevo">
                        <label>Numero Externo</label>
                        <input type="text" name="numero" value='<?php echo $numero; ?>' id="peso" class='form-control'
                            maxlength="15" required></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Peso Real</label>
                        <input type="text" name="peso-real" value='<?php echo $peso_real; ?>' id="real"
                            class='form-control' maxlength="25" required></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Peso Volumétrico</label>
                        <input type="text" name="peso-volumetrico" value='<?php echo $peso_volumetrico; ?>' id="peso"
                            class='form-control' maxlength="25" required></input>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 div-nuevo">
                        <label>Valor de mercancía</label>
                        <input type="text" name="valor" id="apellidos" class='form-control' maxlength="25"
                            value='<?php echo $valor; ?>' required></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                    <?php $querys = "SELECT guia_id,manifiesto_id FROM manif_embarq WHERE guia_id = $guia";
                        $result = mysqli_query($conexion, $querys);
                        if (mysqli_num_rows($result) == 1) {
                            $EditEmpaquetado= "NO";
                        } ?>
                        <label>Empaquetado</label>
                        <div class="form-check">
                            <?php if ($EditEmpaquetado == "SI") { ?>

                                <input type="radio" id="empaquetado" name="empaquetado" value="SI" <?php if ($empaquetado == 'SI') {
                                    echo 'checked';
                                } ?>> SI</input></div>
                                 <div class="form-check">
                                <input type="radio" id="empaquetado" name="empaquetado" value="NO" <?php if ($empaquetado == 'NO') {
                                    echo 'checked';
                                } ?>> NO</input>
                            <?php } else { ?>
                                <?php if ($empaquetado == 'SI') { ?>
                                    <input type="hidden" id="empaquetado" name="empaquetado" value=<?php echo $empaquetado ?>>
                                    <input type="radio" id="empaquetado" name="empaquetado" value="SI" <?php echo 'checked disabled'; ?>> SI</input>
                                    <input type="radio" id="empaquetado" name="empaquetado" value="NO" <?php echo 'disabled'; ?>>
                                    NO</input>
                                <?php }
                                if ($empaquetado == 'NO') { ?>
                                    <input type="hidden" id="empaquetado" name="empaquetado" value=<?php echo $empaquetado ?>>
                                    <input type="radio" id="empaquetado" name="empaquetado" value="SI" <?php echo ' disabled'; ?>>
                                    SI</input>
                                    <input type="radio" id="empaquetado" name="empaquetado" value="NO" <?php echo 'checked disabled'; ?>> NO</input>
                                <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <?php $querys = "SELECT guia_id,manifiesto_id FROM manif_embarq WHERE guia_id = $guia";
                        $result = mysqli_query($conexion, $querys);
                        if (mysqli_num_rows($result) == 1) {
                            $EditElectronico = "NO";
                        } ?>
                        <label>Electrónico</label>
                        <div class="form-check">
                            <?php if ($EditElectronico == "SI") { ?>
                                <input type="radio" id="electronico" name="electronico" value="SI" <?php if ($electronico == 'SI') {
                                    echo 'checked';
                                } ?>> SI</input></div>
                                 <div class="form-check">
                                <input type="radio" id="electronico" name="electronico" value="NO" <?php if ($electronico == 'NO') {
                                    echo 'checked';
                                } ?>> NO</input>
                            <?php } else { ?>
                                <?php if ($electronico == 'SI') { ?>
                                    <input type="hidden" id="eletronico" name="electronico" value=<?php echo $electronico ?>>
                                    <input type="radio" id="electronicoo" name="electronicoo" value="SI" <?php echo 'checked disabled'; ?>> SI</input>
                                    <input type="radio" id="electronicoo" name="electronicoo" value="NO" <?php echo 'disabled'; ?>>
                                    NO</input>

                                <?php }
                                if ($electronico == 'NO') { ?>
                                    <input type="hidden" id="eletronico" name="electronico" value=<?php echo $electronico ?>>
                                    <input type="radio" id="electronicoo" name="electronicoo" value="SI" <?php echo ' disabled'; ?>>
                                    SI</input>
                                    <input type="radio" id="electronicoo" name="electronicoo" value="NO" <?php echo 'checked disabled'; ?>> NO</input>
                                <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Servicio</label>
                        <input type="text" name="servicio" id="servicio" placeholder="International Express Standard"
                            value="International Express Standard" class='form-control' maxlength="25"></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Incotem</label>
                        <select class="form-select" value='<?php echo $icontem; ?>' aria-label="Default select example"
                            name="incotem">
                            <option selected='<?php echo $icontem; ?>'>
                                <?php echo $icontem; ?>
                            </option>
                            <option value="DDP">DDP</option>
                            <option value="DDU">DDU</option>
                        </select>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>Producto</label>
                        <input type="text" name="producto" placeholder="IES" value="IES" class='form-control'
                            maxlength="25" required></input>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="update" class="btn btn-primary"><i class="bi bi-pencil-square"
                        style="margin-right:8px"></i>Editar</button>
                    <button type="button" class="btn btn-dark btn-neutral"><a href="guia.php">Regresar</a></button>
                  
                </div>
            </div>
        </form>
    </div>
</div>
</main>
<?php include_once "includes/footer.php"; ?>