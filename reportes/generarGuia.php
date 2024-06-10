<?php
include "../conexion.php";
// include "./barcode/barcode.php";
include_once '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';

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
        $numero = $row['numero'];
        $fecha = $row['fecha_emb'];
        $valor = $row['valor_mercancia'];
        $tipo_bulto = $row['tipo_bulto'];
        $num_bulto = $row['cantidad_bulto'];
        $empaquetado = $row['empaquetado'];
        $peso_volumetrico = number_format($row['peso_volumetrico'], 3);
        $icontem = $row['incotem'];
        $destinatario = $row['personasDest_id'];
        $remitente = $row['personasEnv_id'];
        $descripcion = $row['descripcion'];
    }
}

$queryDest = "SELECT * FROM personas WHERE id_persona = $destinatario";
$resultadoDest = mysqli_query($conexion, $queryDest);
if (mysqli_num_rows($resultadoDest) == 1) {
    $rowDest = mysqli_fetch_array($resultadoDest);
    $ci = $rowDest['dni'];
    $tel = $rowDest['tel'];
    $dir = $rowDest['direccion'] . ',Provincia: ' . $rowDest['provincia'].', Municipio: '. $rowDest['departamento'];
    $direccion = $rowDest['direccion'];
    $provincia_dest = $rowDest['provincia'];
    $dpto = $rowDest['departamento'];
    $cod_postal = $rowDest['cod_postal'];
    $nombre = $rowDest['nombre'] . ' ' . $rowDest['apellidos'];
}


$datos_provincia = array(
    array("provincia" => "PINAR DEL RIO", "codigoProvincia" => 21),
    array("provincia" => "PINAR DEL RÍO", "codigoProvincia" => 21),
    array("provincia" => "LA HABANA", "codigoProvincia" => 23),
    array("provincia" => "MAYABEQUE", "codigoProvincia" => 24),
    array("provincia" => "MATANZAS", "codigoProvincia" => 25),
    array("provincia" => "CIENFUEGOS", "codigoProvincia" => 27),
    array("provincia" => "VILLA CLARA", "codigoProvincia" => 26),
    array("provincia" => "SANCTI SPIRITUS", "codigoProvincia" => 28),
    array("provincia" => "SANCTI SPÍRITUS", "codigoProvincia" => 28),
    array("provincia" => "CIEGO DE AVILA", "codigoProvincia" => 29),
    array("provincia" => "CIEGO DE ÁVILA", "codigoProvincia" => 29),
    array("provincia" => "CAMAGUEY", "codigoProvincia" => 30),
    array("provincia" => "LAS TUNAS", "codigoProvincia" => 31),
    array("provincia" => "HOLGUIN", "codigoProvincia" => 32),
    array("provincia" => "HOLGUÍN", "codigoProvincia" => 32),
    array("provincia" => "GRANMA", "codigoProvincia" => 33),
    array("provincia" => "SANTIAGO DE CUBA", "codigoProvincia" => 34),
    array("provincia" => "GUANTANAMO", "codigoProvincia" => 35),
    array("provincia" => "GUANTÁNAMO", "codigoProvincia" => 35),
    array("provincia" => "ISLA DE LA JUVENTUD", "codigoProvincia" => 40),
    array("provincia" => "ARTEMISA", "codigoProvincia" => 22)
);

