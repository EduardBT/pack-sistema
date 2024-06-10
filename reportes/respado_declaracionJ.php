<style>
  @page {
    margin: 0;
  }

  .detalleSuperior {
    width: 900px;
    height: 260px;
    border: 5px solid red;
    background: red;
    color: black;
    display: flex;
    align-items: flex-end;
    line-height: 0.5em;
  }

  .destinatario {
    width: 200px;
    height: 100px;
  }

  .receptor {
    width: 250px;
    height: 100px;
    margin-left: 260px;
  }

  .direccion {
    line-height: 0.8em;
  }

  .membretesSuperior {
    font-size: 0.8rem;
  }

  .membretes {
    font-size: 0.8rem;
    font-style: italic;
    background: #00001a;
    line-height: 1em;
    color: white;
  }

  .nombre {
    font-size: 0.8rem;
  }

  .letraDetalles {
    font-size: 0.7rem;
  }

  .detalles {
    width: 1020px;
    height: 50px;
    border: 5px solid red;
    background: red;
    color: black;
    display: flex;
    align-items: flex-end;
    margin-top: 200px;
    line-height: 0.7em;
  }

  .cantidad {
    width: 115px;
    height: 150px;
  }

  .descripcion {
    width: 155px;
    height: 150px;
    margin-left: 115px;
    margin-right: 300px;
  }

  .precio {
    width: 180px;
    height: 150px;
    margin-left: 270px;
  }

  .total {
    width: 100px;
    height: 150px;
    margin-right: 370px;
  }

  #house {
    color: red;
    margin-left: 50px;
  }

  .color_columna {
    background: #ccccff;
  }

  table {
    background: #ccccff;
  }
</style>


</head>   
<?php

include "../conexion.php";


