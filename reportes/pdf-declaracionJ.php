<!DOCTYPE html>
<html>
<head>

<?php

include "../conexion.php";

if (isset($_GET['id_guia'])) {
    $id = $_GET['id_guia'];
    $total = $_GET['totalDeclarado'];
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

        $query_modif = "UPDATE guia_embarque set valor_mercancia = $total +$valor WHERE id_guia = $id_guia";
        $resultado = mysqli_query($conexion, $query_modif);
        if ($resultado) {
            /* die("Error al modificar guia");*/
        }

    }

}

?>
<style>

@page {
    margin:0;
}

.detalleSuperior{
    width: 900px;
    height:143px;  /* alto para los detalles de la parte superior */
    border:5px solid red;
    background:red;
    color:black;
    display:flex;
    align-items:flex-end;
    line-height:0.1em;
    
    
}

.comments-instructions {
    display: flex;
    flex-direction: column; /* Stack the text vertically */
    justify-content: flex-start; /* Align to the start (left) */
    margin-top: 2px; /* Adjust this value for the desired spacing */
    text-align: left; /* Left-align the text within the div */
}

.destinatario{
    width:200px;
    height:100px;
   align-items:flex-end;
}
.receptor{
    width:250px;
    height:100px;
    margin-left:260px;
align-items:flex-end;
}

.direccion{
    line-height:0.8em;
    
    align-items:flex-end;
 
}


.membretesSuperior{
    font-size: 0.6rem;
    align-items:flex-end;
    
}
.membretes{
    font-size: 0.40rem;
    font-style:italic;
    background:#00001a;
    line-height:.4em;
    color:white;
    
}
.nombre{
    font-size: 0.8rem;
}
.letraDetalles{
    font-size: 0.6rem;
    line-height:0.1rem;
}

.letraDetallesPie{
    font-size: 0.6rem;
    line-height:0.1rem;
}

.letraDetallesNotaPie{
    font-size: 0.5rem;
    line-height:0.9rem;
    margin-right:10px;
}
.detalles{
    width: 1020px;
    height:50px;
    border:5px solid red;
    background:red;
    color:black;
    display:flex;
    align-items:flex-end;
    margin-top:200px;
    line-height:0.7em;
    
}
.cantidad{
    width:115px;
    height:150px;
  
    /*background:blue;*/
}
.descripcion{
    width:155px;
    height:150px;
    margin-left:115px;
    margin-right:300px;
    /*background:green;*/
}
.precio{
    width:180px;
    height:150px;
    margin-left:270px;  
}
.pieTabla{
    line-height:1em;
    margin-left:10px;
}

#house{
    color:black;
    margin-left:50px;
    font: 2em "Trebuchet MS",Arial,Sans-Serif;  
}
#letraGrande{
    font: "Trebuchet MS",Arial,Sans-Serif;
    font-size: 1em;
}

.color_columna{
    background:#ccccff;
}

.interno{
border: 1px solid black;
}
.collapse{
    border-collapse:collapse;
    border: 1px solid black;
    padding:0;
    font-size: 0.40rem;
    
    line-height:.4em;
    
}
table{
    width:100%;
    padding:0;
}

.izq{
    text-align:left;
    margin:2px;
}

.der{
    text-align:right;
    margin-right:3px;
}

.cant{
    width:5%;
    height: 10px;
}

.desc{
    width:37%; 
    height: 10px;
}

.interlineado{
 
}
#right-link {
  position: fixed;
  bottom: 1%;
  right: 20px;
  transform: translateY(-2%);
}
</style>

