<?php


require_once('../Models/conexion.php');

$idEvento         = $_POST['idEvento'];
$doctor_id        = $_REQUEST['doctor_id'];
$nombre           = $_REQUEST['nombre'];
$agenda           = ucwords($_REQUEST['agenda']);
$f_inicio         = $_REQUEST['fecha_inicio'];
$fecha_inicio     = date('Y-m-d', strtotime($f_inicio)); 

$f_fin             = $_REQUEST['fecha_fin']; 
$seteando_f_final  = date('Y-m-d', strtotime($f_fin));  
$fecha_fin1        = strtotime($seteando_f_final."+ 1 days");
$fecha_fin         = date('Y-m-d', ($fecha_fin1));  
$color_evento      = $_REQUEST['color_evento'];

$UpdateProd = ("UPDATE agendamiento 
    SET doctor_id ='$doctor_id',
        nombre ='$nombre',
        agenda ='$agenda',
        fecha_inicio ='$fecha_inicio',
        fecha_fin ='$fecha_fin',
        color_evento ='$color_evento'
    WHERE id='".$idEvento."' ");
$result = mysqli_query($conection, $UpdateProd);

header("Location:calendario.php?e=1");

$id = $_REQUEST['idEvento'];
$query  = mysqli_query($conection, 'SELECT * FROM agendamiento where id = "'.$id.'" estatus = 1');
$resultado = mysqli_num_rows($query);

if($resultado == 0){
    header("Location:calendario.php?e=1"); 
}else{
    while ($data = mysqli_fetch_array($query)) {
		
		$id            = $data['id'];
		$nombre        = $data['nombre'];	
		$agenda        = $data['agenda'];	
		$fecha_inicio  = $data['fecha_inicio'];	
		$fecha_fin     = $data['fecha_fin'];	

	}
}
?>