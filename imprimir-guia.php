<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";
include_once 'vendor/autoload.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM guia_embarque WHERE id_guia = $id";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $id_guia = $row['id_guia'];
        $peso_real = $row['peso_real'];
        $cod_origen = $row['cod_origen'];
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
} ?>

<body>
    <br>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                type="button" role="tab" aria-controls="pills-home" aria-selected="true">Envío</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Factura</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Otros reportes</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <!----------Comienzo guia de embarque------------>
            <h2>Guía de embarque</h2>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/pack/proyecto-pack-master/img/logo.jpg"
                            style="max-width: 200px;" alt="logo pack">
                        <br>
                        <p><strong>Cliente: </strong>Pack Express Uruguay S.A.S (COMVD07341)</p>
                        <p><strong>Origen: </strong>Aeropuerto de Carrasco, Montevideo (MVD)</p>
                        <p><strong>Dirección: </strong> Carlos Quijano 1258 Esq. Soriano, Centro. Montevideo, Uruguay
                        </p>
                        <p><strong>Tel.: </strong>(+598) 2902 7227 / (+598) 93 594 297</p>
                        <p><strong>Email: </strong>packexpress2021@gmail.com</p>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-top:1rem;">
                            <?php
                            $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_origen";
                            $resultadoPais = mysqli_query($conexion, $queryPais);
                            while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
                                <div>
                                    <?php
                                    $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
                                    $codPais = $rowPais['codigo'];
                                    $length = 5;
                                    $string = substr(str_repeat(0, $length) . $id_guia, -$length);
                                    $codigoBarra = $codPais . $string . $cod_origen;
                                    echo $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128);
                                    echo $codigoBarra;
                                    ?>
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Remitente</h5>
                        <?php
                        $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
                        $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                        while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                            <p><strong>Nombre: </strong>
                                <?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>
                            </p>
                            <p><strong>Dirección: </strong>
                                <?php echo $rowEnv['direccion'] . ' ' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?>
                            </p>
                            <p><strong>Tel.: </strong>
                                <?php echo $rowEnv['tel']; ?>
                            </p>
                            <?php
                        } ?>
                        <br>
                        <h5>Destinatario</h5>
                        <?php
                        $queryDest = "SELECT * FROM personas  WHERE id_persona =$destinatario";
                        $resultadoDest = mysqli_query($conexion, $queryDest);
                        while ($rowDest = $resultadoDest->fetch_assoc()) { ?>
                            <p><strong>Nombre: </strong>
                                <?php echo $rowDest['nombre'] . ' ' . $rowDest['apellidos']; ?>
                            </p>
                            <p><strong>Dirección: </strong>
                                <?php echo $rowDest['direccion'] . ' ' . $rowDest['pais'] . ' ' . $rowDest['departamento']; ?>
                            </p>
                            <p><strong>Tel.: </strong>
                                <?php echo $rowDest['tel']; ?>
                            </p>
                            <?php
                        } ?>
                        <br>
                    </div>
                    <div class="divider" style="border-top:solid #dededf 1.5px;"></div>
                </div>
                <div class="row">
                    <h5 class="text-center">Información de envio</h5>
                    <div class="espacio"></div>
                    <div class="col-md-4">
                        <p><strong>Fecha:
                                <?php echo $row['fecha']; ?>
                            </strong></p>
                        <p><strong>Fecha embarque:
                                <?php echo $row['fecha_emb']; ?>
                            </strong></p>
                        <p><strong>Valor mercancía (USD):
                                <?php echo $row['valor_mercancia']; ?>
                            </strong></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Peso (Kg):
                                <?php echo $row['peso_real']; ?>
                            </strong></p>
                        <p><strong>Descripción:
                                <?php echo $row['descripcion']; ?>
                            </strong></p>
                        <p><strong>Tipo de bulto:
                                <?php echo $row['tipo_bulto']; ?>
                            </strong></p>
                        <p><strong>Cond. Entrega:
                                <?php echo $row['incotem']; ?>
                            </strong></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Producto: IES</strong></p>
                        <p><strong>Bultos:
                                <?php echo $row['cantidad_bulto']; ?>
                            </strong></p>
                        <?php
                        if ($peso_real > $peso_volumetrico) { ?>
                            <p><strong>Peso a cobrar:
                                    <?php echo $peso_real; ?>
                                </strong></p>
                            <?php
                        } else { ?>
                            <p><strong>Peso a cobrar:
                                    <?php echo $peso_volumetrico; ?>
                                </strong></p>
                        <?php } ?>
                        <p><strong>Status: </strong></p>
                    </div>
                </div>
                <!----------fin guia de embarque----------->
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>
</body>