<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		


$sql_2="select * from carga_pedidos_total order by fecha_reg desc";
//echo $sql_2;
$res = mysql_query($sql_2);
//$reg=mysql_fetch_row($res_lis_2);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language='javascript1.2' type='text/javascript' src="../funciones_js.js"></script>
<link href="../estilos.css" rel="stylesheet" type="text/css" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">
<title></title>
</head>

<body>
<div class="tabcontent">  
<table width="100%" 
border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" class="example table-autosort table-autofilter table-autopage:20 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
	<tr>
	<td colspan="11" align="center" class="clsHoliDayCell"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>
    </tr>
    
  <tr>
   			<?					
						
			echo "<th class='filterable'>PET./REQ.";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable'>PEDIDO";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable'>INSCRIPCION";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			//echo "<th class='filterable'>DIRECCION";						
			//echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
					
				
			echo "<th class='filterable table-sortable:default'>F.REG.LEGADOS";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			
			echo "<th class='table-filterable table-sortable:default'>ORIGEN</th>";
			
			echo "<th class='table-filterable table-sortable:default'>ESTADO</th>";
			
			echo "<th class='table-filterable table-sortable:default'>ZONAL</th>";
			
			echo "<th class='table-filterable table-sortable:default'>ATENDIDO POR</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{	
		$cab="select b.ncompleto 
		from cab_asignaciones_cot a, tb_usuarios b where a.usu_reg=b.iduser and a.peticion='".$reg[0]."'";
		//echo "<br>".$cab;
		$rs_cab = mysql_query($cab);											
		$rg_cab = mysql_fetch_row($rs_cab);
			
		echo "<tr class='alternate'>";		
		
				
		echo "<td>";				
		echo $reg[0]; 						
		echo "</td>";
		
			
		echo "<td>";		
		echo $reg[1]; 				
		echo "</td>";
						
		echo "<td>";		
		echo $reg[2]; 				
		echo "</td>";
		
		/*
		echo "<td >";		
		echo $reg[3]; 				
		echo "</td>";
		*/		
		
		echo "<td>";	
		echo $reg[4]; 				
		echo "</td>";
		
		
		echo "<td>";		
		echo $reg[5]; 						
		echo "</td>";

		 
		$est="select * from tb_estados_asignacion where cod_estado=".$reg[6];
		//echo $est;
		$rs_s = mysql_query($est);											
		$rg_s = mysql_fetch_row($rs_s);

		echo "<td>";		
		echo $rg_s[1]; 						
		echo "</td>";						

		echo "<td>";		
		echo $reg[7]; 						
		echo "</td>";
		
		
		
		echo "<td>";		
		echo $rg_cab[0]; 						
		echo "</td>";
		
		echo "</tr>";		
		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="5" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td colspan="2" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
    <!--
	<tr>
	<td colspan="11" align="center">
    <span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)
    </td>		
	</tr>
    -->
</tfoot>		
</table>
</div>
</body>
</html>