$datos_municipio = array(
    array("municipio" => "Sibanicú", "codigoMunicipio" => "07"),
    array("municipio" => "Florida", "codigoMunicipio" => "09"),
    array("municipio" => "Minas", "codigoMunicipio" => "04"),
    array("municipio" => "Carlos Manuel de Céspedes", "codigoMunicipio" => "01"),
    array("municipio" => "Esmeralda", "codigoMunicipio" => "02"),
    array("municipio" => "Nuevitas", "codigoMunicipio" => "05"),
    array("municipio" => "Guáimaro", "codigoMunicipio" => "06"),
    array("municipio" => "Vertientes", "codigoMunicipio" => "10"),
    array("municipio" => "Sola", "codigoMunicipio" => "03"),
    array("municipio" => "Santa Cruz del Sur", "codigoMunicipio" => "13"),
    array("municipio" => "Jimaguayú", "codigoMunicipio" => "11"),
    array("municipio" => "Cuatro Caminos", "codigoMunicipio" => "12"),
    array("municipio" => "Ciudad Sandino", "codigoMunicipio" => "01"),
    array("municipio" => "Mantua", "codigoMunicipio" => "02"),
    array("municipio" => "Minas de Matahambre", "codigoMunicipio" => "03"),
    array("municipio" => "Viñales", "codigoMunicipio" => "04"),
    array("municipio" => "Consolación del Norte (La Palma)", "codigoMunicipio" => "05"),
    array("municipio" => "Bahía Honda", "codigoMunicipio" => "01"),
    array("municipio" => "Candelaria", "codigoMunicipio" => "10"),
    array("municipio" => "San Cristóbal", "codigoMunicipio" => "11"),
    array("municipio" => "Los Palacios", "codigoMunicipio" => "06"),
    array("municipio" => "Consolación del Sur", "codigoMunicipio" => "07"),
    array("municipio" => "San Juan y Martínez", "codigoMunicipio" => "10"),
    array("municipio" => "Guane", "codigoMunicipio" => "11"),
    array("municipio" => "San Luis", "codigoMunicipio" => "09"),
    array("municipio" => "San José de las Lajas", "codigoMunicipio" => "02"),
    array("municipio" => "Güines", "codigoMunicipio" => "08"),
    array("municipio" => "Melena del Sur", "codigoMunicipio" => "09"),
    array("municipio" => "Batabanó", "codigoMunicipio" => "10"),
    array("municipio" => "Santa Cruz del Norte", "codigoMunicipio" => "04"),
    array("municipio" => "Madruga", "codigoMunicipio" => "05"),
    array("municipio" => "Nueva Paz", "codigoMunicipio" => "06"),
    array("municipio" => "San Nicolás", "codigoMunicipio" => "07"),
    array("municipio" => "Bauta", "codigoMunicipio" => "05"),
    array("municipio" => "Caimito", "codigoMunicipio" => "04"),
    array("municipio" => "Mariel", "codigoMunicipio" => "02"),
    array("municipio" => "Artemisa", "codigoMunicipio" => "09"),
    array("municipio" => "San Antonio de los Baños", "codigoMunicipio" => "06"),
    array("municipio" => "Güira de Melena", "codigoMunicipio" => "07"),
    array("municipio" => "Quivicán", "codigoMunicipio" => "11"),
    array("municipio" => "Alquízar", "codigoMunicipio" => "08"),
    array("municipio" => "Bejucal", "codigoMunicipio" => "01"),
    array("municipio" => "Guanajay", "codigoMunicipio" => "03"),
    array("municipio" => "Jaruco", "codigoMunicipio" => "03"),
    array("municipio" => "Cardenas", "codigoMunicipio" => "02"),
    array("municipio" => "Varadero", "codigoMunicipio" => "03"),
    array("municipio" => "Marti", "codigoMunicipio" => "03"),
    array("municipio" => "Martí", "codigoMunicipio" => "03"),
    array("municipio" => "Colón", "codigoMunicipio" => "04"),
    array("municipio" => "Perico", "codigoMunicipio" => "05"),
    array("municipio" => "Jovellanos", "codigoMunicipio" => "06"),
    array("municipio" => "Pedro Betancourt", "codigoMunicipio" => "07"),
    array("municipio" => "Limonar", "codigoMunicipio" => "08"),
    array("municipio" => "Unión de Reyes", "codigoMunicipio" => "09"),
    array("municipio" => "Ciénaga de Zapata", "codigoMunicipio" => "10"),
    array("municipio" => "Calimete", "codigoMunicipio" => "12"),
    array("municipio" => "Los Arabos", "codigoMunicipio" => "13"),
    array("municipio" => "Jagüey Grande", "codigoMunicipio" => "11"),
    array("municipio" => "Aguada de Pasajeros", "codigoMunicipio" => "01"),
    array("municipio" => "Rodas", "codigoMunicipio" => "02"),
    array("municipio" => "Abreus", "codigoMunicipio" => "08"),
    array("municipio" => "Santa Isabel de las Lajas", "codigoMunicipio" => "04"),
    array("municipio" => "Lajas", "codigoMunicipio" => "04"),
    array("municipio" => "Cruces", "codigoMunicipio" => "05"),
    array("municipio" => "Palmira", "codigoMunicipio" => "03"),
    array("municipio" => "Cumanayagua", "codigoMunicipio" => "06"),
    array("municipio" => "Jatibonico", "codigoMunicipio" => "02"),
    array("municipio" => "Cabaiguán", "codigoMunicipio" => "04"),
    array("municipio" => "Trinidad", "codigoMunicipio" => "06"),
    array("municipio" => "Taguasco", "codigoMunicipio" => "03"),
    array("municipio" => "La Sierpe", "codigoMunicipio" => "08"),
    array("municipio" => "Fomento", "codigoMunicipio" => "05"),
    array("municipio" => "Yaguajay", "codigoMunicipio" => "01"),
    array("municipio" => "Caibarién", "codigoMunicipio" => "06"),
    array("municipio" => "Camajuaní", "codigoMunicipio" => "05"),
    array("municipio" => "Cifuentes", "codigoMunicipio" => "10"),
    array("municipio" => "Corralillo", "codigoMunicipio" => "01"),
    array("municipio" => "Encrucijada", "codigoMunicipio" => "04"),
    array("municipio" => "Manicaragua", "codigoMunicipio" => "13"),
    array("municipio" => "Placetas", "codigoMunicipio" => "08"),
    array("municipio" => "Quemado de Güines", "codigoMunicipio" => "02"),
    array("municipio" => "Ranchuelo", "codigoMunicipio" => "12"),
    array("municipio" => "Remedios", "codigoMunicipio" => "07"),
    array("municipio" => "Sagua la Grande", "codigoMunicipio" => "03"),
    array("municipio" => "Santo Domingo", "codigoMunicipio" => "11"),
    array("municipio" => "Cayo Mambi (C. Frank País)", "codigoMunicipio" => "12"),
    array("municipio" => "Gibara", "codigoMunicipio" => "01"),
    array("municipio" => "Rafael Freyre (Santa Lucía)", "codigoMunicipio" => "02"),
    array("municipio" => "Banes", "codigoMunicipio" => "03"),
    array("municipio" => "Baguanos", "codigoMunicipio" => "05"),
    array("municipio" => "Buenaventura", "codigoMunicipio" => "07"),
    array("municipio" => "Cacocum", "codigoMunicipio" => "08"),
    array("municipio" => "Cueto", "codigoMunicipio" => "10"),
    array("municipio" => "Urbano Noris", "codigoMunicipio" => "09"),
    array("municipio" => "Mayarí", "codigoMunicipio" => "11"),
    array("municipio" => "Sagua de Tánamo", "codigoMunicipio" => "13"),
    array("municipio" => "Moa", "codigoMunicipio" => "14"),
    array("municipio" => "Antilla", "codigoMunicipio" => "04"),
    array("municipio" => "Maisí", "codigoMunicipio" => "05"),
    array("municipio" => "El Salvador", "codigoMunicipio" => "01"),
    array("municipio" => "Baracoa", "codigoMunicipio" => "04"),
    array("municipio" => "Yateras", "codigoMunicipio" => "03"),
    array("municipio" => "Caimanera", "codigoMunicipio" => "08"),
    array("municipio" => "Niceto Pérez", "codigoMunicipio" => "10"),
    array("municipio" => "Manuel Tames", "codigoMunicipio" => "02"),
    array("municipio" => "San Antonio del Sur", "codigoMunicipio" => "07"),
    array("municipio" => "Imías", "codigoMunicipio" => "06"),
    array("municipio" => "Bayamo", "codigoMunicipio" => "04"),
    array("municipio" => "Río Cauto", "codigoMunicipio" => "01"),
    array("municipio" => "Cauto Cristo", "codigoMunicipio" => "02"),
    array("municipio" => "Jiguaní", "codigoMunicipio" => "03"),
    array("municipio" => "Yara", "codigoMunicipio" => "05"),
    array("municipio" => "Manzanillo", "codigoMunicipio" => "06"),
    array("municipio" => "Campechuela", "codigoMunicipio" => "07"),
    array("municipio" => "Media Luna", "codigoMunicipio" => "08"),
    array("municipio" => "Niquero", "codigoMunicipio" => "09"),
    array("municipio" => "Pilón", "codigoMunicipio" => "10"),
    array("municipio" => "Bartolomé Masó", "codigoMunicipio" => "11"),
    array("municipio" => "Buey Arriba", "codigoMunicipio" => "12"),
    array("municipio" => "Guisa", "codigoMunicipio" => "13"),
    array("municipio" => "Palma Soriano", "codigoMunicipio" => "07"),
    array("municipio" => "Contramaestre", "codigoMunicipio" => "01"),
    array("municipio" => "La Maya", "codigoMunicipio" => "05"),
    array("municipio" => "Songo la Maya", "codigoMunicipio" => "05"),
    array("municipio" => "San Luis", "codigoMunicipio" => "03"),
    array("municipio" => "II Frente", "codigoMunicipio" => "04"),
    array("municipio" => "Guamá", "codigoMunicipio" => "09"),
    array("municipio" => "III Frente", "codigoMunicipio" => "08"),
    array("municipio" => "Miranda (C. Julio A. Mella)", "codigoMunicipio" => "02"),
    array("municipio" => "Manatí", "codigoMunicipio" => "01"),
    array("municipio" => "Puerto Padre", "codigoMunicipio" => "02"),
    array("municipio" => "Jobabo", "codigoMunicipio" => "06"),
    array("municipio" => "Colombia", "codigoMunicipio" => "07"),
    array("municipio" => "Majibacoa", "codigoMunicipio" => "04"),
    array("municipio" => "Chambas", "codigoMunicipio" => "01"),
    array("municipio" => "1ro de Enero", "codigoMunicipio" => "04"),
    array("municipio" => "Primero de Enero", "codigoMunicipio" => "04"),
    array("municipio" => "Central Bolivia", "codigoMunicipio" => "03"),
    array("municipio" => "Florencia", "codigoMunicipio" => "06"),
    array("municipio" => "Majagua", "codigoMunicipio" => "07"),
    array("municipio" => "Venezuela", "codigoMunicipio" => "09"),
    array("municipio" => "Baraguá", "codigoMunicipio" => "10"),
    array("municipio" => "Morón", "codigoMunicipio" => "02"),
    array("municipio" => "Ciro Redondo", "codigoMunicipio" => "05"),
    array("municipio" => "Cerro", "codigoMunicipio" => "10"),
    array("municipio" => "Centro Habana", "codigoMunicipio" => "03"),
    array("municipio" => "Habana Vieja", "codigoMunicipio" => "04"),
    array("municipio" => "La Habana Vieja", "codigoMunicipio" => "04"),
    array("municipio" => "Plaza de la Revolución", "codigoMunicipio" => "02"),
    array("municipio" => "10 de Octubre", "codigoMunicipio" => "09"),
    array("municipio" => "Habana del Este", "codigoMunicipio" => "06"),
    array("municipio" => "La Habana del Este", "codigoMunicipio" => "06"),
    array("municipio" => "San Miguel del Padrón", "codigoMunicipio" => "08"),
    array("municipio" => "Guanabacoa", "codigoMunicipio" => "07"),
    array("municipio" => "Regla", "codigoMunicipio" => "05"),
    array("municipio" => "Cotorro", "codigoMunicipio" => "15"),
    array("municipio" => "Boyeros", "codigoMunicipio" => "13"),
    array("municipio" => "La Lisa", "codigoMunicipio" => "12"),
    array("municipio" => "Arroyo Naranjo", "codigoMunicipio" => "14"),
    array("municipio" => "Playa", "codigoMunicipio" => "01"),
    array("municipio" => "Marianao", "codigoMunicipio" => "11"),
    array("municipio" => "Santa Clara", "codigoMunicipio" => "09"),
    array("municipio" => "Pinar del Río", "codigoMunicipio" => "08"),
    array("municipio" => "Matanzas", "codigoMunicipio" => "01"),
    array("municipio" => "Cienfuegos", "codigoMunicipio" => "07"),
    array("municipio" => "Sancti Spíritus", "codigoMunicipio" => "07"),
    array("municipio" => "Sancti Spiritus", "codigoMunicipio" => "07"),
    array("municipio" => "Ciego de Ávila", "codigoMunicipio" => "08"),
    array("municipio" => "Camagüey", "codigoMunicipio" => "08"),
    array("municipio" => "Las Tunas", "codigoMunicipio" => "05"),
    array("municipio" => "Holguín", "codigoMunicipio" => "06"),
    array("municipio" => "Santiago de Cuba", "codigoMunicipio" => "06"),
    array("municipio" => "Guantánamo", "codigoMunicipio" => "09"),
    array("municipio" => "Isla de la Juventud", "codigoMunicipio" => "01"),
    array("municipio" => "Isla de la Juventud 1", "codigoMunicipio" => "01"),
    array("municipio" => "Jesús Menéndez", "codigoMunicipio" => "03"),
    array("municipio" => "Amancio", "codigoMunicipio" => "08")
);

