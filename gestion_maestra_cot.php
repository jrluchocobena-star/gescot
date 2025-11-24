<?php
include("conexion_bd.php");

$caso=$_GET["caso"];  
$dni=$_GET["dni"]; 
$iduser=$_GET["iduser"];  
?>
  
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones_js.js"></script>

<script type="text/javascript">

function cerrar_esto() 
{
	parent.location.reload(true);	
	parent.ras.hide();
}




function mostrar_mov_usuarios(id,dni,cip,usu,apli) {		
	 document.getElementById("div_edicion_usuarios").style.display="block";
		
	 document.getElementById("xid_ant").value=id;
	 document.getElementById("xdni_mov").value=dni;
	 document.getElementById("xcip_mov").value=cip;
	 document.getElementById("xusu_mov").value=usu;
	 document.getElementById("xapli_mov").value=apli;
	 document.getElementById("xdni_mov").focus(); 
}


function mostrar_mov_usuarios_n() {		
 document.getElementById("div_edicion_usuarios_n").style.display="block";
 
 document.getElementById("xdni_mov_n").focus();
 
}


</script> 
<input name="iduser" type="hidden" id="iduser" value="<?php echo $_GET["iduser"]; ?>">
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="8" align="right">
	<a href="javascript:cerrar_esto()" class="caja_texto_pe">  Salir  </a>
	</td>
  </tr>
</table>  
<p>

