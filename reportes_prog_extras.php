<?php
require('PHPExcel_/PHPExcel.php');


$iduser = $_GET["iduser"];
$dni = $_GET["dni"];
$xmes = date("Y")."-".$_GET["xmes"];


$conexion = new mysqli('localhost','root','','cot',3306);
if (mysqli_connect_errno()) {
   printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
   exit();
}



$objPHPExcel = new PHPExcel;

//First sheet
$sheet = $objPHPExcel->getActiveSheet();

$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

//Start adding next sheets

// Pagina 1 //
/***********************************************************************************************************************/

$HOJA="DETALLE HORAS PROGRAMADAS";
$i=1;
// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating

//Write cells
$objWorkSheet	->setCellValue('A2', 'ITEM')
		   		->setCellValue('B2', 'DNI')
		   		->setCellValue('C2', 'CIP')
		    	->setCellValue('D2', 'N.COMPLETO')
				->setCellValue('E2', 'SUPERVISOR')
				->setCellValue('F2', 'MODO')
		   		->setCellValue('G2', 'FEC.INI')
		   		->setCellValue('H2', 'FEC.FIN')
				->setCellValue('I2', 'TIEMPO TRABAJADAS')
           		->setCellValue('J2', 'TIEMPO A COMPENSAR')
		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('G')->setAutoSize(true);