$codigoProvincia = null;
$codigoMunicipio = null;

function eliminarTildes($texto)
{
 $tildes = array(
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'Á' => 'A',
        'É' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ú' => 'U',
        'Ü' => 'U'
    );

    return strtr($texto, $tildes);
}

foreach ($datos_provincia as $provincia) {
    if (eliminarTildes(strtolower($provincia['provincia'])) == eliminarTildes(strtolower($provincia_dest))) {
        $codigoProvincia = $provincia['codigoProvincia'];
        break;
    }
}

foreach ($datos_municipio as $municipio) {
    if (eliminarTildes(strtolower($municipio['municipio'])) == eliminarTildes(strtolower($dpto))) {
        $codigoMunicipio = $municipio['codigoMunicipio'];
        break;
    }
}

$queryRemit = "SELECT * FROM personas WHERE id_persona = $remitente";
$resultadoRemit = mysqli_query($conexion, $queryRemit);
if (mysqli_num_rows($resultadoRemit) == 1) {
    $rowRemit = mysqli_fetch_array($resultadoRemit);
    $nombreRemit = $rowRemit['nombre'] . ' ' . $rowRemit['apellidos'];
}


$queryPais = "SELECT * FROM cod_pais WHERE id_pais = $cod_origen";
$resultadoPais = mysqli_query($conexion, $queryPais);
while ($rowPais = $resultadoPais->fetch_assoc()) {
    $codPais = $rowPais['codigo'];
    $descPais = $rowPais['descripcion'];
    $barHTML = new Picqer\Barcode\BarcodeGeneratorHTML();
    $codPais = $rowPais['codigo'];
    $length = 9;
    $secoundrow = 'CM';
    $segoundrow = 'PK';
    $string = substr(str_repeat(0, $length) . $id_guia, -$length);
    $codigoBarra = $secoundrow . $string . $segoundrow;
}

