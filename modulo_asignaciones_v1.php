<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$actividad=$_GET["actividad"];


//echo $actividad."<br>";
	

if ($actividad=="ASIGNACIONES"){
	$origen=$_GET["combo1"];
	$zon=$_GET["combo2"];	

	if ($zon=="0"){
		$cad="";
	}else{	
		$cad=" and zonal='$zon'";
		
	}


	$sql="SELECT a.requerimiento,a.peticion,a.inscripcion,a.direccion,a.f_legado,a.fuente,a.estado,a.zonal
	FROM cab_gestion_actividades_cot a LEFT JOIN cab_asignaciones_cot b 
	ON a.peticion = b.peticion
	WHERE a.estado=0 and a.actividad='ASIGNACIONES' and a.fuente='$origen' $cad
	ORDER BY RAND(), a.f_legado asc LIMIT 1";
//echo $sql;
}

if ($actividad=="CANCELADAS"){
	$marca_1=$_GET["combo1"];
	$marca_2=$_GET["combo2"];	
	
	if ($marca_2=="0"){
		$cad="";
	}else{	
		$cad=" and marca_1='$marca_1'";
		
	}
	
	$sql="SELECT a.requerimiento,a.marca_1,a.f_legado,a.fuente,a.f_carga,a.zonal
FROM cab_gestion_actividades_cot a LEFT JOIN cancelaciones_trabajadas b ON a.requerimiento = b.codigo 
WHERE a.estado='PENDIENTES' AND a.actividad='CANCELADAS' $cad ORDER BY RAND(), a.f_legado ASC LIMIT 1";
//echo $sql;
}


if ($actividad=="MIGRACIONES"){
	$marca_1=$_GET["combo1"];
	$marca_2=$_GET["combo2"];	
	
	if ($marca_2=="0"){
		$cad="";
	}else{	
		$cad=" and marca_2='$marca_1'";
		
	}
	
	$sql="SELECT a.requerimiento,a.inscripcion,a.codigocliente,a.f_legado,a.estado,a.fuente,a.direccion,marca_1,marca_2,a.zonal
FROM cab_gestion_actividades_cot a LEFT JOIN cancelaciones_trabajadas b ON a.requerimiento = b.codigo 
WHERE a.estado='PENDIENTES' AND a.actividad='MIGRACIONES' $cad ORDER BY RAND() LIMIT 1";
//echo $sql;
}

//echo $sql;

$res_lis = mysql_query($sql) or die(mysql_error());		

$nreg = mysql_num_rows($res_lis) 

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
<style type="text/css">
<!--
.caja_texto_c {	font-size:10px;
	font-style:normal;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-align:center;	
	color:#FFF;
	background-color:#6C3;
	border-right: 3px solid #F4F7FF;
	border-bottom: 5px solid #F4F7FF;
	border-left: 1px solid #F4F7FF;
	margin:0px;
	padding:0px;
	list-style: none;
}
-->
</style>

</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>