<body>
<br>
 <div class="detalleSuperior " >    
    <div class="destinario membretesSuperior" style="padding-left: 30px">    
    <?php
    $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_origen";
    $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
    $resultadoPais = mysqli_query($conexion, $queryPais);
    while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
                                                                                        <div>
                                                                                        <?php
                                                                                        $length = 9;
                                                                                        $secoundrow = 'CM';
                                                                                        $segoundrow = 'PK';
                                                                                        $string = substr(str_repeat(0, $length) . $id_guia, -$length);
                                                                                        $codigoBarra = $secoundrow . $string . $segoundrow;
                                                                                        ?>
                                                                                        <?php
                                                                                        $codPais = $rowPais['codigo'];
                                                                                        ?>
                                                                                        <p id="house" font= '"Trebuchet MS",Arial,Sans-Serif"' font-size='4em'  style="margin-left:-4px"><strong><?php echo $codigoBarra; ?></strong> </p>
                                                                                        <p class= "interlineado"><strong>Fecha/Date: </strong><?php echo date("F") . " " . date("m") . ", " . date("Y"); ?> </p>
                                                                                        <p class= "interlineado"> <strong>Factura/Invoice: <?php echo $string ?></strong></p><br>

                                                                                        <p ><strong><u>SHIPPER:</u></strong></p>
                                                                                            <p><strong>Desde: </strong><?php echo $codPais; ?></p>
                                                                                </div> <?php
    } ?>
        <?php
        $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
        $resultadoEnv = mysqli_query($conexion, $queryEnvia);
        while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                                                                                        <p><strong>I.D / RUC / Passport: </strong><?php echo $rowEnv['dni']; ?></p>
                                                                                        <p><strong>Contacto/Contact: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                                                                                        <p><strong>Teléfono/Phone: </strong><?php echo $rowEnv['tel']; ?></p>
                                                                                        <p><strong>E-mail: </strong><?php echo $rowEnv['correo']; ?></p>
                                                                                        <p><strong>Compañía/Company: </strong><?php echo $rowEnv['correo']; ?></p>
                                                                                        <span style="width:40%;position:absolute;"><p class="direccion" style="align-items: flex-end; line-height: 1;"><strong>Direccion/Address:</strong><?php echo $rowEnv['direccion'] . ',  ' . $rowEnv['departamento'] . ', CP:  ' . $rowEnv['cod_postal']; ?></p></span>

        <?php } ?>
        <br>Comentarios/Comments or Special Instructions:<br>         
         <div class="comments-instructions"> </div>
    </div>

    <div class="receptor membretesSuperior">
        <h2  style="max-width:95%;" class="text-center" id="letraGrande" >Factura Comercial</h2>
        <br />
        <br />
        <h2 class="text-center" style="max-width:95%;" id="letraGrande">(Commercial Invoice)</h2>
        <h2 class="text-center" style="max-width:95%;" id="letraGrande"></h2>
        <h2 class="text-center" style="max-width:95%;" id="letraGrande"></h2>
        <br />
        <br />
        <br />
        <p class="text-center"><strong><u>SHIPPED TO:</u></strong></p> 
            <?php
            $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_destino";
            $resultadoPais = mysqli_query($conexion, $queryPais);
            while ($rowPais = $resultadoPais->fetch_assoc()) { ?>
                                                                                                <div>
                                                                                                        <?php
                                                                                                        $codPais = $rowPais['codigo'];
                                                                                                        ?>
                                                                                                    <p><strong>A: </strong><?php echo $codPais; ?></p>
                                                                                                </div> <?php
            } ?>
        <?php
        $queryEnvia = "SELECT * FROM personas WHERE id_persona =$destinatario";
        $resultadoEnv = mysqli_query($conexion, $queryEnvia);
        while ($rowEnv = $resultadoEnv->fetch_assoc()) { ?>
                                                                                            <p><strong>I.D / RUC / Passport: </strong><?php echo $rowEnv['dni']; ?></p>
                                                                                            <p><strong>Contacto/Contact: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                                                                                            <p><strong>Teléfono/Phone: </strong><?php echo $rowEnv['tel']; ?></p>
                                                                                            <p><strong>E-mail: </strong><?php echo $rowEnv['correo']; ?></p>
                                                                                            <p><strong>Compañía/Company: </strong><?php echo $rowEnv['correo']; ?></p>
                                                                                            <p class="direccion" style="align-items: flex-end;line-height: 1;"><strong>Direccion/Address: </strong><?php echo $rowEnv['direccion'] . ', ' . $rowEnv['departamento'] . ', CP: ' . $rowEnv['cod_postal']; ?></p>
     <?php } ?>
        
        <p><strong>Incoterm: </strong><?php echo $icontem; ?></p>
        
    </div>
