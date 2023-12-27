<?php 
   require_once("../Models/conexion.php");
   date_default_timezone_set('America/Asuncion');
   $hoy =  date('Y-m-d');
   $id = $_REQUEST['id'];
   
   $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,u.fecha_nac,u.nombre,dc.cobertura,
   dc.nro_radiografias,c.comentario,dc.monto,dc.descuento, m.nombre as doctor,s.descripcion as seguro,dc.monto_seguro, c.created_at
   FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
   INNER JOIN medicos m ON m.id = c.doctor_id 
   INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
   WHERE c.id = '".$id."' AND c.created_at like '%$hoy%'  ORDER BY c.id DESC");  
   
   //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
   
   //echo 'paso el sql';
   //exit();
   
   
   $resultado = mysqli_num_rows($sql);

   if ($resultado == 0) {
        
       header("location: ../Templates/dashboard.php");
   }else{
      
       while ($data = mysqli_fetch_array($sql)) {
        
           $id                = $data['id'];
           $ruc               = $data['ruc'];
           $razon_social      = $data['razon_social'];
           $medico            = $data['doctor'];
           $nro_radiografias  = $data['nro_radiografias'];
           $seguro            = $data['seguro'];
           $descuento         = $data['descuento'];
           $comentario        = $data['comentario'];
           $created_at        = $data['created_at'];
           $cobertura         = $data['cobertura'];
           $fecha_nac         = $data['fecha_nac'];
          
   
       }
   }
?>

<?php

	# Incluyendo librerias necesarias #
    require_once("code128.php");

    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("Centro medico Paz-Diax")),0,'C',false);
    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Direccion: Primera Junta Municipal, Fernado de la Mora"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: 021514974"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Correo: sistemadiax@gmail.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',15);
    $pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1",strtoupper("Ticket Nro: $id")),0,'C',false);
    $pdf->SetFont('Arial','B',11);

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha de Ingreso: $created_at"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Paciente: $razon_social"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cedula: $ruc "),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","F. Nacimiento : $fecha_nac "),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Medico: $medico"),0,'C',false);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Seguro: $seguro"),0,'C',false);
    if($cobertura == 1){
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cobertura: Preferencial"),0,'C',false);
    }else{
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cobertura: Completa"),0,'C',false);
    }
   

    $pdf->Ln(1);
    $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Nro."),0,0,'C');
    $pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Estudio"),0,0,'C');
    $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Monto"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);



    /*----------  Detalles de la tabla  ----------*/
    $comprobante_id = $id;
    $sql = mysqli_query($conection,"SELECT dc.descripcion,dc.monto,dc.estudio_id FROM detalle_comprobantes dc WHERE dc.comprobante_id='$comprobante_id'");
    
    $resultado = mysqli_num_rows($sql);
    $nro = 0;
    $estudio = '';
    $monto = '';
    $total= 0;
    $cobro = 0;
    $desc = number_format($descuento,0,'.','.');
   while( $data = mysqli_fetch_array($sql)){
    $nro++;
    $estudio = $data['descripcion'];
    if($data['descripcion'] == 'Radiografias'){
        $monto = number_format($data['monto'] * $nro_radiografias,0,'.','.');
    }else{
        $monto = number_format($data['monto'],0,'.','.');
    }

    if($data['descripcion'] == 'Radiografias'){
        $total += $data['monto'] * $nro_radiografias;
    }else{
        $total += $data['monto'];
    }
   
   
   
   
    //print_r($data); 

    $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1","$nro"),0,0,'C');
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","    $estudio"),0,0,'C');
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1","$monto"),0,0,'C');
    $pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
    $pdf->Ln(7);
}
    /*----------  Fin Detalles de la tabla  ----------*/
$cobro =  number_format($total - $descuento, 0,'.','.');
   



    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
     # IDescuento  #
     $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1","Descuento"),0,0,'C');
     $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
     $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$desc"),0,0,'C');
     $pdf->Ln(5);

    $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);
     # ITotal a Pagar #
     $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1","Total a Pagar"),0,0,'C');
     $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
     $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","$cobro"),0,0,'C');
     $pdf->Ln(5);
     $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
     $pdf->Ln(5);




    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*** Este ticket no tiene valor legal, solamente sirve para presentar en caja y realizar el pago del servicio, exija su factura ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su Visita!!!"),'',0,'C');

 
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Tiketc de Recepcion.pdf",true);