<?php
include ("conexion_bd.php"); 	
	
	
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$id = $_GET["id"];
	$dni=trim($_GET["dni"]);
	$pedido=trim($_GET["pedido"]);
	$usuario=$_GET["usuario"];
	$idperfil=trim($_GET["idperfil"]);
	$opc=trim($_GET["opc"]);
	$ape_pat=trim($_GET["ape_pat"]);		
	$ape_mat=trim($_GET["ape_mat"]);
	$ncontacto=trim($_GET["ncontacto"]);		
	$cliente =$ape_pat." ".$ape_mat;
	
	$c_pc		=	"select pc,monitor from tb_usuarios where iduser='$usuario'";
	//echo $c_pc;
	$row_c_pc 	= 	mysql_query($c_pc) or die(mysql_error());
	$reg_c_pc	=	mysql_fetch_row($row_c_pc);
	$pc_asig	=	$reg_c_pc[0];
	
	
	/*	
	if ($dni=="" and $ncontacto==""){
		$obs="SE CONSULTO POR NOMBRES: ".$ape_pat."-".$ape_mat;	
		$dato= $ape_pat."-".$ape_mat;
	}else{
		if ($ncontacto==""){
		$obs="SE CONSULTO POR DNI: ".$dni;	
		$dato= $dni;
		}else{
		$obs="SE CONSULTO POR NUMERO CONTACTO: ".$ncontacto;	
		$dato= $ncontacto;			
		}
		
	}
	*/
	
	
	if($opc==1){	// apellidos y nombres
	$lista="(
	select campo2,campo3,campo8,campo7,item,'DATA CMR(BI)',pedido 
	from tb_contactos_actual 
	where campo11='REGISTRADO' and campo4='$ape_pat' and campo5='$ape_mat'
	group by 1,2
	)UNION(
	select campo2,campo3,campo8,campo7,item ,'DATA COT','S/P'
	from tb_contactos_cot 
	where tipo<>'Eliminar' and campo7 like '%$cliente%' 
	group by 1,2
	)UNION(
	select campo2,campo3,campo8,campo7,item ,'DATA TC','S/P'
	from tb_contactos_tc 
	where campo11='REGISTRADO' and campo7 like '%$cliente%'  
	group by 1,2)	
	";
	
	//$lista="select * from tb_contactos_actual where concat(campo6,'|',campo7)=concat('$ape_pat','|','$ape_mat')";
	//$lista="select * from tb_contactos_new where concat(campo6,'|',campo7)=concat('$ape_pat','|','$ape_mat') order by campo12 asc";
	$msn="PERSONA NO SE ENCUENTRA REGISTRADA EN LA BASE DE DATOS";
	$filtro="Nombres";
	$dato = $cliente;	
	$pre = "campo4='$ape_pat' and campo5='$ape_mat'";
	$obs="SE CONSULTO POR NOMBRES: ".$ape_pat."-".$ape_mat;		
	
	}
	
	if($opc==2){ // dni	
	$lista="(
	select campo2,campo3,campo8,campo7,item,'DATA CMR(BI)',pedido 
	from tb_contactos_actual 
	where campo2='$dni' AND campo11='REGISTRADO'
	group by 1,2
	)UNION(
	select campo2,campo3,campo8,campo7,item,'DATA COT','S/P'
	from tb_contactos_cot 
	where campo2='$dni' and tipo<>'ELIMINAR'  
	group by 1,2
	)UNION(
	SELECT campo2,campo3,campo8,campo7,item,'DATA TC','S/P'
	FROM tb_contactos_tc 
	WHERE campo2='$dni' and campo11='REGISTRADO'
	GROUP BY 1,2)";
	
	$msn="DNI EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	$filtro="Dni";	
	$dato = $dni;
	$pre = "campo2='$dni'";
	$obs="SE CONSULTO POR DNI: ".$dni;	
	}
	
	if($opc==4){	// numero contacto
	$lista="(
	select campo2,campo3,campo8,campo7,item,'DATA CMR(BI)',pedido 
	from tb_contactos_actual 
	where campo3='$ncontacto' AND campo11='REGISTRADO'
	group by campo2,campo3
	)union(
	select campo2,campo3,campo8,campo7,item,'DATA COT','S/P'
	from tb_contactos_cot 
	where campo3='$ncontacto' and tipo<>'Eliminar'  
	group by campo2,campo3
	)UNION(
	SELECT campo2,campo3,campo8,campo7,item,'DATA TC','S/P' 
	FROM tb_contactos_tc 
	WHERE campo3='$ncontacto' and campo11='REGISTRADO'
	group by campo2,campo3)";
	
	//$lista="select * from tb_contactos_new where campo3 like '%$ncontacto%'";
	$msn="NUMERO EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	$filtro="T.Contacto";
	$dato = $ncontacto;
	$pre = "campo3='$ncontacto'";
	$obs="SE CONSULTO POR NUMERO CONTACTO: ".$ncontacto;
	}
	
	if($opc==3){	// numero pedido
	
	$lista="select campo2,campo3,campo8,campo7,item,'DATA CMR(BI)',pedido 
	from tb_contactos_actual 
	where pedido='$pedido' AND campo11='REGISTRADO'
	group by campo2,campo3";
	/*
	$lista="(
	select campo2,campo3,campo8,campo7,item,'DATA CMR(BI)' 
	from tb_contactos_actual 
	where pedido='$pedido' AND campo11='REGISTRADO'
	group by campo2,campo3
	)union(
	select campo2,campo3,campo8,campo7,item,'DATA COT' 
	from tb_contactos_cot 
	where pedido='$pedido' and tipo<>'Eliminar'  
	group by campo2,campo3
	)UNION(
	SELECT campo2,campo3,campo8,campo7,item,'DATA TC' 
	FROM tb_contactos_tc 
	WHERE pedido='$pedido' and campo11='REGISTRADO'
	group by campo2,campo3)";
	*/
	//$lista="select * from tb_contactos_new where campo3 like '%$ncontacto%'";
	$msn="NUMERO DE PEDIDO NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	$filtro="Peticion";
	$dato = $pedido;
	$pre = "pedido='$pedido'";
	$obs="SE CONSULTO POR NUMERO PETICION: ".$pedido;	
	}
	
	//echo $opc."|"."<br>".$lista;
	
	$res_1 = mysql_query($lista);
	$nreg = mysql_num_rows($res_1);
	
	$cad="SELECT max(id) from movimiento_contactos";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);
	$nrg = mysql_num_rows($rs);
	$nid = $rg[0]+1;
	
	if ($nrg<1){
		$eje = "Busqueda No Efectiva";	
	}else{
		$p ="select pedido from tb_contactos_actual where $pre";
		//echo $p;
		$resp= mysql_query($p);
		$regp = mysql_fetch_array($resp);
		if ($regp[0]==""){
			$eje = "Busqueda Efectiva - Particular";	
		}else{
			$eje = "Busqueda Efectiva";
		}
	}
	/*	
	$sql_="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES($nid,'CONSULTA CONTACTOS','$usuario',now(),'$obs','$pc_sis','$pc_asig','$dato')";
	*/
	$sql_	="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato,usu_psi,usu_ase)
	VALUES('','CONSULTA CONTACTOS','$usuario',now(),'$obs','$pc_sis','$reg_c_pc[0]','$dato','$eje','$filtro')";
	//echo $sql_;
	$res_= mysql_query($sql_);
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
</head>