<? if ($actividad=="ASIGNACIONES"){ ?>
<table width='100%'>
  <? if ($nreg == 1){?>  
    <?	
	  while($reg_lis=mysql_fetch_row($res_lis)){	 
   
	  $cc="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[6]'";		
	  $res_cc = mysql_query($cc);
	  $reg_cc=mysql_fetch_row($res_cc);	
	  
	  $data="select * from tb_gestel_423 where inscripcion='$reg_lis[2]'";	
      $res_data = mysql_query($data);
	  $reg_data=mysql_fetch_row($res_data);	
	  
	  if ($reg_lis[5]=="GESTEL-423"){?>
	  <table width='100%'>
	  <tr>
			<td width="12%" class='cabeceras_grid' colspan="2">PETICION</td>
			<td width="13%" class='cabeceras_grid'>PEDIDO</td>
			<td width="15%" class='cabeceras_grid'>INSCRTIPCION</td>
			<td width="6%" class='cabeceras_grid'>AGRUP.</td>
			<td width="6%" class='cabeceras_grid'>CIUDAD</td>
			<td width="30%" class='cabeceras_grid' >DIRECCION</td>
			<td width="6%" class='cabeceras_grid'>ZONAL</td>
			<td width="10%" class='cabeceras_grid'>FEC. REGISTRO</td>
			<td width="6%" class='cabeceras_grid'>ORIGEN</td>
			<td width="6%" class='cabeceras_grid'>ESTADO</td>
			<td width="6%" class='cabeceras_grid'>SEMAFORO</td>
	    </tr>
	<tr>
    	<td class="caja_sb"  id='celda_asignar_on'><img src="image/vis.jpg" alt="" width="20" 
        onclick="javascript:validar_pedido('<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
        '<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" border="1" /> </td>
		<td class="caja_sb" ><? 	echo $reg_lis[0]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[1]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[2]; ?></td>
		<td class="caja_sb" ><? echo $reg_data[13]; ?></td>
		<td class="caja_sb"  ><? echo $reg_data[0]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[3]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[7]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[4]; ?></td>
		<td class="caja_sb" ><? echo $reg_lis[5]; ?></td>
		<td class="caja_sb" ><? echo $reg_cc[1]; ?></td>
		<td class="caja_sb" ><? if ($reg_lis[6]=="1" and $reg_lis[6]=="3"){ ?>
			<img src="image/semaforo_r.JPG" width="30" />
			<? }?>
			<? if ($reg_lis[6]=="0"){ ?>
			<img src="image/semaforo_v.JPG" width="30"  />
			<? }?>
		</td>
 	 </tr>
	 </table>
  <? } ?>
  <? if ($reg_lis[5]=="CMS"){
	
      $cc="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[6]'";		
	  $res_cc = mysql_query($cc);
	  $reg_cc=mysql_fetch_row($res_cc);		
	  
  ?>
  <table width="100%">
  <tr>
  <td class='cabeceras_grid' colspan="2">REQUERIMIENTO</td>
      <td class='cabeceras_grid'>PEDIDO</td>
    <td class='cabeceras_grid'>COD.CLIENTE</td>
    <td class='cabeceras_grid' width="30%">DIRECCION</td>
    <td class='cabeceras_grid'>ZONAL</td>
    <td class='cabeceras_grid'>FEC. REGISTRO</td>
    <td class='cabeceras_grid'>ORIGEN</td>
    <td class='cabeceras_grid'>ESTADO</td>
    <td width="6%" class='cabeceras_grid'>SEMAFORO</td>
  </tr>
  <tr >
    <td class='caja_sb' 
          id='celda_asignar_on'><img src="image/vis.jpg" alt="" width="25" height="25" 
                onclick="javascript:validar_pedido('<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
                '<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" border="1" /> </td>
    <td class="caja_sb"><? 	echo $reg_lis[0]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[1]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[2]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[3]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[7]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[4]; ?></td>
    <td class="caja_sb"><? echo $reg_lis[5]; ?></td>
    <td class="caja_sb"><? echo $reg_cc[1]; ?></td>
    <td class="caja_sb"><? if ($reg_lis[6]=="1" and $reg_lis[6]=="3"){ ?>
        <img src="image/semaforo_r.JPG" width="30" height="30" />
        <? }?>
        <? if ($reg_lis[6]=="0"){ ?>
        <img src="image/semaforo_v.JPG" width="30" height="30" />
        <? }?>    </td>
  </tr>
  </table>
  <? }
	  }?>
 <span class="adaptado">Nota Importante: Para poder separar el pedido debe dar click en el boton <img src="image/vis.jpg" width="25" height="25"  border="1" /> . Sino el pedido quedara liberado
y podra ser escogido por otro gestor.</span>
  <? }else{   
	if ($origen=="GESTEL-423"){?>
 	 <table width="100%">
  	
	  <td width="12%" class='cabeceras_grid' colspan="2">PETICION</td>
      <td width="13%" class='cabeceras_grid'>PEDIDO</td>
    <td width="15%" class='cabeceras_grid'>INSCRTIPCION</td>
    <td width="6%" class='cabeceras_grid'>AGRUP.</td>
    <td width="6%" class='cabeceras_grid'>CIUDAD</td>
    <td width="30%" class='cabeceras_grid' >DIRECCION</td>
    <td width="6%" class='cabeceras_grid'>ZONAL</td>
    <td width="10%" class='cabeceras_grid'>FEC. REGISTRO</td>
    <td width="6%" class='cabeceras_grid'>ORIGEN</td>
    <td width="6%" class='cabeceras_grid'>ESTADO</td>
    <td width="6%" class='cabeceras_grid'>SEMAFORO</td>
  	</tr>
</table>
  <? } 
    if ($origen=="CMS"){?>
   <table width="100%">
   <tr>
   <td class='cabeceras_grid' colspan="2">REQUERIMIENTO</td>
   <td class='cabeceras_grid'>PEDIDO</td>
    <td class='cabeceras_grid'>COD.CLIENTE</td>
    <td class='cabeceras_grid' width="30%">DIRECCION</td>
    <td class='cabeceras_grid'>ZONAL</td>
    <td class='cabeceras_grid'>FEC. REGISTRO</td>
    <td class='cabeceras_grid'>ORIGEN</td>
    <td class='cabeceras_grid'>ESTADO</td>
    <td width="6%" class='cabeceras_grid'>SEMAFORO</td>
  </tr>
  <? } ?>
  <? if ($zon=="0" and $nreg==0){?>
  <tr>
    <td colspan="12" align="center"> ALERTA: CARGA SIN REGISTROS - CARGA EN PROCESO.....</td>
  </tr>
  <? }else{?>
  <tr>
    <td colspan="12"  align="center"> ALERTA: NO SE ENCUENTRAN REGISTROS EN LA ZONAL <? echo $zon ?> </td>
  </tr>
  <? }?>
  
  <? }?>
</table>

<? } ?>

