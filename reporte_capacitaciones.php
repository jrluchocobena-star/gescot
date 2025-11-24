<?php

$f_actual=date("Y-m-d");
$n_archivo="rep_incidenciascot_".$f_actual.".xls";


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];

$xmes=date("Y")."-".$_GET["cri1"];
$fec_i =$_GET["fec_i"];
$fec_f =$_GET["fec_f"];
$cri2  =$_GET["cri2"];

/*
if ($_GET["cri1"]==""){
	$cad="";
}else{
	if ($_GET["cri1"]=="0" and $_GET["cri2"]=="0"){
		$cad="";
	}else{
		if ($_GET["cri2"]=="0"){		
			$cad=" substr(fec_reg,1,7)='$xmes' and usu_reg='$cri2'";			
		}else{		
			$cad=" usu_reg='$cri2'";		
		}
	}
}
*/

//echo $_GET["cri2"]."|".$fec_i."|".$fec_f;

if ($_GET["cri2"]=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){
			$cad="";
	}else{
		if ($_GET["cri2"]<>"" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" ){
			$cad=" where usu_reg='$cri2'";		
		}else{
			if ($_GET["cri2"]<>""){
				$cad=" where SUBSTR(fec_ini_inc,1,10) BETWEEN '$fec_i' AND '$fec_f'";		
			}else{
				$cad=" where SUBSTR(fec_ini_inc,1,10) BETWEEN '$fec_i' AND '$fec_f' ";	
			}
		}
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

$lista="select * from cab_capacitacion $cad group by cod_incidencia, cip, fec_ini_inc order by fec_reg desc";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
			echo "<table width='100%' BORDER='1' style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>COD. INCIDENCIA</td>";	
			echo "<td class='fdotxttabla2'>CIP </td>";														
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";												
			echo "<td class='fdotxttabla2'>FEC.REGISTRO</td>";			
			echo "<td class='fdotxttabla2'>USU.MOVIMIENTO</td>";		
			echo "<td class='fdotxttabla2'>TIPO CAPAC.</td>";		
			echo "<td class='fdotxttabla2'>TEMA</td>";		
			echo "<td class='fdotxttabla2'>SUBTEMA</td>";	
			echo "<td class='fdotxttabla2'>SUPERVISOR</td>";		
			echo "<td class='fdotxttabla2'>FEC. INICIAL</td>";			
			echo "<td class='fdotxttabla2'>FEC. FINAL</td>";		
			echo "<td class='fdotxttabla2'>TIEMPO</td>";			
			echo "<td class='fdotxttabla2'>NRO.PARTICIPANTES</td>";			
			echo "<td class='fdotxttabla2'>OBSERVACIONES</td>";				
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
								
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
				
				$c4="select * from tb_supervisores where cod_supervisor='$reg_c1[23]'";
				//echo $c4;
				$res_c4 = mysql_query($c4);
				$reg_c4 =mysql_fetch_row($res_c4);
				
				
		echo "<tr>";	
		
		echo "<td class='casilla_texto'>"; // ITEM
		echo $i=$i+1; 			
		echo "</td>";
	
		echo "<td class='casilla_texto'>"; // COD. INCIDENCIA
		echo $reg_lis[10]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; // CIP
		echo $reg_c1[3]; 				
		echo "</td>";			
		
		echo "<td class='casilla_texto'>"; // TRABAJADOR
		echo $reg_c1[1]; 				
		echo "</td>";			
		
		echo "<td  class='casilla_texto'>"; // FEC.REGISTRO
		echo $reg_lis[2]; 			
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // USUARIO MOVIMIENTO
		echo $reg_c2[1]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>"; // MOT. CAPA
		echo $reg_lis[17]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // TEMA
		echo $reg_c3[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //SUBTEMA
		echo $reg_lis[18]; 				
		echo "</td>";
		
		
		echo "<td class='casilla_texto'>";
		echo $reg_c4[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[7]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		if (substr($reg_lis[7],11,8)=="00:00:00"){
			$fec1=substr($reg_lis[6],0,10);
			$fec2=substr($reg_lis[7],0,10);
			$dfec=calcular_tiempo_trasnc($fec2,$fec1);
			$fec_r=explode(", ",$dfec); 
			echo $fec_r[0];
			
		}else{
			echo calcular_tiempo_trasnc($reg_lis[7],$reg_lis[6]); 				
		}
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[8]; 				
		echo "</td>";
				
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>