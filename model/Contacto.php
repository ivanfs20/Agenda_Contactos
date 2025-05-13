<?php
include_once("AccesoDatos.php");

class Contacto {
    protected $nIdContacto = 0;
    protected $sNombre = "";
    protected $sApePat = "";
    protected $sApeMat = "";
    protected $dFechaNacim = null;
    protected $sSexo = "";
    protected $sTelefono = "";
    protected $nIdVisualizador = 0;

    function setnIdVisualizador($nIdVisualizador) {
        $this->nIdVisualizador = $nIdVisualizador;
    }

    function getnIdVisualizador() {
        return $this->nIdVisualizador;
    }


    function setIdContacto($nIdContacto) {
        $this->nIdContacto = $nIdContacto;
    }

    function getIdContacto() {
        return $this->nIdContacto;
    }

    function setTelefono($sTelefono) {
        $this->sTelefono = $sTelefono;
    }

    function getTelefono() {
        return $this->sTelefono;
    }

    function setNombre($psNombre) {
        $this->sNombre = $psNombre;
    }

    function getNombre() {
        return $this->sNombre;
    }

    function setApePat($psApePat) {
        $this->sApePat = $psApePat;
    }

    function getApePat() {
        return $this->sApePat;
    }

    function setApeMat($psApeMat) {
        $this->sApeMat = $psApeMat;
    }

    function getApeMat() {
        return $this->sApeMat;
    }

    function setFechaNacim($pdFechaNacim) {
        $this->dFechaNacim = $pdFechaNacim;
    }

    function getFechaNacim() {
        return $this->dFechaNacim;
    }

    function setSexo($psSexo) {
        $this->sSexo = $psSexo;
    }

    function getSexo() {
        return $this->sSexo;
    }

    function getNombreCompleto() {
        return $this->sApePat . " " . $this->sApeMat . " " . $this->sNombre;
    }

    function buscarTodosContactos() {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $aLinea = null;
        $j = 0;
        $oPersHosp = null;
        $arrResultado = [];

        if ($oAccesoDatos->conectar()) {
            $sQuery = "SELECT * FROM Contacto";
            $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
            $oAccesoDatos->desconectar();
            if ($arrRS) {
                foreach ($arrRS as $aLinea) {
                    $oPersHosp = new Contacto();
                    $oPersHosp->setIdContacto($aLinea[0]);
                    $oPersHosp->setNombre($aLinea[1]);
                    $oPersHosp->setApePat($aLinea[2]);
                    $oPersHosp->setApeMat($aLinea[3]);
                    $oPersHosp->setFechaNacim(DateTime::createFromFormat('Y-m-d', $aLinea[4]));
                    $oPersHosp->setSexo($aLinea[5]);
                    $oPersHosp->setTelefono($aLinea[6]);
                    $oPersHosp->setnIdVisualizador($aLinea[7]);
                    
                    $arrResultado[$j] = $oPersHosp;
                    $j++;
                }
            }
        }

        return $arrResultado;
    }

    public function buscarPorUsuario($idUsuario) {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $arrContactos = [];
    
        if ($idUsuario == 0) {
            throw new Exception("Contacto->buscarPorUsuario(): falta el ID del usuario");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "SELECT nIdContacto, sNombre, sApePat, sApeMat, dFecNacim, sSexo, sTelefono, id_usuario 
                           FROM Contacto
                           WHERE id_usuario = " . intval($idUsuario);
    
                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();
    
                if ($arrRS && count($arrRS) > 0) {
                    foreach ($arrRS as $fila) {
                        $oContacto = new Contacto();
                        $oContacto->nIdContacto = $fila[0];
                        $oContacto->sNombre     = $fila[1];
                        $oContacto->sApePat     = $fila[2];
                        $oContacto->sApeMat     = $fila[3];
                        $oContacto->dFechaNacim = DateTime::createFromFormat('Y-m-d', $fila[4]);
                        $oContacto->sSexo       = $fila[5];
                        $oContacto->sTelefono   = $fila[6];
                        $oContacto->nIdVisualizador   = $fila[7];
                        $arrContactos[] = $oContacto;
                    }
                }
            }
        }
    
        return $arrContactos;
    }
    


    public function buscar() {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $bRet = false;

        if ($this->nIdContacto == 0) {
            throw new Exception("Contacto->buscar(): falta el ID del contacto");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "SELECT sNombre, sApePat, sApeMat, dFecNacim, sSexo, sTelefono, id_usuario 
                           FROM Contacto
                           WHERE nIdContacto = ". $this->nIdContacto;

                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();

                if ($arrRS && count($arrRS) > 0) {
                    $this->sNombre     = $arrRS[0][0];
                    $this->sApePat     = $arrRS[0][1];
                    $this->sApeMat     = $arrRS[0][2];
                    $this->dFechaNacim = DateTime::createFromFormat('Y-m-d', $arrRS[0][3]);
                    $this->sSexo       = $arrRS[0][4];
                    $this->sTelefono   = $arrRS[0][5];
                    $this->nIdVisualizador   = $arrRS[0][6];
                    $bRet = true;
                }
            }
        }

        return $bRet;
    }
    function insertar() {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;
    
        if ($this->sNombre == "" || $this->sApePat == "" || $this->sSexo == "" || $this->sTelefono == "" || $this->dFechaNacim == null) {
            throw new Exception("Contacto->insertar(): faltan datos");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "INSERT INTO Contacto (sNombre, sApePat, sApeMat, dFecNacim, sSexo, sTelefono, id_usuario)
                VALUES ('".$this->sNombre."', '".$this->sApePat."',
                ".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
                '".$this->dFechaNacim->format('Y-m-d')."',
                '".$this->sSexo."', '".$this->sTelefono."', '".$this->nIdVisualizador."')";
        
                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }
    
        return $nAfectados;
    }
    
    function modificar() {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;
    
        if ($this->nIdContacto == 0 || $this->sNombre == "" || $this->sApePat == "" || $this->sSexo == "" || $this->sTelefono == "" || $this->dFechaNacim == null) {
            throw new Exception("Contacto->modificar(): faltan datos");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "UPDATE Contacto SET 
                            sNombre = '".$this->sNombre."',
                            sApePat = '".$this->sApePat."',
                            sApeMat = ".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
                            dFecNacim = '".$this->dFechaNacim->format('Y-m-d')."',
                            sSexo = '".$this->sSexo."',
                            sTelefono = '".$this->sTelefono."',
                            id_usuario = '".$this->nIdVisualizador."' 
                           WHERE nIdContacto = ".$this->nIdContacto;
    
                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }
    
        return $nAfectados;
    }
    
  

  function borrar() {
   $oAccesoDatos = new AccesoDatos();
   $sQuery = "";
   $nAfectados = -1;

   if ($this->nIdContacto == 0) {
       throw new Exception("Contacto->borrar(): falta ID de contacto");
   } else {
       if ($oAccesoDatos->conectar()) {
           $sQuery = "DELETE FROM Contacto WHERE nIdContacto = ".$this->nIdContacto;
           $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
           $oAccesoDatos->desconectar();
       }
   }

   return $nAfectados;
}

}
?>
