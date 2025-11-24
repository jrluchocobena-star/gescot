<?
include_once("../conexion_bd.php");
validar_logeo($iduser);
//set_time_limit(0);					

$cad="SELECT a.*,b.dpto,b.contrata 
FROM cab_modem_averiados a, deta_modem_averiados b
WHERE a.c_averia=b.c_averia
GROUP BY a.c_averia";
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
<title>PANEL CONTROL USUARIOS</title>
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>

<div class="tabcontent">  
<table border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" width="100%" 
class="example table-autosort table-autofilter table-autopage:25 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
				
			
			echo "<th class='filterable'>COD.AVERIA";						
			echo "<BR><input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='table-filterable'>DNI</th>";
			
			echo "<th class='table-filterable'>OPERADOR</th>";
															
			echo "<th>FEC.REG</th>";
			
			echo "<th class='table-filterable'>TIPO</th>";
			
			echo "<th class='table-filterable'>PROCEDE</th>";
			
			echo "<th class='table-filterable'>RESULTADO</th>";
			
			echo "<th class='table-filterable'>CANAL</th>";
			
			echo "<th class='table-filterable'>DPTO</th>";
			
			echo "<th class='table-filterable'>CONTRATA</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";
		
		$d="select ncompleto,dni from tb_usuarios where iduser='".$reg[2]."'";
		//echo $q;
		$rs_d = mysql_query($d);											
		$rg_d = mysql_fetch_row($rs_d);
		
		$e="select * from motivos_averias_modem where cod_mot_averia='".$reg[2]."'";
		//echo $q;
		$rs_e = mysql_query($e);											
		$rg_e = mysql_fetch_row($rs_e);
		
		
				
		echo "<td>";		
		echo $reg[1]; 				
		echo "</td>";
		
		
		echo "<td>";		
		echo $rg_d[1]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $rg_d[0]; 				
		echo "</td>";
		
		
		echo "<td>";		
		echo $reg[3]; 				
		echo "</td>";
					
		
		echo "<td>";		
		echo $reg[4]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[6]; 				
		echo "</td>";

		echo "<td>";		
		echo $reg[5]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[7]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[8]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[9]; 				
		echo "</td>";
								
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="7" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td colspan="2" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="10" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
