<?php
require('PHPExcel_/PHPExcel.php');

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

// Pagina 1
$i=0;

// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

$nombreGestor = "LUIS";

//Write cells
$objWorkSheet->setCellValue('A3', 'GESTOR')
		   ->setCellValue('B3', $nombreGestor)
		   ->setCellValue('A5', 'CIP')
		   ->setCellValue('A8', 'ITEM')
		   ->setCellValue('B8', 'MES')
		   ->setCellValue('C8', 'FEC.PROG.INI')
		   ->setCellValue('D8', 'FEC.PROG.FIN')
		   ->setCellValue('D8', 'DIFERENCIA')  ;

// Rename sheet
$objWorkSheet->setTitle("HOJA".$i);

////////////////////////////////////////////////////////////////////////////////////////////		   
// Pagina 2
$i=1;
// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

$nombreGestor = "LUIS";

//Write cells
$objWorkSheet->setCellValue('A3', 'GESTOR')
		   ->setCellValue('B3', "HOY")
		   ->setCellValue('A5', 'CIP')
		   ->setCellValue('B5', 'MES')
		   ->setCellValue('C5', 'TIEMPO PROGRAMADO')
		   ->setCellValue('D5', 'TIEMPO COMPENSADO')
		   ->setCellValue('E5', 'DIF')  ;

// Making headers text bold and larger
$objWorkSheet->getStyle('A3:B3')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A5:E5')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle("HOJA".$i);
		   



//Se agregan los datos de los alumnos
 
$consulta = "SELECT concat(paterno,' ', materno, ' ' , nombre) AS alumno, fechanac, sexo, carrera FROM alumno ";
$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
 
$resultado = $conexion->query($consulta);

$i = 6; //Numero de fila donde se va a comenzar a rellenar
while ($fila = $resultado->fetch_array()) {
 
 $objWorkSheet->setCellValue('A'.$i, $fila['alumno'])
	 ->setCellValue('B'.$i, $fila['fechanac'])
	 ->setCellValue('C'.$i, $fila['sexo'])
	 ->setCellValue('D'.$i, $fila['carrera']);
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A5:E".$i)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);


// POner hoja por defecto
$objPHPExcel->setActiveSheetIndex(0);
		   
// Save the spreadsheet
//$writer->save('products.xlsx');
header('Content-Disposition: attachment;filename="file.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
