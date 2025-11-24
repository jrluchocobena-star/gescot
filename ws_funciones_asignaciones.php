<?php
include_once("conexion_w101.php");

$connection_w101	= db_conn_w101();

$accion=$_GET["accion"];
$iduser=$_GET["iduser"];
$accion=$_GET["accion"];

if ($accion=="c_zonal"){
	
	$combo=$_GET["combo"];
	$valor=$_GET["valor"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="c_xzonal" id="c_xzonal" class="caja_texto_pe" onchange="javascript:mostrar_combo(this.value,'c_eecc')" >
          <?php		
			print "<option value='0' selected>Seleccione</option>";
			$sql="select zonal from ws_zonificacion_cot where region='$valor' group by 1";
			echo $sql;
		  	$queryresult = mysql_query($sql,$connection_w101) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";
			}
			?>
</select>
<?php
	echo "</td></tr></table>";	
}

if ($accion=="c_eecc"){
	
	$combo=$_GET["combo"];
	$valor=$_GET["valor"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="c_xeecc" id="c_xeecc" class="caja_texto_pe" onchange="javascript:mostrar_combo(this.value,'c_jefatura')" >
          <?php 			
			print "<option value='0' selected>Seleccione</option>";
			$sql="select eecc from ws_zonificacion_cot where zonal='$valor' group by 1";
			echo $sql;
		  	$queryresult = mysql_query($sql,$connection_w101) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";
			}
			?>
    </select>
<?php
	echo "</td></tr></table>";	
}

if ($accion=="c_jefatura"){
	
	$combo=$_GET["combo"];
	$valor=$_GET["valor"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="c_xjefatura" id="c_xjefatura" class="caja_texto_pe" >
          <?php 			
			print "<option value='0' selected>Seleccione</option>";
			$sql="select jefatura from ws_zonificacion_cot where eecc='$valor' group by 1";
			echo $sql;
		  	$queryresult = mysql_query($sql,$connection_w101) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";
			}
			?>
    </select>
<?php
	echo "</td></tr></table>";	
}

function limpia_cadenas($cadena) {
//	echo "entro";
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ");

$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N");

$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}


