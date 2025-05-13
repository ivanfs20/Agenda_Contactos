<?php
session_start();

include_once("model/Contacto.php");

$oUsuario = new Contacto();
$oUsuario->setIdContacto($_SESSION["id_usuario"]);
$oUsuario->borrar();

unset($_SESSION["id_usuario"]);
header("Location: tabContactos.php"); 
exit();
?>
