<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];	

?>
<link href="estilos.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="76%" valign="top"><table width="100%">
      <tr>
        <td colspan="16" align="center" class="boton_3"></td>
        </tr>
      <? 
	  $hoy=date("Y-m-d");
	  
	  $cont_1="select count(*) from cab_asignaciones_cot where substr(fec_reg_web,1,10)='$hoy' ";
	  //echo $cont_1;
	  $res_c1 = mysql_query($cont_1);
	  $reg_c1=mysql_fetch_row($res_c1);	
	  
	  $cont_2="select count(*) from cab_asignaciones_rechazados where substr(fec_reg_web,1,10)='$hoy' ";
	  //echo $cont_2;
	  $res_c2 = mysql_query($cont_2);
	  $reg_c2=mysql_fetch_row($res_c2);	
	  
	  $cont_3="select count(*) from cab_asignaciones_cot
	  where substr(fec_reg_web,1,10)='$hoy' AND exclusiones='CANCELACIONES CMS'";
	  //echo $cont_3;
	  $res_c3 = mysql_query($cont_3);
	  $reg_c3=mysql_fetch_row($res_c3);	
	  
	  $cont_4="select count(*) from cab_asignaciones_cot
	  where substr(fec_reg_web,1,10)='$hoy' AND exclusiones='MIGRACIONES'";
	  //echo $cont_3;
	  $res_c4 = mysql_query($cont_4);
	  $reg_c4 =mysql_fetch_row($res_c4);	
	  
	  $cont_5="select count(*) from cab_asignaciones_cot
	  where substr(fec_reg_web,1,10)='$hoy' AND exclusiones='PORT IN'";
	  //echo $cont_3;
	  $res_c5 = mysql_query($cont_5);
	  $reg_c5 =mysql_fetch_row($res_c5);
	  
	  $cont_6="select count(*) from cab_asignaciones_cot
	  where substr(fec_reg_web,1,10)='$hoy' AND origen='CMS'";
	  //echo $cont_3;
	  $res_c6 = mysql_query($cont_6);
	  $reg_c6 =mysql_fetch_row($res_c6);
	  
	  $cont_7="select count(*) from cab_asignaciones_cot
	  where  origen='GESTEL-423'";
	  //echo $cont_3;
	  $res_c7 = mysql_query($cont_7);
	  $reg_c7 =mysql_fetch_row($res_c7);
	  
	  ?>
      <tr >
        <td width="101" class="txtlabel">CANT. PEDIDOS CMS</td>
        <td width="30" align="center" class="aviso"><? echo $reg_c6[0]; ?></td>
        <td width="153" class="txtlabel">CANT. PEDIDOS GESTEL</td>
        <td width="17" align="center" class="aviso"><? echo $reg_c7[0]; ?></td>
        <td width="5" class="clsWeekDay" >&nbsp;</td>
        <td width="80" class="txtlabel">REALIZADOS</td>
        <td width="21" align="center" class="aviso"><? echo $reg_c1[0]; ?></td>
        <td width="85" class="txtlabel">RECHAZADOS</td>
        <td width="28" align="center" class="aviso"><? echo $reg_c2[0]; ?></td>
        <td width="104" class="txtlabel">CANCELACIONES</td>
        <td width="27" align="center" class="aviso"><? echo $reg_c3[0]; ?></td>
        <td width="88" class="txtlabel">MIGRACIONES</td>
        <td width="24" align="center" class="aviso"><? echo $reg_c4[0]; ?></td>
        <td width="92" class="txtlabel">PORTABILIDAD</td>
        <td width="29" align="center" class="aviso"><? echo $reg_c5[0]; ?></td>
        </tr>
      <tr>
        <td colspan="16" align="center" class="boton_3"></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="76%" valign="top"><table width="100%">
      <tr>
        <td colspan="16" align="center" class="boton_3"></td>
        </tr>
      <? 
	  $hoy=date("Y-m-d");
	  
	  $cont_1="select count(*) from cab_asignaciones_cot ";
	  //echo $cont_1;
	  $res_c1 = mysql_query($cont_1);
	  $reg_c1=mysql_fetch_row($res_c1);	
	  
	  $cont_2="select count(*) from cab_asignaciones_rechazados ";
	  //echo $cont_2;
	  $res_c2 = mysql_query($cont_2);
	  $reg_c2=mysql_fetch_row($res_c2);	
	  
	  $cont_3="select count(*) from cab_asignaciones_cot
	  where  exclusiones='CANCELACIONES CMS'";
	  //echo $cont_3;
	  $res_c3 = mysql_query($cont_3);
	  $reg_c3=mysql_fetch_row($res_c3);	
	  
	  $cont_4="select count(*) from cab_asignaciones_cot
	  where  exclusiones='MIGRACIONES'";
	  //echo $cont_3;
	  $res_c4 = mysql_query($cont_4);
	  $reg_c4 =mysql_fetch_row($res_c4);	
	  
	  $cont_5="select count(*) from cab_asignaciones_cot
	  where  exclusiones='PORT IN'";
	  //echo $cont_3;
	  $res_c5 = mysql_query($cont_5);
	  $reg_c5 =mysql_fetch_row($res_c5);
	  
	  $cont_6="select count(*) from cab_asignaciones_cot
	  where  origen='CMS'";
	  //echo $cont_3;
	  $res_c6 = mysql_query($cont_6);
	  $reg_c6 =mysql_fetch_row($res_c6);
	  
	  $cont_7="select count(*) from cab_asignaciones_cot
	  where  origen='GESTEL-423'";
	  //echo $cont_3;
	  $res_c7 = mysql_query($cont_7);
	  $reg_c7 =mysql_fetch_row($res_c7);
	  
	  ?>
      <tr >       
        <td width="80" class="txtlabel">REALIZADOS</td>
        <td width="21" align="center" class="aviso"><? echo $reg_c1[0]; ?></td>
        <td width="85" class="txtlabel">RECHAZADOS</td>
        <td width="28" align="center" class="aviso"><? echo $reg_c2[0]; ?></td>
        <td width="104" class="txtlabel">CANCELACIONES</td>
        <td width="27" align="center" class="aviso"><? echo $reg_c3[0]; ?></td>
        <td width="88" class="txtlabel">MIGRACIONES</td>
        <td width="24" align="center" class="aviso"><? echo $reg_c4[0]; ?></td>
        <td width="92" class="txtlabel">PORTABILIDAD</td>
        <td width="29" align="center" class="aviso"><? echo $reg_c5[0]; ?></td>
        </tr>
      <tr>
        <td colspan="16" align="center" class="boton_3"></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<p>
<p>&nbsp;</p>
