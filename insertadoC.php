<?php
session_start();

include_once("model/Contacto.php"); 

$oUsuario = unserialize($_SESSION["usuario"]); 
$oUsuario->insertar();

unset($_SESSION["usuario"]);
header("Location: tabContactos.php");
exit();
?>
