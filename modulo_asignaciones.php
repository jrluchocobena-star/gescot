<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$origen=$_GET["origen"];

$zon=$_GET["zon"];	

if ($zon=="0"){
	$cad="";
}else{	
	$cad=" and zonal='$zon'";
	
}
	


$sql_2="SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.origen,a.estado,a.zonal
FROM carga_pedidos_total a LEFT JOIN cab_asignaciones_cot b 
ON a.peticion = b.peticion
WHERE a.estado='0' and a.origen='$origen' $cad
ORDER BY RAND(), a.estado asc, a.peticion desc, a.FECHA_REG ASC LIMIT 1";
//echo $sql_2;

$res_lis_2 = mysql_query($sql_2);

$nreg = mysql_num_rows($res_lis_2);

//echo $nreg;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title></title>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<table width='100%'>
<? if ($nreg==1){?>
  <?	
 while($reg_lis=mysql_fetch_row($res_lis_2)){	 
   
 $cc="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[6]'";		
 $res_cc = mysql_query($cc);
 $reg_cc=mysql_fetch_row($res_cc);	
  
 $data="select * from tb_gestel_423 where inscripcion='$reg_lis[2]'";	
 $res_data = mysql_query($data);
 $reg_data=mysql_fetch_row($res_data);	
	  
	  if ($reg_lis[5]=="GESTEL-423"){?>
	  			<tr>
				  <td width="12%" class='cabec_1' colspan="2">PETICION</td>
				  <td width="13%" class='cabec_1'>PEDIDO</td>
				  <td width="15%" class='cabec_1'>INSCRTIPCION</td>
				  <td width="6%" class='cabec_1'>AGRUP.</td>
				  <td width="6%" class='cabec_1'>CIUDAD</td>
				  <td width="30%" class='cabec_1' >DIRECCION</td>
				  <td width="6%" class='cabec_1'>ZONAL</td>
				  <td width="10%" class='cabec_1'>FEC. REGISTRO</td>
				  <td width="6%" class='cabec_1'>ORIGEN</td>
				  <td width="6%" class='cabec_1'>ESTADO</td>
				  <td width="6%" class='cabec_1'>SEMAFORO</td>
				</tr>
				<tr>
				<td class='caja_texto1_n' id='celda_asignar_on'><img src="image/visto1.jpg" alt="" width="25" height="25" 
					onclick="javascript:validar_pedido('<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
					'<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" border="1" />
				</td>
				<td class='caja_texto1_n'> <? 	echo $reg_lis[0]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[1]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[2]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_data[13]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_data[0]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[3]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[7]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[4]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_lis[5]; ?></td>
				  <td class="caja_texto1_n"><? echo $reg_cc[1]; ?></td>
				  <td class="caja_texto1_n">
				  <? if ($reg_lis[6]=="1" and $reg_lis[6]=="3"){ ?>
					<img src="image/semaforo_r.JPG" width="30" height="30" />
					<? }?>
					
					<? if ($reg_lis[6]=="0"){ ?>
					<img src="image/semaforo_v.JPG" width="30" height="30" />
					<? }?>
				  </td>
				</tr>
	<? } ?>
    
	<? if ($reg_lis[5]=="CMS"){
	
	  $cc1="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[6]'";		
	  $res_cc1 = mysql_query($cc1);
	  $reg_cc1=mysql_fetch_row($res_cc1);	
	  
	?>
				  <tr> 	
				  <td class='cabec_1' colspan="2">REQUERIMIENTO</td>
				  <td class='cabec_1'>PEDIDO</td>
				  <td class='cabec_1'>COD.CLIENTE</td>
				  <td class='cabec_1' width="30%">DIRECCION</td>
				  <td class='cabec_1'>ZONAL</td>
				  <td class='cabec_1'>FEC. REGISTRO</td>
				  <td class='cabec_1'>ORIGEN</td>
				  <td class='cabec_1'>ESTADO</td>
				  <td width="6%" class='cabec_1'>SEMAFORO</td>
				  </tr>
					<tr>
					  <td class='caja_texto1_n' 
					  id='celda_asignar_on'><img src="image/visto1.jpg" alt="" width="25" height="25" 
							onclick="javascript:validar_pedido('<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
							'<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" border="1" />
	                  </td>
					  <td class="caja_texto1_n"><? 	echo $reg_lis[0]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_lis[1]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_lis[2]; ?></td>
					  <td height="10%"  class="caja_texto1_n"><? echo $reg_lis[3]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_lis[7]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_lis[4]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_lis[5]; ?></td>
					  <td class="caja_texto1_n"><? echo $reg_cc1[1]; ?></td>      
					  <td class="caja_texto1_n">
						<? if ($reg_lis[6]=="1" and $reg_lis[6]=="3"){ ?>
						<img src="image/semaforo_r.JPG" width="30" height="30" />
						<? }?>
						
						<? if ($reg_lis[6]=="0"){ ?>
						<img src="image/semaforo_v.JPG" width="30" height="30" />
						<? }?>
					  </td>  
					</tr>
		<? }
 }?>
	<tr>
	<td colspan='12' class='cabec_1'>&nbsp;</td>
	</tr>
<? }else{   
	if ($origen=="GESTEL-423"){?>
      <td width="12%" class='cabec_1' colspan="2">PETICION</td>
      <td width="13%" class='cabec_1'>PEDIDO</td>
      <td width="15%" class='cabec_1'>INSCRTIPCION</td>
      <td width="6%" class='cabec_1'>AGRUP.</td>
      <td width="6%" class='cabec_1'>CIUDAD</td>
      <td width="30%" class='cabec_1' >DIRECCION</td>
      <td width="6%" class='cabec_1'>ZONAL</td>
      <td width="10%" class='cabec_1'>FEC. REGISTRO</td>
      <td width="6%" class='cabec_1'>ORIGEN</td>
      <td width="6%" class='cabec_1'>ESTADO</td>
      <td width="6%" class='cabec_1'>SEMAFORO</td>
    </tr>
    <? } 
    if ($origen=="CMS"){?>
      <td class='cabec_1' colspan="2">REQUERIMIENTO</td>
      <td class='cabec_1'>PEDIDO</td>
      <td class='cabec_1'>COD.CLIENTE</td>
      <td class='cabec_1' width="30%">DIRECCION</td>
      <td class='cabec_1'>ZONAL</td>
      <td class='cabec_1'>FEC. REGISTRO</td>
      <td class='cabec_1'>ORIGEN</td>
      <td class='cabec_1'>ESTADO</td>
      <td width="6%" class='cabec_1'>SEMAFORO</td>
    </tr>
    <? } ?>
    
    <? if ($zon=="0" and $nreg==0){?>
        <tr>
    	<td colspan="12" class="aviso" align="center">
        ALERTA: CARGA SIN REGISTROS - VERIFICAR EL PROCESO DE CARGA
        </td>
	    </tr>

    <? }else{?>
    <tr>
    	<td colspan="12" class="aviso" align="center">
        ALERTA: NO SE ENCUENTRAN REGISTROS PARA DICHA OPCION
        </td>
    </tr>
    <? }?>
    <tr>
      <td colspan='12' class='cabec_1'>&nbsp;</td>
    </tr>
<? }?>
</table>
<p>
<div id="bandeja_asignaciones" style="display:none"> 
	<iframe id="i_bandeja_asignaciones"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="700"> 
	</iframe>
</div>
<p>

