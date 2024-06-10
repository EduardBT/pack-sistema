<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

// Buscador
$where = "";
if (isset($_POST["enviar-nombre"])) {
    $valor = $_POST['campo'];
    if (!empty($valor)) {
        $where = " ( nombre LIKE '%$valor%' OR id_guia LIKE '%$valor%' OR apellidos LIKE '%$valor%') AND";
    }
}
$query = "SELECT id_guia, personasEnv_id, cod_destino, personasDest_id, tipo_bulto,fecha, fecha_emb, cantidad_bulto, peso_real, empaquetado, numero FROM guia_embarque ORDER BY fecha_emb";
$result = mysqli_query($conexion, $query);
// Arreglos para almacenar las fechas y pesos
$fechas = array();
$pesos = array();
// Recorrer los resultados y almacenar los datos en los arreglos
while ($row = mysqli_fetch_array($result)) {
    $fechaEmb = substr($row['fecha'], 0, 10);
    $peso = $row['peso_real'];
    // Verificar si la fecha ya existe en el arreglo
    $index = array_search($fechaEmb, $fechas);
    if ($index !== false) {
        // La fecha ya existe, sumar el peso correspondiente
        $pesos[$index] += $peso;
    } else {
        // La fecha no existe, agregar la fecha y el peso al arreglo
        $fechas[] = $fechaEmb;
        $pesos[] = $peso;
    }
}
// Convertir los arreglos a formato JSON
$fechas_json = json_encode($fechas);
$pesos_json = json_encode($pesos);
?>
<div class="container">
    <div class="row">
        <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">
                <!-- Card stats -->
                <div class="row g-6 mb-6">

                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-lg d-block mb-2">Peso Total</span>
                                    <div class="h3 font-bold mb-0" id="idsumaPesosSemana"></div>
                                </div>
                                <div class="col-auto ml-auto">
                                    <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"
                                        style="margin-bottom: 10px">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                </div>
                                <hr>
                                <div style="margin-top: 10px">
                                    <div class="form-group">
                                        <label for="dateFrom">Desde:</label>
                                        <input type="date" id="dateFrom" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="dateTo">Hasta:</label>
                                        <input type="date" id="dateTo" class="form-control">
                                    </div>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </main>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="chart-container">
                <canvas id="chart1"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Obtener referencia a los elementos de fecha
    const dateFromInput = document.getElementById('dateFrom');
    const dateToInput = document.getElementById('dateTo');

    // Obtener referencia al elemento del gráfico
    const chartElement = document.getElementById('chart1');
    const ctx = chartElement.getContext('2d');
    // Crear el objeto del gráfico
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Los labels se actualizarán posteriormente
            datasets: [{
                label: 'Peso (Kg)',
                data: [], // Los datos se actualizarán posteriormente
                backgroundColor: 'rgba(92, 97, 245, 0.3)',
                borderColor: 'rgba(92, 97, 245, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Peso (Kg)',
                        fontSize: 16
                    },
                    ticks: {
                        fontSize: 12
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fechas',
                        fontSize: 16
                    },
                    ticks: {
                        fontSize: 12
                    }
                }
            }
        }
    });
    // Obtener la fecha actual
    const currentDate = new Date();
    // Obtener el primer día de la semana actual (domingo)
    const firstDayOfWeek = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay()));
    // Obtener el último día de la semana actual (sábado)
    const lastDayOfWeek = new Date(currentDate.setDate(currentDate.getDate() + 6));
    // Filtrar los datos para mostrar solo los de la semana actual
    const weekDates = <?php echo $fechas_json ?>.filter(fecha => {
        const date = new Date(fecha);
        return date >= firstDayOfWeek && date <= lastDayOfWeek;
    });
    // Obtener los pesos correspondientes a las fechas de la semana actual
    const weekWeights = <?php echo $pesos_json ?>.filter((peso, index) => {
        const fecha = <?php echo $fechas_json ?>[index];
        const date = new Date(fecha);
        return date >= firstDayOfWeek && date <= lastDayOfWeek;
    });
    // Actualizar el gráfico con los datos de la semana actual
    chart.data.labels = weekDates;
    chart.data.datasets[0].data = weekWeights;
    chart.update();
    // Función para actualizar el gráfico según las fechas seleccionadas
    function updateChart() {
        // Obtener las fechas seleccionadas
        const dateFrom = dateFromInput.value;
        const dateTo = dateToInput.value;
        // Filtrar los datos según las fechas seleccionadas
        const filteredFechas = <?php echo $fechas_json ?>.filter(fecha => {
            const date = new Date(fecha);
            return date >= new Date(dateFrom) && date <= new Date(dateTo);
        });
        const filteredPesos = <?php echo $pesos_json ?>.filter((peso, index) => {
            const fecha = <?php echo $fechas_json ?>[index];
            const date = new Date(fecha);
            return date >= new Date(dateFrom) && date <= new Date(dateTo);
        });
        // Obtener la suma de pesos filtrados por semana
        const sumaPesosSemana = filteredPesos.reduce((total, peso) => total + parseFloat(peso), 0);
        // Mostrar la suma de pesos de la semana en un elemento HTML
        const sumaPesosSemanaElement = document.getElementById('idsumaPesosSemana');
        sumaPesosSemanaElement.innerHTML = '<span>' + sumaPesosSemana + ' kg</span>';
        // Actualizar el gráfico con los datos filtrados
        chart.data.labels = filteredFechas;
        chart.data.datasets[0].data = filteredPesos;
        chart.update();
    }
    // Agregar listeners a los inputs de fecha para actualizar el gráfico al cambiar las fechas seleccionadas
    dateFromInput.addEventListener('input', updateChart);
    dateToInput.addEventListener('input', updateChart);
</script>