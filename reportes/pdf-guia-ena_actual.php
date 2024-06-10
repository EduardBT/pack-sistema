
<style>
    @page {
    margin:0;
}
    .collapse{
    border-collapse:collapse;
    border: 1px solid black;
    padding:0;
}
table{
    width:100%;
    padding:0;
}
.izq{
    text-align:left;
    margin:2px;
}
.membretes{
    font-size: 0.6rem;
    /*font-style:italic;
    Background:#00001a;*/
    line-height:1em;
    text-align:left;
    
}
</style>
<?php

include "../conexion.php";


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $guiaAWB=$_GET['guiaAWB'];
    $query = "SELECT * FROM guia_embarque  WHERE id_guia = $id";
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
    $query3 = "SELECT * FROM cod_pais  WHERE id_pais = $cod_origen ";
    $resultado3 = mysqli_query($conexion, $query3);

    if (mysqli_num_rows($resultado3) == 1) {
        $row3 = mysqli_fetch_array($resultado3);
        $pais_origen=$row3['descripcion'];
    }
}
?>
<html>
    <body>
        <table class="collapse">
            <thead >
                <tr>
                    <th class="izq"> 230 MVD <?php echo $guiaAWB;?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>230-<?php echo $guiaAWB;?></th>
                    <th></th>
                </tr>  
            </thead>     
        </table> 
        
        <table class="collapse">
           <!-- <thead class="membretes">
                <tr>
                    <th class="cant">230 </th>
                    <th class="desc">MVD</th>
                </tr>  
            </thead>   -->  
            <tbody > 
                <tr >
                    <th class="membretes" > Shipper´s Name and Address</th>
                    <th class="membretes" >Shipper´s Acount Number</th>
                    <th class="membretes">pppp</th>
                    <th class="membretes">pppp</th>
                </tr>
            </tbody>
        </table>  
    </body>    
</html>    