<?php
//include ("conexion_bd.php"); 
include ("conexion_teradata.php"); 

$connection_teradata 	= db_conn_teradata();
$connection_mysql 		= db_conn_mysql();

	
set_time_limit(100000);	
	
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$id = $_GET["id"];
	$dni=trim($_GET["dni"]);
	$pedido=trim($_GET["pedido"]);
	$usuario=$_GET["usuario"];
	$idperfil=trim($_GET["idperfil"]);
	$f1=trim($_GET["f1"]);
	$opc=trim($_GET["opc"]);
	$ape_pat=trim($_GET["ape_pat"]);		
	$ape_mat=trim($_GET["ape_mat"]);
	$ncontacto=trim($_GET["ncontacto"]);		
	$cliente =$ape_pat." ".$ape_mat;
		
	/********************************************************************/	
	
	if($opc==1){ // nombres
	$cad_tdata="
	sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,max(ape_materno) as ape_mat,
	max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
	from dbi_public.JRR_Contactabilidad_COT where nombre_completo like '%$cliente%' group by PETICION,nro_documento,TELEFONO";
	$filtro="Nombres";
	$dato = $cliente;
	//$msn="PERSONA NO SE ENCUENTRA REGISTRADA EN LA BASE DE DATOS";
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}	
	}
	
	if($opc==2){ // dni
	
			$d_hoy=date("l");
		 	$hora 	=date("h:m");			
					
			$cad_tdata="
			sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,max(ape_materno) as ape_mat,
			max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
			from dbi_public.JRR_Contactabilidad_COT where nro_documento='$dni' group by PETICION,nro_documento,TELEFONO"; 
					// echo $cad_tdata;
					
			$filtro="Dni";
			$dato = $dni;
			//$msn="PERSONA NO SE ENCUENTRA REGISTRADA EN LA BASE DE DATOS";
				$statement=odbc_exec($connection_teradata, $cad_tdata);
				if (!$statement){
			 		exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
						
				}
			
			/*			
			$cad_mysql="select * from tb_contactos_ant where campo2='$dni' group by campo3";
				$filtro="Dni";
				$dato = $dni;
				//$msn="DNI EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
				$res_0	= mysql_query($cad_mysql,$connection_mysql);
				$num_rows	= mysql_num_rows($res_0);
			*/				
	}
	
	
	if($opc==3){ // peticion
	$cad_tdata="sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,max(ape_materno) as ape_mat,
	max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
	from dbi_public.JRR_Contactabilidad_COT where peticion='$pedido' group by PETICION,nro_documento,TELEFONO";

	$filtro="Peticion";
	$dato = $pedido;
	//$msn="NUMERO EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	}
	
	
	if($opc==4){ // telefono
	$cad_tdata="sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,max(ape_materno) as ape_mat,
	max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
	from dbi_public.JRR_Contactabilidad_COT where telefono='$ncontacto' group by PETICION,nro_documento,TELEFONO";
	 
	$dato = $ncontacto;
	//$msn="NUMERO DE PEDIDO NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	}
	
	
	//echo $cad_tdata;
		
	
	
	/********************************************************************/
	
	
	if ($dni=="" and $ncontacto==""){
		$obs="SE CONSULTO POR NOMBRES: ".$ape_pat."-".$ape_mat;		
	}else{
		if ($ncontacto==""){
		$obs="SE CONSULTO POR DNI: ".$dni;	
		}else{
		$obs="SE CONSULTO POR NUMERO CONTACTO: ".$ncontacto;	
		}
		
	}
	
	
	
	$sql_1	="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES('','CONSULTA CONTACTOS','$usuario',now(),'$obs','$pc_sis','','$dato')";
	//echo $sql_1;
	$res_1	= mysql_query($sql_1,$connection_mysql);
	
	echo "BD: TData";	
	//echo "<br>".date("h:i:s");
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
    
  </p><input name="idperfil" type="hidden" id="idperfil" value="<? echo $idperfil; ?>" />
  <table width="120%" border="0" align="center">
    <tr>
      <td>
	  <!--     
      <a href="JAVASCRIPT:act_nro_contacto()" class="caja_texto_pe">
      <img src="image/BT2.gif" width="20" height="20" border="0" />Agregar Numero</a>
	  -->
      <a href="JAVASCRIPT:javascript:historico_contactos_tdata()" class="caja_texto_pe">
      <img src="image/edit-find-replace.png" width="20" height="20" border="0" />Historico</a>
      </td>
      <td width="32%" align="right" ><input name="xdni" type="hidden"  id="xdni" size="30" maxlength="10" readonly="readonly" value="<? echo $dni;?>" class="caja_sb" /></td>
    </tr>
  </table>
  <p>

<? if ($opc=="2"){

		$d_hoy	=date("l");	
		$hora 	=date("h:m");
  
	  if ($d_hoy=="Saturday" and $hora>="13:30"){
		
		?>
		<DIV id="div_consulta_contacto" style="display:block">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="caja_texto_VERDE" scope="col">PETICION</th>
			<th class="caja_texto_VERDE" scope="col">DNI</th>
			<th class="caja_texto_VERDE" scope="col">NOMBRE COMPLETO </th>
			<th class="caja_texto_VERDE" scope="col">TELEFONO</th>
			<th class="caja_texto_VERDE" scope="col">OPERADOR</th>
		  </tr>
			<? 
			if ($num_rows > 0){
			 
				while($reg_0=mysql_fetch_row($res_0)){		    
					 
					 $i=$i+1;	
		  ?>
			<tr>
			<td colspan="6">
					<div id="div_actualizar_contacto" style="display:NONE">
					<table width="40%" align="center">
					<tr>
					  <td colspan="3" class="caja_texto_db">Registro de Telefono </td>
					  </tr>
					<tr>
					  <td class="caja_texto_pe">TELEFONO</td>
					  <td class="caja_texto_pe"><input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
					  <td class="caja_texto_pe"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
					  </tr>
					</table>
					</div>	
			</td>		
			</tr>	
			<tr>
			<td class="caja_texto_pe">
			  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"
			  size="10" maxlength="8" value="<? echo  "S/P"; ?>" readonly="readonly" />    </td>
			<td class="caja_texto_pe">
			  <input name="xdni" type="text" class="caja_sb" id="xdni"
			  size="10" maxlength="8" value="<? echo  $reg_0[2]; ?>" readonly="readonly" />    </td>
			<td class="caja_texto_pe"><? echo $reg_0[7]; ?>	</td>
			<td class="caja_texto_pe" align="center"><input name="<? echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<? echo "xfijo".$i; ?>"
			size="10" maxlength="9" value="<? echo $reg_0[3];?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
			<td class="caja_texto_pe"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<? echo $reg_0[8];?>"  readonly="readonly" />	</td>
		  </tr>
		  <? }
		  }else{ ?>
		   <tr>
			<th colspan="10" class="caja_texto_pe"><? echo "EL ".$dato." no tiene peticion registrada"; ?></td>
		   </tr>
		  <? } ?>
		</table>
		</div>
	<? }else{ ?>		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	    <tr>
		<th class="caja_texto_VERDE" scope="col">PETICION</th>
		<th class="caja_texto_VERDE" scope="col">DNI</th>
		<th class="caja_texto_VERDE" scope="col">NOMBRE COMPLETO </th>
		<th class="caja_texto_VERDE" scope="col">TELEFONO</th>
		<th class="caja_texto_VERDE" scope="col">OPERADOR</th>
	    </tr>
		<? 
		//echo odbc_fetch_row($statement);
		
		if (odbc_num_rows($statement) > 0){
		 
			while (odbc_fetch_row($statement)) {
				 $col_peticion	=odbc_result($statement,"Peticion");			
				 $col_ndoc		=odbc_result($statement,"nro_documento");				
				 $col_telefono	=odbc_result($statement,"Telefono");	
				 $col_ncompleto	=odbc_result($statement,"nombre_completo");	 			  
				 $col_operador	=odbc_result($statement,"operador");
				 
				 $i=$i+1;	
	  	?>
		<tr>
		<td colspan="6">
				<div id="div_actualizar_contacto" style="display:NONE">
				<table width="40%" align="center">
				<tr>
				  <td colspan="3" class="caja_texto_db">Registro de Telefono </td>
				  </tr>
				<tr>
				  <td class="caja_texto_pe">TELEFONO</td>
				  <td class="caja_texto_pe"><input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
				  <td class="caja_texto_pe"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
				  </tr>
				</table>
				</div>	
		</td>		
		</tr>	
		<tr>
		<td class="caja_texto_pe">
		  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"  size="10" maxlength="8" value="<? echo  $col_peticion; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe">
		  <input name="xdni" type="text" class="caja_sb" id="xdni"  size="10" maxlength="8" value="<? echo  $col_ndoc; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe"><? echo $col_ncompleto; ?>	</td>
		<td class="caja_texto_pe" align="center"><input name="<? echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<? echo "xfijo".$i; ?>"
		size="10" maxlength="9" value="<? echo $col_telefono;?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
		<td class="caja_texto_pe"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<? echo $col_operador;?>"  readonly="readonly" />	</td>
	  </tr>
	  <? }
	  }else{ ?>
	   <tr>
		<th colspan="10" class="caja_texto_pe"><? echo "EL ".$dato." no tiene peticion registrada"; ?></td>
	   </tr>
	   <? } ?>
	   </table>
	
		<? } ?>



<? }else{ ?>
	<DIV id="div_consulta_contacto" style="display:block">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<th class="caja_texto_VERDE" scope="col">PETICION</th>
		<th class="caja_texto_VERDE" scope="col">DNI</th>
		<th class="caja_texto_VERDE" scope="col">NOMBRE COMPLETO </th>
		<th class="caja_texto_VERDE" scope="col">TELEFONO</th>
		<th class="caja_texto_VERDE" scope="col">OPERADOR</th>
	  </tr>
		<? 
		//echo odbc_fetch_row($statement);
		
		if (odbc_num_rows($statement) > 0){
		 
			while (odbc_fetch_row($statement)) {
				 $col_peticion	=odbc_result($statement,"Peticion");			
				 $col_ndoc		=odbc_result($statement,"nro_documento");				
				 $col_telefono	=odbc_result($statement,"Telefono");	
				 $col_ncompleto	=odbc_result($statement,"nombre_completo");	 			  
				 $col_operador	=odbc_result($statement,"operador");
				 
				 $i=$i+1;	
	  	?>
		<tr>
		<td colspan="6">
				<div id="div_actualizar_contacto" style="display:NONE">
				<table width="40%" align="center">
				<tr>
				  <td colspan="3" class="caja_texto_db">Registro de Telefono </td>
				  </tr>
				<tr>
				  <td class="caja_texto_pe">TELEFONO</td>
				  <td class="caja_texto_pe"><input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
				  <td class="caja_texto_pe"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
				  </tr>
				</table>
				</div>	
		</td>		
		</tr>	
		<tr>
		<td class="caja_texto_pe">
		  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"  size="10" maxlength="8" value="<? echo  $col_peticion; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe">
		  <input name="xdni" type="text" class="caja_sb" id="xdni"  size="10" maxlength="8" value="<? echo  $col_ndoc; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe"><? echo $col_ncompleto; ?>	</td>
		<td class="caja_texto_pe" align="center"><input name="<? echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<? echo "xfijo".$i; ?>"
		size="10" maxlength="9" value="<? echo $col_telefono;?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
		<td class="caja_texto_pe"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<? echo $col_operador;?>"  readonly="readonly" />	</td>
	  </tr>
	  <? }
	  }else{ ?>
	   <tr>
		<th colspan="10" class="caja_texto_pe"><? echo "EL ".$dato." no tiene peticion registrada"; ?></td>
	   </tr>
	  <? } ?>
	</table>
	</div>
<? }?>
</body>
</html>