$queryPaisDest = "SELECT * FROM cod_pais WHERE id_pais = $cod_destino";
$resultadoPaisDest = mysqli_query($conexion, $queryPaisDest);
while ($rowPaisDest = $resultadoPaisDest->fetch_assoc()) {
    $codPaisDest = $rowPaisDest['codigo'];
    $descPaisDest = $rowPaisDest['descripcion'];
    $barHTMLDest = new Picqer\Barcode\BarcodeGeneratorHTML();
    $codPaisDes = $rowPaisDest['codigo'];
}

ob_start();

// Incluye la biblioteca PHP QR Code
require "phpqrcodemaster/qrlib.php";

// Contenido del código QR
$contenido = "Peso(kg): " . $peso_real . "\nOrigen: " . $descPais . "\nDest.: " . $nombre . "\nCI: " . $ci . "\nDirección: " . $direccion . "\nProvincia: " . $dpto . "\nRemitente: " . $nombreRemit . "\nPaís: " . $descPais . "\nDescripción: " . $descripcion;

// Ruta y nombre del archivo de salida (imagen PNG)
$archivo_salida = "../img/qr/" . $codigoBarra . ".png";

// Tamaño y nivel de corrección del código QR
$tamanio = 10; // Tamaño de cada punto en el código QR (1-10)
$nivel_correccion = 'L'; // Nivel de corrección: L (baja), M, Q, H (alta)

