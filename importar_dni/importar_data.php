<?php
include("../conexion_bd.php");
require '../PHPExcel/Classes/PHPExcel.php';

$usuario = $_POST['usuario'];

// Cargando la hoja de calculo
$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
$objPHPExcel = $objReader->load("./uploads/" . $_POST['archivo']); //carga en objphpExcel por medio de objReader,el nombre del archivo
$objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
// Llenamos un arreglo con los datos del archivo xlsx
$i = 3; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
$param = 0;
$contador = 0;

$array = array();
while ($param == 0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos

{
    $item['num'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
    $item['nombres'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
    $item['apellido_paterno'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
    $item['apellido_materno'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
    $item['dni'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
    $item['sexo'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
   $fecha_excel = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
    $fecha_php = PHPExcel_Shared_Date::ExcelToPHP($fecha_excel);

    // Sumar un día a la fecha PHP
    $fecha_php = strtotime('+1 day', $fecha_php);

    // Formatear la fecha resultante como Y-m-d
    $fecha_php_formateada = date('Y-m-d', $fecha_php);

    // Usar la fecha PHP corregida
    $item['fecha_nacimiento'] = $fecha_php_formateada;
    

    if ($objPHPExcel->getActiveSheet()
        ->getCell('B' . $i)->getCalculatedValue() == NULL)
    {
        $param = 1;
    }
    else
    {
        $array[] = $item;
    }
    $i++;
}



$mysqli = @new mysqli('localhost', 'root', '', 'cot');
foreach ($array as $key => $item)
{
    $sqlInsert = "INSERT INTO tb_dni (nombres,apellido_paterno,apellido_materno,dni,sexo,fecha_nacimiento,fecha_registro,usuario_registro) VALUES('".$item['nombres']."', '".$item['apellido_paterno']."', '".$item['apellido_materno']."','".$item['dni']."', '".$item['sexo']."', '".$item['fecha_nacimiento']."', '".date('Y-m-d H:i:s')."', '".$usuario."')";
    $mysqli->query($sqlInsert);
}


$response = array();
$response['success'] = true;
$response['data'] = $array;


echo json_encode($response);

?>
