<?php
include("../incidencia/ValidacionAlerta.php");
include("../conexion_bd.php");
require '../PHPExcel/Classes/PHPExcel.php';


$response = array();

if ($_FILES['archivo_excel']["error"] > 0) {
  //echo "Error: " . $_FILES['archivo_excel']['error'] . "<br>";
  $response['mensaje'] = $_FILES['archivo_excel']['error'];
  $success = false;
  return;
}else{

  $ext = pathinfo($_FILES['archivo_excel']['name'], PATHINFO_EXTENSION);
  $nombre = date('Y-m-d').'_'.date('His').'.'.$ext;
  move_uploaded_file($_FILES['archivo_excel']['tmp_name'],"./uploads/".$nombre);
  $success = true;
  
}

if($success==false){
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
}


if($success==true)
{
  // Cargando la hoja de calculo
  $objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
  $objPHPExcel = $objReader->load("./uploads/".$nombre); //carga en objphpExcel por medio de objReader,el nombre del archivo
  $objFecha = new PHPExcel_Shared_Date();
  
  // Asignar hoja de excel activa
  $objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
  
  // Llenamos un arreglo con los datos del archivo xlsx
  $i = 4; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
  $param=0;
  $contador=0;
  
  $arrayErrores = array();
  $mensaje = '';
  $array = array();
  while($param == 0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
  {
    if($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()==NULL){
      $param = 1;
    }else{
      $mysqli = @new mysqli('119.8.147.241', 'gesdeveloper', 'G3sc0td3v#', 'cot');
      $item['num'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
      
      $operador = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
      if($operador == '' || $operador == null){
        $arrayErrores[] = true;
        $mensaje .= 'En la fila ' . $item['num'] . ' no ha seleccionado operador <br>';
      }else{
        $operador = explode('-',$operador);
        $item['operador'] = trim($operador[1]);
      }


      $motivo = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
      if($motivo=='' || $motivo == null){
        $arrayErrores[] = true;
        $mensaje .= 'En la fila ' . $item['num'] . ' no ha seleccionado motivo <br>';
      }else{
        $motivo = explode('_',$motivo);
        $item['motivo'] = end($motivo);
        $motivo = $item['motivo'];
  
        $sqlMotivo = "select cod_mot_inc,nom_mot_inc,tp_inc from tb_motivos_incidencia where cod_mot_inc =  $motivo";
  
        $resMotivo = $mysqli->query($sqlMotivo);
        $assocMotivo = $resMotivo->fetch_assoc();
  
        $item['tipo'] = $assocMotivo['tp_inc'];
      }
      
      $item['modo'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
      if($item['modo'] == "" || $item['modo'] == null){
        $arrayErrores[] = true;
        $mensaje .= 'En la fila ' . $item['num'] . ' no ha seleccionado modo <br>';
      }

      $item['fecha_inicio'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()));
      $item['fecha_inicio'] = date("Y-m-d",strtotime($item['fecha_inicio']."+ 1 day"));
      $item['hora_inicio'] = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(), 'hh:mm:ss');
      $item['fecha_fin'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()));
      $item['fecha_fin'] = date("Y-m-d",strtotime($item['fecha_fin']."+ 1 day"));
      $item['hora_fin'] = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue(), 'hh:mm:ss');
      $item['dias'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
      $item['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();


      $array[] = $item;
    }
    $i++;
  }
}


$error = (in_array(true, $arrayErrores));

if($error){
  $response['mensaje'] = $mensaje;
  $response['success'] = false;
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
  exit();
}



$validacionAlertaObj = new ValidacionAlerta;

$validacionAlerta = array();


$arrayErrores = array();
foreach ($array as $key => $value) {
  $paramsValidacion = array(
      "fechaInicio" => $value['fecha_inicio'].' 00:00:00',
      "fechaFin"	=>	$value['fecha_fin']. ' 00:00:00',
      "motivo"	=> $value['motivo'],
      "dniUser"	=> $value['operador'],
      "modo"	=>	$value['modo']
  );
  $responseValidacion = $validacionAlertaObj->run($paramsValidacion);
  $validacionAlerta[$key] = $responseValidacion;
  $validacionAlerta[$key]['numero'] = $key + 1;
  $arrayErrores[] = $responseValidacion['error'];
}


$error = (in_array(true, $arrayErrores));

$mensaje = '';
if($error){
  foreach ($validacionAlerta as $key => $value) {
    if($value['error']){
      $mensaje .= 'En la fila ' . $value['numero'] . ' '. $value['message'].'<br>';
    }
  }
}

$response['validacion'] = $validacionAlerta;
$response['archivo'] = $nombre;
$response['mensaje'] = $mensaje;
$response['success'] = $error?false:true;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

?>