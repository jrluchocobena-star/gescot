<?php
require '../PHPExcel/Classes/PHPExcel.php';


$response = array();

if ($_FILES['archivo_excel_dni']["error"] > 0) {
  $response['mensaje'] = $_FILES['archivo_excel_dni']['error'];
  $success = false;
  return;
}else{

  $ext = pathinfo($_FILES['archivo_excel_dni']['name'], PATHINFO_EXTENSION);
  $nombre = date('Y-m-d').'_'.date('His').'.'.$ext;
  move_uploaded_file($_FILES['archivo_excel_dni']['tmp_name'],"./uploads/".$nombre);
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
  $i = 3; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
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
      $item['num'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
      
      $apellido_paterno = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
      if($apellido_paterno == '' || $apellido_paterno == null){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el apellido paterno no puede ser vacío </div>';
      }

      $apellido_materno = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
      if($apellido_materno == '' || $apellido_materno == null){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el apellido materno no puede ser vacío </div>';
      }
      
      $dni = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
      if($dni == '' || $dni == null){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el DNI está vacío</div>';
      }
      
      if(strlen($dni)!=8){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el DNI debe ser de 8 dígitos </div>';
      }

      $sexo = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
      if($sexo == '' || $sexo == null){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el sexo está vacío </div>';
      }
      if($sexo!='M' && $sexo != 'F'){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' el sexo es incorrecto </div>';
      }

      $fec_nac = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
      if($fec_nac == '' || $fec_nac == null){
        $arrayErrores[] = true;
        $mensaje .= '<div class="error-carga-dni">En la fila ' . $item['num'] . ' la fecha de nacimiento está vacía</div>';
      }

      $item['nombres'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
      $item['apellido_paterno'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
      $item['apellido_materno'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
      $item['dni'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
      $item['sexo'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
      $item['fecha_nacimiento'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()));


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

$response['archivo'] = $nombre;
$response['mensaje'] = $mensaje;
$response['success'] = $error?false:true;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

?>