<!--MODULO MIGRACIONES-->

<? if ($actividad=="MIGRACIONES"){ ?>

<table width='100%'>
  <tr>
    <td width="12%" class='cabeceras_grid' colspan="2">TELEFONO</td>
 	<td width="15%" class='cabeceras_grid'>CLIENTE </td>  
    <td width="30%" class='cabeceras_grid' >PRODUCTO</td>
    <td width="6%" class='cabeceras_grid'>FACILIDADES TECNICAS </td>
    <td width="10%" class='cabeceras_grid'>TECNOLOCIA</td>
    <td width="6%" class='cabeceras_grid'>SERVICIO</td>
    <td width="6%" class='cabeceras_grid'>MIGRACION</td>
    <td width="6%" class='cabeceras_grid'>ZONA</td>
  </tr>
  <?  while($reg_lis=mysql_fetch_row($res_lis)){	
  	
		$c_pl		= "select * from tb_migraciones where telefono='$reg_lis[0]'";
		$res_c_pl	= mysql_query($c_pl) or die(mysql_error());	
		$reg_c_pl	= mysql_fetch_row($res_c_pl);
  	
  ?>
  <tr>
    <td class="caja_sb"  id='celda_asignar_on'><img src="image/BT4.gif" alt="" width="20" height="20" border="0" 
        onclick="javascript:validar_pedido_migracion('<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
        '<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" /> </td>
    <td class="caja_sb" ><? echo $reg_lis[0]; ?></td>  
    <td class="caja_sb" ><? echo $reg_c_pl[3]." ".$reg_c_pl[4]." ".$reg_c_pl[5]; ?></td>
    <td class="caja_sb" ><? echo $reg_c_pl[8]; ?></td>
    <td class="caja_sb" ><? echo $reg_c_pl[9]." | ".$reg_c_pl[10]." ".$reg_c_pl[11]." ".$reg_c_pl[12];?></td>
    <td class="caja_sb" ><? echo $reg_c_pl[15]; ?></td>
	<td class="caja_sb" ><? echo $reg_c_pl[16]; ?></td>
	<td class="caja_sb" ><? echo $reg_lis[8]; ?></td>
	<td class="caja_sb" ><? echo $reg_lis[9]; ?></td>
	<td class="caja_sb" ><? echo $reg_lis[10]; ?></td>
  </tr>
  <? } 
 }?>
