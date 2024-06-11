<?php
include "conexion.php";

$usuarioCorrecto = $_POST['usuario'];
$passwordCorrecto = $_POST['password'];

if (empty($usuarioCorrecto) || empty($passwordCorrecto)) {
    header("Location: index.php?err");
} else {
    $baseUsuarios = mysqli_query($conexion, "SELECT * FROM usuario WHERE nombre_usuario = '$usuarioCorrecto' AND pass = '$passwordCorrecto'");

    if (mysqli_num_rows($baseUsuarios) == 1) {
        if ($row = mysqli_fetch_array($baseUsuarios)) {
            session_start();
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuarioCorrecto;
            $_SESSION['imagen'] = $row['imagen'];
            $_SESSION['pass'] = $passwordCorrecto;
            $_SESSION['roll'] = $row['roll'];
            header("Location: guia.php");
        }
    } else {
        //Error de ingreso
        header("Location: index.php?err");
    }

}
