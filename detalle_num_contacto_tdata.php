<?php
//include ("conexion_bd.php"); 
include ("conexion_teradata.php"); 

$iduser		=$_GET["iduser"];	

$connection_teradata 	= db_conn_teradata();
$connection_mysql 		= db_conn_mysql();

	
set_time_limit(100000);	
	
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$id = $_GET["id"];
	$dni=trim($_GET["dni"]);
	$pedido=trim($_GET["pedido"]);	
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
	from dbi_cot.RB_Contactabilidad_COT where nombre_completo like '%$cliente%' and estado is null
	group by PETICION,nro_documento,TELEFONO";
	
	
	$dato = $cliente;
	$pre = "nombre_completo like '%$cliente%'";
	$obs="SE CONSULTO POR NOMBRES: ".$ape_pat."-".$ape_mat;		
	
	//$msn="PERSONA NO SE ENCUENTRA REGISTRADA EN LA BASE DE DATOS";
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	$filtro="Nombres";	
	}
	
	if($opc==2){ // dni			
			
			$d_hoy=date("l");
		 	$hora 	=date("h:m");			
			
			$cad_tdata="
			sel telefono,max(nro_documento) as nro_documento,max(peticion) as peticion,max(tipo_de_documento) as tp_documento,
			max(ape_paterno) as ape_pat,max(ape_materno) as ape_mat, max(nombres) as nombres,max(nombre_completo) as nombre_completo,
			max(operador) as operador
			from dbi_cot.RB_Contactabilidad_COT where nro_documento='$dni' and estado is null
			group by TELEFONO, probcto
			order  by probcto desc,telefono"; 
					
			
			$dato = $dni;
			$pre = "nro_documento='$dni'";
			$obs="SE CONSULTO POR DNI: ".$dni;	
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
	$filtro="Dni";		
	}
	
	
	if($opc==3){ // peticion
	
	
	$cad_tdata="sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,
	max(ape_materno) as ape_mat,
	max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
	from dbi_cot.RB_Contactabilidad_COT where peticion='$pedido' and estado is null
	group by PETICION,nro_documento,TELEFONO";

	
	$dato = $pedido;
	$pre = "peticion='$pedido'";
	$obs="SE CONSULTO POR NUMERO PETICION: ".$pedido;	
	//$msn="NUMERO EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	$filtro="Peticion";
	}
	
	
	if($opc==4){ // telefono
	
	
	$cad_tdata="sel peticion,nro_documento,telefono,max(tipo_de_documento) as tp_documento,max(ape_paterno) as ape_pat,
	max(ape_materno) as ape_mat,
	max(nombres) as nombres,max(nombre_completo) as nombre_completo,max(operador) as operador
	from dbi_cot.RB_Contactabilidad_COT where telefono='$ncontacto' and estado is null
	group by PETICION,nro_documento,TELEFONO";
	 
	
	$dato = $ncontacto;
	$pre = "telefono='$ncontacto'";
	$obs="SE CONSULTO POR NUMERO CONTACTO: ".$ncontacto;
		
	//$msn="NUMERO DE PEDIDO NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	$filtro="T.Contacto";
	}
	
	
	//echo $cad_tdata."<br>";
	
	/********************************************************************/
	
	
	$hoy 		=date ("Y-m-d h:m:s");
	
	
	//Busqueda efectiva 
	
	$sql_tdata_1="select count(*) as cant from dbi_cot.RB_Contactabilidad_COT where $pre";
	//echo $sql_tdata_1;
	
		$statement1=odbc_exec($connection_teradata, $sql_tdata_1);
		if (!$statement1){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
	$filas	=odbc_result($statement1,"cant");	
	
	//echo "<br>".$filas;
	
	if ($filas<1){
		$eje = "Busqueda No Efectiva";	
	}else{
		
		$sql_tdata_3="select top 1 peticion from dbi_cot.RB_Contactabilidad_COT where $pre";
	    //echo "<br>".$sql_tdata_3;
	
		$statement3=odbc_exec($connection_teradata, $sql_tdata_3);
		if (!$statement3){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
			}
		$peticion	=odbc_result($statement3,"peticion");	
		
		//echo "<br>".$filas;
		
		if ($peticion==""){
			$eje = "Busqueda Efectiva - Particular";	
		}else{
			$eje = "Busqueda Efectiva";
		}
		
	}
	
	
	/********************************************************/
	
	$sql_tdata_2="INSERT INTO
	DBI_COT.lc_movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato,usu_psi,usu_ase)
	VALUES('','CONSULTA CONTACTOS','$iduser','$hoy','$obs','$pc_sis','','$eje','$dato','$filtro')";
	//echo $sql_tdata_2;
	
	$statement2=odbc_exec($connection_teradata, $sql_tdata_2);
	if (!$statement2){
		exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
	}
	
	
	$sql_1	="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato,usu_psi,usu_ase)
	VALUES('','CONSULTA CONTACTOS','$iduser',now(),'$obs','$pc_sis','','$dato','$eje','$filtro')";
	//echo $sql_1;
	$res_1	= mysql_query($sql_1,$connection_mysql);
	
	/********************************************************/
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript1.2" type="text/javascript" src="funciones_js.js"></script>
</head>

