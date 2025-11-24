<?php
include_once("../conexion_bd.php");
//set_time_limit(0);					
$a_actual = date("Y");
$iduser=$_GET["iduser"];
$idperfil=$_GET["perfil"];

$cad_2    ="select * from horarios_gestores_cot where supervisor='$iduser' GROUP BY DNI order by ncompleto asc";
//echo $cad_2;
$res_2    =mysql_query($cad_2);		

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
<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">


<title></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>

<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
<a class="caja_texto_pe" href="javascript:javascript:cerrar_win('3')"><img src="../image/act.jpg" width="20" height="20" border="0"/>Actualizar</a>
<p>
    <div>
    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="caja_texto_peke">
      <tr>
        <td><a class="aviso_horario">Nota Importante: </a>
        <a class="caja_sb">Si los horarios aparecen como S/H signfica que no tienen horario asignado, por lo tanto 
        Se tienen comunicar con Torre de Control para que se regularice y pueda aparecer su horario. 
        La GESCOT no registra,ni actualiza ni elimina horarios del personal COT</a>
        </td>
      </tr>
    </table>
    </div>
    
<br>    
<div id="div_cambiohorario" style="display: none">
  <table width="60%" border="0" class="marco_tabla">
  <tbody>
    <tr>
      <td width="46" valign="top">Horario</td>
      <td width="71" valign="top">
          <select name="c_horario" id="c_horario" class="caja_texto_pe" >
          <?php
         
			print "<option value='0' selected>Seleccione...</option>";
			$sql1="SELECT cod_horario,descripcion_1 FROM horarios_rrhh WHERE descripcion_1<>'' GROUP BY 1 order by 1";
            
		  	$queryresult1 = mysql_query($sql1) or die (mysql_error()); 
			while ($rowper1=mysql_fetch_row($queryresult1)) { 										  
			print "<option value='$rowper1[0]'>".$rowper1[0]."-".$rowper1[1]."</option>";
            }
			?>
          </select></td>
      <td width="109" valign="top">Observacion</td>
      <td width="260" valign="top"><input id="obs_hor" type="text" class="caja_texto_peq" size="50" /></td>
      <td width="55" class="caja_texto_pe" align="center" onClick="javascript:actualizar_horarios()">Aceptar</td>
    </tr>
  </tbody>
</table>
</div>

<input type="HIDDEN" name="x_dni" id="x_dni"/>
<input type="HIDDEN" name="f_horario" id="f_horario"/>
<input type="HIDDEN" name="hor_ant" id="hor_ant"/>
    
<p>
<div class="tabcontent" style="overflow:auto">  
<table width="95%"  border="0" cellpadding="0" cellspacing="0" align="center"
class="example table-autosort table-autofilter table-autopage:20 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
<thead>
<tr>
  <td colspan="10" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>\bandejas\bandeja_general_horarios_cot.php</a>"; ?></td>
</tr>
<tr>
   			<?php
    
            //echo "<th class='table-filterable table-sortable:default'>SUPERVISOR</th>";-->
            echo "<th>ITEM</th>";
    
			echo "<th>NOMBRE COMPLETOS<br>";
			echo "<input name='filter' size='50' onkeyup='Table.filter(this,this)'></th>";
			
				
			echo "<th>DNI<br>";
			echo "<input name='filter' size='10' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th>CIP<br>";
			echo "<input name='filter' size='10' onkeyup='Table.filter(this,this)'></th>";
			
			/*
			echo "<th class='table-filterable table-sortable:default'>CARGO</th>";	
			*/
    
			echo "<th class='table-filterable table-sortable:default'>COD.HORARIO</th>";	
					
			echo "<th>DESCRIPCION HORARIOS</th>";	
			
			echo "<th>HR.INCIAL</th>";
			
			echo "<th>HR.FINAL</th>";
    
            echo "<th>FECHA CARGA</th>";
			
			
			
			?>	
  </tr>
</thead>
<tbody>
		<?php
		$con=1;
    
        
    
		while($reg=mysql_fetch_row($res_2))
		{	
          $con= $con + 1;		
          $txt = "txt_horario_".$con;
          $fila = "fila_".$con;
            
		echo "<tr id='$fila' name='$fila' >";
        
       
       
            
		$hor	="select * from horarios_rrhh WHERE cod_horario='$reg[4]'";
		//echo $hor;
		$res_hor =mysql_query($hor);		
		$reg_hor =mysql_fetch_row($res_hor);
        
            /*
        echo "<td>";		//supervisor
		echo $reg[3]; 				
		echo "</td>";
		*/
            
        echo "<td>";		//ITEM
		echo $con; 				
		echo "</td>";
            
		echo "<td>";		//nombre
		echo $reg[2]; 				
		echo "</td>";
						
		echo "<td>";		//dni
        ?>    
		<a href="javascript:mostrar_historico_horarios('<?php echo $reg[0]; ?>','<?PHP echo $fila; ?>');"><?php echo $reg[0];  ?></a> 			
        <?php
		echo "</td>";
		
		echo "<td>";		//cip
		echo $reg[1]; 				
		echo "</td>";
							
		/*
		echo "<td>";		//cargo
		echo $reg[4]; 				
		echo "</td>";
			*/
       
        
		echo "<td align='right'>";        
		echo "<input id='$fila' type='text' class='caja_sb_rojo' name='$fila' style='display: none' 
        onkeypress='return event.charCode >= 48 && event.charCode <= 57' />"; 
        echo $reg[5];
        ?>
    &nbsp;
    <img src="../image/lapiz1.jpg" width="15" height="15" alt="" onDblClick="javascript:editar_chorario('<?PHP echo $reg[0]; ?>',
        '<?PHP echo $fila; ?>','<?PHP echo $reg[5]; ?>')"/>     
        
        <?php
		echo "</td>";
			
		echo "<td>";		//descripcion
		echo $reg[6]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[8]; 				
		echo "</td>";
		
		echo "<td>";		
		echo $reg[9]; 				
		echo "</td>";
		
	    echo "<td>";		
		echo $reg[11]; 				
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
	<tr>
	<td colspan="10" align="center"><span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)</td>		
	</tr>
</tfoot>		
</table>			
</div>

<br> 
<div id="div_historico_cambiohorarios">
</div>    
    
    
</body>
</html>
