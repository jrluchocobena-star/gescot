<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion_bd.php");
//include("funciones_fechas.php");
set_time_limit(2000);


$conn = db_conn();



$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$u_reg=$_GET["u_reg"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];
$estado=$_GET['estado'];
$supervisor=$_GET['supervisor'];

/*
$iduser=1;
$perfil=2;
$c_inc=3;
$gestor=4;
$u_reg=156;
$fec_i='2025-01-01';
$fec_f='2025-11-01';
$estado=1;
$supervisor='';
*/

//echo "<input name='iduser' type='hidden' class='casilla_texto' id='iduser' value='$iduser'/>";

if ($c_inc=="" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
	if($perfil!=1){
		$cad="";
	} else {
		$cad=" and  usu_reg='$iduser'";
	}
}else{

	if ($c_inc<>"" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
		if($perfil!=1){
			$cad=" and  cod_incidencia='$c_inc'";
		} else {
			$cad=" and  cod_incidencia='$c_inc' and  usu_reg='$iduser'";
		}
		}else{
			if ($c_inc=="" and $gestor=="0" and $u_reg=="0"){
				if($perfil!=1){
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
				} else {
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f' and  usu_reg='$iduser'";
				}
			}else{
				if ($c_inc=="" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
					$cad=" and  dni='$gestor'";	
				}else{
					if ($c_inc=="" and $u_reg=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0"){
						$cad=" and  dni='$gestor' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
					}else{
						if ($u_reg<>"0" and $c_inc=="" and $gestor=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0" ){
							$cad=" and  usu_reg='$u_reg' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";								 					}else{		
							$cad=" and usu_reg='$u_reg'";						
						}
					}
					
				}
			}
		}
}


if($estado!='Todos'){
	$cad =  $cad ." AND estado_inc = '" . $estado . "'";
}

//echo $cad;


if($supervisor!='Todos'){
	//$cad = $cad ." AND lider.iduser = " .$supervisor;
}

/*
$lista="SELECT  * FROM cab_incidencia inc 
INNER JOIN tb_usuarios usu ON  dni = usu.dni
INNER JOIN tb_usuarios lider ON usu.c_supervisor = lider.iduser
WHERE tp_incidencia NOT IN ('MONITOREO Y CAPACITACION COT') ".$cad." AND  fec_reg >= DATE_SUB(NOW(), INTERVAL 365 DAY) GROUP BY cod_incidencia, tp_incidencia";
*/



$sql = "select * from cab_incidencia where substr(fec_reg,1,4)='2025'".$cad." GROUP BY cod_incidencia,dni";
//echo $sql;
$resultados = mysql_query($sql);
    
    $var .= "DNI".";"."GESTOR COT".";"."FECHA REGISTRO".";"."C.INDICENCIA".";"."TP.INCIDENCIA".";"."MOTIVO".";"."FEC.INICIO".";"."FEC.FIN".";"
        ."DOID".";"."REGISTRADO POR".";"."MODO".";" ."TIEMPO".";"."OBSERVACION".";"."FECHA APROBACION".";"."LIDER/SUPERVISOR".";"."ESTADO".";"."USU.RECHAZO".";"."FEC.RECHAZO"
        .";"."MOT.RECHAZO".";"."TIEMPO MIN".";"."USU.EDICION".";"."USU.APROBADO".";"."FEC.CANCELADO".";"."USU.CANCELADO;"."\n";

$con = 0;
while ($reg = mysql_fetch_array($resultados))
{
   $con = $con + 1;
    
   $q1="select * from tb_motivos_incidencia where tp_inc ='$reg[tp_incidencia]' and cod_mot_inc='$reg[motivo_incidencia]'";
   $res1 = mysql_query($q1);
   $reg1 = mysql_fetch_array($res1);
    
   $q2="select * from tb_usuarios where dni='$reg[dni]'";
   $res2 = mysql_query($q2);
   $reg2 = mysql_fetch_array($res2);
    
   $q3="select * from tb_usuarios where iduser='$reg[usu_mov_est]'";
   $res3 = mysql_query($q3);
   $reg3 = mysql_fetch_array($res3);
    
   $q4="select * from tb_usuarios where iduser='$reg[usu_rechazo]'";
   $res4 = mysql_query($q4);
   $reg4 = mysql_fetch_array($res4);
    
   $q5="select * from tb_usuarios where iduser='$reg[usu_cancelado]'";
   $res5 = mysql_query($q5);
   $reg5 = mysql_fetch_array($res5);
    
   $q6="select * from tb_usuarios where iduser='$reg[usu_aprobado]'";
   $res6 = mysql_query($q6);
   $reg6 = mysql_fetch_array($res6);
    
   $q7="select * from tb_estados_incidencia where cod_estado='$reg[estado_inc]'";
   $res7 = mysql_query($q7);
   $reg7 = mysql_fetch_array($res7);
    
    
   $q8="select * from tb_usuarios where iduser='$reg2[c_supervisor]'";
   $res8 = mysql_query($q8);
   $reg8 = mysql_fetch_array($res8);
    
   $q9="select * from tb_usuarios where iduser='$reg[usu_reg]'";
   $res9 = mysql_query($q9);
   $reg9 = mysql_fetch_array($res9);
    
   $q10="select * from tb_usuarios where iduser='$reg[usu_mov_est]'";
   $res10 = mysql_query($q10);
   $reg10 = mysql_fetch_array($res10);

   $obs = limpia_cadena($reg["obs_incidencia"]);
   $observacion = limpiarCaracteres($obs); 
    
   $var .= $reg["dni"].";".$reg2["ncompleto"].";".$reg["fec_reg"].";".$reg["cod_incidencia"].";".$reg["tp_incidencia"].";".$reg1["nom_mot_inc"].";".$reg["fec_ini_inc"].";".$reg["fec_fin_inc"].";".$reg["c_doid"].";".$reg9["ncompleto"].";".$reg["modo"].";".$reg["tiempo"].";".$observacion.";".$reg["fec_aprobado"].";".$reg8["ncompleto"].";".$reg7["estado"].";".$reg4["ncompleto"].";".$reg["fec_rechazo"].";".$reg["mot_rechazo"].";".$reg["tt_min"].";".$reg["usu_mov_est"].";".$reg6["ncompleto"].";".$reg["fec_cancelado"].";".$reg["usu_cancelado"]."\n";

   /* Formamos una cadena con los datos separados por punto y coma,
   * y le concatenamos el salto de linea, para diferenciar entre un registro y otro.
   */

}
//aqui le decimos al navegador que vamos a enviar a un archivo del tipo CSV
header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=archivo.csv");
echo $var;

?>
