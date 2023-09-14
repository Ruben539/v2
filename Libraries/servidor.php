<?php

require_once("mysql.php");

$oMysql = new MYSQL();

$respuesta = "";
if($_POST){ 
$rq = $_POST['rq'];
}
if($rq == 1){
	$respuesta = $oMysql->getPacientePaz();

}elseif ($rq == 2) {
 	$respuesta = $oMysql->getPacienteDiax();

}elseif ($rq == 3) {
	$respuesta = $oMysql->getTotalPacientes();

}elseif ($rq == 4) {
	$respuesta = $oMysql->getMontoDiax();

}elseif ($rq == 5) {
	$respuesta = $oMysql->getMontoPaz();

}elseif($rq == 6) {
	$respuesta = $oMysql->getMontoTotal();
}elseif($rq == 7) {
	$respuesta = $oMysql->getEliminacionOrdenes();
}elseif($rq == 8) {
	$respuesta = $oMysql->getEliminacionGasto();
}elseif($rq == 9) {
	$respuesta = $oMysql->getEliminacionMedico();
}
echo $respuesta;