// Genera el código QR y guarda la imagen en el archivo de salida
QRcode::png($contenido, $archivo_salida, $nivel_correccion, $tamanio);

// Crear una imagen en blanco de 400x300 píxeles
$imagen = imagecreatetruecolor(400, 300);

// Establecer el color de fondo
$colorFondo = imagecolorallocate($imagen, 255, 255, 255);
imagefill($imagen, 0, 0, $colorFondo);

// Escribir "Hola, mundo!" en la imagen
$colorTexto = imagecolorallocate($imagen, 255, 255, 255);
$texto = ".";
imagestring($imagen, 5, 50, 150, $texto, $colorTexto);


// Cargar la imagen existente
$imagenExistente = imagecreatefrompng('../img/qr/' . $codigoBarra . '.png');

// Obtener las dimensiones de la imagen existente
$anchoExistente = imagesx($imagenExistente);
$altoExistente = imagesy($imagenExistente);

// Crear una nueva imagen concatenada con el ancho total
$imagenConcatenada = imagecreatetruecolor($anchoExistente + 0, max($altoExistente, 0));

// Copiar la imagen existente en la imagen concatenada
imagecopy($imagenConcatenada, $imagenExistente, 0, 0, 0, 0, $anchoExistente, $altoExistente);

// Copiar la imagen nueva en la imagen concatenada
imagecopy($imagenConcatenada, $imagen, $anchoExistente, 0, 0, 0, 400, 300);

