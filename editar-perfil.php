<?php
include("session.php");
include("conexion.php");

if (isset($_POST['perfil'])) {
  //Guardando nombre y ruta de img
  $nom_archivo = $_FILES['file1']['name'];
  $ruta = "uploads/" . $nom_archivo;
  //Subiendo img
  $archivo = $_FILES['file1']['tmp_name'];
  $subir = move_uploaded_file($archivo, $ruta);
  //actualizanod en base de datos
  $sentencia_img = "UPDATE users SET imagen = '" . $ruta . "' WHERE id_user = '" . $_GET['id'] . "' ";
  $resultado = mysqli_query($conexion, $sentencia_img);
  //Mostrar msj y redireccionar
  $_SESSION['message'] = "Perfil modificado con exito";
  $_SESSION['message-type'] = 'success';

  header('Location: perfil.php');
  session_start();
  $_SESSION['imagen'] = $nom_archivo;
}
?>
<?php
include_once("includes/header.php");
include_once("includes/sidebar.php");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <div class="col-md-12">
    <h2>Modificar perfil</h2>
  </div>
</div>
<form class="form-horizontal" method="POST" enctype="multipart/form-data"
  action="editar-perfil.php?id=<?php echo $_GET['id']; ?>" autocomplete="off">
  <div class="container">
    <input type="file" name="file1" id="file1">
    <button type="submit" name="perfil" class="btn btn-primary">Modificar</button>
  </div>
</form>
<?php
include_once("includes/footer.php");
?>