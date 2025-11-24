<?
include_once("../conexion_bd.php");
//set_time_limit(0);					
$dni		=$_GET["dni"];

$cad="select * from programacion_extra where dni='$dni'order by fec_ini_inc desc";
//<echo $cad;
$res =mysql_query($cad);		

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>


<script>
var XmlHttp = null;   

function createRequest()
{
	try {ajaxc = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e) {
			try {ajaxc = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (E) {ajaxc = false;}
	}
	if (!ajaxc && typeof XMLHttpRequest!='undefined') {
	   ajaxc = new XMLHttpRequest();
	}
	return ajaxc;
}

function mostrar_detalle(correlativo){
	
	
	var pag1 = "bandeja_det_programacion.php?correlativo="+correlativo;
	
	//alert(pag1);
	
	ajaxc = new createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 				
		//alert(ajaxc.responseText);
		parent.document.getElementById("d_detalle").style.display="block";  		
		parent.document.getElementById("d_detalle").innerHTML=ajaxc.responseText;				
        }
	}
	ajaxc.send(null)

}

function ventana_modal(opcion){
	
	if (opcion=="1"){
	var page="detalle_num_contacto.php?id="+val1+"&dni="+val2+"&origen="+val4+"&iduser="+val3+"&ccliente="+val5;
	//alert(page);
	}
	
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Actualizacion de Informacion Del Cliente', 'width=1100px,height=250px,center=1,resize=0,scrolling=0');	
	
	
}


</script>
<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">

<title></title>
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
			
			echo "<th>FEC.PROGRAMADA<br>";
			echo "<input name='filter' size='25' maxlength='20' onkeyup='Table.filter(this,this)'></th>";
			
			//echo "<th class='table-filterable table-sortable:default'>FEC.FIN</th>";
			
			echo "<th class='table-filterable table-sortable:default'>TIEMPO</th>";
												
			echo "<th>USUARIO</br>";		
			
			echo "<th class='table-filterable table-sortable:default'>MOTIVO</br>";							
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
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
		echo "<td>";		
		echo $reg[1]; 				
		echo "</td>";
		
		echo "<td>";			
		echo $rg_q[1]; 				
		echo "</td>";
				
			
		echo "<td>";		
		echo $reg[6]; 				
		echo "</td>";
						
		/*
		echo "<td>";		
		echo $reg[7]; 				
		echo "</td>";
		*/
		echo "<td>";		
		echo $reg[10]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $rg_usu[0]; 				
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
		<td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="3" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
	<tr>
	<td colspan="6" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>
</body>
</html>
