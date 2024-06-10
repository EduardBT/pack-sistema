<?php
include "session.php";
include "conexion.php";
include_once "includes/header.php";
include_once "includes/sidebar.php";
include_once "includes/footer.php";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
      form#multiphase {
        border: #000 1px solid;
        padding: 24px;
        width: 100%;
      }
      form#multiphase > #phase2,
      #phase3,
      #show_all_data {
        display: none;
      }
    </style>

  </head>
  <body>
    <div class="container">
        <progress id="progressBar" value="0" max="100" style="width: 100%"></progress>
        <h3 id="status">Paso 1 de 3</h3>
        <form id="multiphase" onsubmit="return false">

            <div id="phase1"> <!-- Remitente-->
                
                 Remitente:
                <select id="remitente" name="remitente" class="form-select" aria-label="Default select example">
                <option value="">Seleccione:</option>
                <?php
                $query = "SELECT * FROM personas  order by dni";
                $result = mysqli_query($conexion, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['id_persona'] . '">' . $row['dni'] .', '. $row['nombre'] . ' ' . $row['apellidos'] . '</option>';
                }
                ?>
                </select> <br/>

               
                <button type="button" class="btn btn-success" onclick="processPhase1()">Continuar</button>
                <a href="nuevo-cliente.php?regreso=remitente"><button type="button" class="btn btn-light">Nuevo Cliente</button></a>
                           <div id="loconseguido">
            
            </div><!--aqui se mostraran los resultados-->
            </div>



               

            <div id="phase2">  <!-- Destinatario -->
                Destinatario:<br/>
                <select id="destinatario" name="destinatario" class="form-select" aria-label="Default select example">
                    <option value="">Seleccione:</option>
                    <?php
                    $query = "SELECT * FROM personas order by dni";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row['id_persona'] . '">' . $row['dni'] .', '. $row['nombre'] . ' ' . $row['apellidos'] . '</option>';
                    }

                    ?>
                </select> <br/>
                <button type="button" class="btn btn-secondary" onclick="procesoAtras0()">Anterior</button>
                <button type="button" class="btn btn-success" onclick="processPhase2()">Continue</button>
                <a href="nuevo-cliente.php"><button type="button" class="btn btn-light">Nuevo Cliente</button></a>
                <div id="loconseguidoDest">
          
          </div><!--aqui se mostraran los resultados-->
            </div>

        <div id="phase3">  <!-- Envío -->
            <div class="form-group">
                <div class="row">
                    <h4>Datos de Envío</h4><br>
                    <div class="col-md-4 div-nuevo">
                        <label>País de Origen</label> 
                        <select id="cod_origen" name="cod_origen" class="form-select" aria-label="Default select example">
                            <option value="0">Seleccione:</option>
                            <?php
                            $query = "SELECT * FROM cod_pais";
                            $result = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label>País de Destino</label> 
                        <select id="cod_destino" name="cod_destino" class="form-select" aria-label="Default select example">
                            <option value="0">Seleccione:</option>
                            <?php
                                $query = "SELECT * FROM cod_pais";
                                $result = mysqli_query($conexion, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id_pais'] . '">' . $row['descripcion'] . '</option>';
                                }
                                ?>
                        </select>
                    </div> <br>
                    <div class="col-md-4 div-nuevo">
                        <label>Fecha de Embarque</label>
                        <input type="date" type="date" name="fecha" id="fecha" class='form-control' maxlength="25" required ></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                       
                        <input type="hidden" name="valor" id="valor" class='form-control' maxlength="25" value=1></input>
                    </div>
            
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 div-nuevo">
                        <label>Tipo de Bulto</label>
                        <select class="form-select" aria-label="Default select example" id="tipo_bulto" name="tipo_bulto">
                            <option selected>Seleccione:</option>
                            <option value="APX">APX</option>
                            <option value="DOX">DOX</option>
                            <option value="ENA">ENA</option>
                        </select>
                        </div>
                        <div class="form-group">
                <div class="row">
                        <div class="col-md-4 div-nuevo">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="descripcion" value="escriba descripcion" class='form-control' maxlength="15"></input>
                    
                    </div>
                        <div class="col-md-4 div-nuevo">
                            <label>Cantidad de Bultos</label>
                            <input type="text" name="num_bulto" id="num_bulto" class='form-control' maxlength="25" required ></input>
                        </div>
                        <div class="col-md-4 div-nuevo">
                            <label class="form-check-label" for="flexCheckDefault">
                                Empaquetado
                            </label>  <!--OJO preguntar por el id="propio (para que se usa?)" -->
                            <input type="radio" id="empaquetado" name="empaquetado" value="Si" > SI
                            <input type="radio" id="empaquetado" name="empaquetado" value="No" checked> NO
                        </div>
                    </div>
                </div>
                
                <!-- Modal calculo de volumen-->
                <div class="modal modal-dialog-scrollable" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                    <div class="modal-dialog  ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Calculadora de volumen</h5>
                                <button type="button" class="btn-close close cerrarModal" data-mdb-dismiss="modal" aria-label="Close" ></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 1</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;"  onkeypress ="calcular();"  >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 2</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 3</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 4</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 5</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 6</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 7</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 8</h5>
                                        </div>
                                        <div class="col-md-2">                                    
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 9</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any" class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h5>Bulto 10</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Alto(cm)</label>
                                            <input type="number" step="any" class="form-control alto" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Ancho(cm)</label>
                                            <input type="number" step="any" class="form-control ancho" style="padding: 4px; border-radius: 0.3rem;">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Largo(cm)</label>
                                            <input type="number" step="any"  class="form-control largo" style="padding: 4px; border-radius: 0.3rem;" onkeypress ="calcular();">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Volumen(cm3)</label>
                                            <input type="number" step="any" class="form-control volumen" style="padding: 4px; border-radius: 0.3rem;" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button  type="button" id="button2" class="btn btn-secondary close cerrarModal" onclick="Cerrar()" data-mdb-dismiss="modal">
                                Cerrar 
                                </button>


                                <button type="button" class="btn btn-primary"  id="button1">Calcular</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin modal -->

                <div class="form-group">
                <div class="row">
                    <div class="col-md-4 div-nuevo">
                    <label>Peso (Kg)</label>
                    <input type="text" id= "peso_real" name="peso_real" class='form-control' maxlength="25" required ></input>
                    </div>
                    <div class="col-md-4 div-nuevo">
                        <label class="form-check-label" for="flexCheckDefault">
                        electronico
                        </label>  <!--OJO preguntar por el id="propio (para que se usa?)" -->
                        <input type="radio" id="electronico" name="electronico" value="SI" checked> SI
                        <input type="radio" id="electronico" name="electronico" value="NO"> NO
                    </div>
                    <div class="col-md-4 div-nuevo">
                    <label>Volumen (m3)</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                        <button type="button" class="btn" data-mdb-toggle="modal" data-mdb-target="#exampleModal" style="padding:0px;" onclick="processCalcular()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
                            <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"></path>
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"></path>
                            </svg>
                        </button>
                        </span>
                        <input type="number" name="peso-volumetrico" class="form-control" id='spTotal' aria-label="Input group example" aria-describedby="basic-addon1">
                    </div>                    
                    </div>
                    <div class="col-md-4 div-nuevo">
                    <label>Servicio</label>
                    <input type="text" name="servicio" id="servicio" placeholder="International Express Standard" value="International Express Standard" class='form-control' maxlength="25"></input>
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="row">
                    <div class="col-md-4 div-nuevo">
                    <label>Incotem</label>
                    <select class="form-select" aria-label="Default select example" id="incotem"name="incotem">
                        <option selected>Seleccione:</option>
                        <option value="DDP">DDP</option>
                        <option value="DDU">DDU</option>
                    
                    </div>
                    
                    <div class="form-group">
                <div class="row">
                    
                   
                    <div class="col-md-4 div-nuevo">
                    <label>escriba el codigo de La Habana</label>
                    <input type="text" name="producto" placeholder="IES" value="escriba el codigo de La Habana" class='form-control' maxlength="15"  ></input>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" onclick="procesoAtras1()">Anterior</button>
                <button type="button" class="btn btn-success" onclick="processPhase3()">Continue</button>
            </div>
            <div id="show_all_data">
            
                Remitente: <span id="display_remitente"></span> <br />
                Destinario: <span id="display_destinatario"></span> <br />
                origen: <span id="display_cod_origen"></span> <br />
                fecha:<span id="display_fecha"></span> <br />
                valor:<span id="display_valor"></span> <br />
                tipo_bulto:<span id="display_tipo_bulto"></span> <br /> 
                num_bulto:<span id="display_num_bulto"></span> <br />        
                peso_real:<span id="display_peso_real"></span> <br />
                
                empaquetado:<span id="display_empaquetado"></span> <br />
                incotem:<span id="display_incotem"></span> <br />
                descripcion:<span id="display_descripcion"></span> <br />
                electronico:<span id="display_electronico"></span> <br/>
                <button onclick="procesoAtras2()">Anterior</button> 
                <button name= "generar-guia" onclick="submitForm()" class="btn btn-primary">Generar Guía</button>
            </div>
        </form>
    </div>
    <script src="js/main.js" ></script>
    <script src="js/prueba.js" ></script>
    <script src="js/destinatarios.js" ></script> 
  </body>
</html>

