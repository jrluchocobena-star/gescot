<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];	

?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<!--
<table width="60%" class="marco_tabla">
  <tr>
    <td colspan="10" align="center"></td>
  </tr>
  <? 
	  $hoy=date("Y-m-d");
	  
	  $cont_1="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' ";
	  echo $cont_1;
	  $res_c1 = mysql_query($cont_1);
	  $reg_c1=mysql_fetch_row($res_c1);	
	  
	  $cont_2="select count(*) from cab_asignaciones_rechazados where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' ";
	  //echo $cont_2;
	  $res_c2 = mysql_query($cont_2);
	  $reg_c2=mysql_fetch_row($res_c2);	
	  
	  $cont_3="select count(*) from cab_asignaciones_cot
	  where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' and exclusiones='CANCELACIONES CMS'";
	  //echo $cont_3;
	  $res_c3 = mysql_query($cont_3);
	  $reg_c3=mysql_fetch_row($res_c3);	
	  
	  $cont_4="select count(*) from cab_asignaciones_cot
	  where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' and exclusiones='MIGRACIONES'";
	  //echo $cont_3;
	  $res_c4 = mysql_query($cont_4);
	  $reg_c4 =mysql_fetch_row($res_c4);	
	  
	  $cont_5="select count(*) from cab_asignaciones_cot
	  where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' and exclusiones='PORT IN'";
	  //echo $cont_3;
	  $res_c5 = mysql_query($cont_5);
	  $reg_c5 =mysql_fetch_row($res_c5);
	  
	  ?>
  <tr class="caja_texto_hr">
    <td width="86" class="caja_sb">REALIZADOS</td>
    <td width="66" align="center" class="aviso"><? echo $reg_c1[0]; ?></td>
    <td width="87" class="caja_sb">RECHAZADOS</td>
    <td width="45" align="center" class="aviso"><? echo $reg_c2[0]; ?></td>
    <td width="44" class="caja_sb">CANCELACIONES</td>
    <td width="44" align="center" class="aviso"><? echo $reg_c3[0]; ?></td>
    <td width="90" class="caja_sb">MIGRACIONES</td>
    <td width="45" align="center" class="aviso"><? echo $reg_c4[0]; ?></td>
    <td width="45" class="caja_sb">PORTABILIDAD</td>
    <td width="90" align="center" class="aviso"><? echo $reg_c5[0]; ?></td>
  </tr>
   <tr>
    <td colspan="10" align="center"></td>
  </tr>
</table>
-->
<table width="200" border="0">
  <tr>
    <td><table width="40%" class="marco_tabla">
      <tr>
        <td colspan="10" align="center"></td>
      </tr>
      <? 
	  $hoy=date("Y-m-d");
	  
	  $cont_1="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and estado_asig=3
	  and substr(fec_reg_web,1,10)='$hoy'";
	  //echo $cont_1;
	  $res_c1 = mysql_query($cont_1);
	  $reg_c1=mysql_fetch_row($res_c1);	
	  
	  $cont_2="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' 
	  and estado_asig in ('0','1')";
	  //echo $cont_2;
	  $res_c2 = mysql_query($cont_2);
	  $reg_c2=mysql_fetch_row($res_c2);	
	  
	  $cont_2="select count(*) from cab_asignaciones_rechazados where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' ";
	  //echo $cont_2;
	  $res_c2 = mysql_query($cont_2);
	  $reg_c2=mysql_fetch_row($res_c2);
	  
	  $cont_5="select count(*) from cab_asignaciones_cot
	  where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$hoy' and exclusiones='PORT IN'";
	  //echo $cont_3;
	  $res_c5 = mysql_query($cont_5);
	  $reg_c5 =mysql_fetch_row($res_c5);
	  
	  
	  ?>
      <tr class="caja_texto_hr">
        <td colspan="6" class="clsCurrentMonthDay">HOY <? echo date("d-m-Y")?></td>
      </tr>
      <tr >
        <td width="86" class="clsCurrentMonthDay">ATENDIDOS</td>
        <td width="66" align="center" class="aviso"><? echo $reg_c1[0]; ?></td>
        <td width="86" class="clsCurrentMonthDay">RECHAZADOS</td>
        <td width="45" align="center" class="aviso"><? echo $reg_c3[0]; ?></td>
        <td width="86" class="clsCurrentMonthDay">PORTABILIDAD</td>
        <td width="45" align="center" class="aviso"><? echo $reg_c5[0]; ?></td>
      </tr>
      <tr>
        <td colspan="10" align="center"></td>
      </tr>
    </table></td>
    <td><table width="40%" class="marco_tabla">
      <tr>
        <td colspan="10" align="center"></td>
      </tr>
      <? 
	  $mes=date("Y-m");
	  
	  $cont_1m="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and estado_asig=3
	  and substr(fec_reg_web,1,7)='$mes'";
	  //echo $cont_1m;
	  $res_c1m = mysql_query($cont_1m);
	  $reg_c1m=mysql_fetch_row($res_c1m);	
	  
	  $cont_2m="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,7)='$mes' 
	  and estado_asig in ('0','1')";
	  //echo $cont_2;
	  $res_c2m = mysql_query($cont_2m);
	  $reg_c2m =mysql_fetch_row($res_c2m);	
	  
	  $cont_3m="select count(*) from cab_asignaciones_rechazados where usu_reg='$iduser' and substr(fec_reg_web,1,7)='$mes' ";
	  //echo $cont_2;
	  $res_c3m = mysql_query($cont_3m);
	  $reg_c3m=mysql_fetch_row($res_c3m);
	  
	  $cont_5m="select count(*) from cab_asignaciones_cot
	  where usu_reg='$iduser' and substr(fec_reg_web,1,7)='$mes' and exclusiones='PORT IN'";
	  //echo $cont_3;
	  $res_c5m = mysql_query($cont_5m);
	  $reg_c5m =mysql_fetch_row($res_c5m);
	  
	  
	  ?>
      <tr class="caja_texto_hr">
        <td colspan="6" class="clsCurrentMonthDay">MES <? echo date("m-Y")?></td>
      </tr>
      <tr >
        <td width="86" class="clsCurrentMonthDay">ATENDIDOS</td>
        <td width="66" align="center" class="aviso"><? echo $reg_c1m[0]; ?></td>
        <td width="86" class="clsCurrentMonthDay">RECHAZADOS</td>
        <td width="45" align="center" class="aviso"><? echo $reg_c3m[0]; ?></td>
        <td width="86" class="clsCurrentMonthDay">PORTABILIDAD</td>
        <td width="45" align="center" class="aviso"><? echo $reg_c5m[0]; ?></td>
      </tr>
      <tr>
        <td colspan="10" align="center"></td>
      </tr>
    </table></td>
  </tr>
</table>
