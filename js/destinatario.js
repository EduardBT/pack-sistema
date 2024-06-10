function initializeForm() {
  var countrySelect = document.getElementById("country-select");
  var provinciaSelect = document.getElementById("provincia-select");
  var municipioSelect = document.getElementById("municipio-select");
  var provinciaInput = document.getElementById("provincia-input");
  var labelsCuba = document.getElementsByClassName("labelCuba");

  countrySelect.addEventListener("change", function () {
    var selectedCountry = countrySelect.value;
    if (selectedCountry == 6) {
      provinciaSelect.style.display = "block";
      provinciaInput.style.display = "none";
      cargarMunicipiosCuba();
    } else {
      provinciaSelect.style.display = "none";
      provinciaInput.style.display = "block";
      municipioSelect.style.display = "none";
      for (var i = 0; i < labelsCuba.length; i++) {
        labelsCuba[i].style.display = "none";
      }
    }
  });

  function cargarMunicipiosCuba() {
    fetch("json/provin_munip.json")
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        var provin_munip = data;
        var select = document.getElementById("provincia-select");
        select.innerHTML = "";
        var provinciasAgregadas = {};
        for (var i = 0; i < provin_munip.datos.length; i++) {
          var provincia = provin_munip.datos[i].Provincia;

          if (!provinciasAgregadas[provincia]) {
            var option = document.createElement("option");
            option.value = provincia;
            option.text = provincia;
            select.appendChild(option);

            provinciasAgregadas[provincia] = true;
          }
        }
      })
      .catch(function (error) {
        console.log("Error al cargar el archivo JSON:", error);
      });
  }

  function handleCountryChange() {
    var selectedCountry = countrySelect.value;
    if (selectedCountry == 6) {
      provinciaSelect.style.display = "block";
      provinciaInput.style.display = "none";
      cargarMunicipiosCuba();
    } else {
      provinciaSelect.style.display = "none";
      provinciaInput.style.display = "block";
      municipioSelect.style.display = "none";
      for (var i = 0; i < labelsCuba.length; i++) {
        labelsCuba[i].style.display = "none";
      }
    }
  }

  countrySelect.addEventListener("change", handleCountryChange);

  handleCountryChange();
}

function onDOMContentLoaded() {
  document.addEventListener("DOMContentLoaded", initializeForm);
}

onDOMContentLoaded();

function confirmarEliminacion(id) {
  if (confirm("¿Desea eliminar el registro?")) {
    window.location.href = "delete-destinatario.php?id=" + id;
  }
}

function openModal(
  dni,
  nombre,
  apellidos,
  tel,
  direccion,
  departamento,
  cod_postal,
  correo
) {
  var modalText = document.getElementById("modalText");
  modalText.innerHTML = `
   <div class="row"> 
       <div class="col-md-3" >
         <i class="bi bi-file-earmark-person" style="font-size:100px"></i>
       </div>
        <div class="col-md-9">
          <h1?><strong>Nombre y Apellidos: </strong>${nombre} ${apellidos}</h1><br>
          <h1?><strong>Teléfono: </strong>${tel}</h1><br>
          <h1?><strong>Dirección: </strong>${direccion}</h1><br>
          <h1?><strong>Departamento: </strong>${departamento}</h1><br>
          <h1?><strong>Código Postal: </strong>${cod_postal}</h1><br>
          <h1?><strong>Correo: </strong>${correo}</h1><br>
        </div>
   </div>`;
  $("#myModal").modal("show");
}

function closeModal() {
  $("#myModal").modal("hide");
}

function buscar() {
  $(document).ready(function () {
    $("#busqueda").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  });
}

function loadMunicipios() {
  fetch("json/provin_munip.json")
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      var datos = data.datos;
      if (Array.isArray(data)) {
        datos = data;
      } else if (Array.isArray(data.datos)) {
        datos = data.datos;
      } else {
        throw new Error("Formato de datos inválido");
      }
      var provinciaSelect = document.getElementById("provincia-select");

      var municipioSelect = document.getElementById("municipio-select");
      var labelsCuba = document.getElementsByClassName("labelCuba");
      municipioSelect.innerHTML = "";

      var provinciaSeleccionada = provinciaSelect.value;
      var municipios = datos.filter(
        (item) => item.Provincia === provinciaSeleccionada
      );

      var emptyOption = document.createElement("option");
      emptyOption.value = "";
      emptyOption.text = "";
      municipioSelect.appendChild(emptyOption);

      for (var i = 0; i < municipios.length; i++) {
        var municipio = municipios[i].Municipio;
        var option = document.createElement("option");
        option.value = municipio;
        option.text = municipio;
        municipioSelect.appendChild(option);
      }

      for (var i = 0; i < labelsCuba.length; i++) {
        labelsCuba[i].style.display = "block";
      }
      municipioSelect.style.display = "block";
    })
    .catch(function (error) {
      console.log("Error al cargar el archivo JSON:", error);
    });
}

function mostrarCodigoPostal() {
  fetch("json/provin_munip.json")
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      var datos = data.datos;
      var municipioSelect = document.getElementById("municipio-select");
      var codigoPostalInput = document.getElementById("cod_postal");

      var municipioSeleccionado = municipioSelect.value;
      var datosMunicipio = datos.find(
        (item) => item.Municipio === municipioSeleccionado
      );

      if (datosMunicipio) {
        codigoPostalInput.value = datosMunicipio["Código Postal"];
      } else {
        codigoPostalInput.value = "";
      }
    })
    .catch(function (error) {
      console.log("Error al cargar el archivo JSON:", error);
    });
}
