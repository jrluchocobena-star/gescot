<?php 
include("conexion_bd.php");


function diff_sinp($fecha1,$fecha2,$tiempo1,$tiempo2){
   $dif = date("H:i", strtotime("00:00") + strtotime($tiempo2) - strtotime($tiempo1));
   /*
   if($dif == '00:00'){
      $dif = null;
   }
   $difd = date_diff(date_create($fecha1),date_create($fecha2));
   $difd = $difd->format('%a');
   */
   return rtrim($dif);
   //return $difd;
}

function dif_horas($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i",mktime($difh,$difm));
}


$accion=$_GET["accion"];
//$iduser=$_GET["iduser"];


if ($accion=="buscar_gestor"){
	$dni = $_GET["dni"];	
	$cip = $_GET["cip"];	
	$nombre = $_GET["nombre"];	
	$opc = $_GET["opc"];	
	
	if($opc==0){	
	$sql="select * from tb_usuarios order by ncompleto asc";	
	}
	
	if($opc==1){	
	$sql="select * from tb_usuarios where ncompleto like '%$nombre%' order by ncompleto asc";	
	}
	
	if($opc==2){	
	$sql="select * from tb_usuarios where dni='$dni' limit 1";
	}
	
	if($opc==3){
		/*	
	$sql="select * from tb_usuarios where ncompleto like'%$nombre%' 
	or dni='$dni' or cip='$cip'  order by ncompleto asc";	
	*/
	$sql="select * from tb_usuarios where cip like '%$cip%' limit 1";
	}
	
	//	echo $opc.$sql;
	
	$res_lis = mysql_query($sql);
	//$reg_lis = mysql_fetch_row($res_lis);
	
	echo "<table width='100%'>";				
			echo "<tr>";					
			echo "<td class='cabeceras_grid'>ITEM</td>";		
			echo "<td class='cabeceras_grid'>NOMBRE</td>";		
			echo "<td class='cabeceras_grid'>DNI </td>";																		
			echo "<td class='cabeceras_grid'>CIP </td>";											
			echo "</tr>";
	
	$con=0;
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
	
	/*
			$a="SELECT CONCAT(LPAD(SUM(STR_TO_DATE(tiempo, '%H')),2,'0'), ':',LPAD(SUM(STR_TO_DATE(tiempo, '%i')),2,'0')) 
FROM programacion_extra  where dni='$reg_lis[2]'";
			//echo $a;
			$rs_a = mysql_query($a);											
			$rg_a = mysql_fetch_row($rs_a);
			
			if ($rg_a[0]==""){
				$tt_acu="00:00";
			}else{				
				$tt_acu=$rg_a[0];
			}
			
			$b="SELECT CONCAT( LPAD(SUM(STR_TO_DATE(tiempo_comp, '%H')),2,'0'), ':',LPAD(SUM(STR_TO_DATE(tiempo_comp, '%i')),2,'0')) 
FROM compensacion_extra where dni='$reg_lis[2]'";
			//echo $b;
			$rs_b = mysql_query($b);											
			$rg_b = mysql_fetch_row($rs_b);
			
			if ($rg_b[0]==""){
				$tt_comp="00:00";
			}else{
				$tt_comp=$rg_b[0];
				}
			
			
						
		$dif_h= substr($tt_comp,1,1) - substr($tt_acu,1,2);
		$dif_m= substr($tt_comp,4,2) - substr($tt_acu,4,2);
		
		if ($dif_h<10){
			$dif_h = str_pad($dif_h,2,"0",STR_PAD_LEFT);
		}else{
			$dif_h = $dif_h;	
		}
		
		if ($dif_m<10){
			$dif_m = str_pad($dif_m,2,"0",STR_PAD_LEFT);
		}else{
			$dif_m = $dif_m;	
		}
		*/
		
		$a="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))) TotalHoras
		FROM programacion_extra where dni='$reg_lis[2]'";
			//echo $a;
		$rs_a = mysql_query($a);											
		$rg_a = mysql_fetch_row($rs_a);
		
			if ($rg_a[0]==""){
				$dif="00:00";
			}else{
				$dif=$rg_a[0];
			}
				
		echo "<tr>";	
		
		echo "<td class='txt_normal'>";
		echo $con=$con+1; 			
		echo "</td>";	

		echo "<td class='txt_normal'>";
		?>
        
		<a href="javascript:mostrar_botonera('<?php echo $reg_lis[2] ?>','<?php echo $reg_lis[3] ?>',
        '<?php echo $reg_lis[1]?>','<?php echo $dif; ?>')">			
		<?php
		echo "$reg_lis[1]</a>" ;
        echo "</td>";	

		
		echo "<td class='txt_normal'>";
		echo $reg_lis[2]; 			
		echo "</td>";	
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[3]; 			
		echo "</td>";		
		
		echo "</tr>";				
	}	
	echo "</table>";
}

