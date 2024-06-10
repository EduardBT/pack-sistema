<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";


// Buscador
$where = "WHERE rol='cliente'";
$where2 = "WHERE rol='destinatario'";

if (isset($_POST["enviar-nombre"])) {
    $valor = mysqli_real_escape_string($conexion, $_POST['campo']); // Sanitize user input
    if (!empty($valor)) {
        $where = "WHERE dni LIKE '%$valor%' OR nombre LIKE '%$valor%' OR apellidos LIKE '%$valor%'";
    }
}
if (isset($_POST["enviar-nombre2"])) {
    $valor2 = mysqli_real_escape_string($conexion, $_POST['campo2']); // Sanitize user input
    if (!empty($valor2)) {
        $where2 = "WHERE dni LIKE '%$valor2%' OR nombre LIKE '%$valor2%' OR apellidos LIKE '%$valor2%'";
    }
}
// For Phase 1 (Remitente)
$queryRemitente = "SELECT * FROM personas $where";
$resultRemitente = mysqli_query($conexion, $queryRemitente);
// For Phase 2 dest
$queryDestinatario = "SELECT * FROM personas $where2";
$resultDestinatario = mysqli_query($conexion, $queryDestinatario);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        form#multiphase {
            border: #000 1px solid;
            padding: 24px;
            width: 100%;
        }

        form#multiphase>#phase2,
        #phase3,
        #show_all_data {
            display: none;
        }

        #container {
            max-width: 550px;
        }

        .step-container {
            position: relative;
            text-align: center;
            transform: translateY(-43%);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #007bff;
            line-height: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
            /* Added cursor pointer */
        }

        .step-line {
            position: absolute;
            top: 16px;
            left: 50px;
            width: calc(100% - 100px);
            height: 2px;
            background-color: #007bff;
            z-index: -1;
        }

        #multi-step-form {
            overflow-x: hidden;
        }

        .select_search: {
            height: 200px;
        }
    </style>

</head>

