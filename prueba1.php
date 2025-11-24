<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="funciones_js.js"></script>
</head>

<body>

<?php 

include("conexion_bd.php");
validar_logeo($iduser);

$accion=$_GET["accion"];
$iduser=$_GET["iduser"];
//$idperfil=$_GET["idperfil"];


$sql_usu = "select * from tb_usuarios where iduser='$iduser'";
//echo $sql_usu;
$res_USU = mysql_query($sql_usu);											
$usu	= mysql_fetch_array($res_USU);


	

/*$sql_1 = "SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.opc
FROM tb_gestel_423 a LEFT JOIN cab_asignaciones_cot b
ON a.PEDIDO = b.pedido
WHERE b.pedido IS NULL 
ORDER BY a.FECHA_REG ASC limit 1";  

$sql_1="SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.opc
FROM tb_gestel_423 a LEFT JOIN cab_asignaciones_cot b
ON a.PEDIDO = b.pedido
WHERE b.pedido IS NULL 
ORDER BY  RAND(), a.FECHA_REG ASC  LIMIT 1";

//echo $sql;
$res_lis_1 = mysql_query($sql_1);
$reg=mysql_fetch_row($res_lis_1);

*/
//$idperfil=$usu[7];
//cho $idperfil;
?>
 <input name="iduser" type="hidden" class="aviso" id="iduser" value="<? echo $iduser; ?>" size="30" />
  <input name="idperfil" type="hidden" class="aviso" id="idperfil" value="<? echo $usu[7]; ?>" size="30" />
  

<table width="90%" Class="marco_tabla_bandeja">
  <tr>
    <td colspan="10" class="cabec_1">MODULO DE GESTION DE PEDIDOS DEL AREA DE ASIGNACIONES</td>
  </tr> 
   <tr>
    
    <? if ($usu[7]<>1){?>
    <td >
    <img id="bt_asigna_pedido_on" src="image/bt_asignar_.jpg" alt="" width="239" height="68" onclick="javascript:asignar_pedido('<? echo $iduser;?>')"   />
    <img id="bt_asigna_pedido_off" src="image/bt_asignar.jpg" alt="" width="169" height="55" style="display:none"/> </td>      
    <td onclick="javascript:menu_asig('3')" ><img src="image/PEDIDOS_.jpg" alt="" width="201" height="66" /></td>    
    <td onclick="javascript:menu_asig('2')" ><img src="image/bandeja_pedido_.jpg" alt="" width="288" height="63" /></td>           
    <? }else{ ?>
    <td>
    <img id="bt_asigna_pedido_on" src="image/bt_asignar_.jpg" alt="" width="198" height="62" onclick="javascript:asignar_pedido('<? echo $iduser;?>')"   />
    <img id="bt_asigna_pedido_off" src="image/bt_asignar.jpg" alt="" width="169" height="55" style="display:none"/>  </td>  
    <td onclick="javascript:menu_asig('3')" ><img src="image/PEDIDOS_.jpg" alt="" width="201" height="66" /></td>    
    <? } ?>
    <td valign="top" onclick="javascript:('<? echo $reg[1]?>','<? echo $reg[4]?>','<? echo $iduser;?>')" >
    <p>
    <? 
		$f_actual=date("Y-m-d");
	
		$c1="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$f_actual'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$mes=date("m");
		$c2="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,6,2)='$mes'";
		//echo "<br>".$c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);

		
	?>
    <table width="300" border="0" align="right" cellpadding="0" cellspacing="0" >
      <tr valign="top">
        <td class="contador">Pedidos Diario</td>
        <td><input name="contador1" type="text" class="contadorcss" id="contador1" value="<? echo $reg_c1[0]; ?>"  size="10" /></td>
      </tr>
      <tr valign="top">
        <td width="193" class="contador">Pedidos Mensual</td>       
        
        <td width="105"><input name="contador2" type="text" class="contadorcss" id="contador2" value="<? echo $reg_c2[0]; ?>"  size="10" /></td>
      </tr>
    </table></td>
  </tr> 
</table> 

<div id="d_pedido" style="display:none"> </div>

<div id="d_gestion" style="display:none">
<table width="80%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja">	
  <tr>
    <td valign="top" class="TitTablaI">EXCLUSIONES</td>
    <td>
    <!--
    <select name="exc" class="casilla_texto" id="exc">
      <option value="0">SELECCIONAR</option>
      <option value="PORT IN">PORTABILIDAD</option>      
    </select>
    -->
    <select name="exc" class="casilla_texto" id="exc">
      <option value="0">SELECCIONAR</option>
      <option value="FUNCIONO">FUNCIONO</option>      
      <option value="NO FUNCIONO">NO FUNCIONO</option>      
      <option value="PARCIALMENTE">PARCIALMENTE</option>  
      <option value="NO DESEA ATENCION">NO DESEA ATENCION</option>     
      <option value="SE ENCONTRO OK">SE ENCONTRO OK</option>          
      <option value="REQUIERE VISITA TECNICA">REQUIERE VISITA TECNICA</option> 
      <option value="NO CONTESTA">NO CONTESTA</option>          
      <option value="VOLVER A LLAMAR">VOLVER A LLAMAR</option>          
    </select>
    </td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">OBSERVACION:</td>
    <td><textarea name="obs" cols="100" rows="5" id="obs"></textarea></td>    
  </tr>  
</table>
</div>


<div id="lista_diario" style="display:none"> </div>



<!----------------------------------BANDEJA TABS------------------------------------------------------------------->
<div id="bandejas_asignaciones" style="display:none">
        <div class="w3-bar w3-black" style="background-color:#CCC">
          <button class="w3-bar-item w3-button" onclick="openCity('LIST_1','bandejas','<? echo $iduser; ?>','1')">DIARIO</button>
          <button class="w3-bar-item w3-button" onclick="openCity('LIST_1','bandejas','<? echo $iduser; ?>','2')">MENSUAL</button>
          <button class="w3-bar-item w3-button" onclick="openCity('LIST_2','lista_operador','<? echo $iduser; ?>','3')">POR OPERADOR</button>
         <!-- <button class="w3-bar-item w3-button" onclick="openCity('Tokyo')">Tokyo</button>-->
  </div>
        
        <div id="LIST_1" class="city">
          <iframe id="bandejas"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
           width="100%"  scrolling="Auto"  height="500"> </iframe>
        </div> 
        <div id="LIST_2" class="city">
          <iframe id="lista_operador"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
           width="100%"  scrolling="Auto"  height="500" > </iframe>
        </div>         
       
</div>
<div id="dcab_criterios" style="display:none"> 
<iframe id="fcab_criterios"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
    width="95%"  scrolling="Auto"  height="700"> 
	</iframe>
</div>


</body>
</html>