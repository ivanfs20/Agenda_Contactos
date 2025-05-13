<?php

include_once("AccesoDatos.php");
include_once("Administracion.php");
class Usuario{ // clase base  "padre"
	private $nClave = 0;
	private $sPwd = "";
	private $oAdmision = null;
	private $oAD = null;

	public function getAdmin(){
		return $this->oAdmision;
	}
	public function setAdmin($valor){
		$this->oAdmision = $valor;
	}

	public function getClave(){
		return $this->nClave;
	}
	public function setClave($valor){
		$this->nClave = $valor;
	}

	public function getPwd(){
		return $this->sPwd;
	}
	public function setPwd($valor){
		$this->sPwd = $valor;
	}

	public function buscarCvePwd(){
	$bRet = false;
	$sQuery = "";
	$arrRS = null;
		if (($this->nClave == 0 || $this->sPwd == "") )
			throw new Exception("Usuario->buscar: faltan datos");
		else{
			$sQuery = "SELECT t1.nIdAdministracion
					   FROM usuario t1
					   WHERE t1.nIdAdministracion = ".$this->nClave."
					   AND t1.sContrasenia = '".$this->sPwd."'";
			//Crear, conectar, ejecutar, desconectar
			$oAD = new AccesoDatos();
			if ($oAD->conectar()){
				$arrRS = $oAD->ejecutarConsulta($sQuery);
				$oAD->desconectar();
				if ($arrRS != null){
					$this->oAdmision = new Administracion();
					$this->oAdmision->setnIdAdministracion($arrRS[0][0]);
					$this->oAdmision->buscar();
					$bRet = true;
				}
			}
		}
		return $bRet;
	}
}
?>
