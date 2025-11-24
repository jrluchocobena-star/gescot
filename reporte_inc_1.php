
<?
include("conexion_bd.php");
include("funciones_fechas.php");

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];


if ($c_inc=="" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){
	
	$lista="SELECT dni,SUBSTR(fec_ini_inc,1,10) AS dia, modo,COUNT(*),SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),SUM(dias) 
		FROM cab_incidencia WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS' GROUP BY 1,2 order by 2 desc";
		//echo "d".$lista;
		
		$res_lista = mysql_query($lista);
			
			echo "<table width='50%'>";	
			echo "<tr>";
				echo "<td colspan>&nbsp;</td>";				
			echo "</tr>";	
			
			echo "<tr>";
				echo "<td align='center' width='30%'>N.COMPLETO</td>";
				echo "<td align='center' width='10%'>DNI</td>";
				echo "<td align='center' width='10%'>FECHA</td>";				
				echo "<td align='center' colspan='2' >TIEMPO</td>";	
		
				
			echo "</tr>";									
			
			while($reg_lista=mysql_fetch_row($res_lista)){			
							
				echo "<tr>";					
				
				$usu		= "select ncompleto from tb_usuarios where dni='$reg_lista[0]'";		
				$res_usu	= mysql_query($usu);
				$reg_usu	= mysql_fetch_row($res_usu);
				
				
				echo "<td align='center' width='12%'>"; // 
				echo $reg_usu[0]; 				
				echo "</td>";			
				
				echo "<td  align='center' width='18%'>"; // 
				echo $reg_lista[0]; 			
				echo "</td>";	
						
				echo "<td  align='center' width='12%'>"; //
				echo $reg_lista[1]; 			
				echo "</td>";	
				
				
			if ($reg_lista[2]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
				
				
				echo "</tr>";				
				}	
			echo "</table>";
	
}else{
	if ($gestor<>"0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){
		
	$lista="(SELECT SUBSTR(fec_ini_inc,1,10),SUBSTR(fec_fin_inc,1,10), modo,COUNT(*),
	SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),SUM(dias) FROM cab_incidencia WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS'
	and dni='$gestor' GROUP BY 1,3 order by 1 desc)
	union(SELECT SUBSTR(fec_ini_inc,1,10) ,SUBSTR(fec_fin_inc,1,10),modo,COUNT(*),SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),SUM(dias) 
	FROM cab_incidencia_2018 WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS' and dni='$gestor' GROUP BY 1,3 order by 1 desc)";
	//echo "a".$lista;
	
	$res_lista = mysql_query($lista);
	
	$usu		= "select ncompleto from tb_usuarios where dni='$gestor'";		
	$res_usu	= mysql_query($usu);
	$reg_usu	= mysql_fetch_row($res_usu);
	
	echo "<table width='50%'>";	
	echo "<tr>";
		echo "<td colspan='4' class='etiqueta_1p'>GESTOR: $gestor - $reg_usu[0]</td>";			
	echo "</tr>";
		
	echo "<tr>";
		echo "<td align='center' width='10%'>FEC.INI</td>";		
		echo "<td align='center' width='10%'>MODO</td>";		
		echo "<td align='center' colspan='2' >TIEMPO</td>";		
	echo "</tr>";									
	
	while($reg_lista=mysql_fetch_row($res_lista)){			
					
		echo "<tr>";					
				
		echo "<td  align='center' width='12%'>"; //
		echo $reg_lista[0]; 			
		echo "</td>";	
		
		echo "<td  align='center' width='12%'>"; //
		echo $reg_lista[2]; 			
		echo "</td>";	
				
		if ($reg_lista[2]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
			
		
		
		echo "</tr>";				
		}	
	echo "</table>";

}else{
	if ($gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){
		$lista="SELECT dni,SUBSTR(fec_ini_inc,1,10) AS dia, modo,COUNT(*),SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),SUM(dias) 
		FROM cab_incidencia WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS' and cod_incidencia='$c_inc' GROUP BY 1,2 order by 2 desc";
		//echo "b".$lista;
		
		$res_lista = mysql_query($lista);
		
		$usu		= "select ncompleto from tb_usuarios where dni='$gestor'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);
		
			echo "<table width='80%'>";	
			echo "<tr>";
			echo "<td colspan='4' class='etiqueta_1p'>GESTOR: $gestor - $reg_usu[0]</td>";			
			echo "</tr>";
		
			echo "<tr>";
				echo "<td align='center' width='30%'>N.COMPLETO</td>";
				echo "<td align='center' width='10%'>DNI</td>";
				echo "<td align='center' width='10%'>FECHA</td>";				
				echo "<td align='center' colspan='2' >TIEMPO</td>";	
				
			echo "</tr>";									
			
			while($reg_lista=mysql_fetch_row($res_lista)){			
							
				echo "<tr>";					
				
				$usu		= "select ncompleto from tb_usuarios where dni='$reg_lista[0]'";		
				$res_usu	= mysql_query($usu);
				$reg_usu	= mysql_fetch_row($res_usu);
				
				
				echo "<td align='center' width='12%'>"; // 
				echo $reg_usu[0]; 				
				echo "</td>";			
				
				echo "<td  align='center' width='18%'>"; // 
				echo $reg_lista[0]; 			
				echo "</td>";	
						
				echo "<td  align='center' width='12%'>"; //
				echo $reg_lista[1]; 			
				echo "</td>";	
				
				
				if ($reg_lista[2]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
				
				
				echo "</tr>";				
				}	
			echo "</table>";
	}else{
		if ($c_inc=="" and $gestor<>"0"){ // gestor + fecha
		$lista="SELECT dni,SUBSTR(fec_ini_inc,1,10) AS dia, modo,COUNT(*),SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),
		SUM(dias),cod_incidencia
		FROM cab_incidencia WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS' and dni='$gestor'
		and fec_ini_inc BETWEEN '$fec_i' AND '$fec_f' 
		GROUP BY 1,2,3 order by 2 desc";
		//echo "e".$lista;
		
		$res_lista = mysql_query($lista);
			
		
		$usu		= "select ncompleto from tb_usuarios where dni='$gestor'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);	
			
			echo "<table width='70%'>";	
				echo "<tr>";
					echo "<td colspan='4' class='etiqueta_1p'>GESTOR: $gestor - $reg_usu[0]</td>";			
				echo "</tr>";
					
				echo "<tr>";					
					echo "<td align='center' width='10%'>DNI</td>";
					echo "<td align='center' width='10%'>NCOMPLETO</td>";
					echo "<td align='center' width='10%'>FECHA</td>";								
					echo "<td align='center' width='10%'>MODO</td>";					
					echo "<td align='center' colspan='2' >TIEMPO</td>";	
				echo "</tr>";									
				
				while($reg_lista=mysql_fetch_row($res_lista)){			
								
					echo "<tr>";					
			
					$usu1		= "select ncompleto from tb_usuarios where dni='$reg_lista[0]'";		
					$res_usu1	= mysql_query($usu1);
					$reg_usu1	= mysql_fetch_row($res_usu1);
									
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[0]; 			
					echo "</td>";
					
					echo "<td  width='12%'>"; //
					echo $reg_usu1[0]; 			
					echo "</td>";
					
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[1]; 			
					echo "</td>";
								
					
									
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[2]; 			
					echo "</td>";	
					
					
					if ($reg_lista[2]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
					
					
					echo "</tr>";				
					}	
			echo "</table>";
	
		}else{
		$lista="SELECT dni,SUBSTR(fec_ini_inc,1,10) AS dia, modo,COUNT(*),SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),
		SUM(dias),cod_incidencia
		FROM cab_incidencia WHERE tp_incidencia<>'INCIDENCIAS DE SISTEMAS' 
		and fec_ini_inc BETWEEN '$fec_i' AND '$fec_f' 
		GROUP BY 1,2,3 order by 2 desc";
		//echo "c".$lista;
		
		$res_lista = mysql_query($lista);
			
		
		$usu		= "select ncompleto from tb_usuarios where dni='$gestor'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);	
			
			echo "<table width='70%'>";	
				echo "<tr>";
					echo "<td colspan='4' class='etiqueta_1p'>GESTOR: $gestor - $reg_usu[0]</td>";			
				echo "</tr>";
					
				echo "<tr>";					
					echo "<td align='center' width='10%'>DNI</td>";
					echo "<td align='center' width='10%'>NCOMPLETO</td>";
					echo "<td align='center' width='10%'>FECHA</td>";								
					echo "<td align='center' width='10%'>MODO</td>";					
					echo "<td align='center' colspan='2' >TIEMPO</td>";	
				echo "</tr>";									
				
				while($reg_lista=mysql_fetch_row($res_lista)){			
								
					echo "<tr>";					
			
					$usu1		= "select ncompleto from tb_usuarios where dni='$reg_lista[0]'";		
					$res_usu1	= mysql_query($usu1);
					$reg_usu1	= mysql_fetch_row($res_usu1);
									
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[0]; 			
					echo "</td>";
					
					echo "<td  width='12%'>"; //
					echo $reg_usu1[0]; 			
					echo "</td>";
					
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[1]; 			
					echo "</td>";
								
					
									
					echo "<td  align='center' width='12%'>"; //
					echo $reg_lista[2]; 			
					echo "</td>";	
					
					
					if ($reg_lista[2]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
					
					
					echo "</tr>";				
					}	
			echo "</table>";
			
		}
	  }
	}
}

?>
