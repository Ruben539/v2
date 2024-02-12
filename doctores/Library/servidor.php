<?php

require_once("mysql.php");

$oMysql = new MYSQL();

$respuesta = "";
if($_POST){ 
$rq = $_POST['rq'];
}
if($rq == 1){
	$respuesta = $oMysql->getPacienteDoctores();

}

echo $respuesta;