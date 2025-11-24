<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$accion=$_GET["accion"];

$dni=$_GET["dni"];

  $sql_usu = "SELECT a.*,b.* FROM tb_usuarios a, usuarios_detalle b WHERE a.dni=b.dni and a.dni='$dni' GROUP BY a.dni";
  //echo $sql_usu;
  $res_USU = mysql_query($sql_usu);											
  $nreg= mysql_num_rows($res_USU);
  $reg_USU=mysql_fetch_array($res_USU);
  
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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">    
      
      <tr class="celdas">
          <td width="10%" height="18">DNI</td>
          <td width="10%">CIP</td>
          <td width="10%">NOMBRE COMPLETO</td>
          <td width="10%">&nbsp;</td>
          <td width="10%">ESTADO</td>
          <td width="10%">PERFIL</td>
          <td width="10%">&nbsp;</td>
          <td width="10%">GESCOT</td>
          <td width="10%">GENIO</td>
        </tr>
        
        <tr>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="dni" value="<?php echo  $reg_USU["dni"]; ?>" size="20"  readonly /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="cip" value="<?php echo  $reg_USU["cip"];  ?>" size="20"  readonly /></td>
          <td colspan="2" class="casilla_texto"><input type="text" class="casilla_texto" id="ncompleto" value="<?php echo  $reg_USU["ncompleto"];   ?>" size="50" readonlY /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="" value="<?php echo  $reg_USU["estado"];   ?>" size="20" readonly /></td>
          <td class="casilla_texto">          
          <select name="PERFIL" id="PERFIL" class="casilla_texto">
            <option value="T">ESCOGER</option>
            <option value="2">JEFE</option>
            <option value="1">OPERADOR</option>
            <option value="3">SUPERVISOR</option>
          </select>
         </td>
         <?php 
		  if($reg_USU["perfil"]=="0"){ $perfil="ADMINISTRADOR";}
  		  if($reg_USU["perfil"]=="1"){ $perfil="OPERADOR";}
		  if($reg_USU["perfil"]=="2"){ $perfil="JEFE";}
  		  if($reg_USU["perfil"]=="3"){ $perfil="SUPERVISOR";}
		  		  
		 
		 ?>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="perfil" value="<?php echo  $perfil;  ?>" size="20" readonly /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="login" value="<?php echo  $reg_USU["login"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_GENIO" value="<?php echo  $reg_USU["USUARIO_GENIO"];   ?>" size="20" /></td>
        </tr>
        
          
      <tr class="celdas">
          <td width="10%" height="18">GESTEL</td>
          <td width="10%">MULTICONSULTAS</td>
          <td width="10%">INTRAWAY</td>
          <td width="10%">UNIFICADA</td>
          <td width="10%">PSI</td>
          <td width="10%">ATIS</td>
          <td width="10%">CMS</td>
          <td width="10%">SARA</td>
          <td width="10%">ASEGURAMIENTO</td>
        </tr>
        
        <tr>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_GESTEL" value="<?php echo  $reg_USU["USUARIO_GESTEL"]; ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_MULTICONSULTA" value="<?php echo  $reg_USU["USUARIO_MULTICONSULTA"];  ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_INTRAWAY" value="<?php echo  $reg_USU["USUARIO_INTRAWAY"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_WEB_UNIFICADA" value="<?php echo  $reg_USU["USUARIO_WEB_UNIFICADA"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_PSI" value="<?php echo  $reg_USU["USUARIO_PSI"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_ATIS" value="<?php echo  $reg_USU["USUARIO_ATIS"];  ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="USUARIO_CMS" value="<?php echo  $reg_USU["USUARIO_CMS"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="WEB_SARA" value="<?php echo  $reg_USU["WEB_SARA"];   ?>" size="20" /></td>
          <td class="casilla_texto"><input type="text" class="casilla_texto" id="WEB_ASEGURAMIENTO" value="<?php echo  $reg_USU["WEB_ASEGURAMIENTO"];   ?>" size="20"  /></td>
        </tr>
        
             
        <tr>
          <td width="10%" height="18" class="celdas">CLEAR VIEW</td>
          <td width="10%" class="celdas">REPARTIDOR</td>
          <td width="10%" class="celdas">INCIDENCIAS PSI</td>
          <td width="10%" class="celdas">PDM</td>
          <td width="10%" class="celdas">CALCULADORA ARPU</td>
          <td width="10%" class="celdas">ASIGNACIONES</td>
          <td width="10%" class="celdas">MAPA GIG</td>
          <td width="10%" class="celdas">&nbsp;</td>
          <td class="celdas">&nbsp;</td>
        
        </tr>
        <tr>
          <td height="18"><input type="text" class="casilla_texto" id="CLEAR_VIEW" value="<?php echo  $reg_USU["CLEAR_VIEW"];   ?>" size="20"   /></td>
          <td><input type="text" class="casilla_texto" id="REPARTIDOR" value="<?php echo  $reg_USU["REPARTIDOR"];   ?>" size="20" /></td>
          <td><span class="casilla_texto">
            <input type="text" class="casilla_texto" id="USUARIO_INCIDENCIAS_PSI" value="<?php echo  $reg_USU["WEB_INCIDENCIAS_PSI"];   ?>" size="20"  />
          </span></td>
          <td><span class="casilla_texto">
            <input type="text" class="casilla_texto" id="PDM" value="<?php echo  $reg_USU["PDM"];   ?>" size="20"  />
          </span></td>
          <td><input type="text" class="casilla_texto" id="WEB_ARPU_CALCULADORA" value="<?php echo  $reg_USU["WEB_ARPU_CALCULADORA"];   ?>" size="20" /></td>
          <td><input type="text" class="casilla_texto" id="WEB_ASIGNACIONES" value="<?php echo  $reg_USU["WEB_ASIGNACIONES"];   ?>" size="20" /></td>
          <td><input type="text" class="casilla_texto" id="WEB_SIGTP_MAPA_GIG" value="<?php echo  $reg_USU["WEB_SIGTP_MAPA_GIG"];   ?>" size="20"  /></td>
          <td>&nbsp;</td>
          <td><img src="image/visto3.jpg" width="25" height="25" onclick="javascript:actualizar_datos_usu('<?php echo $dni; ?>')" />ACTUALIZAR</td>
          
        </tr>
        
        
        
    </table>
    
    </td> 


</body>
</html>