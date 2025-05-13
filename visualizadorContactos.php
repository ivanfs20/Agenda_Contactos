<?php

include_once("model/Usuario.php");
include_once("model/Contacto.php");
session_start();
$sErr="";
$sNom="";
$arrPersHosp=null;
$oUsu = new Usuario();
$oPersHosp = new Contacto();
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getAdmin()->getNombre();
		try{
			$arrPersHosp = $oPersHosp->buscarPorUsuario($oUsu->getClave());
		}catch(Exception $e){
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$sErr = "Error en base de datos, comunicarse con el administrador";
		}
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == ""){
		include_once("cabecera.html");
		include_once("menu.php");
		include_once("aside.html");
	}
	else{
		header("Location: error.php?sError=".$sErr);
		exit();
	}
?>
		<section>
			<h3>Usuarios</h3>
			<form name="formTablaGral" method="post" action="abcContacto.php">
				<input type="hidden" name="txtClave">
				<input type="hidden" name="txtOpe">
				<table border="1">
					<tr>
						<td>Clave</td>
						<td>Nombre</td>
						<td>FechaNacimiento</td>
						<td>Sexo</td>
						<td>Telefono</td>
					</tr>
					<?php
						if ($arrPersHosp!=null){
							foreach($arrPersHosp as $oPersHosp){
					?>
					<tr>
						<td class="llave"><?php echo $oPersHosp->getIdContacto(); ?></td>
						<td><?php echo $oPersHosp->getNombreCompleto(); ?></td>
						<td><?php echo $oPersHosp->getFechaNacim()->format('Y-m-d'); ?></td>
						<td><?php echo $oPersHosp->getSexo(); ?></td>
						<td><?php echo $oPersHosp->getTelefono(); ?></td>
					</tr>
					<?php 
							}
						}else{
					?>     
					<tr>
						<td colspan="2">No hay datos</td>
					</tr>
					<?php
						}
					?>
				</table>
			</form>
		</section>
<?php
include_once("pie.html");
?>