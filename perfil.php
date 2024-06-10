<?php
include("session.php");
include("conexion.php");
include_once("includes/header.php");
include_once("includes/sidebar.php");
include_once("includes/footer.php");
?>

<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message-type']; ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']);
} ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="col-md-12">
        <h2>Perfil usuario
            <?php echo $_SESSION["usuario"]; ?>
        </h2>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h4>Foto de Perfil</h4>
        </div>
        <?php

        $id = $_SESSION['id'];
        $query = "SELECT * FROM usuario WHERE id_user = '$id'";
        $result = mysqli_query($conexion, $query);

        //recorrer tabla
        while ($row = mysqli_fetch_array($result)) { ?>
            <div class="col-md-6">
                <?php echo "<img src='" . $row['imagen'] . "' width='250px'>"; ?>
                <a class="btn btn-secondary" href="editar-perfil.php?id=<?php echo $row['id_user']; ?>"><i
                        class="bi bi-pencil-fill"></i></a>
            </div>

        <?php } ?>
    </div>
</div>
</main>
</div>