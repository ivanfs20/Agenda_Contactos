<?php

include_once("model/Usuario.php");
session_start();
$sErr="";
$sCve="";
$sNom="";
$sPwd="";
$oUsu = new Usuario();
	if (isset($_POST["txtCve"]) && !empty($_POST["txtCve"]) &&
		isset($_POST["txtPwd"]) && !empty($_POST["txtPwd"])){
		$sCve = $_POST["txtCve"];
		$sPwd = $_POST["txtPwd"];
		$oUsu->setClave($sCve);
		$oUsu->setPwd($sPwd);
		try{
			if ( $oUsu->buscarCvePwd() ){
				$sNom = $oUsu->getAdmin()->getNombre();
				$_SESSION["usu"] = $oUsu;
				if ($oUsu->getAdmin()->getTipo()== Administracion::TIPO_ADMIN)
					$_SESSION["tipo"] = "Administrador";
				else
					if ($oUsu->getAdmin()->getTipo()== Administracion::TIPO_VISUALIZADOR)
					$_SESSION["tipo"] = "Visualizador";
			}
			else{
				$sErr = "Usuario desconocido";
			}
		}catch(Exception $e){
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$sErr = "Error al acceder a la base de datos";
		}
	}
	else
		$sErr = "Faltan datos";
	if ($sErr == "")
		header("Location: inicio.php");
	else
		header("Location: error.php?sError=".$sErr);
?>
