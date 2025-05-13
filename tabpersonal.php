<?php
/*
Archivo:  tabpersonal.php
Objetivo: consulta general sobre personal hospitalario y acceso a operaciones detalladas
Autor:    
*/
include_once("model/Usuario.php");
include_once("model/Administracion.php");
session_start();
$sErr="";
$sNom="";
$arrAdmin=null;
$oUsu = new Usuario();
$oAdmin = new Administracion();
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getAdmin()->getNombre();
		try{
			$arrAdmin = $oAdmin->buscarTodos();
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
			<h3>Personal Agendas</h3>
			<form name="formTablaGral" method="post" action="abcPersHosp.php">
				<input type="hidden" name="txtClave">
				<input type="hidden" name="txtOpe">
				<table border="1">
					<tr>
						<td>Clave</td>
						<td>Nombre</td>
						<td>Operaci&oacute;n</td>
					</tr>
					<?php
						if ($arrAdmin!=null){
							foreach($arrAdmin as $oAdmin){
					?>
					<tr>
						<td class="llave"><?php echo $oAdmin->getnIdAdministracion(); ?></td>
						<td><?php echo $oAdmin->getNombreCompleto(); ?></td>
						<td>
							<input type="submit" name="Submit" value="Modificar" onClick="txtClave.value=<?php echo $oAdmin->getnIdAdministracion(); ?>; txtOpe.value='m'">
							<input type="submit" name="Submit" value="Borrar" onClick="txtClave.value=<?php echo $oAdmin->getnIdAdministracion(); ?>; txtOpe.value='b'">
						</td>
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
				<input type="submit" name="Submit" value="Crear Nuevo" onClick="txtClave.value='-1';txtOpe.value='a'" style="margin:2; background-color:black; color: white;" id="crearPersonal">
			</form>
		</section>
<?php
include_once("pie.html");
?>