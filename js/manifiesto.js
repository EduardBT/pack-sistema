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

function compararProvincias(provincia1, provincia2) {
  // Función auxiliar para eliminar las tildes
  function eliminarTildes(texto) {
    return texto
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "");
  }

  provincia1 = eliminarTildes(provincia1);
  provincia2 = eliminarTildes(provincia2);

  return provincia1 === provincia2 || provincia1 === provincia2.toLowerCase();
}

function obtenerFechaDeNacimiento(numero) {
  var anio = parseInt(numero.toString().substring(0, 2));
  var mes = parseInt(numero.toString().substring(2, 4));
  var dia = parseInt(numero.toString().substring(4, 6));

  // Obtener el año actual
  var anioActual = new Date().getFullYear();

  // Determinar el siglo de nacimiento
  var siglo = anio <= 40 ? 20 : 19;

  // Ajustar el año de nacimiento
  var anioNacimiento = siglo * 100 + anio;

  // Crear objeto de fecha con la fecha de nacimiento
  var fechaNacimiento = new Date(anioNacimiento, mes - 1, dia);

  // Obtener los componentes de la fecha
  var yy = fechaNacimiento.getFullYear().toString();
  var mm = ("0" + (fechaNacimiento.getMonth() + 1)).slice(-2);
  var dd = ("0" + fechaNacimiento.getDate()).slice(-2);

  // Construir la fecha en formato YY-MM-DD
  var fechaFormateada = yy + "-" + mm + "-" + dd;

  return fechaFormateada;
}

