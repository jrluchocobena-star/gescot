<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>

 
 <?
$QR="select * from tb_personal where dni=$dni_p and estado>0";
//echo $QR;
$RS = mysql_query($QR);											
$RG_PER=mysql_fetch_array($RS);	

if (mysql_num_rows($RS)>=1){	
$foto="fotos/".$RG_PER["dni"].".jpg";
?>
  <br>
</p>
<table width="1000" border="0" align="center" cellpadding="1" cellspacing="1" class="tabla_con_borde">
   <tr>
     <td colspan="2" align="left" class="celdas">INFORMACION PERSONAL</td>
     <td width="287" rowspan="8"><table width="150" height="158" border="0" align="center" class="tabla_con_borde">
         <tr>
           <td height="152" align="center" valign="top"><img src="<?=$foto ?>" height="150" width="150" /></td>
         </tr>
     </table></td>
   </tr>
   <tr>
     <td width="131" align="left" class="TitTablaI">CARNET</td>
     <td align="left">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">NOMBRES</td>
     <td width="576">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">APELLIDOS </td>
     <td align="left">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">DNI</td>
     <td align="left">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">BREVETE</td>
     <td align="left">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">CELULAR</td>
     <td align="left">&nbsp;</td>
  </tr>
   <tr>
     <td align="left" class="TitTablaI">RPM</td>
     <td align="left">     (No ingresar el simbolo #) </td>
  </tr>
   <tr>
     <td colspan="8" class="celdas">DATOS LABORALES</td>
   </tr>
   <tr>
     <td colspan="8">
     <table width="1000" border="0" align="left" cellpadding="0" cellspacing="0" class="tabla_con_borde">
         <tr>
           <td class="TitTablaI">FECHA INGRESO</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td width="134" class="TitTablaI">ESTADO</td>
           <td width="579">&nbsp;</td>
           <td width="287">&nbsp;</td>
         </tr>
         <tr>
           <td class="TitTablaI">CARGO</td>
           <td><div id="c_cargo" style="display:none">
                <select name="cargo" class="celda_tabla" id="cargo">
                   <option> </option>
                   <? 			
						
						$qry100 = "select cod_cargo,nom_cargo from tb_cargo";
						echo $qry100;
						$res100 = mysql_query($qry100);
											
						while ($cantres100=mysql_fetch_array($res100))
						{									
							$tmpxx = "<option value=" . $cantres100[0];
							if($cmb_motivo == $cantres100[1]) $tmpxx = $tmpxx;
							$tmpxx = $tmpxx.">".$cantres100[1]."</option>";
							echo utf8_encode($tmpxx);			
						}	
				
						?>
              </select>
                 <?=$motivo_; ?>
           </div></td>
           <td>&nbsp;</td>
         </tr>
         
         <tr>
           <td class="TitTablaI">SUPERVISOR</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <?
	  		$q2="select * from tb_empresas where idemp='".$RG_PER["contrata"]."'";
			//echo $q1;
			$rs2 = mysql_query($q2);											
			$rg_eecc=mysql_fetch_array($rs2);	
	  ?>
           <td class="TitTablaI">CONTRATA</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td class="TitTablaI">SUB-CONTRATA</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         
         <tr>
           <td class="TitTablaI" >PLACA</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td class="TitTablaI" >MODELO</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td valign="top" class="TitTablaI" >OBSERVACION</td>
           <td><textarea name="obs" cols="40" rows="5" class="celda_tabla_sin_borde"  id="obs"><?=$RG_PER["obs"]; ?>
           </textarea></td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td colspan="3"></td>
         </tr>
         <tr>
           <td colspan="3" class="titulo_tabla"><div align="center"></div></td>
         </tr>
        
         <tr>
           <td colspan="7"><div id="observaciones" style="display:none" ></div></td>
         </tr>
     </table></td>
   </tr>
</table>
 
<?  

}?>

<script language="javascript">
//var tec = 'tecnico'+<? print $empresa;?>;

var ac3 = new AC('<?php print $caja_busqueda; ?>', '<?php print $caja_busqueda; ?>');
ac3.enable_unicode();
ac3.update_input = function() {
    this.obj.value = this.div.childNodes[this.selected_option].value;
	//alert(this.obj.value);
	
}

var tecnico = new AC('<?php print $caja_busqueda; ?>');

tecnico.url = 'js/frame.php';
tecnico.highlight = true;
tecnico.update_input = function() {
    this.obj.value = this.div.childNodes[this.selected_option].value;

	
}
//document.form2.tecnico.focus();
// -->
</script>

</body>
</html>