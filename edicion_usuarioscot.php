<?php
include("conexion_bd.php");

$iduser		=$_GET["iduser"];
$idperfil	=$_GET["idperfil"];
$dni		=$_GET["dni"];
$dato		=$_GET["dato"];
$aplicativo	=$_GET["aplicativo"];
$est		=$_GET["est"];

//echo $est;
	$sql_0="(select * from movimientos_maestra where dni='$dni' and aplicativo='$aplicativo'
	)union(select * from historico_usuarios_maestra where dni='$dni' and aplicativo='$aplicativo' and est='DESACTIVADO') order by fec_mov desc";
	//echo $sql_0;			
	$res_sql_0= mysql_query($sql_0);	
	$nreg_sql_0 = mysql_num_rows($res_sql_0);
	//echo $nreg_sql_0;
	
	//echo $est;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<input name="est" type="hidden" class="casilla_texto" id="est" value="<?php echo $est; ?>"/>

<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4%" class="caja_texto_pe">DNI</td>
    <td width="8%" class="caja_texto_pe"><input name="dni_1" type="text" class="caja_sb" id="dni_1" size="15" value="<?php echo $dni; ?>" /></td>
    <td width="4%" class="caja_texto_pe">DATO</td>
    <td width="8%" class="caja_texto_pe">
	<input name="usu_1" type="text" class="caja_sb" id="usu_1" size="15" value="<?php echo $dato; ?>" />
	<input name="usu_ant" type="hidden" class="caja_sb" id="usu_ant" size="15" value="<?php echo $dato; ?>" />
	</td>
    <td width="8%" class="caja_texto_pe">APLICATIVO</td>
    <td width="26%" class="caja_texto_pe"><input name="aplicativo_1" type="text" class="caja_sb" id="aplicativo_1" size="50" value="<?php echo $aplicativo; ?>" /></td>
    <td width="42%" class="caja_texto_pe"><table width="50%" border="0">
      <tr>
        <td width="29">
		<?php
		if ($dato=="-" or $est=='NUEVO'){		
		}else{
		if ($est=="CREADO"){?> 
			<img src="image/eliminar.jpg" title="DESACTIVAR" width="25" height="25" onclick="javascript:cambios_usuariocot('1')";/>
        <?php }else{ ?>
			<img src="image/vis.jpg" title="ACTIVAR" width="25" height="25" onclick="javascript:cambios_usuariocot('1')";/>
		<?php }  
		}?>
		</td>
		<td width="22">&nbsp;</td>
        <td width="25"><img src="image/grabar.jpg" title="ACTUALIZAR"
		width="25" height="25" onclick="javascript:cambios_usuariocot('2');" /></td>
        <td width="24">&nbsp;</td>
        <td width="38"><img src="image/BT5.gif" title="CERRAR"
		width="25" height="25" onclick="javascript:cerrar_edicion_usuarios()" /></td>
        <td width="31">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<div style="overflow:auto; height:auto">
<?php
			echo "<table width='100%' >";	
			
			echo "<tr>";	
			echo "<td class='txtlabel'>DNI</td>";	
			echo "<td class='txtlabel'>USUARIO </td>";															
			echo "<td class='txtlabel'>APLICATIVO</td>";	
			echo "<td class='txtlabel'>USU.MOV</td>";
			echo "<td class='txtlabel'>FEC.MOV</td>";
			echo "<td class='txtlabel'>ESTADO</td>";								
			echo "</tr>";
	
			while($reg_sql_0 = mysql_fetch_row($res_sql_0)){	
				
			echo "<tr>";			
					
			echo "<td class='clsDataArea'>";				
			echo $reg_sql_0[1];
			echo "</td>";
			
			echo "<td class='clsDataArea'>";			 			
			echo $reg_sql_0[2];
			echo "</td>";
			
			
			echo "<td class='clsDataArea'>";					
			echo $reg_sql_0[3];
			echo "</td>";
			
			$sql_usu="select * from tb_usuarios where iduser='$reg_sql_0[8]'";
			//echo $sql_0;		
			$res_usu = mysql_query($sql_usu);
			$reg_usu = mysql_fetch_row($res_usu);
			
			echo "<td class='clsDataArea'>";					
			echo $reg_usu[1];
			echo "</td>";
			
			
			echo "<td class='clsDataArea'>";					
			echo $reg_sql_0[5];
			echo "</td>";
			
			echo "<td class='clsDataArea'>";			
			echo $reg_sql_0[10];
			echo "</td>";
			
			}
 ?>
</div>
<span class="caja_texto_pe">

</span>
</body>
</html>