if (isset($_GET['id_guia'])) {
    $id = $_GET['id_guia'];
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


<body>




<br>

<div class="detalleSuperior ">
    <div class="destinario membretesSuperior">
        <h4 id="house">HOUSE </h4>
        <p><strong>Fecha/Date: </strong><?php echo date("F") . " " . date("m") . ", " . date("Y");?> </p>
        <p ><strong>Factura/Invoice: </strong></p>

        <p ><strong><u>SHIPPER:</u></strong></p>

        <?php
        $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_origen";
        $resultadoPais= mysqli_query($conexion, $queryPais);
        while ($rowPais = $resultadoPais->fetch_assoc()) {?>
        <div>
                <?php
                $codPais = $rowPais['codigo'];
            ?>
            <p><strong>Enviado desde: </strong><?php echo $codPais; ?></p>
        </div> <?php
        } ?>
            <?php
        $queryEnvia = "SELECT * FROM personas WHERE id_persona =$remitente";
        $resultadoEnv = mysqli_query($conexion, $queryEnvia);
        while ($rowEnv = $resultadoEnv->fetch_assoc()) {?>
            <p><strong>I.D / RUC / Passport: </strong><?php echo $rowEnv['dni']; ?></p>
            <p><strong>Contacto/Contact: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
            <p><strong>Teléfono/Phone: </strong><?php echo $rowEnv['tel']; ?></p>
            <p><strong>E-mail: </strong><?php echo $rowEnv['correo']; ?></p>
            <p><strong>Compañía/Company: </strong><?php echo $rowEnv['correo']; ?></p>
            <p class="direccion"><strong>Direccion/Address: </strong><?php echo $rowEnv['direccion'] . ' ' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?></p>
        <?php
            }?>
        <br>
        <p><strong>Comentarios/Comments or Special <br>Instructions:</strong></p>

       
    </div>
    <div class="receptor membretesSuperior">
        <h2 class="text-center" style="max-width:80%;">Factura Comercial  </h2>
        <h2 class="text-center" style="max-width:80%;">(Commercial Invoice)</h2><br>
        <p class="text-center"><strong><u>SHIPPED TO:</u></strong></p>
            

        <?php
        $queryPais = "SELECT * FROM cod_pais WHERE id_pais =$cod_destino";
        $resultadoPais= mysqli_query($conexion, $queryPais);
        while ($rowPais = $resultadoPais->fetch_assoc()) {?>
        <div>
                <?php
                $codPais = $rowPais['codigo'];
            ?>
            <p><strong>Enviado desde: </strong><?php echo $codPais; ?></p>
        </div> <?php
        } ?>
        <?php
            $queryEnvia = "SELECT * FROM personas WHERE id_persona =$destinatario";
            $resultadoEnv = mysqli_query($conexion, $queryEnvia);
            while ($rowEnv = $resultadoEnv->fetch_assoc()) {?>
                <p><strong>I.D / RUC / Passport: </strong><?php echo $rowEnv['dni']; ?></p>
                <p><strong>Contacto/Contact: </strong><?php echo $rowEnv['nombre'] . ' ' . $rowEnv['apellidos']; ?></p>
                <p><strong>Teléfono/Phone: </strong><?php echo $rowEnv['tel']; ?></p>
                <p><strong>E-mail: </strong><?php echo $rowEnv['correo']; ?></p>
                <p><strong>Compañía/Company: </strong><?php echo $rowEnv['correo']; ?></p>
                <p class="direccion"><strong>Direccion/Address: </strong><?php echo $rowEnv['direccion'] . ' ' . $rowEnv['pais'] . ' ' . $rowEnv['departamento']; ?></p>
        <?php
            }?>
        
        <p><strong>Incoterm: </strong><?php echo $icontem; ?></p>
        
    </div>
</div>

<br>
<br>

<div class="detalles">
    <div class="cantidad letraDetalles">
        <h3 class="membretes">Cantidad (Quantity) <br>.</h3> 
        <?php
        $cantidades = array(
            $_GET['cant1'], $_GET['cant2'], $_GET['cant3'], $_GET['cant4'], $_GET['cant5'],
            $_GET['cant6'], $_GET['cant7'], $_GET['cant8'], $_GET['cant9'], $_GET['cant10'],
            $_GET['cant11'], $_GET['cant12'], $_GET['cant13'], $_GET['cant14'], $_GET['cant15'],
            $_GET['cant16'], $_GET['cant17'], $_GET['cant18'], $_GET['cant19'], $_GET['cant20']
        );
        $precios = array(
            $_GET['precio1'], $_GET['precio2'], $_GET['precio3'], $_GET['precio4'], $_GET['precio5'],
            $_GET['precio6'], $_GET['precio7'], $_GET['precio8'], $_GET['precio9'], $_GET['precio10'],
            $_GET['precio11'], $_GET['precio12'], $_GET['precio13'], $_GET['precio14'], $_GET['precio15'],
            $_GET['precio16'], $_GET['precio17'], $_GET['precio18'], $_GET['precio19'], $_GET['precio20']
        );
        $subtotal = 0;
        for ($i = 0; $i < count($cantidades); $i++) {
            $cantidad = intval($cantidades[$i]);
            $precio = floatval($precios[$i]);
            $total = $cantidad * $precio;
            $subtotal += $total;
            echo "<p>$cantidad</p>";
        }
        ?>
    </div>
    
    <div class="descripcion letraDetalles">
        <h3 class="membretes">Descripcion (Description) <br>.</h3><br>
        <?php
        $descripciones = array(
            $_GET['descripcion1'], $_GET['descripcion2'], $_GET['descripcion3'], $_GET['descripcion4'], $_GET['descripcion5'],
            $_GET['descripcion6'], $_GET['descripcion7'], $_GET['descripcion8'], $_GET['descripcion9'], $_GET['descripcion10'],
            $_GET['descripcion11'], $_GET['descripcion12'], $_GET['descripcion13'], $_GET['descripcion14'], $_GET['descripcion15'],
            $_GET['descripcion16'], $_GET['descripcion17'], $_GET['descripcion18'], $_GET['descripcion19'], $_GET['descripcion20']
        );
        for ($i = 0; $i < count($descripciones); $i++) {
            $descripcion = $descripciones[$i];
            echo "<p>$descripcion</p>";
        }
        ?>
    </div>
    
    <div class="precio letraDetalles">
        <h3 class="membretes">Precio Unitario <br> (Unit Price)</h3>
        <?php
        for ($i = 0; $i < count($precios); $i++) {
            $precio = $precios[$i];
            echo "<p>$precio</p>";
        }
        ?>
    </div>
    
    <div class="total letraDetalles">
        <h3 class="membretes">Cantidad (Amount)</h3><br>
        <?php
        $totales = array(
            $_GET['total1'], $_GET['total2'], $_GET['total3'], $_GET['total4'], $_GET['total5'],
            $_GET['total6'], $_GET['total7'], $_GET['total8'], $_GET['total9'], $_GET['total10'],
            $_GET['total11'], $_GET['total12'], $_GET['total13'], $_GET['total14'], $_GET['total15'],
            $_GET['total16'], $_GET['total17'], $_GET['total18'], $_GET['total19'], $_GET['total20']
        );
        for ($i = 0; $i < count($totales); $i++) {
            $total = floatval($totales[$i]);
            echo "<p>$total</p>";
        }
        ?>
    </div>
</div>

<div class="subtotal letraDetalles">
    <h3 class="membretes">Subtotal</h3>
    <p><?php echo $subtotal; ?></p>
</div>

<br>

<table>
    <thead class="membretes">
        <tr>
            <th>Cantidad (Quantity)</th>
            <th>Descripcio (Description)</th>
            <th>Precio Unitario (Unit Price)</th>
            <th>Cantidad (Amount)</th>
        </tr>  
    </thead>     
    <tbody class="letraDetalles"> 
        <?php
        for ($i = 0; $i < count($cantidades); $i++) {
            $cantidad = intval($cantidades[$i]);
            $descripcion = $descripciones[$i];
            $precio = floatval($precios[$i]);
            $total = floatval($totales[$i]);
            echo "<tr>";
            echo "<th><p>$cantidad</p></th>";
            echo "<th><p>$descripcion</p></th>";
            echo "<th><p>$precio</p></th>";
            echo "<th class='color_columna'><p>$total</p></th>";
            echo "</tr>";
        }
        ?>
    </tbody>    
</table>

</body>
</html>