</div>
<br>
<br>
 <table class="collapse" style="margin-left:20px;margin-top:5px">
    <thead class="membretes" >
        <tr>
            <th class="cant">Cantidad (Quantity)</th>
            <th class="desc" style="line-height: 1">Descripcióoon (Description)</th>
            <th>Precio Unitario (Unit Price)</th>
            <th>Cantidad (Amount)<th>
        </tr>  
    </thead>     
    <tbody class="letraDetalles"> 
        <tr class="collapse">
            <th class="collapse"><p><?php echo !empty($_GET['cantidad1']) ? $_GET['cantidad1'] : ""; ?></p></th>
            <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion1']) ? $_GET['descripcion1'] : ""; ?></p></th>
            <th class="collapse"><p  class="der"><?php echo !empty($_GET['precio1']) ? number_format($_GET['precio1'], 2, ',', '.') : ''; ?></p></th>
            <th class="color_columna collapse"><p class="der"><?php if (!empty($_GET['total1']) && $_GET['total1'] > 0): ?>
                                                                                <p><?php echo number_format($_GET['total1'], 2, ',', '.'); ?></p><?php endif; ?></p> </th>
        </tr>  
        <tr class="collapse">
         <th class="collapse"><p><?php echo !empty($_GET['cantidad2']) ? $_GET['cantidad2'] : ""; ?></p></th>
            <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion2']) ? $_GET['descripcion1'] : ""; ?></p></th>
            <th class="collapse"><p  class="der"><?php echo !empty($_GET['precio2']) ? number_format($_GET['precio2'], 2, ',', '.') : ''; ?></p></th>
            <th class="color_columna collapse"><p class="der"><?php if (!empty($_GET['total2']) && $_GET['total2'] > 0): ?>
                                                                                                                                        <p><?php echo number_format($_GET['total2'], 2, ',', '.'); ?></p>
            <?php endif; ?></p> </th>
        </tr> 
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad3']) ? $_GET['cantidad3'] : ""; ?></p></th>
            <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion3']) ? $_GET['descripcion3'] : ""; ?></p></th>
            <th class="collapse"><p  class="der"><?php echo !empty($_GET['precio3']) ? number_format($_GET['precio3'], 2, ',', '.') : ''; ?></p></th>
            <th class="color_columna collapse"><p class="der"><?php if (!empty($_GET['total3']) && $_GET['total3'] > 0): ?>
                                                                                                                                            <p><?php echo number_format($_GET['total3'], 2, ',', '.'); ?></p>
            <?php endif; ?></p> </th>
        </tr> 
        <tr class="collapse">
         <th class="collapse"><p><?php echo !empty($_GET['cantidad4']) ? $_GET['cantidad4'] : ""; ?></p></th>
            <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion4']) ? $_GET['descripcion4'] : ""; ?></p></th>
            <th class="collapse"><p  class="der"><?php echo !empty($_GET['precio4']) ? number_format($_GET['precio4'], 2, ',', '.') : ''; ?></p></th>
            <th class="color_columna collapse"><p class="der"><?php if (!empty($_GET['total']) && $_GET['total4'] > 0): ?>
                                                                                                                                            <p><?php echo number_format($_GET['total4'], 2, ',', '.'); ?></p>
            <?php endif; ?></p> </th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad5']) ? $_GET['cantidad5'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion5']) ? $_GET['descripcion5'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio5']) ? number_format($_GET['precio5'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total5']) && $_GET['total5'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total5'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad6']) ? $_GET['cantidad6'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion6']) ? $_GET['descripcion6'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio6']) ? number_format($_GET['precio6'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total6']) && $_GET['total6'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total6'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad7']) ? $_GET['cantidad7'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion7']) ? $_GET['descripcion7'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio7']) ? number_format($_GET['precio7'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total7']) && $_GET['total7'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total7'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad8']) ? $_GET['cantidad8'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion8']) ? $_GET['descripcion8'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio8']) ? number_format($_GET['precio8'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total8']) && $_GET['total8'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total8'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad9']) ? $_GET['cantidad9'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion9']) ? $_GET['descripcion9'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio9']) ? number_format($_GET['precio9'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total9']) && $_GET['total9'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total9'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad10']) ? $_GET['cantidad10'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion10']) ? $_GET['descripcion10'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio10']) ? number_format($_GET['precio10'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total10']) && $_GET['total10'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total10'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad11']) ? $_GET['cantidad11'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion11']) ? $_GET['descripcion11'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio11']) ? number_format($_GET['precio11'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total11']) && $_GET['total11'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total11'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad12']) ? $_GET['cantidad12'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion12']) ? $_GET['descripcion12'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio12']) ? number_format($_GET['precio12'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total12']) && $_GET['total12'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total12'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad13']) ? $_GET['cantidad13'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion13']) ? $_GET['descripcion13'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio13']) ? number_format($_GET['precio13'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total13']) && $_GET['total13'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total13'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad14']) ? $_GET['cantidad14'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion14']) ? $_GET['descripcion14'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio14']) ? number_format($_GET['precio14'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total14']) && $_GET['total14'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total14'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad15']) ? $_GET['cantidad15'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion15']) ? $_GET['descripcion15'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio15']) ? number_format($_GET['precio15'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total15']) && $_GET['total15'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total15'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad16']) ? $_GET['cantidad16'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion16']) ? $_GET['descripcion16'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio16']) ? number_format($_GET['precio16'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total16']) && $_GET['total16'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total16'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad17']) ? $_GET['cantidad17'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion17']) ? $_GET['descripcion17'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio17']) ? number_format($_GET['precio17'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total17']) && $_GET['total17'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total17'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad18']) ? $_GET['cantidad18'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion18']) ? $_GET['descripcion18'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio18']) ? number_format($_GET['precio18'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total18']) && $_GET['total18'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total18'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad19']) ? $_GET['cantidad19'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion19']) ? $_GET['descripcion19'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio19']) ? number_format($_GET['precio19'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total18']) && $_GET['total19'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total19'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad20']) ? $_GET['cantidad20'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion20']) ? $_GET['descripcion20'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio20']) ? number_format($_GET['precio20'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total20']) && $_GET['total20'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total20'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad21']) ? $_GET['cantidad21'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion21']) ? $_GET['descripcion21'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio21']) ? number_format($_GET['precio21'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total21']) && $_GET['total21'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total21'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad22']) ? $_GET['cantidad22'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion22']) ? $_GET['descripcion22'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio22']) ? number_format($_GET['precio22'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total22']) && $_GET['total22'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total22'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad23']) ? $_GET['cantidad23'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion23']) ? $_GET['descripcion23'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio23']) ? number_format($_GET['precio23'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total23']) && $_GET['total23'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total23'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad24']) ? $_GET['cantidad24'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion24']) ? $_GET['descripcion24'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio24']) ? number_format($_GET['precio24'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total24']) && $_GET['total24'] > 0): ?>
                                                                                                                <p><?php echo number_format($_GET['total23'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr class="collapse">
        <th class="collapse"><p><?php echo !empty($_GET['cantidad25']) ? $_GET['cantidad25'] : ""; ?></p></th>
        <th class="collapse"><p class="izq"><?php echo !empty($_GET['descripcion25']) ? $_GET['descripcion25'] : ""; ?></p></th>
        <th class="collapse"><p class="der"><?php echo !empty($_GET['precio25']) ? number_format($_GET['precio25'], 2, ',', '.') : ''; ?></p></th>
        <th class="color_columna collapse"><p class="der">
            <?php if (!empty($_GET['total25']) && $_GET['total25'] > 0): ?>
                                                                                                            <p><?php echo number_format($_GET['total23'], 2, ',', '.'); ?></p>
            <?php endif; ?>
        </p></th>
        </tr>
        <tr>
        <td colspan="2" rowspan="4">
            <p class="pieTabla">
                <strong>Declaro que según mi leal saber y entender, la información antes mencionada es cierta y correcta, además que este envío se origina en el país de URUGUAY.</strong>
            </p>
        </td>
        <td class="collapse">
            <p class="der letraDetallesPie"><strong></strong></p>
        </td>
        <td class="collapse">
            <p class="der">0,00%</p>
        </td>
        </tr>
        <tr>
            <td class="collapse">
                <p class="der letraDetallesPie"><strong></strong></p>
            </td>
            <td class="collapse color_columna">
                <p class="der">0,00</p>
            </td>
        </tr>
        <tr>
            <td class="collapse">
                <p class="der letraDetallesPie"><strong></strong></p>
            </td>
            <td class="collapse">
                <p class="der"><strong>0,00</strong></p>
            </td>
        </tr>
        <tr>
            <td class="collapse">
                <p class="der letraDetallesPie"><strong>Sub TOTAL</strong></p>
            </td>
            <td class="collapse color_columna">
                <p class="der"><strong><?php echo number_format($_GET['totalDeclarado'], 2, ',', '.'); ?></strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?php
                $queryEnvia = "SELECT * FROM personas WHERE id_persona = $remitente";
                $resultadoEnv = mysqli_query($conexion, $queryEnvia);
                while ($rowEnv = $resultadoEnv->fetch_assoc()) {
                    ?>
                                                                        <p class="letraDetalles">
                                                                            <strong>Nombre/Name: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Firma/Signature: </strong>_____________________
                                                                        </p>
                    <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <p class="letraDetallesNotaPie">
                    <strong>ADJUNTAR Y ARCHIVAR COPIAS DE LA DECLARACIÓN DE SEGURIDAD, COPIA DE PASAPORTE O IDENTIDAD PERSONAL, LICENCIA DE CONDUCIR</strong>
                </p>
            </td>
        </tr>

        <div id="right-link">
            <p class="letraDetalles">
                <a href="#" style="text-decoration: underline; text-align:right;">https://www.copacourier.com/es/Bienvenido.aspx</a>
            </p>
            <p class="letraDetalles">
                <a href="#" style="text-decoration: underline; text-align:right;">https://www.correos.cu/rastreador-de-envios/</a>
            </p>

        </div>       
    </tbody>    
</table > 
</body>

