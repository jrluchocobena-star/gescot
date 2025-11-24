<?
include_once("../conexion_bd.php");
//set_time_limit(0);					
$dni		=$_GET["dni"];

$cad_2="select * from compensacion_extra where dni='$dni'order by fec_ini_comp desc";
//echo $cad_2;
$res_2 =mysql_query($cad_2);		

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">

<title></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>

<div class="tabcontent">  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" 
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
			
			//echo "<th>CORRELATIVO<br>";				
			//echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>DNI</th>";
			
			echo "<th>N.COMPLETO</th>";	
			
			echo "<th>FEC.REGISTRO<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>FEC.COMPENSACION<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='table-filterable table-sortable:default'>TIEMPO</th>";
												
			echo "<th>USUARIO</br>";		
			
			echo "<th class='table-filterable table-sortable:default'>OBSERVACION</br>";							
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res_2))
		{		
		echo "<tr class='alternate'>";
					
		$q="select iduser,ncompleto,c_supervisor from tb_usuarios where dni='".$reg[1]."'";
		//echo $q;
		$rs_q = mysql_query($q);											
		$rg_q = mysql_fetch_row($rs_q);
		
		$usu="select ncompleto from tb_usuarios where iduser='".$reg[3]."'";
		//echo $usu;
		$rs_usu = mysql_query($usu);											
		$rg_usu = mysql_fetch_row($rs_usu);
			
		/*
		echo "<td>";
		?>
        <a href="javascript:mostrar_detalle('<? echo $reg[1]; ?>')">
        <?		
		echo $reg[9]; 				
		echo "</a></td>";
		*/
		echo "<td class='caja_texto_hr'>";		
		echo $reg[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		?>
        <a href="javascript:ventana_modal('1')">
        <?
		echo $rg_q[1]; 				
		echo "</a></td>";
				
			
		echo "<td class='caja_texto_hr'>";		
		echo $reg[3]; 				
		echo "</td>";
						
		echo "<td class='caja_texto_hr'>";		
		echo $reg[4]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $rg_usu[0]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[8]; 						
		echo "</td>";
		
	
								
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="4" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="7" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
