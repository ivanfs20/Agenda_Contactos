<?php

include_once("model/Contacto.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = ""; $sNomBoton ="Borrar";
$oPersHosp=new Contacto();
$bCampoEditable = false; $bLlaveEditable=false;

$oPersHosp = new Contacto();
	/*Verificar que haya sesión*/
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		/*Verificar datos de captura*/
		if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
			isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
			$sOpe = $_POST["txtOpe"];
			$sCve = $_POST["txtClave"];

			if ($sOpe != 'a'){
				$oPersHosp->setIdContacto($sCve);
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

<script>
	alert(
		echo $_POST["txtClave"];
	);
</script>
		<section>
			<form name="abcPH" action="resABCContactos.php" method="post">
				<h1>Contacto:</h1>
				<input type="hidden" name="txtOpe" value="<?php echo $sOpe;?>">
				<input type="hidden" name="txtClave" value="<?php echo $sCve;?>"/>
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
				Telefono
				<input type="text" name="txtTelefono" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $oPersHosp->getTelefono();?>"/>
				<br/>

				Id Visualizador:
				<input type="text" name="idVisualizador" 
					<?php echo ($bCampoEditable==true?'':' disabled ');?>
					value="<?php echo $oPersHosp->getnIdVisualizador();?>"/>
				<br/>


				<br/>
				<input type ="submit" value="<?php echo $sNomBoton;?>" 
				onClick="return evalua(txtNombre, txtApePat, rbSexo, txtFecNacim);" style="margin:2; background-color:black; color: white;"/>
				<input type="submit" name="Submit" value="Cancelar" 
				 onClick="abcPH.action='inicio.php';" style="margin:2; background-color:black; color: white;">
			</form>
		</section>
<?php
include_once("pie.html");
?>