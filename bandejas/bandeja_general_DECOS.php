<?
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");
//set_time_limit(0);			


		

$cad="select * from cab_asignaciones_cot order by fec_reg_web desc";
//echo $cad;
$res =mysql_query($cad);		

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">
<script language='javascript1.2' type='text/javascript' src="../funciones_js.js"></script>
<link href="estillos_css.css" rel="stylesheet" type="text/css" />
<title>PANEL CONTROL ABONADOS</title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
<? 
echo "<table width='2000px' border='0'>";				
			echo "<tr>";							
			echo "<td><img src='../image/exportar.jpg' alt='' width='70' height='35' onclick='javascript:exportar_reporte_modulo($iduser,$opc);' /></td>";																												
			echo "</tr></table>";
?>
<div class="tabcontent">  
<table width="120%"
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">

<thead>
	<tr>
	<td colspan="9" align="center" bgcolor="#3B5998" class="txtlabel" style="color:#FFF font-size:16px" >BANDEJA DE PEDIDOS : DECOS AVERIADOS</td>		
	</tr>
	<tr>
	<td colspan="9" align="center" bgcolor="#3B5998" style="color:#FFF"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
  <tr>
   			<?					
			
			echo "<th class='filterable'>PEDIDO";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
						
			echo "<th class='table-filterable table-sortable:default'>USUARIO</th>";
			
			/*	
			echo "<th class='filterable'>FEC. REG. GESTEL";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			*/
				
			echo "<th class='filterable'>FEC. INICIO ATENCION";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable'>FEC. CIERRE ATENCION";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='table-filterable table-sortable:default'>MOTIVO</th>";
			
			//echo "<th class='table-sortable:default'>TIEMPO</th>";			
			echo "<th class='table-filterable table-sortable:default'>ESTADO</th>";
			
			echo "<th>OBSERVACION</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg_lis=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";		
						
		echo "<td  class='caja_texto_hr'>";
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		$sql_usu = "select * from tb_usuarios where iduser='$reg_lis[2]'";
		//echo $sql_usu;
		$res_USU = mysql_query($sql_usu);											
		$usu	= mysql_fetch_array($res_USU);
		
		echo "<td class='caja_texto_hr'>";
		echo $usu[1]; 				
		echo "</td>";	
		
		
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[3]; 				
		echo "</td>";	
		
		/*
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[3]; 				
		echo "</td>";
		*/	
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		/*
		if ($reg_lis[6]==3){
		echo "<td class='caja_texto_hr'>";
		echo dif_fechas($reg_lis[3],$reg_lis[5]); 				
		echo "</td>";
		}else{
		echo "<td class='caja_texto_hr'>";
		echo "0000-00-00 00:00:00"; 				
		echo "</td>";
		}
		
		echo "<td class='caja_texto_hr'>";
		echo calcular_tiempo_trasnc($reg_lis[5],$reg_lis[4]); 				
		echo "</td>";
		*/		
		
		$est="select * from tb_estados_asignacion where cod_estado='$reg_lis[6]'";
		$res_est= mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_est[1]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "</tr>";			
		}		
	?>
</tbody>	
	
<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="4" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>
		<td colspan="2" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>	
</tfoot>
		
</table>			
</div>
</body>
</html>
