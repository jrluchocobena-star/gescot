<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");



$iduser=$_GET["iduser"];
$cip=$_GET["cip"];
$c_inc=$_GET["c_inc"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

echo $c_inc;

$sql_2="select * from tb_usuarios where estado='HABILITADO' GROUP BY DNI ";
//echo $sql_2;
$res = mysql_query($sql_2);
$reg=mysql_fetch_row($res);

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

<script language="JavaScript" src="../calendar1.js"></script> 

<link href="../estilos.css" rel="stylesheet" type="text/css" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">

<script language="javascript">



</script>

<title>LISTADO DE PARTICIPANTES</title>
</head>

<body>
<input name="arr_escogidos" type="hidden" class="caja_sb_st" id="arr_escogidos" readonly />
<input name="cip" type="hidden" class="casilla_texto" id="cip" value="<?php echo $reg[3];?>" />
<input name="dni" type="hidden" class="casilla_texto" id="dni" value="<?php echo $reg[4];?>" />
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil;?>" />
<input name="tp_incidencia" type="hidden" class="casilla_texto" id="tp_incidencia" value="<?php echo "MONITOREO Y CAPACITACION COT";?>" />
<input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<?php echo $c_inc;?>" />
<input name="chk_escogidos" type="hidden" class="caja_texto_sb" id="chk_escogidos" />
<input name="tt_c" type="hidden" class="caja_texto_sb" id="tt_c" />


<input name="chk_escogidos_" type="text" class="caja_texto_sb" id="chk_escogidos_" size="30" />
<table width="100%">
<tr>		
        <td colspan="3">
        <input name="opc" type="hidden" class="caja_texto_sb" id="opc" />
        <div id="d_supervisor" style="display:none">
        <table width="80%" border="0" class="marco_tabla">
          <tr>
            <td width="19%" class="TitTablaI">SUPERVISOR</td>
            <td width="61%">
            <select name="c_supervisor" id="c_supervisor" class="caja_texto_pe" >
              <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select * from tb_supervisores where est='1'";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select></td>
            <td width="20%" class="caja_texto_pe" onclick="javascript:grabar_cambios2()">
            <img src="../image/BT4.gif" width="30" height="30" />ACEPTAR</td>
          </tr>
        </table> 
        </div>
        
        <div id="d_monitor" style="display:none">
        <table width="80%" border="0" class="marco_tabla">
          <tr>
            <td width="19%" class="TitTablaI">MONITOR</td>
            <td width="61%"><select name="c_monitor" id="c_monitor" class="caja_texto_pe" >
              <? 			
			print "<option value='0' selected>Seleccione Monitor</option>";
			$sql7="select * from tb_monitores";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select></td>
           <td width="20%" class="caja_texto_pe" onclick="javascript:grabar_cambios2()">
            <img src="../image/BT4.gif" width="30" height="30" />ACEPTAR</td>
          </tr>
        </table> 
        </div>
        
        <div id="d_locales" style="display:none">
        <table width="80%" border="0" class="marco_tabla">
          <tr>
            <td width="19%" class="TitTablaI">LOCALES</td>
            <td width="61%"><select name="c_local" id="c_local" class="caja_texto_pe" >
              <? 			
			print "<option value='0' selected>Seleccione Local</option>";
			$sql7="select * from tb_locales";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select></td>
            <td width="20%" class="caja_texto_pe" onclick="javascript:grabar_cambios2()">
            <img src="../image/BT4.gif" width="30" height="30" />ACEPTAR</td>
          </tr>
        </table> 
        </div>
        
        <div id="d_olas" style="display:none">
        <table width="80%" border="0" class="marco_tabla">
          <tr>
            <td width="19%" class="TitTablaI">OLAS</td>
            <td width="61%"><select name="c_olas" id="c_olas" class="caja_texto_pe" >
              <option value="0">Seleccione Ola</option>
              <option value="OLA 1">OLA 1</option>
              <option value="OLA 2">OLA 2</option> 
              <option value="OLA 3">OLA 3</option>
              <option value="OLA 4">OLA 4</option> 
              <option value="OLA 5">OLA 5</option>
              <option value="OLA 6">OLA 6</option> 
              <option value="OLA 7">OLA 7</option>
              <option value="OLA 8">OLA 8</option> 
              <option value="OLA 9">OLA 9</option>
              <option value="OLA 10">OLA 10</option>             
              <option value="OLA 11">OLA 11</option>             
              <option value="OLA 12">OLA 12</option>             
              <option value="OLA 13">OLA 13</option>   
              <option value="OLA CUZ">OLA CUZ</option>   
              <option value="OLA ARE">OLA ARE</option>   
              <option value="OLA CHI">OLA CHI</option>   
              <option value="OLA PIU">OLA PIU</option>                           
            </select></td>
            <td width="20%" class="caja_texto_pe" onclick="javascript:grabar_cambios2()">
            <img src="../image/BT4.gif" width="30" height="30" />ACEPTAR</td>
          </tr>
        </table> 
        </div>
        
        </td>
        <td width="41%" colspan="2" align="right"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="19%" class="caja_texto_pe" id="add_part" onclick="javascript:mostrar_cambios('1')">
                <img src="../image/BT1.gif" width="30" height="30" />Supervisor</td>
                 <td width="19%" class="caja_texto_pe" id="add_part" onclick="javascript:mostrar_cambios('2')">
                <img src="../image/ima50.png" width="30" height="30" />Monitores</td>
                 <td width="19%" class="caja_texto_pe" id="add_part" onclick="javascript:mostrar_cambios('3')">
                <img src="../image/inicio.jpg" width="30" height="30" />Locales</td>   
                <td width="19%" class="caja_texto_pe" id="add_part" onclick="javascript:mostrar_cambios('4')">
                <img src="../image/BT1.gif" width="30" height="30" />Olas</td>                
                <td width="22%" class="caja_texto_pe" onclick="javascript:cerrar_win('3')"><img src="../image/SAL.jpg" width="20" height="20" />Salir</td>
              </tr>
		</table>

    </td>
  </tr>
</table>
<br>
<div id="lista_participantes" style="overflow:scroll">  
  <table width="80%" 
 class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page over:auto  table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">

<thead>
	
  <tr>
   		<?php					
			
			//echo "<th>ITEM</th>";				
			echo "<th>...</th>";
			
			echo "<th class='filterable' align='left'>CIP";						
			echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
			
			echo "<th class='filterable' align='left'>DNI";						
			echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
				
			echo "<th class='filterable' align='left'>NOMBRES(CON MAYUSCULA)";						
			echo "<input class='caja_texto_pe' name='filter' size='40' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			/*
			echo "<th class='filterable' align='left'>DNI";						
			echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
				*/		
			
			
			echo "<th class='table-filterable table-sortable:default'>LOCALES</th>";
			/*
			echo "<th class='table-filterable table-sortable:default'>MONITOR</th>";
			
			echo "<th class='table-filterable table-sortable:default'>LOCALES</th>";
			*/
			
			?>	
  </tr>
</thead>
<tbody>
		<?php
		$i=0;
		while($reg=mysql_fetch_row($res))
		{	
		
			$s="select ncompleto from tb_usuarios where iduser='".$reg[21]."'";
		//echo $s;
			$rs_s = mysql_query($s);											
			$rg_s = mysql_fetch_row($rs_s);
		
		//$m="select nom_monitor from tb_monitores where cod_monitor='".$reg[5]."'";
		//echo $s;
		//$rs_m = mysql_query($m);											
		//$rg_m = mysql_fetch_row($rs_m);
		
		//$lo="select nom_local from tb_locales where cod_local='".$reg[6]."'";
		//echo $s;
		//$rs_lo = mysql_query($lo);											
		//$rg_lo = mysql_fetch_row($rs_lo);
				
		echo "<tr class='alternate'>";		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$i = $i + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
			
		echo "<td>";
		//echo "check".$i."|".$reg[2];
		?>
    <input type="checkbox" name="<?php echo "check".$i; ?>" id="<?php echo "check".$i; ?>" value="<?php echo $reg[2]; ?>" 
    onclick="javascript:escojer_gestor()" /> 
        <?php
		echo "</td>";
		
		echo "<td>";		//CIP		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";		//DNI		
		echo $reg[2]; 				
		echo "</td>";
		
		echo "<td>";
		echo $reg[1]; 		//NOMBRE	
		echo "</td>";
		
		
		echo "<td>";		// LOCAL		
		//echo $rg_lo[0];
    echo $reg[10];
		echo "</td>";
		
		
		/*
		echo "<td>";		// monitor		
		echo $rg_m[0]; 				
		echo "</td>";
		
	
				
		echo "<td>";		//olas		
		echo $reg[7]; 				
		echo "</td>";
		
		*/
		echo "</tr>";	
				
		}		
	?>
</tbody>		

</table>
</div>

<div id="registro_cap" style="display:none">
<table width="90%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <!--
    <td width="94" valign="top" class="clsCurrentMonthDay">TRABAJADOR</td>
    <td colspan="2"><select name="gestor" id="gestor" class="caja_sb" >
      <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql7="select cip,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1] - $rowper[0]</option>";
			}
			?>
    </select>

	</td>
   -->
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">CODIGO</td>
    <td colspan="2"><input name="c_incx" type="text" class="aviso" id="c_incx" size="30" readonly /></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">TEMA</td>
    <td colspan="2"><select name="combo_mot" id="combo_mot" class="caja_texto_pe">
            <option value="0">Escoger Tema</option>
            <?
			$sql7="select * from tb_motivos_incidencia where tp_inc='MONITOREO Y CAPACITACION COT'";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">MODO</td>
    <td width="5232" colspan="2"><select name="modo" size="1" class="caja_texto_pe" id="modo" 
    onchange="javascript:mostrar_modo_inc(this.value);" > 
      <option value="0">Seleccionar</option>
      <option value="D">DIAS</option>
      <option value="H">HORAS</option>      
      </select></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr> 
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">
    
    <form name="form1">
    <div id="f_dias" style="display:NONE">        
    <table width="100%" class="marco_tabla">
      <tr>
        <td width="18%" class="caja_sb">FEC. INICIO </td>
        <td width="34%">
          <input readonly="readonly" name="input1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input1" />
          <a href="javascript:cal1.popup();"> 
          <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a></span>
          </td>
        <td width="11%" class="caja_sb">FEC. FIN  </td>
        <td width="37%">
          <input readonly="readonly" name="input2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input2" />
          <a href="javascript:cal2.popup();"> 
          <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></span></td>
        </tr>
    </table>        
    </div>
    <div id="f_horas" style="display:none">
     <table width="100%"  class="marco_tabla">
    	<tr>
    	  <td width="18%" class="caja_sb">FECHA  </td>
    	  <td colspan="5">
    	    <input readonly="readonly" name="input3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input3" />
    	    <a href="javascript:cal3.popup();"> 
    	      <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></span></td>
  	  </tr>
    	<tr>
    	  <td class="caja_sb">&nbsp;</td>
    	  <td width="12%">HORAS</td>
    	  <td width="13%">MINUTOS</td>
    	  <td class="caja_sb">&nbsp;</td>
    	  <td width="12%">HORAS</td>
    	  <td width="27%">MINUTOS</td>
  	  </tr>
    	<tr>
        <td width="18%" class="caja_sb">HORA INICIO</td>
        <td><label for="tiempo_1"></label>
          <select name="h_ini" size="1" class="caja_texto_cb" id="h_ini" >
            <option value="0"> </option>         
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>           
          </select>
          :          </td>
        <td><select name="mm_ini" size="1" class="caja_texto_cb" id="mm_ini" >
          <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select></td>
        <td width="18%" class="caja_sb">HORA FIN</td>
        <td>
        <select name="h_fin" size="1" class="caja_texto_cb" id="h_fin" 
        onchange="javascript:validar_horas(this.value);" >
          <option value="0"> </option>          
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>         
        </select>
          :          </td>
        <td><select name="mm_fin" size="1" class="caja_texto_cb" id="mm_fin" >
          <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
             <option value="45">45</option>
        </select></td>
        </tr>
    </table>       
    </div>
    </form> 
     <script language="JavaScript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;
										
                        
                        var cal2 = new calendar1(document.forms["form1"].elements['input2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						
						var cal3 = new calendar1(document.forms["form1"].elements['input3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;									
                        
						
                        
        </script>
    </td>
  </tr>
   <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
     <td colspan="2">
     <input name="tiempo" type="text" class="caja_texto_pe" id="tiempo" size="5" readonly="readonly" />
    <input name="exc" type="hidden" class="caja_texto_pe" id="exc" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
     <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
  </tr> 
  <tr>
    <td valign="top" class="clsCurrentMonthDay">OBSERVACION</td>
    <td colspan="2"><textarea name="obs" cols="50" rows="3" class="caja_texto_pe" id="obs" onclick="javascript:calcular_tiempos_capa()"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" class="clsCurrentMonthDay">&nbsp;</td>
  </tr>
</table>
</div>
</body>
</html>