if ($accion=="grabar_registro_tecnico"){
	$iduser		= $_GET["iduser"];
	$celular	= "+519".trim($_GET["celular"]);

	
	if ($c_actividad=="ACTUALIZACION"){
		$sql_2 ="insert into ws_movimiento_usuarios
		SELECT '',correlativo,NroCel,actividad,NOW(),SolicitadoPor,''
		FROM ws_gestion_usuarios where celular='$celular'";	
		//echo $sql;
		$resp_2 = mysql_query($sql_2,$connection_w101) or die (mysql_error($sql_2));
	}
	
	if ($c_actividad=="REGISTRO"){
	
	$celular	= "+51".trim($_GET["celular"]);
	$ape_pat	= limpia_cadenas($_GET["ape_pat"]);	
	$ape_mat	= limpia_cadenas($_GET["ape_mat"]);
	$nombre		= limpia_cadenas($_GET["nombre"]);	
	$dni		= $_GET["dni"];
	$carnet		= $_GET["carnet"];	
	$c_region	= $_GET["c_region"];
	$c_zonal	= $_GET["c_zonal"];	
	$c_zona		= $_GET["c_eecc"];	
	$c_eecc		= $_GET["c_eecc"];
	$c_jefatura	= $_GET["c_jefatura"];	
	$c_gestion	= $_GET["c_gestion"];
	$c_actividad= $_GET["c_actividad"];
	$c_estado	= $_GET["c_estado"];	
	$solicitado	= $_GET["solicitado"];	
	/*
	$c_obs		= $_GET["c_obs"];
	$c_tratec	= $_GET["c_tratec"];	
	$c_tracon	= $_GET["c_tracon"];
	$c_pcg		= $_GET["c_pcg"];	
	$c_toa		= $_GET["c_toa"];
	*/
	$obs_solicitud	= $_GET["detalle"];
	$obs_aprobacion	= $_GET["obs_aprobacion"];
	$obs_ejecucion	= $_GET["obs_ejecucion"];
	$nombre		= $nombre." ".$ape_pat." ".$ape_mat;
	
	$check_1=$_GET['check_1'];
	$check_2=$_GET['check_2'];
	$check_3=$_GET['check_3'];
	$check_4=$_GET['check_4'];
	$check_5=$_GET['check_5'];
	$check_6=$_GET['check_6'];
	$check_7=$_GET['check_7'];
	$check_8=$_GET['check_8'];
	$check_9=$_GET['check_9'];
	$check_10=$_GET['check_10'];
	$check_11=$_GET['check_11'];
	$check_12=$_GET['check_12'];
	$check_13=$_GET['check_13'];
	$check_14=$_GET['check_14'];
	$check_15=$_GET['check_15'];
	$check_16=$_GET['check_16'];
	$check_17=$_GET['check_17'];
	$check_18=$_GET['check_18'];
	$check_19=$_GET['check_19'];
	$check_20=$_GET['check_20'];
	$check_21=$_GET['check_21'];
	
	
	$dia=date("Y-m-d");
	
	$cad="SELECT MAX(idDSL) FROM ws_movimiento_usuarios";
	$rs = mysql_query($cad,$connection_w101);
	$rg = mysql_fetch_array($rs);
	$idsl = $rg[0]+1;
	$idfranqueo="RUS".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);

	/*
	$sql_1 ="INSERT INTO ws_usuarios VALUES (NULL,'$celular','$nombre','$carnet','$dni',
	'$c_region','$c_zonal','$c_zona','$c_eecc','$c_jefatura','$c_gestion','','$c_actividad','$c_estado',
	'$check_1','$check_2','$check_3','$check_4','$check_5','$check_6','$check_7','$check_8','$check_9','$check_10','$check_11',
	'$check_12','$check_13','$check_14','$check_15','$check_16','$check_17','$check_18','$check_19','$check_20',
	NOW(),NOW(),'$obs_solicitud','$iduser','$check_21','','','','','','','','$idfranqueo') 
	ON DUPLICATE KEY UPDATE Nombre='$nombre',Carnet='$carnet',DNI='$dni',Region='$c_region',
	Zonal='$c_zonal',Zona='$c_zona',EECC='$c_eecc',Jefatura='$c_jefatura',AreaGestion='$c_gestion',Responsable='',actividad='$c_actividad',
	Estado='$c_estado',pConsulta='$check_1',pReset='$check_2',pReconfig='$check_3',pCambioParADSL='$check_4',pCambioVoz='$check_5',pRecomenLinea='$check_6',
	pConsultaPedido='$check_7',pReporte='$check_8',pReasignacion='$check_9',pRegistrarCaja='$check_10',flagConformidad='$check_11',pReasigMDF='$check_12',
	pObservadas='$check_13',pReporteNODEID='$check_14',pConsultaCajas='$check_15',pTratTecnico='$check_16',pTratConsultTelf='$check_17',pCierreAten='$check_18',
	pGamming='$check_19',pCGAveria='$check_20',FechaModifi=IF(FechaModifi<>'0000-00-00 00:00:00',NOW(),FechaModifi),obs_solicitud='$obs_solicitud',SolicitadoPor='$iduser',
	FechaCreacion=IF(FechaCreacion='0000-00-00 00:00:00',NOW(),FechaCreacion),TOA='$check_21',AtendidoPor='',AprobadoPor='',obs_aprobacion='$obs_aprobacion',
	Fec_aprobacion='0000-00-00 00:00:00', EjecutadorPor='',Fec_ejecucion='0000-00-00 00:00:00',obs_ejecucion='$obs_ejecucion',correlativo='$idfranqueo'";	
	//echo $sql_1;
	$resp_1 = mysql_query($sql_1) or die (mysql_error($sql_1));
	*/
	
	$sql_1 ="INSERT INTO ws_usuarios VALUES (NULL,'$celular','$nombre','$carnet','$dni',
	'$c_region','$c_zonal','$c_zona','$c_eecc','$c_jefatura','$c_gestion','','','$c_estado',
	'$check_1','$check_2','$check_3','$check_4','$check_5','$check_6','$check_7','$check_8','$check_9','$check_10','$check_11',
	'$check_12','$check_13','$check_14','$check_15','$check_16','$check_17','$check_18','$check_19','$check_20',
	NOW(),NOW(),'$obs_solicitud','$solicitado','$check_21','$iduser') 
	ON DUPLICATE KEY UPDATE Nombre='$nombre',Carnet='$carnet',DNI='$dni',Region='$c_region',
	Zonal='$c_zonal',Zona='$c_zona',EECC='$c_eecc',Jefatura='$c_jefatura',AreaGestion='$c_gestion',Responsable='',celular='',
	Estado='$c_estado',pConsulta='$check_1',pReset='$check_2',pReconfig='$check_3',pCambioParADSL='$check_4',pCambioVoz='$check_5',pRecomenLinea='$check_6',
	pConsultaPedido='$check_7',pReporte='$check_8',pReasignacion='$check_9',pRegistrarCaja='$check_10',flagConformidad='$check_11',pReasigMDF='$check_12',
	pObservadas='$check_13',pReporteNODEID='$check_14',pConsultaCajas='$check_15',pTratTecnico='$check_16',pTratConsultTelf='$check_17',pCierreAten='$check_18',
	pGamming='$check_19',pCGAveria='$check_20',FechaModifi=IF(FechaModifi<>'0000-00-00 00:00:00',NOW(),FechaModifi),SolicitadoPor='$solicitado',
	FechaCreacion=IF(FechaCreacion='0000-00-00 00:00:00',NOW(),FechaCreacion),TOA='$check_21',AtendidoPor='$iduser'";	
	echo "<br>".$sql_1;
	$resp_1 = mysql_query($sql_1,$connection_w101) or die (mysql_error($sql_1));
	
	$sql_2 ="INSERT INTO ws_movimiento_usuarios VALUES ('$idsl','$celular','$nombre','$carnet','$dni',
	'$c_region','$c_zonal','$c_zona','$c_eecc','$c_jefatura','$c_gestion','','$c_actividad','$c_estado',
	'$check_1','$check_2','$check_3','$check_4','$check_5','$check_6','$check_7','$check_8','$check_9','$check_10','$check_11',
	'$check_12','$check_13','$check_14','$check_15','$check_16','$check_17','$check_18','$check_19','$check_20',
	NOW(),NOW(),'$obs_solicitud','$solicitado','$check_21','$iduser','POR MODULO','','','','')";	
	echo "<br>".$sql_2;
	$resp_2 = mysql_query($sql_2,$connection_w101) or die (mysql_error($sql_2));		
	
	}
	

}

