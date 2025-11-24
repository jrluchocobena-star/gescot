<?php
//Incluimos librería y archivo de conexión
require '../PHPExcel/Classes/PHPExcel.php';
$id_user = $_GET['usuario'];
//Consulta
$mysqli = @new mysqli('119.8.147.241', 'gesdeveloper', 'G3sc0td3v#', 'cot');

$arrayLetrasMotivos = array (0 => 'B', 1 => 'C' , 2 => 'D', 3 => 'E', 4 => 'F', 5 => 'G', 6 => 'H', 7 => 'I', 8 => 'J', 9 => 'K', 10 => 'L', 11 => 'M', 12 => 'N', 13 => 'O', 14 => 'P');

$sql = "select grupo,sgrupo from tb_usuarios where iduser =  $id_user";
$usuarios = $mysqli->query($sql);

$usuarios = $usuarios->fetch_assoc();

$grupo = $usuarios['grupo'];

$sql = "SELECT tb_usuarios.ncompleto, tb_usuarios.dni FROM tb_usuarios 
INNER JOIN horarios_gestores_cot ON tb_usuarios.dni = horarios_gestores_cot.dni
WHERE estado='HABILITADO' AND horarios_gestores_cot.cod_horario != 'S/H' AND horarios_gestores_cot.vacaciones != 'SI' AND c_supervisor='$id_user' 
order by ncompleto";
$operador = $mysqli->query($sql);
$operador_numero = $operador->num_rows;


$sql = "SELECT cod_mot_inc,tp_inc 
FROM tb_motivos_incidencia 
WHERE est='1' AND nom_mot_inc != '' AND cod_mot_inc != '' AND tp_inc != 'MONITOREO Y CAPACITACION COT'
GROUP BY tp_inc
ORDER BY tp_inc";
$motivotipo = $mysqli->query($sql);
$motivotipo_numero = $motivotipo->num_rows;

$rowsMotivoTipo = array();
while($row = $motivotipo->fetch_assoc()) {
    $rowsMotivoTipo[] = $row;
}



foreach ($rowsMotivoTipo as  $key => $tipo) {
    
    $whereTipo = $tipo['tp_inc'];
    $sql = "SELECT cod_mot_inc,nom_mot_inc FROM tb_motivos_incidencia WHERE est='1' AND nom_mot_inc != '' AND tp_inc = '$whereTipo' ORDER BY nom_mot_inc";
  
    $motivo = $mysqli->query($sql);
    $motivo_numero = $motivo->num_rows;

    $rowsMotivo = array();
    while($row = $motivo->fetch_assoc()) {
        $rowsMotivo[] = $row;
    }
    $rowsMotivoTipo[$key]['numero'] = $motivo_numero;
    $rowsMotivoTipo[$key]['motivos'] = $rowsMotivo;
}

/*
echo '<pre>';
print_r($rowsMotivoTipo);
exit();
*/

//$gdImage = imagecreatefrompng('');//Logotipo
//Objeto de PHPExcel
$objPHPExcel = new PHPExcel();

//Propiedades de Documento
$objPHPExcel->getProperties()
    ->setCreator("Author")
    ->setDescription("Importar Masivas");

//Establecemos la pestaña activa y nombre a la pestaña
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()
    ->setTitle("Masivas");

$estiloTituloReporte = array(
    'font' => array(
        'name' => 'Arial',
        'bold' => true,
        'italic' => false,
        'strike' => false,
        'size' => 13
    ) ,
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID
    ) ,
    'borders' => array(
        
    ) ,
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloTituloColumnas = array(
    'font' => array(
        'name' => 'Arial',
        'bold' => true,
        'size' => 10,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ) ,
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => '538DD5'
        )
    ) ,
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ) ,
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray(array(
    'font' => array(
        'name' => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ) ,
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID
    ) ,
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ) ,
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
));

/*
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:E4')
    ->applyFromArray($estiloTituloReporte);
*/


$fila = 2; //Establecemos en que fila inciara a imprimir los datos


$objPHPExcel->getActiveSheet()
    ->setCellValue('C1', 'PLANTILLA GESCOT');
$objPHPExcel->getActiveSheet()
    ->mergeCells('C1:D1');
$objPHPExcel->getActiveSheet()
->getStyle('C1')
->applyFromArray($estiloTituloReporte);


$fila++;

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('A')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('A'.$fila, 'N°');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('B')
    ->setWidth(60);
$objPHPExcel->getActiveSheet()
    ->setCellValue('B'.$fila, 'OPERADOR');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('C')
    ->setWidth(50);