<?php if ($caso=="1"){


  $sql_usu = "SELECT * FROM usuarios_detalle where dni='$dni' GROUP BY dni";
 // echo $sql_usu;
  $res_USU = mysql_query($sql_usu);											
  $nreg= mysql_num_rows($res_USU);
  $reg_USU=mysql_fetch_array($res_USU);
  
  $loc="select * from tb_locales where cod_local='$reg_USU[local]'";  
 //	echo $loc;
  $res_loc = mysql_query($loc);											
  $reg_loc=mysql_fetch_array($res_loc);
  
  $sup="select * from tb_supervisores where cod_supervisor='$reg_USU[c_supervisor]'";  
 //	echo $loc;
  $res_sup = mysql_query($sup);											
  $reg_sup=mysql_fetch_array($res_sup);
  
  $mon="select * from tb_monitores where cod_monitor='$reg_USU[c_monitor]'";  
 //	echo $loc;
  $res_mon = mysql_query($mon);											
  $reg_mon=mysql_fetch_array($res_mon);
  
  $per="select * from tb_perfil where id='$reg_USU[perfil]'";  
 //	echo $loc;
  $res_per = mysql_query($per);											
  $reg_per=mysql_fetch_array($res_per);
  
  

?>


<table width="90%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja" >
  <tr>
    <td colspan="8" class="caja_texto_db">INFORMACION DE USUARIOS(ACTUALES) </td>
  </tr>
  <tr>
    <td colspan="8"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="celdas">
        <td width="10%" class="caja_texto_plomo">RED</td>
        <td width="10%" height="18" class="caja_texto_plomo">GESCOT</td>
        <td width="10%" class="caja_texto_plomo">GESTEL</td>
        <td width="10%" class="caja_texto_plomo">CMS</td>
        <td width="10%" class="caja_texto_plomo">ATIS</td>
        </tr>
      <tr>
        <td class="caja_texto_est">
		<input name="text" type="text" class="caja_sb" id="usuario_red" value="<?php echo  $reg_USU["usuario_red"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="login" value="<?php echo  $reg_USU["usuario_gescot"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_GESTEL" value="<?php echo  $reg_USU["USUARIO_GESTEL"]; ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_CMS" value="<?php echo  $reg_USU["USUARIO_CMS"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_ATIS" value="<?php echo  $reg_USU["USUARIO_ATIS"];  ?>" size="20" readonly="readonly" /></td>
        </tr>
      <tr class="celdas">
        <td class="caja_texto_plomo">GENIO</td>
        <td height="18" class="caja_texto_plomo">SARA</td>
        <td class="caja_texto_plomo">TECNICA/ASIGNACIONES</td>
        <td class="caja_texto_plomo">MAPA GICS</td>
        <td class="caja_texto_plomo">CALC. ARPU</td>
        </tr>
      <tr>
        <td class="caja_texto_est"><input name="text22" type="text" class="caja_sb" id="USUARIO_GENIO" value="<?php echo  $reg_USU["USUARIO_GENIO"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text23" type="text" class="caja_sb" id="WEB_SARA" value="<?php echo  $reg_USU["WEB_SARA"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text3" type="text" class="caja_sb" id="web_asignaciones" value="<?php echo  $reg_USU["WEB_ASIGNACIONES"];   ?>" 
			  size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text24" type="text" class="caja_sb" id="WEB_SIGTP_MAPA_GIG" value="<?php echo  $reg_USU["WEB_SIGTP_MAPA_GIG"];   ?>" size="20" readonly="readonly" /></td>
        <td class="caja_texto_est"><input name="text25" type="text" class="caja_sb" id="CALC_ARPU" value="<?php echo  $reg_USU["WEB_ARPU_CALCULADORA"];   ?>" size="20" readonly="readonly" /><p></td>
        </tr>
      <tr class="celdas">
        <td class="caja_texto_plomo">UNIFICADA</td>
        <td height="18" class="caja_texto_plomo">MULTICONSULTAS</td>
        <td class="caja_texto_plomo">INTRAWAY</td>
        <td class="caja_texto_plomo">PSI</td>
        <td class="caja_texto_plomo">ASEGURAMIENTO</td>
        </tr>
      <tr>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_WEB_UNIFICADA" value="<?php echo  $reg_USU["USUARIO_WEB_UNIFICADA"];   ?>" size="20" readonly="readonly" />        </td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_MULTICONSULTA" value="<?php echo  $reg_USU["USUARIO_MULTICONSULTA"];  ?>" size="20" readonly="readonly" />        </td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_INTRAWAY" value="<?php echo  $reg_USU["USUARIO_INTRAWAY"];   ?>" size="20" readonly="readonly" />        </td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="USUARIO_PSI" value="<?php echo  $reg_USU["USUARIO_PSI"];   ?>" size="20" readonly="readonly" />        </td>
        <td class="caja_texto_est"><input name="text2" type="text" class="caja_sb" id="WEB_ASEGURAMIENTO" value="<?php echo  $reg_USU["WEB_ASEGURAMIENTO"];   ?>" size="20"  readonly="readonly" />        <p></td>
        </tr>
    </table></td>
  </tr>
</table>
<?php } ?>

<?php

if ($caso=="2"){

$dni=$_GET["dni"];
	
	$listax="select * from movimiento_usuarios where dato='$dni' GROUP BY SUBSTR(fec_mov,1,16) order by fec_mov desc";
	//echo $listax;
	$res_lis_x = mysql_query($listax);
	
	echo "<table width='100%'>";							
			echo "<tr>";					
			echo "<td class='caja_texto_db' colspan='5'>HISTORICO DE MOVIMIENTOS</td>";		
			echo "</tr>";
			echo "<tr>";							
			echo "<td class='celdas' width='5%'>FECHA </td>";															
			echo "<td class='celdas' width='10%'>USU.MOVIMIENTO</td>";						
			echo "<td class='celdas' width='10%'>PROCESO</td>";	
			echo "<td class='celdas' width='30%'>DETALLE</td>";		
			echo "</tr>";
	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	
		$usu="select * from tb_usuarios where iduser='$reg_lis_x[2]'";
		$res_usu= mysql_query($usu);
		$reg_usu=mysql_fetch_row($res_usu);
		
		$sup="select * from tb_supervisores where cod_supervisor='$reg_usu[23]'";
//		echo $sup;
		$res_sup= mysql_query($sup);
		$reg_sup=mysql_fetch_row($res_sup);
					
		echo "<tr>";	
		
		echo "<td class='caja_sb'>";
		echo $reg_lis_x[3]; 				
		echo "</td>";			
		
		echo "<td  class='caja_sb'>";
		echo $reg_usu[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_sb'>";
		echo $reg_lis_x[1]; 				
		echo "</td>";
		
		echo "<td class='caja_sb'>";
		echo $reg_lis_x[4]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";	
	
}

if ($caso=="3"){  // HISTORICO


	$listax="SELECT * FROM movimientos_maestra WHERE dni='$dni' order by fec_mov desc";
	//echo $listax;
	$res_lis_x = mysql_query($listax);

?>	
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td class="caja_texto_db">DNI</td>
    <td class="caja_texto_db">CIP</td>
    <td class="caja_texto_db">USUARIO</td>
    <td class="caja_texto_db">APLICATIVO</td>
    <td class="caja_texto_db">FEC.MOV.</td>
    <td class="caja_texto_db">FEC.INI</td>
    <td class="caja_texto_db">FEC.FIN</td>
    <td class="caja_texto_db">ACTUALIZADO POR</td>
    <td class="caja_texto_db">ESTADO</td>
  </tr>

<?	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	
		$usu="select * from tb_usuarios where dni='$reg_lis_x[1]'";
		$res_usu= mysql_query($usu);
		$reg_usu=mysql_fetch_row($res_usu);
		
		$usu_r="select * from tb_usuarios where iduser='$reg_lis_x[8]'";
		$res_usu_r= mysql_query($usu_r);
		$reg_usu_r=mysql_fetch_row($res_usu_r);
						
		echo "<tr>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_usu[3]; 				
		echo "</td>";			
		
		if ($reg_lis_x[2]==""){
			echo "<td  class='caja_texto_pe'>X</td>";
		}else{
			echo "<td  class='caja_texto_pe'>";
			echo $reg_lis_x[2]; 			
			echo "</td>";	
		}
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_lis_x[3]; 			
		echo "</td>";	
			
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[5]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[6]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[7]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_usu_r[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[10]; 				
		echo "</td>";	

		echo "</tr>";				
		}	
	echo "</table>";	
}	


if ($caso=="4"){    // FORM MOVIMIENTO?>

<div id="div_edicion_usuarios" style="display:none">
		<table width="80%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
		  <tr>
			<th width="13%" class="caja_texto_VERDE" scope="col">DNI</th>
			<th width="13%" class="caja_texto_VERDE" scope="col">CIP</th>
			<th width="13%" class="caja_texto_VERDE" scope="col">USUARIO</th>
			<th width="14%" class="caja_texto_VERDE" scope="col">APLICATIVO</th>
			<th width="20%" class="caja_texto_VERDE" scope="col">FEC. INI</th>
			<th width="7%" scope="col"><input name="xid_ant" type="HIDDEN" class="caja_texto_pe" id="xid_ant"  /></th>
		  </tr>
		  
		  <tr>
			<td><input name="xdni_mov" type="text" class="caja_texto_pe" id="xdni_mov" readonly  />    </td>
			<td><input name="xcip_mov" type="text" class="caja_texto_pe" id="xcip_mov" readonly  />    </td>
			<td><input name="xusu_mov" type="text" class="caja_texto_pe" id="xusu_mov"  />    			</td>
			<td><input name="xapli_mov" type="text" class="caja_texto_pe" id="xapli_mov" size="40" readonly></td>
			<td><table width="200" border="0" align="center" class="caja_texto_pe">
			  <tr>
				<td width="51"> DD
				  <input name="dia_i" type="text" class="caja_texto_pe" id="dia_i" value="00" size="6" maxlength="2" /></td>
				<td width="65">MM
				  <select name="mes_i" size="1" class="caja_texto_pe" id="mes_i" >
					  <!--
					  <option value="00">Mes </option>
					  <option value="01">01</option>
					  <option value="02">02</option>
					  <option value="03">03</option>
					  <option value="04">04</option>
					  <option value="05">05</option>
					  <option value="05">06</option>
					  <option value="07">07</option>
					  <option value="08">08</option>-->
					  <option value="09">09</option>
					  <option value="10">10</option>
					  <option value="11">11</option>
					  <option value="12">12</option>
				  </select></td>
				<td width="70">AA
				  <select name="an_i" size="1" class="caja_texto_pe" id="an_i" >
					  <option value="0000">Escoger </option>
					  <option value="2019">2019</option>
					  <option value="2020">2020</option>
					  <option value="2021">2021</option>
					  <option value="2022">2022</option>
					  <option value="2023">2023</option>
					  <option value="2024">2024</option>
				  </select></td>
			  </tr>
			</table></td>
			<td><a class="caja_texto_pe" href="javascript:grabar_movimientos_usuarios()"><img src="image/BT7.gif" width="20" height="20" border="0" /> Grabar</a> </td>
		  </tr>
		</table>
</div>



<?php

	$listax1="SELECT * FROM movimientos_maestra WHERE dni='$dni' AND est='ACTIVO' order by fec_mov desc";
    echo $listax1;
	$res_lis_x = mysql_query($listax1);
	
	
	echo "<table width='100%'>";	
	echo "<tr>";
	echo "<td colspan='7' class='caja_texto_pe'> LAS COLUMNAS DE COLOR AMARILLO (USUARIO Y FEC.INI) SON LAS UNICAS QUE PUEDEN SER MODIFICADAS";
	echo "<tr>";
			
			echo "<tr>";
			/*
			echo "<td valign='top'>
			<a class='caja_texto_pe' href='javascript:grabar_movimientos_usuarios()'><img src='image/BT7.gif' width='20' height='20' border='0' /> Grabar</a>	
			<a class='caja_texto_pe' href='javascript:mostrar_mov_usuarios_n()'><img src='image/stock_copy.png' width='20' height='20' border='0' /> Editar</a> <br>";
			echo "</td>";
			*/
			echo "<td colspan='7'>";?>
			<div id="div_edicion_usuarios_n" style="display:none">
							<table width="60%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
							  <tr>
								<th width="41%" class="caja_texto_VERDE" scope="col">DNI</th>
								<th width="41%" class="caja_texto_VERDE" scope="col">FEC. INI</th>
							  </tr>
							  
							  <tr>
								<td><input name="xdni_mov_n" type="text" class="caja_texto_pe" id="xdni_mov_n" value="<?php echo $dni?>"readonly  />    </td>
								<td><table width="200" border="0" align="center" class="caja_texto_pe">
								  <tr>
									<td width="51"> DD
									  <input name="dia_i_n" type="text" class="caja_texto_pe" id="dia_i_n" value="00" size="6" maxlength="2" /></td>
									<td width="65">MM
									  <select name="mes_i_n" size="1" class="caja_texto_pe" id="mes_i_n" >
										  <!--
										  <option value="00">Mes </option>
										  <option value="01">01</option>
										  <option value="02">02</option>
										  <option value="03">03</option>
										  <option value="04">04</option>
										  <option value="05">05</option>
										  <option value="05">06</option>
										  <option value="07">07</option>
										  <option value="08">08</option>-->
										  <option value="09">09</option>
										  <option value="10">10</option>
										  <option value="11">11</option>
										  <option value="12">12</option>
									  </select></td>
									<td width="70">AA
									  <select name="an_i_n" size="1" class="caja_texto_pe" id="an_i_n" >
										  <option value="0000">Escoger </option>
										  <option value="2019">2019</option>
										  <option value="2020">2020</option>
										  <option value="2021">2021</option>
										  <option value="2022">2022</option>
										  <option value="2023">2023</option>
										  <option value="2024">2024</option>
									  </select></td>
								  </tr>
								</table></td>
								<td>
								<a class="caja_texto_pe" href="javascript:grabar_movimientos_usuarios()"><img src="image/BT7.gif" width="20" height="20" border="0" /> 
								Grabar</a> </td>
							  </tr>
							</table>
			</div>
			<?php
			echo "</td>";
			echo "</tr>";									
			echo "<tr>";							
			echo "<td class='caja_texto_db'>DNI</td>";		
			echo "<td class='caja_texto_db'>CIP</td>";												
			echo "<td class='caja_texto_db'>USUARIO</td>";	
			echo "<td class='caja_texto_db'>APLICATIVO</td>";						
			echo "<td class='caja_texto_db'>FEC.MOV.</td>";
			echo "<td class='caja_texto_db'>FEC.INI</td>";
			echo "<td class='caja_texto_db'>FEC.FIN</td>";					
			echo "</tr>";
	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	
		$usu="select * from tb_usuarios where dni='$reg_lis_x[1]'";
		$res_usu= mysql_query($usu);
		$reg_usu=mysql_fetch_row($res_usu);
						
		echo "<tr>";	
		
		echo "<td class='caja_texto_pe'>"; //dni
		echo "<input name='dni_mov' type='text' class='caja_sb' id='dni_mov' size='15'  value='$reg_lis_x[1]' readonly>";
//		echo $reg_lis_x[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; //cip
		echo "<input name='cip_mov' type='text' class='caja_sb' id='cip_mov' size='15' value='$reg_usu[3]' readonly>";		
		echo "</td>";			
		
		if ($reg_lis_x[2]=="-"){ //usuario
			$valor = "X";
		}else{
			$valor = $reg_lis_x[2];			
		}
		
		$n_texto = trim($reg_lis_x[11]);
		$name_texto = "f_".trim($reg_lis_x[11]); 
		
		echo "<td  class='caja_texto_ama'>";
		echo "<input name='$n_texto' type='text' class='caja_sb' id='$n_texto' size='20' value='$valor'>";
		echo "</td>";
		
			
		echo "<td  class='caja_texto_pe'>"; //aplicativo
		echo "<input name='apli_mov' type='text' class='caja_sb' id='apli_mov' size='40' value='$reg_lis_x[3]' readonly>";?>
		
        <!--
		<img src="image/vis.jpg" width="15" height="15" 
		onclick="javascript:mostrar_mov_usuarios('<?php echo $reg_lis_x[0] ?>','<?php echo $reg_lis_x[1] ?>','<?php echo $reg_usu[3]?>','<?php echo $reg_lis_x[2] ?>','<?php echo $reg_lis_x[3]; ?>')" />		
		-->
       
        <img src="image/lapiz1.jpg" width="15" height="15" 
		onclick="javascript:grabar_movimientos_usuarios_nuevo('<? echo $reg_lis_x[0]; ?>','<? echo trim($reg_lis_x[11]); ?>',
        '<? echo $reg_lis_x[6]; ?>','<? echo $reg_lis_x[1]; ?>','<?php echo $reg_usu[3]; ?>','<?php echo $reg_lis_x[3]; ?>',
        '<?php echo $n_texto; ?>','<?php echo $reg_lis_x[7]; ?>');" title="Grabar">
        		
		<?php 
		
		echo "</td>";	
		
		
		echo "<td class='caja_texto_pe'>";
		echo "<input type='text' class='caja_sb'  size='30' value='$reg_lis_x[5]' readonly>";					
		echo "</td>";	
		
		
		echo "<td class='caja_texto_ama'>";
		echo "<input name='$name_texto' type='text' class='caja_sb' id='$name_texto' size='20' value='$reg_lis_x[6]'>";					
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo "<input name='f_fin_mov' type='text' class='caja_sb' id='f_fin_mov' size='20' value='$reg_lis_x[7]' readonly>";						
		echo "</td>";	

		echo "</tr>";				
		}	
	echo "</table>";	
}	

 
?>
