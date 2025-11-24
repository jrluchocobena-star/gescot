<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		

if ($iduser=="156"){
	$sql_2="select *,SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,fec_reg_web, fec_cierre_atencion))*60) AS diferencia  
	from cab_beoliquidaciones_cot order by fec_cierre_atencion desc";
}else{
	$sql_2="select *,SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,fec_reg_web, fec_cierre_atencion))*60) AS diferencia 
	 from cab_beoliquidaciones_cot where usu_reg='$iduser' order by fec_cierre_atencion desc";
}
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
	<th colspan="11" align="center" class="clsHoliDayCell"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</th>
    </tr>
    
  <tr>
   			<?					
			
			//echo "<th>ITEM</th>";				
			//echo "<th>...</th>";
				
			echo "<th class='table-filterable table-sortable:default'>MES";
			echo "<th class='table-filterable table-sortable:default'>ESTADO";
			
			echo "<th class='filterable'>COD.MULTIGESTION";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			
			echo "<th class='filterable'>COD.CLIENTE";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
						
			echo "<th class='table-filterable'>FEC.INICIO</th>";
			
			echo "<th>HR.INICIO</th>";	
				
			echo "<th class='table-filterable'>FEC.FIN</th>";
			
			echo "<th>HR.FIN</th>";	
					
			
			if ($iduser=="156"){
				echo "<th class='table-filterable table-sortable:default'>REGISTRADO POR</th>";
			}
			
			
			echo "<th class='table-filterable table-sortable:default'>EXCLUSION</th>";
			
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{	
		
		$est="select * from tb_estados_asignacion where cod_estado='".$reg[8]."'";
		//echo $s;
		$rs_s = mysql_query($est);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$usu="select * from tb_usuarios where iduser='$reg[2]'";
		$res_usu = mysql_query($usu);
		$reg_usu =mysql_fetch_row($res_usu);
		
		$mot="select * from tb_motivos_beo where cod_mot='".$reg[10]."'";
		//echo $s;
		$rs_mot= mysql_query($mot);											
		$rg_mot = mysql_fetch_row($rs_mot);
		
				
		echo "<tr class='alternate'>";		
		
		$con = $con + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
		/*	
		echo "<td>";
		?>
        <img src="../image/b_edit.png" width='15' height='15' onclick="javascript:popup_reclamo('7','<? echo $reg[1]; ?>',
        '<? echo $iduser; ?>','','','')"/>	
        <?
		echo "</td>";
		*/
		echo "<td>";		//FEC.INI
		echo substr($reg[3],0,7); 				
		echo "</td>";
		
		echo "<td>";		
		echo $rg_s[1]; //estado						
		echo "</td>";			
		
		echo "<td>";
		echo $reg[1]; 		//MG	
		echo "</td>";
			
		echo "<td>";		//CLIENTE		
		echo $reg[11]; 				
		echo "</td>";
						
		echo "<td>";		//FEC.INI
		echo substr($reg[3],0,10); 				
		echo "</td>";
		
		echo "<td>";		//HOR.INI
		echo substr($reg[3],11,8); 				
		echo "</td>";
		
		
		echo "<td>";		//FEC.FIN
		echo substr($reg[7],0,10); 	; 				
		echo "</td>";
				
		echo "<td>";		//HOR.FIN
		echo substr($reg[7],11,8); 				
		echo "</td>";
		
		/*
		echo "<td>";	///FEC.ATENCION
		echo $reg[5]; 				
		echo "</td>";
		*/
		
		
		
		if ($iduser=="156"){
		echo "<td>";		
		echo $reg_usu[1]; 				
		echo "</td>";
		}
		
	
		echo "<td>";		
		echo $rg_mot[1]; 						
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