// Guardar la imagen concatenada en un archivo
imagepng($imagenConcatenada, '../img/qr/' . $codigoBarra . '.png');


$html = '<head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Pack Express</title>
            <meta name="keywords" content="">
            <meta name="description" content="Gestión de Cheques">

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
                integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
                integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
            <!--iconos-->
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
    table {
        width:400px;
        margin-top:-10px;
        font-size: 30px;
        font-family: Calibri, Arial, sans-serif;
        text-align: left;
        vertical-align: middle;
        font-weight: bold;
        height: 560px;
        table-layout: fixed;
        border-collapse: collapse;
        border: 2px solid black;
    }
    img{
        height:55px;
        margin-left:160px;
        margin-top: 8px;
    }
<style>
</head>
<body>
<table style="width: 100%;">
    <tr>
        <td style="text-align: center; vertical-align: top; font-weight: bold;">
            <div style="display: flex; align-items: center; justify-content: center;">
                <img src="../img/iso2.png"
                    style="max-width: 80px; margin-right: 15px;">
                <h1 style="font-size:20px"><strong>PACK EXPRESS URUGUAY</strong></h1>
            </div>
        </td>
    </tr>
    <tr style="padding:10px">
        <td style="border: 1px solid black;">
            <div>
             <p style="text-align: left; font-weight: bold; font-size: 36px;margin-left:10px;margin-top:20px"><strong>' . $codigoBarra . '</strong></p>
            </div>
            <div style="text-align: center;">
            <div style="margin-top: -80px">
                <img  style="height:90px;width:90px; margin-left:300px;" src="../img/qr/' . $codigoBarra . '.png"></img>
            </div>

        </div>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid black;padding-left:10px">
            <p style="font-size:16px">' . $nombre . '</p>
            <p style="font-size:16px">CI: ' . $ci . '</p>
            <p style="font-size:16px">Teléfono: ' . $tel . '</p>
            <p style="font-size:16px">Dirección: ' . $dir . '</p>
            <p style="font-size:16px">Código Postal: (' . $cod_postal . '), Código Provincia: (' . $codigoProvincia . '), Código Municipio: (' . $codigoMunicipio . '), País Destino: ' . $descPaisDest . '</p>
          <div style="position: absolute; width: 125px; top: 150px; left: 318px;">  
            <h1 style="margin-left:30px">' . $codPaisDest . '</h1>
            <div>
            <div style="display: inline-block; width: 100%;">
            ' . $barHTMLDest->getBarcode($codPaisDest, $barHTMLDest::TYPE_CODE_128) . '
             </div>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid black;">
        <p style="font-size: 18px;margin-left:10px;">' . $dpto . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $numero . '</p>
        </td>
       
    </tr>
    <tr>
        <td style="border: 1px solid black;"> <p style="font-size:16px;margin-left:10px">Remitente: ' . $nombreRemit . '</p></td>
    </tr>
    <tr>
        <td style="border: 1px solid black;"> <p style="font-size: 17px;margin-left:10px;">Peso(kg): ' . $peso_real . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volumen(m³): ' . $peso_volumetrico . '</p></td>
    </tr>
    <tr>
    <td style="border: 1px solid black;"> <p style="font-size: 17px;margin-left:10px;">Bultos: ' . $num_bulto . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $descripcion . '</p></td>
</tr>
    <tr style="height:800px">
        <td style="border: 1px solid black;">
        <div style="margin-left:60px" >' . $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128) . $barHTML->getBarcode($codigoBarra, $barHTML::TYPE_CODE_128) . '</div>
        <div style="color: black;font-size: 24px;margin-left: 125px"><strong>' . $codigoBarra . '</strong></div>
        </td>
    </tr>
</table>
</body>';


use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();
$dompdf->stream($codigoBarra . '.pdf', array('Attachment' => false));


?>