<body>
    <!----------------------------------------------------STEP----------------------------->
    <div class="container-fluid mt-5" style="padding:3%; background-color:#fff">
        <div style="margin-bottom:35px">
            <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-<?php echo $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']);
            } ?>
        </div>
        <div class="progress px-1" style="height: 3px;">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                aria-valuemax="100"></div>l
        </div>
        <div class="step-container d-flex justify-content-between">
            <div class="step-circle" onclick="displayStep(1)">1</div>
            <div class="step-circle" onclick="displayStep(2)">2</div>
            <div class="step-circle" onclick="displayStep(3)">3</div>
        </div>

        <form id="multi-step-form" method="POST" action="guardar-guia.php">
            <div class="step step-1">
                <!-- Step 1 form fields here -->
                <div class="mb-3" id="phase1"> <!-- Remitente -->
                    <!-- Remitente selection dropdown -->
                    <label for="remitente" style="font-size:28px">Remitente:</label>
                    <select id="remitente" name="remitente" class="form-select select_search"
                        aria-label="Default select example" onchange="toggleContinueButton2()">>
                        <option value="">Seleccione...</option>
                        <?php
                        // Display the results as options in the select dropdown for Remitente
                        mysqli_data_seek($resultRemitente, 0); // Reset the pointer
                        while ($row = mysqli_fetch_array($resultRemitente)) {
                            echo '<option value="' . htmlspecialchars($row['id_persona']) . '">' . htmlspecialchars($row['dni']) . ' | ' . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellidos']) . '</option>';
                        }
                        ?>
                    </select> <br />
                    <div style="margin-top:2%">
                        <button type="button" id="continueButton2" class="btn btn-primary next-step"
                            onclick="processPhase1()" disabled>Continuar<i class="bi bi-chevron-double-right"
                                style="margin-left:10px"></i></button>
                        <a href="nuevo-cliente.php?regreso=remitente"><button type="button" class="btn btn-success"><i
                                    class="bi bi-plus-circle" style="margin-right:8px"></i>Nuevo
                                Cliente</button></a>
                    </div>

                </div>
                <div id="loconseguido"></div>
            </div>
            <script>
                function toggleContinueButton2() {
                    var destinatarioSelect = document.getElementById("remitente");
                    var continueButton = document.getElementById("continueButton2");

                    if (destinatarioSelect.value !== "") {
                        continueButton.disabled = false;
                    } else {
                        continueButton.disabled = true;
                    }
                }
            </script>
            <!-- Step 2 form fields here -->
            <div class="step step-2">
                <div class="mb-3" id="phase2" style="display: none;"> <!-- Destinatario -->
                    <form id="destinatarioForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <!-- Search input for Destinatario -->
                        <label for="destinatario" style="font-size:28px">Destinatario:</label>
                        <select id="destinatario" name="destinatario" class="form-select"
                            aria-label="Default select example" onchange="toggleContinueButton()">
                            <option value="">Seleccione:</option>
                            <?php
                            // Display the results as options in the select dropdown for Remitente
                            mysqli_data_seek($resultDestinatario, 0); // Reset the pointer
                            while ($row = mysqli_fetch_array($resultDestinatario)) {
                                echo '<option value="' . htmlspecialchars($row['id_persona']) . '">' . htmlspecialchars($row['dni']) . ' | ' . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellidos']) . '</option>';
                            }
                            ?>
                        </select> <br />
                        <div style="margin-top:2%">
                            <button type="button" class="btn btn-primary prev-step" onclick="procesoAtras0()"><i
                                    class="bi bi-chevron-double-left" style="margin-right:10px"></i>Anterior</button>
                            <button type="button" class="btn btn-primary next-step" id="continueButton"
                                onclick="processPhase2()" disabled>Continuar<i class="bi bi-chevron-double-right"
                                    style="margin-left:10px"></i></button>
                            <a href="nuevo-destinatario.php"><button type="button" class="btn btn-success"><i
                                        class="bi bi-plus-circle" style="margin-right:8px"></i>Nuevo
                                    Destinatario</button></a>
                        </div>
                    </form>
                </div>
                <div id="loconseguidoDest"></div>
            </div>

            <script>
                function toggleContinueButton() {
                    var destinatarioSelect = document.getElementById("destinatario");
                    var continueButton = document.getElementById("continueButton");

                    if (destinatarioSelect.value !== "") {
                        continueButton.disabled = false;
                    } else {
                        continueButton.disabled = true;
                    }
                }
            </script>
            <!-- Step 3 form fields here -->
            <div class="step step-3">
                <div class="form-group" id="phase3">
                    <h4>Datos de Envío</h4><br>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4 div-nuevo">
                                <label>País de Origen</label>
                                <select id="cod_origen" name="cod_origen" class="form-select"
                                    aria-label="Default select example">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    $query = "SELECT * FROM cod_pais ORDER BY descripcion ASC";
                                    $result = mysqli_query($conexion, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>País de Destino</label>
                                <select id="cod_destino" name="cod_destino" class="form-select"
                                    aria-label="Default select example">
                                    <option value="0">Seleccione...</option>
                                    <?php
                                    $query = "SELECT * FROM cod_pais ORDER BY descripcion ASC";
                                    $result = mysqli_query($conexion, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div> <br>
                            <div class="col-md-4 div-nuevo">
                                <label>Fecha de Embarque</label>
                                <input type="date" type="date" name="fecha" id="fecha" class='form-control'
                                    maxlength="25" required></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 div-nuevo">
                                <label>Tipo de Bulto</label>
                                <select class="form-select" aria-label="Default select example" id="tipo_bulto"
                                    name="tipo_bulto">
                                    <option selected>Seleccione...</option>
                                    <option value="APX">APX</option>
                                    <option value="DOX">DOX</option>
                                    <option value="ENA">ENA</option>
                                </select>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>Descripción</label>
                                <input type="text" name="descripcion" id="descripcion" value="" class='form-control'
                                    maxlength="50"></input>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>Cantidad de Bultos</label>
                                <input type="text" name="num_bulto" id="num_bulto" class='form-control' maxlength="25"
                                    oninput="generarElementos()" required></input>
                            </div>
                            <div id="contenedor" style="margin-bottom:15px"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 div-nuevo">
                                <label>Número Externo</label>
                                <input type="text" name="numero" id="numero" class='form-control' maxlength="15"
                                    required></input>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>Peso (Kg)</label>
                                <input type="text" id="peso_real" name="peso_real" class='form-control' maxlength="25"
                                    required></input>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>Valor de mercancía</label>
                                <input type="text" name="valor" id="valor" class='form-control' maxlength="25"
                                    required></input>
                            </div>
                            <div class="col-md-2 div-nuevo">
                                <label for="flexCheckDefault">
                                    Empaquetado
                                </label> <!--OJO preguntar por el id="propio (para que se usa?)" -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="empaquetado" id="empaquetado_si"
                                        value="SI">
                                    <label class="form-check-label" for="empaquetado_si">
                                        SI
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="empaquetado" id="empaquetado_no"
                                        value="NO">
                                    <label class="form-check-label" for="empaquetado_no">
                                        NO
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 div-nuevo">
                                <label for="flexCheckDefault">
                                    Electrónico
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="electronico" id="electronico_si"
                                        value="SI">
                                    <label class="form-check-label" for="electronico_si">
                                        SI
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="electronico" id="electronico_no"
                                        value="NO" checked>
                                    <label class="form-check-label" for="electronico_no">
                                        NO
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 div-nuevo">
                                <label>Volumen (m3)</label>
                                <div class="input-group">
                                    <input type="number" name="peso_volumetrico" class="form-control" id="spTotal"
                                        aria-label="Input group example" aria-describedby="basic-addon1"  required>
                                </div>
                            </div>
                            <div class="col-md-4 div-nuevo">
                                <label>Servicio</label>
                                <input type="text" name="servicio" id="servicio"
                                    placeholder="International Express Standard" value="International Express Standard"
                                    class='form-control' maxlength="25"></input>
                            </div>
                            <div class="cold-md-4 div-nuevo">

                            </div>
                        </div>
                    </div>

                    <!-- Modal calculo de volumen-->
                    <div class="modal modal-dialog-scrollable" id="myModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true"
                        data-mdb-keyboard="true">
                        <div class="modal-dialog  ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Calculadora de volumen
                                    </h5>
                                    <button type="button" class="btn-close close cerrarModal" data-mdb-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 1</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 2</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 3</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 4</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 5</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 6</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 7</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 8</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 9</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h5>Bulto 10</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Alto(cm)</label>
                                                <input type="number" step="any" class="form-control alto"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Ancho(cm)</label>
                                                <input type="number" step="any" class="form-control ancho"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Largo(cm)</label>
                                                <input type="number" step="any" class="form-control largo"
                                                    style="padding: 4px; border-radius: 0.3rem;"
                                                    onkeypress="calcular();">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Volumen(cm3)</label>
                                                <input type="number" step="any" class="form-control volumen"
                                                    style="padding: 4px; border-radius: 0.3rem;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="button2" class="btn btn-secondary close cerrarModal"
                                        onclick="Cerrar()" data-mdb-dismiss="modal">
                                        Cerrar
                                    </button>


                                    <button type="button" class="btn btn-primary" id="button1">Calcular</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary prev-step" onclick="procesoAtras1()"><i
                                class="bi bi-chevron-double-left" style="margin-right:10px"></i>Anterior</button>
                        <button type="button" class="btn btn-primary" onclick="processPhase3()">Continuar<i
                                class="bi bi-chevron-double-right" style="margin-left:10px"></i></button>
                        <div class="row">
                            <div class="col-md-4 div-nuevo">
                                <label>Incotem</label>
                                <select class="form-select" aria-label="Default select example" id="incotem"
                                    name="incotem">
                                    <option selected>Seleccione:</option>
                                    <option value="DDP">DDP</option>
                                    <option value="DDU">DDU</option>
                            </div>
                        </div>
                    </div>

                    <div id="show_all_data">
                        Remitente: <span id="display_remitente"></span> <br />
                        Destinario: <span id="display_destinatario"></span> <br />
                        origen: <span id="display_cod_origen"></span> <br />
                        fecha:<span id="display_fecha"></span> <br />
                        valor:<span id="display_valor"></span> <br />
                        tipo_bulto:<span id="display_tipo_bulto"></span> <br />
                        num_bulto:<span id="display_num_bulto"></span> <br />
                        peso_real:<span id="display_peso_real"></span> <br />
                        numero:<span id="display_numero"></span> <br />
                        empaquetado:<span id="display_empaquetado"></span> <br />
                        incotem:<span id="display_incotem"></span> <br />
                        descripcion:<span id="display_descripcion"></span> <br />
                        electronico:<span id="display_electronico"></span> <br />
                        <button onclick="procesoAtras2()"><i class="bi bi-chevron-double-left"
                                style="margin-right:10px"></i>Anterior</button>
                        <button name="generar-guia" onclick="submitForm()" class="btn btn-primary">Generar
                            Guía</button>
                    </div>
        </form>
    </div>
    </div>
    </div>
    </form>
    </div>

    <!----------------------------------------------------------------->

    <script src="js/main.js"></script>
    <script src="js/prueba.js"></script>
    <script src="js/destinatarios.js"></script>
    <script>
        $(document).ready(function () {
            $('#remitente').select2({
                placeholder: 'Buscar...',
                allowClear: true,
                width: '100%',

            });
        });
        $(document).ready(function () {
            $('#destinatario').select2({
                placeholder: 'Buscar...',
                allowClear: true,
                width: '100%',

            });
        });
    </script>
    <script>
        function generarElementos() {
            const cantidad = document.getElementById('num_bulto').value;
            const contenedor = document.getElementById('contenedor');

            // Limpiar contenido existente
            contenedor.innerHTML = '';

            // Generar los elementos según la cantidad ingresada
            for (let i = 1; i <= cantidad; i++) {
                const div = document.createElement('div');
                div.className = 'row';
                div.innerHTML = `
      <div class="row">
        <h5>Bulto ${i}</h5>
      </div>
      <div class="col-md-3">
        <label for="">Alto(cm)</label>
        <input type="number" step="any" class="form-control alto"  oninput="calcular()"
          style="padding: 4px; border-radius: 0.3rem;">
      </div>
      <div class="col-md-3">
        <label for="">Ancho(cm)</label>
        <input type="number" step="any" class="form-control ancho"  oninput="calcular()"
          style="padding: 4px; border-radius: 0.3rem;">
      </div>
      <div class="col-md-3">
        <label for="">Largo(cm)</label>"
        <input type="number" step="any" class="form-control largo"  oninput="calcular()"
          style="padding: 4px; border-radius: 0.3rem;"
          onkeypress="calcular();">
      </div>
      <div class="col-md-3">
        <label for="">Volumen(cm3)</label>
        <input type="number" step="any" class="form-control volumen"
          style="padding: 4px; border-radius: 0.3rem;">
      </div>
    `;

                contenedor.appendChild(div);
            }
        }
    </script>
    <script>
        var currentStep = 1;
        var updateProgressBar;

        function displayStep(stepNumber) {
            if (stepNumber >= 1 && stepNumber <= 3) {
                $(".step-" + currentStep).hide();
                $(".step-" + stepNumber).show();
                currentStep = stepNumber;
                updateProgressBar();
            }
        }

        $(document).ready(function () {
            $('#multi-step-form').find('.step').slice(1).hide();

            $(".next-step").click(function () {
                if (currentStep < 3) {
                    $(".step-" + currentStep).addClass("animate animated animate fadeOutLeft");
                    currentStep++;
                    setTimeout(function () {
                        $(".step").removeClass("animate animated animate fadeOutLeft").hide();
                        $(".step-" + currentStep).show().addClass("animate animated animate fadeInRight");
                        updateProgressBar();
                    }, 500);
                }
            });

            $(".prev-step").click(function () {
                if (currentStep > 1) {
                    $(".step-" + currentStep).addClass("animate animated animate fadeOutRight");
                    currentStep--;
                    setTimeout(function () {
                        $(".step").removeClass("animate animated animate fadeOutRight").hide();
                        $(".step-" + currentStep).show().addClass("animate animated animate fadeInLeft");
                        updateProgressBar();
                    }, 500);
                }
            });

            updateProgressBar = function () {
                var progressPercentage = ((currentStep - 1) / 2) * 100;
                $(".progress-bar").css("width", progressPercentage + "%");
            }
        });
    </script>
    <script>
        var codigoBarrasInput = document.getElementById('numero');
        codigoBarrasInput.addEventListener('input', function(event) {
        var codigoBarras = event.target.value;
        });
    </script>
</body>

</html>