<body>

  <p>       
    <input name="idperfil" type="hidden" id="idperfil" value="<?php echo $idperfil; ?>" />
  </p>
  <table width="120%" border="0" align="center">
    <tr>
      <td>     
      <a href="JAVASCRIPT:act_nro_contacto()" class="caja_texto_pe">
      <img src="image/BT2.gif" width="20" height="20" border="0" />Agregar Numero</a>
      <a href="JAVASCRIPT:javascript:historico_contactos(<?php echo $reg_1[0];?>)" class="caja_texto_pe">
      <img src="image/edit-find-replace.png" width="20" height="20" border="0" />Historico</a>
      </td>
      <td width="32%" align="right" ><input name="xdni" type="hidden"  id="xdni" size="30" maxlength="10" readonly="readonly" value="<?php echo $dni;?>" class="caja_sb" /></td>
    </tr>
  </table>
  <p>
  <?php //echo "BD: Local GESCOT"; ?>
<div id="div_actualizar_contacto" style="display:none">
<table width="120%" border="0" class="marco_tabla" align="center">
  <tr >
    <td width="38%" class="clsHoliDayCell">TELEFONO</td>
    <td width="45%" class="clsHoliDayCell">OPERADOR</td>
    <td width="8%" class="clsHoliDayCell">GUARDAR</td>
  </tr> 
  <tr>
    <td><input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
    <td><select name="n_operador" id="n_operador" class="caja_texto_pe" >
      <?php 			
			print "<option value='S/O' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td class="caja_texto_est"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
  </tr>
</table>
</div>

<?php

