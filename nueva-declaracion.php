<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM guia_embarque WHERE id_guia = $id";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $id_guia = $row['id_guia'];
        $peso_real = $row['peso_real'];
        $cod_origen = $row['cod_origen'];
        $cod_destino = $row['cod_destino'];
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
<link
    href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lobster&family=Nothing+You+Could+Do&family=Peddana&family=Rancho&display=swap"
    rel="stylesheet">
<script src="https://kit.fontawesome.com/80d0152778.js" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<br>
<div class="container" style="background-color: #fff;padding-top:2%">
    <h2>Declaración Jurada</h2>
    <div class="col-md-12 text-center">
        <h2 class="text-center text-primary">Factura Comercial (Commercial Invoice)</h2>
    </div>
    <br>
    <form id="formularioDJ" method="GET" action="reportes\pdfdeclaracionJ.php" target="_blank">
        <input type="hidden" name="id_guia" value=<?php echo $id; ?>>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha/Date: </strong>
                        <?php echo date("F") . " " . date("m") . ", " . date("Y"); ?>
                    </p>
                    <p><strong>Factura/Invoice: </strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="text-center"><strong><u>SHIPPER:</u></strong></p>
                </div>
                <div class="col-md-6">
                    <p class="text-center"><strong><u>SHIPPED TO:</u></strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_origen";
                    $resultadoPais = mysqli_query($conexion, $queryPais);
                    while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
                        <div>
                            <?php
                            $codPais = $rowPais['codigo'];
                            ?>
                            <p><strong>Enviado por: </strong>
                                <?php echo $codPais; ?>
                            </p>
                        </div>
                        <?php
                    } ?>
                    <?php
                    $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
                    $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                    while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                        <p><strong>I.D / RUC / Passport: </strong>
                            <?php echo $rowEnv['dni']; ?>
                        </p>
                        <p><strong>Contacto/Contact: </strong>
                            <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                        </p>
                        <p><strong>Teléfono/Phone: </strong>
                            <?php echo $rowEnv['tel']; ?>
                        </p>
                        <p><strong>E-mail: </strong>
                            <?php echo $rowEnv['correo']; ?>
                        </p>
                        <p><strong>Compañía/Company: </strong>
                            <?php echo $rowEnv['correo']; ?>
                        </p>
                        <p><strong>Direccion/Address: </strong>
                            <?php echo $rowEnv['direccion'] . ' ' . $rowEnv['cod_postal'] . ' ' . $rowEnv['departamento']; ?>
                        </p>
                        <?php
                    } ?>
                </div>
                <div class="col-md-6">
                    <?php
                    $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_destino";
                    $resultadoPais = mysqli_query($conexion, $queryPais);
                    while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
                        <div>
                            <?php
                            $codPais = $rowPais['codigo'];
                            ?>
                            <p><strong>Enviado a: </strong>
                                <?php echo $codPais; ?>
                            </p>
                        </div>
                        <?php
                    } ?>
                    <?php
                    $queryEnvia = "SELECT * FROM personas WHERE id_persona =$destinatario";
                    $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                    while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                        <p><strong>I.D / RUC / Passport: </strong>
                            <?php echo $rowEnv['dni']; ?>
                        </p>
                        <p><strong>Contacto/Contact: </strong>
                            <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                        </p>
                        <p><strong>Teléfono/Phone: </strong>
                            <?php echo $rowEnv['tel']; ?>
                        </p>
                        <p><strong>E-mail: </strong>
                            <?php echo $rowEnv['correo']; ?>
                        </p>
                        <p><strong>Compañía/Company: </strong>
                            <?php echo $rowEnv['correo']; ?>
                        </p>
                        <p><strong>Direccion/Address: </strong>
                            <?php echo $rowEnv['direccion'] . ' ' . $rowEnv['cod_postal'] . ' ' . $rowEnv['departamento']; ?>
                        </p>
                        <?php
                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Comentarios/Comments or Special Instructions:</strong></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Incoterm: </strong>
                        <?php echo $icontem; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="divider" style="border-top:solid #dededf 0.5px;"></div>
        <br>
        <div class="container">
            <div class="row" style="margin-bottom:3%">
                <div class="col-md-12 field_wrapper">
                    <label for="num_productos"><strong>Número de productos:</strong></label>
                    <input id="num_productos" type="number" class="form-control num_productos"
                        style="padding: 2px; border-radius: 0.3rem;" onkeyup="crearFilas(event);">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row ">
                <div class="col-md-3 field_wrapper">
                    <label for=""><strong>Cantidad (Quantity)</strong></label>
                </div>
                <div class="col-md-3 field_wrapper">
                    <label for=""><strong>Descripción</strong></label>
                </div>
                <div class="col-md-3 field_wrapper">
                    <label for=""><strong>Precio Unitario</strong></label>
                </div>
                <div class="col-md-3 field_wrapper">
                    <label for=""><strong>Cantidad (Amount)</strong></label>
                </div>
            </div>
            <div id="filasContainer"></div>

            <div class="row" style="margin-top:2%">
                <div class="col-md-6">
                    <p><strong>Declaro que según mi leal saber y enteder, la información antes mencionada es cierta y
                            correcta, ademas que este envio se origina en el país de URUGUAY.</strong></p>
                </div>
                <div class="col-md-6">
                    <span><strong>Sub total: $</strong><span id="resultado"></span></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
                    $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                    while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                        <p><strong>Nombre/Name: </strong>
                            <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                        </p>
                        <?php
                    } ?></span>
                </div>
                <div class="col-md-6">
                    <p><strong>Firma/Signature: </strong>_____________________</p>
                </div>
            </div>
        </div>
        <div style="row">
            <input name="totalDeclarado" id="totalDeclarado" value="" hidden>
            <a class="btn btn-primary" style="margin-top: 15px; margin-right: 2%;" onclick="totalCalcular()">Calcular
                Total</a>
            <button type="submit" class="btn btn-primary" style="margin-top: 15px; margin-right: 2%;"
                id="generarPDFButton" disabled>Generar PDF</button>
        </div>
        <br><br>
    </form>
