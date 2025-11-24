<?
include_once("../conexion_bd.php");
//set_time_limit(0);					

$xmes=date("Y-m");

$cad="SELECT b.ncompleto,b.dni,SUBSTR(a.fec_reg_web,1,10) AS dia,a.origen,COUNT(*)
FROM cab_asignaciones_cot a, tb_usuarios b
WHERE a.usu_reg=b.iduser and SUBSTR(a.fec_reg_web,1,7)='$xmes'
GROUP BY 2,3,4";
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

<link href="estillos_css.css" rel="stylesheet" type="text/css" />
<title></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>

<div>  
<table border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" 
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
			
			echo "<th class='table-filterable table-sortable:default'>NOMBRE COMPLETO</th>";	
			
			echo "<th>DNI";				
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>DIA</th>";
												
			echo "<th>ORIGEN</th>";
				
			echo "<th>CANTIDAD</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";
				
	
		echo "<td class='caja_texto_hr'>";		
		echo $reg[0]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[1]; 				
		echo "</td>";
		
			
		echo "<td class='caja_texto_hr'>";		
		echo $reg[2]."&nbsp;"; 				
		echo "</td>";
						
		echo "<td class='caja_texto_hr'>";		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[4]; 				
		echo "</td>";
										
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="3" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="6" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
