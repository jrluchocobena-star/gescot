<?
include_once("../conexion_bd.php");
//set_time_limit(0);					
$dni		=$_GET["dni"];

$cad_2="(select dni,usu_reg,fec_reg,tp_incidencia,fec_ini_inc,tiempo,factor,modo,'PROGRAMACION',id,fec_fin_inc 
from programacion_extra order by fec_reg desc)
union
(select dni,usu_reg,fec_reg,'TIEMPOxTIEMPO',fec_ini_comp,tiempo_comp,'','','COMPENSACION',id,fec_fin_comp
from compensacion_extra order by fec_reg desc)";
//echo $cad_2;
$res_2 =mysql_query($cad_2);		

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>
<script src="../funciones_js.js"></script>

<script>
function reporte_comp(){
	var iduser=document.getElementById("iduser").value;	
		
	var win=null;
	var url="../reporte_programa_extras.php?iduser="+iduser;
	win=window.open(url,true);	
}


function ventana_modal(opcion,val1,val2){

	if (opcion==1){
	var page		="../actualizar_compensacion.php?id="+val1+"&clase="+val2;
	var atributos 	="width=600px,height=350px,center=1,resize=0,scrolling=0";
	var titulo 		="EDITAR INFORMACION DE COMPENSACION DE HORAS";
	//alert(page);
	}
	
	
	modal=dhtmlmodal.open('EmailBox', 'iframe',page,titulo,atributos);	
	
	
}



</script>
<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">


<title></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
<a href="javascript:reporte_comp()" class="caja_texto_pe" >
<img src="../image/EXCELES.JPG" width="30" height="30" border="0" />Exportar</a>
<p>
<p>
<div class="tabcontent" style="overflow:scroll">  
<table  border="0" align="center" cellpadding="0" cellspacing="0" 
class="example table-autosort table-autofilter table-autopage:10 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
  <tr>
   			<?					
			
			echo "<th>PANEL<br>";				
			//echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			echo "<th class='table-filterable table-sortable:default'>TIPO</br>";	
						
			echo "<th class='table-filterable table-sortable:default'>DNI</br>";
			
			echo "<th class='table-filterable table-sortable:default'>N.COMPLETO</th>";
			
			echo "<th class='table-filterable table-sortable:default'>MODALIDAD</th>";
			
			echo "<th>FEC.REGISTRO<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>FEC.PROG.INI<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>FEC.PROG.FIN<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='table-filterable table-sortable:default'>TIEMPO</th>";
			
			echo "<th class='table-filterable table-sortable:default'>FACTOR</th>";
			
			echo "<th class='table-filterable table-sortable:default'>MODO</th>";
			
			echo "<th class='table-filterable table-sortable:default'>USER</th>";
			
									
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res_2))
		{		
		echo "<tr class='alternate'>";
				
		$q="select iduser,ncompleto,c_supervisor from tb_usuarios where dni='".$reg[0]."'";
		//echo $q;
		$rs_q = mysql_query($q);											
		$rg_q = mysql_fetch_row($rs_q);
		
		$usu="select ncompleto from tb_usuarios where iduser='".$reg[1]."'";
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
		?>
        <img src="../image/eliminar3.jpg" width="10" height="10" onclick="javascript:eliminar_extra('<? echo $reg[9]?>','<? echo $reg[8]?>')" />
		<?
		echo "</td>";
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[8]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";	
		?>
            <a href="javascript:ventana_modal('1','<? echo $reg[9]; ?>','<? echo $reg[8]; ?>')">
        <?	
		echo $reg[0]; 						
		echo "</a></td>";	
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $rg_q[1]; 				
		echo "</td>";
				
			
		echo "<td class='caja_texto_hr'>";		
		echo $reg[3]; 				
		echo "</td>";
						
		echo "<td class='caja_texto_hr'>";		
		echo $reg[2]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[4]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[10]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[5]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg[7]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $rg_usu[0]; 				
		echo "</td>";
		
		
		
	
								
		echo "</tr>";		
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
		<td  class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="10" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="12" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
