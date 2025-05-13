<?php
session_start();

include_once("model/Contacto.php"); 

$oUsuario = unserialize($_SESSION["usuario"]); 
$oUsuario->modificar();

unset($_SESSION["usuario"]);
header("Location: tabContactos.php");
exit();
?>
