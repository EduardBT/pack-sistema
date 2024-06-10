<?php
session_start();

if (empty($_SESSION['nombre_usuario'])) {
    header('location: index.php');
    exit();
}
