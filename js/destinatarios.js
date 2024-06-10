$(document).ready(function () {
  $("#destinatario").on("change", function () {
    var valorSelect = $(this).val(); //obtenemos el valor seleccionado en una variable

    $.ajax({
      url: "callbackDest.php",
      type: "POST",
      data: { valorSelect: valorSelect }, //enviamos lo seleccionado

      success: function (respuesta) {
        $("#loconseguidoDest").html(respuesta); //en el div con el id respuestas mostramos los resultados del callback
      },
    });
  });
});
