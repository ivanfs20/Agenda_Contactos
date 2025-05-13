<?php

include_once("model/Contacto.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = "";
$oAdmin = new Contacto();

	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		/*Verifica datos de captura mínimos*/
		if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
			isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
			$sOpe = $_POST["txtOpe"];
			$sCve = $_POST["txtClave"];
			$oAdmin->setIdContacto($sCve);
			
			if ($sOpe != "b"){
				$oAdmin->setNombre($_POST["txtNombre"]);
				$oAdmin->setApePat($_POST["txtApePat"]);
				$oAdmin->setApeMat($_POST["txtApeMat"]);
				$oAdmin->setFechaNacim(DateTime::createFromFormat('Y-m-d', $_POST["txtFecNacim"]));
				$oAdmin->setSexo($_POST["rbSexo"]);
				$oAdmin->setTelefono($_POST["txtTelefono"]);
				$oAdmin->setnIdVisualizador($_POST["idVisualizador"]);
			}
			try {
				if ($sOpe == 'a') {
					$_SESSION["usuario"] = serialize($oAdmin);
					header("Location: insertarC.php");
					exit();	
					//$nResultado = $oPersHosp->insertar();
				} else if ($sOpe == 'b') {
					$_SESSION["id_usuario"] = $sCve;
					header("Location: borrarC.php");
					exit(); 
				} else {
					$_SESSION["usuario"] = serialize($oAdmin);
					header("Location: modificarC.php");
					exit();	
					//$nResultado = $oPersHosp->modificar();
				}
				
				if ($nResultado != 1) {
					$sError = "Error en bd";
				}
			} catch (Exception $e) {
				error_log("ERROR SQL: ".$e->getMessage()."\nTrace: ".$e->getTraceAsString());
				$sErr = "Error en base de datos: " . $e->getMessage();  // ← muestra el error real en pantalla temporalmente
			}
		}
		else{
			$sErr = "Faltan datos";
		}
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == "")
		header("Location: tabContactos.php");
	else
		header("Location: error.php?sError=".$sErr);
	exit();
?>