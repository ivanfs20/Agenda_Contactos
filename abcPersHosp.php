<?php

include_once("model/Administracion.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = ""; $sNomBoton ="Borrar";
$oPersHosp=new Administracion();
$bCampoEditable = false; $bLlaveEditable=false;

$oPersHosp = new Administracion();
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
			isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
			$sOpe = $_POST["txtOpe"];
			$sCve = $_POST["txtClave"];
			if ($sOpe != 'a'){
				$oPersHosp->setnIdAdministracion($sCve);
				try{
					if (!$oPersHosp->buscar()){
						$sError = "Personal Hospitalario no existe";
					}
				}catch(Exception $e){
					error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
					$sErr = "Error en base de datos, comunicarse con el administrador";
				}
			}
			if ($sOpe == 'a'){
				$bCampoEditable = true;
				$bLlaveEditable = true;
				$sNomBoton ="Agregar";
			}
			else if ($sOpe == 'm'){
				$bCampoEditable = true; 
				$sNomBoton ="Modificar";
			}
		}
		else{
			$sErr = "Faltan datos";
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
			<form name="abcPH" action="resABC.php" method="post">
				<input type="hidden" name="txtOpe" value="<?php echo $sOpe;?>">
				<input type="hidden" name="txtClave" value="<?php echo $sCve;?>"/>
					
				<!--<?php echo "<script>alert(" . $oPersHosp->getnIdAdministracion() . ");</script>"; ?>-->

				Nombre
				<input type="text" name="txtNombre" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $oPersHosp->getNombre();?>"/>
				<br/>
				Apellido Paterno
				<input type="text" name="txtApePat" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $oPersHosp->getApePat();?>"/>
				<br/>
				Apellido Materno
				<input type="text" name="txtApeMat" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $oPersHosp->getApeMat();?>"/>
				<br/>
				Fecha de Nacimiento (aaaa-mm-dd)
				<input type="date" name="txtFecNacim" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $sOpe == 'a'?'':$oPersHosp->getFechaNacim()->format('Y-m-d');?>"/>
				<br/>
				Sexo
				<input type="radio" name="rbSexo" value="F"
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					<?php echo ($oPersHosp->getSexo()=='F'?'checked="true"':'');?>/>Femenino
				<input type="radio" name="rbSexo" value="M"
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					<?php echo ($oPersHosp->getSexo()=='M'?'checked="true"':'');?>/>Masculino
				<br/>
				Tipo
				<select name="cmbTipo" <?php echo ($bCampoEditable==true?'':' disabled ');?>>
					<option value="<?php echo Administracion::TIPO_ADMIN;?>"
					<?php echo ($oPersHosp->getTipo()==Administracion::TIPO_ADMIN?'selected="true"':'');?>>Administrador Sistema</option>
					<option value="<?php echo Administracion::TIPO_VISUALIZADOR;?>"
					<?php echo ($oPersHosp->getTipo()==Administracion::TIPO_VISUALIZADOR?'selected="true"':'');?>>Visualizador</option>
				</select>
				<br/>
				<input type ="submit" value="<?php echo $sNomBoton;?>" 
				onClick="return evalua(txtNombre, txtApePat, rbSexo, txtFecNacim);" style="margin:2; background-color:black; color: white;"/>
				<input type="submit" name="Submit" value="Cancelar" 
				 onClick="abcPH.action='tabpersonal.php';" style="margin:2; background-color:black; color: white;">
			</form>
		</section>
<?php
include_once("pie.html");
?>