$objPHPExcel->getActiveSheet()
    ->setCellValue('C'.$fila, 'TIPOS');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('D')
    ->setWidth(50);
$objPHPExcel->getActiveSheet()
    ->setCellValue('D'.$fila, 'MOTIVO');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('E')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('E'.$fila, 'MODO');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('F')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('F'.$fila, 'FECHA INICIO');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('G')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('G'.$fila, 'HORA INICIO');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('H')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('H'.$fila, 'FECHA FIN');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('I')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('I'.$fila, 'HORA FIN');


$objPHPExcel->getActiveSheet()
    ->getColumnDimension('J')
    ->setAutoSize(true);
$objPHPExcel->getActiveSheet()
    ->setCellValue('J'.$fila, 'DIAS');

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('K')
    ->setWidth(100);
$objPHPExcel->getActiveSheet()
    ->setCellValue('K'.$fila, 'OBSERVACIONES');



$objPHPExcel->getActiveSheet()
    ->getStyle('A'.$fila.':K'.$fila)
    ->applyFromArray($estiloTituloColumnas);


$fila++;

foreach (range(1,1000) as $key) {
  $objPHPExcel->getActiveSheet()
  ->setCellValue('A' . $fila, $key);

  $validation = $objPHPExcel->getActiveSheet()->getCell('B'.$fila)->getDataValidation();
  $validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
  $validation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
  $validation->setAllowBlank(true);
  $validation->setShowDropDown(true);
  $validation->setErrorTitle('Input error');
  $validation->setError('Value is not in list');
  $validation->setFormula1('Operadores!A1:A'.$operador_numero);

  $validation = $objPHPExcel->getActiveSheet()->getCell('C'.$fila)->getDataValidation();
  $validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
  $validation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
  $validation->setAllowBlank(true);
  $validation->setShowDropDown(true);
  $validation->setErrorTitle('Input error');
  $validation->setError('Value is not in list');
  $validation->setFormula1('Motivos!ref_tipos');

  
    $validation = $objPHPExcel->getActiveSheet()->getCell('D'.$fila)->getDataValidation();
    $validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
    $validation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Input error');
    $validation->setError('Value is not in list');
    $validation->setFormula1('INDIRECT(C'.$fila.')');

    $modos = "D,H";
    $validation = $objPHPExcel->getActiveSheet()->getCell('E'.$fila)->getDataValidation();
    $validation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
    $validation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Input error');
    $validation->setError('Value is not in list');
    $validation->setFormula1('"'.$modos.'"');
  
  

    //CALCULAR DIAS
    $objPHPExcel->getActiveSheet()
    ->setCellValue('J'.$fila, '=(H'.$fila.'-F'.$fila.')+1');



  $fila++;
}

$operador->data_seek(0);



$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setTitle('Operadores');
$fila = 1;
while ($rows = $operador->fetch_assoc())
{
    $objPHPExcel->getActiveSheet()
    ->setCellValue('A' . $fila, $rows['ncompleto'].' - '.$rows['dni']);
    $fila++;
}
$objPHPExcel->getSheetByName('Operadores')
    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);




$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->setTitle('Motivos');


$fila = 1;
foreach ($rowsMotivoTipo as $keyTipo => $tipo) {

    $tp_inc = preg_replace("/[^a-zA-Z0-9-\s+]+/", "", $tipo['tp_inc']);
    $tp_inc = str_replace(' ', '_', $tp_inc);

    $objPHPExcel->getActiveSheet()
    ->setCellValue('A' . $fila, $tp_inc);

    $filaMotivo = 1;
    foreach ($tipo['motivos'] as $keyMotivo => $mo) {
        $objPHPExcel->getActiveSheet()
        ->setCellValue($arrayLetrasMotivos[$keyTipo] . $filaMotivo, $mo['nom_mot_inc'].'_'.$mo['cod_mot_inc']);
        $filaMotivo++;
    }


    $objPHPExcel->addNamedRange( 
        new PHPExcel_NamedRange(
            $tp_inc, 
            $objPHPExcel->getActiveSheet(), 
            $arrayLetrasMotivos[$keyTipo].'1:'.$arrayLetrasMotivos[$keyTipo].$tipo['numero']
        ) 
    );

    $fila++;
}

//exit();

$objPHPExcel->addNamedRange( 
    new PHPExcel_NamedRange(
        'ref_tipos', 
        $objPHPExcel->getActiveSheet(), 
        'A1:A'.$motivotipo_numero
    ) 
);

$objPHPExcel->getSheetByName('Motivos')
->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);



$objPHPExcel->setActiveSheetIndex(0);


$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Plantilla_usuario_'.$id_user.'.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>