if ($accion=="validar_registro_tecnico"){
	$celular	= "+51".trim($_GET["celular"]);
	$dni		= $_GET["dni"];
	
	
	$sql_1 		= "select NroCel from ws_gestion_usuarios where NroCel='$celular'";	
	//echo "<br>".$sql_1;
	$resp_1 	= mysql_query($sql_1,$connection_w101) or die (mysql_error($sql_1));
	$reg_1		= mysql_fetch_row($resp_1);
	
	$sql_2 		= "select DNI from ws_gestion_usuarios where DNI='$dni'";	
	//echo "<br>".$sql_2;
	$resp_2 	= mysql_query($sql_2,$connection_w101) or die (mysql_error($sql_2));
	$reg_2		= mysql_fetch_row($resp_2);
		
	//echo $reg[0];	
	if ($reg_1[0]=="" and $reg_2[0]==""){
		$est="4";
		$mensaje= "NUMERO DE CELULAR SE ENCUENTRA LIBRE Y DNI NO SE ENCUENTRA REGISTRADO";
	}else{
		
		if ($reg_1[0]==""){
			$est="3";
			$mensaje= $mensaje."NUMERO DE CELULAR ENCUENTRA LIBRE";
		}else{
			if ($reg_2[0]==""){
				$est="2";
				$mensaje= $mensaje. "NUMERO DE CELULAR SE ENCUENTRA REGISTRADO Y DNI NO SE ENCUENTRA REGISTRADO";
			}else{
				$est="1";
				$mensaje= $mensaje. "NUMERO DE CELULAR SE ENCUENTRA REGISTRADO Y DNI SE ENCUENTRA REGISTRADO";
			}
		}
		
	}
	
	echo $est."|".$mensaje;
}

