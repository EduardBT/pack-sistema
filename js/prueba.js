$(document).ready(function () {
  $("#remitente").on("change", function () {
    var valorSelect = $(this).val(); //obtenemos el valor seleccionado en una variable

    $.ajax({
      url: "callback.php",
      type: "POST",
      data: { valorSelect: valorSelect }, //enviamos lo seleccionado

      success: function (respuesta) {
        $("#loconseguido").html(respuesta); //en el div con el id respuestas mostramos los resultados del callback
      },
    });
  });
});
