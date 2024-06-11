<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";
?>
<style>
  form#multiphase {
    border: #c7c7c7 1px solid;
    border-radius: 5px;
    padding: 24px;
    width: 100%;
  }

  form#multiphase>#phase2,
  #phase3,
  #show_all_data {
    display: none;
  }
</style>
<script>
  var remitente, destinatario, gender, country;
  function _(x) {
    return document.getElementById(x);
  }
  function procesoAtras0() {

    _("phase1").style.display = "block";
    _("phase2").style.display = "none";
    _("progressBar").aria - valuenow = 33;
    _("status").innerHTML = "Paso 1 of 3";
  }

  function procesoAtras1() {
    _("phase2").style.display = "block";
    _("phase3").style.display = "none";
    _("progressBar").aria - valuenow = 66;
    _("status").innerHTML = "Paso 2 of 3";
  }
  function procesoAtras2() {
    _("phase3").style.display = "block";
    _("show_all_data").style.display = "none";
    _("progressBar").aria - valuenow = 100;
    _("status").innerHTML = "Data Overview";
  }

  function processPhase1() {
    destinatario = _("destinatario").value;
    remitente = _("remitente").value;
    if (remitente.length > 2 && destinatario.length > 2) {
      _("phase1").style.display = "none";
      _("phase2").style.display = "block";
      _("progressBar").aria - valuenow = 33;
      _("status").innerHTML = "Paso 2 of 3";
    } else {
      alert("Por favor complete los campos");
    }
  }
  function processPhase2() {
    gender = _("gender").value;
    if (gender.length > 0) {
      _("phase2").style.display = "none";
      _("phase3").style.display = "block";
      _("progressBar").aria - valuenow = 66;
      _("status").innerHTML = "Paso 3 of 3";
    } else {
      alert("Por favor elija un genero");
    }
  }
  function processPhase3() {
    country = _("country").value;
    if (country.length > 0) {
      _("phase3").style.display = "none";
      _("show_all_data").style.display = "block";
      _("display_destinatario").innerHTML = destinatario;
      _("display_remitente").innerHTML = remitente;
      _("display_gender").innerHTML = gender;
      _("display_country").innerHTML = country;
      _("progressBar").aria - valuenow = 100;
      _("status").innerHTML = "Resumen de Datos";
    } else {
      alert("Por favor elija su País");
    }
  }
  function submitForm() {
    _("multiphase").method = "post";
    _("multiphase").action = "guardar-guia.php";
    _("multiphase").submit();
  }
</script>
<br>
<h2>Envío</h2>
<br>
<div class="container">
  <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <progress id="progressBar" value="0" max="100" style="width: 250px"></progress>
  <h3 id="status">Paso 1 de 3</h3>
  <form class="form-horizontal" id="multiphase" onsubmit="return false">
    <div class="row">
      <div id="phase1">
        <div class="col-md-4">
          <h4>Seleccione un Destinatario</h4>
          <br>
          <select id="destinatario" name="destinatario" class="form-select" aria-label="Default select example">
            <option value="">Seleccione:</option>
            <?php
            $query = "SELECT * FROM personas";
            $result = mysqli_query($conexion, $query);
            while ($row = mysqli_fetch_array($result)) {
              echo '<option value="' . $row[id_persona] . '">' . $row[nombre] . ' ' . $row[apellidos] . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="col-md-8">
          <h4>Seleccione un Remitente</h4>
          <br>
          <select id="remitente" name="remitente" class="form-select" aria-label="Default select example">
            <option value="0">Seleccione:</option>
            <?php

            $query = "SELECT * FROM personas";
            $result = mysqli_query($conexion, $query);
            while ($row = mysqli_fetch_array($result)) {
              echo '<option value="' . $row[id_persona] . '">' . $row[nombre] . ' ' . $row[apellidos] . '</option>';
            }
            ?>
          </select>
          <button class="btn btn-dark boton-secundario" onclick="processPhase1()">Siguiente</button>
        </div>
      </div>
    </div>
    <div id="phase2">
      Gender:
      <select id="gender" name="gender">
        <option value=""></option>
        <option value="m">Male</option>
        <option value="f">Female</option>
      </select>
      <br />
      <button onclick="procesoAtras0()">Anterior</button>
      <button onclick="processPhase2()">Siguiente</button>
    </div>

    <div id="phase3">
      Country:
      <select id="country" name="country">
        <option value="United States">United States</option>
        <option value="India">India</option>
        <option value="United Kingdom">United Kingdom</option>
      </select><br />
      <button onclick="procesoAtras1()">Anterior</button>
      <button onclick="processPhase3()">Siguiente</button>
    </div>

    <div id="show_all_data">
      First Name: <span id="display_fname"></span> <br />
      Last Name: <span id="display_lname"></span> <br />
      Gender: <span id="display_gender"></span> <br />
      Country: <span id="display_country"></span> <br />
      <button onclick="procesoAtras2()">Anterior</button>
      <button onclick="submitForm()">Enviar</button>
    </div>
  </form>
</div>