if ($accion=="validar_celular"){
	
	$celular	= "+51".trim($_GET["celular"]);
	$dni		= $_GET["xdni"];
	$carnet		= $_GET["xcarnet"];
	
	if ($_GET["celular"]<>"" and $dni=="" and $carnet=="" and $nombres=="" ){
	$sql_1 		= "select * from ws_usuarios where NroCel='$celular'";	
	}
	
	if ($dni<>"" and $celular=="" and $carnet=="" and $nombres=="" ){
	$sql_1 		= "select * from ws_usuarios where dni='$dni'";	
	}
	
	if ($carnet<>"" and $dni=="" and $celular=="" and $nombres=="" ){
	$sql_1 		= "select * from ws_usuarios where Carnet='$carnet'";	
	}
	
	
	//echo $sql_1;
	
	$resp_1 	= mysql_query($sql_1,$connection_w101);
	$reg_1		= mysql_fetch_row($resp_1);
	$nreg		= mysql_num_rows($resp_1);
	
	echo $nreg;
	/*	
	if ($nreg==0){  // SI SE ENCUENTRA LIBRE			
		echo "LIBRE";
	}else{	
		echo "OCUPADO";
	}
	*/
}

if ($accion=="mostrar_info"){
	$celular	= "+51".trim($_GET["celular"]);
	$dni		= $_GET["xdni"];
	$carnet		= $_GET["xcarnet"];
	
	if ($_GET["celular"]<>"" and $_GET["xdni"]=="" and $_GET["xcarnet"]=="" and $_GET["xnombres"]=="" ){ // celular
		$opc="1";
	}
	
	if ($_GET["celular"]=="" and $_GET["xdni"]<>"" and $_GET["xcarnet"]=="" and $_GET["xnombres"]=="" ){ // dni
		$opc="2";
	}


	if ($_GET["celular"]=="" and $_GET["xdni"]=="" and $_GET["xcarnet"]<>"" and $_GET["xnombres"]=="" ){ // carnet
		$opc="3";
	}

	
	
//	echo $_GET["celular"]."|".$_GET["xdni"]."|".$_GET["xcarnet"]."|".$_GET["xnombres"]."|".$opc;

	if ($opc=="1"){
		$sql_1 		= "select * from ws_usuarios where NroCel='$celular'";	
		$msn="EL NUMERO DE CELULAR ".$celular." SE ENCUENTRA REGISTRADO";
	}
	
	if ($opc=="2"){
		$sql_1 		= "select * from ws_usuarios where dni='$dni'";	
		$msn="EL NUMERO DE DNI ".$dni." SE ENCUENTRA REGISTRADO";
	}
	
	if ($opc=="3"){
		$sql_1 		= "select * from ws_usuarios where Carnet='$carnet'";	
		$msn="EL NUMERO DE CARNET ".$carnet." SE ENCUENTRA REGISTRADO";
	}
	

	
	
	//echo $sql_1;	
	
	$resp_1 	= mysql_query($sql_1,$connection_w101) or die (mysql_error());
	$reg_1		= mysql_fetch_row($resp_1);
	

				
		$tecnico = explode(" ", $reg_1[2]);
		//echo $tecnico[2];
			
		$nombres = trim($tecnico[0]); // porción1
		$pat = trim($tecnico[1]); // porción2
		$mat = trim($tecnico[2]);
	
		echo "
		<table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>			
		<tr>
        <td colspan='5'>&nbsp;</td>       
		</tr>	
		<tr>
        <td valign='top' class='aviso_peke' colspan='4' align='center' >$msn</td>       
		</tr>				
		<tr>
		<td colspan='10' valign='top'>&nbsp;</td>
		</tr> 
		<tr>
        <td colspan='5' class='boton_3'>INFORMACION GENERAL DEL TECNICO</td>       
		</tr>	
		<tr>
		<tr>
        <td width='10%' valign='top' class='caja_texto_pe'>NRO.CELULAR</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb_rojo' id='' value='$reg_1[1]' readonly/></td>		
        <td width='10%' valign='top' class='caja_texto_pe' colspan='2'></td>        
		</tr>	
        <td width='10%' valign='top' class='caja_texto_pe'>DNI</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[4]' readonly/></td>		
        <td width='10%' valign='top' class='caja_texto_pe'>CARNET</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[3]' readonly /></td>
		</tr>		
        <tr>
        <td valign='top' class='caja_texto_pe'>PATERNO</td>
        <td  valign='top' class='caja_texto_pe'><input name='a_ape_pat' type='text' class='caja_sb'  id='a_ape_pat' value='$pat' readonly /></td>		
        <td valign='top' class='caja_texto_pe'>MATERNO</td>
        <td valign='top' class='caja_texto_pe'><input name='a_ape_mat' type='text' id='a_ape_mat'  class='caja_sb' value='$mat' readonly /></td>
		</tr>
		<tr>
        <td  valign='top' class='caja_texto_pe'>NOMBRES</td>
        <td class='caja_texto_pe'><input name='nombre2' type='text' class='caja_sb' id='nombre2' value='$nombres' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>AREA GESTION </td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[10]' readonly /></td>
        </tr>   
		<tr>
        <td valign='top' class='caja_texto_pe'>REGION</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[5]' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>ZONAL</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[6]' readonly /></td>
        </tr>   
		<tr>
        <td valign='top' class='caja_texto_pe'>ZONA</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[7]' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>EECC</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_1[8]' readonly /></td>
        </tr>     
		<tr>
        <td valign='top' class='caja_texto_pe'>ESTADO</td>";
		if ($reg_1[13]=="A"){
			$est="ACTIVO";
		}else{
			$est="DESACTIVADO";
		}
		echo "		
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$est' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>FEC.REGISTRO</td>
        <td valign='top' class='caja_texto_pe'>
		<input name='' type='text' class='caja_sb' id='' value='$reg_1[35]' readonly /></td>
        </tr>     
     	<tr>
			<td colspan='4'>
			<p>
			<table width='50%' border='0'>			
			<tr>
            <td class='boton_3'>OPCIONES DEL MENU USSD-101</td>
            <td  class='boton_3' align='center'>TODOS<br>"; ?>		
			<input type='checkbox' name='checkbox_ct' id='checkbox_ct' onclick="javascript:marcaAllCheckBox('2')";/> 
			<?php
		echo "</td>
          	</tr>";
		  					
			$array = array('','','','','','','','','','','','','','','P_Consulta','P_Reset','P_Reconfig','P_CambioParADSL','P_CambioVoz','P_RecomenLinea','P_ConsultaPedido','P_Reporte',
				'P_Reasignacion','P_RegistrarCaja','P_FlagConformidad','P_ReasigMDF','P_Observadas','P_ReporteNODEID','P_ConsultaCajas','P_TratTecnico','P_TratConsultTelf',
				'P_CierreAten','P_Gamming','P_CGAveria');			
					
				for ($i = 14; $i < 33; $i++) { 				
					if ($reg_1[$i]=='S'){
						$chk='checked=checked';
					}else{
						$chk='';
					}
				
				$name='c_check_'.$i;
				
					
				echo "<tr>	
				<td caja_texto_pe>$array[$i]</td>					
				<td align='center'><input type='checkbox' name='$name' id='$name' $chk /></td>
				</tr>";
				}
				
			echo "<tr>
				<td >TOA</td>";
					if ($reg_1[38]=="S"){
						echo "<td align='center'><input type='checkbox' checked=checked /></td>";
					}else{
						echo "<td align='center'><input type='checkbox'></td>";
					}				
				echo "</tr>";	
							
			echo "</table>
			</td>
		</tr>
		    
       </table>";
	   
	   
	   
	
}