if ($accion=="calcular_tiempo"){	
	
	$modo=$_GET["modo"];	
	$factor=$_GET["factor"];	
			
			$fec=$_GET["fec"];	
			$fec_=substr($fec,6,4)."-".substr($fec,3,2)."-".substr($fec,0,2)." ".substr($fec,11,8);
			
	
	if ($modo=="D"){
		
			$hor_ini="08:00";	
			$hor_fin="16:30";	
			
			$fec_ini=$fec_." ".$hor_ini;
			$fec_fin=$fec_." ".$hor_fin;			
			
			$calc="select SEC_TO_TIME(((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin'))*$factor)*60) as dif";
			//echo $calc;
			
			$rs_calc = mysql_query($calc);											
			$rg_calc = mysql_fetch_row($rs_calc);	
			$tt="08:30:00";	
	
	}else{			
			
			$hor_ini=$_GET["hor_ini"];	
			$hor_fin=$_GET["hor_fin"];	
			
			$fec_ini=$fec_." ".$hor_ini;
			$fec_fin=$fec_." ".$hor_fin;
			
			
			$calc="select SEC_TO_TIME(((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin'))*$factor)*60) as dif";
			//echo $calc;
			$rs_calc = mysql_query($calc);											
			$rg_calc = mysql_fetch_row($rs_calc);	
			
			$calc1="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin'))*60) as dif";
			//echo $calc;
			$rs_calc1 = mysql_query($calc1);											
			$rg_calc1 = mysql_fetch_row($rs_calc1);	
			$tt		  = $rg_calc1[0];
	}
	
	$ndia = get_nombre_dia($fec);
	
	echo $rg_calc[0]."|".$ndia."|".$tt;
	
}

if ($accion=="calcular_compensacion"){	
	
	$dni			=$_GET["dni"];	
	$modo			=$_GET["modo"];	
	$fec_ini		=$_GET["fec_ini"];	
	$tt_acumulado	=$_GET["tt_acumulado"];	
	$tt_restante	=$_GET["tt_restante"];	
	$tt_compensando	=$_GET["tt_compensando"];	
	$t_comp_a		=$_GET["t_comp_a"];
	$t_saldo_a		=$_GET["t_saldo_a"];	
	
	if ($modo=="D"){
		$t_comp		= "08:30"; 
//		$t_restante	= $tiempo_a - (float)$t_comp; 
		$t_restante = dif_horas($tt_restante,$t_comp_a);
	
	}else{			
			$fec_=substr($fec_ini,6,4)."-".substr($fec_ini,3,2)."-".substr($fec_ini,0,2)." ".substr($fec_ini,11,8);
			
			$hor_ini=$_GET["hor_ini"];	
			$hor_fin=$_GET["hor_fin"];	
			
			
			//$t_comp = diff_horas($hor_ini,$hor_fin);		
			//$t_comp = date("H:i", strtotime("00:00") + strtotime($hor_fin) - strtotime($hor_ini));
			$t_comp = dif_horas($hor_ini,$hor_fin);			
			
			
	}
	
	//$t_restante = dif_horas($tiempo_r,$tiempo_a);
	
	
	$t_dif = ($tiempo_c + $tiempo_r) ;	
		
	echo $t_comp."|".$t_restante."|".$t_dif;
	
}

