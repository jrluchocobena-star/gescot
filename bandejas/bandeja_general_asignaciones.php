<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

//echo $idperfil;

if ($idperfil<>"1"){
	$sql_2="select *,SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,fec_reg_web, fec_cierre_atencion))*60) AS diferencia  
	from cab_asignaciones_cot where SUBSTR(fec_reg_web,1,7)='$xmes' order by fec_reg_web desc";
}else{
	$sql_2="select *,SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,fec_reg_web, fec_cierre_atencion))*60) AS diferencia 
	 from cab_asignaciones_cot where usu_reg='$iduser' and SUBSTR(fec_reg_web,1,7)='$xmes' order by fec_reg_web desc";
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
	<th colspan="13" align="center" class="clsHoliDayCell"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</th>
    </tr>
    
  <tr>
   			<?					
			
			//echo "<th>ITEM</th>";				
			echo "<th>...</th>";
				
			echo "<th class='table-filterable table-sortable:default'>MES";
			echo "<th class='table-filterable table-sortable:default'>ESTADO";
			
			echo "<th class='filterable'>PET./REQ.";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";		
			
			echo "<th class='table-filterable'>PEDIDO</th>";				
						
			echo "<th class='table-filterable'>FEC.REGISTRO</th>";
			
			echo "<th>HR.INI REGISTRO</th>";	
				
			echo "<th class='table-filterable'>FEC.FIN</th>";
			
			echo "<th>HR.FIN</th>";	
			
			echo "<th class='table-filterable table-sortable:default'>T.ATENCION(HH:MM)</th>";
			
			if ($idperfil<>"1"){
				echo "<th class='table-filterable table-sortable:default'>USUARIO</th>";
			}
			echo "<th class='table-filterable table-sortable:default'>ORIGEN</th>";
			
			echo "<th class='table-filterable table-sortable:default'>EXCLUSION</th>";
			
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{	
		
		$est="select * from tb_estados_asignacion where cod_estado='".$reg[6]."'";
		//echo $s;
		$rs_s = mysql_query($est);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$usu="select * from tb_usuarios where iduser='$reg[2]'";
		$res_usu = mysql_query($usu);
		$reg_usu =mysql_fetch_row($res_usu);
				
		echo "<tr class='alternate'>";		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$con = $con + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
			
		echo "<td>";
		?>
        <img src="../image/b_edit.png" width='15' height='15' onclick="javascript:popup_reclamo('5','<? echo $reg[1]; ?>',
        '<? echo $iduser; ?>','','','')"/>	
        <?
		echo "</td>";
		
		echo "<td>";		//FEC.INI
		echo substr($reg[3],0,7); 				
		echo "</td>";
		
		echo "<td>";		
		echo $rg_s[1]; //estado						
		echo "</td>";			
		
		echo "<td>";
		echo $reg[1]; 		//PETICION	
		echo "</td>";
			
		echo "<td>";		//PEDIDO
		
		echo $reg[10]; 				
		echo "</td>";
		
		//echo "<td>";		//PEDIDO
		
        
						
		echo "<td>";		//FEC.REGISTRO WEB
		echo substr($reg[3],0,10); 				
		echo "</td>";
		
		echo "<td>";		//HOR.INI
		echo substr($reg[3],11,8); 				
		echo "</td>";
		
		
		echo "<td>";		//FEC.FIN
		echo substr($reg[5],0,10); 	; 				
		echo "</td>";
		
		echo "<td>";		//dif
		echo substr($reg[11],0,5); 				
		echo "</td>";
		
		echo "<td>";		//HOR.FIN
		echo substr($reg[5],11,8); 				
		echo "</td>";
		
		/*
		echo "<td>";	///FEC.ATENCION
		echo $reg[5]; 				
		echo "</td>";
		*/
		
		
		
		if ($idperfil<>"1"){
		echo "<td>";		
		echo $reg_usu[1]; 				
		echo "</td>";
		}
		
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
		<td colspan="9" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

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