if ($accion=="cargamasivausuarios"){	
	
	//include("http://10.226.44.221/asignaciones/ActualizarListaBlancaUSSD.php");
	
	$page = file_get_contents('http://10.226.44.221/asignaciones/ActualizarListaBlancaUSSD.php'); 


	$ruta 		="http://10.226.44.221/asignaciones/";
	$archivo	="ActualizarListaBlancaUSSD.php";
	
	$sql_1 		= "insert into log_gestion_usuarios values('','$ruta','$archivo','lcobenat',now(),'EJECUTADO OK')";	
	//echo "<br>".$sql_1;
	$resp_1 	= mysql_query($sql_1,$connection_w101) or die (mysql_error($sql_1));
	
	echo "Proceso Terminado";
}

if ($accion=="eliminar_tecnico"){	
	$celular	= "+519".trim($_GET["celular"]);
	$iduser		= $_GET['iduser'];
	
	$sql_0 		= "select dni,carnet from ws_usuarios where NroCel='$celular' and estado='A' limit 1";	
	$resp_0 	= mysql_query($sql_0,$connection_w101) or die (mysql_error($sql_0));
	$reg_0 		= mysql_fetch_array($resp_0);
	
	$sql_1 		= "update ws_usuarios set estado='D',FechaModifi=now(), AtendidoPor='$iduser' where NroCel='$celular' or dni='$reg_0[0]'";	
	//echo "<br>".$sql_1;
	$resp_1 	= mysql_query($sql_1,$connection_w101) or die (mysql_error($sql_1));
	
	$dia=date("Y-m-d");
	
	$cad="SELECT max(idDSL) from ws_movimiento_gestion_usuarios";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);
	$correlativo="RUS".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);
	
	$sql_2 ="INSERT INTO ws_movimiento_gestion_usuarios
	SELECT *,'','','','$iduser',NOW(),'BAJA','$correlativo' 
	FROM ws_usuarios WHERE NroCel='$celular'";	
	echo $sql_2;
	$resp_2 = mysql_query($sql_2,$connection_w101) or die (mysql_error($sql_2));
	
	
}

