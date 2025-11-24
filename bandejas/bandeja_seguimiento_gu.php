<?
include_once("../conexion_bd.php");
//set_time_limit(0);					

$cad="select * from gu_gestion_usuarios_cab";
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
<p>
<div class="tabcontent">  
<table width="100%" 
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
			
			echo "<th>ITEM</th>";
									
			echo "<th>TIPO</th>";
			
			echo "<th class='filterable'>C. WEB";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)' value='GU'></th>";
			
			echo "<th class='table-filterable table-sortable:default sort01'>MOTIVO</th>";
			
			echo "<th class='filterable'>C. LEGADOS";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
				
			echo "<th class='filterable'>FEC. REG.";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
			
			echo "<th class='table-filterable'>USU.REQ.</th>";		
			
			echo "<th class='table-filterable'>EST.REQ.</th>";
			
			//echo "<th class='table-filterable'>ESTADO</th>";
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";
				
		
		
		$C1="select * FROM gu_tipo_solicitud where cod_solicitud='".$reg[2]."'";
		//echo $C1;
		$rs_C1= mysql_query($C1);											
		$rg_C1 = mysql_fetch_row($rs_C1);
		
		$C2="select * FROM gu_motivos where cod_motivo='".$reg[4]."'";
		//echo $C2;
		$rs_C2= mysql_query($C2);											
		$rg_C2 = mysql_fetch_row($rs_C2);
		
		$C3="select * FROM gu_estados_req where cod_estado='".$reg[9]."'";
		//echo $C2;
		$rs_C3= mysql_query($C3);											
		$rg_C3 = mysql_fetch_row($rs_C3);
		
		$C4="select * FROM gu_estados where cod_estado='".$reg[10]."'";
		//echo $C2;
		$rs_C4= mysql_query($C4);											
		$rg_C4 = mysql_fetch_row($rs_C4);
		
		$usu="select * from tb_usuarios where iduser='$reg[13]'";
		$res_usu = mysql_query($usu);
		$reg_usu =mysql_fetch_row($res_usu);
		
		
		echo "<td>";		
		echo $reg[0]; 				
		echo "</td>";
				
		echo "<td>";		
		echo $rg_C1[1]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[1]; 				
		echo "</td>";
			
		echo "<td>";		
		echo $rg_C2[2]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[5]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg_usu[1]; 				
		echo "</td>";
					
		echo "<td>";		
		echo $rg_C3[1]; 				
		echo "</td>";
		
		/*
		echo "<td>";		
		echo $rg_C4[1]; 				
		echo "</td>";
		*/	
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="5" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="8" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
