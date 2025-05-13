<?php

include_once("model/Usuario.php");
session_start();
$sErr = "";
$sNom="";
$sTipo="";
$oUsu=new Usuario();
 
	if (isset($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getAdmin()->getNombre();
		$sTipo = $_SESSION["tipo"];
	}
	else
		$sErr = "Debe estar firmado";
	
	if ($sErr == ""){
		include_once("cabecera.html");
		include_once("menu.php");
		include_once("aside.html");
	}
	else{
		header("Location: error.php?sErr=".$sErr);
		exit();
	}
 ?>
        <section id="sectionInformation">
			<div>
			<h1>Bienvenido <?php echo $sNom;?></h1>
			<br>
			<h3>Eres tipo <?php echo $sTipo;?></h3>
			</div>
			<?php
				if($sTipo=="Administrador"){
			?>
			<div>
				<img src="media/admin.png" alt="">
			</div>
			<?php
				}else{
			?>
			<div>
				<img src="media/user.png" alt="">
			</div>
			<?php
				}
			?>
		</section>
<?php
include_once("pie.html");
?>