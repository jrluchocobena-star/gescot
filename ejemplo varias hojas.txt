<?php
require('PHPExcel.php');

$objPHPExcel = new PHPExcel;

//First sheet
$sheet = $objPHPExcel->getActiveSheet();

//Start adding next sheets
$i=0;
while ($i < 10) {

  // Add new sheet
  $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

  //Write cells
  $objWorkSheet->setCellValue('A1', 'Hello'.$i)
			   ->setCellValue('B2', 'world!')
			   ->setCellValue('C1', 'Hello')
			   ->setCellValue('D2', 'world!');

  // Rename sheet
  $objWorkSheet->setTitle("$i");

  $i++;
}

?>