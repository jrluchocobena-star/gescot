<?
include_once("conexion_bd.php");
//set_time_limit(0);					

$cad="select a.cip,a.dni,b.ncompleto,a.cod_incidencia,a.fec_ini_inc,a.fec_fin_inc,datediff(a.fec_ini_inc,a.fec_fin_inc)
from cab_incidencia_2018 a, tb_usuarios b
where a.dni=b.dni and a.modo='H'
group by 3";
//echo $cad;
$res =mysql_query($cad);	
?>
<table width="100%" border="0">
  <tr>
    <td>CIP</td>
    <td>DNI</td>
    <td>NOMBRE</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? 
 	 $con=0;
	 while($reg=mysql_fetch_row($res)){		
  ?>
  <tr>
    <td><? echo $reg[0];?></td>
    <td><? echo $reg[1];?></td>
    <td><? echo $reg[2];?></td>
    <td><? echo $reg[3];?></td>
    <td><? echo $reg[4];?></td>
    <td><? echo $reg[5];?></td>
    <td><? echo $reg[6];?></td>
  </tr>
  <? } ?>
</table>
