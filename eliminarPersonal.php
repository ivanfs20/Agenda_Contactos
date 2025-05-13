<?php
session_start(); 
include_once("model/Administracion.php"); 

$oUsuario = new Administracion();
$oUsuario->setnIdAdministracion($_SESSION["id_usuario"]);
$oUsuario->borrar();

unset($_SESSION["id_usuario"]);
header("Location: tabpersonal.php"); 
exit();
?>