<body>

  <p>       
    
  </p><input name="idperfil" type="hidden" id="idperfil" value="<?php echo $idperfil; ?>" />
  <input name="iduser" type="hidden" id="iduser" value="<?php echo $iduser; ?>" />
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
      <td width="32%" align="right" ><input name="xdni" type="hidden"  id="xdni" size="30" maxlength="10" readonly="readonly" value="<?php echo $dni;?>" class="caja_sb" /></td>
    </tr>
  </table>
  <p>

<?php 
if ($opc=="2"){  // BD GESCOT

		$d_hoy	=date("l");	
		$hora 	=date("h:m");
  
	  if ($d_hoy=="Saturday" and $hora>="13:30"){
		
		?>
		<DIV id="div_consulta_contacto" style="display:block">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="caja_texto_pe">
		  <tr >
			<th class="caja_texto_db" scope="col">PETICION</th>
			<th class="caja_texto_db" scope="col">DNI</th>
			<th class="caja_texto_db" scope="col">NOMBRE COMPLETO </th>
			<th class="caja_texto_db" scope="col">TELEFONO</th>
			<th class="caja_texto_db" scope="col">OPERADOR</th>
		  </tr>
			<?php
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
					  <td class="caja_texto_pe">
                      <input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
					  <td class="caja_texto_pe">
                      <img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
					  </tr>
					</table>
					</div>	
			</td>		
			</tr>	
			<tr>
			<td class="caja_texto_peke">
			  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"
			  size="10" maxlength="8" value="<?php echo  "S/P"; ?>" readonly="readonly" />    </td>
			<td class="caja_texto_peke">
			  <input name="xdni" type="text" class="caja_sb" id="xdni"
			  size="10" maxlength="8" value="<?php echo  $reg_0[2]; ?>" readonly="readonly" />    </td>
			<td class="caja_texto_peke"><?php echo $reg_0[7]; ?>	</td>
			<td class="caja_texto_peke" align="center"><input name="<?php echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<?php echo "xfijo".$i; ?>"
			size="10" maxlength="9" value="<?php echo $reg_0[3];?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
			<td class="caja_texto_peke"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<?php echo $reg_0[8];?>"  readonly="readonly" />	</td>
		  </tr>
		  <?php
		  }
		  }else{ ?>
		   <tr>
			<th colspan="10" class="caja_texto_peke"><?php echo "EL ".$dato." no se encuentra registrado en la Base de datos"; ?></td>
		   </tr>
		  <?php
		  } ?>
		</table>
		</div>
	<?php }else{   // BD TERADATA?>		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	    <tr>
		<th width="10%" class="caja_texto_pekecab" scope="col">PETICION</th>
		<th width="10%" class="caja_texto_pekecab" scope="col">DNI</th>
		<th width="32%" class="caja_texto_pekecab" scope="col">NOMBRE COMPLETO </th>
		<th width="13%" class="caja_texto_pekecab" scope="col">TELEFONO</th>
		<th width="18%" class="caja_texto_pekecab" scope="col">OPERADOR</th>
        <th width="17%" class="caja_texto_pekecab" scope="col">ACCION</th>
	    </tr>
		<?php
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
				  <td class="caja_texto_peke">TELEFONO</td>
				  <td class="caja_texto_peke"><input name="n_numero" type="text" class="caja_texto_pe" id="n_numero" size="20" maxlength="9" /></td>
				  <td class="caja_texto_peke"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_numero()" /></td>
				  </tr>
				</table>
				</div>	
		</td>		
		</tr>	
		<tr>
		<td class="caja_texto_peke">
		  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"  size="10" maxlength="8" value="<?php echo  $col_peticion; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_peke">
		  <input name="xdni" type="text" class="caja_sb" id="xdni"  size="10" maxlength="8" value="<?php echo  $col_ndoc; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_peke"><?php echo $col_ncompleto; ?>	</td>
		<td class="caja_texto_peke" align="center"><input name="<?php echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<?php echo "xfijo".$i; ?>"
		size="10" maxlength="9" value="<?php echo $col_telefono;?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
		<td class="caja_texto_peke"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<?php echo $col_operador;?>"  readonly="readonly" />	</td>
        	
        <td class="caja_texto_peke"><select name="acto" size="1" class="caja_texto_pe" id="acto" 
        onchange="javascript:actualizar_contacto_tdata('<?php echo $col_ndoc; ?>','<?php echo $col_telefono; ?>','<?php echo $pedido; ?>',this.value)" >
          <option value="T">Escoger</option>
          <option value="NO EXISTE">NO EXISTE</option>
          <option value="NO PERTENECE">NO PERTENECE</option>
        </select></td>
	  </tr>
	  <?php
	  }
	  }else{ ?>
	   <tr>
		<th colspan="10" class="caja_texto_peke"><?php echo "EL ".$dato." no se encuentra registrado en la Base de datos"; ?></td>
	   </tr>
        <tr>
		<th colspan="10" class="caja_texto_peke"></td>
	   </tr>
	   <?php
	   } ?>
	   </table>
	
		<?php
		} ?>



