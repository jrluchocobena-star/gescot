<script language="javascript" src="funciones_js.js"></script>
<?php
include("conexion_bd.php");

$iduser 			= $_GET["iduser"];
$perfil 			= $_GET["perfil"];
$texto_inicial 		= trim($_GET["texto_ini"]);
$texto_intermedio 	= $_GET["texto_int"];
$texto_final 		= $_GET["texto_fin"];
$estado				= 1;

?>
<link href="estilos.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
    <td class="cabeceras_grid">
    <?php
		if ($estado=="1"){
			echo "<img src='registrado.png' width='500' height='150'>";
		}else{
			echo "<img src='error_registrado.png' width='500' height='150'>";
			}
	?>
    
    </td>
  </tr>
  <tr>
    <td class="cabeceras_grid"><?php echo "Se registro la incidencia correctamente: " . $texto_inicial;?></td>
  </tr>
   <tr>
  <p>
    <td align="center" ><a class="boton_3" onClick="javascript:cerrar_alertas('0')">Cerrar</a></td>
  </tr>
  <tr>
    <td class="cabeceras_grid"><?php 
	$lista="select * from cab_incidencia where cod_incidencia='$texto_inicial' group by dni";
	//echo $lista;
	$res_lis = mysql_query($lista);

	
	echo "<table width='100%' class='marco_tabla'>";				
		echo "<tr>";		
		echo "<td class='caja_texto_pekecab'>CIP</td>";							
		echo "<td class='caja_texto_pekecab'>DNI</td>";							
		echo "<td class='caja_texto_pekecab'>NOMBRE COMPLETO</td>";		
		echo "<td class='caja_texto_pekecab'>OBSERVACION</td>";
		echo "</tr>";		
		
		while($reg_lis=mysql_fetch_row($res_lis)){	
						$ch1		="select * from tb_usuarios where dni='$reg_lis[15]'";
						//echo $ch1;
						$res_ch1 	= mysql_query($ch1);
						$reg_ch1	= mysql_fetch_row($res_ch1);
									
		echo "<tr>";		
		
				
		echo "<td class='caja_texto_peke'>";		//CIP		
		echo $reg_lis[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//dni		
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";//NOMBRE	
		echo $reg_ch1[1]; 		
		echo "</td>";
		
		
			
		if ($reg_lis[17]=="0"){
			$clas='caja_texto_peke';
			$estado ="REGISTRADO OK";
		}
		
	
		if ($reg_lis[17]=="3"){
			$clas='aviso_horario';
			$estado ="MAL REGISTRADO";
		}
		
		echo "<td class='$color'>";		// 	ESTADO
		echo $estado; 				
		echo "</td>";
		
	
		
		echo "</tr>";				
		}	
	echo "</table>";	
	?></td>
  </tr>
  <tr>
    <td class="cabeceras_grid"><?php echo $texto_final;?></td>
  </tr>
 
</table>