if ($nreg > 0){ ?>


  <p>
<DIV id="div_consulta_contacto" style="display:block">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr >
    <td width="12%" class="caja_texto_db">PEDIDO</td>
    <td width="12%" class="caja_texto_db">DNI</td>
    <td width="18%" class="caja_texto_db">NOMBRE CONTACTO</td>
    <td width="11%" class="caja_texto_db">TELEFONO</td>
    <td width="27%" class="caja_texto_db">OPERADOR</td>    
    <td colspan="2" class="caja_texto_db">ORIGEN</td>
    <!--<td width="11%" class="cabeceras_grid">PANEL</td>-->
  </tr>
  <?php 
  while($reg_1=mysql_fetch_row($res_1)){	
  $i=$i+1;	
  ?>
  <tr>
    <td><input name="<?php echo "xdni".$i; ?>2" type="text" class="caja_texto_pe" id="<?php echo "xdni".$i; ?>2"
    size="10" maxlength="8" value="<?php echo $reg_1[6];?>" readonly="readonly"  /></td>
    <td>
    <input name="<?php echo "xdni".$i; ?>" type="text" class="caja_texto_pe" id="<?php echo "xdni".$i; ?>"
    size="10" maxlength="8" value="<?php echo $reg_1[0];?>" readonly  />    </td>
    <td class="caja_texto_min"><input type="text" class="caja_texto_pe" size="70" value="<?php echo ltrim($reg_1[3]);?>" readonly="readonly">
     </td>
    <td > <input name="<?php echo "xfijo".$i; ?>" type="text" class="caja_texto_pe" id="<?php echo "xfijo".$i; ?>"
    size="20" maxlength="9" value="<?php echo $reg_1[1];?>"  /></td>
    <td>
    <input name="xop_" type="text" class="caja_texto_pe" id="xop_" value="<?php echo $reg_1[2];?>"  readonly />
	<!--
      <select name="<?php echo "oper_".$i; ?>" id="<?php echo "oper_".$i; ?>" class="caja_texto_pe" >
        <?php 			
			print "<option value='0' selected>Seleccione Operador</option>";
			print "<option value='CASA'>CASA</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
      </select>
	  --></td>
    <td width="8%" class="caja_texto_min">
	<input name="<?php echo "xfijo".$i; ?>" type="text" class="caja_texto_pe" id="<?php echo "xfijo".$i; ?>"
    size="20" maxlength="9" value="<?php echo $reg_1[5];?>"  />
	</td>
	<td width="13%" class="caja_texto_min">
	<!--
    <select name="<?php echo "c_tipo".$i; ?>" id="<?php echo "c_tipo".$i; ?>" class="caja_texto_pe" >
      <option value="T">Escoger</option>
      <option value="Eliminar">ELIMINAR</option>
      <option value="Actualizar">ACTUALIZAR INFO</option>
    </select>
	--></td>
    <?php //if ($idperfil==0){ ?>
    <td class="caja_texto_min">    
    <!--<img src="image/act.jpg" alt="" width="20" height="20" 
    onclick="javascript:act_contacto('<?php echo $reg_1[4];?>','<?php echo "xfijo".$i; ?>')" title="ACTUALIZAR" /> 

    <img src="image/eliminar2.jpg" width="20" height="20" border="0" title="ELIMINAR" 
    onclick="javascript:eliminar_contacto('<?php echo $reg_1[4]?>','<?php echo $reg_1[0]?>','<?php echo $reg_1[1]?>')" /> 
   
    <img src="image/reg2.jpg" width="20" height="20"  
    onclick="javascript:gestion_contacto('<?php echo $i ?>','<?php echo "xfijo".$i; ?>',
    '<?php echo $reg_1[0]?>','<?php echo $reg_1[1]?>','<?php echo $reg_1[4];?>')"/>    </td>
      <?php //} ?>   
	   -->  
    </tr>
  <?php } ?>
</table>
</div>

<?php }else{ ?>

<DIV id="div_consulta_contacto" style="display:block">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr >
    <td height="50" class="cabeceras_grid">PEDIDO</td>
    <td class="cabeceras_grid">DNI</td>
    <td class="cabeceras_grid">NOMBRE CONTACTO</td>
    <td class="cabeceras_grid">TELEFONO</td>
    <td class="cabeceras_grid">OPERADOR</td>    
    <td class="cabeceras_grid">ORIGEN<br></td> 
    <p>  
  </tr>

  <tr>  
    <td height="50" class="cabeceras_grid" colspan="8" align="center">NO EXISTE INFORMACION</td>
   </tr>
    
</table>
</div>

<?php } ?>

</body>
</html>