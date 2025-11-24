<?php
include("../conexion_bd.php");
include ("../funciones_fechas.php");
include("../incidencia/ValidacionAlerta.php");
require '../PHPExcel/Classes/PHPExcel.php';

// Cargando la hoja de calculo
$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
$objPHPExcel = $objReader->load("./uploads/" . $_POST['archivo']); //carga en objphpExcel por medio de objReader,el nombre del archivo
$objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
// Llenamos un arreglo con los datos del archivo xlsx
$i = 4; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
$param = 0;
$contador = 0;

$array = array();
while ($param == 0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos

{
    $item['num'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
    $c_operador = explode('-',$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
    $item['operador'] = trim($c_operador[1]);
    $item['tipo'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
    
    $motivo = explode('_',$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
    $item['motivo'] = end($motivo);
   
    $item['modo'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

    $item['fecha_inicio'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()));
    $item['fecha_inicio'] = date("Y-m-d",strtotime($item['fecha_inicio']."+ 1 day"));
    $item['hora_inicio'] = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(), 'hh:mm:ss');
    $item['fecha_fin'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()));
    $item['fecha_fin'] = date("Y-m-d",strtotime($item['fecha_fin']."+ 1 day"));
    $item['hora_fin'] = PHPExcel_Style_NumberFormat::toFormattedString($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue(), 'hh:mm:ss');
    $item['dias'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
    $item['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();

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

foreach ($array as $key => $item)
{
    $codigo = insertarMasiva($item,count($array));
    $array[$key]['response'] = $codigo;
}


$response = array();
$response['success'] = true;
$response['data'] = $array;


echo json_encode($response);

function insertarMasiva($item,$numero)
{
  $mysqli = @new mysqli('119.8.147.241', 'gesdeveloper', 'G3sc0td3v#', 'cot');

  $modo_gru = $item['modo'];
  $obs_gru = $item['observaciones'];
  $dni_escogidos = $item['operador'];
  $fec_ini_inc = $item['fecha_inicio'];
  $fec_fin_inc = $item['fecha_fin'];
  if($item['modo']=='H'){
    $fec_ini_inc += ' '.$item['hora_inicio'];
    $fec_fin_inc += ' '.$item['hora_fin'];
  }
  $nro_escogidos = 1;//$numero;
  $c_mot_inc_gru = $item['motivo'];

  $sqlMotivo = "select cod_mot_inc,nom_mot_inc,tp_inc from tb_motivos_incidencia where cod_mot_inc =  $c_mot_inc_gru";
  $resMotivo = $mysqli->query($sqlMotivo);
  $assocMotivo = $resMotivo->fetch_assoc();

  $c_mot_gru = $assocMotivo['tp_inc'];
  $pc = gethostbyaddr($_SERVER['REMOTE_ADDR']);

  $iduser = $_POST["usuario"];
  $idperfil = $_POST["perfil"];
  //$xc_incidencia = limpia_espacios($_GET["c_incidencia"]);
  $c_doid_gru = '';//$item['codigo_doid'];
  $c_inc = $_GET["c_inc"];
  $opc = $_GET["opc"];
  $combo = $_GET["combo"];

  if ($idperfil == "3" or $idperfil == "2")
  { // si es supervisor estado aprobado
      $xest_inc = "1";
  }
  else
  {
      $xest_inc = "0";
  }
  $valida = "select datediff(curdate() + 1,'$fec_ini_inc')";
  $res_valida = mysql_query($valida);
  $reg_valida = mysql_fetch_row($res_valida);

  $dia = date("d");

  if ($_GET["motivo_inc"] == "154")
  {
      $nuevo_motivo = "159";
  }
  if ($_GET["motivo_inc"] == "155")
  {
      $nuevo_motivo = "156";
  }
  if ($_GET["motivo_inc"] == "157")
  {
      $nuevo_motivo = "158";
  }
  if ($_GET["motivo_inc"] == "153")
  {
      $nuevo_motivo = "160";
  }

  if ($_GET["motivo"] == "154")
  {
      $dif_tiempo_perm = $reg_dif_0[0];
  }
  else
  {
      $dif_tiempo_perm = "-" . $reg_dif_0[0];
  }

  if ($_GET["motivo_inc"] == "82")
  {
      $nuevo_motivo = "160";
  }

  if ($reg_valida[0] > 90)
  { // VALIDA SI ES MAYOR A 2 DIAS
      $error = "2-Atencion: Solo se puede registrar incidencias con 2 dias de anterioridad";
  }
  else
  {

      if ($c_mot_inc_gru == "41" and $item['modo'] == "H")
      { //Lactancia
          $f_ini_inc = explode(" ", $fec_ini_inc);
          $f_fin_inc = explode(" ", $fec_fin_inc);

          $hor_ini_inc = $f_ini_inc[1]; // captura el valor de solo la hora inicial 08:00
          $fec_inc_ant = $f_ini_inc[0]; // captura el valor de solo la fecha 2019-05-05
          $hor_fin_inc = $f_fin_inc[1]; // captura el valor de solo la hora final 10:00
          $fec_fin_inc_ = date("Y-m-d", strtotime($fec_inc_ant . "+ 1 month"));
          $fec_fin_inc = $fec_fin_inc_ . " " . $hor_fin_inc;

          $dif_1 = "select datediff('$fec_fin_inc_','$fec_inc_ant')";

          $res_dif_1 = mysql_query($dif_1);
          $reg_dif_1 = mysql_fetch_row($res_dif_1);
          $diff = $reg_dif_1[0];

          $cad = "SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";

          $rs = mysql_query($cad);
          $rg = mysql_fetch_array($rs);
          $franq = limpia_espacios($rg[0]);
          $c_incidencia = "INC-" . $franq;

          $error = "1-Nota : Fechas de Lactancia se calcula automaticamente 1 mes, el registro se hace mensual";
          $observacion = trim($obs_gru) . "#" . trim($error);


              $hor = "select * from horarios_gestores_cot
        where dni='" . $dni_escogidos . "' ORDER BY 1 DESC LIMIT 1";

              $res_hor = mysql_query($hor);

              while ($reg_hor = mysql_fetch_row($res_hor))
              {
                  $ch1 = "select * from tb_usuarios where dni='$reg_hor[0]'";

                  $res_ch1 = mysql_query($ch1);
                  $reg_ch1 = mysql_fetch_row($res_ch1);

                  $hor_r = "select * from horarios_rrhh where cod_horario='$reg_hor[5]'";

                  $res_hor_r = mysql_query($hor_r);
                  $reg_hor_r = mysql_fetch_row($res_hor_r);

                  $date1 = $fec_inc_ant;
                  $date2 = $fec_fin_inc_;

                  $d = 0;
                  for ($contador = 0;$contador < $diff + 1;$contador++)
                  {
                      $d = $d + 1;

                      $NombreDia = get_nombre_dia($date1);
                      $NombreCorto = substr($NombreDia, 0, 2);
                      $validar = Obtener_valor($NombreCorto, $reg_hor_r[7]);
                      $FEC_Ini = $date1 . " " . $reg_hor_r[5];
                      $FEC_Fin = $date1 . " " . $reg_hor_r[6]; //no cambiar
                      if ($validar == 1)
                      {
                          if ($c_mot_inc_gru == "154")
                          {
                              $tiempo_cal = "-06:00:00";
                          }
                          else
                          {
                              $tiempo_cal = "06:00:00";
                          }

                          $paramsValidacion = array(
                              "fechaInicio" => $FEC_Ini,
                              "fechaFin" => $FEC_Fin,
                              "motivo" => $c_mot_inc_gru,
                              "cipUser" => $reg_ch1[3]
                          );
                          $validacionAlertaObj = new ValidacionAlerta;
                          $responseValidacion = $validacionAlertaObj->run($paramsValidacion);

                          if (!$responseValidacion["error"])
                          {
                              if (isset($responseValidacion["fechaInicio"]))
                              {
                                  $FEC_Ini = $responseValidacion["fechaInicio"];
                              }
                              if (isset($responseValidacion["fechaFin"]))
                              {
                                  $FEC_Fin = $responseValidacion["fechaFin"];
                              }
                              $sql_inc = "INSERT INTO cab_incidencia 
                                (id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias,estado_inc,fec_mov_est,usu_mov_est) VALUES ('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini', '$FEC_Fin','$observacion','$nro_escogidos', '$c_incidencia','','$tiempo_cal','$modo_gru', '$c_doid_gru','$dni_escogidos','1','$xest_inc',now(),'$iduser')";
                              //echo $sql_inc;
                              $res_sql = mysql_query($sql_inc);
                          }
                      } // if validar
                      $date1 = date("Y-m-d", strtotime($date1 . "+ 1 days"));
                  } //cierre for
                  /***********************************/
              } // cierre while
        
          
      }
      else
      {

          if ($item['modo'] == "H")
          { // Si modo es HORAS
              $f_ini_inc = explode(" ", $fec_ini_inc);
              $f_fin_inc = explode(" ", $fec_fin_inc);

              $hor_ini_inc = $f_ini_inc[1]; // captura el valor de solo la hora inicial 08:00
              $fec_inc = $f_ini_inc[0]; // captura el valor de solo la fecha 2019-05-05
              $hor_fin_inc = $f_fin_inc[1]; // captura el valor de solo la hora final 10:00
              $cad = "SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
              //echo $cad;
              $rs = mysql_query($cad);
              $rg = mysql_fetch_array($rs);
              $franq = limpia_espacios($rg[0]);
              $c_incidencia = "INC-" . $franq;


                  //validar_incidencia($dni_escogidos[$i],$fec_ini_inc,$fec_fin_inc,$c_mot_inc_gru);
                  /* tranformo las fechas de horario */
                  $c0 = "select * from horarios_gestores_cot where dni='" . $dni_escogidos . "' ORDER BY 1 DESC LIMIT 1";
                  //echo "<br>".$c0;
                  $res_c0 = mysql_query($c0);
                  $reg_c0 = mysql_fetch_row($res_c0);

                  $hor_ini_horario = $reg_c0[8];
                  
                  $hor_fin_horario = $reg_c0[9];
                  if ($reg_c0[5] == "")
                  { // Si gestor se encuentra sin horario
                      $dif_tiempo = "00:00";
                      $error = "2-Nota: Sin horarios registrado";
                      $xest = 3;

                  }
                  else
                  { // GESTORES CON HORARIOS
                      // calcular el valor de la diferencia de fechas
                      $calc = "select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_inc','$fec_fin_inc'))*60) as dif";
                      $res_calc = mysql_query($calc);
                      $reg_calc = mysql_fetch_row($res_calc);

                      if ($c_mot_inc_gru == "154")
                      {
                          $dif_tiempo = "-" . $reg_calc[0];
                      }
                      else
                      {
                          $dif_tiempo = $reg_calc[0];
                      }

                      $xest = 0;

                      if ($hor_ini_inc <= $hor_ini_horario and $hor_fin_inc >= $hor_fin_horario)
                      { // fuera de rango al inicio y al final
                          $error = "0-Nota: Rango de fecha de incidencias exceden a las fechas de su horario";
                      }
                      else
                      {
                          if ($hor_ini_inc <= $hor_ini_horario and $hor_fin_inc <= $hor_ini_horario)
                          { // antes del horario
                              $error = "0-Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";
                          }
                          else
                          { // dentro del rango inicial
                              if ($hor_ini_inc <= $hor_ini_horario and $hor_fin_inc <= $hor_fin_horario)
                              { //fuera de rango al incio
                                  $error = "0-Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";
                              }
                              else
                              {
                                  if ($hor_ini_inc >= $hor_ini_horario and $hor_fin_inc >= $hor_fin_horario)
                                  { // fuera de rango final
                                      $error = "0-Nota: Rango de fecha Final de incidencias exceden a las fechas Final de su horario";
                                  }
                                  else
                                  { // dentro del rango
                                      $error = "1-Nota : Fechas de incidencias dentro de las fechas de horarios";
                                  }
                              }
                          }
                      }
                  } //cerrar if
                  $paramsValidacion = array(
                      "fechaInicio" => $fec_ini_inc,
                      "fechaFin" => $fec_fin_inc,
                      "motivo" => $c_mot_inc_gru,
                      "dniUser" => $dni_escogidos,
                      "modo" => $item['modo']
                  );
                  $validacionAlertaObj = new ValidacionAlerta;
                  $responseValidacion = $validacionAlertaObj->run($paramsValidacion);
                  if (!$responseValidacion["error"])
                  {
                      if (isset($responseValidacion["fechaInicio"]))
                      {
                          $fec_ini_inc = $responseValidacion["fechaInicio"];
                      }
                      if (isset($responseValidacion["fechaFin"]))
                      {
                          $fec_fin_inc = $responseValidacion["fechaFin"];
                      }
                      $observacion = trim($obs_gru) . "#" . trim($error);
                      $sql_inc = "INSERT INTO cab_incidencia
                      (id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,
                      tiempo,modo,cod_incidencia,c_doid,dni,dias,nro_participantes,estado_inc,fec_mov_est,usu_mov_est)
                  VALUES	
                      ('','$cip',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$fec_ini_inc','$fec_fin_inc','$observacion',
                      '$dif_tiempo','$modo_gru','$c_incidencia',
                      '$c_doid_gru','$dni_escogidos','0','$nro_escogidos','$xest_inc',now(),'$iduser')";
                      //echo "<br>".$sql_inc;
                      $res_1 = mysql_query($sql_inc);

                      $msn_inc = "SE REGISTRO LA INCIDENCIA PARA " . $cip . " con codigo incidencia " . $c_incidencia . "|$c_mot_gru - $c_mot_inc_gru";

                      $sql_2 = "INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,dato,pc)
                  VALUES(LAST_INSERT_ID(),'REGISTRO INCIDENCIA','$iduser',now(),'$msn_inc','$cip','$pc_asig')";
                      //echo $sql_3;
                      $res_2 = mysql_query($sql_2);

                      $sql_3 = "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
                      $sql_3 = mysql_query($sql_3) or die(mysql_error());

                      $sql_4 = "update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and a.dni='$dni_escogidos' 
                  and a.cod_incidencia='$c_incidencia'";
                      //echo $sql_4;
                      $res_4 = mysql_query($sql_4);
                  }
             
              
          }
          else
          { // modo DIAS
              /*
              echo "<br>"."fec.total.ini.incidencia = ".$fec_ini_inc;
              echo "<br>"."fec.total.fin.incidencia= ".$fec_fin_inc;
              */
              //Calculo de la marcha blanca
              if ($c_mot_inc_gru == "800")
              {
                  $fec_ini_inc = $item['fecha_inicio'];
                  $fec_fin_inc = date("Y-m-d", strtotime($item['fecha_inicio'] . "+ 2 month"));
              }
              else
              {
                  $fec_ini_inc = $item['fecha_inicio'];
                  $fec_fin_inc = $item["fecha_fin"];
              }
              //echo $c_mot_inc_gru."|".$modo_gru."|".$fec_ini_inc."|".$fec_fin_inc;
              //if ($fec_ini_inc > $fec_fin_inc){ //Ricardo Flores
              if ($fec_ini_inc > $fec_fin_inc)
              { //Ricardo Flores
                  $error = "0-Nota: La fecha inicial es mayor que la fecha final"; //Ricardo Flores
                  
              }
              else
              { //Ricardo Flores
                  $error = "1-Nota : Fechas de incidencias dentro de las fechas de horarios";
                  $observacion = trim($obs_gru) . "#" . trim($error);

                  if ($fec_ini_inc == $fec_fin_inc)
                  {
                      $dif_1 = "select 0";

                  }
                  else
                  {
                      $dif_1 = "select datediff('$fec_fin_inc','$fec_ini_inc')";

                  }
                  //echo $dif_1;
                  $res_dif_1 = mysql_query($dif_1);
                  $reg_dif_1 = mysql_fetch_row($res_dif_1);
                  $diff = $reg_dif_1[0];
                  $cad = "SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
                  //echo $cad;
                  $rs = mysql_query($cad);
                  $rg = mysql_fetch_array($rs);
                  $franq = limpia_espacios($rg[0]);
                  $c_incidencia = "INC-" . $franq;


                      $hor = "select * from horarios_gestores_cot where dni='" . $dni_escogidos . "' ORDER BY 1 DESC LIMIT 1";
                      //echo "<br>".$hor;
                      $res_hor = mysql_query($hor);

                      while ($reg_hor = mysql_fetch_row($res_hor))
                      {
                          $ch1 = "select * from tb_usuarios where dni='$reg_hor[0]'";
                          //echo $ch1;
                          $res_ch1 = mysql_query($ch1);
                          $reg_ch1 = mysql_fetch_row($res_ch1);

                          $hor_r = "select * from horarios_rrhh where cod_horario='$reg_hor[5]'";
                          //echo $hor_r;
                          $res_hor_r = mysql_query($hor_r);
                          $reg_hor_r = mysql_fetch_row($res_hor_r);
                          /************************************/

                          $date1 = $fec_ini_inc;
                          $date2 = $fec_fin_inc;

                          //echo "<br>dif.dias=".$diff;
                          $d = 0;
                          for ($contador = 0;$contador < $diff + 1;$contador++)
                          {
                              $d = $d + 1;

                              $NombreDia = get_nombre_dia($date1);
                              $NombreCorto = substr($NombreDia, 0, 2);
                              $validar = Obtener_valor($NombreCorto, $reg_hor_r[7]);
                             
                              $FEC_Ini = $date1 . " " . $reg_hor_r[5];
                              $FEC_Fin = $date1 . " " . $reg_hor_r[6]; //no cambiar
                              //echo "<br>".$NombreCorto."|".$reg_hor_r[7]."|";
                              //echo "fechaini".$FEC_Ini."|";
                              //echo "fechafin".$FEC_Fin."|";
                              //echo "<BR>".$validar."|";
                              if ($c_mot_inc_gru == "154")
                              {
                                  $tiempo_cal = "-06:00:00";
                              }
                              else
                              {
                                  $tiempo_cal = "06:00:00";
                              }

                              if ($validar == "1")
                              {
                                  $paramsValidacion = array(
                                      "fechaInicio" => $FEC_Ini,
                                      "fechaFin" => $FEC_Fin,
                                      "motivo" => $c_mot_inc_gru,
                                      "cipUser" => $reg_ch1[3]
                                  );
                                  $validacionAlertaObj = new ValidacionAlerta;
                                  $responseValidacion = $validacionAlertaObj->run($paramsValidacion);

                                  if (!$responseValidacion["error"])
                                  {
                                      if (isset($responseValidacion["fechaInicio"]))
                                      {
                                          $FEC_Ini = $responseValidacion["fechaInicio"];
                                      }
                                      if (isset($responseValidacion["fechaFin"]))
                                      {
                                          $FEC_Fin = $responseValidacion["fechaFin"];
                                      }
                                      $sql_inc = "INSERT INTO cab_incidencia
                                  (id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
                                  fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,										
                                  c_doid,dni,dias,estado_inc,fec_mov_est,usu_mov_est)
                                  VALUES	
                                  ('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini',																								
                                  '$FEC_Fin','$observacion','$nro_escogidos',
                                  '$c_incidencia','','$tiempo_cal','$modo_gru',
                                  '$c_doid_gru','$dni_escogidos','1','$xest_inc',now(),'$iduser')";
                                      //echo $sql_inc;
                                      $res_sql = mysql_query($sql_inc);
                                  }
                              } // if validar
                              $date1 = date("Y-m-d", strtotime($date1 . "+ 1 days"));
                          } //cierre for
                          /***********************************/
                      } // cierre while
                      
                 
                  
              } //Ricardo Flores
              $error = "1-Nota : Fechas de incidencias dentro de las fechas de horarios";

          } // cerrar if modo_gru
          
      } // cerrar if de lactancia
      
      $response_insert = array();
      $response_insert['c_incidencia'] = $c_incidencia;
      $response_insert['error'] = $error;
      return $response_insert;
  } // cerrar if tiempo
  $pason = "delete from lista_gestores_inc where cod_incidencia='$c_incidencia'";
  //echo "<br>".$i.$paso2;
  $res_pason = mysql_query($pason);
}

?>