$objWorkSheet->getColumnDimension('H')->setAutoSize(true);
$objWorkSheet->getColumnDimension('I')->setAutoSize(true);
$objWorkSheet->getColumnDimension('J')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_1 = "SELECT a.dni,b.ncompleto,a.fec_ini_inc,a.fec_ini_inc,a.tiempo,b.cip,
a.modo,tiempo_sf,b.c_supervisor
FROM programacion_extra a, tb_usuarios b 
WHERE a.dni = b.dni  and substr(a.fec_ini_inc,1,7)='$xmes'
GROUP BY 1,2,3 ORDER BY b.ncompleto ";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_1; 
$res_q1 = $conexion->query($query_1);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_1 = $res_q1->fetch_row()) { 

	$c_supervisor = $fila_1['8'];
	
	$query_s = "select * from tb_supervisores WHERE cod_supervisor='$c_supervisor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_s; 
	$res_qs = $conexion->query($query_s);
	$fila_s = $res_qs->fetch_ARRAY();
	

 $objWorkSheet	->setCellValue('A'.$i, $item=$item+1)
	 			->setCellValue('B'.$i, $fila_1['0'])
	 			->setCellValue('C'.$i, $fila_1['5'])
	 			->setCellValue('D'.$i, $fila_1['1'])
	 			->setCellValue('E'.$i, $fila_s['nom_supervisor'])
	 			->setCellValue('F'.$i, $fila_1['6'])
	 			->setCellValue('G'.$i, $fila_1['2'])
	 			->setCellValue('H'.$i, $fila_1['3'])
	 			->setCellValue('I'.$i, $fila_1['7'])
	 			->setCellValue('J'.$i, $fila_1['4'])
	 ;
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:J".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("B2:C".$i)->applyFromArray($estilo);

/********************************************************************************************************************/
//PAGINA 2

$HOJA = "ACUMULADO HORAS PROGRAMADAS";
//Write cells
$objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating

$objWorkSheet->setCellValue('A2', 'ITEM')
		   ->setCellValue('B2', 'DNI')
		   ->setCellValue('C2', 'CIP')
   		   ->setCellValue('D2', 'N.COMPLETO')
		   ->setCellValue('E2', 'SUPERVISOR')
		   ->setCellValue('F2', 'MES')
		   ->setCellValue('G2', 'HR. TRABAJADAS ')
   		   ->setCellValue('H2', 'HR. COMPENSAR ')
		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:H2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('G')->setAutoSize(true);
$objWorkSheet->getColumnDimension('H')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_2 = "SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_inc,1,7) AS mes,SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))),b.cip,SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo_sf))),b.c_supervisor
FROM programacion_extra a, tb_usuarios b
WHERE a.dni=b.dni and substr(a.fec_ini_inc,1,7)='$xmes'
GROUP BY 1,3";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_2; 
$res_q2 = $conexion->query($query_2);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_2 = $res_q2->fetch_row()) { 


	$c_supervisor = $fila_2['6'];	
	$query_s = "select * from tb_supervisores WHERE cod_supervisor='$c_supervisor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_s; 
	$res_qs = $conexion->query($query_s);
	$fila_s = $res_qs->fetch_ARRAY();
	
 $objWorkSheet->setCellValue('A'.$i, $item=$item+1)
	 ->setCellValue('B'.$i, $fila_2['0'])
	 ->setCellValue('C'.$i, $fila_2['4'])
	 ->setCellValue('D'.$i, $fila_2['1'])
	 ->setCellValue('E'.$i, $fila_s['nom_supervisor'])
	 ->setCellValue('F'.$i, $fila_2['2'])
	 ->setCellValue('G'.$i, $fila_2['5'])
	 ->setCellValue('H'.$i, $fila_2['3'])
	 ;
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:H".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')				
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("B2:C".$i)->applyFromArray($estilo);

/***********************************************************************************************************************/
// pagina 3


$HOJA="DETALLE HORAS COMPENSACION";

$i=1;
// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet(3); //Setting index when creating

//Write cells
$objWorkSheet	->setCellValue('A2', 'ITEM')
		   		->setCellValue('B2', 'DNI')
		   		->setCellValue('C2', 'CIP')
		    	->setCellValue('D2', 'N.COMPLETO')
				->setCellValue('E2', 'SUPERVISOR')
				->setCellValue('F2', 'MODO')
		   		->setCellValue('G2', 'FEC.INI')
		   		->setCellValue('H2', 'FEC.FIN')
				->setCellValue('I2', 'TIEMPO TRABAJADAS')
           		->setCellValue('J2', 'TIEMPO A COMPENSAR')
		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('J')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_3 = "SELECT a.dni,b.ncompleto,a.fec_ini_comp,a.fec_fin_comp,a.tiempo_comp,b.cip,
a.modo_comp,tiempo_comp,b.c_supervisor
FROM compensacion_extra a, tb_usuarios b 
WHERE a.dni = b.dni  and substr(a.fec_ini_comp,1,7)='$xmes'
GROUP BY 1,2,3 ORDER BY b.ncompleto ";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_3; 
$res_q3 = $conexion->query($query_3);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_3 = $res_q3->fetch_row()) { 

	$c_supervisor = $fila_3['8'];
	
	$query_s = "select * from tb_supervisores WHERE cod_supervisor='$c_supervisor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_s; 
	$res_qs = $conexion->query($query_s);
	$fila_s = $res_qs->fetch_ARRAY();
	
	
 $objWorkSheet	->setCellValue('A'.$i, $item=$item+1)
	 			->setCellValue('B'.$i, $fila_3['0'])
	 			->setCellValue('C'.$i, $fila_3['5'])
	 			->setCellValue('D'.$i, $fila_3['1'])
	 			->setCellValue('E'.$i, $fila_s['nom_supervisor'])
	 			->setCellValue('F'.$i, $fila_3['6'])
	 			->setCellValue('G'.$i, $fila_3['2'])
	 			->setCellValue('H'.$i, $fila_3['3'])
	 			->setCellValue('I'.$i, $fila_3['7'])
	 			->setCellValue('J'.$i, $fila_3['4'])
				
	 ;	 
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:J".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("B2:C".$i)->applyFromArray($estilo);

/*********************************************************************************************************************/

//PAGINA 4

$HOJA = "ACUMULADO HORAS COMPENSACION";
//Write cells
$objWorkSheet = $objPHPExcel->createSheet(4); //Setting index when creating

$objWorkSheet->setCellValue('A2', 'ITEM')
		   ->setCellValue('B2', 'DNI')
		   ->setCellValue('C2', 'CIP')
   		   ->setCellValue('D2', 'N.COMPLETO')
		   ->setCellValue('E2', 'SUPERVISOR')
		   ->setCellValue('F2', 'MES')
		   ->setCellValue('G2', 'HR. TRABAJADAS ')
   		   ->setCellValue('H2', 'HR. COMPENSAR ')

		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:H2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('G')->setAutoSize(true);
$objWorkSheet->getColumnDimension('H')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
$query_4 = "SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_comp,1,7) AS mes,SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo_comp))),
b.cip,SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo_comp))),b.c_supervisor
FROM compensacion_extra a, tb_usuarios b
WHERE a.dni=b.dni and substr(a.fec_reg,1,7)='$xmes'
GROUP BY 1,3";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_4; 
$res_q4 = $conexion->query($query_4);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_4 = $res_q4->fetch_row()) { 


	$c_supervisor = $fila_4['6'];	
		
	$query_s = "select * from tb_supervisores WHERE cod_supervisor='$c_supervisor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_s; 
	$res_qs = $conexion->query($query_s);
	$fila_s = $res_qs->fetch_ARRAY();
	
	
 $objWorkSheet->setCellValue('A'.$i, $item=$item+1)
	 ->setCellValue('B'.$i, $fila_4['0'])
	 ->setCellValue('C'.$i, $fila_4['4'])
	 ->setCellValue('D'.$i, $fila_4['1'])
	 ->setCellValue('E'.$i,$fila_s['nom_supervisor'])
	 ->setCellValue('F'.$i, $fila_4['2'])
	 ->setCellValue('G'.$i, $fila_4['5'])
	 ->setCellValue('H'.$i, $fila_4['3'])
	 ;
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:H".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')				
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("B2:C".$i)->applyFromArray($estilo);

/*********************************************************************************************************************/
// Rename sheet
//$objWorkSheet->setTitle("HOJA".$i);


// POner hoja por defecto
//$objPHPExcel->setActiveSheetIndex(0);
		   
// Save the spreadsheet
//$writer->save('products.xlsx');
$n_archivo="programacion_extras_".date("Y-m-d").".xls";


header('Content-Disposition: attachment;filename="'.$n_archivo.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
