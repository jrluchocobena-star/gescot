<?php


$f_actual=date("Y-m-d");
$n_archivo="rep_incidencias_cot_".$f_actual.".xls";

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=".$n_archivo);


include("conexion_bd.php");
include("funciones_fechas.php");


/************************************************************************/

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$cip=trim($_GET["cip"]);
$xano=$_GET["xano"];
$xmes=$xano."-".trim($_GET["xmes"]);
$supervisor=trim($_GET["supervisor"]);

if ($_GET["xmes"]=="0"){
	$cri=$_GET["xano"];	
	$cad="SUBSTR(fec_ini_inc,1,4)='$cri'";
}else{
	$cri=$xano."/".$_GET["xmes"];
 	$cad="SUBSTR(fec_ini_inc,1,7)='$xmes'";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORTE INCIDENCIAS COT</title>

</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>

<p>
<? 
$lista="INSERT INTO reporte_incidencia_cot(
SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),''  
	FROM cab_incidencia 
	WHERE SUBSTR(fec_reg,1,7)='$xmes'
	ORDER BY fec_reg DESC
)";
	
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>CIP </td>";	
			echo "<td class='fdotxttabla2'>DNI </td>";														
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";												
			echo "<td class='fdotxttabla2'>FEC.REGISTRO</td>";	
			echo "<td class='fdotxttabla2'>SUPERVISOR</td>";			
			echo "<td class='fdotxttabla2'>USU.MOVIMIENTO</td>";		
			echo "<td class='fdotxttabla2'>TIPO INCIDENCIA</td>";			
			echo "<td class='fdotxttabla2'>MOTIVO INCIDENCIA</td>";		
			echo "<td class='fdotxttabla2'>CODIGO INCIDENCIA</td>";		
			echo "<td class='fdotxttabla2'>FEC. INICIAL</td>";			
			echo "<td class='fdotxttabla2'>FEC. FINAL</td>";	
			echo "<td class='fdotxttabla2'>MODO</td>";		
			echo "<td class='fdotxttabla2'>T.PERMISO</td>";			
			echo "<td class='fdotxttabla2'>OBSERVACIONES</td>";	
			echo "<td class='fdotxttabla2'>MES</td>";				
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		$c1="select * from tb_usuarios where dni='$reg_lis[15]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$c2="select * from tb_usuarios where iduser='$reg_lis[3]'";
		//echo $c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lis[5]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		$c4="select * from tb_supervisores where cod_supervisor='$reg_c2[23]'";
		//echo $c3;
		$res_c4 = mysql_query($c4);
		$reg_c4=mysql_fetch_row($res_c4);
		
		echo "<td class='casilla_texto'>";
		echo $i=$i+1; 			
		echo "</td>";
				
		echo "<td class='casilla_texto'>";
		echo $reg_c1[3]; 				
		echo "</td>";	
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[15]; 				
		echo "</td>";			
		
		echo "<td class='casilla_texto'>";
		echo $reg_c1[1]; 				
		echo "</td>";			
		
		echo "<td  class='casilla_texto'>";
		echo $reg_lis[2]; 			
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_c2[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_c4[1]; 				
		echo "</td>";



		echo "<td class='casilla_texto'>";
		echo $reg_lis[4]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_c3[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[10]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[13]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		
		if ($reg_lis[13]=="H"){
			echo $reg_lis[12];
		}else{
			echo $reg_lis[16];
		}
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[8]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[18]; 				
		echo "</td>";
				
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>