function crearXML(id) {
  $.ajax({
    url: "reportes/generarExcel.php?id=" + id,
    type: "GET",
    success: function (response) {
      // Asigna los datos recibidos a la variable
      var datosManifiesto = response;

      // Crear un documento XML
      var xmlDoc = document.implementation.createDocument(
        null,
        "ManifiestoPostal"
      );

      // Crear la declaración XML
      var xmlDeclaration = xmlDoc.createProcessingInstruction(
        "xml",
        'version="1.0" encoding="utf-8"'
      );

      // Agregar la declaración XML como el primer nodo del documento
      xmlDoc.insertBefore(xmlDeclaration, xmlDoc.firstChild);

      // Obtener el elemento raíz
      var manifiestoPostal = xmlDoc.documentElement;

      // Agregar los atributos al elemento raíz
      manifiestoPostal.setAttribute(
        "xmlns:eAduana",
        "https://www.aduana.co.cu/XMLSchema"
      );
      manifiestoPostal.setAttribute(
        "xmlns:xsi",
        "http://www.w3.org/2001/XMLSchema-instance"
      );
      manifiestoPostal.setAttribute(
        "xsi:schemaLocation",
        "https://www.aduana.co.cu/XMLSchema manifiestoPostal.xsd"
      );

      const datos_provincia = [
        { provincia: "PINAR DEL RIO", codigoProvincia: 21 },
        { provincia: "PINAR DEL RÍO", codigoProvincia: 21 },
        { provincia: "LA HABANA", codigoProvincia: 23 },
        { provincia: "MAYABEQUE", codigoProvincia: 24 },
        { provincia: "MATANZAS", codigoProvincia: 25 },
        { provincia: "CIENFUEGOS", codigoProvincia: 27 },
        { provincia: "VILLA CLARA", codigoProvincia: 26 },
        { provincia: "SANCTI SPIRITUS", codigoProvincia: 28 },
        { provincia: "SANCTI SPÍRITUS", codigoProvincia: 28 },
        { provincia: "CIEGO DE AVILA", codigoProvincia: 29 },
        { provincia: "CIEGO DE ÁVILA", codigoProvincia: 29 },
        { provincia: "CAMAGUEY", codigoProvincia: 30 },
        { provincia: "CAMAGÜEY", codigoProvincia: 30 },
        { provincia: "LAS TUNAS", codigoProvincia: 31 },
        { provincia: "HOLGUIN", codigoProvincia: 32 },
        { provincia: "HOLGUÍN", codigoProvincia: 32 },
        { provincia: "GRANMA", codigoProvincia: 33 },
        { provincia: "SANTIAGO DE CUBA", codigoProvincia: 34 },
        { provincia: "GUANTANAMO", codigoProvincia: 35 },
        { provincia: "GUANTÁNAMO", codigoProvincia: 35 },
        { provincia: "ISLA DE LA JUVENTUD", codigoProvincia: 40 },
        { provincia: "ARTEMISA", codigoProvincia: 22 },
      ];

      const datosMunicipios = [
        { municipio: "Sibanicú", codigoMunicipio: "07" },
        { municipio: "Florida", codigoMunicipio: "09" },
        { municipio: "Minas", codigoMunicipio: "04" },
        { municipio: "Carlos Manuel de Céspedes", codigoMunicipio: "01" },
        { municipio: "Esmeralda", codigoMunicipio: "02" },
        { municipio: "Nuevitas", codigoMunicipio: "05" },
        { municipio: "Guáimaro", codigoMunicipio: "06" },
        { municipio: "Vertientes", codigoMunicipio: "10" },
        { municipio: "Sola", codigoMunicipio: "03" },
        { municipio: "Santa Cruz del Sur", codigoMunicipio: "13" },
        { municipio: "Jimaguayú", codigoMunicipio: "11" },
        { municipio: "Cuatro Caminos", codigoMunicipio: "12" },
        { municipio: "Ciudad Sandino", codigoMunicipio: "01" },
        { municipio: "Mantua", codigoMunicipio: "02" },
        { municipio: "Minas de Matahambre", codigoMunicipio: "03" },
        { municipio: "Viñales", codigoMunicipio: "04" },
        {
          municipio: "Consolación del Norte (La Palma)",
          codigoMunicipio: "05",
        },
        { municipio: "Bahía Honda", codigoMunicipio: "01" },
        { municipio: "Candelaria", codigoMunicipio: "10" },
        { municipio: "San Cristóbal", codigoMunicipio: "11" },
        { municipio: "Los Palacios", codigoMunicipio: "06" },
        { municipio: "Consolación del Sur", codigoMunicipio: "07" },
        { municipio: "San Juan y Martínez", codigoMunicipio: "10" },
        { municipio: "Guane", codigoMunicipio: "11" },
        { municipio: "San Luis", codigoMunicipio: "09" },
        { municipio: "San José de las Lajas", codigoMunicipio: "02" },
        { municipio: "Güines", codigoMunicipio: "08" },
        { municipio: "Melena del Sur", codigoMunicipio: "09" },
        { municipio: "Batabanó", codigoMunicipio: "10" },
        { municipio: "Santa Cruz del Norte", codigoMunicipio: "04" },
        { municipio: "Madruga", codigoMunicipio: "05" },
        { municipio: "Nueva Paz", codigoMunicipio: "06" },
        { municipio: "San Nicolás", codigoMunicipio: "07" },
        { municipio: "Bauta", codigoMunicipio: "05" },
        { municipio: "Caimito", codigoMunicipio: "04" },
        { municipio: "Mariel", codigoMunicipio: "02" },
        { municipio: "Artemisa", codigoMunicipio: "09" },
        { municipio: "San Antonio de los Baños", codigoMunicipio: "06" },
        { municipio: "Güira de Melena", codigoMunicipio: "07" },
        { municipio: "Quivicán", codigoMunicipio: "11" },
        { municipio: "Alquízar", codigoMunicipio: "08" },
        { municipio: "Bejucal", codigoMunicipio: "01" },
        { municipio: "Guanajay", codigoMunicipio: "03" },
        { municipio: "Jaruco", codigoMunicipio: "03" },
        { municipio: "Cardenas", codigoMunicipio: "02" },
        { municipio: "Varadero", codigoMunicipio: "03" },
        { municipio: "Marti", codigoMunicipio: "03" },
        { municipio: "Colón", codigoMunicipio: "04" },
        { municipio: "Perico", codigoMunicipio: "05" },
        { municipio: "Jovellanos", codigoMunicipio: "06" },
        { municipio: "Pedro Betancourt", codigoMunicipio: "07" },
        { municipio: "Limonar", codigoMunicipio: "08" },
        { municipio: "Unión de Reyes", codigoMunicipio: "09" },
        { municipio: "Ciénaga de Zapata", codigoMunicipio: "10" },
        { municipio: "Calimete", codigoMunicipio: "12" },
        { municipio: "Los Arabos", codigoMunicipio: "13" },
        { municipio: "Jagüey Grande", codigoMunicipio: "11" },
        { municipio: "Aguada de Pasajeros", codigoMunicipio: "01" },
        { municipio: "Rodas", codigoMunicipio: "02" },
        { municipio: "Abreus", codigoMunicipio: "08" },
        { municipio: "Santa Isabel de las Lajas", codigoMunicipio: "04" },
        { municipio: "Lajas", codigoMunicipio: "04" },
        { municipio: "Cruces", codigoMunicipio: "05" },
        { municipio: "Palmira", codigoMunicipio: "03" },
        { municipio: "Cumanayagua", codigoMunicipio: "06" },
        { municipio: "Jatibonico", codigoMunicipio: "02" },
        { municipio: "Cabaiguán", codigoMunicipio: "04" },
        { municipio: "Trinidad", codigoMunicipio: "06" },
        { municipio: "Taguasco", codigoMunicipio: "03" },
        { municipio: "La Sierpe", codigoMunicipio: "08" },
        { municipio: "Fomento", codigoMunicipio: "05" },
        { municipio: "Yaguajay", codigoMunicipio: "01" },
        { municipio: "Caibarién", codigoMunicipio: "06" },
        { municipio: "Camajuaní", codigoMunicipio: "05" },
        { municipio: "Cifuentes", codigoMunicipio: "10" },
        { municipio: "Corralillo", codigoMunicipio: "01" },
        { municipio: "Encrucijada", codigoMunicipio: "04" },
        { municipio: "Manicaragua", codigoMunicipio: "13" },
        { municipio: "Placetas", codigoMunicipio: "08" },
        { municipio: "Quemado de Güines", codigoMunicipio: "02" },
        { municipio: "Ranchuelo", codigoMunicipio: "12" },
        { municipio: "Remedios", codigoMunicipio: "07" },
        { municipio: "Sagua la Grande", codigoMunicipio: "03" },
        { municipio: "Santo Domingo", codigoMunicipio: "11" },
        { municipio: "Cayo Mambi (C. Frank País)", codigoMunicipio: "12" },
        { municipio: "Gibara", codigoMunicipio: "01" },
        { municipio: "Rafael Freyre (Santa Lucía)", codigoMunicipio: "02" },
        { municipio: "Banes", codigoMunicipio: "03" },
        { municipio: "Baguanos", codigoMunicipio: "05" },
        { municipio: "Buenaventura", codigoMunicipio: "07" },
        { municipio: "Cacocum", codigoMunicipio: "08" },
        { municipio: "Cueto", codigoMunicipio: "10" },
        { municipio: "Urbano Noris", codigoMunicipio: "09" },
        { municipio: "Mayarí", codigoMunicipio: "11" },
        { municipio: "Sagua de Tánamo", codigoMunicipio: "13" },
        { municipio: "Moa", codigoMunicipio: "14" },
        { municipio: "Antilla", codigoMunicipio: "04" },
        { municipio: "Maisí", codigoMunicipio: "05" },
        { municipio: "El Salvador", codigoMunicipio: "01" },
        { municipio: "Baracoa", codigoMunicipio: "04" },
        { municipio: "Yateras", codigoMunicipio: "03" },
        { municipio: "Caimanera", codigoMunicipio: "08" },
        { municipio: "Niceto Pérez", codigoMunicipio: "10" },
        { municipio: "Manuel Tames", codigoMunicipio: "02" },
        { municipio: "San Antonio del Sur", codigoMunicipio: "07" },
        { municipio: "Imías", codigoMunicipio: "06" },
        { municipio: "Bayamo", codigoMunicipio: "04" },
        { municipio: "Río Cauto", codigoMunicipio: "01" },
        { municipio: "Cauto Cristo", codigoMunicipio: "02" },
        { municipio: "Jiguaní", codigoMunicipio: "03" },
        { municipio: "Yara", codigoMunicipio: "05" },
        { municipio: "Manzanillo", codigoMunicipio: "06" },
        { municipio: "Campechuela", codigoMunicipio: "07" },
        { municipio: "Media Luna", codigoMunicipio: "08" },
        { municipio: "Niquero", codigoMunicipio: "09" },
        { municipio: "Pilón", codigoMunicipio: "10" },
        { municipio: "Bartolomé Masó", codigoMunicipio: "11" },
        { municipio: "Buey Arriba", codigoMunicipio: "12" },
        { municipio: "Guisa", codigoMunicipio: "13" },
        { municipio: "Palma Soriano", codigoMunicipio: "07" },
        { municipio: "Contramaestre", codigoMunicipio: "01" },
        { municipio: "La Maya", codigoMunicipio: "05" },
        { municipio: "Songo la Maya", codigoMunicipio: "05" },
        { municipio: "San Luis", codigoMunicipio: "03" },
        { municipio: "II Frente", codigoMunicipio: "04" },
        { municipio: "Guamá", codigoMunicipio: "09" },
        { municipio: "III Frente", codigoMunicipio: "08" },
        { municipio: "Miranda (C. Julio A. Mella)", codigoMunicipio: "02" },
        { municipio: "Manatí", codigoMunicipio: "01" },
        { municipio: "Puerto Padre", codigoMunicipio: "02" },
        { municipio: "Jobabo", codigoMunicipio: "06" },
        { municipio: "Colombia", codigoMunicipio: "07" },
        { municipio: "Majibacoa", codigoMunicipio: "04" },
        { municipio: "Chambas", codigoMunicipio: "01" },
        { municipio: "1ro de Enero", codigoMunicipio: "04" },
         { municipio: "Primero de Enero", codigoMunicipio: "04" },
        { municipio: "Central Bolivia", codigoMunicipio: "03" },
        { municipio: "Florencia", codigoMunicipio: "06" },
        { municipio: "Majagua", codigoMunicipio: "07" },
        { municipio: "Venezuela", codigoMunicipio: "09" },
        { municipio: "Baraguá", codigoMunicipio: "10" },
        { municipio: "Morón", codigoMunicipio: "02" },
        { municipio: "Ciro Redondo", codigoMunicipio: "05" },
        { municipio: "Cerro", codigoMunicipio: "10" },
        { municipio: "Centro Habana", codigoMunicipio: "03" },
        { municipio: "Habana Vieja", codigoMunicipio: "04" },
        { municipio: "La Habana Vieja", codigoMunicipio: "04" },
        { municipio: "Plaza de la Revolución", codigoMunicipio: "02" },
        { municipio: "10 de Octubre", codigoMunicipio: "09" },
        { municipio: "Habana del Este", codigoMunicipio: "06" },
        { municipio: "La Habana del Este", codigoMunicipio: "06" },
        { municipio: "San Miguel del Padrón", codigoMunicipio: "08" },
        { municipio: "Guanabacoa", codigoMunicipio: "07" },
        { municipio: "Regla", codigoMunicipio: "05" },
        { municipio: "Cotorro", codigoMunicipio: "15" },
        { municipio: "Boyeros", codigoMunicipio: "13" },
        { municipio: "La Lisa", codigoMunicipio: "12" },
        { municipio: "Arroyo Naranjo", codigoMunicipio: "14" },
        { municipio: "Playa", codigoMunicipio: "01" },
        { municipio: "Marianao", codigoMunicipio: "11" },
        { municipio: "Santa Clara", codigoMunicipio: "09" },
        { municipio: "Pinar del Río", codigoMunicipio: "08" },
        { municipio: "Matanzas", codigoMunicipio: "01" },
        { municipio: "Cienfuegos", codigoMunicipio: "07" },
        { municipio: "Sancti Spíritus", codigoMunicipio: "07" },
        { municipio: "Ciego de Ávila", codigoMunicipio: "08" },
        { municipio: "Camagüey", codigoMunicipio: "08" },
        { municipio: "Las Tunas", codigoMunicipio: "05" },
        { municipio: "Holguín", codigoMunicipio: "06" },
        { municipio: "Calixto García", codigoMunicipio: "07" },
        { municipio: "Santiago de Cuba", codigoMunicipio: "06" },
        { municipio: "Guantánamo", codigoMunicipio: "09" },
        { municipio: "Isla de la Juventud", codigoMunicipio: "01" },
        { municipio: "Isla de la Juventud 1", codigoMunicipio: "01" },
        { municipio: "Jesús Menéndez", codigoMunicipio: "03" },
        { municipio: "Amancio", codigoMunicipio: "08" },
      ];

      // Crear elementos personalizados
      var datosXml = xmlDoc.createElement("datosXml");
      var envios = xmlDoc.createElement("envios");
      var xmlEstructura = xmlDoc.createElement("xmlEstructura");
      var xmlVersion = xmlDoc.createElement("xmlVersion");
      var xmlNombre = xmlDoc.createElement("xmlNombre");
      var xmlTipo = xmlDoc.createElement("xmlTipo");
      var xmlFecha = xmlDoc.createElement("xmlFecha");
      var xmlDescripcion = xmlDoc.createElement("xmlDescripcion");
      var operador = xmlDoc.createElement("operador");
      var codigoAduana = xmlDoc.createElement("codigoAduana");
      var agenciaOrigen = xmlDoc.createElement("agenciaOrigen");
      var noGA = xmlDoc.createElement("noGA");
      var noVuelo = xmlDoc.createElement("noVuelo");
      var fechaArribo = xmlDoc.createElement("fechaArribo");
      var operacion = xmlDoc.createElement("operacion");
      var cantidadBultos = xmlDoc.createElement("cantidadBultos");

      // Establecer el contenido de los elementos
      xmlEstructura.textContent = "Manifiesto Postal";
      xmlVersion.textContent = "1.0";

      var fechaActual =datosManifiesto[0].fecha_emb;
      var fechaParts = fechaActual.split("-"); // Divide la cadena en partes separadas por "-"
      var anio = fechaParts[0];
      var mes = fechaParts[1];
      var dia = fechaParts[2];
      var fechaFormateada = anio + mes + dia;
      xmlNombre.textContent =
        "Manifiesto" +
        fechaFormateada +
        datosManifiesto[0].numero_externo.slice(-4) +
        "PK" +
        ".xml";
      console.log(datosManifiesto[0].numero_externo);

      xmlTipo.textContent = "MAN_POS";
      xmlFecha.textContent = datosManifiesto[0].fecha;
      xmlDescripcion.textContent =
        "INFORMACION ADELANTADA MANIFIESTO DE ENVIO POSTAL ORIGINAL";
      operador.textContent = "01001862514";
      agenciaOrigen.textContent = "PK";
      noGA.textContent = datosManifiesto[0].numero_externo;
      noVuelo.textContent = datosManifiesto[0].vuelo;
      fechaArribo.textContent = datosManifiesto[0].fechaArribo;
      console.log(datosManifiesto[0].fechaArribo);
      operacion.textContent = "I";
      let cantidadB = 0;

      for (let i = 0; i < datosManifiesto.length; i++) {
        cantidadB += parseInt(datosManifiesto[i].cantidad_bulto);
        const length = 9;
        const secoundrow = "CM";
        const segoundrow = "PK";
        const id_guia = datosManifiesto[i].id_guia;
        const string = ("0".repeat(length) + id_guia).slice(-length);
        const codigo_guia = secoundrow + string + segoundrow;

        // Datos Destinatario
        var numero_ci = datosManifiesto[i].dni_dest;
        var fechaDeNacimiento_Dest = obtenerFechaDeNacimiento(numero_ci);
        var nombre_dest = datosManifiesto[i].nombre_dest;
        var nomb_dest = nombre_dest.split(" ");
        var apellidos_dest = datosManifiesto[i].apellidos_dest;
        var apell_dest = apellidos_dest.split(" ");

        //Datos Remitente
        var nombre_Env = datosManifiesto[i].nombre_Env;
        var nomb_Env = nombre_Env.split(" ");
        var apellidos_Env = datosManifiesto[i].apellidos_Env;
        var apell_Env = apellidos_Env.split(" ");

        //Direccion
        const direccion = datosManifiesto[i].direccion_dest;
        const partes = direccion.split(".");
        const variables = {};

        partes.forEach((parte) => {
          parte = parte.trim();
          const [variable, valor] = parte.split(":");

          if (variable && valor) {
            variables[variable.trim()] = valor.trim();
          }
        });
        const calle_dest = variables["Calle"] || " ";
        const entre = variables["Entre"] || " ";
        const entre_split = entre.split("y") || " ";
        const ent_1 = entre_split[0];
        const ent_2 = entre_split[1];
        const edificio = variables["Edificio"] || " ";
        const num_casa = variables["No"] || " ";
        const apartamento = variables["Apartamento"] || " ";

        var envio = xmlDoc.createElement("envio");
        var noEnvio = xmlDoc.createElement("noEnvio");
        var peso = xmlDoc.createElement("peso");
        var peso = xmlDoc.createElement("peso");
        var paisOrigenDestino = xmlDoc.createElement("paisOrigen-Destino");
        var descripcion = xmlDoc.createElement("descripcion");
        var fechaImposicion = xmlDoc.createElement("fechaImposicion");
        var ArancelesPagados = xmlDoc.createElement("ArancelesPagados");
        var EntregaDomicilio = xmlDoc.createElement("EntregaDomicilio");

        var destinatario = xmlDoc.createElement("destinatario");
        var contacto = xmlDoc.createElement("contacto");
        var contactosTelefonos = xmlDoc.createElement("contactosTelefonos");
        var telefono = xmlDoc.createElement("telefono");
        var noTelefono = xmlDoc.createElement("noTelefono");

        var contactosDomicilios = xmlDoc.createElement("contactosDomicilios");
        var domicilio = xmlDoc.createElement("domicilio");
        var calle = xmlDoc.createElement("calle");
        var entreCalle = xmlDoc.createElement("entreCalle");
        var yCalle = xmlDoc.createElement("yCalle");
        var no = xmlDoc.createElement("no");
        var piso = xmlDoc.createElement("piso");
        var apto = xmlDoc.createElement("apto");
        var provincia = xmlDoc.createElement("provincia");
        var codigoProvincia = xmlDoc.createElement("codigoProvincia");
        var codigoMunicipio = xmlDoc.createElement("codigoMunicipio");

        var remitente = xmlDoc.createElement("remitente");
        var persona = xmlDoc.createElement("persona");
        var personaR = xmlDoc.createElement("persona");
        var primerNombre = xmlDoc.createElement("primerNombre");
        var segundoNombre = xmlDoc.createElement("segundoNombre");
        var primerApellido = xmlDoc.createElement("primerApellido");
        var segundoApellido = xmlDoc.createElement("segundoApellido");
        var primerNombre_Env = xmlDoc.createElement("primerNombre");
        var segundoNombre_Env = xmlDoc.createElement("segundoNombre");
        var primerApellido_Env = xmlDoc.createElement("primerApellido");
        var segundoApellido_Env = xmlDoc.createElement("segundoApellido");
        var id = xmlDoc.createElement("id");
        var nacionalidad = xmlDoc.createElement("nacionalidad");
        var nacionalidadD = xmlDoc.createElement("nacionalidad");
        var fechaNacimiento = xmlDoc.createElement("fechaNacimiento");
        var fechaNacimiento_Env = xmlDoc.createElement("fechaNacimiento");

        noEnvio.textContent = codigo_guia;
        codigoAduana.textContent = "0302";
        peso.textContent = datosManifiesto[i].peso_real;
        paisOrigenDestino.textContent ="URY";
        peso.textContent = datosManifiesto[i].peso_real;
        descripcion.textContent = datosManifiesto[i].descripcion;
        fechaImposicion.textContent = datosManifiesto[i].fecha_emb;
        ArancelesPagados.textContent = "N";
        EntregaDomicilio.textContent = "N";
        // Destinatario
        primerNombre.textContent = nomb_dest[0];
        segundoNombre.textContent = nomb_dest[1] || " ";
        primerApellido.textContent = apell_dest[0];
        segundoApellido.textContent = apell_dest[1];
        id.textContent = datosManifiesto[i].dni_dest;
        nacionalidad.textContent = "CUB";
        nacionalidadD.textContent = "CUB";
        fechaNacimiento.textContent = fechaDeNacimiento_Dest;
        noTelefono.textContent = datosManifiesto[i].tel_dest;
        // Remitente
        primerNombre_Env.textContent = nomb_Env[0];
        segundoNombre_Env.textContent = nomb_Env[1] || " ";
        primerApellido_Env.textContent = apell_Env[0];
        segundoApellido_Env.textContent = apell_Env[1];
        fechaNacimiento_Env.textContent =
          datosManifiesto[i].fecha_nacimiento_Env;
        // Domicilio
        for (var j = 0; j < datos_provincia.length; j++) {
          if (
            compararProvincias(
              datos_provincia[j].provincia,
              datosManifiesto[i].provincia_dest
            )
          ) {
            codigoProvincia.textContent = datos_provincia[j].codigoProvincia;
            break;
          }
        }

        for (var k = 0; k < datosMunicipios.length; k++) {
          if (
            compararProvincias(
              datosMunicipios[k].municipio,
              datosManifiesto[i].departamento_dest
            )
          ) {
            codigoMunicipio.textContent = datosMunicipios[k].codigoMunicipio;
            break;
          }
        }

        apto.textContent = apartamento;
        piso.textContent = " ";
        no.textContent = num_casa;
        calle.textContent = calle_dest;
        entreCalle.textContent = ent_1;
        yCalle.textContent = ent_2;

        persona.appendChild(primerNombre);
        persona.appendChild(segundoNombre);
        persona.appendChild(primerApellido);
        persona.appendChild(segundoApellido);
        persona.appendChild(id);

        //noTelefono.appendChild(noTelefono)
        telefono.appendChild(noTelefono);
        contactosTelefonos.appendChild(telefono);
        contacto.appendChild(contactosTelefonos);
        persona.appendChild(contacto);
        persona.appendChild(nacionalidadD);
        persona.appendChild(fechaNacimiento);
        destinatario.appendChild(persona);

        provincia.appendChild(codigoProvincia);
        provincia.appendChild(codigoMunicipio);
        domicilio.appendChild(calle);
        domicilio.appendChild(entreCalle);
        domicilio.appendChild(yCalle);
        domicilio.appendChild(no);
        domicilio.appendChild(piso);
        domicilio.appendChild(apto);
        contactosDomicilios.appendChild(domicilio);
        domicilio.appendChild(provincia);
        contacto.appendChild(contactosTelefonos);
        contacto.appendChild(contactosDomicilios);
        destinatario.appendChild(contacto);

        personaR.appendChild(primerNombre_Env);
        personaR.appendChild(segundoNombre_Env);
        personaR.appendChild(primerApellido_Env);
        personaR.appendChild(segundoApellido_Env);
        personaR.appendChild(nacionalidad);
        personaR.appendChild(fechaNacimiento_Env);
        remitente.appendChild(personaR);

        envio.appendChild(noEnvio);
        envio.appendChild(peso);
        envio.appendChild(paisOrigenDestino);
        envio.appendChild(descripcion);
        envio.appendChild(fechaImposicion);
        envio.appendChild(ArancelesPagados);
        envio.appendChild(EntregaDomicilio);
        envio.appendChild(destinatario);
        envio.appendChild(remitente);
        envios.appendChild(envio);
      }
      cantidadBultos.textContent = cantidadB;

      // Construir la estructura del documento XML
      datosXml.appendChild(xmlEstructura);
      datosXml.appendChild(xmlVersion);
      datosXml.appendChild(xmlNombre);
      datosXml.appendChild(xmlTipo);
      datosXml.appendChild(xmlFecha);
      datosXml.appendChild(xmlDescripcion);
      xmlDoc.documentElement.appendChild(datosXml);
      xmlDoc.documentElement.appendChild(operador);
      xmlDoc.documentElement.appendChild(codigoAduana);
      xmlDoc.documentElement.appendChild(agenciaOrigen);
      xmlDoc.documentElement.appendChild(noGA);
      xmlDoc.documentElement.appendChild(noVuelo);
      xmlDoc.documentElement.appendChild(fechaArribo);
      xmlDoc.documentElement.appendChild(operacion);
      xmlDoc.documentElement.appendChild(cantidadBultos);
      envios.appendChild(envio);
      xmlDoc.documentElement.appendChild(envios);

      var xmlString = new XMLSerializer().serializeToString(xmlDoc);

      // Función para formatear la cadena XML con indentación opcional
      function formatXMLString(xmlString, indent = true) {
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(xmlString, "application/xml");
        var xmlSerializer = new XMLSerializer();
        var formattedString = xmlSerializer.serializeToString(xmlDoc);

        if (indent) {
          formattedString = formattedString.replace(
            /(>)\s*(<)(\/*)/g,
            "$1\n$2$3"
          );
          var pad = 0;
          formattedString = formattedString
            .split("\n")
            .map(function (node) {
              var indent = 0;
              if (node.match(/.+<\/\w[^>]*>$/)) {
                indent = 0;
              } else if (node.match(/^<\/\w/)) {
                if (pad !== 0) {
                  pad -= 1;
                }
              } else if (node.match(/^<\w[^>]*[^\/]>.*$/)) {
                indent = 1;
              } else {
                indent = 0;
              }

              var padding = "";
              for (var i = 0; i < pad; i++) {
                padding += "  ";
              }

              pad += indent;

              return padding + node;
            })
            .join("\n");
        }

        return formattedString;
      }

      xmlString = formatXMLString(xmlString);

      // Crear un enlace de descarga
      var downloadLink = document.createElement("a");
      downloadLink.href =
        "data:text/xml;charset=utf-8," + encodeURIComponent(xmlString);
     //downloadLink.download = "MANIFIESTO0000000UY.xml";
         downloadLink.download= "Manifiesto" +fechaFormateada+datosManifiesto[0].numero_externo.slice(-4) +"PK" + ".xml";
      // Simular clic en el enlace de descarga
      downloadLink.click();
    },
  });

  // Función para dar formato a la estructura del documento XML con indentación
  function formatXMLString(xmlNode, indent = "") {
    var result = "";

    // Verificar si el nodo es de tipo Document y tiene un solo nodo hijo
    if (
      xmlNode.nodeType === Node.DOCUMENT_NODE &&
      xmlNode.childNodes.length === 1
    ) {
      // Llamar recursivamente a la función con el nodo hijo
      return formatXMLString(xmlNode.childNodes[0], indent);
    }

    // Agregar indentación a la etiqueta de apertura
    result += indent + "<" + xmlNode.nodeName;

    // Agregar atributos
    if (xmlNode.attributes) {
      for (var i = 0; i < xmlNode.attributes.length; i++) {
        var attribute = xmlNode.attributes[i];
        result += " " + attribute.nodeName + '="' + attribute.nodeValue + '"';
      }
    }

    // Agregar contenido o etiquetas anidadas
    if (xmlNode.childNodes.length > 0) {
      result += ">";
      var hasNestedTags = false; // Verificar si hay etiquetas anidadas

      for (var j = 0; j < xmlNode.childNodes.length; j++) {
        var child = xmlNode.childNodes[j];

        if (child.nodeType === Node.ELEMENT_NODE) {
          result += "\n" + formatXMLString(child, indent + "  ");
          hasNestedTags = true;
        } else if (child.nodeType === Node.TEXT_NODE) {
          result += child.nodeValue;
        }
      }

      // Agregar indentación y salto de línea solo si hay etiquetas anidadas
      if (hasNestedTags) {
        result += indent;
      }

      // Agregar etiqueta de cierre en la misma línea si no hay etiquetas anidadas
      if (!hasNestedTags) {
        result += "</" + xmlNode.nodeName + ">";
      } else {
        // Agregar indentación a la etiqueta de cierre
        result += "\n" + indent + "</" + xmlNode.nodeName + ">";
      }
    } else {
      // No hay contenido, cerrar la etiqueta en la misma línea
      result += "/>";
    }

    return result;
  }
}

function crearPDF(id) {
  var datosManifiesto; // Variable para almacenar los datos recibidos

  $.ajax({
    url: "reportes/generarExcel.php?id=" + id,
    type: "GET",
    success: function (response) {
      // Asigna los datos recibidos a la variable
      datosManifiesto = response;
      // STEP 1: Create a new workbook
      const wb = XLSX.utils.book_new();

      // STEP 2: Create data rows and styles
      let emptyRow = []; // Empty row as the first and third row
      let encabezado = [
        {
          v: "INFORMACION ADELANTADA MANIFIESTO DE ENVIOS DE ORIGEN",
          t: "s",
          s: {
            font: { bold: true, name: "Calibri", sz: 11 },
            alignment: { vertical: "center", horizontal: "center" }, // Center alignment
          },
        },
      ];

      let datos_envio = [
        {
          v: "DATOS DEL ENVIO",
          t: "s",
          s: {
            font: { bold: true, name: "Calibri", sz: 11 },
            alignment: { vertical: "center", horizontal: "center" },
          },
        },
      ];

      let op = [
        {
          v: "OPERADOR",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "01001862514",
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let guia_bl = [
        {
          v: "GUIA No. / BL",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: datosManifiesto[0].numero_externo,
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let no_vuelo_barco = [
        {
          v: "No. VUELO / BARCO",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: datosManifiesto[0].vuelo,
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let linea_aerea = [
        {
          v: "LINEA AEREA",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "CopaAirlines",
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];
      let pais_origen = [
        {
          v: "PAIS ORIGEN",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: datosManifiesto[0].pais_origen,
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let cant_envios = [
        {
          v: "CANT. ENVIOS",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: datosManifiesto.length,
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let peso_kg = [
        {
          v: "PESO EN KG",
          t: "s",
          s: {
            font: { bold: true, name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "", // v: datosManifiesto[0].peso_total,
          t: "s",
          s: {
            font: { name: "Arial", sz: 9 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];

      let fila_data_1 = [
        {
          v: "CÓDIGO",
          t: "s",
          s: {
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PESO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "DESCRIPCIÓN",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "FECHA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PRIMER",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "SEGUNDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PRIMER",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "SEGUNDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "CARNE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PASAPORTE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NACIONA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "FECHA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "ENTRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "CALLES",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NÚMERO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "APARTA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PISO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PRIMER",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "SEGUNDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PRIMER",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "SEGUNDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NACIONA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "FECHA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              top: { style: "medium", color: { rgb: "000000" } },
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];
      let fila_data_2 = [
        {
          v: "ENVIO",
          t: "s",
          s: {
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "KGS",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "ORIGEN",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "IMPOSICIÓN",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NOMBRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NOMBRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "APELLIDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "APELLIDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "IDENTIDAD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "LIDAD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NACIMIENETO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "TELÉFONO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "CALLE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "ENTRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "ENTRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "MENTO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "PROVINCIA",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "MUNICIPIO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NOMBRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NOMBRE",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "APELLIDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "APELLIDO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "LIDAD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "NACIMIENTO",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];
      let fila_data_3 = [
        {
          v: "",
          t: "s",
          s: {
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "AA-MM-DD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "AA-MM-DD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
        {
          v: "AA-MM-DD",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            font: { bold: true, name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        },
      ];
      // STEP 3: Create worksheet with rows; Add worksheet to workbook
      const ws = XLSX.utils.aoa_to_sheet([
        emptyRow,
        encabezado,
        emptyRow,
        op,
        guia_bl,
        no_vuelo_barco,
        linea_aerea,
        pais_origen,
        cant_envios,
        peso_kg,
        emptyRow,
        datos_envio,
        fila_data_1,
        fila_data_2,
        fila_data_3,
      ]);

      let pesoTotal = 0;
      let bultoTotal = 0;
      for (let i = 0; i < datosManifiesto.length; i++) {
        const length = 9;
        const secoundrow = "CM";
        const segoundrow = "PK";
        const id_guia = datosManifiesto[i].id_guia;
        const string = ("0".repeat(length) + id_guia).slice(-length);
        const codigo_guia = secoundrow + string + segoundrow;
        pesoTotal += parseFloat(datosManifiesto[i].peso_total);
        bultoTotal += parseInt(datosManifiesto[i].cantidad_bulto);

        let code_guia = {
          v: codigo_guia,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let peso_real = {
          v: datosManifiesto[i].peso_real,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let descrip = {
          v: datosManifiesto[i].descripcion,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let fecha_guia = {
          v: datosManifiesto[i].fecha_emb,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        var nombre_dest = datosManifiesto[i].nombre_dest;
        var nomb_dest = nombre_dest.split(" ");
        var apellidos_dest = datosManifiesto[i].apellidos_dest;
        var apell_dest = apellidos_dest.split(" ");

        let name1_dest = {
          v: nomb_dest[0],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let name2_dest = {
          v: nomb_dest.slice(1).join(" "),
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        let ap1_dest = {
          v: apell_dest[0],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let ap2_dest = {
          v: apell_dest[1],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let ci = {
          v: datosManifiesto[i].dni_dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let passport = {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        let nacionalidad = {
          v: "CUB",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let fecha_nacEnv = {
          v: "1994-06-17",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        var numero_ci = datosManifiesto[i].dni_dest;
        var fechaDeNacimiento_Dest = obtenerFechaDeNacimiento(numero_ci);
        let fecha_nacDest = {
          v: fechaDeNacimiento_Dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let telefono_dest = {
          v: datosManifiesto[i].tel_dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        const direccion = datosManifiesto[i].direccion_dest;
        const partes = direccion.split(".");
        const variables = {};

        partes.forEach((parte) => {
          parte = parte.trim();
          const [variable, valor] = parte.split(":");

          if (variable && valor) {
            variables[variable.trim()] = valor.trim();
          }
        });

        // console.log(datosManifiesto[i]);
        const calle_dest = variables["Calle"];
        const entre = variables["Entre"] || "";
        const entre_split = entre.split("y") || "";
        const ent_1 = entre_split[0];
        const ent_2 = entre_split[1];
        const edificio = variables["Edificio"];
        const num_casa = variables["No"];
        const apartamento = variables["Apartamento"];

        let calle = {
          v: calle_dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let entre_1 = {
          v: ent_1,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let entre_2 = {
          v: ent_2,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let numero_casa = {
          v: num_casa !== undefined && num_casa !== "" ? num_casa : "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let apto = {
          v: apartamento !== undefined && apartamento !== "" ? apartamento : "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let piso = {
          v: "",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let provincia = {
          v: datosManifiesto[i].provincia_dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let municipio = {
          v: datosManifiesto[i].departamento_dest,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        var nombre_Env = datosManifiesto[i].nombre_Env;
        var nomb_Env = nombre_Env.split(" ");
        var apellidos_Env = datosManifiesto[i].apellidos_Env;
        var apell_Env = apellidos_Env.split(" ");

        let name1_Env = {
          v: nomb_Env[0],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let name2_Env = {
          v: nomb_Env.slice(1).join(" "),
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        let ap1_Env = {
          v: apell_Env[0],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let ap2_Env = {
          v: apell_Env[1],
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };
        let dni = {
          v: "CUB",
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        let fecha_nacRnv = {
          v: datosManifiesto[i].fecha_nacimiento_Env,
          t: "s",
          s: {
            font: { name: "Calibri", sz: 10 },
            alignment: { vertical: "center", horizontal: "center" },
            border: {
              left: { style: "medium", color: { rgb: "000000" } },
              right: { style: "medium", color: { rgb: "000000" } },
              bottom: { style: "medium", color: { rgb: "000000" } },
            },
          },
        };

        XLSX.utils.sheet_add_aoa(
          ws,
          [
            [
              code_guia,
              peso_real,
              descrip,
              fecha_guia,
              name1_dest,
              name2_dest,
              ap1_dest,
              ap2_dest,
              ci,
              passport,
              nacionalidad,
              fecha_nacDest,
              telefono_dest,
              calle,
              entre_1,
              entre_2,
              numero_casa,
              apto,
              piso,
              provincia,
              municipio,
              name1_Env,
              name2_Env,
              ap1_Env,
              ap2_Env,
              dni,
              fecha_nacRnv,
            ],
          ],
          { origin: { r: 15 + i, c: 0 } }
        );
      }

      XLSX.utils.sheet_add_aoa(ws, [[pesoTotal, ""]], { origin: "B10" });

      XLSX.utils.sheet_add_aoa(ws, [["No. ENVIO", ""]], { origin: "H4" });

      XLSX.utils.sheet_add_aoa(ws, [["CAN.BULTOS", bultoTotal]], {
        origin: "H5",
      });

      XLSX.utils.sheet_add_aoa(ws, [["AGENCIA", "PK"]], { origin: "H10" });

      XLSX.utils.sheet_add_aoa(ws, [["DATOS DEL DESTINATARIO", ""]], {
        origin: "F12",
      });

      XLSX.utils.sheet_add_aoa(ws, [["DATOS DEL REMITENTE", ""]], {
        origin: "W12",
      });

      ws["F12"].s = {
        font: { bold: true },
        alignment: { vertical: "center", horizontal: "center" },
      };
      ws["W12"].s = {
        font: { bold: true },
        alignment: { vertical: "center", horizontal: "center" },
      };

      ws["B10"].s = {
        alignment: { vertical: "center", horizontal: "center" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };
      ws["H4"].s = {
        font: { bold: true },
        alignment: { vertical: "left", horizontal: "left" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };
      ws["I4"].s = {
        alignment: { vertical: "right", horizontal: "right" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };

      ws["H5"].s = {
        font: { bold: true },
        alignment: { vertical: "left", horizontal: "left" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };
      ws["I5"].s = {
        alignment: { vertical: "right", horizontal: "right" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };

      ws["H10"].s = {
        font: { bold: true },
        alignment: { vertical: "left", horizontal: "left" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };
      ws["I10"].s = {
        alignment: { vertical: "right", horizontal: "right" },
        border: {
          top: { style: "medium", color: { rgb: "000000" } },
          bottom: { style: "medium", color: { rgb: "000000" } },
          left: { style: "medium", color: { rgb: "000000" } },
          right: { style: "medium", color: { rgb: "000000" } },
        },
      };

      XLSX.utils.book_append_sheet(wb, ws, "readme demo");

      // Merge cells
      const merge = { s: { r: 1, c: 0 }, e: { r: 1, c: 26 } }; // Merge A2:AB2
      merge.s.border = {
        top: { style: "medium", color: { rgb: "000000" } },
        bottom: { style: "medium", color: { rgb: "000000" } },
        left: { style: "medium", color: { rgb: "000000" } },
        right: { style: "medium", color: { rgb: "000000" } },
      };
      const merge2 = { s: { r: 11, c: 0 }, e: { r: 11, c: 4 } };
      const merge3 = { s: { r: 11, c: 5 }, e: { r: 11, c: 21 } };
      const merge4 = { s: { r: 11, c: 22 }, e: { r: 11, c: 26 } };
      ws["!merges"] = [merge, merge2, merge3, merge4];
      // STEP 4: Write Excel file to browser

      XLSX.writeFile(
        wb,
        "INFORMACION ADELANTADA MANIFIESTO_" +
          datosManifiesto[0].numero_externo +
          ".xlsx"
      );
    },
  });
}