/****************************************************************/

if ($accion=="validar_cdc"){
	
	$usuario	= trim($_GET["usuario"]);
	$dni	= trim($_GET["dni"]);
	$carnet	= trim($_GET["carnet"]);
	
	if ($usuario<>"" and $dni=="" and $carnet==""){
	$sql_cdc1 		= "select * from config_usuarios where usuario='$usuario'";	
	}
	if ($usuario=="" and $dni<>"" and $carnet==""){
	$sql_cdc1 		= "select * from config_usuarios where dni='$dni'";	
	}
	if ($usuario=="" and $dni=="" and $carnet<>""){
	$sql_cdc1 		= "select * from config_usuarios where carnet='$carnet'";	
	}

	//echo $sql_1;
	
	$resp_cdc1 	= mysql_query($sql_cdc1,$connection_w101);
	$reg_cdc1	= mysql_fetch_row($resp_cdc1);
	$nreg_cdc1	= mysql_num_rows($resp_cdc1);
	
	echo $nreg_cdc1;	
}

if ($accion=="mostrar_info_cdc"){
	$usuario	= trim($_GET["usuario"]);
	$dni		= trim($_GET["dni"]);
	$carnet		= trim($_GET["carnet"]);
	
	//(echo $usuario;
	
	if ($usuario<>"" and $dni=="" and $carnet==""){
	$sql_cdc1 		= "select * from config_usuarios where usuario='$usuario'";		
	}else{
		if ($dni<>"" and $carnet==""){
			$sql_cdc1 		= "select * from config_usuarios where dni='$dni'";			
		}else{			
			$sql_cdc1 		= "select * from config_usuarios where carnet like '%".$carnet."%'";				
		}
	}
	//echo "cadena".$sql_cdc1;
	
		
	$resp_cdc1 	= mysql_query($sql_cdc1,$connection_w101) or die (mysql_error($sql_cdc1));
	$reg_cdc1		= mysql_fetch_row($resp_cdc1);
	

				
		$tecnico = explode(" ", $reg_cdc1[2]);
		//echo $tecnico[2];
			
		$nombres = trim($tecnico[0]); // porción1
		$pat = trim($tecnico[1]); // porción2
		$mat = trim($tecnico[2]);
	
		
	
		echo "
		<table width='70%' border='0' cellpadding='0' cellspacing='0'>												
		<tr>
        <td colspan='5' class='caja_texto_AMA'>INFORMACION GENERAL DEL TECNICO</td>       
		</tr>	
		<tr>
		<tr>
        <td width='10%' valign='top' class='caja_texto_pe'>USUARIO</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb_rojo' id='' value='$reg_cdc1[1]' readonly/></td>		
        <td width='10%' valign='top' class='caja_texto_pe' colspan='2'></td>        
		</tr>	
        <td width='10%' valign='top' class='caja_texto_pe'>DNI</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[24]' readonly/></td>		
        <td width='10%' valign='top' class='caja_texto_pe'>CARNET</td>
        <td width='20%' valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[14]' readonly /></td>
		</tr>		
        <tr>
        <td valign='top' class='caja_texto_pe'>PATERNO</td>
        <td  valign='top' class='caja_texto_pe'><input name='a_ape_pat' type='text' class='caja_sb'  id='a_ape_pat' value='$pat' readonly /></td>		
        <td valign='top' class='caja_texto_pe'>MATERNO</td>
        <td valign='top' class='caja_texto_pe'><input name='a_ape_mat' type='text' id='a_ape_mat'  class='caja_sb' value='$mat' readonly /></td>
		</tr>
		<tr>
        <td  valign='top' class='caja_texto_pe'>NOMBRES</td>
        <td class='caja_texto_pe'><input name='nombre2' type='text' class='caja_sb' id='nombre2' value='$nombres' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>SUPERVISION </td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[10]' readonly /></td>
        </tr>   
		<tr>
        <td valign='top' class='caja_texto_pe'>CELULAR</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[25]' readonly /></td>       
         <td valign='top' class='caja_texto_pe'>FEC.CREACION</td>
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[20]' readonly /></td> 
        </tr>   		
		<tr>
        <td valign='top' class='caja_texto_pe'>ESTADO</td>";
		if ($reg_cdc1[5]=="A"){
			$est="ACTIVO";
		}else{
			$est="DESACTIVADO";
		}
		echo "		
        <td valign='top' class='caja_texto_pe'><input name='' type='text' class='caja_sb' id='' value='$est' readonly /></td>       
        <td valign='top' class='caja_texto_pe'>ZONAL</td>";
       
	   	if ($reg_cdc1[29]=="L"){
			echo "<td valign='top' class='caja_texto_pe'>LIMA</td>";
		}else{
			echo "<td valign='top' class='caja_texto_pe'>PROVINCIA</td>";
		} 
        echo "</tr>  
		<tr>
		<td colspan='10' valign='top'>&nbsp;</td>
		</tr> 
		<tr>
        <td  valign='top' class='caja_texto_pe'>CODPAGE</td>
        <td class='caja_texto_pe' colspan='3'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[13]' size='100' readonly /></td>       
        </tr>  
		
		<tr>
		<td colspan='10' valign='top'>&nbsp;</td>
		</tr> 
		<tr>
        <td  valign='top' class='caja_texto_pe'>MOT.TRANFERENCIA</td>
        <td class='caja_texto_pe' colspan='3'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[19]' size='100' readonly /></td>       
        </tr>  
		
		<tr>
		<td colspan='10' valign='top'>&nbsp;</td>
		</tr> 
		<tr>
        <td  valign='top' class='caja_texto_pe'>AMBITO</td>
        <td class='caja_texto_pe' colspan='3'><input name='' type='text' class='caja_sb' id='' value='$reg_cdc1[22]' size='100' readonly /></td>       
        </tr>
		<tr>
		<td colspan='10' valign='top'>&nbsp;</td>
		</tr>   
		        	
       </table>";
	
}


