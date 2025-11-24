<?php
require('PHPExcel_/PHPExcel.php');

$iduser = $_GET["iduser"];
$dni = $_GET["dni"];


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

$query_1 = "SELECT * from tb_usuarios where dni='$dni' ";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_1;
 
$res_q1 = $conexion->query($query_1);

$reg_q1 = $res_q1->fetch_array();

$HOJA=1;

$i=1;
// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet($HOJA); //Setting index when creating

//Write cells
$objWorkSheet->setCellValue('A3', 'GESTOR')
		   ->setCellValue('B3', $reg_q1['ncompleto'])
		   ->setCellValue('A5', 'DNI')
		   ->setCellValue('B5', $reg_q1['dni'])
		   ->setCellValue('A10', 'ITEM')
		   ->setCellValue('B10', 'MES')
		   ->setCellValue('C10', 'FEC.INI')
		   ->setCellValue('D10', 'FEC.FIN')
           ->setCellValue('E10', 'DIF.')
		   ;

// Making headers text bold and larger
$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A10:E10')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle("HOJA".$HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_2 = "SELECT *
FROM programacion_extra where dni='$dni' ";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_2; 
$res_q2 = $conexion->query($query_2);

$i = 11; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila = $res_q2->fetch_array()) { 
 $objWorkSheet->setCellValue('A'.$i, $item=$item+1)
	 ->setCellValue('B'.$i, substr($fila['fec_ini_inc'],0,7))
	 ->setCellValue('C'.$i, $fila['fec_ini_inc'])
	 ->setCellValue('D'.$i, $fila['fec_fin_inc'])
	 ->setCellValue('E'.$i, $fila['tiempo']);
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A10:E".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

/********************************************************************************************************************/

$HOJA = 2;
//Write cells
$objWorkSheet = $objPHPExcel->createSheet($HOJA); //Setting index when creating

$objWorkSheet->setCellValue('A3', 'GESTOR')
		   ->setCellValue('B3', $reg_q1['ncompleto'])
		   ->setCellValue('A5', 'DNI')
		   ->setCellValue('B5', $reg_q1['dni'])
		   ->setCellValue('A10', 'ITEM')
		   ->setCellValue('B10', 'MES')
		   ->setCellValue('C10', 'ACUMULADO')
		   ;

// Making headers text bold and larger
$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A10:E10')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle("HOJA".$HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_3 = "SELECT SUBSTR(fec_ini_inc,1,7) AS mes,SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo)))
FROM programacion_extra where dni='$dni'";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_2; 
$res_q3 = $conexion->query($query_3);

$i = 11; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_2 = $res_q3->fetch_row()) { 
 $objWorkSheet->setCellValue('A'.$i, $item=$item+1)
	 ->setCellValue('B'.$i, $fila_2['0'])
	 ->setCellValue('C'.$i, $fila_2['1'])
	 ;
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A10:E".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);





/*********************************************************************************************************************/
// Rename sheet
//$objWorkSheet->setTitle("HOJA".$i);


// POner hoja por defecto
//$objPHPExcel->setActiveSheetIndex(0);
		   
// Save the spreadsheet
//$writer->save('products.xlsx');
$n_archivo="programacion_extras_".date("Y-m-d").".csv";


header('Content-Disposition: attachment;filename="PROG_HORAS_EXTRAS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
