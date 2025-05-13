<?php

include_once("AccesoDatos.php");
include_once("Persona.php");
class Administracion extends Persona{
	private $nTipo=0;
	private $nIdAdministracion=0;

	CONST TIPO_ADMIN = 2;
	CONST TIPO_VISUALIZADOR = 1;

    function setTipo($pnTipo){
       $this->nTipo = $pnTipo;
    }
    function getTipo(){
       return $this->nTipo;
    }

    function setnIdAdministracion($nIdAdministracion){
       $this->nIdAdministracion = $nIdAdministracion;
    }
    function getnIdAdministracion(){
       return $this->nIdAdministracion;
    }

	function buscar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->nIdAdministracion==0)
			throw new Exception("Administracion->buscar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = " SELECT sNombre, sApePat, sApeMat, dFecNacim,
								  sSexo, nTipo
							FROM Administracion
							WHERE nIdAdministracion = ".$this->nIdAdministracion;
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$this->dFechaNacim = DateTime::createFromFormat('Y-m-d',$arrRS[0][3]);
					$this->sSexo = $arrRS[0][4];
					$this->nTipo = $arrRS[0][5];
					$bRet = true;
				}
			}
		}
		return $bRet;
	}
	function insertar(){
		$oAccesoDatos = new AccesoDatos();
		$sQuery = "";
		$nAfectados = -1;
	
		if ($this->sNombre == "" || $this->sApePat == "" || $this->sSexo == "" || $this->nTipo == 0 || $this->dFechaNacim == null) {
			throw new Exception("Administracion->insertar(): faltan datos");
		} else {
			if ($oAccesoDatos->conectar()) {
				// 1. Insertar en Administracion
				$sQuery = "INSERT INTO Administracion (sNombre, sApePat, sApeMat, dFecNacim, sSexo, nTipo)
						   VALUES ('".$this->sNombre."', '".$this->sApePat."', ".
						  ($this->sApeMat=="" ? "null" : "'".$this->sApeMat."'").", '".
						  $this->dFechaNacim->format('Y-m-d')."', '".$this->sSexo."', ".$this->nTipo.")";
	
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
	
				$sQueryId = "SELECT nIdAdministracion FROM Administracion 
							 WHERE sNombre = '".$this->sNombre."' AND 
								   sApePat = '".$this->sApePat."' AND 
								   ".($this->sApeMat=="" ? "sApeMat IS NULL" : "sApeMat = '".$this->sApeMat."'")." AND 
								   dFecNacim = '".$this->dFechaNacim->format('Y-m-d')."' AND 
								   sSexo = '".$this->sSexo."' AND 
								   nTipo = ".$this->nTipo."
							 ORDER BY nIdAdministracion DESC LIMIT 1";
	
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQueryId);
	
				if ($arrRS && count($arrRS) > 0) {
					$nIdAdmin = $arrRS[0][0];
					
					$sQueryUsuario = "INSERT INTO Usuario (sContrasenia, nIdAdministracion)
									  VALUES ('".$this->sNombre."', ".$nIdAdmin.")";
	
					$oAccesoDatos->ejecutarComando($sQueryUsuario);
				}
	
				$oAccesoDatos->desconectar();
			}
		}
	
		return $nAfectados;
	}
	
	

	function modificar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->nIdAdministracion==0 OR $this->sNombre == "" OR $this->sApePat == "" OR
		    $this->sSexo == "" OR $this->nTipo == 0 OR $this->dFechaNacim==null)
			throw new Exception("Administracion->modificar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "UPDATE Administracion
					SET sNombre= '".$this->sNombre."' ,
					sApePat= '".$this->sApePat."' ,
					sApeMat= ".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
					dFecNacim = '".$this->dFechaNacim->format('Y-m-d')."',
					sSexo = '".$this->sSexo."',
					nTipo = ".$this->nTipo."
					WHERE nIdAdministracion = ".$this->nIdAdministracion;

				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}

	function borrar(){
		$oAccesoDatos = new AccesoDatos();
		$sQuery = "";
		$nAfectados = -1;
	
		if ($this->nIdAdministracion == 0)
			throw new Exception("PersonalHospitalario->borrar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				$sQueryContacto = "DELETE FROM Contacto WHERE id_usuario = " . $this->nIdAdministracion;
				$oAccesoDatos->ejecutarComando($sQueryContacto);
				
				$sQueryUsuario = "DELETE FROM Usuario WHERE nIdAdministracion = " . $this->nIdAdministracion;
				$oAccesoDatos->ejecutarComando($sQueryUsuario);
				
				$sQuery = "DELETE FROM Administracion WHERE nIdAdministracion = " . $this->nIdAdministracion;
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				
	
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}

	function buscarTodos(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$aLinea=null;
	$j=0;
	$oAdmin=null;
	$arrResultado=[];
		if ($oAccesoDatos->conectar()){
		 	$sQuery = "SELECT nIdAdministracion,sNombre, sApePat, sApeMat,
							  dFecNacim, sSexo, nTipo
				FROM Administracion
				ORDER BY nIdAdministracion";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				foreach($arrRS as $aLinea){
					$oAdmin = new Administracion();
					$oAdmin->setnIdAdministracion($aLinea[0]);
					$oAdmin->setNombre($aLinea[1]);
					$oAdmin->setApePat($aLinea[2]);
					$oAdmin->setApeMat($aLinea[3]);
					$oAdmin->setFechaNacim(DateTime::createFromFormat('Y-m-d',$aLinea[4]));
					$oAdmin->setSexo($aLinea[5]);
					$oAdmin->setTipo($aLinea[6]);
            		$arrResultado[$j] = $oAdmin;
					$j=$j+1;
                }
			}
			else
				$arrResultado = false;
        }
		return $arrResultado;
	}



}
?>