</div>
<script>
     function crearFilas(event) {
        var numProductos = parseInt(event.target.value);
        if (!isNaN(numProductos) && numProductos > 0) {
            var container = document.getElementById("filasContainer");
            var existingRows = container.getElementsByClassName("row");
            var existingRowsCount = existingRows.length;

            if (existingRowsCount < numProductos) {
                for (var i = existingRowsCount + 1; i <= numProductos; i++) {
                    var newRow = document.createElement("div");
                    newRow.classList.add("row");
                    newRow.style.marginBottom = "10px";
                    newRow.innerHTML = `
                    <div class="col-md-3 field_wrapper">
                        <input id="cantidad${i}" name="cantidad${i}" type="number" class="form-control cantidad"
                            style="padding: 2px; border-radius: 0.3rem;" oninput="calcularTotal()" value="">
                    </div>
                    <div class="col-md-3 field_wrapper">
                        <input id="descripcion${i}" name="descripcion${i}" type="text" class="form-control descripcion"
                            style="padding: 2px; border-radius: 0.3rem;" value="">
                    </div>                  
                    <div class="col-md-3 field_wrapper">
                        <input id="precio${i}" name="precio${i}" type="number" step="any" class="form-control precio" oninput="calcularTotal();"
                            style="padding: 2px; border-radius: 0.3rem;" value="">
                    </div>
                    <div class="col-md-3 field_wrapper">
                        <input id="total${i}" name="total${i}" type="number" step="any" class="form-control total"
                            style="padding: 2px; border-radius: 0.3rem;" readonly value="">
                    </div>
                `;
                    container.appendChild(newRow);
                }
            } else if (existingRowsCount > numProductos) {
                while (existingRowsCount > numProductos) {
                    container.removeChild(container.lastChild);
                    existingRowsCount--;
                }
            }
        }
    }
    function calcularTotal() {
        var numProductos = parseInt(document.getElementById("num_productos").value);
        var cantidadTotal = [];

        for (var i = 1; i <= numProductos; i++) {
            var cantidad = document.getElementById("cantidad" + i);
            var precio = document.getElementById("precio" + i);
            var total = document.getElementById("total" + i);

            var cant = parseFloat(cantidad.value);
            var prec = parseFloat(precio.value);

            total.value = (cant * prec).toFixed(2);
        }
    }
    function totalCalcular() {
        var cantTotal = 0;
        var numProductos = parseInt(document.getElementById("num_productos").value)
        var generarPDFButton = document.getElementById('generarPDFButton');


        for (var i = 1; i <= numProductos; i++) {
            var total = document.getElementById("total" + i);
            if (!isNaN(parseFloat(total.value))) {
                cantTotal += parseFloat(total.value);
            }
        }
        console.log(cantTotal)
        document.getElementById("resultado").innerText = cantTotal.toFixed(2);
        document.getElementById("totalDeclarado").value = cantTotal.toFixed(2);
        generarPDFButton.disabled = false;
    }
</script>