</table>

<!--- MODULO CANCELADAS-->
<? if ($actividad=="CANCELADAS"){ ?>

   <table width="100%" border="0"> 
     <tr class="TitTablaI">
       <td class="cabeceras_grid">REQUERIMIENTO</td>
       <td class="cabeceras_grid">CASUISTICA</td>
       <td class="cabeceras_grid">F.LEGADO</td>
       <td class="cabeceras_grid">FUENTE</td>
       <td class="cabeceras_grid">FEC.CARGA</td>
       <td class="cabeceras_grid">ZONA</td>
     </tr>
     <?
  // echo $reg_lis_1[0]; 
		   
	  while($reg_lis=mysql_fetch_row($res_lis)){		  
			  /*
				$sql_2		="INSERT INTO cancelaciones_trabajadas(codigo,est,pc,iduser,fec_bloqueo,fec_carga,fec_legado)
				VALUES('$reg_lis[0]','SEPARADO','$pc','$iduser',now(),'$reg_lis[9]','$reg_lis[10]')";
				//echo $sql_2;
				$res_sql_2  = mysql_query($sql_2) or die(mysql_error()); 
			  */
		   ?>
			  <tr>
			   <td>		
			    <a class="caja_texto_pe" id="pet_req" href="javascript:separar_cancelada()"><? echo $reg_lis[0]?></a>	  	     			   
			   </td>			  
			   <td class="caja_sb"><? echo $reg_lis[1]?></td>
			   <td class="caja_sb">
		        <input name="f_legado" type="text" class="caja_texto_pe" id="f_legado" value="<? echo $reg_lis[2]?>" size="15" readonly="readonly"/></td>
			   <td class="caja_sb"><? echo $reg_lis[3]?></td>
			  <td class="caja_sb">
			    <input name="f_carga" type="text" class="caja_texto_pe" id="f_carga" value="<? echo $reg_lis[4]?>" size="20" readonly="readonly"/></td>
			   <td class="caja_sb"><? echo $reg_lis[5]?></td>
			 </tr>
    	 <? }  
 	?>
   </table>
   <br>
   <div id="d_gestion_canceladas" style="display:none">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td height="14" colspan="6" valign="top" class="boton">&nbsp;</td>
     </tr>	
	 <tr>
       <td height="14" colspan="6" valign="top">&nbsp;</td>
     </tr>	
     <tr>
       <td width="10%" height="39" valign="top" class="caja_sb">TIPO</td>
       <td width="15%" valign="top" ><select name="c_tipo" class="caja_sb" id="c_tipo" onchange="javascript:mostrar_carnet(this.value)" >
           <option value="CANCELADO OK" selected="selected">CANCELADO OK</option>
           <option value="POR CONSOLIDAR">POR CONSOLIDAR</option>
           <option value="POR REMEDY">POR REMEDY</option>
       </select></td>
     
       <td width="10%" align="center"  class="caja_texto_pe" onclick="javascript:aceptar_pedido_canceladas('<? echo $res_sql_2[0]; ?>','<? echo $reg_lis[0]?>','<? echo $reg_lis[4]?>','<? echo $iduser;?>',
        '<? echo $reg_lis[5]?>','<? echo $reg_lis[1]?>')" >
		<img src="image/BT4.gif" width="20" height="20"> OK</td>
       
       <td width="49%">&nbsp;</td>
       <td width="8%">&nbsp;</td>
       <td width="8%">&nbsp;</td>
     </tr>
   </table>
   </div>
<? } ?>

<p>


<div id="bandeja_asignaciones" style="display:none"> 
	<iframe id="i_bandeja_asignaciones"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="700"> 
	</iframe>
</div>
<p>

