<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$tiempo=$_GET["tiempo"];	

if ($tiempo=="0"){
	$cad="";
}else{
	$cad="and SUBSTR(fh_reg104,1,10)='$tiempo'";
}

$sql_2="SELECT a.CODMULTIGESTION,a.CODCLI,a.CLIENTENOMBRE,a.CLIENTEDNI,a.ATENCION,
a.comentario,a.FH_REG104,a.FH_REG2L,a.LLAMADOR,a.F_CARGA,a.ESTADO
FROM tb_beoliquidacion a LEFT JOIN cab_beoliquidaciones_cot b 
ON a.CODMULTIGESTION = b.CODMULTIGESTION
WHERE a.estado=0 $cad
ORDER BY  RAND(),fh_reg104 asc LIMIT 1";
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

<script language='javascript1.2'>

</script>


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
   
	  $cc="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[10]'";		
	  $res_cc = mysql_query($cc);
	  $reg_cc=mysql_fetch_row($res_cc);	
	  
	 ?>
     <tr>
      <td class='cabec_1' colspan="2">CODMULTIGESTION</td>
      <td width="5%" class='cabec_1'>COD.REQ.</td>    
      <td width="5%" class='cabec_1'>CODCLI</td>
      <td width="5%" class='cabec_1'>DNI</td>
      <td width="10%" class='cabec_1'>CONTACTO</td>     
      <td width="5%" class='cabec_1'>ATENCION</td>
      <td width="30%" class='cabec_1' >OBS.</td>
      <td width="5%" class='cabec_1'>FEC. CLIENTE</td>
      <td width="5%" class='cabec_1'>FEC. ATENTO</td>
       <td width="5%" class='cabec_1'>ESTADO</td>     
       
    </tr>
	<tr >
    <!--
  	<td width="5%" class='caja_texto1_n' id='celda_asignar_on'><img src="image/clip.jpg" alt="" width="30" height="30" 
        onclick="javascript:popup_reclamo('6','<? echo $reg_lis[0]?>','<? echo $reg_lis[1]?>',
        '<? echo $reg_lis[9]?>','<? echo $reg_lis[6]?>','<? echo $reg_lis[7]?>')" border="1" />
    </td>
    -->
      <td width="5%" class='caja_texto1_n' id='celda_asignar_on'><img src="image/clip.jpg" alt="" width="30" height="30" 
        onclick="javascript:aceptar_asignacion_bl('<? echo $reg_lis[0] ?>','<? echo $iduser ?>','<? echo $reg_lis[6] ?>',
        '<? echo $reg_lis[7] ?>','<? echo $reg_lis[9] ?>','<? echo $reg_lis[1] ?>')" border="1" id="bt_acep" />
   	  </td>
      <td width="5%" class='caja_texto1_n'><? echo $reg_lis[0]; ?></td>
      <td 			class="caja_texto1_n"><? echo $reg_lis[8]; ?></td>      
      <td 			class="caja_texto1_n"><? echo $reg_lis[1]; ?></td>
      <td 			class="caja_texto1_n"><? echo $reg_lis[3]; ?></td>
      <td 			class="caja_texto1_n"><? echo $reg_lis[2]; ?></td>
      <td 			class="caja_texto1_n"><? echo $reg_lis[4]; ?></td>
      <td			class="caja_texto1_n"><? echo quitar_tildes($reg_lis[5]); ?></td>
      <td 			class="caja_texto1_n"><? echo $reg_lis[6]; ?></td> 
      <td 			class="caja_texto1_n"><? echo $reg_lis[7]; ?></td>   
      <td 			class="caja_texto1_n"><? echo $reg_cc[1]; ?></td>    
     
    </tr>
	

	<? 	
	$fec_carga=substr($_GET["tiempo"],0,10);
		
	
	$sql="INSERT INTO cab_beoliquidaciones_cot
	(id,CODMULTIGESTION,usu_reg,fec_reg_web,fec_reg_cli,fec_reg_carga,fec_reg_atento,fec_cierre_atencion,estado,
	obs_registro,acciones,c_cliente)
	VALUES(LAST_INSERT_ID(),'$reg_lis[0]','$iduser',NOW(),'$reg_lis[6]','$fec_carga','$reg_lis[7]','','1','OK','1','$reg_lis[1]')";
	//echo $sql;
	$res_sql = mysql_query($sql);
	
	$os1="update tb_beoliquidacion set estado='1' where CODMULTIGESTION='$$reg_lis[0]'";
	//echo $os1;
	$res_os1 = mysql_query($os1);

	  } ?>
    
    <tr>
      <td colspan='12' class='cabec_1'>&nbsp;</td>
    </tr>
<? }else{ ?>
	<tr>
      <td class='cabec_1' colspan="2">CODMULTIGESTION</td>
      <td width="5%" class='cabec_1'>COD.REQ.</td>    
      <td width="5%" class='cabec_1'>CODCLI</td>
      <td width="5%" class='cabec_1'>DNI</td>
      <td width="10%" class='cabec_1'>CONTACTO</td>     
      <td width="5%" class='cabec_1'>ATENCION</td>
      <td width="30%" class='cabec_1' >OBS.</td>
      <td width="5%" class='cabec_1'>FEC. CLIENTE</td>
      <td width="5%" class='cabec_1'>FEC. ATENTO</td>
       <td width="5%" class='cabec_1'>ESTADO</td>     
       
    </tr>
    <tr>
      <td colspan='12' class='aviso_horario' align="center">ALERTA: No hay Registros(Carga Terminada)</td>
    </tr>
     <tr>
      <td colspan='12' class='cabec_1'>&nbsp;</td>
    </tr>
    

<? } ?>
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

