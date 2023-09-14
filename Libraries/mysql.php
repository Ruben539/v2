<?php
session_start();
require_once("host.php");


class MYSQL {
	private $oConBD = null;

	public function __construct(){
		global $usuarioBD , $passBD, $ipBD, $nombreBD, $rq;

		$this->usuarioBD = $usuarioBD;
		$this->passBD = $passBD;
		$this->ipBD = $ipBD;
		$this->nombreBD = $nombreBD;
		$this->$rq = $rq;

	}




	//Vamos a utlilzar la sintaxis PDO de Conexion
	public function conexBDPDO(){
		try{
			$this->oConBD = new PDO("mysql:host=".$this->ipBD.";dbname=". $this->nombreBD , $this->usuarioBD, $this->passBD);

			return true;
		}catch(PDOException $e){
			echo "Error de Conexion: ". $e->getMessage(). "\n";
			return false;
		}
	}

	//Codigo sirve para traer los parametros para las vistas
	public function getPacientePaz(){
		$idPacientePaz = 0;
		$fecha =  date('d-m-Y');
		// $anio =  date('Y');
		try{
			$strQuery = "SELECT count(*) tpacientes  FROM historial  where Fecha LIKE '%$fecha%' AND Atendedor like '%PAZ%' AND estatus = 1";
			//$strQuery = "SELECT COUNT(*) from clientes WHERE year(FechaIngreso)= $anio AND month(FechaIngreso)= $mes ";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idPacientePaz= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getPacientePaz: ". $e->getMessage(). "\n";
			return -1;;
		}
		return $idPacientePaz;
	}

	public function getPacienteDiax(){
		$idPacienteDiax = 0;
		$fecha =  date('d-m-Y');
		// $anio =  date('Y');
		try{
			$strQuery = "SELECT count(*) tpacientes  FROM historial  where Fecha LIKE '%$fecha%' AND Atendedor like '%DIAX%' AND estatus = 1";
			//$strQuery = "SELECT COUNT(*) from clientes WHERE year(FechaIngreso)= $anio AND month(FechaIngreso)= $mes ";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idPacienteDiax= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getPacienteDiax: ". $e->getMessage(). "\n";
			return -1;;
		}
		return $idPacienteDiax;
	}

	//Codigo sirve para traer los parametros para las de los Pacientes en espera
	public function getTotalPacientes(){
		$idTotalPacientes = 0;
		$fecha  =  date('d-m-Y');

		try{
			$strQuery = "SELECT count(*) tpacientes  FROM historial where Fecha LIKE '%".$fecha."%' AND estatus = 1";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idTotalPacientes= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getTotalPacientes: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idTotalPacientes;
	}

	//Codigo sirve para traer los parametros para las de los Pacientes Atendidos
	public function getMontoDiax(){
		$idMontoDiax = 0;
		$fecha  =  date('d-m-Y');

		try{
			$strQuery = "SELECT SUM(monto) tmontoDiax  FROM historial  where Fecha LIKE '%$fecha%' AND Atendedor LIKE '%DIAX%' AND estatus = 1";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idMontoDiax = $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getMontoDiax: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idMontoDiax;
	}

	//Codigo sirve para traer los parametros para las de los Pacientes totales en el mes
	public function getMontoPaz(){
		$idMontoPaz = 0;
		$fecha  =  date('d-m-Y');
	
		try{
			$strQuery = "SELECT SUM(monto) tmontoPaz  FROM historial  where Fecha LIKE '%$fecha%' AND Atendedor LIKE '%PAZ%' AND estatus = 1";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idMontoPaz= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getMontoPaz: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idMontoPaz;
	}


	public function getMontoTotal(){
		$idTotalMonto = 0;
		$fecha  =  date('d-m-Y');
		try{
			$strQuery = "SELECT SUM(monto) tmontoTotal  FROM historial  where Fecha LIKE '%$fecha%' AND estatus = 1 ";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idTotalMonto= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getNofificaciones: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idTotalMonto;
	}

	public function getEliminacionOrdenes(){
		$idNotificacionPen = 0;
		try{
			$strQuery = "SELECT COUNT(*) as tNotificacion FROM historial WHERE estatus = 2";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idNotificacionPen= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getEliminacionOrdenes: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idNotificacionPen;
	}

	public function getEliminacionGasto(){
		$idNotificacioGasto = 0;
	
		try{
			$strQuery = "SELECT COUNT(*) as tNotificacion FROM gastos WHERE estatus = 2";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idNotificacioGasto= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getEliminacionGasto: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idNotificacioGasto;
	}

	public function getEliminacionMedico(){
		$idNotificacionMedico = 0;
		$mes = date('m');
		$anio = date('Y');
		try{
			$strQuery = "SELECT COUNT(*) as tNotificacion FROM medicos WHERE estatus = 2";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idNotificacionMedico= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getEliminacionMedico: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idNotificacionMedico;
	}

	public function getGastos(){
		$idGastos = 0;
		$mes = date('m');
		$anio = date('Y');
		try{
			$strQuery = "SELECT COUNT(*) as tNotificacion FROM gastos WHERE estatus = 2";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idGastos= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getGastos: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idGastos;
	}

	public function getGastosPen(){
		$idGastosPen = 0;
		$mes = date('m');
		$anio = date('Y');
		try{
			$strQuery = "SELECT COUNT(*) as tNotificacion FROM gastos WHERE estatus = 2";
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$idGastosPen= $pQuery->fetchColumn();
			}
		}catch(PDOException $e){
			echo "MYSQL.getGastos: ". $e->getMessage(). "\n";
			return -1;
		}
		return $idGastosPen;
	}

	/*//Codigo para recuperar los datos para la grafica
	public function getDatosGrafica(){
		$jDatos = '';
		$rawData= array();
		$i=0;
		try{
			$strQuery = "SELECT SUM(producida) as tproduccion, SUM(probado) as tprobados,SUM(faltante) as tfaltante, SUM(banco) as tbanco, DATE_FORMAT(fecha_alta,'%Y-%m/%d') as fecha FROM control GROUP BY DATE_FORMAT(fecha_alta,'%Y-%m/%d') ORDER BY fecha DESC ";
			//echo $strQuery;
			if($this->conexBDPDO()){
				$pQuery =$this->oConBD->prepare($strQuery);
				$pQuery->execute();
				$pQuery->setFetchMode(PDO::FETCH_ASSOC);
				while ($producto = $pQuery->fetch()) {
					$oGrafica = new Grafica();
					$oGrafica->totalProducido = $producto['tproduccion'];
					$oGrafica->totalProbado = $producto['tprobados'];
					$oGrafica->totalFaltante = $producto['tfaltante'];
					$oGrafica->totalBanco = $producto['tbanco'];
					
					$rawData[$i] = $oGrafica;
					$i++;

				}

				$jDatos = json_encode($rawData);

			}
		}catch(PDOException $e){
			echo "MYSQL.getDatosGrafica: ". $e->getMessage(). "\n";
		}
		return $jDatos;
	}
*/
	
}
class Grafica{
	public $totalProducido = 0;
	public $totalProbado = 0;
	public $totalFaltante = 0;
	public $totalBanco = 0;
}
