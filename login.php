<?php

include("conexion.php");

$usuario = $_POST["username"];
$Contraseña = $_POST["password"];

$Usuario = mysqli_real_escape_string($con,(strip_tags($_POST["username"],ENT_QUOTES)));
$Contraseña = mysqli_real_escape_string($con,(strip_tags($_POST["password"],ENT_QUOTES)));

$sql = "SELECT * FROM users WHERE email= '$Usuario' AND password = '$Contraseña' ";
$consulta = mysqli_query($con,$sql);

if (mysqli_num_rows($consulta) == 0) {
    echo '<center><div th:if="${param.error}" class="alert alert-danger" role="alert">Usuario invalido</div></center>';
} else {    
    session_start();
    $_SESSION["usuario"] = $usuario;
    header("Location: user-form.php");
}