<?php }else{  // SI APLICA SWITCH ?>
	<DIV id="div_consulta_contacto" style="display:block">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="caja_texto_pe">
	  <tr>
		<th width="10%" class="caja_texto_pekecab" scope="col">PETICION</th>
		<th width="10%" class="caja_texto_pekecab" scope="col">DNI</th>
		<th width="32%" class="caja_texto_pekecab" scope="col">NOMBRE COMPLETO </th>
		<th width="14%" class="caja_texto_pekecab" scope="col">TELEFONO</th>
		<th width="17%" class="caja_texto_pekecab" scope="col">OPERADOR</th>
        <th width="17%" class="caja_texto_pekecab" scope="col">ACCION</th>
	  </tr>
		<?php 
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
		  <input name="xpeticion" type="text" class="caja_sb" id="xpeticion"  size="10" maxlength="8" value="<?php echo  $col_peticion; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe">
		  <input name="xdni" type="text" class="caja_sb" id="xdni"  size="10" maxlength="8" value="<?php echo  $col_ndoc; ?>" readonly="readonly" />    </td>
		<td class="caja_texto_pe"><?php echo $col_ncompleto; ?>	</td>
		<td class="caja_texto_pe" align="center"><input name="<?php echo "xfijo".$i; ?>" type="text" class="caja_sb" id="<?php echo "xfijo".$i; ?>"
		size="10" maxlength="9" value="<?php echo $col_telefono;?>" readonly="readonly" /><input name="" type="checkbox" value="" />	</td>
		<td class="caja_texto_pe"><input name="xop_" type="text" class="caja_sb" id="xop_" value="<?php echo $col_operador;?>"  readonly="readonly" />	</td>
         <td class="caja_texto_pe"><select name="acto2" size="1" class="caja_texto_pe" id="acto2" 
        onchange="javascript:actualizar_contacto_tdata('<?php echo $col_ndoc; ?>','<?php echo $col_telefono; ?>','<?php echo $pedido; ?>',this.value)" >
           <option value="T">Escoger</option>
           <option value="NO EXISTE">NO EXISTE</option>
           <option value="NO PERTENECE">NO PERTENECE</option>
         </select></td>
	  </tr>
	  <?php }
	  }else{ ?>
	   <tr>
		<th colspan="10" class="caja_texto_pe"><?php echo "EL ".$dato." no se encuentra registrado en la Base de datos"; ?></td>
	   </tr>
	  <?php } ?>
	</table>
	</div>
<?php }?>
</body>
</html>