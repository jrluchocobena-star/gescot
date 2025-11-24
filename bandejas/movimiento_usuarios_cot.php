<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

//echo $idperfil;
$sql_2="select * from movimientos_maestra";
//echo $sql_2;
$res = mysql_query($sql_2);
//$reg=mysql_fetch_row($res_lis_2);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

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
	<th colspan="10" align="center" class="clsHoliDayCell"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</th>
    </tr>
    
  <tr>
   			<?					
			
			
			echo "<th class='table-filterable table-sortable:default'>MES";
			
			echo "<th class='table-filterable table-sortable:default'>FEC.MOVIMIENTO";
			
			echo "<th class='filterable'>DNI";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";		
			
			echo "<th class='filterable'>USUARIO";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";					
						
			echo "<th class='table-filterable'>TIPO</th>";
			
			echo "<th class='table-filterable'>CLASE</th>";
				
			echo "<th class='table-filterable'>FEC.INI</th>";
			
			echo "<th class='table-filterable'>FEC.FIN</th>";
			
			echo "<th class='table-filterable'>USU.MOV.</th>";
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{	
		
				
		echo "<tr class='alternate'>";		
		
		$sql_usu = "SELECT * from tb_usuarios where iduser='$reg[8]' GROUP BY dni";
		  //echo $sql_usu;
	   $res_USU = mysql_query($sql_usu);											
	   $nreg= mysql_num_rows($res_USU);
	   $reg_USU=mysql_fetch_array($res_USU);
	  
		$con = $con + 1; 
					
		
		echo "<td>";		//FEC.INI
		echo substr($reg[5],0,7); 				
		echo "</td>";
		
		echo "<td>";		//FEC.INI
		echo $reg[5]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[1]; //dni						
		echo "</td>";			
		
		echo "<td>";
		echo $reg[2]; 		//	
		echo "</td>";
			
		echo "<td>";		//		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";		//		
		echo $reg[4]; 				
		echo "</td>";
		
			
		echo "<td>";		//		FECINI
		echo $reg[6]; 				
		echo "</td>";
		
		echo "<td>";		//	FECFIN	
		echo $reg[7]; 				
		echo "</td>";
		
		echo "<td>";		//USU		
		echo $reg_USU[1]; 				
		echo "</td>";	

		
		echo "</tr>";	
				
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
        <td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="6" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

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