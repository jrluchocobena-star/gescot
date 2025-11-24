<?php
include("conexion_bd.php");
//include("funciones_fechas.php");
//ini_set("default_charset", "UTF-8");
	
	
$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];

$cip=$_GET["cip"];
$dni=$_GET["dni"];
$area=$_GET["area"];
$ncompleto=$_GET["ncompleto"];

if ($cip=="" and $dni=="" and $area=="0" and $ncompleto==""){
$cad=" ";
}else{
	if ($cip=="" and $dni=="" and $ncompleto==""){
	$cad=" where c_supervisor='$area'";
	}else{
		if ($cip=="" and $ncompleto==""){
		$cad=" where dni='$dni'";
		}else{
			if ($dni=="" and $ncompleto==""){
			$cad=" where cip='$cip'";		
			}else{
			$cad=" where ncompleto like '%$ncompleto%'";				
			}
		}		
	}
}

  $sql_usu = "select * from tb_usuarios $cad order by ncompleto";
  //echo $sql_usu;
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
<script>
function cambiar_color(color,fila){ 
//alert(color)
document.getElementById('nombre_fila' + fila).bgColor = color; 
} 
</script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class='hovertable'>
 <tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>bandeja_usuarios.php</a>"; ?></td>
  </tr>
  <tr>
    <td>
      <table width="100%" >        
        <tr>
          <td colspan="17" class="caja_texto_plomo" align="center">SE ENCONTRARON <?php echo $nreg." REGISTROS"; ?></td>
        </tr>
        <tr>
          <td width="2%" height="18" class="caja_texto_plomo">ITEM</td>
          <!--<td width="9%">CRITERIO</td>-->
          <td width="20%" class="caja_texto_plomo">NOMBRE COMPLETO</td>
          <td width="2%" class="caja_texto_plomo">DNI</td>
          <td width="2%" class="caja_texto_plomo">...</td>
          <td width="3%" class="caja_texto_plomo">CIP</td>
          <td width="4%" class="caja_texto_plomo">IDUSER</td>         
          <td width="10%" class="caja_texto_plomo">PERFIL</td>          
          <td width="9%"  class="caja_texto_plomo">F.BAJA</td> 
          <td width="9%"  class="caja_texto_plomo">ESTADO</td>
			<td width="10%" class="caja_texto_plomo">ESCOGER</td> 
        </tr>
        <?php

  while($reg_USU=mysql_fetch_row($res_USU)){		
			
		  ?>
		  
		  <tr>
		  <?php 
		  $loc="select * from tb_locales where cod_local='$reg_USU[22]'";  
		 //	echo $loc;
		  $res_loc = mysql_query($loc);											
		  $reg_loc=mysql_fetch_array($res_loc);
		  
		  $sup="select * from tb_supervisores where cod_supervisor='$reg_USU[22]'";  
		 //	echo $loc;
		  $res_sup = mysql_query($sup);											
		  $reg_sup=mysql_fetch_array($res_sup);
		  
		  $mon="select * from tb_monitores where cod_monitor='$reg_USU[24]'";  
		 //	echo $loc;
		  $res_mon = mysql_query($mon);											
		  $reg_mon=mysql_fetch_array($res_mon);
		  
		  $per="select * from tb_perfil where id='$reg_USU[7]'";  
		 //	echo $loc;
		  $res_per = mysql_query($per);											
		  $reg_per=mysql_fetch_array($res_per);
		  
		  
		  ?>
		  
		  <td class="caja_texto_peke" id="nombre_fila<?php echo $i; ?>" onclick="javascript:cambiar_color('#99CC66','<?php echo $i; ?>');" > 
		  <?php echo $i=$i+1; ?> </td>
		
		  <td class="caja_texto_pe"><?php 
		  $nom_completo= $reg_USU[1];
		  echo $nom_completo; ?>
          </td>
		  <td class="caja_texto_pe"><?php echo $reg_USU[2]; //dni ?></td> 
          <td class="caja_texto_peke"><a href="javascript:mostrar_edicion('<?php echo $reg_USU[2]; ?>')">
          <img src="image/BT4.gif" width="23" height="23" border="0" /></a></td> 
		  <td class="caja_texto_pe"><?php echo $reg_USU[3]; ?></a></td>
          
		  		<td align="center" class="caja_texto_pe"><?php echo $reg_USU[0]; //cip ?></td>    
				<td class="caja_texto_pe"><?php echo $reg_per["perfil"];    ?></td>                 
                <td class="caja_texto_pe" align="center">
					 <?php 
	  		 			if($reg_USU[38]==""){
				 			echo "-" ;   
						}else{
							echo $reg_USU[38] ;  
						}//FIN ?>
	  			</td>                  
                                           
				  <td class="caja_texto_pe"> <?php echo $reg_USU[9];?></td>
                  <? if($idperfil=="0" or $idperfil=="3"){?>
				  <td class="caja_texto_pe">
					<select name="criterio_1" class="caja_texto_pe" id="criterio_1" 
				  onchange="javascript:asignar_reglas('<?php echo $iduser;?>',this.value,'<?php echo $i; ?>','criterio_1','<?php echo $reg_USU[2]; ?>')">         
					  <option value="0">SELECCIONAR</option>
					  <option value="HABILITADO">ACTIVAR</option>
					  <option value="DESHABILITADO">DESACTIVAR</option>
					</select>
				  </td>
                  <? } ?>
				</tr>
				<?php } ?>
			</table></td>
		  </tr>
		</table>
		<p>
  <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
  <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
</p>
</body>
</html>