if ($accion=="grabar_registro_tecnico_cdc"){
	$iduser		= $_GET["iduser"];
	
	
	if ($c_actividad=="REGISTRO"){
	
	$usuario	= trim($_GET["usuario"]);
	$ape_pat	= limpia_cadenas($_GET["ape_pat"]);	
	$ape_mat	= limpia_cadenas($_GET["ape_mat"]);
	$nombre		= limpia_cadenas($_GET["nombre"]);	
	$dni		= $_GET["dni"];
	$carnet		= $_GET["carnet"];	
	$c_actividad= $_GET["c_actividad"];
	$c_estado	= $_GET["c_estado"];	
	$usu_modelo	= $_GET["usu_modelo"];	
	
	/*
	$c_obs		= $_GET["c_obs"];
	$c_tratec	= $_GET["c_tratec"];	
	$c_tracon	= $_GET["c_tracon"];
	$c_pcg		= $_GET["c_pcg"];	
	$c_toa		= $_GET["c_toa"];
	
	$obs_solicitud	= $_GET["detalle"];
	$nombre		= $nombre." ".$ape_pat." ".$ape_mat;
	*/
	
	$codpage=$_GET['check_1'].",".$_GET['check_2'].$_GET['check_3'].",".$_GET['check_4'].",".$_GET['check_5'].",".
	$_GET['check_6'].",".$_GET['check_7'].",".$_GET['check_8'].",".$_GET['check_9'];
	
	$dia=date("Y-m-d");
	
	
	$sql_1 ="insert into ws_movimientos_config_usuarios values
	(null,'$usuario','$nombre','','','$c_estado','',md5('$dni'),'','','','','','$codpage','$carnet','','','','','',NOW(),
	'','','','$dni','','','','','')";	
	//echo "<br>".$sql_1;
	$resp_1 = mysql_query($sql_1,$connection_w101) or die (mysql_error($sql_1));
	
	$sql_2 ="	UPDATE ws_movimientos_config_usuarios 
	SET 
	codpage=(SELECT b.codpage FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	codMotivosTratTecnicas=(SELECT b.codMotivosTratTecnicas FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	TraTecZonal=(SELECT b.TraTecZonal FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	LimProv=(SELECT b.LimProv FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	Supervision=(SELECT b.Supervision FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	Perfil=(SELECT b.Perfil FROM config_usuarios b WHERE b.usuario='$usu_modelo'),
	TOA=(SELECT b.TOA FROM config_usuarios b WHERE b.usuario='$usu_modelo')
	WHERE usuario='$usuario'";	
	//echo "<br>".$sql_2;
	$resp_2 = mysql_query($sql_2,$connection_w101) or die (mysql_error($sql_2));
	
	$sql_3 ="insert into config_usuarios values
	(null,'$usuario','$nombre','','','$c_estado','',md5('$dni'),'','','','','','$codpage','$carnet','','','','','',NOW(),
	'','','','$dni','','','','','')";	
	//echo "<br>".$sql_1;
	$resp_3 = mysql_query($sql_3,$connection_w101) or die (mysql_error($sql_3));
	
	
	$sql_4 ="	
	SET @var1=(SELECT b.codpage FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var2=(SELECT b.codMotivosTratTecnicas FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var3=(SELECT b.TraTecZonal FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var4=(SELECT b.LimProv FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var5=(SELECT b.Supervision FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var6=(SELECT b.Perfil FROM config_usuarios b WHERE b.usuario='$usuario_modelo');
	SET @var7=(SELECT b.TOA FROM config_usuarios b WHERE b.usuario='$usuario_modelo');


	UPDATE config_usuarios 
	SET 
	codpage=@var1,
	codMotivosTratTecnicas=@var2,
	TraTecZonal=@var3,
	LimProv=@var4,
	Supervision=@var5,
	Perfil=@var6,
	TOA=@var7
	WHERE usuario='$usuario'";	
	echo "<br>".$sql_4;
	$resp_4 = mysql_query($sql_4,$connection_w101) or die (mysql_error($sql_4));	
	
	
	}
}


?>
