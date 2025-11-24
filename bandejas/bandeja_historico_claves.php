<?
include_once("../conexion_bd.php");
//set_time_limit(0);					

$cad="select * from movimiento_usuarios where proceso in('RESETEO DE CLAVE','OLVIDO DE CLAVE') order by fec_mov desc";
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
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>

<div class="tabcontent">  
<table border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" width="80%" 
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
			
			
			
			echo "<th class='filterable'>USUARIOS ";						
			echo "<input name='filter' size='40' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
												
			echo "<th class='table-filterable table-sortable:default'>PROCESO</th>";				
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
				
			echo "<th class='filterable'>FECHA MOV ";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>OBSERVACION</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";
				
		
		
		$q="select iduser,ncompleto,login from tb_usuarios where dni='".$reg[6]."'";
		//echo $q;
		$rs_q = mysql_query($q);											
		$rg_q = mysql_fetch_row($rs_q);
		
		$s="select nom_supervisor from tb_supervisores where cod_supervisor='".$rg_q[2]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		
			
		echo "<td class='caja_texto_pe'>";		
		echo $rg_q[1]; 				
		echo "</td>";
						
		echo "<td>";		
		echo $reg[1]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[4]; 						
		echo "</td>";
								
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td  class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="2" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="5" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
