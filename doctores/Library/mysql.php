<?php 
//TODO:Consultas realizadas para los alert de los medicos con pacientes nuevos.
session_start();
require_once('host.php');
$id = $_SESSION['idMedico'];
class MYSQL {

    //TODO: Variable privadas definidas para la conexion a la base de datos.
    private $oConBD = null;
    private $usuarioBD = '';
    private $passBD = '';
    private $hostBD = '';
    private $nombreBD = '';


   


    public function __construct() {
        
        global $usuarioBD , $passBD, $hostBD, $nombreBD, $rq;

        $this->usuarioBD = $usuarioBD;
		$this->passBD = $passBD;
		$this->hostBD = $hostBD;
		$this->nombreBD = $nombreBD;
		$this->$rq = $rq;
	
    }

    //TODO: Funcion para realizar la conexion a la base de datos por las variables definidas.
    public function conexBDPDO(){
		try{
			$this->oConBD = new PDO("mysql:host=".$this->hostBD.";dbname=". $this->nombreBD , $this->usuarioBD, $this->passBD);

			return true;
		}catch(PDOException $e){
			echo "Error de Conexion: ". $e->getMessage(). "\n";
			return false;
		}
	}


    //TODO: Funcion utlizada para realizar la alerta de un nuevo paciente.
    public function getPacienteDoctores(){
		$id    = $_SESSION['idMedico'];
		$fecha = date('Y-m-d');
		$idPacientes = 0;
		try{
			$strQuery = "SELECT * FROM comprobantes WHERE doctor_id = $id AND estado LIKE '%En Espera%' AND created_at LIKE '%$fecha%' ";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idPacientes= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getPacienteDoctores: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idPacientes;
	}


}