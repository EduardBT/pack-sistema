<?php
include "../conexion.php";

$id = $_GET['id']; // Obtén el ID enviado a través de la URL

$query = "SELECT
              m.id_manifiesto,
              m.numero AS numero_externo,
              m.fecha,
              m.vuelo,
              m.cod_origen,
              m.cod_destino,
              m.expedidor,
              m.consignatario,
              m.fechaArribo,
              me.manifiesto_id,
              me.guia_id,
              g.*,
              (SELECT codigo FROM cod_pais WHERE id_pais = m.cod_origen) AS pais_origen,
              (SELECT codigo FROM cod_pais WHERE id_pais = m.cod_destino) AS pais_destino,
              (SELECT SUM(peso_real) FROM guia_embarque WHERE manifiesto_id = me.manifiesto_id AND id_guia = me.guia_id) AS peso_total,
              (SELECT SUM(cantidad_bulto) FROM guia_embarque WHERE manifiesto_id = me.manifiesto_id AND id_guia = me.guia_id) AS cant_bultos,
              pe_env.dni AS dni_Env,
              pe_env.nombre AS nombre_Env,
              pe_env.apellidos AS apellidos_Env,
              pe_env.direccion AS direccion_Env,
              pe_env.tel AS tel_Env,
              pe_env.departamento AS departamento_Env,       
              pe_env.fecha_nacimiento AS fecha_nacimiento_Env,       
              pd_dest.dni AS dni_dest,
              pd_dest.nombre AS nombre_dest,
              pd_dest.apellidos AS apellidos_dest,
              pd_dest.direccion AS direccion_dest,
              pd_dest.tel AS tel_dest,
              pd_dest.departamento AS departamento_dest,
              pd_dest.fecha_nacimiento AS fecha_nacimiento_dest,
              pd_dest.direccion AS direccion_dest,
              pd_dest.provincia AS provincia_dest
          FROM manifiesto AS m
          JOIN manif_embarq AS me ON m.id_manifiesto = me.manifiesto_id
          JOIN guia_embarque AS g ON me.guia_id = g.id_guia
          JOIN personas AS pe_env ON pe_env.id_persona = g.personasEnv_id
          JOIN personas AS pd_dest ON pd_dest.id_persona = g.personasDest_id
          WHERE m.estado_id = 1 AND m.id_manifiesto = $id";

$result = mysqli_query($conexion, $query);


// Obtén los resultados en forma de arreglo
$resultados = array();
while ($row = mysqli_fetch_assoc($result)) {
    $resultados[] = $row;
}

// Convierte los resultados en formato JSON
$jsonResultados = json_encode($resultados);

// Devuelve los resultados al cliente
header("Content-Type: application/json");
echo $jsonResultados;
?>