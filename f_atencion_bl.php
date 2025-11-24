<? 
include_once("conexion_bd.php");


$c_multig	=$_GET["c_multig"];
$iduser		=$_GET["iduser"];
$c_cliente	=$_GET["c_cliente"];
$tipo		=$_GET["tipo"];
$fec_cli	=$_GET["fec_cli"];
$fec_atento	=$_GET["fec_atento"];



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
    <input type="hidden" name="c_multig" id="c_multig" value='<?=$c_multig?>'/>
    <input type="hidden" name="c_cliente" id="c_cliente" value='<?=$c_cliente?>'/>
    
<? if ($tipo=="6"){ 

$data="select * from tb_beoliquidacion where CODMULTIGESTION='$c_multig'";	
//echo $data;
$res_data = mysql_query($data);
$reg_data=mysql_fetch_row($res_data);

?>
<span class="TitTablaI">
<input name="c_multig3" type="hidden" class="caja_texto_cb" id="c_multig3" value="<? echo $c_multig;?>" />
</span>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI" width="150">NOMBRE CLIENTE</td>
    <td class="casilla_texto"><? echo $reg_data[6];?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">COD. REQUERIMIENTO</td>
    <td class="casilla_texto"><? echo "";?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">COD.CLIENTE</td>
    <td class="casilla_texto"><span class="casilla_texto"><? echo $c_cliente;?></span></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">DNI</td>
    <td class="casilla_texto"><? echo $reg_data[10];?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td width="150" valign="top" class="TitTablaI">ACCIONES</td>
    <td width="57%" class="casilla_texto">
    <select name="exc" id="exc" class="casilla_texto" >
        <? 		
			
			$sql7="select * from tb_motivos_beo";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA CLIENTE</td>
    <td class="casilla_texto"><? echo $fec_cli;?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA ATENTO</td>
    <td class="casilla_texto"><? echo $fec_atento;?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">OBSERVACION ATENTO</td> 
    <td class="casilla_texto"><? echo $reg_data[20];?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">OBSERVACION
    <br></td>
    <td><textarea name="obs" cols="50" rows="5" class="casilla_texto" id="obs"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">
    <table width="225" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="89" class="caja_textop" onclick="javascript:grabar_asignacion_bl('<? echo $c_multig ?>')">
          <img id='bt_aceptar' src='image/visto2.jpg' alt='' 
          width='25' height='25'  />Grabar</td>
          <td width="10" >&nbsp;</td>
          <td width="102" class="caja_textop" onclick="JAVASCRIPT:cerrar_win('5')">
          <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>
          <td width="24">&nbsp;</td>
        </tr>
    </table></td>
  </tr>  
</table>
<? } ?>

<? if ($tipo=="7"){

$data_1 	="select * from cab_beoliquidaciones_cot where CODMULTIGESTION='$c_multig'";	
//echo $data_1;
$res_data_1 = mysql_query($data_1);
$reg_data_1 = mysql_fetch_row($res_data_1);

$usu="select * from tb_usuarios where iduser='$reg_data_1[2]'";
$res_usu = mysql_query($usu);
$reg_usu =mysql_fetch_row($res_usu);

$mot="select * from tb_motivos_beo where cod_mot='".$reg_data_1[10]."'";
		//echo $s;
$rs_mot= mysql_query($mot);											
$rg_mot = mysql_fetch_row($rs_mot);
		
	
?>
<table width="70%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">COD. REQUERIMIENTO</td>
    <td class="caja_texto_hr"><span class="casilla_texto"><? echo "";?></span></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">COD.CLIENTE</td>
    <td class="caja_texto_hr"><span class="casilla_texto"><? echo $reg_data_1[11];?></span></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td width="16%" valign="top" class="TitTablaI">ACCIONES</td>
    <td width="47%" class="caja_texto_hr"><? echo $rg_mot[1]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA CLIENTE</td>
    <td class="caja_texto_hr"><? echo $reg_data_1[4]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA ATENTO</td>
    <td class="caja_texto_hr"><? echo $reg_data_1[6]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA REGISTRO</td>
    <td class="caja_texto_hr"><? echo $reg_data_1[3]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">FECHA CIERRE</td>
    <td class="caja_texto_hr"><? echo $rg_mot[7]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td class="caja_texto_hr">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">GESTOR</td>
    <td class="caja_texto_hr"><? echo $reg_usu[1]?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">OBSERVACION</td>
    <td class="caja_texto_hr"><? echo $reg_data_1[9]; ?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">
    <table width="225" border="0" cellpadding="0" cellspacing="0">
        <tr>          
          <td width="94" class="caja_textop" onclick="JAVASCRIPT:cerrar_win('2')">
          <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>
          <td width="115">&nbsp;</td>
        </tr>
    </table></td>
  </tr>  
</table>
<? } ?>
</body>
</html>