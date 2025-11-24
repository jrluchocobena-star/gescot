<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];

$cip=$_GET["cip"];
$dni=$_GET["dni"];

if ($cip=="" and $dni==""){
$cad="";
}else{
	if ($cip==""){
	$cad=" and dni=trim('$dni')";
	}else{
	$cad=" and cip=trim('$cip')";	
	}		
}

  $sql_usu = "select * from tb_usuarios where sgrupo like '%ASIGNACIONES%' $cad order by ncompleto";
 // echo $sql_usu;
  $res_USU = mysql_query($sql_usu);											
  $nreg= mysql_num_rows($res_USU);
  
  
  $i=0;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript" src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="80%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
      <table width="90%" >
        <tr>
          <td colspan="7" class="ecabezado_verde">BANDEJA DEL AREA DE ASIGNACIONES</td>
        </tr>
        <tr>
          <td colspan="6" class="resaltado" align="center">SE ENCONTRARON <? echo $nreg." REGISTROS"; ?></td>
        </tr>
        <tr class="TitTablaC" >
          <td width="5%" align="center">ITEM</td>
          <td width="20%">CRITERIO ACTUAL</td>
          <td width="40%">NOMBRE COMPLETO</td>
          <td width="10%">TP. SERVICIO</td>
          <td width="10%">ESTADO</td>
          </tr>
        <?

  while($reg_USU=mysql_fetch_row($res_USU)){		
  
  ?>
        <tr>
          <td class="casilla_texto" align="center"><? echo $i=$i+1; ?></td>
          <td class="casilla_texto"><? 
	$cc="select * from reglas where iduser='$reg_USU[0]'";
	//echo $cc;
	$res_cc = mysql_query($cc);											
	$reg_cc=mysql_fetch_row($res_cc);
	
	//echo $reg_cc[2];
	?>            
            <input type="text" class="casilla_texto" id="<? echo "criterio_1".$i; ?>" value="<? echo  $reg_cc[2]; ?>" size="10" />
          <input type="text" class="casilla_texto" id="<? echo "criterio_2".$i; ?>" value="<? echo  $reg_cc[3]; ?>" size="10" /></td>
          <td class="texto_inv" ><? echo $reg_USU[2]; ?>
		  <? echo "-". $reg_USU[1]; ?></td>
          <? if ($reg_USU[13]=="ASIGNACIONES"){?>
          <td><select name="criterio_2" class="casilla_texto" id="criterio_2" 
          onchange="javascript:asignar_reglas('<? echo $reg_USU[0];?>',this.value,'<? echo $i; ?>','criterio_2')">
            <option value="0">SELECCIONAR</option>
            <option value="GESTEL-423">GESTEL-423</option>
            <option value="CMS">CMS</option>
            <option value="AMBOS">AMBOS</option>
            <option value="N/A">NINGUNO</option>
          </select></td>
          <? }else{ ?>
          <td class="casilla_texto">NO ASIGNACIONES</td>
          <? } ?>
          <td><select name="criterio_1" class="casilla_texto" id="criterio_1" onchange="javascript:asignar_reglas('<? echo $reg_USU[0];?>',this.value,'<? echo $i; ?>','criterio_1')">
            <option value="0">SELECCIONAR</option>
            <option value="HABILITADO">ACTIVAR</option>
            <option value="DESHABILITADO">DESACTIVAR</option>
          </select></td>          
        </tr>
        <? } ?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>