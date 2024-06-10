var fname, lname, gender, country;

function _(x) {
  return document.getElementById(x);
}

function procesoAtras0() {
  _("phase1").style.display = "block";
  _("phase2").style.display = "none";
  _("status").innerHTML = "Paso 1 de 3 Remitente";
}

function procesoAtras1() {
  _("phase2").style.display = "block";
  _("phase3").style.display = "none";
  _("status").innerHTML = "Paso 2 de 3  Destinatario";
}

function procesoAtras2() {
  _("phase3").style.display = "block";
  _("show_all_data").style.display = "none";
  _("status").innerHTML = "Paso 3 de 3 Datos del Embarque";
}

function datosremitente() {
  /*Datos remitente */
  remitente = _("remitente").value;
}

function processPhase1() {
  /*Datos remitente */
  remitente = _("remitente").value;
  if (remitente.length > 0) {
    _("phase1").style.display = "none";
    _("phase2").style.display = "block";
  } else {
    alert("Por favor complete los campos");
  }
}

function processPhase2() {
  /* Datos destinatario */
  destinatario = _("destinatario").value;
  if (destinatario.length > 0) {
    _("phase2").style.display = "none";
    _("phase3").style.display = "block";
  } else {
    alert("Por favor elija un destinatario");
  }
}

function processPhase3() {
  var empaquetadoInputs = document.getElementsByName("empaquetado");
  var electronicoInputs = document.getElementsByName("electronico");
  var empaquetadoValue;
  var electronicoValue;

  for (var i = 0; i < electronicoInputs.length; i++) {
    if (electronicoInputs[i].checked) {
      electronicoValue = electronicoInputs[i].value;
      break;
    }
  }
  for (var i = 0; i < empaquetadoInputs.length; i++) {
    if (empaquetadoInputs[i].checked) {
      empaquetadoValue = empaquetadoInputs[i].value;
      break;
    }
  }

  var num_bulto = _("num_bulto").value;
  var numero = _("numero").value;
  var cod_origen = _("cod_origen").value;
  var cod_destino = _("cod_destino").value;
  var fecha = _("fecha").value;
  var valor = _("valor").value;
  var peso_real = _("peso_real").value;
  var tipo_bulto = _("tipo_bulto").value;
  var descripcion = _("descripcion").value;
  var peso_volumetrico = _("spTotal").value;
  var incotem = "DDP";
  //var incotem = _("incotem").value;
  var remitente = _("remitente").value;
  var destinatario = _("destinatario").value;

  var formData = new FormData();
  formData.append("num_bulto", num_bulto);
  formData.append("numero", numero);
  formData.append("cod_origen", cod_origen);
  formData.append("cod_destino", cod_destino);
  formData.append("fecha", fecha);
  formData.append("valor", valor);
  formData.append("peso_real", peso_real);
  formData.append("tipo_bulto", tipo_bulto);
  formData.append("descripcion", descripcion);
  formData.append("empaquetado", empaquetadoValue);
  formData.append("peso_volumetrico", peso_volumetrico);
  formData.append("incotem", incotem);
  formData.append("electronico", electronicoValue);
  formData.append("remitente", remitente);
  formData.append("destinatario", destinatario);

  fetch("guardar-guia.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      if (response.ok) {
        // Respuesta del servidor (opcional)
        return response.text();
      } else {
        throw new Error("Error en la solicitud.");
      }
    })
    .then(function (responseText) {
      console.log(responseText);
    })
    .catch(function (error) {
      console.log(error);
    });

  // Redirigir a guia.php
  window.location.href = "guia.php";
}

function submitForm() {
  "multi-step-form".method = "post";
  _("multi-step-form").action = "guardar-guia.php"; /*"my_parser.php";*/
  _("multi-step-form").submit();
}

function processCalcular() {
  /* Datos destinatario */
  num_bulto = _("num_bulto").value;
  if (num_bulto.length > 0) {
    $("#myModal").modal("show");
  } else {
    alert("Por favor ingrese el número de bultos");
  }
}

function Cerrar() {
  $("#myModal").modal("hide");
}

/* uso del modal */

//modal funcion abrir y cerrar
$("button1").click(function () {
  $("#myModal").modal("show");
});

$(".cerrarModal").click(function () {
  $("#myModal").modal("hide");
});

//modal funcion calculadora
function calcular() {
  var alto = document.querySelectorAll(".alto");
  var ancho = document.querySelectorAll(".ancho");
  var largo = document.querySelectorAll(".largo");
  var volumen = document.querySelectorAll(".volumen");
  var total = 0;

  for (var i = 0; i < alto.length; i++) {
    if (alto[i].value && ancho[i].value && largo[i].value) {
      volumen[i].value =
        (alto[i].value * ancho[i].value * largo[i].value) / 5000;
      total += parseFloat(volumen[i].value);
    }
  }

  $("#spTotal").val(total);
}

//Funcion popover guia
$(document).ready(function () {
  $('[data-toggle="popover"]').popover();
});

/* fin uso del modal */

//funcion calculo declaracion jurada
function cantidad() {
  var cantidad = document.querySelectorAll(".cantidad");
  var precio = document.querySelectorAll(".precio");
  var total = document.querySelectorAll(".total");
  var cantTotal = 0;

  console.log(cantidad[0].value);
  console.log(precio[0].value);
  console.log(total[0].value);
  for (var i = 0; i < cantidad.length; i++) {
    var cant = cantidad[i].value ? parseFloat(cantidad[i].value) : 0;
    var prec = precio[i].value ? parseFloat(precio[i].value) : 0;

    total[i].value = (cant * prec).toFixed(2);
    cantTotal += parseFloat(total[i].value);
  }

  document.getElementById("resultado").innerText = cantTotal.toFixed(2);
  document.getElementById("totalDeclarado").value = cantTotal.toFixed(2);
}

//funcion añadir y eliminar input
$(document).ready(function () {
  var maxField = 10; //Input fields increment limitation
  var addButton = $(".add_button"); //Add button selector
  var wrapper = $(".field_wrapper"); //Input field wrapper
  var fieldHTML =
    '<div><input type="text" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Eliminar campos"><i class="bi bi-dash-circle-fill"></i></a></div>'; //New input field html
  var x = 1; //Initial field counter is 1
  $(addButton).click(function () {
    //Once add button is clicked
    if (x < maxField) {
      //Check maximum number of input fields
      x++; //Increment field counter
      $(wrapper).append(fieldHTML); // Add field html
    }
  });
  $(wrapper).on("click", ".remove_button", function (e) {
    //Once remove button is clicked
    e.preventDefault();
    $(this).parent("div").remove(); //Remove field html
    x--; //Decrement field counter
  });
});

function imprimir(imp1) {
  // función para iprimir solo un cóntenido dentro de una pag (en este caso pra la factura))

  var printContents = document.getElementById("imp1").innerHTML;
  w = window.open();
  w.document.write(printContents);
  w.document.close(); // necessary for IE >= 10
  w.focus(); // necessary for IE >= 10
  w.print();
  w.close();
  return true;
}
