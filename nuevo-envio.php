<?php
include("session.php");
include("conexion.php");
include_once("includes/header.php");
include_once("includes/sidebar.php");
include_once("includes/footer.php");

?>
<br>
<h2>Nuevo Cheque</h2>
    <div class="container">
        <form class="form-horizontal" method="POST" action="guardar-cheque.php" autocomplete="off">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 div-nuevo">
					    <label for="numero" class="col-sm-2 control-label">Cód. Cliente</label>
					    <input type="text" class="form-control" id="clientes_id" name="clientes_id" required>
					</div>
                    <div class="col-md-6 div-nuevo">
					    <label for="numero" class="col-sm-2 control-label">N° de Cheque</label>
					    <input type="text" class="form-control" id="cheque" name="cheque" required>
					</div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 div-nuevo">
                        <label>Razon Social Librador</label>
                        <input type="text" name="razon_social" id="razon_social" class='form-control' maxlength="50" required ></input>
                    </div>
                    <div class="col-md-6 div-nuevo">
                        <label>Cuit Librador</label>
                        <input type="text" name="cuit_librador" id="cuit_librador" class='form-control' maxlength="50" required ></input>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 div-nuevo">
					    <label for="vto" class="col-sm-2 control-label">Vencimiento</label>
					    <input type="text" class="form-control" id="vto" name="vto" required>
					</div>
                    <div class="col-md-6 div-nuevo">
                        <label for="importe" class="col-sm-2 control-label">Importe</label>
					    <input type="text" class="form-control" id="importe" name="importe" required>
					</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 div-nuevo">
                        <label for="propio" class="col-sm-2 control-label">Cheque Propio</label>
                        <label class="radio-inline">
                            <input type="radio" id="propio" name="propio" value="Si" checked> SI
                        </label>    
                        <label class="radio-inline">
                            <input type="radio" id="propio" name="propio" value="No"> NO
                        </label>
                    </div>
                    <br>
                    <div class="col-md-6 div-nuevo">
                        <label for="echeq" class="col-sm-2 control-label">Echeq</label>
                        <label class="radio-inline">
                            <input type="radio" id="echeq" name="echeq" value="Si" checked> SI
                        </label>    
                        <label class="radio-inline">
                            <input type="radio" id="echeq" name="echeq" value="No"> NO
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-dark boton-secundario"><a href="cheques.php">Regresar</a></button>
                        <button type="submit" name= "guardar_cheque" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</main>