if ($accion=="calcular_tiempo_capa"){	
	
	$modo=$_GET["modo"];	
	
	$fec_ini=$_GET["fec_ini"];	
	$fec_ini=substr($fec_ini,6,4)."-".substr($fec_ini,3,2)."-".substr($fec_ini,0,2)." ".substr($fec_ini,11,8);
			
	
	if ($modo=="D"){
		
		$fec_ini=$_GET["fec_ini"];	
		//$fec_ini=substr($fec_ini,6,4)."-".substr($fec_ini,3,2)."-".substr($fec_ini,0,2)." ".substr($fec_ini,11,8);
	
		$fec_fin=$_GET["fec_fin"];	
		//$fec_fin=substr($fec_fin,6,4)."-".substr($fec_fin,3,2)."-".substr($fec_fin,0,2)." ".substr($fec_fin,11,8);
		
			$ss="select DATEDIFF('$fec_fin','$fec_ini')";
			$rs_ss = mysql_query($ss);											
			$rg_ss = mysql_fetch_row($rs_ss);
		
		
			$hor_ini="08:00";	
			$hor_fin="16:30";	
			
			$fec_ini_=$fec_ini." ".$hor_ini;
			$fec_fin_=$fec_fin." ".$hor_fin;			
			
			$calc="SELECT SEC_TO_TIME(($rg_ss[0]+1)*8.5*3600) AS dif";
			//echo $calc;
			
			$rs_calc = mysql_query($calc);											
			$rg_calc = mysql_fetch_row($rs_calc);	
			$tt="08:30:00";	
	}else{			
			$fec_=$_GET["fec"];	
			$fec_=substr($fec_,6,4)."-".substr($fec_,3,2)."-".substr($fec_,0,2)." ".substr($fec_,11,8);
			
			$hor_ini=$_GET["hor_ini"];	
			$hor_fin=$_GET["hor_fin"];	
			
			$fec_ini=$fec_." ".$hor_ini;
			$fec_fin=$fec_." ".$hor_fin;
			
			
			$calc="select SEC_TO_TIME(((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin')))*60) as dif";
			//echo $calc;
			$rs_calc = mysql_query($calc);											
			$rg_calc = mysql_fetch_row($rs_calc);				
			$tt		  = $rg_calc[0];
	}
	
	$ndia = get_nombre_dia($fec);
	
	echo $rg_calc[0]."|".$ndia."|".$tt;
	
}

if ($accion=="grabar_incidencia_comp"){
	
	$iduser=$_GET["iduser"];
	$dni=$_GET["dni"];
	$tp_incidencia=$_GET["tp_incidencia"];
	$factor=$_GET["factor"];
	$modo=$_GET["modo"];
	$factor=$_GET["factor"];
	$tiempo = $_GET["tiempo"];
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	$tt_c	=$_GET["tt_c"];	
		
	
	$obs=quitar_tildes($_GET["obs"]);

	
	
	$sql_1="INSERT INTO programacion_extra(id,dni,usu_reg,	
	fec_reg,tp_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,factor,est_prog,tiempo_sf)
	VALUES 
	(LAST_INSERT_ID(),'$dni','$iduser',now(),'$tp_incidencia','$fec_ini_','$fec_fin_','$obs','$tiempo','$modo','$factor','PENDIENTE',
	'$tt_c')";
	echo "<br>".$sql_1;	
	$res_1= mysql_query($sql_1) or die(mysql_error());	
	
	/**************************************************/
	/*
	$dia=date("Y-m-d");
	
	$cad=" SELECT LAST_INSERT_ID() from cab_programacion_extra";
	$rs = mysql_query($cad) or die(mysql_error());
	$rg = mysql_fetch_array($rs);
	$idfranqueo="CORR-".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);
	echo $idfranqueo; 	
	
	$cad_1="update cab_programacion_extra set correlativo='$idfranqueo' where id='$rg[0]'";
	$rs_1 = mysql_query($cad_1) or die(mysql_error());
			
	
	$sql_2="INSERT INTO det_programacion_extra(id,correlativo,dni,estado,tipo,motivo,usu_mov,fec_mov,fec_ini_inc,fec_fin_inc,
	tiempo_inc,modo_inc,fec_ini_comp,fec_fin_comp,tiempo_comp,modo_comp,obs)
	VALUES(LAST_INSERT_ID(),'$idfranqueo','$dni','REGISTRADO','PROGRAMAR','$tp_incidencia','$iduser',now(),'$fec_ini_','$fec_fin_','$tiempo_t',
	'$modo','','','','','$obs')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	*/	
}

if ($accion=="grabar_compensaciones"){

	$iduser		=$_GET["iduser"];	
	$dni		=$_GET["dni"];	
	$modo		=$_GET["modo"];	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	

	$tiempo_a	= limpia_espacios($_GET["tiempo_a"]);
	
	
	$sql_1="INSERT INTO compensacion_extra(id,dni,usu_reg,fec_reg,fec_ini_comp,fec_fin_comp,tiempo_comp,modo_comp,obs)
	VALUES(LAST_INSERT_ID(),'$dni','$iduser',now(),'$fec_ini_','$fec_fin_','$tiempo_a','$modo','$obs')";	
	$res_1= mysql_query($sql_1);	
	//echo $sql_1;
	
	echo "Se registro la compensacion correctamente";	
	
}




?>
