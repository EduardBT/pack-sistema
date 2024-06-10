<?php
include_once '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';


use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
include "../conexion.php";



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

}

?>
<!doctype html>
<html lang="es">

<head>
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

</head>
<style>
    .container {
        overflow: auto;
        margin-top: 20px;
        /* Limpiar el flujo de los elementos flotantes */
    }

    .justificado {
        text-align: justify;
    }

    .box {
        width: 360px;
        height: 500px;
        float: left;
    }

    .box1 {
        margin-left: -20px;
        margin-right: 25px;
    }

    .box2 {}
</style>

<body>
    <!-- First Page -->
    <div style="text-align: center; font-size: 11px;">
        <b><u>CONTRATO DE PRESTACION DE SERVICIOS DE MENSAJERIA, PAQUETERIA Y CARGA NO COMERCIAL</u></b>
    </div>
    <div style="font-size: 11px;margin-top:12px">
        <b><u>DE UNA PARTE: </u></b>La Sociedad Mercantil por Acciones Simplificadas <b>PACK EXPRESS URUGUAY SAS</b> con
        domicilio en Carlos Quijano 1258 esq: Soriano, Montevideo.
    </div>
    <div style="font-size: 11px;">
        <b><u>DE OTRA PARTE:</u></b>
        <?php
        $queryPersona = "SELECT * FROM personas WHERE id_persona =$remitente";
        $resultadoPersona = mysqli_query($conexion, $queryPersona);
        while ($rowPersona = $resultadoPersona->fetch_assoc()) {
            echo '<u style="white-space: pre;">                                  ' . $rowPersona['nombre'] . " " . $rowPersona['apellidos'] . '                                           </u>';
        }
        ?>
        en lo adelante se denominará, EL CLIENTE.
    </div>

    <div class="container">
        <div class="box box1" style="font-size: 8.6px;">
            <b>TERMINOS Y CONDICIONES</b><br>
            <p class="justificado">
                Al presentar el embarque aquí descrito para su transporte, el remitente acepta estas condiciones del
                contrato y acepta que esta guía aérea no es negociable y ha sido preparada por él o, a su solicitud, por
                el transportista.
            </p>
            <p class="justificado">
                <b>1. </b> Como se usa aquí, “Transportista” significa “la línea aérea u operador de carga que
                transporta los
                bienes descritos aquí”. La Convención de Varsovia significa la convención para la unificación de ciertas
                normas relativas al transporte Internacional aéreo firmada en Varsovia en 1929. La Convención de
                Montreal significa la convención para la unificación de ciertas normas relativas al transporte
                Internacional aéreo firmada en Montreal en 1999.<br>

                <b>2. </b> Notificación de las convenciones de Varsovia y Montreal. Las convenciones de Varsovia y
                Montreal
                podrán aplicarse a este embarque y limitar nuestra responsabilidad por daño (s), pérdida o demora. De
                otra manera, nuestra responsabilidad por demora está limitada al reembolso de sus gastos de transporte
                (pero no por gastos por valores adicionales declarados, derechos aduaneros o impuestos adelantados por
                nosotros a su favor).<br>
                <b>3. </b> Mientras que no entre en conflicto con lo anterior, el embarque aquí contemplado y otros
                servicios
                quedan sujetos a las leyes, reglamentaciones y tarifas aplicables. Dichas tarifas están disponibles para
                su inspección y hacen parte de este contrato.<br>

                <b>4. </b> Cualquier limitación de responsabilidad aplicable a PACK EXPRESS, se aplica igualmente a los
                agentes,
                los empleados y los representantes de PACK EXPRESS.<br>
                <b>5. </b> Ningún agente, empleado o representante de PACK EXPRESS, o del portador está facultado para
                modificar, alterar o renunciar a cualquiera de las disposiciones de este contrato.<br>

                <b>6. </b> El remitente garantiza que cada artículo del embarque está descrito apropiadamente en esta
                guía aérea
                y no ha sido declarado por PACK EXPRESS como inaceptable para el transporte y que el embarque está
                apropiadamente rotulado, dirigido y embalado para garantizar un transporte seguro con la manipulación de
                un ciudadano corriente. El remitente por este medio reconoce que PACK EXPRESS podrá abandonar y/o
                deshacerse de cualquier artículo consignado a PACK EXPRESS por el remitente y que PACK EXPRESS haya
                declarado ser inaceptable, o que el remitente haya devaluado para efectos de aduana, o haya descrito
                equivocadamente aquí, ya sea intencionalmente o de otra forma sin incurrir en ninguna responsabilidad,
                cualquiera que esta sea, con el remitente y el remitente librará, relevará, indemnizará y exonerará de
                responsabilidad a PACK EXPRESS por cualquier reclamo(s), daño(s), multa(s) o gasto(s) que surjan de
                ello.<br>

                <b>7. </b> No subsistirá ningún reclamo por daño(s) o pérdida de los bienes a menos que la persona
                facultada
                para entregarlos presente un reclamo por escrito a PACK EXPRESS, en el caso (1) de daños visibles a los
                bienes inmediatamente después del descubrimiento del daño y a más tardar 21 días después del recibo de
                los bienes; (2) de bienes no entregados, dentro de los 120 días siguientes a la fecha de expedición de
                la guía aérea. No se atenderá ningún reclamo por pérdida o daño hasta que todos los costos del
                transporte hayan sido pagados. La cuantía de cualesquiera de dichos reclamos no podrá ser deducida de
                ningún costo de transportes adeudados a PACK EXPRESS.<br>

                <b>8. </b> PACK EXPRESS tiene el derecho, pero no la obligación de inspeccionar cualquier embarque,
                incluyendo
                pero sin limitarla a la abertura del embarque.<br>

                <b>9. </b> Mientras que PACK EXPRESS realice sus mejores esfuerzos por suministrar una entrega expedita
                de
                conformidad con los horarios de entregas regulares, PACK EXPRESS no será responsable, bajo ninguna
                circunstancia, por la demora en el retiro, transporte o entrega de ningún embarque independientemente de
                la causa de dicha demora. Además, PACK EXPRESS tampoco será responsable de ninguna pérdida, daño,
                entrega equivocada o falta de entrega:
                (a) Debida a acto de naturaleza, suceso de fuerza mayor o cualquier causa razonablemente fuera del
                control de PACK EXPRESS.
                (b) Debido a daño electrónico o magnético, borradura u otro daño similar sufrido de cualquier manera en
                imágenes electrónicas o fotográficas o en grabaciones.<br>

                <b>10. </b> Materiales no aceptables para el transporte salvo por el consentimiento, expreso por escrito
                de un
                funcionario autorizado de PACK EXPRESS, la compañía no transportará dinero, joyas, lingotes, cheques de
                gerencia, antigüedades, sellos, licor, metales preciosos, armas de fuego, giros postales, plantas,
                drogas, tabaco, obras de arte, piedras preciosas, explosivos, cheques viajeros, animales, comestibles y
                artículos restringidos por IATA, incluyendo materiales peligrosos o combustibles.<br>

                <b>11. </b> El remitente cumplirá con todas las leyes y reglamentaciones aplicables. PACK EXPRESS no es
                responsable para con el remitente por pérdida o gastos debido a la falta de cumplimiento por parte del
                remitente de esta disposición.

            </p>

        </div>
        <div class="box box2" style="font-size: 8.6px;">
            <b>TERMS AND CONDITIONS</b><br>
            <p class="justificado">
                On delivering the freight herein described for its transportation, the shipper agrees to the conditions
                of this agreement and accepts that this airway bill is non-negotiable and has been prepared by him or to
                his request.
            </p>
            <p class="justificado">
                <b>1. </b> As herein used “shipper” means “the shipper who transports the goods herein described”. The
                Warsaw
                Convention means the convention for the unification of certain rules relative to the international
                aerial transportation signed in Warsaw in 1929. The Montreal Convention means the convention for the
                unification of certain rules relative to the international aerial transportation signed in Montreal in
                1999.<br>
                <b>2. </b>Notice of the Warsaw and Montreal conventions. The Warsaw and Montreal conventions may apply
                to this
                shipment and limit PACK EXPRESS liability for damage, loss or delay. Otherwise, PACK EXPRESS liability
                for delay is limited to the reimbursement of the Shipper´s transportation charges (but not expenses for
                declared additional securities, customs duties or taxes advanced by PACK EXPRESS in Shipper´s behalf)
                .<br>
                <b>3. </b> Provided there is not conflict with the above, the shipment herein established and other
                services are
                subject to applicable laws, regulations and tariff. The tariffs are available for the shipper´s
                inspections and are part of this Agreement.<br>
                <b>4. </b> Any limitation to the liability applicable to PACK EXPRESS is likewise applicable to the
                agents,
                employees and representatives of PACK EXPRESS .<br>
                <b>5. </b> No agent employee or representative of PACK EXPRESS or the bearer is authorized to modify,
                alter or
                waive any to the provisions of this Agreement.<br>
                <b>6. </b> The shipper warrants that every article of the shipment is properly described in this airway
                bill and
                has not been declared as unacceptable by PACK EXPRESS for transportation, and that the shipment is
                properly addressed and packed to guarantee a safe transportation for the handling with common care. The
                shipper by these means acknowledges that PACK EXPRESS may abandon or dispose of any article consigned
                with PACK EXPRESS by the Shipper that PACK EXPRESS has declared unacceptable, or that the shipper has
                devaluated for customs purposes or mistakenly described herein, be it intentionally or otherwise,
                without incurring in any responsibility whatsoever with the shipper and the shipper will hold harmless,
                release, indemnify and exempt PACK EXPRESS from liability for any claim (s), damage (s) fine (s) or
                expenses (s) arisen.<br>
                <b>7. </b> No claim for damage (s) or loss of goods shall subsist unless that person entitled to deliver
                the
                goods file a claim in writing with PACK EXPRESS in the case of (1) visible damage of the goods,
                immediately after finding the damage and no later than 21 days after receiving the goods; and (2) goods
                not delivered within the following 120 days to the date of expedition or the airway bill. No claim for
                loss or damages will be handled until all transportation costs have been paid. The amount of any such
                claims may not be deducted from any transportation cost owed to PACK EXPRESS .<br>
                <b>8. </b> PACK EXPRESS has the right, but not the obligation, to inspect any shipment, including but
                without
                limiting the opening of the shipment.<br>
                <b>9. </b> While PACK EXPRESS makes its best efforts to make and expedite delivery pursuant to the
                regular
                delivery schedules, PACK EXPRESS shall not be liable, under no circumstances, for the delay in the
                withdrawal, transportation or delivery of any shipment regardless of the cause of said delay. Further,
                PACK EXPRESS is neither responsible for any loss, damages, mistaken delivery or lack delivery:
                (a) Due to acts to nature, force mejeure or any cause reasonably out of control of PACK EXPRESS : or,
                (b) Due to electrical or magnetic damages, erasing or other similar damage suffered in any way in
                electronic photographic images or in recordings.<br>
                <b>10. </b>. Unacceptable materials for transportation except with the express consent in writing of an
                authorized officer of PACK EXPRESS , will not transport money, jewels, ingots, cashier’s checks,
                antiques, stamps, liquors, precious metals, fire arms, money orders, plants, drugs, tobacco, art pieces,
                precious stones, explosives, traveler´s checks, animals, groceries or articles restricted by IATA,
                including hazardous or combustible materials.<br>
                <b>11. </b> The Shipper shall comply with all the laws and regulations applicable, PACK EXPRESS is not
                responsible before the Shipper for losses or expenses due to lack of fulfillment on the part of the
                shipper regarding this provision.<br>

            </p>
        </div>

        <div style="font-size: 11px; text-align: center; margin-top: 800px; position: absolute;margin-left:-300px">
            ____________________________________<br>
            <b>POR PACK EXPRESS</b>
            <div>
                <b>
                    <?php echo 'Montevideo ' . date('d/m/Y'); ?><b>
            </div>
        </div>
        <div style="font-size: 11px; text-align: right; margin-top: 800px; position: absolute;">
            <b>FIRMA CLIENTE:<b> _______________________________________<br><br>
                    <b>ACLARACION:<b> _______________________________________<br><br>
                            <b>CEDULA:<b> _______________________________________

        </div>
    </div>

    <!--declaracion general-->

    <?php
    $html = ob_get_clean();
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);

    // Set the PDF page size to match the fixed-size container, with landscape orientation
    $dompdf->setPaper('400px', '0px', 'landscape');

    $dompdf->render();
    $dompdf->stream("CONTRATO DE PRESTACION DE SERVICIOS.pdf", array("Attachment" => false));
    ?>
</body>

</html>