<?php
include_once("../conexion_w101.php");

$connection_w101	= db_conn_w101();

$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

//echo $idperfil;

$sql_1="select * from wt_maestra_tecnicos where estado_celular='CON TELEFONO' order by nom_tecnico";

//echo $sql_2;
$res = mysql_query($sql_1,$connection_w101);
//$reg=mysql_fetch_row($res_lis_2);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<title></title>
</head>

<body>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="6" valign="top" class="menu_sup">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="Tpresenta_R">NOTAS IMPORTANTE:
      <p>1.- SE DEBE VERIFICAR LOS 3 CAMPOS CLAVES: DNI + CARNET + CELULAR, SI ALGUNO DE ELLOS NO COINCIDEN SIGNIFICA QUE NO ESTA CONFIGURADO EN EL 101 <br />
        2.- LOS TECNICOS QUE NO APARECEN EN ESTA BANDEJA. COORDINARLO CON MARIA RESURRECCION Y/O LEYDA CHIGUAN </p></td>
  </tr>
  <tr>
    <td colspan="6" valign="top" class="menu_sup">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" ><a class="Tpresenta_R">CONSULTA MASIVA</a>
        <p> <a class="TitTablaI">1.-DESCARGAR EL FORMATO </a> <a id="" class="caja_texto_pe" style="cursor:pointer" href="../formato_101.csv" target="_blank">Descargar Formato</a> <a class="TitTablaI"> Y GUARDARLO EN D:\\</a> </p>
      <p> <br />
          <a class="TitTablaI">2.- DARLE CLICK PARA EJECUTAR LA CONSULTA </a> <a id="bt_buscar101" class="caja_texto_pe" onclick="javascript:sube_archivo_101()" style="cursor:pointer">Procesar Consulta</a> </p>
      <p> <a class="TitTablaI">3.- DARLE CLICK EN EL BOTON EXPORTAR PARA VER EL RESULTADO DE LA CONSULTA MASIVA</a> </p></td>
    <td colspan="5" class="caja_texto_sb"><div id="load_2" style="float:none"></div></td>
  </tr>
  <tr>
    <td colspan="6" valign="top" class="menu_sup">&nbsp;</td>
  </tr>
</table>

<div id="" class="tabcontent">  
<table width="100%" 
border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#99CC99" bgcolor="#FFFFFF" class="example table-autosort table-autofilter table-autopage:20 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">

<thead>
	<tr>
	<th colspan="13" align="center" class="clsHoliDayCell"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</th>
    </tr>
    
  <tr>
   			<?php					
			
			echo "<th class='filterable'>NRO.DOC";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
						
			echo "<th class='filterable'>CARNET";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable'>CELULAR";						
			echo "<input name='filter' size='20' onkeyup='Table.filter(this,this)'></th>";	
			
			echo "<th class='filterable'>NOMBRE COMPLETO";						
			echo "<input name='filter' size='50' onkeyup='Table.filter(this,this)'></th>";		
			
			echo "<th class='table-filterable'>CONTRATA</th>";			
					
			echo "<th class='table-filterable'>TIPO TECNICO</th>";
			
			echo "<th class='table-filterable'>TOA</th>";
			
			echo "<th class='table-filterable' align='center'>CONFIGURADO EN USSD-101</th>";
			
			echo "<th >FEC.CARGA</th>";
			?>	
  </tr>
</thead>
<tbody>
		<?php
		$con=0;
		while($reg=mysql_fetch_row($res))
		{	
			
		echo "<td class='caja_texto_peq'>";	
		echo $reg[3]; 		
		echo "</td>";	
	     
		echo "<td class='caja_texto_peq'>";		
		echo $reg[0];					
		echo "</td>";			
		
		echo "<td class='caja_texto_peq'>";	
		echo trim(substr($reg[10],3,15)); 		
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";
		echo $reg[1]; 		
		echo "</td>";
			
		echo "<td class='caja_texto_peq'>";		
		echo $reg[5];			
		echo "</td>";		
	
		
		echo "<td class='caja_texto_peq'>";
		echo $reg[7]; 		
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";
		echo $reg[12]; 		
		echo "</td>";
		
		echo "<td class='caja_texto_peq' align='center'>";
		if ($reg[11]=="CON TELEFONO"){
			echo "SI";
		}else{
			echo "NO";
		}
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";
		echo substr($reg[13],0,10); 		
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