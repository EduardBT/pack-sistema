<?php
include "session.php";
include "conexion.php";

$numero = $_POST['numero'];
$cod_origen = $_POST['cod_origen'];
$cod_destino = $_POST['cod_destino'];
$fecha = $_POST['fecha'];
$valor = $_POST['valor'];
$peso_real = $_POST['peso_real'];
$tipo_bulto = $_POST['tipo_bulto'];
$num_bulto = $_POST['num_bulto'];
$descripcion = $_POST['descripcion'];
$empaquetado = $_POST['empaquetado'];
$peso_volumetrico = $_POST['peso_volumetrico'];
$incotem = $_POST['incotem'];
$electronico = $_POST['electronico'];
$remitente = $_POST['remitente'];
$destinatario = $_POST['destinatario'];
$vuelo = '';

// Insertar valores en tabla guia_embarque
$query_guia_embarque = "INSERT INTO guia_embarque(numero, cod_origen, cod_destino, fecha_emb, valor_mercancia, peso_real, tipo_bulto, cantidad_bulto, descripcion, empaquetado, peso_volumetrico, incotem, electronico, personasEnv_id, personasDest_id) VALUES ('$numero', '$cod_origen', '$cod_destino', '$fecha', '$valor', '$peso_real', '$tipo_bulto', '$num_bulto', '$descripcion', '$empaquetado', '$peso_volumetrico', '$incotem', '$electronico', '$remitente', '$destinatario')";

$resultado_guia_embarque = mysqli_query($conexion, $query_guia_embarque);

if (!$resultado_guia_embarque) {
    die("Error al insertar en la tabla guia_embarque: " . mysqli_error($conexion));
}

$_SESSION['message'] = "Guía de embarque agregada con éxito";
$_SESSION['message-type'] = 'success';
?>