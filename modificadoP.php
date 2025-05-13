<?php
session_start();

include_once("model/Administracion.php"); 

$oUsuario = unserialize($_SESSION["usuario"]); 
$oUsuario->modificar();

unset($_SESSION["usuario"]);
header("Location: tabpersonal.php");
exit();
?>
