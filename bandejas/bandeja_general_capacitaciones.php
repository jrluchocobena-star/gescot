<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$opc=$_GET["opc"];
	
$xmes=date("Y")."-".$_GET["cri1"];

$fec_i =$_GET["fec_i"];
$fec_f =$_GET["fec_f"];
$cri2  =$_GET["cri2"];

/*
if ($_GET["cri1"]==""){
			$cad="";
	}else{
		if ($_GET["cri1"]!="0" and $_GET["cri2"]!="0"){
			$cad=" where substr(fec_reg,1,7)='$xmes' and usu_reg='$cri2'";
		}else{
			if ($_GET["cri1"]=="0" and $_GET["cri2"]=="0"){
			$cad="";
			}else{
				if ($_GET["cri2"]=="0"){		
					$cad=" where substr(fec_reg,1,7)='$xmes'";			
				}else{					
					$cad=" where usu_reg='$cri2'";		
				}
			}
		}
	}
*/

//echo $fec_i."|".$fec_f;

if ($_GET["cri2"]=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){
			$cad="";
	}else{
		if ($_GET["cri2"]<>"" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" ){
			$cad=" where usu_reg='$cri2'";		
		}else{
			if ($_GET["cri2"]<>""){
				$cad=" where DATE_FORMAT(fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";		
			}else{
				$cad=" where DATE_FORMAT(fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f' and usu_reg='$cri2'";	
			}
		}
}

$sql_1="select * from cab_capacitacion $cad order by fec_reg desc";	
//echo $sql_1;	

$res_1 = mysql_query($sql_1);


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
<p>
<tr>
  <td ><div class="tabcontent">
    <table width="100%"
border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" class="example table-autosort table-autofilter table-autopage:15 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">

<thead>   
    <tr>
	 <? 
		$sp="select * from tb_monitores where cod_monitor='$cri2'";
		$res_sp = mysql_query($sp);
		$reg_sp =mysql_fetch_row($res_sp);
		
		echo "<th colspan='11'>MONITOR: ".$reg_sp[1]; 
	?>
    </th>
    </tr>
    
	<tr>
	<th colspan="11" align="center" class="clsHoliDayCell"><span id="t1filtercount">
    </span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</th>
    </tr>
    
  <tr>
   			<?					
			
			//echo "<th>ITEM</th>";				
			//echo "<th>PANEL</th>";
			
			echo "<th class='filterable'>INCIDENCIA";						
			echo "<input name='filter' size='15' maxlength='20' onkeyup='Table.filter(this,this)' value='CAP-'></th>";
			echo "<th class='filterable'>CIP";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";					
			echo "<th class='table-filterable table-sortable:default'>TRABAJADOR</th>";												
			echo "<th class='filterable'>FEC.REGISTRO";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";			
			echo "<th class='filterable'>FEC.";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";			
			echo "<th class='filterable'>FEC.FIN";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";		
			echo "<th class='table-filterable table-sortable:default'>TIPO</th>";
			echo "<th class='table-filterable table-sortable:default'>CURSO</th>";	
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res_1))
		{			
		echo "<tr class='alternate'>";		
			
		
		$usu	 = "select * from tb_usuarios where iduser='$reg[3]'";
		//echo $usu;
		$res_usu = mysql_query($usu);
		$reg_usu = mysql_fetch_row($res_usu);
		
		$tra="select * from tb_usuarios where dni='$reg[15]'";
		//echo $tra;
		$res_tra = mysql_query($tra);
		$reg_tra =mysql_fetch_row($res_tra);
		
	
		$sup="select * from tb_monitores where cod_monitor='$reg_tra[24]'"; //monitor
			//  echo $sup;
		$res_sup = mysql_query($sup);
		$reg_sup =mysql_fetch_row($res_sup);
				
		$mot="select * from tb_motivos_incidencia wHERE cod_mot_inc='$reg[5]'";
		$res_mot = mysql_query($mot);
		$reg_mot =mysql_fetch_row($res_mot);
		
		/*
		echo "<td>";		//
		?>
		<img src="../image/b_edit.png" width='15' height='15' onclick="javascript:popup_reclamo('4','<? echo $iduser; ?>','<? echo $idperfil; ?>','<? echo "Editar"; ?>','<? echo $reg[10]; ?>','<? echo $reg[11]; ?>')"/>		
		<?
        echo "</td>";
		*/
						
		echo "<td>";		//incidencia
		echo $reg[10]; 				
		echo "</td>";		
				
		
		echo "<td>";		//cip
		echo $reg[1]; 				
		echo "</td>";	
		
		echo "<td>";		//NOMBRE
		echo $reg_tra[1]; 				
		echo "</td>";		
		
			
		echo "<td>";		//FEC.REG
		echo $reg[2]; 				
		echo "</td>";
		
		echo "<td>";		//FEC.ini
		echo $reg[6]; 				
		echo "</td>";
		

		echo "<td>";		//FEC.fin
		echo $reg[7]; 				
		echo "</td>";
		
		
		echo "<td>";		
		echo $reg[17]; 			// tipo			
		echo "</td>";
		
		
		echo "<td>";		
		echo $reg_mot[1]; 		// motivo				
		echo "</td>";
		
		
		echo "</tr>";	
				
		}		
	?>
</tbody>

<tfoot>
	<tr>		
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="5" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td colspan="3" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>	
</tfoot>	
</table>

<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
</div>
</body>
</html>