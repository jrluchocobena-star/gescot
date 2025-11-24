
<?php

//echo "<script language='javascript1.2' type='text/javascript' src='funciones_js.js'>

include("conexion_bd.php");
include("funciones_fechas.php");
include(__DIR__."/incidencia/ValidacionAlerta.php");
include(__DIR__."/incidencia/ValidacionTraslape.php");

$accion=$_GET["accion"];
$iduser=$_GET["iduser"];

$c_pc		=	"select pc,monitor from tb_usuarios where iduser='$iduser'";
//echo $c_pc;
$row_c_pc 	= 	mysql_query($c_pc) or die(mysql_error());
$reg_c_pc	=	mysql_fetch_row($row_c_pc);
$pc_asig	=	$reg_c_pc[0];


if ($accion=="valida_acceso"){	
	$login = $_GET["login"];	
	$clave = $_GET["clave"];
	
	$query = "select iduser,max(numingreso),perfil,pc,grupo from tb_usuarios where login='$login' and pass='$clave'
	and estado='HABILITADO' group by 1";
	//echo $query;
	
	$result = 	mysql_query($query) or die(mysql_error());
	
	$row	=	mysql_fetch_row($result);
	$nrow	=	mysql_num_rows($result);

	
	
	//echo "nrow=".$nrow."<br>";
	
	if ($nrow>0){
	
			if (is_null($row[1])){
				$ingresos = 1;
			}
			else{
				$ingresos = $row[1] + 1;
			}					
			
			$id 		= "K32".date('tz')."72".date('zt').$login.$ingresos;	
			$perfil		= $row[2];
			$iduser		= $row[0];			
			$grupo		= $row[4];
			
			/*************************/
			$pc_sis		= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
			//$pc_asig 	= $row[3];
					
			$ss			= 
			"insert into conexiones_web(idsess,proceso,usu_mov,obs,pc_asig,
			pc_sis,fec_ini,fec_fin,tiempo,estado)
			values('$id','SE INGRESO WEB GESCOT',
			'$iduser','','$pc_asig','$pc_sis',now(),'','00:00:00','CONECTADO')";
			//echo "<p>".$ss;
			$res_ss 	= mysql_query($ss);	
					
			/*************************/
			
			$query = "update tb_usuarios
					 set idsess='$id',
					 numingreso = $ingresos,
					 conectado='1',
					 user_pc='$pc_sis'			 
					 where login ='$login' and pass='$clave'";
			//echo "<br>".$query;
					 
			$result1 = mysql_query($query) or die(mysql_error());
			
	}else{	
		$id 	=trim("X");		
		$perfil =trim("X");
		$iduser =trim("X");		
	}

	//echo "<br>".$nrow." | ".$id;	
	//echo $id."|".$perfil."|".$iduser."|".$query;	
	echo $id."|".$perfil."|".$iduser."|".$grupo;
}


if ($accion=="mostrar_datos_contacto"){	
	
	$dni=trim($_GET["dni"]);
	$iduser=trim($_GET["iduser"]);
	$opc=trim($_GET["opc"]);
	$ape_pat=trim($_GET["ape_pat"]);		
	$ape_mat=trim($_GET["ape_mat"]);
	$ncontacto=trim($_GET["ncontacto"]);		
	$cliente =$ape_pat." ".$ape_mat;
	
		
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

	/*
	// guarda consultas de numeros de contactos
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
	$sql_="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc,dato)
	VALUES(LAST_INSERT_ID(),'CONSULTA CONTACTOS','$iduser',now(),'$obs','$pc','$dato')";
	echo $sql_;
	$res_= mysql_query($sql_);
	*/
	
	
	
	if($opc==1){	// apellidos y nombres
	$lista="select * from tb_contactos_prueba where campo7 like '%$ape_pat%' or campo7 like '%$ape_mat%'";
	//$lista="select * from tb_contactos_prueba where concat(campo6,'|',campo7)=concat('$ape_pat','|','$ape_mat')";
	//$lista="select * from tb_contactos_new where concat(campo6,'|',campo7)=concat('$ape_pat','|','$ape_mat') order by campo12 asc";
	$msn="PERSONA NO SE ENCUENTRA REGISTRADA EN LA BASE DE DATOS";
	}
	
	if($opc==2){ // dni	
	$lista="select * from tb_contactos_prueba where campo2='$dni'";
	$msn="DNI EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	}
	
	if($opc==3){	// numero contacto
	$lista="select * from tb_contactos_prueba where campo3='$ncontacto'";
	
	//$lista="select * from tb_contactos_new where campo3 like '%$ncontacto%'";
	$msn="NUMERO EN CONSULTA NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS";
	}
	
	
	//echo $opc."-".$lista;
	
	$res_lis = mysql_query($lista);
	$nreg = mysql_num_rows($res_lis);
	
	if ($nreg==0){
		echo "<table width='100%' >";	
			/*	
			echo "<tr>";					
			echo "<td class='contador' colspan='7'>DATOS DEL CLIENTE</td>";		
			echo "</tr>";
			
			echo "<tr>";					
			echo "<td colspan='7'>&nbsp;</td>";		
			echo "</tr>";
			*/
			echo "<tr>";					
			echo "<td class='txtlabel'>NOMBRE CLIENTE</td>";		
			echo "<td class='txtlabel'>DNI </td>";	
			echo "<td class='txtlabel'>N.CONTACTO </td>";															
			echo "<td class='txtlabel'>OPERADOR</td>";									
			echo "</tr>";
			
			echo "<tr>";					
			echo "<td colspan='8' align='center' class='aviso'>$msn</td>";												
			echo "</tr>";
			
	}else{
	
	echo "<table width='100%' >";	
			/*	
			echo "<tr>";					
			echo "<td class='contador' colspan='7'>DATOS DEL CLIENTE</td>";		
			echo "</tr>";
			
			echo "<tr>";					
			echo "<td colspan='7'>&nbsp;</td>";		
			echo "</tr>";
			*/
			echo "<tr>";					
			echo "<td class='txtlabel'>NOMBRE CLIENTE</td>";		
			echo "<td class='txtlabel'>DNI </td>";	
			echo "<td class='txtlabel'>N.CONTACTO </td>";															
			echo "<td class='txtlabel'>OPERADOR</td>";									
			echo "</tr>";
	
	while($reg_lisT=mysql_fetch_row($res_lis)){		
			
					
		echo "<tr>";			
				
		echo "<td class='clsDataArea'>";
		//echo $reg_lisT[4]." ".$reg_lisT[5]." ".$reg_lisT[6]; 			
		echo $reg_lisT[7];
		echo "</td>";
		
		echo "<td class='clsDataArea'>"; ?>
       
		<!--
        <a href="javascript:editar_contacto('<?php echo $reg_lisT[0] ?>','<?php echo $reg_lisT[2] ?>','<?php echo $reg_lisT[3] ?>','<?php echo $reg_lisT[4] ?>',
        '<?php echo $reg_lisT[6] ?>','<?php echo $reg_lisT[8] ?>','<?php echo $reg_lisT[10] ?>','<?php echo $reg_lisT[5] ?>','<?php echo $reg_lisT[7]?>',
        '<?php echo $reg_lisT[9]?>','<?php echo $reg_lisT[11]?>');">
       
         -->
        <a href="javascript:popup_reclamo('2','<?php echo $reg_lisT[0] ?>','<?php echo $reg_lisT[2] ?>','<?php echo $iduser; ?>','','');">
        
		<?php echo "$reg_lisT[2]</a></td>";	
		
				
		echo "<td class='clsDataArea'>";
		echo $reg_lisT[3]; 			
		echo "</td>";	
		
		echo "<td class='clsDataArea'>";
		echo $reg_lisT[8]; 			
		echo "</td>";	
		
		/*	
		$oper_1="select * from tb_operadores_moviles where id='$reg_lisT[5]'";
		//echo $oper_1;		
		$res_lis1 = mysql_query($oper_1);
		$reg_lis1 = mysql_fetch_array($res_lis1);
		
		$oper_2="select * from tb_operadores_moviles where id='$reg_lisT[7]'";		
		//echo $oper_2;	
		$res_lis2 = mysql_query($oper_2);
		$reg_lis2 = mysql_fetch_array($res_lis2);
		
		$oper_3="select * from tb_operadores_moviles where id='$reg_lisT[9]'";		
		$res_lis3 = mysql_query($oper_3);
		$reg_lis3 = mysql_fetch_array($res_lis3);
		
		$oper_4="select * from tb_operadores_moviles where id='$reg_lisT[11]'";		
		$res_lis4 = mysql_query($oper_4);
		$reg_lis4 = mysql_fetch_array($res_lis4);
		
		
		echo "<td class='clsDataArea'>";
		if($reg_lisT[4]==""){
			echo "N/A"; 								
		}else{
		echo $reg_lisT[4]."-".$reg_lis1["operador"]; 	
		}
		echo "</td>";	
		
		echo "<td class='clsDataArea'>";
		if($reg_lisT[6]==""){
			echo "N/A"; 								
		}else{
		echo $reg_lisT[6]."-".$reg_lis2["operador"]; 
		}
		echo "</td>";	
		
		echo "<td class='clsDataArea'>";
		if($reg_lisT[8]==""){
			echo "N/A"; 								
		}else{
		echo $reg_lisT[8]."-".$reg_lis3["operador"]; 
		}
		echo "</td>";	

		echo "<td class='clsDataArea'>";
		if($reg_lisT[10]==""){
			echo "N/A"; 								
		}else{
			echo $reg_lisT[10]."-".$reg_lis4["operador"]; 				
		}
		echo "</td>";	
		
		*/
		echo "</tr>";				
		}	
	echo "</table>";	
	}
		
}

/*************************************************************************************************************************************************************/


if ($accion=="asignar_pedido"){

/*
$sql_2="SELECT PETICION,PEDIDO,INSCRIPCION,DIRECCION,FECHA_REG,origen,estado
FROM carga_pedidos_total
WHERE estado IN(0,4,5) 
ORDER BY  RAND(), estado DESC, peticion DESC, FECHA_REG ASC LIMIT 1";
//echo "<br>".$sql_2;

$sql_2="SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.origen,a.estado
FROM carga_pedidos_total a LEFT JOIN cab_asignaciones_cot b 
ON a.PEDIDO = b.pedido
WHERE b.pedido IS NULL and a.estado in(0,4,5) 
ORDER BY  RAND(), a.estado desc, a.peticion desc, a.FECHA_REG ASC LIMIT 1";


*/

$sql_2="SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.origen,a.estado
FROM carga_pedidos_total a LEFT JOIN cab_asignaciones_cot b 
ON a.PEDIDO = b.pedido
WHERE a.estado in(0,4,5) 
ORDER BY  RAND(), a.estado asc, a.peticion desc, a.FECHA_REG ASC LIMIT 1";

$res_lis_2 = mysql_query($sql_2);
//$reg=mysql_fetch_row($res_lis_2);

echo "<table width='90%' border='0' cellpadding='0' cellspacing='0' class='marco_tabla_bandeja'>";
echo "<tr>";
echo "<td colspan='6' class='caja_sb'>Sr(a). <?php echo $usu[1]; ?> se le asignado el Pedido Nro. <?php echo $reg[1]; ?>. Ud. es el encargado de darle tratamiento y poder dar una gestion optima y personalizada del pedido asignado.  Dar click en el numero de pedido para hacer la gestión respectiva.
    <p> 
	NOTA IMPORTANTE: SE EXCLUYEN LOS PEDIDOS QUE SON DE EMPRESAS</td>
  </tr>  
  <tr>";
  /*
  echo "
    <td class='cabec_1'>PETICIO</td>
    <td class='cabec_1'>PEDIDO</td>	
	<td class='cabec_1'>INSCRIPCION/COD.CLIENTE</td>
    <td class='cabec_1'>DIRECCION</td>    
    <td class='cabec_1'>FEC. REGISTRO</td>   
    <td class='cabec_1'>ORIGEN</td>   
    <td class='cabec_1' >PANEL</td>   
  </tr>";
  */
  echo "
    <td class='cabec_1'>CIUDAD</td>
    <td class='cabec_1'>PEDIDO</td>	
	<td class='cabec_1'>INSCRIPCION</td>	
	<td class='cabec_1'>PETICION</td>		
	<td class='cabec_1'>CLIENTE</td>		
	<td class='cabec_1'>CUENTA</td>		
    <td class='cabec_1'>NRO.REFERENCIAS</td>    
    <td class='cabec_1'>FEC. REGISTRO</td>   
    <td class='cabec_1'>ORIGEN</td>   
	<td class='cabec_1'>ESTADO</td>   
	<td class='cabec_1'>OBS</td>   
    <td class='cabec_1' >PANEL</td>   
  </tr>";
  
	?>
	<?php	
  while($reg_lis=mysql_fetch_row($res_lis_2)){		 			
					
		echo "<tr>";		
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[0]; 				
		echo "</td>";
							
		echo "<td class='aviso' valign='top' id='celda_asignar_on'>";
		?>
		<img src="image/visto1.jpg" alt="" width="25" height="25" 
        onclick="javascript:popup_reclamo('1','<?php echo $reg_lis[0]?>','<?php echo $reg_lis[4]?>','<?php echo $iduser;?>','<?php echo $reg_lis[5]?>')" border="1" />	
        <?php
		echo $reg_lis[1];		
        echo "</td>";		
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[0]; 				
		echo "</td>";	
		/*
		echo "<td class='clsDataArea'>";
		echo $reg_lis[2]; 				
		echo "</td>";
		*/
		echo "<td class='clsDataArea'>";
		echo $reg_lis[3]; 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		$cc="SELECT * FROM tb_estados_asignacion WHERE cod_estado='$reg_lis[6]'";
//		echo $cc;
		$res_cc = mysql_query($cc);
		$reg_cc=mysql_fetch_row($res_cc);
	
	
		echo "<td class='clsDataArea'>";
		echo $reg_cc[1]; 				
		echo "</td>";
		
		$cco="SELECT obs_registro FROM cab_asignaciones_cot WHERE pedido='$reg_lis[1]'";
		//echo $cco;
		$res_cco = mysql_query($cco);
		$reg_cco=mysql_fetch_row($res_cco);
		
		echo "<td class='clsDataArea'>";
		echo $reg_cco[0]; 				
		echo "</td>";
		
		echo "<td>";
		echo "<table width=100>";
			echo "<tr>";			
			//echo "<td><img id='bt_cancelar' src='image/anula1.jpg' alt='' width='25' height='25' /></td>";
			echo "<td><img id='bt_aceptar' src='image/visto2.jpg' alt='' 
			width='25' height='25' style='display:none' onclick='JAVASCRIPT:grabar_asignacion($reg_lis[1])' /></td>";
			echo "</tr>";
		echo "</table>";
		echo "</td>";			
		
		echo "</tr>";				
		}		
echo "</table>";

}


if ($accion=="validar_pedido"){	

	$peticion=trim($_GET["peticion"]);	
	/*
	//borrar pedidos que estan en procesos y pasan los 20 min de atencion
	$cc0="DELETE FROM cab_asignaciones_cot WHERE estado_asig='1' 
	AND SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , fec_reg_web, NOW() ))*60)>='00:20:00'";
	$res_cc0 = mysql_query($cc0);
	*/
	$cc="SELECT a.peticion,a.estado,b.estado FROM carga_pedidos_total a, tb_estados_asignacion b 
	WHERE a.estado=b.cod_estado AND a.peticion='$peticion'";
	//echo $cc;
	$res_cc = mysql_query($cc);
	$reg_cc=mysql_fetch_row($res_cc);
	$nro=mysql_num_rows($res_cc);
	
	
//	echo "<br>".$nro;
	//echo "<br>".$reg_cc[1];
	
	if ($reg_cc[1]==0){	
		echo "LIBRE"; // libre
	}else{
		echo "OCUPADO"; // ocupado
		//echo "<br>El pedido ".$pedido." se encuentra en ".$reg_cc[2];
	}
	
	/***************************************************************************/	
	$cc1="SELECT a.requerimiento,a.estado,b.estado 
	FROM cab_gestion_actividades_cot a, tb_estados_asignacion b 
	WHERE a.estado=b.cod_estado AND a.peticion='$peticion'";
	//echo $cc;
	$res_cc1 = mysql_query($cc1);
	$reg_cc1 =mysql_fetch_row($res_cc1);
	$nro1    =mysql_num_rows($res_cc1);
	
	if ($reg_cc1[1]==0){	
		echo "LIBRE"; // libre
	}else{
		echo "OCUPADO"; // ocupado
		//echo "<br>El pedido ".$pedido." se encuentra en ".$reg_cc[2];
	}
		
}

if ($accion=="aceptar_asignacion"){	
	$peticion=trim($_GET["peticion"]);	
	$pedido=trim($_GET["pedido"]);	
	$origen=trim($_GET["origen"]);		
	$fec_reg=trim($_GET["fec_reg"]);
	/*		
	$yy=substr($_GET["fec_reg"],6,2);
	$mm=substr($_GET["fec_reg"],3,2);
	$dd=substr($_GET["fec_reg"],0,2);	
	$hora=substr($_GET["fec_reg"],10,4);
	$fec_reg="20".$yy."-".$mm."-".$dd." ".$hora;*/
	
	$cc		="select max(id) from cab_asignaciones_cot";
	$res_cc = mysql_query($cc);
	$reg_cc	= mysql_fetch_row($res_cc);
	$id 	= $reg_cc[0] + 1;
	
	$sql="INSERT INTO cab_asignaciones_cot
	(id,peticion,usu_reg,fec_reg_web,fec_reg_gestel,fec_cierre_atencion,estado_asig,obs_registro,origen,exclusiones,pedido)
	VALUES($id,'$peticion','$iduser',NOW(),'$fec_reg','','1','','$origen','','$pedido')";
	//echo $sql;
	$res_sql = mysql_query($sql);
	
	
	/*
	$os="select pedido,obs_registro from cab_asignaciones_cot where peticion='$peticion'";
	$res_os = mysql_query($os);
	$reg_os =mysql_fetch_row($res_os);
	*/
	//echo $reg_os[1];

	$os1="update carga_pedidos_total set estado='1' where peticion='$peticion'";
	$res_os1 = mysql_query($os1);
	
	$os2="update cab_gestion_actividades_cot set estado='1' where requerimiento='$peticion' and actividad='ASIGNACIONES'";
	$res_os2 = mysql_query($os2);
}

if ($accion=="rechazar_pedido"){	
	$peticion=trim($_GET["peticion"]);	
	$pedido=trim($_GET["pedido"]);	
	$iduser=trim($_GET["iduser"]);	
	$obs=trim($_GET["obs"]);	
			
	$del_1="update carga_pedidos_total set estado='0' where peticion='$peticion'";
//	echo $del_1;
	$res_1 = mysql_query($del_1);
	
	$del_2="delete from cab_asignaciones_cot where peticion='$peticion'";
	//echo $del_2;
	$res_2 = mysql_query($del_2);
	
	$sql="insert into cab_asignaciones_rechazados(id,peticion,usu_reg,fec_reg_web,obs) values(LAST_INSERT_ID(),'$peticion','$iduser',NOW(),'$obs')";
	$res_3 = mysql_query($sql);

	
}

if ($accion=="grabar_asignacion"){	
	
	//$id=trim($_GET["id"]);	
	//$ccliente=trim($_GET["ccliente"]);
	$iduser=trim($_GET["iduser"]);	
	$peticion=trim($_GET["peticion"]);	
	$obs=trim($_GET["obs"]);	
	$pedido=trim($_GET["pedido"]);	
	$exc=trim($_GET["exc"]);		
	/*
	if ($exc=="NO CONTESTA"){
		$est="4";
	}else{
		if ($exc=="VOLVER A LLAMAR"){
		$est="5";	
		}else{
		$est="3";
		}
	}
	*/
	

	$cc="SELECT id FROM cab_asignaciones_cot WHERE peticion='$peticion' ORDER BY fec_reg_web DESC LIMIT 1";
	$res_cc = mysql_query($cc);
	$reg_cc= mysql_fetch_row($res_cc);
	
	$sql="update cab_asignaciones_cot set obs_registro='$obs',estado_asig='3',fec_cierre_atencion=now(),
	exclusiones='$exc',usu_reg='$iduser'
	WHERE id='$reg_cc[0]'";
	//echo $sql;
	$res_sql = mysql_query($sql);	
	
	$sql_1="update carga_pedidos_total set estado='3' WHERE peticion='$peticion'"; 
	//echo $sql;
	$res_sql1 = mysql_query($sql_1);
		
	$sql_2="update cab_gestion_actividades_cot set estado='3' WHERE peticion='$peticion'"; 
	//echo $sql;
	$res_sql2 = mysql_query($sql_2);	
	
}

if ($accion=="contador_pedidos"){	
	$pedido=trim($_GET["pedido"]);		
		
	$f_actual=date("Y-m-d");
	
	$c1="select count(*) from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$f_actual'";
	$res_c1 = mysql_query($c1);
	$reg_c1= mysql_fetch_row($res_c1);	
		
	$mes=date("m");
	$c2="select count(*) from cab_asignaciones_cot where substr(fec_reg_web,6,2)='$mes'";
	$res_c2 = mysql_query($c2);
	$reg_c2= mysql_fetch_row($res_c2);
	
	echo $reg_c1[0]."|".$reg_c2[0];	
}

if ($accion=="conteo_pedidos_operador"){
	
mysql_query("truncate table conteo_pedidos_user") ; 	

$paso1="INSERT INTO conteo_pedidos_user (SELECT usu_reg,SUBSTR(fec_reg_web,1,10) AS dia,COUNT(*) AS conteo,SUBSTR(fec_reg_web,9,2) AS xdia
FROM cab_asignaciones_cot GROUP BY 1,2 ORDER BY usu_reg)";
//echo $paso1;
$res_paso1 = mysql_query($paso1);


mysql_query("truncate table dinamica_por_usuario") ; 

$paso2="INSERT INTO dinamica_por_usuario
SELECT iduser,concat(ncompleto,' - ',cip),'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0' FROM tb_usuarios where sgrupo like '%asignaciones%'";
//echo $paso2;
$res_paso2 = mysql_query($paso2);


$i=0;
	for ($i = 1; $i<32 ; $i++) {
	$var1="a.d".$i;
	$mes=date("m");
	$dia="2018-".$mes."-".str_pad($i, 2, "0", STR_PAD_LEFT );
	$paso3="UPDATE dinamica_por_usuario a, conteo_pedidos_user b SET ".$var1."=b.conteo WHERE a.iduser=b.usu_reg AND b.dia='$dia'";	
	//echo "<br>".$i.$paso3;	
	$res_paso3 = mysql_query($paso3);
	}   

}

if ($accion=="listar_pedidos"){

$f_actual=date("Y-m-d");
	
$lista="select * from cab_asignaciones_cot where usu_reg='$iduser' and substr(fec_reg_web,1,10)='$f_actual' order by fec_reg_web desc";
//echo $lista;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' >";				
			echo "<tr>";							
			echo "<td colspan='6'>ATENCION: En esta bandeja no debe haber ningun pedido EN PROCESO<p></td>";																												
			echo "</tr>";
			echo "<tr>";							
			echo "<td class='cabec_1'>ITEM </td>";	
			echo "<td class='cabec_1' width='150'>PEDIDO </td>";												
			echo "<td class='cabec_1'>FEC. INICIO</td>";
			echo "<td class='cabec_1'>FEC. FIN</td>";
			echo "<td class='cabec_1'>MOTIVO</td>";					
			echo "<td class='cabec_1'>ESTADO</td>";		
			echo "<td class='cabec_1' width='500'>OBSERVACION</td>";									
			echo "</tr>";
	$i=0;
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_texto_cb'>";
		echo $i=$i+1; 			
		echo "</td>";	
						
		echo "<td  class='caja_texto_cb'>";
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		echo "<td class='caja_texto_cb'>";
		echo $reg_lis[3]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_cb'>";
		echo $reg_lis[5]; 				
		echo "</td>";			
		
		echo "<td class='caja_texto_cb'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		$est="select * from tb_estados_asignacion where cod_estado='$reg_lis[6]' order by fec_reg_web desc limit 1";
		$res_est= mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
		
		echo "<td class='caja_texto_cb'>";
		echo $reg_est[1]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_cb'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";	
}


if ($accion=="asignar_reglas"){
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$criterio = $_GET["criterio"];
	$ncombo = $_GET["ncombo"];
	$user = $_GET["user"];
	$dni = $_GET["dni"];
	$hoy = date("Y-m-d");
	
	if ($ncombo=="criterio_1"){
	$c1="update tb_usuarios set estado='$criterio',fec_fin_cot='$hoy' where dni='$dni'";
	}
	
	if ($ncombo=="criterio_3"){
	$c1="update tb_usuarios set s_area='$criterio',fec_fin_cot='$hoy' where iduser='$user'";
	}
	
	
	//echo $criterio."|".$ncombo."|".$user."|".$dni."|".$c1;
	$res_c1 = mysql_query($c1);	
	
	$sql_3="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'ACTUALIZACION DE ESTADO WEB GESCOT','$user',now(),
		'SE ACTUALIZO EL ESTADO A : $criterio al DNI $dni','$pc_sis','$dni')";
		//echo $sql_3;
	$res_3= mysql_query($sql_3);
	
}

if ($accion=="actualizar_datos_usu"){
	
	$dni = $_GET["dni"];	
	$USUARIO_GESTEL = $_GET["USUARIO_GESTEL"];
	$USUARIO_MULTICONSULTA = $_GET["USUARIO_MULTICONSULTA"];
	$USUARIO_INTRAWAY = $_GET["USUARIO_INTRAWAY"];
	$USUARIO_WEB_UNIFICADA = $_GET["USUARIO_WEB_UNIFICADA"];
	$USUARIO_PSI = $_GET["USUARIO_PSI"];
	$USUARIO_ATIS = $_GET["USUARIO_ATIS"];
	$USUARIO_CMS = $_GET["USUARIO_CMS"];
	$USUARIO_INCIDENCIAS_PSI = $_GET["USUARIO_INCIDENCIAS_PSI"];
	$CLEAR_VIEW = $_GET["CLEAR_VIEW"];
	$PERFIL = $_GET["PERFIL"];
	$REPARTIDOR = $_GET["REPARTIDOR"];
	$WEB_SARA = $_GET["WEB_SARA"];
	$PDM = $_GET["PDM"];
	$WEB_ASEGURAMIENTO = $_GET["WEB_ASEGURAMIENTO"];
	$WEB_ARPU_CALCULADORA = $_GET["WEB_ARPU_CALCULADORA"];
	$USUARIO_GENIO = $_GET["USUARIO_GENIO"];
	$WEB_ASIGNACIONES = $_GET["WEB_ASIGNACIONES"];
	$WEB_SIGTP_MAPA_GIG = $_GET["WEB_SIGTP_MAPA_GIG"];	

	$sql_usu="update usuarios_detalle set USUARIO_GESTEL='$USUARIO_GESTEL', USUARIO_MULTICONSULTA='$USUARIO_MULTICONSULTA',
	USUARIO_INTRAWAY='$USUARIO_INTRAWAY',USUARIO_WEB_UNIFICADA='$USUARIO_WEB_UNIFICADA',USUARIO_PSI='$USUARIO_PSI',USUARIO_ATIS='$USUARIO_ATIS',
	USUARIO_CMS='$USUARIO_CMS',WEB_INCIDENCIAS_PSI='$USUARIO_INCIDENCIAS_PSI',CLEAR_VIEW='$CLEAR_VIEW',PDM='$PDM',
	REPARTIDOR='$REPARTIDOR',WEB_SARA='$WEB_SARA',WEB_ASEGURAMIENTO='$WEB_ASEGURAMIENTO',
	WEB_ARPU_CALCULADORA='$WEB_ARPU_CALCULADORA',USUARIO_GENIO='$USUARIO_GENIO',WEB_ASIGNACIONES='$WEB_ASIGNACIONES',
	WEB_SIGTP_MAPA_GIG='$WEB_SIGTP_MAPA_GIG'
	where DNI='$dni'";
	//echo $sql_usu;
	$res_usu= mysql_query($sql_usu);
	
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
	VALUES(LAST_INSERT_ID(),'ACTUALIZACION DE USUARIO WEB GESCOT','$iduser',now(),'SE ACTUALIZO EL USUARIO CON DNI $dni','$pc','$dni')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	
	$sql_3="update tb_usuarios set perfil=$perfil where dni=$dni";
	$res_3= mysql_query($sql_3);
	
	/*
	$sql_4="INSERT INTO usuario_vert
	(SELECT dni,usuario_multiconsulta,'USUARIO_MULTICONSULTA' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_INTRAWAY,'USUARIO_INTRAWAY' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_WEB_UNIFICADA,'USUARIO_WEB_UNIFICADA' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_PSI,'USUARIO_PSI' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_ATIS,'USUARIO_ATIS' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_CMS,'USUARIO_CMS' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_GESTEL,'USUARIO_GESTEL' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,WEB_SARA,'WEB_SARA' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,WEB_ASEGURAMIENTO,'WEB_ASEGURAMIENTO' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,WEB_ARPU_CALCULADORA,'WEB_ARPU_CALCULADORA' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,USUARIO_GENIO,'USUARIO_GENIO' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,WEB_ASIGNACIONES,'WEB_ASIGNACIONES' FROM usuarios_detalle WHERE dni='$dni')UNION
	(SELECT dni,WEB_SIGTP_MAPA_GIG,'WEB_SIGTP_MAPA_GIG' FROM usuarios_detalle WHERE dni='$dni')";
	 $res_4= mysql_query($sql_4);
	*/
}


if ($accion=="registrar_usuario"){
	$dni_ = $_GET["dni"];	
	$cip_ = $_GET["cip"];
	$iduser = $_GET["iduser"];
	$ape_pat = $_GET["ape_pat"];
	$ape_mat = $_GET["ape_mat"];
	$nombres = $_GET["nombres"];
	$ncompleto = $_GET["ncompleto"];
	$perfil = $_GET["perfil"];	
	$login = $_GET["login"];
	$clave = $_GET["clave"];
	$grupo = $_GET["grupo"];
	$fec_nac = $_GET["fec_nac"];
	$ola = $_GET["ola"];
	$sup = $_GET["sup"];
	
	if (strlen($dni_)==8){
		$dni= $dni_;	
	}else{
		$dni = str_pad($dni_, 8, "0", STR_PAD_LEFT);
	}
	
	if (strlen($cip_)==9){
		$cip =$cip_;
	}else{
		$cip = str_pad($cip_, 9, "0", STR_PAD_LEFT);
	}
	
	
	$sql_0="select * from tb_usuarios where dni='$dni'";
	$res_0= mysql_query($sql_0);
	$nreg_0=mysql_num_rows($res_0);
	
	//echo $nreg;
	
	if ($nreg_0 <1){	
		/*$sql_1="INSERT INTO tb_usuarios(iduser,ncompleto,dni,cip,login,perfil,s_area,estado)
		VALUES(LAST_INSERT_ID(),'$ncompleto','$dni','$cip','$login','$perfil','$area2','HABILITADO')";*/
		$sql_1="INSERT INTO tb_usuarios(iduser,ncompleto,dni,cip,login,pass,perfil,estado,fec_reg,ape_pat,ape_mat,nombres,grupo,fec_nacimiento,ola,c_supervisor)
		VALUES(LAST_INSERT_ID(),'$ncompleto','$dni','$cip','$login','$clave','$perfil','HABILITADO',now(),'$ape_pat',
		'$ape_mat','$nombres','$grupo','$fec_nac','$ola','$sup')";
		//echo $sql_1;
		$res_1= mysql_query($sql_1);
	
		$sql_2="INSERT INTO usuarios_detalle(DNI,CIP,USUARIO_MULTICONSULTA,USUARIO_INTRAWAY,		
		USUARIO_WEB_UNIFICADA,USUARIO_PSI,USUARIO_ATIS,PERFIL_ATIS,USUARIO_CMS,PERFIL_CMS,
		USUARIO_GESTEL,PERFIL_GESTEL,WEB_INCIDENCIAS_PSI,PDM,CLEAR_VIEW,REPARTIDOR,WEB_SARA,WEB_ASEGURAMIENTO,
		WEB_ARPU_CALCULADORA,USUARIO_GENIO,WEB_ASIGNACIONES,WEB_SIGTP_MAPA_GIG,opc,usuario_red,usuario_gescot,usuario_genesys,fec_reg)
		VALUES('$dni','$cip','','','','','','','','','','','','','','','','','','','','','','','','',now())";
		//echo $sql_2;
		$res_2= mysql_query($sql_2);
		
		$sql_3="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'REGISTRO DE USUARIO WEB GESCOT','$iduser',now(),'SE REGISTRO EL USUARIO CON DNI $dni','$pc_sis','$dni')";
		//echo $sql_3;
		$res_3= mysql_query($sql_3);
	
		if ($perfil=="3"){		
		$sql_4="insert into tb_supervisores values(LAST_INSERT_ID(),'$ncompleto','1','')";
		//echo $sql_3;
		$res_4= mysql_query($sql_4);		
		}
	
		if ($perfil=="5"){		
		$sql_5="insert into tb_monitores values(LAST_INSERT_ID(),'$ncompleto','1','','')";
		//echo $sql_3;
		$res_5= mysql_query($sql_5);		
		}
		
		
		$sql_6 = "INSERT INTO movimientos_maestra
		SELECT '','$dni_','-',b.aplicativo,'ACT.USUARIO',NOW(),CURDATE(),'2050-01-01','$iduser','','NO CREADO',CONCAT('t_',b.aplicativo),''
		FROM tb_usuarios a, tb_aplicativos b
		GROUP BY 2,4";
		$res_6= mysql_query($sql_6);
		
		/******************TDATA*********************************/
		/*
		include ("conexion_teradata.php"); 
		$connection_teradata 	= db_conn_teradata();
		
		$cad_tdata="";
	
	
		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}	
		
		/***************************************************/
		
		echo trim("Se registro el gestor $ncompleto satisfactoria con el dni $dni");	
				
		}else{
				
				echo "El trabajador con dni: $dni YA FUE INGRESADO";	
		}
}

if ($accion=="actualizar_datos_usu_horiz"){
	
	
	/*
	$USUARIO_GESTEL = $_GET["USUARIO_GESTEL"];
	$USUARIO_MULTICONSULTA = $_GET["USUARIO_MULTICONSULTA"];
	$USUARIO_INTRAWAY = $_GET["USUARIO_INTRAWAY"];
	$USUARIO_WEB_UNIFICADA = $_GET["USUARIO_WEB_UNIFICADA"];
	$USUARIO_PSI = $_GET["USUARIO_PSI"];
	$USUARIO_ATIS = $_GET["USUARIO_ATIS"];
	$USUARIO_CMS = $_GET["USUARIO_CMS"];
	$USUARIO_INCIDENCIAS_PSI = $_GET["USUARIO_INCIDENCIAS_PSI"];
	$CLEAR_VIEW = $_GET["CLEAR_VIEW"];	
	$REPARTIDOR = $_GET["REPARTIDOR"];
	$WEB_SARA = $_GET["WEB_SARA"];
	$PDM = $_GET["PDM"];
	$WEB_ASEGURAMIENTO = $_GET["WEB_ASEGURAMIENTO"];
	$WEB_ARPU_CALCULADORA = $_GET["WEB_ARPU_CALCULADORA"];
	$WEB_SIGTP_MAPA_GIG = $_GET["WEB_SIGTP_MAPA_GIG"];
	$USUARIO_GENIO = $_GET["USUARIO_GENIO"];
	$usuario_red = $_GET["usuario_red"];	
	*/
	$id_g = $_GET["id_g"];
	$dni = $_GET["dni"];
	$cip = $_GET["cip"];
	$iduser = $_GET["iduser"];	
	$perfil = $_GET["perfil"];
	$motivo_act = "MTTO GESCOT: ".$_GET["motivo_act"];
	$correo_p = $_GET["correo_p"];
	$correo_w = $_GET["correo_w"];	
	$celular1 = $_GET["celular1"];	
	$celular2 = $_GET["celular2"];	
	$anexo = $_GET["anexo"];	
	$local = $_GET["local"];	
	$xestado = $_GET["xestado"];		
	$supervisor = $_GET["supervisor"];	
	$sgrupo = $_GET["sgrupo"];	
	$area = $_GET["area"];	
	$olas = $_GET["olas"];	
	$monitor = $_GET["monitor"];	
	$pc = $_GET["pc"];	
	$pcmonitor = $_GET["pcmonitor"];	
	$c_emergencia = $_GET["c_emergencia"];	
	$fec_nac = $_GET["fec_nac"];
	$motivo_cambio = "SE ACTUALIZO INFORMACION DEL USUARIO CON DNI ".$dni." REALIZADO POR EL IDUSER $iduser";	
	$ncompleto = $_GET["ncompleto"];	
	$ape_pat = utf8_decode($_GET["ape_pat"]);
	$ape_mat = utf8_decode($_GET["ape_mat"]);
	$nombres = utf8_decode($_GET["nombres"]);
	$grupo = $_GET["grupo"];
	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	
	$sql_usu1="update tb_usuarios set 
	correo_personal='$correo_p',correo_w='$correo_w',celular1='$celular1',celular2='$celular2',
	grupo='$grupo',	local='$local',anexo='$anexo',c_supervisor='$supervisor',c_monitor='$monitor',
	perfil='$perfil',pc='$pc',monitor='$pcmonitor',	c_emergencia='$c_emergencia',fec_nacimiento='$fec_nac',
	n_area='$area',estado='$xestado',ncompleto='$ncompleto',ape_pat='$ape_pat',
	ape_mat='$ape_mat',nombres='$nombres',dni='$dni',cip='$cip',ola='$olas',sgrupo='$sgrupo'
	where iduser='$id_g'";
	//echo $sql_usu1;
	$res_usu1= mysql_query($sql_usu1);
	
	/*
	$sql_usu2="update usuarios_detalle set USUARIO_GESTEL='$USUARIO_GESTEL', USUARIO_MULTICONSULTA='$USUARIO_MULTICONSULTA',
	USUARIO_INTRAWAY='$USUARIO_INTRAWAY',USUARIO_WEB_UNIFICADA='$USUARIO_WEB_UNIFICADA',USUARIO_PSI='$USUARIO_PSI',USUARIO_ATIS='$USUARIO_ATIS',
	USUARIO_CMS='$USUARIO_CMS',WEB_INCIDENCIAS_PSI='$USUARIO_INCIDENCIAS_PSI',CLEAR_VIEW='$CLEAR_VIEW',PDM='$PDM',
	REPARTIDOR='$REPARTIDOR',WEB_SARA='$WEB_SARA',WEB_ASEGURAMIENTO='$WEB_ASEGURAMIENTO',
	WEB_ARPU_CALCULADORA='$WEB_ARPU_CALCULADORA',USUARIO_GENIO='$USUARIO_GENIO',WEB_ASIGNACIONES='$WEB_ASIGNACIONES',
	WEB_SIGTP_MAPA_GIG='$WEB_SIGTP_MAPA_GIG',usuario_red='$usuario_red'
	where DNI='$dni'";
	//echo $sql_usu2;
	$res_usu2= mysql_query($sql_usu2);
	*/
	
	
	
	
	$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
	VALUES(LAST_INSERT_ID(),'$motivo_act','$iduser',now(),'$motivo_cambio','$pc_sis','$dni')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	
	$sql_3="update tb_usuarios set perfil=$perfil where dni=$dni";
	$res_3= mysql_query($sql_3);
	
	if ($perfil=="3"){		
		$sql_4="insert into tb_supervisores values('$id_g','$ncompleto','1','')";
		//echo $sql_3;
		$res_4= mysql_query($sql_4);		
			
			
	}
	
	if ($perfil=="5"){		
		$sql_5="insert into tb_monitores values('$id_g','$ncompleto','1','$supervisor','')";
		//echo $sql_3;
		$res_5= mysql_query($sql_5);	
		
		
	}
	
	$d_hoy=date("Y-m-d");
	
	if ($_GET["supervisor"]<>"0"){
		$dato=$_GET["supervisor"];
		$tarea="NUEVO SUPERVISOR";		
	}else{
		if ($_GET["monitor"]<>"0"){
		$dato=$_GET["monitor"];	
		$tarea="NUEVO MONITOR";		
		}	
	}
	
	
	$sql6="insert into movimientos_maestra values('','$dni','$dato','-','$tarea',now(),'$d_hoy','2050-01-01','$iduser','','NO CREADO')";
		//echo "<br>".$sql2;
	$res_sql6 = mysql_query($sql6);
	
}

if ($accion=="carga_combo"){
	
	$combo=$_GET["combo"];
	$valor1=$_GET["valor1"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="combo_mot" id="combo_mot" class="caja_sb" onchange="javascript:carga_combo_modo('modo_gru',this.value)" >
          <?php 			
			print "<option value='0' selected>Seleccione Motivo</option>";
			$sql7="select * from tb_motivos_incidencia where tp_inc='$valor1' and est='1' order by nom_mot_inc";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
        </select>
<?php
	echo "</td></tr></table>";	
}

if ($accion=="carga_combo_modo"){
	
	$combo=$_GET["combo"];
	$valor_combo=$_GET["valor_combo"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="modalidad" id="modalidad" class="caja_sb" onchange="javascript:mostrar_modo_gru(this.value)";>
          <option value="0">Seleccionar</option>
		  <?php
		  	if ($_GET["valor_combo"]=="800"){
				echo "<option value='D'>DIAS</option>" ;
			}else{
				if ($_GET["valor_combo"]=="41"){
					echo "<option value='D'>DIAS</option>" ;
					echo "<option value='H'>HORAS</option>" ;
				}else{
					if ($_GET["valor_combo"]=="801"){
					echo "<option value='D'>DIAS</option>" ;					
					}
					if ($_GET["valor_combo"]=="154") {
						echo "<option value='H'>HORAS</option>" ;
					}else{	
					echo "<option value='D'>DIAS</option>" ;
					echo "<option value='H'>HORAS</option>" ;
			   		}
				}
			}		  
		  ?>
        </select>
<?php
	echo "</td></tr></table>";	
}


if ($accion=="grabar_incidencia"){
	
	
	$iduser=$_GET["iduser"];
	$trabajador=$_GET["trabajador"];
	
	if ($_GET["opc"]=="1"){	
	$trabajador = explode("-", $trabajador);	
	$cip=$trabajador[0]; // porción1
	$dni=$trabajador[1]; // porción1
	}else{
	$trabajador = explode("-", $trabajador);	
	$cip=$trabajador[0]; // porción1
	$dni=$trabajador[1]; // porción1
	}
	$ntrabajador=$trabajador[1]; // porción2	
	$tp_incidencia=$_GET["tp_incidencia"];
	$c_mot_inc=$_GET["c_mot_inc"];
	$nro=$_GET["nro"];
	$modo=$_GET["modo"];
	$c_doid=$_GET["c_doid"];
	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	
	if ($_GET["modo"]=="0"){		
		
		if ($_GET["tiempo"]=="1")	{
			$tiempo_t="8.5";
		}else{
			$tiempo_t	= $tiempo*8.5;
			
		}
				
	}else{
		
		if ($_GET["modo"]=="D"){
			
			if ($_GET["tiempo"]=="1")	{
				$tiempo_t 	="8.5";
			}else{
				$tiempo_t	= $tiempo*8.5;				
			}
		
		}else{
	
		$tiempo_t=$_GET["tiempo"];
			
		}
	}
	
	$tiempo_t	= limpia_espacios($tiempo_t);
	
	//echo $ms."-".$tiempo_t;
	
	$obs=quitar_tildes($_GET["obs"]);

	
	$sql_1="INSERT INTO cab_incidencia
	(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,
	c_doid,dni,nro_participantes)
	VALUES	
	(LAST_INSERT_ID(),'$cip',now(),'$iduser','$tp_incidencia','$c_mot_inc','$fec_ini_','$fec_fin_','$obs','$tiempo_t','$modo',
	'$c_doid','$dni','$nro')";
	//echo "<br>".$sql_1;	
	$res_1= mysql_query($sql_1);	
	
	/**************************************************/
	$dia=date("Y-m-d");
	
	$cad=" SELECT LAST_INSERT_ID() from cab_incidencia";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);
	

	$idfranqueo="INC-".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);
	//echo $idfranqueo; 	
	
	$cad_1="update cab_incidencia set cod_incidencia='$idfranqueo' where id='$rg[0]'";
	$rs_1 = mysql_query($cad_1);
	
	/***************************************************/
	$msn_inc="SE REGISTRO LA INCIDENCIA PARA ".$cip." con codigo incidencia ".$idfranqueo;
	
	$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,dato,pc)
	VALUES(LAST_INSERT_ID(),'REGISTRO INCIDENCIA','$iduser',now(),'$msn_inc','$cip','$pc_asig')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	
	echo "Se registro incidencia ".$idfranqueo;
	
}

if ($accion=="grabar_capacitacion"){
	
	$iduser=$_GET["iduser"];
	/*
	$trabajador_=$_GET["trabajador"];
	$trabajador = explode("-", $trabajador);
	$cip=$trabajador[0]; // porción1
	$dni=$trabajador[1]; // porción1
	*/
	$tp_incidencia=$_GET["tp_incidencia"];
	$c_mot_inc=$_GET["c_mot_inc"];
	$num_part=$_GET["num_part"];
	$modo=$_GET["modo"];
	$c_doid=$_GET["c_doid"];
	$c_inc=trim($_GET["c_inc"]);
	$dni_escogidos = explode("|", $dni_escogidos);
	$nro_escogidos=$_GET["nro_escogidos"];
	$s_tipo=$_GET["s_tipo"];
	$tema=$_GET["tema"];
	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	
	if ($_GET["modo"]=="0"){		
		
		if ($_GET["tiempo"]=="1")	{
			$tiempo_t="08:30";
		}else{
			$tiempo_t	= $tiempo*8.30;
			
		}
				
	}else{
		
		if ($_GET["modo"]=="D"){
			
			if ($_GET["tiempo"]=="1")	{
				$tiempo_t 	="08:30";
			}else{
				$tiempo_t	= $tiempo*8.30;				
			}
		
		}else{
	
		$tiempo_t=$_GET["tiempo"];
			
		}
	}
	
	$tiempo_t	= limpia_espacios($tiempo_t);
	
	//echo $ms."-".$tiempo_t;
	
	$obs=quitar_tildes($_GET["obs"]);

	
	
	$i=0;
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {	
	$paso="INSERT INTO cab_capacitacion	(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,dni,cod_incidencia,nro_participantes,sub_tipo,tema)
	VALUES('','',now(),'$iduser','$tp_incidencia','$c_mot_inc','$fec_ini_','$fec_fin_','$obs',
	'$tiempo_t','$modo','$dni_escogidos[$i]','$c_inc','$nro_escogidos','$s_tipo','$tema')";	
	echo "<br>".$i.$paso;	
	$res_paso = mysql_query($paso);
	
	$paso_1="update cab_capacitacion a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni ";	
	//echo "<br>".$i.$paso_1;	
	$res_paso_1 = mysql_query($paso_1);
	}
	
	/*
	$dia=date("Y-m-d");
	
	$cad=" SELECT LAST_INSERT_ID() from cab_incidencia";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);
	$idfranqueo="INC-".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);
	//echo $idfranqueo; 	
	
	$cad_1="update cab_incidencia set cod_incidencia='$idfranqueo' where id='$rg[0]'";
	$rs_1 = mysql_query($cad_1);
	
	
	*/
	$msn_inc="SE REGISTRO LA CAPACITACION PARA ".$cip." con codigo incidencia ".$idfranqueo;
	
	$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,dato,pc)
	VALUES(LAST_INSERT_ID(),'REGISTRO','$iduser',now(),'$msn_inc','$cip','$pc_asig')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
}


if ($accion=="borrar_incidencia"){
	
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	
	$sql_1="delete from cab_incidencia where id='$id'";
	$res_1= mysql_query($sql_1);
	
	$msn_inc="SE ELIMINO LA INCIDENCIA DEL REGISTRO ".$id;
	
	$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,dato,pc)
	VALUES(LAST_INSERT_ID(),'ELIMINAR ','$iduser',now(),'$msn_inc','$id','$pc_asig')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);	
		
}

if ($accion=="act_incidencia"){
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$iduser=$_GET["iduser"];
	$c_inc=$_GET["c_inc"];
	$cip=$_GET["cip"];
	$fec_ini=$_GET["fec_ini"];
	$fec_fin=$_GET["fec_fin"];
	$tiempo=$_GET["tiempo"];
	$obs=quitar_tildes($_GET["obs"]);
	$ejecutado=$_GET["ejecutado"];
	
	$sql="update cab_incidencia set fec_ini_inc='$fec_ini',fec_fin_inc='$fec_fin',tiempo='$tiempo',
	obs_incidencia='$obs', ejecuto='$ejecutado'
	where cod_incidencia='$c_inc' ";
	//echo $sql;
	$res= mysql_query($sql);	
	
	$msn_inc="SE ACTUALIZO LA INCIDENCIA ".$c_inc." PARA EL CIP: $cip";
	
	$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,pc,dato,pc)
	VALUES(LAST_INSERT_ID(),'ACTUALIZAR','$iduser',now(),'$msn_inc','$pc','$cip','$pc_asig')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);

}


if ($accion=="cambio_contra"){	
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$contra1=$_GET["contra1"];
	$iduser=$_GET["iduser"];

	$sql="update tb_usuarios set pass='$contra1' where iduser='$iduser'";
	$res= mysql_query($sql);
	
	$msn="SE CAMBIO CONTRASENA DEL ID USER ".$iduser;
	$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
	VALUES(LAST_INSERT_ID(),'CAMBIO CONTRASENA WEB GESCOT','$iduser',now(),' $msn','$pc','$iduser')";
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	
}



if ($accion=="reg_nuevo_numero"){
	
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
		
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	$dni=$_GET["dni"];
	$ncontacto=$_GET["ncontacto"];
	$operador=$_GET["operador"];
	
	$sql_1="INSERT INTO tb_contactos_cot
			SELECT '',campo1,campo2,'$ncontacto',campo4,campo5,campo6,campo7,'$operador',
			campo9,NOW(),'$iduser','$pc','AGREGAR NUMERO' 
			FROM tb_contactos_actual 
			WHERE campo2='$dni' limit 1";				
	//echo "<br>".$sql_1;
	$res_1= mysql_query($sql_1);	
	
	$sql_2="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES(LAST_INSERT_ID(),'NUEVO NUMERO DE CONTACTO','$iduser',now(),'SE AGREGO EL NUMERO $ncontacto AL CLIENTE CON DNI $dni','$pc_sis','$pc_asig','$dni')";
	//echo "<br>".$sql_2;
	$res_2= mysql_query($sql_2);
}
	
if ($accion=="reg_nuevo_contacto"){
	
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
		
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	$dni=$_GET["dni"];
	$ape_pat=$_GET["ape_pat"];
	$ape_mat=$_GET["ape_mat"];
	$nombres=$_GET["nombres"];
	$ncontacto=$ape_pat." ".$ape_mat.",".$nombres;
	$operador=$_GET["operador"];
	$num_contacto=$_GET["num_contacto"];
	
	$ss1="(
		SELECT campo2,campo3 FROM tb_contactos_actual WHERE campo2='$dni' AND campo3='$num_contacto' GROUP BY 1
		)UNION(
		SELECT campo2,campo3 FROM tb_contactos_cot WHERE campo2='$dni' AND campo3='$num_contacto' GROUP BY 1
		)UNION(
		SELECT campo2,campo3 FROM tb_contactos_tc WHERE campo2='$dni' AND campo3='$num_contacto' GROUP BY 1
		)";
	//echo $ss1;
	$res_ss1	= mysql_query($ss1);
	//$reg_ss1	= mysql_fetch_row($res_ss1);
	$nreg_ss1 	= mysql_num_rows($res_ss1);
	
	//echo $nreg_ss1;
	
	if ($nreg_ss1 > 0 ){
		echo "DNI SE ENCUENTRA REGISTRADO CON ESE NUMERO TELEFONICO";
	}else{
		$sql_1="insert into tb_contactos_cot(item,campo1,campo2,campo3,campo4,campo5,campo6,campo7,
			campo8,campo9,fec_mov,usu_mov,pc_mov,tipo)
			values(LAST_INSERT_ID(),'DNI','$dni','$num_contacto','$ape_pat','$ape_mat','$nombres','$ncontacto','
			$operador','',now(),'$iduser','$pc','AGREGAR CONTACTO')";				
			//echo "<br>".$sql_1;
			$res_1= mysql_query($sql_1);	
			
			$sql_2="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
			VALUES(LAST_INSERT_ID(),'NUEVO CONTACTO','$iduser',now(),'SE AGREGO EL NUMERO $ncontacto  CON DNI $dni','$pc_sis','$pc_asig','$dni')";
			//echo "<br>".$sql_2;
			$res_2= mysql_query($sql_2);
			
			echo "Se registro Correctamente";
	}
	
	
	/*
	if ($reg_ss1[0]<>""){
		echo "DNI SE ENCUENTRA REGISTRADO CON ESE NUMERO TELEFONICO";		
	}else{
	
		$ss2="select campo3 from tb_contactos_actual where campo3='$num_contacto' group by 1";
		//echo $ss1;
		$res_ss2= mysql_query($ss2);
		$reg_ss2=mysql_fetch_row($res_ss2);
		
		if ($reg_ss2[0]==$num_contacto){
			echo "NUMERO DE CONTACTO YA SE ENCUENTRA REGISTRADO";		
		}else{
			
			$sql_1="insert into tb_contactos_cot(item,campo1,campo2,campo3,campo4,campo5,campo6,campo7,
			campo8,campo9,fec_mov,usu_mov,pc_mov)
			values(LAST_INSERT_ID(),'DNI','$dni','$num_contacto','$ape_pat','$ape_mat','$nombres','$ncontacto','
			$operador','',now(),'$iduser','$pc','AGREGAR CONTACTO')";				
			//echo "<br>".$sql_1;
			$res_1= mysql_query($sql_1);	
			
			$sql_2="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc,dato)
			VALUES(LAST_INSERT_ID(),'NUEVO CONTACTO','$iduser',now(),'SE AGREGO EL NUMERO $ncontacto  CON DNI $dni','$pc','$dni')";
			//echo "<br>".$sql_2;
			$res_2= mysql_query($sql_2);
			
			echo "Se registro Correctamente";
		}
	}
	*/
}	

if ($accion=="act_contacto"){
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
		
		
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	$dni=$_GET["dni"];
	$ncontacto=$_GET["ncontacto"];
	$operador=$_GET["operador"];
	

	$sql_1="update tb_contactos_actual set campo11='ACTUALIZAR',campo8='$operador',campo9='Se actualizo a $ncontacto'
	where item='$id'";
	//echo $sql_1;
	$res_1= mysql_query($sql_1);
	
	
		
	$sql_2="INSERT INTO tb_contactos_cot
			SELECT '',campo1,campo2,'$ncontacto',campo4,campo5,campo6,campo7,'$operador',campo9,NOW(),'$iduser',
			'$pc','ACTUALIZAR' 
			FROM tb_contactos_actual 
			WHERE campo2='$dni' limit 1";				
	//echo "<br>".$sql_1;
	$res_2= mysql_query($sql_2);	
	
	
	$sql_3="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES(LAST_INSERT_ID(),'ACTUALIZACION DE CONTACTOS','$iduser',now(),'SE ACTUALIZO EL $ncontacto DEL CLIENTE CON DNI $xdni','$pc_sis','$pc_asig','$xdni')";
	//echo "<br>".$sql_3;
	$res_3= mysql_query($sql_3);

	
		
}

if ($accion=="eliminar_contacto"){
	//$pc_asig	=	$_GET["pc_asig"];	
	$pc_sis		= 	gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	$dni=$_GET["dni"];
	$contacto=$_GET["contacto"];
		
	
	$sql_1="update tb_contactos_actual set campo11='ELIMINAR' where item='$id'";
	$res_1= mysql_query($sql_1);
	
	$sql_2="delete from tb_contactos_cot where campo3='$contacto' and tipo IN('ACTUALIZAR','AGREGAR NUMERO','AGREGAR CONTACTO')";
	echo $sql_2;
	$res_2= mysql_query($sql_2);
	
	$sql_3="INSERT INTO tb_contactos_cot
			SELECT '',campo1,campo2,'$contacto',campo4,campo5,campo6,campo7,'$operador','Se elimino $contacto',NOW(),'$iduser',
			'$pc','ELIMINAR' 
			FROM tb_contactos_actual 
			WHERE campo2='$dni' limit 1";				
	echo "<br>".$sql_1;
	$res_3= mysql_query($sql_3);	
	
	
	
	$sql_5="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES(LAST_INSERT_ID(),'ELIMINAR CONTACTOS','$iduser',now(),
	'SE ELIMINO EL NUMERO $contacto DEL CLIENTE CON DNI $dni','$pc_sis','$pc_asig','$dni')";
	//echo "<br>".$sql_3;
	$res_5= mysql_query($sql_5);
}

if ($accion=="combo_monitor"){
	$valor = $_GET["valor"];
	
	echo "
	<select name='c_monitor' id='c_monitor' class='caja_texto1_1'>
            <option value='0'>Escoger Monitor</option>       
            <?php
			$sql8=select * from tb_monitores where c_supervisor='$valor';			
		  	$queryresult8 = mysql_query($sql8) or die (mysql_error());
			while ($rowper8=mysql_fetch_row($queryresult8)) { 										  
			print '<option value='$rowper8[1]'>$rowper8[1]</option>';
			}
			?>
            </select>";
	
	
}


if ($accion=="validar_contacto"){			
	
	$dni=trim($_GET["dni"]);	
	$opc=trim($_GET["opc"]);
	$ape_pat=trim($_GET["ape_pat"]);		
	$ape_mat=trim($_GET["ape_mat"]);
	$ncompleto= $ape_pat.$ape_mat;
	$ncontacto=trim($_GET["ncontacto"]);	
	$pedido=trim($_GET["pedido"]);	
		
	
	if ($ncontacto=="" and $ape_mat=="" and $ape_pat=="" and $pedido==""){
		$cc=" campo2='$dni'";
		$dato = $dni;
	}else{
		if ($dni=="" and $ape_mat=="" and $ape_pat=="" and $pedido==""){	
			//$cc="campo3='$ncontacto' or campo4='$ncontacto' or campo6='$ncontacto' or campo8='$ncontacto' or campo10='$ncontacto'";
			$cc="campo3='$ncontacto'";
			$dato = $ncontacto;
		}else{
			if ($dni=="" and $pedido=="" and $ncontacto==""){
//			$cc="campo13 LIKE '%$ape_pat%' or campo14like '%$ape_mat%'";
			$cc="campo6 LIKE '%$ape_pat%' or campo7 like '%$ape_mat%'";
			$dato= $ape_mat." ".$ape_mat;
			}else{
			$cc="campo12='$pedido'";
			$dato = $pedido;	
			}
		}
		
	}
		
	$sql="SELECT * FROM tb_contactos_actual WHERE $cc";
	//echo $sql;
	$res_sql= mysql_query($sql);
	$reg_sql=mysql_num_rows($res_sql);
	
	//echo $reg_sql;
	
	if ($reg_sql==0){
		echo "NO";	
	}else{
		echo "SI";	
	}
	
	
	
}


if ($accion=="calcular_tiempo"){	
	
	$modo=$_GET["modo"];	
	
	if ($modo==""){
			
		$fec_ini=$_GET["fec_ini"];			
		$fec_fin=$_GET["fec_fin"];
			
		$cad   = "SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini', '$fec_fin'))*60) from cab_incidencia ";
		//echo $cad;
		$res   = mysql_query($cad);
		$reg   = mysql_fetch_row($res);
		
		$valor = limpia_espacios($reg[0]);
	
	}else{
	
		if ($modo=="0"){ // cuando combo modo esta desabilitado
			$fec_ini=$_GET["fec_ini"];			
			$fec_fin=$_GET["fec_fin"];	
	
		
			$cad   = "SELECT DATEDIFF('$fec_fin', '$fec_ini') + 1";
			//echo $cad;
			$res   = mysql_query($cad);
			$reg   = mysql_fetch_row($res);
			
			$valor = limpia_espacios($reg[0]);
	
			
		}else{
			
			if ($modo=="D"){
				
				$fec_ini=$_GET["fec_ini"];			
				$fec_fin=$_GET["fec_fin"];	
		
			
				$cad   = "SELECT DATEDIFF('$fec_fin', '$fec_ini') + 1";
				//echo $cad;
				$res   = mysql_query($cad);
				$reg   = mysql_fetch_row($res);
				
				$valor = limpia_espacios($reg[0]);			
			}
			
			if ($modo=="H"){
			
				$fec=$_GET["fec"];	
				$fec_=substr($fec,6,4)."-".substr($fec,3,2)."-".substr($fec,0,2)." ".substr($fec,11,8);
				
				$hor_ini=$_GET["hor_ini"];	
				$hor_fin=$_GET["hor_fin"];	
				
				$fec_ini=$fec_." ".$hor_ini;
				$fec_fin=$fec_." ".$hor_fin;
				
				//echo $fec_ini."|".$fec_fin;
				
				$valor = diff_sinp($fec_,$fec_,$hor_ini,$hor_fin);	
			}
			
		}
		
	}
	echo $valor;
	
	
	
}

if ($accion=="cerrar_secion"){
	
	if(isset($_SESSION['tiempo']) ) {
	
				//Tiempo en segundos para dar vida a la sesión.
			$inactivo = 900;//15min en este caso.
	
			//Calculamos tiempo de vida inactivo.
			$vida_session = time() - $_SESSION['tiempo'];
	
				//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
				if($vida_session > $inactivo)
				{
					
					//Removemos sesión.
					session_unset();
					//Destruimos sesión.
					session_destroy();              
					//Redirigimos pagina.
				   // header("Location: login.php");
								
					exit();
				}	
				
		}
	$_SESSION['tiempo'] = time();

	
	$ssx		= "update conexiones_web set fec_fin=now(),estado='DESCONECTADO',
	tiempo = SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , fec_ini, fec_fin ))*60)
	where idsess='$idsess'";
	//echo "<p>".$ssx;
	$res_ssx 	= mysql_query($ssx);
				
	$ssx1		= "update tb_usuarios 
	set idsess=0,user_pc='',conectado='0' 
	where iduser='$iduser'";
	//echo  "<p>".$ssx1;
	$res_ssx1 	= mysql_query($ssx1);		
	
	$ssx2		= "DELETE FROM cab_asignaciones_cot WHERE estado_asig='1' 
	AND SEC_TO_TIME((TIMESTAMPDIFF(HOUR ,fec_reg_web,NOW()))*60)='00:02:00'";
	//echo  "<p>".$ssx1;
	$res_ssx2 	= mysql_query($ssx2);
	
	
}

if ($accion=="mostrar_datos_carga"){
	
	$origen=$_GET["origen"];
	
	if ($origen=="G423"){
	
		$ss_2	= "SELECT origen,COUNT(*) FROM carga_pedidos_total GROUP BY 1 ORDER BY 1 ";
		$res_ss_2 	= mysql_query($ss_2);		
		
		echo "<table width='30%'>";				
			echo "<tr>";								
			echo "<td class='caja_texto_VERDE' width='15%'>ORIGEN </td>";	
			echo "<td class='caja_texto_VERDE' width='10%'>REGISTROS</td>";															
			echo "</tr>";
	
		while($reg_ss_2 = mysql_fetch_row($res_ss_2)){		
		
		echo "<tr>";			
						
		echo "<td class='caja_texto_pe'>";
		echo $reg_ss_2[0]; 			
		echo "</td>";	
				
		echo "<td class='caja_texto_pe' align='center'>";
		echo $reg_ss_2[1]; 			
		echo "</td>";		
		
		echo "</tr>";	
		
		$tot = 	$tot + $reg_ss_2[1]; 					
		}
		
		echo "<tr>";		
		echo "<td class='caja_texto_plomo'>";
		echo "TOTAL"; 			
		echo "</td>";	
		echo "<td class='caja_texto_plomo' align='center'>";
		echo $tot; 			
		echo "</td>";	
		echo "</tr>";	
		
	echo "</table>";	
	

	/**************************************************************************/
	echo "<br>";	
			
			$ss_1	= "SELECT origen,estado,COUNT(*) FROM carga_pedidos_total GROUP BY 1,2 ORDER BY 1 ";
			//echo $ss_1;
			
			$res_ss_1 	= mysql_query($ss_1);		
			
			echo "<table width='50%'>";				
			echo "<tr>";								
			echo "<td class='caja_texto_VERDE' width='15%'>ORIGEN </td>";	
			echo "<td class='caja_texto_VERDE' width='15%'>ESTADO </td>";	
			echo "<td class='caja_texto_VERDE' width='10%'>REGISTROS</td>";															
			echo "</tr>";
	
			while($reg_ss_1=mysql_fetch_row($res_ss_1)){		
			
			$cc1			="select * from tb_estados_asignacion where cod_estado=$reg_ss_1[1]";		
			$res_cc1 		= mysql_query($cc1);			
			$reg_cc1		=mysql_fetch_row($res_cc1);
			
			echo "<tr>";			
							
			echo "<td class='caja_texto_pe'>";
			echo $reg_ss_1[0]; 			
			echo "</td>";	
					
			echo "<td class='caja_texto_pe'>";
			echo $reg_cc1[1]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto_pe' align='center'>";
			echo $reg_ss_1[2]; 			
			echo "</td>";	
			
			echo "</tr>";		
					
			}	
		echo "</table>";	
		
	
	/**************************************************************************/
	
	/*
	echo "<br>";		
	$ss		= "SELECT * FROM origen_zonal ORDER BY zonal";	
	$res_ss 	= mysql_query($ss);		
	
	echo "<table width='50%'>";				
			echo "<tr>";					
			echo "<td class='txtlabel' width='15%'>ZONAL</td>";		
			echo "<td class='txtlabel' width='15%'>ORIGEN </td>";	
			echo "<td class='txtlabel' width='15%'>ESTADO </td>";	
			echo "<td class='txtlabel' width='10%'>REGISTROS</td>";															
			echo "</tr>";
	
	while($reg_ss=mysql_fetch_row($res_ss)){		
		
		$cc			= "select * from tb_estados_asignacion where cod_estado=$reg_ss[2]";		
		$res_cc 	= mysql_query($cc);			
		$reg_cc		= mysql_fetch_row($res_cc);
		
		echo "<tr>";			
						
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[0]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_cc[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[3]; 			
		echo "</td>";	
		
		echo "</tr>";		
				
		}	
	echo "</table>";	
		
	
		
	}else{
		
		echo "<br>";		
		$ss		= "SELECT 'CARGA GESTEL 47D',SUBSTR(fecha,1,10),COUNT(*) FROM gestel_47d GROUP BY 2 order by 2 desc";	
		//echo $ss;
		
		$res_ss 	= mysql_query($ss);		
		
		echo "<table width='50%'>";				
				echo "<tr>";					
				echo "<td class='txtlabel' width='15%'>PROCESO</td>";		
				echo "<td class='txtlabel' width='15%'>FECHA </td>";	
				echo "<td class='txtlabel' width='10%'>REGISTROS</td>";															
				echo "</tr>";
		
		while($reg_ss=mysql_fetch_row($res_ss)){		
			
			echo "<tr>";			
							
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[0]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[1]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[2]; 			
			echo "</td>";	
			
		
			echo "</tr>";		
					
			}	
		echo "</table>";
	*/
	}
}
if ($accion=="resetear_tablas"){
	mysql_query("truncate table tb_cms") ; 
	mysql_query("truncate table tb_cms_tmp") ; 
	mysql_query("truncate table tb_gestel_423") ;
	mysql_query("truncate table tb_gestel_423_prov") ;	
	
	$ayer=date("Y")."-".date("m")."-".(date("d")- 1);
	$paso_1		= "delete from tb_gestel_423_dia where substr(fec_carga,1,10)='$ayer'";		
	//echo "<br>".$paso_1;	
	$res_paso_1 = mysql_query($paso_1);	
	
	$paso_2		= "DELETE FROM cab_asignaciones_cot WHERE estado_asig='1' 
	AND SEC_TO_TIME((TIMESTAMPDIFF(HOUR ,fec_reg_web,NOW()))*60)='00:02:00'";
	//echo  "<p>".$paso_2;
	$res_paso_2	= mysql_query($paso_2);
}

if ($accion=="aceptar_asignacion_bl"){	
	
	
	$iduser=trim($_GET["iduser"]);	
	$c_multig=trim($_GET["c_multig"]);	
	$obs=trim($_GET["obs"]);	
	$c_cliente=trim($_GET["c_cliente"]);	
	$exc=trim($_GET["exc"]);		
	

	$cc="SELECT id FROM cab_beoliquidaciones_cot WHERE CODMULTIGESTION='$c_multig' 
	ORDER BY fec_reg_web DESC LIMIT 1";
	$res_cc = mysql_query($cc);
	$reg_cc= mysql_fetch_row($res_cc);
	
	$sql="update cab_beoliquidaciones_cot set estado='3',fec_cierre_atencion=now()	
	WHERE id='$reg_cc[0]'";
	//echo $sql;
	$res_sql = mysql_query($sql);	
	
	$sql_1="update tb_beoliquidacion set estado='3' WHERE CODMULTIGESTION='$c_multig'"; 
	//echo $sql;
	$res_sql1 = mysql_query($sql_1);	
	
	
	
}

if ($accion=="separar_pedido_bl"){	
	$c_multig=trim($_GET["c_multig"]);	
	$c_cliente=trim($_GET["c_cliente"]);	
	$fec_cli=trim($_GET["fec_cli"]);		
	$fec_atento=trim($_GET["fec_atento"]);
	$fec_carga=substr($_GET["fec_carga"],0,10);
		
	
	$sql="INSERT INTO cab_beoliquidaciones_cot
	(id,CODMULTIGESTION,usu_reg,fec_reg_web,fec_reg_cli,fec_reg_carga,fec_reg_atento,fec_cierre_atencion,estado,
	obs_registro,acciones,c_cliente)
	VALUES(LAST_INSERT_ID(),'$c_multig','$iduser',NOW(),'$fec_cli','$fec_carga','$fec_atento',NOW(),'1','OK','1','$c_cliente')";
	//echo $sql;
	$res_sql = mysql_query($sql);
	
	$os1="update tb_beoliquidacion set estado='1' where CODMULTIGESTION='$c_multig'";
	//echo $os1;
	$res_os1 = mysql_query($os1);
}

if ($accion=="rechazar_pedido_bl"){	
	$c_multig=trim($_GET["c_multig"]);	
	$c_cliente=trim($_GET["c_cliente"]);	
	$iduser=trim($_GET["iduser"]);	
	$obs=trim($_GET["obs"]);	
			
	$del_1="update tb_beoliquidacion set estado='0' where CODMULTIGESTION='$c_multig'";
//	echo $del_1;
	$res_1 = mysql_query($del_1);
	
	$del_2="delete from cab_beoliquidaciones_cot where CODMULTIGESTION='$c_multig'";
	//echo $del_2;
	$res_2 = mysql_query($del_2);
	
	$sql="insert into cab_beoliquidaciones_rechazados(id,CODMULTIGESTION,usu_reg,fec_reg_web,obs) values(LAST_INSERT_ID(),'$c_multig','$iduser',NOW(),'$obs')";
	$res_3 = mysql_query($sql);

	
}

if ($accion=="registrar_modem"){	
	$iduser=trim($_GET["iduser"]);	
	$c_averia=trim($_GET["c_averia"]);		
	$tipo=trim($_GET["tipo"]);	
	$medio=trim($_GET["medio"]);	
	

	$prev="select * from cab_modem_averiados where c_averia='$c_averia'";
	//echo $prev;
	$res_prev = mysql_query($prev);
	$reg_prev = mysql_fetch_row($res_prev);
	//echo $reg_prev[1]."|".$reg_prev[5];
	
	if ($reg_prev[1]==$c_averia || $reg_prev[5]=="RESERVADO"){
		
				$cc			="select * from tb_usuarios where iduser=$reg_prev[2]";		
				$res_cc 	= mysql_query($cc);			
				$reg_cc		= mysql_fetch_row($res_cc);
				
					echo "<table width='100%'>";				
					echo "<tr>";					
					echo "<td class='txtlabel' width='15%'>USUARIO</td>";		
					echo "<td class='txtlabel' width='15%'>FEC. REGISTRO</td>";	
					echo "<td class='txtlabel' width='15%'>C.AVERIA</td>";	
					echo "<td class='txtlabel' width='15%'>ESTADO </td>";	
					echo "<td class='txtlabel' width='10%'>TIPO</td>";	
					echo "<td class='txtlabel' width='10%'>CANAL</td>";															
					echo "</tr>";				
					echo "<tr>";					
					echo "<td class='aviso_horario' align='center' colspan='7'>EL COD.AVERIA $c_averia fue $reg_prev[5] por $reg_cc[1]</td>";
					echo "</tr>";				
			}else{
				$sql="insert into cab_modem_averiados(id_reg,c_averia,usu_reg,fec_reg,tipo,estado,via)
				values(LAST_INSERT_ID(),'$c_averia','$iduser',NOW(),'$tipo','RESERVADO','$medio')";
				//echo $sql;
				$res = mysql_query($sql);
				
				$sql_1="insert into deta_modem_averiados(c_averia,dpto,contrata,estado,obs_reg,obs_ate,usu_mov,fec_mov)
				values('$c_averia','','','RESERVADO','','','$iduser',now())";
				//echo $sql_1;
				$res_1 = mysql_query($sql_1) or die(mysql_error());
			
				echo "1";
	}	
	
}

if ($accion=="actualiza_pedido_modem"){
	$iduser=trim($_GET["iduser"]);	
	$c_averia=trim($_GET["c_averia"]);	
	$dpto=trim($_GET["dpto"]);	
	$contrata=trim($_GET["contrata"]);	
	$est=trim($_GET["est"]);		

	$sql_1="UPDATE deta_modem_averiados set dpto='$dpto', contrata='$contrata',estado='ATENDIDO', usu_mov='$iduser',fec_mov=now() 
	where c_averia='$c_averia'";
	//echo $sql_1;
	$res_1 = mysql_query($sql_1) or die(mysql_error());

	$sql_2="update cab_modem_averiados set estado='ATENDIDO',procede='$est' WHERE c_averia='$c_averia'";
	//echo $sql_1;
	$res_2 = mysql_query($sql_2) or die(mysql_error());

	/*****************************************************/
		$hoy =date("Y-m-d");
		$mm		= "SELECT * FROM cab_modem_averiados where usu_reg='$iduser' 
		and SUBSTR(fec_Reg,1,10)='$hoy' ORDER BY fec_reg desc";	
		//echo $mm;
		$res_mm	= mysql_query($mm);		
		
		echo "<table width='100%'>";				
				echo "<tr>";									
				echo "<td class='txtlabel' width='15%'>C.AVERIA</td>";	
				echo "<td class='txtlabel' width='15%'>ESTADO </td>";	
				echo "<td class='txtlabel' width='10%'>TIPO</td>";	
				echo "<td class='txtlabel' width='10%'>PROCEDE</td>";															
				echo "<td class='txtlabel' width='15%'>USUARIO</td>";		
				echo "<td class='txtlabel' width='15%'>FEC. REGISTRO</td>";	
				echo "</tr>";
		
		while($reg_mm = mysql_fetch_row($res_mm)){		
			
			$cc			="select * from tb_usuarios where iduser=$reg_mm[2]";		
			$res_cc 	= mysql_query($cc);			
			$reg_cc		= mysql_fetch_row($res_cc);
			
			echo "<tr>";			
							
		
			
			echo "<td class='casilla_texto'>";
			echo $reg_mm[1]; 			
			echo "</td>";	
			
			echo "<td class='casilla_texto'>";
			echo $reg_mm[5]; 			
			echo "</td>";	
			
			echo "<td class='casilla_texto'>";
			echo $reg_mm[4]; 			
			echo "</td>";	
			
			echo "<td class='casilla_texto'>";
			echo $reg_mm[6]; 			
			echo "</td>";
			
			echo "<td class='casilla_texto'>";
			echo $reg_cc[1]; 			
			echo "</td>";	
			
			echo "<td class='casilla_texto'>";
			echo $reg_mm[3]; 			
			echo "</td>";	
			echo "</tr>";		
					
			}	
		echo "</table>";		
}


if ($accion=="rechazar_modem"){
	$iduser=trim($_GET["iduser"]);	
	$c_averia=trim($_GET["c_averia"]);	
	
	$sql="delete from cab_modem_averiados where c_averia='$c_averia'";
	//echo $sql;
	$res = mysql_query($sql) or die(mysql_error());
	
	echo "Pedido $c_averia ha sido liberado";
}

if ($accion=="eliminar_extra"){
	
	$iduser=$_GET["iduser"];
	$id=$_GET["id"];
	$tipo=$_GET["tipo"];
	if ($tipo=="PROGRAMACION"){
		$tabla="programacion_extra";
	}else{
		$tabla="compensacion_extra";
	}
	$sql_1="delete from $tabla where id='$id'";
	$res_1= mysql_query($sql_1);
			
}



if ($accion=="agregar_part"){
	$iduser=$_GET["iduser"];
	$dni_escogidos=$_GET["dni_escogidos"];
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_inc=$_GET["c_inc"];
	
	$dni_escogidos = explode("|", $dni_escogidos);
	
	$dia=date("Y-m-d");
	
	$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_capacitacion ORDER BY 1 DESC";
	//echo $cad;
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq 	= limpia_espacios($rg[0]);
	$franqueo = "INC-".$franq;
//	echo $franqueo."|".$nro_escogidos."|";	
	
	echo $franqueo ;
	
	$i=0;
	
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {	
	
			
		$paso="insert into lista_capacitacion(cod_incidencia,cip_gestor,dni) values('$franqueo','','$dni_escogidos[$i]') ";	
		//echo "<br>".$i.$paso;	
		$res_paso = mysql_query($paso);
		
		$rutina_4	= "UPDATE lista_capacitacion SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and dni='$dni_escogidos[$i]'";
		//echo $rutina_4;
		$result_4 	= mysql_query($rutina_4) or die(mysql_error());

		$paso_1="update lista_capacitacion a, tb_usuarios b set a.cip_gestor=b.cip where a.dni=b.dni and a.cod_incidencia='$franqueo' ";	
		//echo "<br>".$i.$paso_1;	
		$res_paso_1 = mysql_query($paso_1);
	
	} 
	
}

if ($accion=="borrar_asig"){
	$hoy=date("Y-m-d");
	
	$paso_1="DELETE FROM tb_gestel_423_dia WHERE SUBSTR(fec_carga,1,10)< '$hoy'";		
	//echo "<br>".$paso_1;	
	$res_paso_1 = mysql_query($paso_1);	
	
	$paso_2		= "DELETE FROM cab_asignaciones_cot WHERE estado_asig='1' 
	AND SEC_TO_TIME((TIMESTAMPDIFF(HOUR ,fec_reg_web,NOW()))*60)='00:02:00'";
	//echo  "<p>".$ssx1;
	$res_paso_2	= mysql_query($paso_2);
}

if ($accion=="carga_combo_gu"){
	
	$combo=$_GET["combo"];
	$valor1=$_GET["valor1"];	
	$tabla["tabla"];	
	$valor2=$_GET["valor2"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="c_motivos_gu" id="c_motivos_gu" class="caja_sb">
          <?php 			
			print "<option value='0' selected>Seleccione Motivo</option>";
			$sql7="select * from $tabla where $valor2='$valor1'";
			//echo $sql7;
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[2]</option>";
			}
			?>
        </select>
<?php
	echo "</td></tr></table>";	
}


if ($accion=="grabar_cambios"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	//$dni_escogidos=$_GET["dni_escogidos"];
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_inc=$_GET["c_inc"];
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];
	$dni_escogidos = explode("|", $dni_escogidos);	
	
	
	
	$i=0;
	
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {	
		
		$paso_0="select c_supervisor,c_monitor,local,ola from tb_usuarios where dni='$dni_escogidos[$i]'";	
		//echo "<br>".$paso_1;	
		$res_paso_0 = mysql_query($paso_0);	
		$reg_paso_0=mysql_fetch_row($res_paso_0);
		
		if ($opc=="1"){
			$cad	=" c_supervisor = '$combo'";
			$detalle	=" Supervisor Nuevo : $combo | Usuario Anterior: $reg_paso_0[0] ";
		}
		
		if ($opc=="2"){
			$cad	=" c_monitor = '$combo'";
			$detalle	=" Monitor Nuevo : $combo | Monitor Anterior: $reg_paso_0[1]" ;
		}
		
		if ($opc=="3"){
			$cad	=" local = '$combo'";
			$detalle	=" Local Nuevo : $combo | Local Anterior: $reg_paso_0[2]";
		}
		
		if ($opc=="4"){
			$cad	=" ola = '$combo'";
			$detalle	=" Ola Nueva : $combo | Ola Anterior: $reg_paso_0[1]";
		}
		
		$paso_1="update tb_usuarios set $cad where dni='$dni_escogidos[$i]' ";	
		//echo "<br>".$paso_1;	
		$res_paso_1 = mysql_query($paso_1);
		
		$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'ORGANIZACION DE USUARIO WEB GESCOT','$iduser',now(),
		'ACTUALIZACION DE INFORMACION DE LOS DNI: $dni_escogidos[$i]|$detalle','$pc','$dni_escogidos[$i]')";
		//echo $sql_2;
		$res_2= mysql_query($sql_2);
	
	} 
	
	  
}

if ($accion=="grabar_cambios2"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$dni_escogidos=$_GET["dni_escogidos"];
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_inc=$_GET["c_inc"];
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];
	$dni_escogidos = explode("|", $dni_escogidos);	
	
	
	
	$i=0;
	
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {	
		
		$paso_0="select c_supervisor,c_monitor,local,ola from tb_usuarios where dni='$dni_escogidos[$i]'";	
		//echo "<br>".$paso_1;	
		$res_paso_0 = mysql_query($paso_0);	
		$reg_paso_0=mysql_fetch_row($res_paso_0);
		
		if ($opc=="1"){
			$cad	=" c_supervisor = '$combo'";
			$detalle	=" Supervisor Nuevo : $combo | Usuario Anterior: $reg_paso_0[0] ";
		}
		
		if ($opc=="2"){
			$cad	=" c_monitor = '$combo'";
			$detalle	=" Monitor Nuevo : $combo | Monitor Anterior: $reg_paso_0[1]" ;
		}
		
		if ($opc=="3"){
			$cad	=" local = '$combo'";
			$detalle	=" Local Nuevo : $combo | Local Anterior: $reg_paso_0[2]";
		}
		
		if ($opc=="4"){
			$cad	=" ola = '$combo'";
			$detalle	=" Ola Nueva : $combo | Ola Anterior: $reg_paso_0[1]";
		}
		
		$paso_1="update tb_usuarios set $cad where dni='$dni_escogidos[$i]' ";	
		//echo "<br>".$paso_1;	
		$res_paso_1 = mysql_query($paso_1);
		
		$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'ORGANIZACION DE USUARIO WEB GESCOT','$iduser',now(),
		'ACTUALIZACION DE INFORMACION DE LOS DNI: $dni_escogidos[$i]|$detalle','$pc','$dni_escogidos[$i]')";
		//echo $sql_2;
		$res_2= mysql_query($sql_2);
	
	} 
	
	  
}

if ($accion=="grabar_incidencia_prueba"){
	
	
	$iduser=$_GET["iduser"];
	$trabajador=$_GET["trabajador"];
	
	if ($_GET["opc"]=="1"){	
	$trabajador = explode("-", $trabajador);	
	$cip=$trabajador[0]; // porción1
	$dni=$trabajador[1]; // porción1
	}else{
	$trabajador = explode("-", $trabajador);	
	$cip=$trabajador[0]; // porción1
	$dni=$trabajador[1]; // porción1
	}
	$ntrabajador=$trabajador[1]; // porción2	
	$tp_incidencia=$_GET["tp_incidencia"];
	$c_mot_inc=$_GET["c_mot_inc"];
	$nro=$_GET["nro"];
	$modo=$_GET["modo"];
	$c_doid=$_GET["c_doid"];
	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	
	if ($_GET["modo"]=="0"){		
		
		if ($_GET["tiempo"]=="1")	{
			$tiempo_t	= "8.5";
		}else{
			$tiempo_t	= $tiempo*8.5;
			
		}
				
	}else{
		
	if ($_GET["modo"]=="D"){
			
			if ($_GET["tiempo"]=="1")	{
				$tiempo_t 	="8.5";
			}else{
				$tiempo_t	= $tiempo*8.5;				
			}
		
		}else{
	
		$tiempo_t	=$_GET["tiempo"];
			
		}
	}
	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];
	
	$tiempo_t	= limpia_espacios($tiempo_t);	
	
	
	$nf_ini	= substr($_GET["fec_ini"],11,2);
	$nf_ini = (int) $nf_ini;

	
	$nf_fin	= substr($_GET["fec_fin"],11,2);
	$nf_fin = (int) $nf_fin;
	
	$nf_tiempo	= substr($tiempo_t,0,2);
	$nf_tiempo = (int) $nf_tiempo;
	
	$nf_min	= substr($tiempo_t,3,2);
	//$nf_min = (int) $nf_min;
	
	//echo $nf_ini."|".$nf_fin."|".$nf_tiempo;
	
	echo $tiempo_t."|".$nf_min;
	
	//for $con=$nf_ini 
	$con = 0;
	
	for ($con = 0 ; $con < $nf_tiempo  + 1 ; $con++) {
		$n_hri=(int)substr($_GET["fec_ini"],11,2) + $con;
		$hor_final_ini = substr($fec_ini_,0,10)." ".$n_hri.":00";	
		//echo $hor_final_ini."|";
		
		$sql_1="INSERT INTO cab_incidencia
		(cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,
		c_doid,dni,nro_participantes)
		VALUES	
		('$cip',now(),'$iduser','$tp_incidencia','$c_mot_inc','$fec_ini_','$$hor_final_ini','$obs','$tiempo_t','$modo',
		'$c_doid','$dni','$nro')";
		echo "<br>".$sql_1;			
		$res_1= mysql_query($sql_1);	
		
		$dia=date("Y-m-d");
	
		$cad=" SELECT LAST_INSERT_ID() from cab_incidencia";
		$rs = mysql_query($cad);
		$rg = mysql_fetch_array($rs);
		$idfranqueo="INC-".substr($dia,0,4).substr($dia,5,2).substr($dia,8,2).str_pad($rg[0], 4, '0', STR_PAD_LEFT);
		//echo $idfranqueo; 	
		
		$cad_1="update cab_incidencia set cod_incidencia='$idfranqueo' where id='$rg[0]'";
		echo $cad_1;
		
		$rs_1 = mysql_query($cad_1);
		
		if ($nf_min=="30"){
			
		}
	
	}
}

if ($accion=="carga_combo_gestores"){
	
	$combo=$_GET["combo"];
	$valor1=$_GET["valor1"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="gestores" id="gestores" class="caja_texto_pe" >
      <option value="0">Escoger</option>
      <?php
	  		$sql8="select iduser,ncompleto from tb_usuarios where estado='HABILITADO' and c_supervisor='$valor1'";	
			echo $sql8;	
				
		  	$queryresult8 = mysql_query($sql8) or die (mysql_error());
			while ($rowper8=mysql_fetch_row($queryresult8)) { 										  
			print "<option value='$rowper8[0]'>$rowper8[1]</option>";
			}
			?>
        </select>
<?php
	echo "</td></tr></table>";	
}


if ($accion=="buscar_gestores_asig"){
	$c_supervisor=$_GET["c_supervisor"];
	$gestores=$_GET["gestores"];
	$fec=$_GET["fec"];
	$h_ini=$_GET["h_ini"];
	$origen=$_GET["origen"];

	if ($_GET["gestores"]=="0"){
		$cad_1="";
	}else{
		$cad_1=" and usu_reg='$gestores'";
	}

	if ($_GET["fec"]==""){
		$cad_2="";
	}else{
		$fec = substr($fec,6,4)."-".substr($fec,3,2)."-".substr($fec,0,2);
		$cad_2=" and SUBSTR(a.fec_reg_web,1,10)='$fec'";
	}
	
	if ($_GET["h_ini"]=="0"){
		$cad_3="";
	}else{
		$cad_3=" and SUBSTR(a.fec_reg_web,1,10)='$fec' and SUBSTR(a.fec_reg_web,12,2)='$h_ini'";
	}
	
	if ($_GET["origen"]=="0"){
		$cad_4="";
	}else{
		$cad_4=" and a.origen='$origen'";
	}	
		
	$t_cad = $cad_1.$cad_2.$cad_3.$cad_4;
	
	$sql="SELECT a.usu_reg,b.ncompleto,SUBSTR(a.fec_reg_web,1,10) AS dia ,SUBSTR(a.fec_reg_web,12,2) AS hora,a.origen,
	COUNT(*) AS cantidad,b.c_supervisor,b.c_monitor
	FROM cab_asignaciones_cot a, tb_usuarios b
	WHERE a.usu_reg=b.iduser $t_cad
	GROUP BY 1,2,3,4,5
	ORDER BY 2,3,4";
	//echo $sql;
	$res_lis = mysql_query($sql);
	
	echo "<table width='100%'>";
	echo "<tr>
	<td class='caja_texto_pe' align='center'>SUPERVISOR</td>
    <td class='caja_texto_pe' align='center'>GESTOR</td>
    <td class='caja_texto_pe' align='center'>FECHA</td>
    <td class='caja_texto_pe' align='center' >HORA</td>
	<td class='caja_texto_pe' align='center'>ORIGEN</td>
    <td class='caja_texto_pe' align='center'>CANTIDAD</td>
	</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){	
		
		$s="select nom_supervisor from tb_supervisores where cod_supervisor='".$reg_lis[6]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
  	echo "
  	<tr class='caja_sb'>
	<td>$rg_s[0]</td>
    <td>$reg_lis[1]</td>
    <td>$reg_lis[2]</td>
    <td align='center'>$reg_lis[3]:00</td>
    <td align='center'>$reg_lis[4]</td>
    <td align='center'>$reg_lis[5]</td>
  	</tr>";    	
	}
	echo "</table>";
}


if ($accion=="mostrar_coordinado"){
	
	$combo=$_GET["combo"];
	$valor1=$_GET["valor1"];	
	
	//<td class='tit_boleta' width='85'>Provincia</td>
	echo "
	<table border='0'>
	<tr>	
	<td>";
	?>
	<select name="c_coordinado" id="c_coordinado" class="caja_texto_pe" >
      <option value="0">Escoger</option>
      <?php
			$sql8="select * from gu_alogamiento  WHERE id_tp_solicitud='$valor1'";	
			echo $sql8;		
		  	$queryresult8 = mysql_query($sql8) or die (mysql_error());
			while ($rowper8=mysql_fetch_row($queryresult8)) { 										  
			print "<option value='$rowper8[0]'>$rowper8[2]</option>";
			}
			?>
        </select>
<?php
	echo "</td></tr></table>";	
}

if ($accion=="grabar_gestion_usu"){	

	$iduser=trim($_GET["iduser"]);	
	$gestor=trim($_GET["gestor"]);	
	$solicitud=trim($_GET["solicitud"]);	
	$n_req=trim($_GET["n_req"]);	
	$coordinado=trim($_GET["coordinado"]);
	$tpregistro=trim($_GET["tpregistro"]);
	$motivos=trim($_GET["cmotivos"]);
	$obs=trim($_GET["obs"]);
	
			
	$yy=substr($_GET["fec"],6,4);
	$mm=substr($_GET["fec"],3,2);
	$dd=substr($_GET["fec"],0,2);	
	$fec_reg=$yy."-".$mm."-".$dd;
	
	$cc			="select max(gu_int) from gu_gestion_usuarios_cab";
	$res_cc 	= mysql_query($cc);
	$reg_cc		= mysql_fetch_row($res_cc);
	$id 		= $reg_cc[0] + 1;
	
	$ss 		= "select CONCAT('GU',LPAD($id,8,'0'))";
	//echo $ss;
	$res_ss 	= mysql_query($ss);
	$reg_ss		= mysql_fetch_row($res_ss);
	$gu_codigo 	= $reg_ss[0];
	
	$sql="INSERT INTO gu_gestion_usuarios_cab
	(gu_int,gu_codigo,gu_tip_reg,gu_num_inc,gu_mot,gu_fec_reg,gu_fec_cierre,gu_fec_val,gu_tsla,gu_est_req,
	 gu_dni,gu_coord,gu_usu_reg,gu_est,reg_por_inc,gu_det_obs,gu_are_der
	)VALUES(
	$id,'$gu_codigo','$solicitud','$n_req','$motivos','$fec_reg','','','','$tpregistro',
	'$gestor','$coordinado','$iduser','1','','$obs',''
	)";
	echo $sql;
	$res_sql = mysql_query($sql);
	
}

if ($accion=="grabar_edicion_incidencia"){
	$iduser		=$_GET["iduser"];	
	$c_inc		=$_GET["c_inc"];		
	$fec_ini	=$_GET["fec_ini"];	
	$fec_fin	=$_GET["fec_fin"];	
	$obs		=$_GET["obs"];	
	$tp_inc		=$_GET["tp_inc"];	
	
	
	$sql_1="update cab_incidencia set fec_ini_inc='$fec_ini', fec_fin_inc='$fec_fin', obs_incidencia='$obs' 
	where cod_incidencia='$c_inc'";	
	//echo $sql_1;
	$res_1= mysql_query($sql_1);	
	
	$sql_2="insert into det_incidencia(cod_incidencia,usu_mov,fec_mov,fec_ini,fec_fin,obs) 
	values('$c_inc','$iduser',now(),'$fec_ini','$fec_fin','$obs')";	
	//echo $sql_2;
	$res_2= mysql_query($sql_2);	
	
}

if ($accion=="eliminar_incidencia"){
	$iduser		= $_GET["iduser"];	
	$c_inc		= $_GET["c_inc"];		
	$obs 		= "Se elimino incidencia ".$inc." por el usuario ".$iduser;
	
	$sql_1="delete from cab_incidencia where id='$c_inc'";	
	//echo $sql_1;
	$res_1= mysql_query($sql_1);	

	$sql_2="insert into det_incidencia(cod_incidencia,usu_mov,fec_mov,fec_ini,fec_fin,obs) 
	values('$c_inc','$iduser',now(),'$fec_ini','$fec_fin','$obs')";	
	echo $sql_2;
	$res_2= mysql_query($sql_2);	
}


if ($accion=="aceptar_pedido_canceladas"){	
	$id=trim($_GET["id"]);	
	$codigo=trim($_GET["codigo"]);	
	$c_tipo=$_GET["c_tipo"];
	$iduser=$_GET["iduser"];	
	
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	/*
	$sql="INSERT INTO cancelaciones_trabajadas(id,codigo,fec_eje,est,pc,iduser)VALUES(LAST_INSERT_ID(),'$codigo',NOW(),'$c_tipo','$pc','$iduser')";
	//echo $sql;
	$res_sql = mysql_query($sql);
	*/
	
	
	$sql_3		="select LAST_INSERT_ID() from cancelaciones_trabajadas";
//echo $sql_3;
	$res_sql_3  = mysql_query($sql_3) or die(mysql_error());
	$reg_lis_3  = mysql_fetch_row($res_sql_3);

	$sql="update cancelaciones_trabajadas set fec_eje=now(),est='$c_tipo' where codigo='$codigo'";
	//echo $sql;
	$res_sql = mysql_query($sql);
	
		
	$os1="update cab_gestion_actividades_cot set estado='$c_tipo',marca1='$pc',marca2='$iduser' where requerimiento='$codigo'";
	echo $os1;
	$res_os1 = mysql_query($os1);
		
	//echo "OK";	
	
}

if ($accion=="separar_pedido_cancelada"){	
	$iduser		=$_GET["iduser"];	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$codigo		=trim($_GET["codigo"]);	
	$f_carga	=$_GET["f_carga"];
	$f_legado	=$_GET["f_legado"];	
	
	
	$sql_2		="INSERT INTO cancelaciones_trabajadas(codigo,est,pc,iduser,fec_bloqueo,fec_carga,fec_legado)
	VALUES('$codigo','SEPARADO','$pc','$iduser',now(),'$f_carga','$f_legado')";
				//echo $sql_2;
	$res_sql_2  = mysql_query($sql_2) or die(mysql_error()); 

}


/************************************TDATA****************************************************************************************/

if ($accion=="validar_contacto_tdata"){		

	include("conexion_teradata.php");	
	
	$dni=trim($_GET["dni"]);	
	$opc=trim($_GET["opc"]);
	$bd=trim($_GET["bd"]);
	$ape_pat=trim($_GET["ape_pat"]);		
	$ape_mat=trim($_GET["ape_mat"]);
	$ncompleto= $ape_pat.$ape_mat;
	$ncontacto=trim($_GET["ncontacto"]);	
	$pedido=trim($_GET["pedido"]);	
		
		
	if ($ncontacto=="" and $ape_mat=="" and $ape_pat=="" and $pedido==""){
		$cc="nro_documento='$dni'";
		$dato = $dni;
	}else{
		if ($dni=="" and $ape_mat=="" and $ape_pat=="" and $pedido==""){	
			//$cc="campo3='$ncontacto' or campo4='$ncontacto' or campo6='$ncontacto' or campo8='$ncontacto' or campo10='$ncontacto'";
			$cc="telefono='$ncontacto'";
			$dato = $ncontacto;
		}else{
			if ($dni=="" and $pedido=="" and $ncontacto==""){
//			$cc="campo13 LIKE '%$ape_pat%' or campo14like '%$ape_mat%'";
			$cc="ape_paterno LIKE '%$ape_pat%' or ape_materno like '%$ape_mat%'";
			$dato= $ape_mat." ".$ape_mat;
			}else{
			$cc="peticion='$pedido'";
			$dato = $pedido;	
			}
		}
		
	}
	
	if($bd=="TERADATA"){
		$cad	="sel *  from dbi_cot.RB_Contactabilidad_COT where $cc";
		//echo $cad;
					
		$statement	=odbc_exec($connection, $cad);
		$n_filas 	=odbc_num_rows($statement);
		
		//echo $n_filas;
		
		if ($n_filas==0){
			echo "NO";	
		}else{
			echo "SI";	
		}
		
	}else{		
		$sql="SELECT * FROM tb_contactos_actual WHERE $cc";
		//echo $sql;
		$res_sql= mysql_query($sql);
		$reg_sql=mysql_num_rows($res_sql);
		
		//echo $reg_sql;
		
		if ($reg_sql==0){
			echo "NO";	
		}else{
			echo "SI";	
		}
	}
	
}

if ($accion=="mostrar_combo_mig"){	
	$valor=trim($_GET["valor"]);	
	
	if ($valor=="NO ATENDIDO"){	
	echo "
    <td width='30%' valign='top' class=''>MOTIVO</td>
    <td width='70%' class=''>
	<select name='exc' class='casilla_texto' id='exc'>
      <option value='0'>SELECCIONAR</option>
      <option value='INTERNET NAKED/DTH/MONOPRODUCTO/VOIP '>INTERNET NAKED/DTH/MONOPRODUCTO/VOIP </option>
      <option value='SUSPENDIDO/EN BAJA'>SUSPENDIDO/EN BAJA</option>
      <option value='ERROR EN HOST/PEDIDO PENDIENTE'>ERROR EN HOST/PEDIDO PENDIENTE</option>
      <option value='SIN COBERTURA/NO PRODUCTO ESPEJO'>SIN COBERTURA/NO PRODUCTO ESPEJO</option>
      <option value='T.EMPRESAS/ENTIDAD PUBLICA'>T.EMPRESAS/ENTIDAD PUBLICA</option>
      <option value='EMBAJADOR TDP'>EMBAJADOR TDP </option>
    </select>
	</td>";
	}

	if ($valor=="ATENDIDO"){	
	echo "
	<tr>
    <td width='35%' valign='top' class='caja_texto_pe'>PET. ATIS</td>
    <td width='65%' class=''><input name='c_atis' type='text' id='c_atis' /></td>
	</tr>
	<tr>
		<td valign='top' class='caja_texto_pe'>PRECIO</td>
		<td class='caja_texto_pe'><input id='precio' type='text' name='precio' /></td>
	</tr>
	<tr>
		<td valign='top' class='caja_texto_pe'>UPGRADE</td>
		<td class='caja_texto_pe'>
		<select name='up' class='casilla_texto' id='up'>     
		  <option value='SI'>SI</option>
		  <option value='NO' selected>NO</option>
		</select></td>
    </tr>";
	}
}

if ($accion=="validar_pedido_migracion"){	

	$peticion=trim($_GET["peticion"]);	
	
	$cc1="SELECT a.telefono,a.estado,b.estado 
	FROM cab_gestion_actividades_cot a, tb_estados_asignacion b 
	WHERE a.estado=b.cod_estado AND a.peticion='$peticion'";
	//echo $cc;
	$res_cc1 = mysql_query($cc1);
	$reg_cc1 =mysql_fetch_row($res_cc1);
	$nro1    =mysql_num_rows($res_cc1);
	
	if ($reg_cc1[1]==0){	
		echo "LIBRE"; // libre
	}else{
		echo "OCUPADO"; // ocupado
		//echo "<br>El pedido ".$pedido." se encuentra en ".$reg_cc[2];
	}
		
}



if ($accion=="aceptar_migracion"){	
	$iduser=trim($_GET["iduser"]);	
	$telefono=trim($_GET["peticion"]);		
	
	$cc		="select max(id) from cab_migraciones_cot";
	$res_cc = mysql_query($cc);
	$reg_cc	= mysql_fetch_row($res_cc);
	$id 	= $reg_cc[0] + 1;
	
	$sql="INSERT INTO cab_migraciones_cot
	(telefono,usu_reg,fec_reg_web,fec_reg_leg,fec_cierre_atencion,estado_migra,obs_registro,precio,up,exclusiones)
	VALUES('$telefono','$iduser',now(),'$f_leg','','SEPARADO','','','','')";
	//echo $sql;
	$res_sql = mysql_query($sql);
	

	$os2="update cab_gestion_actividades_cot set estado='SEPARADO' where requerimiento='$telefono' and actividad='MIGRACIONES'";
	$res_os2 = mysql_query($os2);
}


if ($accion=="grabar_migracion"){	
		
	$iduser=trim($_GET["iduser"]);	
	$telefono=trim($_GET["telefono"]);	
	$obs=trim($_GET["obs"]);		
	$estado=trim($_GET["estado"]);		
	$precio=trim($_GET["precio"]);	
	$f_leg=trim($_GET["f_leg"]);		
	$exc=trim($_GET["exc"]);		
	$c_atis=trim($_GET["c_atis"]);		
	

	$sql_0	=" SELECT MAX(id) from cab_migraciones_cot";
	$rs_0 	= mysql_query($sql_0);
	$rg_0 = mysql_fetch_array($rs_0);
	
	$sql_1="update cab_migraciones_cot set estado_migra='$estado',fec_cierre_atencion=now(),precio='$precio',c_atis='$c_atis', up='$up',obs_registro='$obs',exclusiones='$exc'
	WHERE id='$rg_0[0]'"; 
//	echo $sql_1;
	$res_sql1 = mysql_query($sql_1);
	
	$sql_2="update cab_gestion_actividades_cot set estado='$estado' WHERE telefono='$telefono'"; 
	//echo $sql_1;
	$res_sql2 = mysql_query($sql_2);
	
	
}

if ($accion=="rechazar_pedido_migracion"){	
	$peticion=trim($_GET["peticion"]);		
	$iduser=trim($_GET["iduser"]);	
	$obs=trim($_GET["obs"]);	
	
	
			
	$del_1="update cab_gestion_actividades_cot set estado='PENDIENTES' where telefono='$peticion' and actividad='MIGRACIONES'";
//	echo $del_1;
	$res_1 = mysql_query($del_1);
	
	$sql_0	=" SELECT MAX(id) from cab_migraciones_cot";
	$rs_0 	= mysql_query($sql_0);
	$rg_0 = mysql_fetch_array($rs_0);
	
	$del_2="delete from cab_migraciones_cot where id='$rg_0[0]'";
	//echo $del_2;
	$res_2 = mysql_query($del_2);
	
	$del_3="insert into cab_migraciones_rechazados(telefono,usu_reg,fec_reg_web,obs) values('$peticion','$iduser',NOW(),'$obs')";
	//echo del_3;
	$res_3 = mysql_query($del_3);

	
}


if($accion=="guardar_archivo"){

$c_unico=$_GET["c_unico"]; 	
//$archivo_origen=$_GET["archivo_origen"]; 	
$archivo_destino=$_GET["archivo_destino"]; 	
$carpeta_destino=$_GET["carpeta_destino"]; 	

//$exten = pathinfo( $_FILES["archivo"]['name'],PATHINFO_DIRNAME);
//$exten = pathinfo($archivo_origen, PATHINFO_FILENAME);
print_r($_FILES);

}

if($accion=="grabar_reasignacion"){

	$iduser=$_GET["iduser"]; 	
	$telefono=$_GET["telefono"]; 	
	
	$sql="insert into cab_reasignaciones values('','$telefono','$iduser',NOW(),now(),'','1','','','','')";
	//echo del_3;
	$res_sql = mysql_query($sql);


}

if($accion=="fin_reasignacion"){

	$iduser=$_GET["iduser"]; 	
	$telefono=$_GET["telefono"]; 	
	$c_comprobacion=$_GET["c_comprobacion"]; 	
	$c_reasig=$_GET["c_reasig"]; 	
	
	$cad=" SELECT MAX(id)  from cab_reasignaciones";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);
	
	$sql="update cab_reasignaciones set cod_comprobacion='$c_comprobacion',exclusiones='$c_reasig',estado_asig='3',fec_cierre_atencion=now()  
	where id='$rg[0]'";
	//echo $sql;
	$res_sql = mysql_query($sql);

	echo "Se registro atencion del telefono ".$telefono." con codigo de comprobacion ".$c_comprobacion;
}

if($accion=="detalle_maestra_reniec_tdata"){

	include ("conexion_teradata.php"); 
	
	$connection_teradata 	= db_conn_teradata();
	$connection_mysql 		= db_conn_mysql();
	
	$dni=$_GET["dni"]; 
		
	$cad_tdata="sel * from DBI_PUBLIC.padron_personas where dni='$dni'";

		$statement=odbc_exec($connection_teradata, $cad_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}	
	
	
	echo "
	<table width='100%' border='0' cellpadding='0' cellspacing='0' class='marco_tabla'>"; 
	
				$cc				= "select * from tb_usuarios where dni='$dni'";		 
				//echo $cc;
				$res_cc			= mysql_query($cc,$connection_mysql);
				$num_rows_cc	= mysql_num_rows($res_cc);
				
				if ($num_rows_cc == 1){
				echo "			
				  <tr>
					<td colspan='10' class='aviso_horario' align='center'>
					<input name='existe' type='hidden' id='existe' value='SI' />
					USUARIO YA SE ENCUENTRA REGISTRADO EN LA GESCOT</td>
				  </tr>";			  
				}else{
					echo "<input name='existe' type='hidden' id='existe' value='NO' />";
				}			


	echo "
	  <tr>
		<td class='caja_texto_AMA'>APELLIDO PATERNO</td>
		<td class='caja_texto_AMA'>APELLIDO MATERNO</td>
		<td class='caja_texto_AMA'>NOMBRES</td>
		<td class='caja_texto_AMA'>FECHA NACIMIENTO</td> 
		<td class='caja_texto_AMA'>SEXO</td> 
	  </tr>";
	  
	  	  
	  if (odbc_num_rows($statement)>0){
		 
		while (odbc_fetch_row($statement)) {
				 $col_dni				=odbc_result($statement,"dni");			
				 $col_ape_pat			=odbc_result($statement,"ape_pat");				
				 $col_ape_mat			=odbc_result($statement,"ape_mat");	
				 $col_nombre			=odbc_result($statement,"nombre");	 			  
				 $col_fec_nacimiento	=odbc_result($statement,"fec_nacimiento");
				 $col_sexo				=odbc_result($statement,"sexo");			 
				 
		echo "			
		  <tr>
			<td class='caja_texto_pe'><input name='APE_PAT' type='text' class='caja_texto_cb' id='APE_PAT' size='30' value='$col_ape_pat'  /></td>
			<td class='caja_texto_pe'><input name='APE_MAT' type='text' class='caja_texto_cb' id='APE_MAT' size='30' value='$col_ape_mat' /></td>
			<td class='caja_texto_pe'><input name='NOMBRES' type='text' class='caja_texto_cb' id='NOMBRES' size='30' value='$col_nombre' /></td>
			<td class='caja_texto_pe'><input name='fec_nacimiento' type='text' class='caja_texto_cb' id='fec_nacimiento' size='30' value='$col_fec_nacimiento' /></td>
			<td class='caja_texto_pe'><input name='sexo' type='text' class='caja_texto_cb' id='sexo' size='30' value='$col_sexo' /></td>
		  </tr>";
		  
		  		
		}
	 }else{
	 	echo "			
		  <tr>
			<td colspan='10' class='caja_texto_pe' align='center'>DNI NO SE ENCUENTRA REGISTRADO EN LA RENIEC</td>
		  </tr>";	 
	 }	 
	echo "</table>";
}

if($accion=="grabar_movimientos_usuarios"){

	$iduser		= $_GET["iduser"]; 
	$xid_ant	=$_GET["xid_ant"]; 
	$xdni_mov	=$_GET["xdni_mov"]; 
	$xcip_mov	=$_GET["xcip_mov"]; 
	$xusu_mov	=$_GET["xusu_mov"]; 
	$xapli_mov	=$_GET["xapli_mov"]; 
	$xfec_mov	=$_GET["xfec_mov"]; 
	
	
	$sql0	="SELECT * FROM movimientos_maestra WHERE dato='$xusu_mov' and aplicativo='$xapli_mov' and est='CREADO'";
	//echo $sql0;
	$rs_0 	= mysql_query($sql0);
	$rg_0 	= mysql_fetch_array($rs_0);
	$nrg	= mysql_num_rows($rs_0);
	
	//echo "<br>".$nrg;
	
	if ($nrg > 0){
		echo "EL USUARIO $xusu_mov YA SE ENCUENTRA REGISTRADO CON EL APLICATIVO $xapli_mov";	
	}else{
	
		$sql1="update movimientos_maestra set est='DESACTIVADO',fec_fin='$xfec_mov',usu_mov='$iduser',obs_mov='' where id='$xid_ant'";
		//echo $sql1;
		$res_sql1 = mysql_query($sql1);
	
		$apli="t_".strtolower(str_replace(' ','_',$xapli_mov));
		
		$sql2="insert into movimientos_maestra values('','$xdni_mov','$xusu_mov','$xapli_mov',
		'ACT. USUARIO',now(),'$xfec_mov','2050-01-01','$iduser','MODIFICACION POR MODULO','CREADO','$apli','','')";
		//echo "<br>".$sql2;
		$res_sql2 = mysql_query($sql2);
		
		echo "Se registro correctamente";
	}
	
	/*
		$sql1="update movimientos_maestra set est='DESACTIVADO',fec_fin='$xfec_mov',usu_mov='$iduser',obs_mov='' where id='$xid_ant'";
		//echo $sql1;
		$res_sql1 = mysql_query($sql1);
	
		$sql2="insert into movimientos_maestra values('','$xdni_mov','$xusu_mov','$xapli_mov','ACT. USUARIO',now(),'$xfec_mov','2050-01-01','$iduser','','ACTIVO')";
		//echo "<br>".$sql2;
		$res_sql2 = mysql_query($sql2);
		
		echo "Se registro correctamente";
	*/
}

if ($accion=="agregar_gestores"){
	$iduser=$_GET["iduser"];
	$dni_escogidos=$_GET["dni_escogidos"];
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_inc=$_GET["c_inc"];
	
	$dni_escogidos = explode("|", $dni_escogidos);
	
	$dia=date("Y-m-d");
	
	$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
	//echo $cad;
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq 	= limpia_espacios($rg[0]);
	$franqueo_ = "INC-".$franq;
//	echo $franqueo."|".$nro_escogidos."|";	
	
	echo trim($franqueo_);
	
	
	$i=0;
	
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {	
	
			
		$paso="insert into lista_gestores(cod_incidencia,cip_gestor,dni) values('$franqueo_','','$dni_escogidos[$i]') ";	
		//echo "<br>".$i.$paso;	
		$res_paso = mysql_query($paso);
		
		$rutina_4	= "UPDATE lista_gestores SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and dni='$dni_escogidos[$i]'";
		//echo $rutina_4;
		$result_4 	= mysql_query($rutina_4) or die(mysql_error());

		$paso_1="update lista_gestores a, tb_usuarios b set a.cip_gestor=b.cip where a.dni=b.dni and a.cod_incidencia='$franqueo_' ";	
		//echo "<br>".$i.$paso_1;	
		$res_paso_1 = mysql_query($paso_1);
	
	} 
	
}


if ($accion=="grabar_incidencia_grupal"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$c_incidencia=limpia_espacios($_GET["c_incidencia"]);
	$c_mot_gru=$_GET["c_mot_gru"];
	$c_mot_inc_gru=$_GET["c_mot_inc_gru"];
	$modo_gru=$_GET["modo_gru"];
	
	$c_doid_gru=$_GET["c_doid_gru"];	
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_inc=$_GET["c_inc"];	
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];
	$dni_escogidos = explode("|", $_GET["dni_escogidos"]);	
	
	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
		
	$obs=trim(quitar_tildes($_GET["obs"]));

	if ($_GET["modo_gru"]=="D"){
		$tiempo_gru1 = "00:00:00";
		$tiempo_gru2 = $_GET["tiempo_gru"];
	}else{
		$tiempo_gru2 = "0";
		$tiempo_gru1 = $_GET["tiempo_gru"];
	}
	

	$i=0;
	
		echo "<table width='100%' border='0'>";
		echo "<tr>";
			echo "<td class='cabeceras_grid'>CIP</td>";
			echo "<td class='cabeceras_grid'>DNI</td>";
			echo "<td class='cabeceras_grid'>N.COMPLETO</td>";
			echo "<td class='cabeceras_grid'>HORARIO</td>";
			echo "<td class='cabeceras_grid'>ENTRADA</td>";
			echo "<td class='cabeceras_grid'>SALIDA</td>";
			echo "<td class='cabeceras_grid'>INI.INC</td>";
			echo "<td class='cabeceras_grid'>FIN.INC</td>";
			echo "<td class='cabeceras_grid'>DIF.</td>";
			
		echo "</tr>";
		
		
	
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {
		
		/* tranformo las fechas de horario */
		$c0="select * from horarios_cot where dni='".$dni_escogidos[$i]."' ORDER BY 1 DESC LIMIT 1";
		//echo "<br>".$c0;
		$res_c0= mysql_query($c0);
		$reg_c0 = mysql_fetch_row($res_c0);
		
			
				
						
				$fec_hor_f1 = explode("[",$reg_c0[6]);
				$fec_hor_f1= $fec_hor_f1[1];
				$fec_hor_f2 = explode("-",$fec_hor_f1);
				
				
				if (substr($fec_hor_f2[1],5,1)=="]"){
					$fec_hor_fin	= trim(substr($fec_hor_f2[1],0,5));
				}else{
					$fec_hor_fin	= trim(substr($fec_hor_f2[1],1,5));
					}
		
				$fec_fin = trim(substr($fec_fin_,11,5));
		
				//echo $fec_hor_fin."|".$fec_fin."|";
		/*************/
	
		
		/*****muestra listado ****/
		
		//echo $dni_escogidos[$i]." ".$valida1."|";
		$hor ="select * from horario_cot_mes where dni='$dni_escogidos[$i]'";
		//echo $hor;
		$res_hor = mysql_query($hor);
		
	
		
		while($reg_hor=mysql_fetch_row($res_hor)){	
		
			$ch1="select * from tb_usuarios where dni='$reg_hor[10]'";
			$res_ch1 = mysql_query($ch1);
			$reg_ch1=mysql_fetch_row($res_ch1);
		
		
				
			echo "<tr>";
			echo "<td class='caja_texto_pe'>$reg_ch1[2]</td>";
			echo "<td class='caja_texto_pe'>$reg_ch1[3]</td>";
			echo "<td class='caja_texto_pe'>$reg_ch1[1]</td>";
			echo "<td class='caja_texto_pe'>$reg_hor[4]-$reg_hor[6]</td>";
			
			$p_ini 	= explode("[",$reg_hor[6]);
			$ini 	= substr($p_ini[1],1,5);
			
				if (substr($p_ini[1],5,1)=="-"){
					$ini 	= substr($p_ini[1],1,4);
				}else{
					$ini 	= substr($p_ini[1],1,5);
				}
							
			$p_fin  = explode("-",$p_ini[1]);
			//echo substr($p_fin[1],5,1);
		
			if (substr($p_fin[1],5,1)=="]"){
				$fin 	= substr($p_fin[1],0,5);
			}else{
				$fin 	= substr($p_fin[1],1,5);
				}
			
			
				
			/* primera validacion */	
				if ($fec_hor_fin < $fec_fin){  // hora fin mayor a la fecha de horario
					$valida1 =  "NO GRABO"; 
					$fec_fin_nueva = substr($fec_fin_,0,11)." ".$fin;
					$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_','$fec_fin_nueva'))*60) as dif";
				}else{
					$valida1 = "GRABO";
					$fec_fin_nueva = $fec_fin_;
					$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_','$fec_fin_nueva'))*60) as dif";
					
				}
		
		
				
			
			//echo $calc;
			$rs_calc = mysql_query($calc);														
			$rg_calc = mysql_fetch_row($rs_calc);	
			
			
			$ini_inc=substr($fec_ini_,11,6);
			$fin_inc=substr($fec_fin_nueva,11,6);
			
			echo "<td class='caja_texto_pe'>$ini</td>";
			echo "<td class='caja_texto_pe'>$fin</td>";
			echo "<td class='caja_texto_pe'>$ini_inc</td>";
			echo "<td class='caja_texto_pe'>$fin_inc</td>";
			echo "<td class='caja_texto_pe'>$rg_calc[0]</td>";
			echo "</tr>";
			}		
	}
	
	echo "</table>";
	
	
	
	
	
	/*
	for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {		
		
		$sql_1="INSERT INTO cab_incidencia
		(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,cod_incidencia,
		c_doid,dni,dias,nro_participantes)
		VALUES	
		('','$cip',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$fec_ini_','$fec_fin_','$obs_gru','$tiempo_gru1','$modo_gru','$c_incidencia',
		'$c_doid_gru','$dni_escogidos[$i]','$tiempo_gru2','')";
		//echo "<br>".$sql_1;	
		$res_1= mysql_query($sql_1);	
	
		
		$sql_2="INSERT INTO movimiento_usuarios(id,proceso,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'ACTUALIZACION DE USUARIO WEB GESCOT','$iduser',now(),
		'SE ACTUALIZO MASIVAMENTE LOS DNI $dni_escogidos[$i]','$pc','$dni_escogidos[$i]')";
		//echo $sql_2;
		$res_2= mysql_query($sql_2);
		
		$sql_3	= "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
		$sql_3 	= mysql_query($sql_3) or die(mysql_error());
		
		
		$sql_4="update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and a.dni='$dni_escogidos[$i]' and a.cod_incidencia='$c_incidencia'";
		//echo $sql_3;
		$res_4= mysql_query($sql_4);
		
		
	} 
	
	  */
}


if ($accion=="grabar_incidencia_masiva"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$c_incidencia=limpia_espacios($_GET["c_incidencia"]);
	$c_supervisor=$_GET["c_supervisor"];
	$c_mot_mas=$_GET["c_mot_mas"];
	$c_mot_inc_mas=$_GET["c_mot_inc_mas"];
	$modo_mas=$_GET["modo_mas"];
	
	$obs_mas=trim($_GET["obs_mas"]);
	$c_doid_mas=$_GET["c_doid_mas"];	
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];

	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
		
	$obs=trim(quitar_tildes($_GET["obs"]));

	if ($_GET["modo_mas"]=="D"){
		$tiempo_mas1 = "00:00:00";
		$tiempo_mas2 = $_GET["tiempo_mas"];
	}else{
		$tiempo_mas2 = "0";
		$tiempo_mas1 = $_GET["tiempo_mas"];
	}
	
	
	$sql_0="select dni from tb_usuarios where c_supervisor='$c_supervisor'";
	//echo "<br>".$sql_0;	
	$rs_0 = mysql_query($sql_0);

	
	$i=0;
	
	while($reg_0 = mysql_fetch_row($rs_0)){	
		
		
		$dni = $reg_0[0];
					
		$sql_1="INSERT INTO cab_incidencia
		(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,tiempo,modo,cod_incidencia,
		c_doid,dni,dias,nro_participantes)
		VALUES	
		('','$cip',now(),'$iduser','$c_mot_mas','$c_mot_inc_mas','$fec_ini_','$fec_fin_','$obs_mas','$tiempo_mas1','$modo_mas','$c_incidencia',
		'$c_doid_mas',$dni,'$tiempo_mas2','')";
		echo "<br>".$sql_1;	
		$res_1= mysql_query($sql_1);
			
		$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,pc,dato)
		VALUES(LAST_INSERT_ID(),'REGISTRO DE INCIDENCIA','$iduser',now(),
		'','$pc','$c_incidencia')";
		//echo $sql_2;
		$res_2= mysql_query($sql_2);
		
		$sql_3	= "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
		$sql_3 	= mysql_query($sql_3) or die(mysql_error());
		
		
		$sql_4="update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and b.dni='$dni' and a.cod_incidencia='$c_incidencia'";
		//echo "<br>".$sql_3;
		$res_4= mysql_query($sql_4);
		
	
		
	} 
	
 
}

if ($accion=="listar_bandeja_gestores"){

$f_actual=date("Y-m-d");
$valor=$_GET["valor"];
$idperfil=$_GET["idperfil"];
$iduser=$_GET["iduser"];

if ($valor=="0"){
	$cad="";
}else{
	$cad=" and c_supervisor='$valor'";
}
if ($idperfil == 1){
	$cad=$cad." and iduser='$iduser'";
}	
$lista="select iduser,ncompleto,dni,cip,c_supervisor,c_monitor,local,ola from 
tb_usuarios where estado='HABILITADO'
$cad ORDER BY ncompleto";
//echo $lista;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' class='marco_tabla'>";	
	
	echo "<tr>
		<td colspan='9'>
		<a class='aviso_horario'>Nota Importante: </a>
		<a class='caja_sb'>Si los horarios aparecen como DESHABILITADO signfica que no tienen horario asignado, por lo tanto 
		Se tienen comunicar con Torre de Control para que se regularice y pueda aparecer su horario. 
		La GESCOT no registra,ni actualiza ni elimina horarios del personal COT</a>
		</td>
	</tr><p>";
	if($idperfil != 1){
		echo "<tr>
				<td colspan='4'>
				<a href='javascript:seleccionar_incidencia_todo()'>Marcar todos</a> |
				<a href='javascript:deseleccionar_incidencia_todo()'>Marcar ninguno</a>				
				</td>
		</tr>";
	} else {
		echo "<tr>
				<td colspan='4'>
				</td>
		</tr>";
	}
				
		echo "<tr>";
		echo "<td colspan='2' class='caja_texto_pekecab'>...</td>";				
		echo "<td class='caja_texto_pekecab'>CIP</td>";						
		echo "<td class='caja_texto_pekecab'>DNI</td>";							
		echo "<td class='caja_texto_pekecab'>NOMBRE COMPLETO</td>";
		echo "<td class='caja_texto_pekecab'>SUPERVISOR</td>";
		echo "<td class='caja_texto_pekecab'>C.HORARIO</td>";	
		echo "<td class='caja_texto_pekecab'>HORARIO</td>";		
		echo "<td class='caja_texto_pekecab'>OBS.</td>";	
		echo "</tr>";
	$i=0;
	while($reg_lis=mysql_fetch_row($res_lis)){	
	
		$s="select nom_supervisor from tb_supervisores where cod_supervisor='".$reg_lis[4]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$m="select nom_monitor from tb_monitores where cod_monitor='".$reg_lis[5]."'";
		//echo $s;
		$rs_m = mysql_query($m);											
		$rg_m = mysql_fetch_row($rs_m);
		
		$lo="select nom_local from tb_locales where cod_local='".$reg_lis[6]."'";
		//echo $s;
		$rs_lo = mysql_query($lo);											
		$rg_lo = mysql_fetch_row($rs_lo);
		
		$hor="select * from horarios_gestores_cot where dni='".$reg_lis[2]."'";
		//echo $hor;
		$rs_hor = mysql_query($hor);											
		$rg_hor = mysql_fetch_row($rs_hor);
					
		echo "<tr>";	
		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$i = $i + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
		echo "<td class='caja_texto_peq'>$i</td>";
			
		echo "<td class='caja_texto_peq'>";		
		//echo "check".$i."|".$reg[2];
		if ($idperfil=="0"){
			$marcar="";
		}else{
			if ($rg_hor[10]=="SI"){
				//$marcar="disabled"; vacaciones	
				$marcar="";	
			}else{
				if ($rg_hor[5]=="S/H"){
					$marcar="disabled";	
				}else{
					$marcar="enabled";	
				}
			}
		}
		?>
			 <input type="checkbox" name="<?php echo "check".$i; ?>" id="<?php echo "check".$i; ?>" 
             value="<?php echo $reg_lis[2]; ?>" 
			onclick="javascript:escojer_gestor_inc()"  <?php echo $marcar; ?>/>
			<?php			
		//echo $reg_lis[2]; 	
		echo "</td>";
		
		
		echo "<td class='caja_texto_peq'>";		//CIP		
		echo $reg_lis[3]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";		//dni		
		echo $reg_lis[2]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";
		echo utf8_encode($reg_lis[1]); 		//NOMBRE	
		echo "</td>";
		
		/*	
		echo "<td>";		//DNI		
		echo $reg[2]; 				
		echo "</td>";
		*/
		
		echo "<td class='caja_texto_peq'>";		// SUPERVISOR		
		echo $rg_s[0]; 				
		echo "</td>";
		
		if ($rg_hor[5]==""){
			$c_hor ="S/H";
			$n_hor ="SIN HORARIO";
		}else{
			$c_hor =$rg_hor[5];
			$n_hor =$rg_hor[6];
		}
		echo "<td class='caja_texto_peq'>";		// C HORARIO		
		echo $c_hor; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peq'>";		// HORARIO		
		echo $n_hor; 				
		echo "</td>";
		
		if ($rg_hor[10]=="SI"){
		echo "<td class='caja_texto_color'>";		// HORARIO		
		echo "VACACIONES"; 				
		echo "</td>";
		}else{
			if ($rg_hor[5]=="S/H"){
			echo "<td class='caja_texto_peq'>";		// HORARIO		
			echo "DESHABILITADO"; 				
			echo "</td>";
			}else{
			echo "<td class='caja_texto_peq'>";		// HORARIO		
			echo "HABILITADO"; 				
			echo "</td>";
			}
		}
		
		echo "</tr>";				
		}	
	echo "</table>";	
}


if($accion=="grabar_movimientos_usuarios_n"){

	$iduser		= $_GET["iduser"]; 
	$xid_ant	=$_GET["xid_ant"]; 
	$xdni_mov	=$_GET["xdni_mov"]; 
	$xcip_mov	=$_GET["xcip_mov"]; 
	$xusu_mov	=$_GET["xusu_mov"]; 
	$xapli_mov	=$_GET["xapli_mov"]; 
	$xfec_mov	=$_GET["xfec_mov"]; 
	
	
	$sql0	="SELECT * FROM movimientos_maestra WHERE dato='$xusu_mov' and aplicativo='$xapli_mov'";
	//echo $sql0;
	$rs_0 	= mysql_query($sql0);
	$rg_0 	= mysql_fetch_array($rs_0);
	$nrg	= mysql_num_rows($rs_0);
	
	//echo "<br>".$nrg;
	
	if ($nrg > 0){
		echo "EL USUARIO $xusu_mov YA SE ENCUENTRA REGISTRADO CON EL APLICATIVO $xapli_mov";	
	}else{
	
		$sql1="update movimientos_maestra set est='DESACTIVADO',fec_fin='$xfec_mov',usu_mov='$iduser',obs_mov='' where id='$xid_ant'";
		//echo $sql1;
		$res_sql1 = mysql_query($sql1);
	
		$sql2="insert into movimientos_maestra values('','$xdni_mov','$xusu_mov','$xapli_mov','ACT. USUARIO',now(),'$xfec_mov','2050-01-01','$iduser','','CREADO')";
		//echo "<br>".$sql2;
		$res_sql2 = mysql_query($sql2);
		
		echo "Se registro correctamente";
	}


}

if($accion=="mostrar_horarios_gestores"){
	
	$nro_escogidos=$_GET["nro_escogidos"];	
	$hor_gestores = explode("|", $_GET["hor_gestores"]);	
	
	
	
	echo "<table width='100%' border='0'>";
		echo "<tr>";
			echo "<td class='cabeceras_grid'>CIP</td>";
			echo "<td class='cabeceras_grid'>DNI</td>";
			echo "<td class='cabeceras_grid'>N.COMPLETO</td>";
			echo "<td class='cabeceras_grid'>HORARIO</td>";
			echo "<td class='cabeceras_grid'>H.ENTRADA</td>";
			echo "<td class='cabeceras_grid'>H.SALIDA</td>";
			echo "<td class='cabeceras_grid'>INC.DEL DIA</td>";
			echo "</tr>";
		
		
	for ($i = 0; $i < $nro_escogidos + 1 ; $i++) {
		
		$hor ="select * from horarios_gestores_cot where dni='$hor_gestores[$i]' group by 2 ";
		//echo $hor;
		$res_hor = mysql_query($hor);	
		
		
		while($reg_hor=mysql_fetch_row($res_hor)){	
		
			$hoy = date("Y-m-d");
			$ch2="select * from horarios_rrhh where cod_horario='$reg_hor[5]'";
			//echo $ch2;
			$res_ch2 = mysql_query($ch2);
			$reg_ch2=mysql_fetch_row($res_ch2);
			
			$conta_d	 = "SELECT COUNT(*) FROM cab_incidencia WHERE dni='$hor_gestores[$i]' AND SUBSTR(fec_reg,1,10)='$hoy'";
			//echo $conta_d;
			$res_conta_d = mysql_query($conta_d);
			$reg_conta_d = mysql_fetch_row($res_conta_d);
			
			
			echo "<tr>";
			echo "<td class='caja_texto_pe'>$reg_hor[1]</td>";
			echo "<td class='caja_texto_pe'>$reg_hor[0]</td>";
			echo "<td class='caja_texto_pe'>".utf8_encode($reg_hor[2])."</td>";
			echo "<td class='caja_texto_pe'>$reg_ch2[2]</td>";	
			echo "<td class='caja_texto_pe'>$reg_ch2[5]</td>";
			echo "<td class='caja_texto_pe'>$reg_ch2[6]</td>";	
			
			if ($reg_conta_d[0] > 0){				
				echo "<td class='caja_texto_pe' align='center' >";
			?>				
			<a class="aviso_horario" onclick="popup_reclamo('13','<?php echo $hor_gestores[$i]; ?>','<? echo $iduser; ?>','','','')" ><?php echo $reg_conta_d[0]; ?> </a>
            </td>
			<?php 
			}else{				
				echo "<td class='caja_texto_pe'>$reg_conta_d[0]</td>";	
			}
			/*
			$p_ini 	= explode("[",$reg_hor[6]);
			$ini 	= substr($p_ini[1],1,5);
			
				if (substr($p_ini[1],5,1)=="-"){
					$ini 	= substr($p_ini[1],1,4);
				}else{
					$ini 	= substr($p_ini[1],1,5);
				}
							
			$p_fin  = explode("-",$p_ini[1]);
			//echo substr($p_fin[1],5,1);
			
			if (substr($p_fin[1],5,1)=="]"){
				$fin 	= substr($p_fin[1],0,5);
			}else{
				$fin 	= substr($p_fin[1],1,5);
				}
			*/
		
			echo "</tr>";
		}
		
	}
	echo "</table>";
}


if ($accion=="grabar_horarios_gestores_resp"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$c_incidencia=limpia_espacios($_GET["c_incidencia"]);	
	$modo_gru=$_GET["modo_gru"];
	$dni_escogidos = explode("|", $_GET["dni_escogidos"]);	
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	$dia =  date("d");			
	$nro_escogidos=$_GET["nro_escogidos"];
	$c_mot_inc_gru=$_GET["c_mot_inc_gru"];		
	$c_doid_gru=$_GET["c_doid_gru"];	
	$c_inc=$_GET["c_inc"];	
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];
	
	
	
	
			if ($_GET["modo_gru"]=="H"){  // Si modo es HORAS
				
					$i=0;
			
				echo "<table width='100%' border='0'>";
				echo "<tr>";			
					echo "<td class='cabeceras_grid'>TRABAJADOR</td>";
					echo "<td class='cabeceras_grid'>HORARIO</td>";
					echo "<td class='cabeceras_grid'>ENTRADA</td>";
					echo "<td class='cabeceras_grid'>SALIDA</td>";
					echo "<td class='cabeceras_grid'>INI.INC</td>";
					echo "<td class='cabeceras_grid'>FIN.INC</td>";
					echo "<td class='cabeceras_grid'>DIF.</td>";
					echo "<td class='cabeceras_grid'>OBS</td>";
					
				echo "</tr>";
				
				
					
					for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {
						
					
						$hor ="select * from horario_cot_mes where dni='$dni_escogidos[$i]'";
						//echo $hor;
						$res_hor = mysql_query($hor);
						
					
						
						while($reg_hor=mysql_fetch_row($res_hor)){	
						
							$ch1="select * from tb_usuarios where dni='$reg_hor[10]'";
							$res_ch1 = mysql_query($ch1);
							$reg_ch1=mysql_fetch_row($res_ch1);
						
								$fec_hor_ini_p= explode("[",$reg_hor[6]);
								$fec_hor_ini_p= $fec_hor_ini_p[1];
								$fec_hor_ini_p = explode("-",$fec_hor_ini_p);
								$fec_hor_ini = $fec_hor_ini_p[0];
								
								$fec_hor_f1 = explode("[",$reg_hor[6]);
								$fec_hor_f1= $fec_hor_f1[1];
								$fec_hor_f2 = explode("-",$fec_hor_f1);
								
					/**************************/
					
					//echo $fec_hor_ini."|".
								$fec_ini_inc=substr($fec_ini_,11,5);
					
								
								if (substr($fec_hor_f2[1],5,1)=="]"){
									$fec_hor_fin	= trim(substr($fec_hor_f2[1],0,5));
								}else{
									$fec_hor_fin	= trim(substr($fec_hor_f2[1],1,5));
									}
						
								$fec_fin_inc = trim(substr($fec_fin_,11,5));
						
							
							$p_ini 	= explode("[",$reg_hor[6]);
							
							//$ini 	= substr($p_ini[1],1,5);
							
								if (substr($p_ini[1],5,1)=="-"){
									$ini 	= substr($p_ini[1],1,4);
								}else{
									$ini 	= substr($p_ini[1],1,5);
								}
											
							$p_fin  = explode("-",$p_ini[1]);
							//echo substr($p_fin[1],5,1);
						
							if (substr($p_fin[1],5,1)=="]"){
								$fin 	= substr($p_fin[1],0,5);
							}else{
								$fin 	= substr($p_fin[1],1,5);
								}
							
							
							if ( $fec_ini_inc <= $fec_hor_ini  and $fec_fin_inc >= $fec_hor_fin ) { // fuera de rango al inicio y al final
								$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
								$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;				
								$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
								$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
								
								$n_ini_inc = $fec_hor_ini;
								$n_fin_inc = $fec_hor_fin;
								$val_ini_inc = substr($fec_ini_,0,11).$fec_hor_ini;
								$val_fin_inc = substr($fec_fin_,0,11).$fec_hor_fin;
								
								$calc="select 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_1','$fec_fin_nueva_1'))*60) as dif_fin, 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_2','$fec_ini_nueva_1'))*60) as dif_ini";
								
								$obs_="Error: Fechas de incidencias fuera de rango de Fechas Horarios";	
								
												
							}else{ 
								
								if ($fec_ini_inc  >=$fec_hor_ini  and $fec_fin_inc >= $fec_hor_fin) { // fuera de rango al final
								$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
								$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fin_inc;				
								$fec_ini_nueva_2 = substr($fec_fin_,0,11)." "."00:00";
								$fec_fin_nueva_2 = substr($fec_ini_,0,11)." "."00:00";
										
								$n_ini_inc = $fec_ini_inc;
								$n_fin_inc = $fec_hor_fin;
								$val_ini_inc = substr($fec_ini_,0,11).$fec_ini_inc;
								$val_fin_inc = substr($fec_fin_,0,11).$fec_hor_fin;
								
								$calc="select 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_','$fec_fin_nueva_1'))*60) as dif_fin";
								
								$obs_="Error: Rango de fecha fin de incidencias exceden a las fechas fin de su horario";
												
									
								}else{ 
									
									if ($fec_ini_inc  >= $fec_hor_ini and $fec_fin_inc<=$fec_hor_fin ) {  // dentro del rango
										$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
										$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;				
										$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
										$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
																
										$n_ini_inc = $fec_ini_inc;
										$n_fin_inc = $fec_fin_inc;
										$val_ini_inc = substr($fec_ini_,0,11).$fec_ini_inc;
										$val_fin_inc = substr($fec_fin_,0,11).$fec_fin_inc;
										
										$calc="select 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_2','$fec_fin_nueva_2'))*60) as dif_ini";	
										
										$obs_="OK : Fechas de incidencias dentro de las fechas de horarios";
										
									}else{ // fuera de rango al inicio
										
										$fec_fin_nueva_1 = substr($fec_fin_,0,11)." "."00:00";
										$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;					
										$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
										$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
														
										$n_ini_inc = $fec_hor_ini;
										$n_fin_inc = $fec_fin_inc;
										$val_ini_inc = substr($fec_ini_,0,11).$fec_hor_ini;
										$val_fin_inc = substr($fec_fin_,0,11).$fec_fin_inc;
										
										$calc="select 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_1','$fec_fin_nueva_2'))*60) as dif_ini";
										
										$obs_="Error: Rango de fecha Inicial de incidencias exceden a las fechas Inicio de su horario";
									}
								}
							}
							
							//echo $fec_hor_ini ."|". $fec_ini_inc ."|". $fec_hor_fin ."|". $fec_fin."|".$calc;
							
							//echo $calc;
							$res_calc = mysql_query($calc);
							$reg_calc = mysql_fetch_row($res_calc);
							
							//echo "<br>".$dif;
							
							//$ini_inc=substr($fec_ini_,11,6);
							$ini_inc=substr($fec_ini_nueva,11,6);
							$fin_inc=substr($fec_fin_nueva,11,6);
							
							
							if ($cond=="a"){
								$dif = $reg_calc[0] + $reg_calc[1];	
							}else{
								$dif = $reg_calc[0];	
							}
							
							
									
							echo "<tr>";							
							echo "<td class='caja_texto_pe'>$reg_ch1[2] - $reg_ch1[1]</td>";
							echo "<td class='caja_texto_pe'>$reg_hor[4]-$reg_hor[6]</td>";
							echo "<td class='caja_texto_pe'>$ini</td>";
							echo "<td class='caja_texto_pe'>$fin</td>";
							echo "<td class='caja_texto_pe'>$n_ini_inc</td>";
							echo "<td class='caja_texto_pe'>$n_fin_inc</td>";
							echo "<td class='caja_texto_pe'>$dif</td>";
							echo "<td class='caja_texto_pe'>$obs_</td>";
							echo "</tr>";
							
							
													
							$obs_gru = trim($_GET["obs_gru"])."|".$obs_;
							
							
						/******************GRABAR EN LAS TABLAS***************************************/
									
								if ($dni_escogidos[$i]<>""){	// grabar si dni es diferente a vacio
								$sql_1="INSERT INTO cab_incidencia
								(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,
								obs_incidencia,tiempo,modo,cod_incidencia,
								c_doid,dni,dias,nro_participantes)
								VALUES	
								('','$cip',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$val_ini_inc','$val_fin_inc','$obs_gru',
								'$dif','$modo_gru','$c_incidencia',
								'$c_doid_gru','$dni_escogidos[$i]','$tiempo_gru2','')";
								//echo "<br>".$sql_1;	
								$res_1= mysql_query($sql_1);	
							
								
								$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,pc,dato)
								VALUES(LAST_INSERT_ID(),'REGISTRO DE INCIDENCIA','$iduser',now(),
								'','$pc','$c_incidencia')";
								//echo $sql_2;
								$res_2= mysql_query($sql_2);
								
								$sql_3	= "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') 
								WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
								$sql_3 	= mysql_query($sql_3) or die(mysql_error());
								
								
								$sql_4="update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and a.dni='$dni_escogidos[$i]' 
								and a.cod_incidencia='$c_incidencia'";
								//echo $sql_4;
								$res_4= mysql_query($sql_4);
								}		
					
					/***************************/
					}
					
					echo "</table>";	
					}
			}else{  // si modo es DIAS
			
				$c_mot_gru=$_GET["c_mot_gru"];
				$c_mot_inc_gru=$_GET["c_mot_inc_gru"];
				$obs_gru=trim($_GET["obs_gru"]);
				$c_doid_gru=$_GET["c_doid_gru"];	
				$nro_escogidos=$_GET["nro_escogidos"];
				$c_inc=$_GET["c_inc"];	
				$opc=$_GET["opc"];
				$combo=$_GET["combo"];
			
			
				$fec_ini_inc	=$_GET["fec_ini"];	
				$fec_fin_inc	=$_GET["fec_fin"];
				
				$dif_1 ="select datediff('$fec_fin_inc','$fec_ini_inc')";
				//echo $dif_1;
				$res_dif_1 = mysql_query($dif_1);
				$reg_dif_1 = mysql_fetch_row($res_dif_1);
				
				echo "<table width='100%' border='0'>";
				
				echo "<tr>";			
					echo "<td class='cabeceras_grid'>TRABAJADOR</td>";
					echo "<td class='cabeceras_grid'>HORARIO</td>";			
					echo "<td class='cabeceras_grid'>INI.INC</td>";
					echo "<td class='cabeceras_grid'>FIN.INC</td>";
					echo "<td class='cabeceras_grid'>DIF.</td>";					
				echo "</tr>";
				
				
				
				for ($j = 1; $j<$nro_escogidos + 1 ; $j++) {
					
					$hor="select * from horarios_cot where dni='".$dni_escogidos[$j]."' ORDER BY 1 DESC LIMIT 1";
					//echo "<br>".$c0;
					$res_hor= mysql_query($hor);
								
					while($reg_hor=mysql_fetch_row($res_hor)){	
					
						$ch1		="select * from tb_usuarios where dni='$reg_hor[10]'";
						//echo $ch1;
						$res_ch1 	= mysql_query($ch1);
						$reg_ch1	= mysql_fetch_row($res_ch1);
					
						echo "<tr>";			
						echo "<td class='cabeceras_grid'>$reg_ch1[2] - $reg_ch1[1]</td>";
						echo "<td class='cabeceras_grid'>$reg_hor[6]</td>";			
						echo "<td class='cabeceras_grid'>$fec_ini_inc</td>";
						echo "<td class='cabeceras_grid'>$fec_fin_inc</td>";
						echo "<td class='cabeceras_grid'>$reg_dif_1[0]</td>";					
						echo "</tr>";
						
						$hor_r		="select * from horarios_rrhh where cod_horario='$reg_hor[4]'";
						
						$res_hor_r 	= mysql_query($hor_r);
						$reg_hor_r	= mysql_fetch_row($res_hor_r);
						
							
						/************************************/
									
						$date1 = $fec_ini_inc;
						$date2 = $fec_fin_inc;
						
						$diff = $reg_dif_1[0];
						
						//echo $diff;
						$d=0;									
						for ($contador = 0; $contador < $diff + 1; $contador++) {
										$d=$d+1;
									
										$NombreDia=get_nombre_dia($date1);
										$NombreCorto=substr($NombreDia, 0, 2);
										$validar=Obtener_valor($NombreCorto,$reg_hor_r[7]);
										$FEC_Ini=$date1." ".$reg_hor_r[5];
										$FEC_Fin=$date1." ".$reg_hor_r[6];
										
										
										//echo $NombreCorto."|".$reg_hor_r[7]."|";	
										
										//echo "fechaini".$FEC_Ini."|";
										//echo "fechafin".$FEC_Fin."|";
										
										
										echo $validar."|";
										
										
										if ($validar==1){
							
										$sql = "INSERT INTO cab_incidencia
												(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
												fec_fin_inc,obs_incidencia,tiempo,modo,cod_incidencia,										
												c_doid,dni,dias,nro_participantes)
												VALUES	
												('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini','$FEC_Fin',
												'$obs_gru',
												'08:30','$modo_gru','$c_incidencia',
												'$c_doid_gru','$dni_escogidos[$j]','1','')";
										//echo $sql;
										$res_sql 	= mysql_query($sql);
										
										}
										//print "<p>$contador</p>\n";
										$date1 = date("Y-m-d",strtotime($date1."+ 1 days"));
										//print "<p>$date1</p>\n";
							} //cierre for
													
							/***********************************/
						
					} // cierre while
					
								
				}// cierre for
				
			}// cierre ifelse
			
}


if ($accion=="validar_horarios_incidencias"){
	
	$modo_gru=$_GET["modo_gru"];		
	$dni_escogidos = explode("|", $_GET["dni_escogidos"]);		
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	$nro_escogidos=$_GET["nro_escogidos"];
	

	$valida="select datediff(curdate() + 1,'$fec_ini_')";
	
	$res_valida= mysql_query($valida);
	$reg_valida = mysql_fetch_row($res_valida);
	
	$dia =  date("d");

	if ($reg_valida[0] > 60 ){   // VALIDA SI ES MAYOR A 2 DIAS
		echo "0|Atencion: Solo se puede registrar incidencias con 2 dias de anterioridad";
	} else {
			if ($_GET["modo_gru"]=="H"){  // Si modo es HORAS
			
				$i=0;			
					for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {
						
						/* tranformo las fechas de horario */
						$c0="select * from horarios_cot where dni='".$dni_escogidos[$i]."' ORDER BY 1 DESC LIMIT 1";
						//echo "<br>".$c0;
						$res_c0= mysql_query($c0);
						$reg_c0 = mysql_fetch_row($res_c0);
						
									
								$fec_hor_ini_p= explode("[",$reg_c0[6]);
								$fec_hor_ini_p= $fec_hor_ini_p[1];
								$fec_hor_ini_p = explode("-",$fec_hor_ini_p);
								$fec_hor_ini = $fec_hor_ini_p[0];
								
								$fec_hor_f1 = explode("[",$reg_c0[6]);
								$fec_hor_f1= $fec_hor_f1[1];
								$fec_hor_f2 = explode("-",$fec_hor_f1);
								
					/**************************/
					
					//echo $fec_hor_ini."|".
								$fec_ini_inc=substr($fec_ini_,11,5);
					
								
								if (substr($fec_hor_f2[1],5,1)=="]"){
									$fec_hor_fin	= trim(substr($fec_hor_f2[1],0,5));
								}else{
									$fec_hor_fin	= trim(substr($fec_hor_f2[1],1,5));
									}
						
								$fec_fin_inc = trim(substr($fec_fin_,11,5));
								
						/*****muestra listado ****/		
						
						$hor ="select * from horario_cot_mes where dni='$dni_escogidos[$i]'";
						//echo $hor;
						$res_hor = mysql_query($hor);
						
					
						
						while ($reg_hor=mysql_fetch_row($res_hor)) {	
						
							$ch1="select * from tb_usuarios where dni='$reg_hor[10]'";
							$res_ch1 = mysql_query($ch1);
							$reg_ch1=mysql_fetch_row($res_ch1);
							
							$p_ini 	= explode("[",$reg_hor[6]);
							
							//$ini 	= substr($p_ini[1],1,5);
							
								if (substr($p_ini[1],5,1)=="-"){
									$ini 	= substr($p_ini[1],1,4);
								}else{
									$ini 	= substr($p_ini[1],1,5);
								}
											
							$p_fin  = explode("-",$p_ini[1]);
							//echo substr($p_fin[1],5,1);
						
							if (substr($p_fin[1],5,1)=="]"){
								$fin 	= substr($p_fin[1],0,5);
							}else{
								$fin 	= substr($p_fin[1],1,5);
								}
							
							
							if ($fec_ini_inc <=  $fec_hor_ini and $fec_fin_inc >=  $fec_hor_fin ) { // fuera de rango al inicio y al final
								$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
								$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;				
								$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
								$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
								
								$n_ini_inc = $fec_hor_ini;
								$n_fin_inc = $fec_hor_fin;
								$val_ini_inc = substr($fec_ini_,0,11).$fec_hor_ini;
								$val_fin_inc = substr($fec_fin_,0,11).$fec_hor_fin;
								
								/*
								$calc="select 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_1','$fec_fin_nueva_1'))*60) as dif_fin, 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_2','$fec_ini_nueva_1'))*60) as dif_ini";
								*/
								$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$val_ini_inc','$val_fin_inc'))*60) as dif_fin";
								
								$error="0|Nota: Rango de fecha de incidencias exceden a las fechas de su horario";
								
												
							}else{ 
								
								if ($fec_ini_inc >=  $fec_hor_ini and $fec_fin_inc >=  $fec_hor_fin )  { // fuera de rango al final
								$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
								$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fin_inc;				
								$fec_ini_nueva_2 = substr($fec_fin_,0,11)." "."00:00";
								$fec_fin_nueva_2 = substr($fec_ini_,0,11)." "."00:00";
										
								$n_ini_inc = $fec_ini_inc;
								$n_fin_inc = $fec_hor_fin;
								$val_ini_inc = substr($fec_ini_,0,11).$fec_ini_inc;
								$val_fin_inc = substr($fec_fin_,0,11).$fec_hor_fin;
								
								$calc="select 
								SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_','$fec_fin_nueva_1'))*60) as dif_fin";
								
								$error="0|Nota: Rango de fecha fin de incidencias exceden a las fechas fin de su horario";
												
									
								}else{ 
									
									if ($fec_ini_inc >= $fec_hor_ini and  $fec_fin_inc <=$fec_hor_fin)  {  // dentro del rango
										$fec_fin_nueva_1 = substr($fec_fin_,0,11)." ".$fec_hor_fin;
										$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;				
										$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
										$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
																
										$n_ini_inc = $fec_ini_inc;
										$n_fin_inc = $fec_fin_inc;
										$val_ini_inc = substr($fec_ini_,0,11).$fec_ini_inc;
										$val_fin_inc = substr($fec_fin_,0,11).$fec_fin_inc;
										
										$calc="select 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_2','$fec_fin_nueva_2'))*60) as dif_ini";	
										
										$error="1|Nota : Fechas de incidencias dentro de las fechas de horarios";
										
									}else{ // fuera de rango al inicio
										
										$fec_fin_nueva_1 = substr($fec_fin_,0,11)." "."00:00";
										$fec_ini_nueva_1 = substr($fec_ini_,0,11)." ".$fec_hor_ini;					
										$fec_ini_nueva_2 = substr($fec_fin_,0,11)." ".$fec_ini_inc;
										$fec_fin_nueva_2 = substr($fec_ini_,0,11)." ".$fec_fin_inc;
														
										$n_ini_inc = $fec_hor_ini;
										$n_fin_inc = $fec_fin_inc;
										$val_ini_inc = substr($fec_ini_,0,11).$fec_hor_ini;
										$val_fin_inc = substr($fec_fin_,0,11).$fec_fin_inc;
										
										$calc="select 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_nueva_1','$fec_fin_nueva_2'))*60) as dif_ini";
										//echo $calc;
										
										$error="0|Nota: Rango de fecha Inicial de incidencias exceden a las fechas Inicio de su horario";
									}
								}
							}
						
						}							
			
					}		
			}else{
			
				$error="1|";			
			
			}
	}
	
	//echo $calc."|".$valida."|".$reg_valida[0]."|".$_GET["modo_gru"]."<br>";
	//echo  $calc ."|".$fec_hor_ini ."|". $fec_ini_inc ."|". $fec_hor_fin."|".$fec_fin_inc;
	echo trim($error);
}



if ($accion=="listar_bandeja_incidencias"){

$f_actual=date("Y-m-d");
$valor=$_GET["valor"];

if ($valor=="0"){
	$cad="";
}else{
	$cad=" where usu_reg='$valor' and substr(fec_reg,1,7)='2019-10'";
}	
	$lista="select * from cab_incidencia  $cad and estado_inc<>4 group by cod_incidencia";
	echo $lista;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'>";	
	
		echo "<tr>
				<td colspan='10'>
				<a class='caja_sb' href='javascript:seleccionar_incidencia_todo()'>Marcar todos</a> |
				<a class='caja_sb' href='javascript:deseleccionar_incidencia_todo()'>Marcar ninguno</a>				
				</td>
		</tr>";
				
		echo "<tr>";
		echo "<td colspan='2' class='caja_texto_db'>...</td>";				
		echo "<td class='caja_texto_db'>COD.INCIDENCIA</td>";	
		echo "<td class='caja_texto_db'>CIP</td>";						
		echo "<td class='caja_texto_db'>DNI</td>";							
		echo "<td class='caja_texto_db'>NOMBRE COMPLETO</td>";
		echo "<td class='caja_texto_db'>TP.INCIDENCIA</td>";
		echo "<td class='caja_texto_db'>MOTIVO</td>";		
		echo "<td class='caja_texto_db'>HORARIO</td>";
		echo "<td class='caja_texto_db'>MODO</td>";
		echo "<td class='caja_texto_db'>USU.REGISTRO</td>";
		echo "<td class='caja_texto_db'>FEC.INI.INC</td>";
		echo "<td class='caja_texto_db'>FEC.FIN.INC</td>";
		echo "<td class='caja_texto_db'>DIF.</td>";
		echo "<td class='caja_texto_db'>ESTADO</td>";
		echo "</tr>";
	$i=0;
	while($reg_lis=mysql_fetch_row($res_lis)){	
	
		$s="select * from tb_usuarios where dni='".$reg_lis[15]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$m="select * from tb_motivos_incidencia where cod_mot_inc='".$reg_lis[5]."'";
		//echo $s;
		$rs_m = mysql_query($m);											
		$rg_m = mysql_fetch_row($rs_m);
		
		$hor="select * from horarios_gestores_cot where dni='".$reg_lis[15]."'";
		//echo $s;
		$rs_hor = mysql_query($hor);											
		$rg_hor = mysql_fetch_row($rs_hor);
		

		$usu_reg="select * from tb_usuarios where iduser='".$reg_lis[3]."'";
		//echo $s;
		$rs_usu_reg = mysql_query($usu_reg);											
		$rg_usu_reg = mysql_fetch_row($rs_usu_reg);
					
	
		echo "<tr>";	
		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$i = $i + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
		echo "<td class='caja_texto_pe'>$i</td>";
			
		echo "<td class='caja_texto_peke'>";		
		//echo "check".$i."|".$reg[2];
		?>
   		 <input type="checkbox" name="<?php echo "check".$i; ?>" id="<?php echo "check".$i; ?>" value="<?php echo $reg_lis[10]; ?>" 
    	onclick="javascript:escojer_gestor()" /> 
        <?php
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//C.INCIDENCIA		
		echo $reg_lis[10]; 				
		echo "</td>";
	
		echo "<td class='caja_texto_peke'>";		//CIP		
		echo $reg_lis[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//dni		
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		echo $rg_s[1]; 		//NOMBRE	
		echo "</td>";
	
		
		echo "<td class='caja_texto_peke'>";		// tp incidencia		
		echo $reg_lis[4]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		// motivo		
		echo $rg_m[1]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		// HORARIO		
		echo $rg_hor[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//modo		
		echo $reg_lis[13]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//USUREG		
		echo $rg_usu_reg[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//fecini		
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//fecfin		
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		if ($reg_lis[13]=="D"){
			echo $reg_lis[16]; 		
		}else{
			echo $reg_lis[12]; 		
			}
		
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		//ESTADO	
			if ($reg_lis[17]==0){
				echo "PENDIENTE";
			}
			if ($reg_lis[17]==1){
				echo "APROBADO";
			}	
			
			if ($reg_lis[17]==2){
				echo "RECHAZADO";
			}
					
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";	
}


if ($accion=="aprobar_incidencias"){
	
	$iduser			=$_GET["iduser"];		
	$inc_escogidas 	= explode("|", $_GET["inc_escogidas"]);		
	$nro_escogidos	=$_GET["nro_escogidos"];	
	$idperfil			=$_GET["idperfil"];
	$estado	=$_GET["estado"];
	
	
	for ($x = 1; $x < $nro_escogidos + 1 ; $x++) {	
		$cod = trim($inc_escogidas[$x]);
			
		$cad="update cab_incidencia set estado_inc='$estado',usu_mov_est='$iduser',fec_mov_est=now() 
		where cod_incidencia='$cod'";	
		//echo $cad;	
		$rs_hor = mysql_query($cad) or die(mysql_error($cad));	
	}
	
}

if ($accion=="grabar_incidencias_cot"){
	
	$modo_gru=$_GET["modo_gru"];	
	$obs_gru=$_GET["obs_gru"];	
	$dni_escogidos = explode("|", $_GET["dni_escogidos"]);		
	$fec_ini_	=$_GET["fec_ini"];	
	$fec_fin_	=$_GET["fec_fin"];	
	$nro_escogidos=$_GET["nro_escogidos"];
	
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	$xc_incidencia=limpia_espacios($_GET["c_incidencia"]);	
	$c_mot_inc_gru=$_GET["c_mot_inc_gru"];		
	$c_doid_gru=$_GET["c_doid_gru"];	
	$c_inc=$_GET["c_inc"];	
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];

	$valida="select datediff(curdate() + 1,'$fec_ini_')";
	
	$res_valida= mysql_query($valida);
	$reg_valida = mysql_fetch_row($res_valida);
	
	$dia =  date("d");
	
	if ($reg_valida[0] > 60 ){   // VALIDA SI ES MAYOR A 2 DIAS
		echo "0|Atencion: Solo se puede registrar incidencias con 2 dias de anterioridad";
	} else {
		if ($_GET["modo_gru"]=="H") {  // Si modo es HORAS
				$f_ini_inc = explode(" ",$fec_ini_);
				$hor_ini_inc = $f_ini_inc[1];
				$fec_inc = $f_ini_inc[0];
				
				$f_fin_inc = explode(" ",$fec_fin_);
				$hor_fin_inc = $f_fin_inc[1];	
				
				/****************/
				$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
				//echo $cad;
				$rs = mysql_query($cad);
				$rg = mysql_fetch_array($rs);	
				$franq 	= limpia_espacios($rg[0]);
				$c_incidencia = "INC-".$franq;
					
				for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {
						/* tranformo las fechas de horario */
						$c0="select * from horarios_gestores_cot where dni='".$dni_escogidos[$i]."' ORDER BY 1 DESC LIMIT 1";
						//echo "<br>".$c0;
						$res_c0= mysql_query($c0);
						$reg_c0 = mysql_fetch_row($res_c0);
						
						$hor_ini_horario = $reg_c0[8];
						$hor_fin_horario = $reg_c0[9];
								
						/*			
								echo "<br>"."fec.total.ini.incidencia = ".$fec_ini_;
								echo "<br>"."fec.total.fin.incidencia= ".$fec_fin_;
								echo "<br>"."fec.incidencia= ".$fec_inc;
								echo "<br>"."hor.ini.incidencia= ".$hor_ini_inc;
								echo "<br>"."hor.fin.incidencia= ".$hor_fin_inc;
								echo "<br>"."hor_ini_horario = ".$hor_ini_horario;
								echo "<br>"."hor_fin_horario = ".$hor_fin_horario;
						*/
						if ($reg_c0[5]=="") {
							$corr_fec_ini =$fec_ini_;	
							$corr_fec_fin =$fec_fin_;
							$dif_tiempo   = "00:00";
							$error="0|Nota: Sin horarios registrado";									
							$xest = 3;	
						
						} else {
								
								if (
									$hor_ini_inc <=  $hor_ini_horario and 
									$hor_fin_inc >=  $hor_fin_horario
								) { // fuera de rango al inicio y al final
										$nueva_fec_ini_hor = $fec_inc." ".$hor_ini_horario;		
										$nueva_fec_fin_hor = $fec_inc." ".$hor_fin_horario;										
										$nueva_fec_ini_inc= $fec_inc." ".$hor_ini_inc;
										$nueva_fec_fin_inc = $fec_inc." ".$hor_fin_inc;					
										
										$corr_fec_ini = $fec_inc." ".$hor_ini_horario;	
										$corr_fec_fin = $fec_inc." ".$hor_fin_horario;
										/*
										$calc="select 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_ini_inc','$nueva_fec_ini_hor'))*60) as dif_ini, 
										SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_fin_inc','$nueva_fec_fin_hor'))*60) as dif_fin";
										*/
										$calc="select 
											SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$corr_fec_ini','$corr_fec_fin'))*60) as dif";
										
										$error="0|Nota: Rango de fecha de incidencias exceden a las fechas de su horario";
										
										$xest = 0;					
								} else { 
										if ($hor_ini_inc <=  $hor_ini_horario and $hor_fin_inc <= $hor_ini_horario ) { // antes del horario 
												if ($c_mot_gru=="COMPENSACIONES") {
														$nueva_fec_ini_hor = $fec_inc." ".$hor_ini_horario;		
														$nueva_fec_fin_hor = $fec_inc." ".$hor_fin_horario;										
														$nueva_fec_ini_inc= $fec_inc." ".$hor_ini_inc;
														$nueva_fec_fin_inc = $fec_inc." ".$hor_fin_inc;			
														
														$corr_fec_ini = $fec_inc." ".$hor_ini_inc;
														$corr_fec_fin = $fec_inc." ".$hor_fin_inc;
															
														
														$calc="select 
														SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_ini_inc','$nueva_fec_fin_inc'))*60) as dif";
														
														$error="0|Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";
																		
														$xest = 0;		
												} else {
														$corr_fec_ini = "0000-00-00 00:00";	
														$corr_fec_fin = "0000-00-00 00:00";
														$dif_tiempo   = "00:00";
														$error="0|Nota: Las horas de incidencias estan fuera del horario|Se trato de registrar la incidencia 
														con las siguientes horas $hor_ini_inc - $hor_fin_inc";									
														$xest = 3;
												}
										} else {// dentro del rango inicial
												if ($hor_ini_inc <=  $hor_ini_horario and $hor_fin_inc <= $hor_fin_horario ) { //fuera de rango al incio
														$nueva_fec_ini_hor = $fec_inc." ".$hor_ini_horario;		
														$nueva_fec_fin_hor = $fec_inc." ".$hor_fin_horario;										
														$nueva_fec_ini_inc= $fec_inc." ".$hor_ini_inc;
														$nueva_fec_fin_inc = $fec_inc." ".$hor_fin_inc;			
														
														$corr_fec_ini = $fec_inc." ".$hor_ini_inc;
														$corr_fec_fin = $fec_inc." ".$hor_fin_inc;
															
														
														$calc="select 
														SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_ini_inc','$nueva_fec_fin_inc'))*60) as dif";
														
														$error="0|Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";
																		
														$xest = 0;
												} else {
														if ($hor_ini_inc >=  $hor_ini_horario and $hor_fin_inc >= $hor_fin_horario) { // fuera de rango final
																$nueva_fec_ini_hor = $fec_inc." ".$hor_ini_horario;		
																$nueva_fec_fin_hor = $fec_inc." ".$hor_fin_horario;										
																$nueva_fec_ini_inc= $fec_inc." ".$hor_ini_inc;
																$nueva_fec_fin_inc = $fec_inc." ".$hor_fin_inc;			
																
																$corr_fec_ini = $fec_inc." ".$hor_ini_inc;
																$corr_fec_fin = $fec_inc." ".$hor_fin_inc;
																	
																
																$calc="select 
																SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_ini_inc','$nueva_fec_fin_inc'))*60) as dif";
																
																$error="0|Nota: Rango de fecha Final de incidencias exceden a las fechas Final de su horario";
																
																$xest = 0;
													
														} else { // dentro del rango 
																$nueva_fec_ini_hor = $fec_inc." ".$hor_ini_horario;		
																$nueva_fec_fin_hor = $fec_inc." ".$hor_fin_horario;										
																$nueva_fec_ini_inc= $fec_inc." ".$hor_ini_inc;
																$nueva_fec_fin_inc = $fec_inc." ".$hor_fin_inc;			
																
																$corr_fec_ini = $fec_inc." ".$hor_ini_inc;
																$corr_fec_fin = $fec_inc." ".$hor_fin_inc;
																	
																
																$calc="select 
																SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$nueva_fec_ini_inc','$nueva_fec_fin_inc'))*60) as dif";
																
																$error="1|Nota : Fechas de incidencias dentro de las fechas de horarios";
																
																$xest = 0;
														}
												}
										}					   
								}
					  }//cerrar if
					 
						//echo $nueva_fec_fin_inc."|".$nueva_fec_ini_hor."|".$nueva_fec_ini_inc."|".$nueva_fec_fin_hor;	
						//echo $corr_fec_ini."|".$corr_fec_fin;			
						//echo "<br>".$calc;
								
						$res_calc = mysql_query($calc);
						$reg_calc = mysql_fetch_row($res_calc);
						//echo $nueva_fec_fin_inc."|".$nueva_fec_ini_hor."|".$nueva_fec_ini_inc."|".$nueva_fec_fin_hor;	
						//echo $corr_fec_ini."|".$corr_fec_fin;			
						//echo "<br>".$calc;	
						$dif_tiempo = $reg_calc[0];
						
						$observacion = trim($obs_gru) ."#". $error;

						$sql_1=
										"INSERT INTO cab_incidencia
										(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,
										tiempo,modo,cod_incidencia,c_doid,dni,dias,nro_participantes,estado_inc,fec_mov_est,usu_mov_est)
										VALUES	
										('','$cip',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$corr_fec_ini','$corr_fec_fin','$observacion',
										'$dif_tiempo','$modo_gru','$c_incidencia',
										'$c_doid_gru','$dni_escogidos[$i]','0','$nro_escogidos','$xest',now(),'$iduser')";
								//echo "<br>".$sql_1;	
						$res_1= mysql_query($sql_1);	
															
						$sql_2=
									"INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,pc,dato)
											VALUES(LAST_INSERT_ID(),'REGISTRO DE INCIDENCIA','$iduser',now(),
											'','$pc','$c_incidencia')";
								//echo $sql_2;
						$res_2= mysql_query($sql_2);
										
						$sql_3= "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
						$sql_3 	= mysql_query($sql_3) or die(mysql_error());
											
						$sql_4="update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and a.dni='$dni_escogidos[$i]' 
								and a.cod_incidencia='$c_incidencia'";
								//echo $sql_4;
						$res_4= mysql_query($sql_4);
				}//cerrar for
		} else {  // modo DIAS
				/*
				echo "<br>"."fec.total.ini.incidencia = ".$fec_ini_;
				echo "<br>"."fec.total.fin.incidencia= ".$fec_fin_;
				*/
				$fec_ini_inc = $_GET["fec_ini"];
				//Calculo de la marcha blanca
				if ($c_mot_inc_gru=="800" and $modo_gru=="D") {
						//$fec_fin_inc = $_GET["fec_fin"];
						$fec_fin_inc = date("Y-m-d",strtotime($_GET["fec_ini"]."+ 2 month"));
					
				} else {
						$fec_fin_inc = $_GET["fec_fin"];
				}
		    //echo $c_mot_inc_gru."|".$modo_gru."|".$fec_ini_inc."|".$fec_fin_inc;
				//if ($fec_ini_ > $fec_fin_){ //Ricardo Flores
				if ($fec_ini_inc > $fec_fin_inc) { //Ricardo Flores
						$error = "0| Error: La fecha inicial es mayor que la fecha final"; //Ricardo Flores				
				} else { //Ricardo Flores
						if ($fec_ini_inc == $fec_fin_inc) {					
								$dif_1 ="select 0";
						} else {
								$dif_1 ="select datediff('$fec_fin_inc','$fec_ini_inc')";
						}
						//echo $dif_1;
						$res_dif_1 = mysql_query($dif_1);
						$reg_dif_1 = mysql_fetch_row($res_dif_1);
						
						$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
						//echo $cad;
						$rs = mysql_query($cad);
						$rg = mysql_fetch_array($rs);	
						$franq 	= limpia_espacios($rg[0]);
						$c_incidencia = "INC-".$franq;
					
						for ($j = 1; $j < $nro_escogidos + 1 ; $j++) {
								$hor="select * from horarios_gestores_cot where dni='".$dni_escogidos[$j]."' ORDER BY 1 DESC LIMIT 1";
								//echo "<br>".$hor;
								$res_hor= mysql_query($hor);
										
								while ($reg_hor=mysql_fetch_row($res_hor)) {
										$ch1		="select * from tb_usuarios where dni='$reg_hor[0]'";
										//echo $ch1;
										$res_ch1 	= mysql_query($ch1);
										$reg_ch1	= mysql_fetch_row($res_ch1);
									
										$hor_r		="select * from horarios_rrhh where cod_horario='$reg_hor[5]'";
										//echo $hor_r;
										$res_hor_r 	= mysql_query($hor_r);
										$reg_hor_r	= mysql_fetch_row($res_hor_r);

										/************************************/
										$date1 = $fec_ini_inc;
										$date2 = $fec_fin_inc;
										
										$diff = $reg_dif_1[0];
										//echo $diff;
										$d=0;									
										for ($contador = 0; $contador < $diff + 1; $contador++) {
													$d=$d+1;
												
													$NombreDia=get_nombre_dia($date1);
													$NombreCorto=substr($NombreDia, 0, 2);
													$validar=Obtener_valor($NombreCorto,$reg_hor_r[7]);
													$FEC_Ini=$date1." ".$reg_hor_r[5];
													$FEC_Fin=$date1." ".$reg_hor_r[6];
													//echo $NombreCorto."|".$reg_hor_r[7]."|";

													if ($validar==1) {
															$est = "0";
										
															$sql = 
																	"INSERT INTO cab_incidencia
																			(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
																			fec_fin_inc,obs_incidencia,tiempo,modo,cod_incidencia,										
																			c_doid,dni,dias,nro_participantes,estado_inc,fec_mov_est,usu_mov_est)
																	VALUES	
																			('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini',
																			'$FEC_Fin','$obs_gru','06:00:00','$modo_gru','$c_incidencia',
																			'$c_doid_gru','$dni_escogidos[$j]','1','$nro_escogidos','$est',now(),'$iduser')";
															//echo $sql;
															$res_sql 	= mysql_query($sql);
													}// if validar
													$date1 = date("Y-m-d",strtotime($date1."+ 1 days"));
										} //cierre for
																
										/***********************************/
								} // cierre while		
						}// cierre for
				}		//Ricardo Flores
				$error="1|Registro OK";					
		} // cerrar if modo_gru
		
		echo $c_incidencia."|".$error;
	}	// cerrar if tiempo
	$pason="delete from lista_gestores_inc where cod_incidencia='$c_incidencia'";	
		//echo "<br>".$i.$paso2;	
	$res_pason = mysql_query($pason);
}


if ($accion=="agregar_gestores_inc") {
		$iduser=$_GET["iduser"];
		$dni_escogidos=$_GET["dni_escogidos"];
		$nro_escogidos=$_GET["nro_escogidos"];
		$c_inc=$_GET["c_inc"];
		
		$dni_escogidos = explode("|", $dni_escogidos);
		
		$dia=date("Y-m-d");
	
		/*************************************************************/
		$sq_0 ="select count(*) from lista_gestores_inc";
		$rs_0 = mysql_query($sq_0);
		$rg_0 = mysql_fetch_array($rs_0);
	
		if ($rg_0[0]=="0") {
				$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
				//echo $cad;
				$rs = mysql_query($cad);
				$rg = mysql_fetch_array($rs);	
				$franq 	= limpia_espacios($rg[0]);
				$franqueo_ = "INC-".$franq;
			//	echo $franqueo."|".$nro_escogidos."|";	
				
				echo trim($franqueo_);
		} else {
				$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM lista_gestores_inc ORDER BY 1 DESC";
				//echo $cad;
				$rs = mysql_query($cad);
				$rg = mysql_fetch_array($rs);	
				$franq 	= limpia_espacios($rg[0]);
				$franqueo_ = "INC-".$franq;
			//	echo $franqueo."|".$nro_escogidos."|";	
				
				echo trim($franqueo_);	
			/*************************************************************/
		}
		$paso2="insert into lista_gestores_inc(cod_incidencia,usu_reg,fec_reg,est) values('$franqueo_','$iduser',now(),'1') ";	
			//echo "<br>".$i.$paso2;	
		$res_paso2 = mysql_query($paso2);
}

if ($accion=="borrar_incidencia_temp"){
	
	$iduser=$_GET["iduser"];
	$c_incidencia=trim($_GET["c_incidencia"]);
	
	
	$paso		="delete from lista_gestores_inc where cod_incidencia='$c_incidencia'";	
	echo "<br>".$i.$paso;	
	$res_paso 	= mysql_query($paso);
}

if ($accion=="mostrar_bandeja_aprobaciones"){

  $iduser=$_GET["iduser"];
  $est=$_GET["est"];
  $usu_reg=$_GET["usu_reg"];
  $m_actual=date("Y-m");

	$queryGestores = "SELECT c_supervisor,ncompleto,iduser FROM tb_usuarios
	WHERE c_supervisor = '".$usu_reg."' AND estado = 'HABILITADO'";
	$resultado = mysql_query($queryGestores);

	if($num_rows = mysql_num_rows($resultado) == 0){
		echo "<center><h4>NO EXISTEN GESTORES RELACIONADOS</h4></center>";
		exit();
	}
	$usuarios_array = array();
	while ($fila = mysql_fetch_assoc($resultado)) {
		$usuarios_array[] = $fila['iduser'];
	}
	$usuarios_implode = implode(',',$usuarios_array);
  
  if ($est=="T"){
	  $cad =" usu_reg IN (".$usuarios_implode.")";
  } else{
	  $cad =" usu_reg IN (".$usuarios_implode.") AND estado_inc='$est' ";
  }
  
  			$lista="select * from cab_incidencia where $cad
			order by fec_mov_est desc";
			//echo "<br>".$lista;
			$res_lis = mysql_query($lista);
			$nreg = mysql_num_rows($res_lis);
			
			if ($nreg>0){	
		 	echo "<table width='100%'>";	
				
					echo "<tr>
							<td colspan='10'>
							<a class='caja_sb' href='javascript:seleccionar_incidencia_todo()'>Marcar todos</a> |
							<a class='caja_sb' href='javascript:deseleccionar_incidencia_todo()'>Marcar ninguno</a>				
							</td>
					</tr>";
							
					echo "<tr>";
					echo "<td colspan='2' class='caja_texto_db'>...</td>";				
					echo "<td class='caja_texto_db'>COD.INCIDENCIA</td>";	
					echo "<td class='caja_texto_db'>CIP</td>";						
					echo "<td class='caja_texto_db'>DNI</td>";							
					echo "<td class='caja_texto_db'>NOMBRE COMPLETO</td>";
					echo "<td class='caja_texto_db'>TP.INCIDENCIA</td>";
					echo "<td class='caja_texto_db'>MOTIVO</td>";
					echo "<td class='caja_texto_db'>HORARIO</td>";
					echo "<td class='caja_texto_db'>MODO</td>";
					echo "<td class='caja_texto_db'>USU.REGISTRO</td>";
					echo "<td class='caja_texto_db'>FEC.INI.INC</td>";
					echo "<td class='caja_texto_db'>FEC.FIN.INC</td>";
					echo "<td class='caja_texto_db'>DIF.</td>";
					echo "<td class='caja_texto_db'>ESTADO</td>";
					echo "<td class='caja_texto_db'>APROBADO POR</td>";
					echo "</tr>";
					
		
		  $i=0;
			
				
				while($reg_lis=mysql_fetch_row($res_lis)){	
				
					$s="select * from tb_usuarios where dni='".$reg_lis[15]."'";
					//echo $s;
					$rs_s = mysql_query($s);											
					$rg_s = mysql_fetch_row($rs_s);
					
					$m="select * from tb_motivos_incidencia where cod_mot_inc='".$reg_lis[5]."'";
					//echo $s;
					$rs_m = mysql_query($m);											
					$rg_m = mysql_fetch_row($rs_m);
					
					$hor="select * from horarios_gestores_cot where dni='".$reg_lis[15]."'";
					//echo $s;
					$rs_hor = mysql_query($hor);											
					$rg_hor = mysql_fetch_row($rs_hor);
					
					$usu_reg="select * from tb_usuarios where iduser='".$reg_lis[3]."'";
					//echo $s;
					$rs_usu_reg = mysql_query($usu_reg);											
					$rg_usu_reg = mysql_fetch_row($rs_usu_reg);
					
					$usu_apro="select * from tb_usuarios where iduser='".$reg_lis[19]."'";
					//echo $s;
					$rs_usu_apro= mysql_query($usu_apro);											
					$rg_usu_apro = mysql_fetch_row($rs_usu_apro);
				
					echo "<tr>";	
					
					
					/*
					echo "<td>";		
					echo $con = $con + 1; 				
					echo "</td>";
					*/
					$i = $i + 1; 
					$nn="d_obs_".$con;
					$nnx="f_obs_".$con;
					
					if ($reg_lis[17]==0){
						$marcar ="enabled";
						
					}else{
						$marcar ="disabled";
					}
					echo "<td class='caja_texto_pe'>$i</td>";
						
					echo "<td class='caja_texto_peke'>";		
					//echo "check".$i."|".$reg[2];
					?>
					 <input type="checkbox" name="<?php echo "check".$i; ?>" id="<?php echo "check".$i; ?>" value="<?php echo $reg_lis[10]; ?>" 
					onclick="javascript:escojer_gestor()" <?php echo $marcar; ?>/> 
					<?php
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";		//C.INCIDENCIA		
					echo $reg_lis[10]; 				
					echo "</td>";
				
					echo "<td class='caja_texto_peke'>";		//CIP		
					echo $reg_lis[1]; 				
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";		//dni		
					echo $reg_lis[15]; 				
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";
					echo $rg_s[1]; 		//NOMBRE	
					echo "</td>";
				
					
					echo "<td class='caja_texto_peke'>";		// tp incidencia		
					echo $reg_lis[4]; 				
					echo "</td>";
					
					
					echo "<td class='caja_texto_peke'>";		// motivo		
					echo $rg_m[1]; 				
					echo "</td>";
					
					
					echo "<td class='caja_texto_peke'>";		// HORARIO		
					echo $rg_hor[6]; 				
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";		//modo		
					echo $reg_lis[13]; 				
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";		//usu reg		
					echo $rg_usu_reg[1]; 				
					echo "</td>";
					
					echo "<td class='caja_texto_peke'>";		//fecini		
					echo $reg_lis[6]."1"; 				
					echo "</td>";
						
					echo "<td class='caja_texto_peke'>";		//fecfin		
					echo $reg_lis[7]; 				
					echo "</td>";
						
					echo "<td class='caja_texto_peke'>";		//tiempo		
					echo $reg_lis[16]; 		
					echo "</td>";					
					
							//ESTADO	
						if ($reg_lis[17]==0){
							$estado_ap= "PENDIENTE";
							$color_texto="#FFC800";
						}
						if ($reg_lis[17]==1){
							$estado_ap= "APROBADO";
							$color_texto="#4E5D17";
						}	
						
						if ($reg_lis[17]==2){
							$estado_ap= "RECHAZADO";
							$color_texto="#DD4F43";
						}
					echo "<td bgcolor='$color_texto' style='color:#FFFFFF'>$estado_ap</td>";
					
					if ($reg_lis[17]==0){
					echo "<td class='caja_texto_peke'>";		// HORARIO		
					echo ""; 				
					echo "</td>";					
					}else{
					echo "<td class='caja_texto_peke'>";		// HORARIO		
					echo $rg_usu_apro[1]; 				
					echo "</td>";	
					}
					
					echo "</tr>";				
					}
									
		
				echo "</table>";	
	}else{
		echo "<table width='100%'>";	
				
					echo "<tr>
							<td colspan='10'>
							<a class='caja_sb' href='javascript:seleccionar_incidencia_todo()'>Marcar todos</a> |
							<a class='caja_sb' href='javascript:deseleccionar_incidencia_todo()'>Marcar ninguno</a>				
							</td>
					</tr>";
							
					echo "<tr>";
					echo "<td colspan='2' class='caja_texto_db'>...</td>";				
					echo "<td class='caja_texto_db'>COD.INCIDENCIA</td>";	
					echo "<td class='caja_texto_db'>CIP</td>";						
					echo "<td class='caja_texto_db'>DNI</td>";							
					echo "<td class='caja_texto_db'>NOMBRE COMPLETO</td>";
					echo "<td class='caja_texto_db'>TP.INCIDENCIA</td>";
					echo "<td class='caja_texto_db'>MOTIVO</td>";
					echo "<td class='caja_texto_db'>HORARIO</td>";
					echo "<td class='caja_texto_db'>MODO</td>";
					echo "<td class='caja_texto_db'>USU.REGISTRO</td>";
					echo "<td class='caja_texto_db'>FEC.INI.INC</td>";
					echo "<td class='caja_texto_db'>FEC.FIN.INC</td>";
					echo "<td class='caja_texto_db'>DIF.</td>";
					echo "<td class='caja_texto_db'>ESTADO</td>";
					echo "<td class='caja_texto_db'>APROBADO POR</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan='16' class='caja_texto_peke' align='center'>NO HAY REGISTROS</td>";	
					echo "</tr>";
		echo "</table>";	
	}
			
}

/*
if ($accion=="save_compensaciones_inc"){
		
	$iduser			=$_GET["iduser"];	
	$c_incidencia	=$_GET["c_incidencia"];	
	$dni			=$_GET["dni"];	
	$modo			=$_GET["modalidad"];	
	$fec_ini_comp		=$_GET["fec_ini"];	
	$fec_fin_comp		=$_GET["fec_fin"];	
	
	$fec_ini_perm		=$_GET["fec_ini_inc"];	
	$fec_ini_perm		=$_GET["fec_fin_inc"];	
	
	$tiempo_acumulado_permiso = $_GET["tt_acumulado_perm"];
	$tiempo_acumulado_comp = $_GET["tt_acu_comp"];
	
	
}
*/



if ($accion=="act_contacto_tdata"){
	
	include ("conexion_teradata.php"); 
	$connection_teradata 	= db_conn_teradata();
	
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$iduser		=$_GET["iduser"];	
	$telefono	=trim($_GET["telefono"]);	
	$dni		=trim($_GET["dni"]);	
	$peticion	=trim($_GET["peticion"]);	
	$v_combo	=$_GET["v_combo"];	
	$hoy 		=date ("d-m-Y h:m");
	
	$sql_tdata_1="INSERT INTO DBI_COT.LC_COT_LISTANEGRA
	select top 1 '','DNI','$dni','$telefono',ape_paterno,ape_materno,nombres,nombre_completo,operador,
	'$v_combo','$hoy','$iduser','$pc'
	from dbi_cot.RB_Contactabilidad_COT where nro_documento='$dni'";
	//echo "<br>".$sql_tdata_1;
	
	$statement1=odbc_exec($connection_teradata, $sql_tdata_1);
	if (!$statement1){
		exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
	}
	
	
	$sql_tdata_2="INSERT INTO 
	DBI_COT.lc_movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato,usu_psi)
	VALUES('','ACTUALIZACION CONTACTABILIDAD: $v_combo','$iduser',now(),
	'SE ACTUALIZO EL $telefono DEL CLIENTE CON DNI $dni','$pc','$pc_asig','$telefono','T.Contacto')";
	//echo $sql_tdata_2;
	
	$statement2=odbc_exec($connection_teradata, $sql_tdata_2);
	if (!$statement2){
		exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
	}
	
	if ($telefono!=""){
		$xtelefono= $telefono;
	}else{
		$sql_tdata_t="select top 1 nro_documento,dni,telefono 
		from dbi_cot.RB_Contactabilidad_COT where peticion='$peticion'";
		//echo $sql_tdata_t;
		
		$statement_t=odbc_exec($connection_teradata, $sql_tdata_t);
		if (!$statement_t){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
		$xtelefono		=odbc_result($statement,"telefono");	
	}
	
	$sql_tdata_3="update dbi_cot.RB_Contactabilidad_COT set ESTADO='$v_combo' 
	where nro_documento='$dni' and telefono='$xtelefono'";
	//echo $sql_tdata_3;
	
	$statement3=odbc_exec($connection_teradata, $sql_tdata_3);
	if (!$statement3){
		exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
	}
	
	/****************/
	
	$connection_mysql 		= db_conn_mysql();
	
		
	$sql_2="INSERT INTO tb_contactos_cot
			SELECT '',campo1,campo2,'$telefono',campo4,campo5,campo6,campo7,campo8,campo9,NOW(),'$iduser',
			'$pc','$v_combo' 
			FROM tb_contactos_ant 
			WHERE campo2='$dni' limit 1";				
	//echo "<br>".$sql_2;
	$res_2= mysql_query($sql_2,$connection_mysql);	
	
	
	$sql_3="INSERT INTO movimiento_contactos(id,proceso,usu_mov,fec_mov,obs,pc_sis,pc_asig,dato)
	VALUES(LAST_INSERT_ID(),'ACTUALIZACION CONTACTABILIDAD: $v_combo','$iduser',now(),
	'SE ACTUALIZO EL $telefono DEL CLIENTE CON DNI $dni','$pc_sis','$pc_asig','$telefono')";
	//echo "<br>".$sql_3;
	$res_3= mysql_query($sql_3,$connection_mysql);
	
	
	/***************/
	echo "Se actualizo correctamente el N. Contacto: $telefono del Dni: $dni";
}



if ($accion=="save_compensaciones_inc"){
		
	$iduser			=$_GET["iduser"];	
	$idperfil			=$_GET["idperfil"];
	$c_incidencia	=$_GET["c_incidencia"];	
	$dni			=$_GET["dni"];	
	$modo			=$_GET["modalidad"];	
	
	$fec_ini_comp	=$_GET["fec_ini"];	
	$fec_fin_comp	=$_GET["fec_fin"];	
	
	$fec_ini_perm	=$_GET["fec_ini_inc"];	
	$fec_fin_perm	=$_GET["fec_fin_inc"];	
	
	$h_ini_perm		=$_GET["h_ini"];	
	$h_fin_perm		=$_GET["h_fin"];
	
	$tiempo_acumulado_permiso = $_GET["tt_acumulado_perm"];
	$tiempo_acumulado_comp = $_GET["tt_acu_comp"];
	$tt_comp_tot = $_GET["tt_comp_tot"];
	
	
	
	
	if ($idperfil<4){ // todos los mandos pasan directo a aprobado
				$estado_inc	= 1;
			}else{
				$estado_inc	=0;
			}
	//$dif_1 		="select SEC_TO_TIME(('$tt_comp_tot'+'$tiempo_acumulado_comp')*3600)";
	
	
	//echo $dif_comp."|".$reg_dif_comp[0];
	//echo $dif_fec_perm_act."|".$tiempo_acumulado_permiso;
	
	$dif_0 ="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_comp','$fec_fin_comp'))*60)";
	//echo $dif_0;
	$res_dif_0 = mysql_query($dif_0);
	$reg_dif_0 = mysql_fetch_row($res_dif_0);
	$dif_t_perm = $reg_dif_0[0];
	
	
		
		if ($_GET["motivo_inc"]=="154"){
			$nuevo_motivo="159";
		}
		
		if ($_GET["motivo_inc"]=="155"){
			$nuevo_motivo="156";
		}
		
		if ($_GET["motivo_inc"]=="157"){
			$nuevo_motivo="158";
		}
		
		if ($_GET["motivo_inc"]=="153"){
			$nuevo_motivo="160";
		}
		
		if ($_GET["motivo_inc"]=="82"){
		$nuevo_motivo="160";
		}
	
	
	if ($_GET["motivo"]=="154"){
		$dif_tiempo_perm = $reg_dif_0[0];
	}else{
		$dif_tiempo_perm ="-".$reg_dif_0[0];
	}
	
	
	
	
	// valida si esta dentro del horario de trabajo	
	$sql_0a		="select * from horarios_gestores_cot where dni='$dni'";	
	//echo "<br>".$sql_0a;
	$res_0a		= mysql_query($sql_0a) or die(mysql_error());
	$reg_lis0a	=mysql_fetch_row($res_0a);
	$cod_horario = $reg_lis0a[5];
	$hora_ini_hor = $reg_lis0a[8];
	$hora_fin_hor = $reg_lis0a[9];
	
	//echo $fec_ini_comp."|".$fec_fin_comp."|".$hor_ini_comp."|".$hor_fin_comp."|".$fec_ini_hor."|".$fec_fin_hor;
	 
	$sql_0b		="select cod_horario,dias from horarios_rrhh where cod_horario='$cod_horario'";	
	//echo "<br>".$sql_0b;
	$res_0b		= mysql_query($sql_0b) or die(mysql_error());
	$reg_lis0b	=mysql_fetch_row($res_0b);
	$ndias 	   = $reg_lis0b[1];
	
	$pre ="select * from tb_usuarios where dni='$dni'";
	$res_pre= mysql_query($pre);
	$reg_pre = mysql_fetch_row($res_pre);	
												
	
	
					$NombreDia=get_nombre_dia($fec_ini_comp);
					$NombreCorto=substr($NombreDia, 0, 2);
					$validar=Obtener_valor($NombreCorto,$ndias);
					
					//echo "<br>".$fec_ini_comp."|".$NombreDia."|".$NombreCorto."|".$ndias."|".$validar."\n";
					
					//echo $validar;
					//echo "<br>".$h_ini_perm."|".$hora_fin_hor."\n";
							
					if ($validar=="1"){	// dias laborales
							
							if (trim($h_ini_perm) >= trim($hora_ini_hor)  and trim($h_ini_perm) <= trim($hora_fin_hor) and 
							trim($h_fin_perm)>= trim($hora_ini_hor) and trim($h_fin_perm) <= trim($hora_fin_hor)){ // Dentro de horario
							
								$error 		= "0";
								$valor 		= "00:00:00";
								$msn 		= "Error: Las compensaciones se deben de registrar fuera del rango de horarios";	
								$hor_tot	= "00:00:00";								
							
							}else{
														
								$error		= "1";
								$valor 		= $dif_t_perm;
								$hor_tot 	= $reg_dif_comp[0];
								$msn 		= "Se registro correctamente la compensacion";
														
							}
							
					}else{ 	// dias descanso				
							$error 		= "1";
							$valor 		= $dif_t_perm;
							$msn 		= "Se registro correctamente la compensacion";	
							$hor_tot 	= $reg_dif_comp[0];
							
													
					}// if validar
		
													
	
		if ($error=="1"){
			
						
			$sql = "INSERT INTO cab_incidencia
			(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
			fec_fin_inc,obs_incidencia,tiempo,modo,cod_incidencia,										
			c_doid,dni,dias,nro_participantes,estado_inc,fec_mov_est,usu_mov_est)
			VALUES	
			('','$reg_pre[3]',now(),'$iduser','COMPENSACIONES','$nuevo_motivo','$fec_ini_comp',
			'$fec_fin_comp','Compensacion Registrada','$dif_tiempo_perm','H','$c_incidencia',
			'0','$dni','0','0','$estado_inc',now(),'$iduser')";
			//echo "<br>".$sql."\n";
			$res_sql 	= mysql_query($sql);
			
			$dif_comp		="select SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo)*-1)) from cab_incidencia 
			where cod_incidencia='$c_incidencia' and tp_incidencia='COMPENSACIONES' and motivo_incidencia in('159','156','158')";
			
			$res_dif_comp 	= mysql_query($dif_comp);
			$reg_dif_comp 	= mysql_fetch_row($res_dif_comp);	
			$hor_tot		= $reg_dif_comp[0];
			
			$dif_		="update cab_incidencia set estado_inc='1'
			where cod_incidencia='$c_incidencia' and estado_inc='0'";			
			$res_dif_	= mysql_query($dif_);
						
		}
		
		
		
		echo $error."|".$valor."|".$msn."|".$hor_tot;
}


if ($accion=="listar_compensaciones_inc"){
	
$c_incidencia	=$_GET["c_incidencia"];	
$f_actual=date("Y-m-d");
	
$lista="select * from cab_incidencia where cod_incidencia='$c_incidencia' and tp_incidencia='COMPENSACIONES' 
and motivo_incidencia in('156','158','159','160')";
//echo $lista;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' >";	
			echo "<tr>";							
			echo "<td class='caja_texto_pe'>ITEM </td>";													
			echo "<td class='caja_texto_pe'>FEC. INICIO</td>";
			echo "<td class='caja_texto_pe'>FEC. FIN</td>";
			echo "<td class='caja_texto_pe'>DIF.</td>";				
							
			echo "</tr>";
	$i=0;
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_texto_peke'>";
		echo $i=$i+1; 			
		echo "</td>";	
		
		$fec_ini =$reg_lis[6];
		$fec_fin =$reg_lis[7];
						
		$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin'))*60) as dif";
		//echo $calc;
			
		$rs_calc = mysql_query($calc);											
		$rg_calc = mysql_fetch_row($rs_calc);	
		
		echo "<td class='caja_texto_peke'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		echo $reg_lis[7]; 				
		echo "</td>";			
		
		echo "<td class='caja_texto_peke'>";
		echo $rg_calc[0]; 				
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";	
}


if ($accion=="calc_tiempo_comp"){
	$fec_ini_comp		=$_GET["fec_ini"];	
	$fec_fin_comp		=$_GET["fec_fin"];	
	
	$fec_ini_perm		=$_GET["fec_ini_inc"];	
	$fec_ini_perm		=$_GET["fec_fin_inc"];	
	
	$tiempo_acumulado_permiso = $_GET["tt_acumulado_perm"];
	$tiempo_acumulado_comp = $_GET["tt_acu_comp"];
	
	/*
	if (substr($_GET["tt_comp_tot"],0,1)=="-"){
		$tt_comp_tot = trim(substr($_GET["tt_comp_tot"],1,10));
	}else{
		$tt_comp_tot = $_GET["tt_comp_tot"];
	}
	*/
	$tt_comp_tot = $_GET["tt_comp_tot"];
	
	$dif_0 ="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_comp','$fec_fin_comp'))*60)";
	//echo $dif_0."<br>";
	$res_dif_0 = mysql_query($dif_0);
	$reg_dif_0 = mysql_fetch_row($res_dif_0);
	
	$valor = $reg_dif_0[0];
	
	
	
	if ($dif_fec_perm_act>=$tiempo_acumulado_permiso){
		$error ="0";
		$msn ="El tiempo Programado no debe ser mayor que el tiempo acumulado del permiso";
		
	}else{
		
		$error ="1";
		$msn ="";
	}

	echo $error."|".$valor."|".$msn."|".$hor_tot;
}

if ($accion=="calcular_lactancia"){
	$fec_ini_lac		=$_GET["fec_ini_lac"];	
	
	$dif_0 =" DATE_ADD( $fec_ini_lac, INTERVAL 1 YEAR )  ";
	echo $dif_0."<br>";
	$res_dif_0 = mysql_query($dif_0);
	$reg_dif_0 = mysql_fetch_row($res_dif_0);
	

	echo  $reg_dif_0[0];
}
/***************************************************************************************************************************************/
if($accion=="grabar_movimientos_usuarios_nuevo"){
	
	
	$iduser		= $_GET["iduser"]; 
	$xid_ant	=$_GET["id"]; 
	$xdni_mov	=$_GET["dni"]; 
	$xcip_mov	=$_GET["cip"]; 
	$xusu_mov	=$_GET["usu_aplicativo"]; 
	$xapli_mov	=$_GET["aplicativo"]; 
	$xfec_ini	=$_GET["fec_ini"]; 
	$xfec_fin	=$_GET["fec_fin"]; 
	$apli		=$_GET["n_apli"]; 
	$hoy 		=date("d-m-Y");
	
		$sql0	="SELECT * FROM movimientos_maestra WHERE dato='$xusu_mov' and aplicativo='$xapli_mov' and est='CREADO'";
		//echo $sql0;
		$rs_0 	= mysql_query($sql0);
		$rg_0 	= mysql_fetch_array($rs_0);
		$nrg	= mysql_num_rows($rs_0);
		
	
		$sql1="update movimientos_maestra set est='DESACTIVADO',fec_fin='$xfec_fin',usu_mov='$iduser',
		obs_mov='Se desactiva usuario $xusu_mov el dia $hoy' 
		where id='$xid_ant'";
		//echo $sql1;
		$res_sql1 = mysql_query($sql1);
	
		//$apli="t_".strtolower(str_replace(' ','_',$xapli_mov));
		
		//OJO		
		$sql_2="insert into historico_usuarios_maestra 
		VALUES('','$xdni_mov','$xusu_mov','$xapli_mov','',NOW(),CURDATE(),'2050-01-01','$iduser',
		'SE ACTUALIZA EL USUARIO $dato del aplicativo $aplicativo','DESACTIVADO','$apli','')";
		//echo $sql."|";			
		$res_sql2= mysql_query($sql_2);
	
	
			
		echo "Se registro correctamente";
}

if($accion=="validar_incidencia"){
	
	$iduser		= $_GET["iduser"]; 
	$idperfil	=$_GET["idperfil"]; 
	$fec_ini_inc	=$_GET["fec_ini"]; 
	$fec_fin_inc	=$_GET["fec_fin"]; 
	$tipo_incidencia	=$_GET["tipo_incidencia"]; 
	$dni_escogidos	=$_GET["dni_escogidos"]; 
	$modo_incidencia	=$_GET["modo_incidencia"]; 
	
	if ($_GET["modo_incidencia"]=="H"){  // Si modo es HORAS
				
				$f_ini_inc = explode(" ",$fec_ini_inc);				
				$f_fin_inc = explode(" ",$fec_fin_inc);				
				
						
				$fec_ini_inc = $f_ini_inc[0]; // captura el valor de solo la fecha 2019-05-05
				$fec_fin_inc = $f_fin_inc[0]; // captura el valor de solo la fecha 2019-05-05
				
				$hor_ini_inc = $f_ini_inc[1]; // captura el valor de solo la hora inicial 08:00
				$hor_fin_inc = $f_fin_inc[1]; // captura el valor de solo la hora inicial 08:00	
						
	}else{
		
		
	}
	
	
	$sql_1="select * from cab_incidencia where dni='$dni_escogidos'
	and $fec_ini_inc between fec_ini_inc and fec_fin_inc";
	echo "<p>".$sql_1;
	//$res_sql_1 = mysql_query($sql_1);
}

if ($accion=="eliminar_incidencia_todo"){
	$iduser		= $_GET["iduser"];	
	$c_inc		= "INC-".$_GET["c_incidencia"];		
	$obs 		= "Se elimino incidencia ".$inc." por el usuario ".$iduser;
	
	$sql_1="delete from cab_incidencia where cod_incidencia='$c_inc'";	
	//echo $sql_1;
	$res_1= mysql_query($sql_1);	

	$sql_2="insert into det_incidencia(cod_incidencia,usu_mov,fec_mov,fec_ini,fec_fin,obs) 
	values('$c_inc','$iduser',now(),'$fec_ini','$fec_fin','$obs')";	
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
		
}

if ($accion=="grabar_aplicativo"){
	$aplicativo	= $_GET["aplicativo"];	
	$iduser		= $_GET["iduser"];	
	$aplicativo1 = "t_".$aplicativo;
	
	$sql ="select aplicativo from tb_aplicativos where aplicativo='$aplicativo' and estado = '1'";
	$res_sql = mysql_query($sql);
	$nreg = mysql_num_rows($res_sql);
	
	//echo $nreg;
	
	if ($nreg>0){
	echo "<a class='aviso_horario'>Aplicativo ya se encuentra registrado</a>";
	
	}else{
	
	
	$sql_0="SELECT MAX(orden) FROM tb_aplicativos";
	$res_sql_0 = mysql_query($sql_0);
	$reg_sql_0=mysql_fetch_row($res_sql_0);
	$orden = $reg_sql_0[0]+1;
	
	
	$sql_1="insert into tb_aplicativos(c_aplicativo,aplicativo,estado,f_act,usuario,orden) 
	values('','$aplicativo','1',now(),'$iduser','$orden')";	
	//echo $sql_2;
	$res_1= mysql_query($sql_1);
	
	
	$sql_2="INSERT INTO movimientos_maestra
	(SELECT '',dni,'-','$aplicativo','ACT.USUARIO',NOW(),CURDATE(),'2050-01-01','$iduser','REGISTRADO POR GESCOT',
	'CREADO','$aplicativo1','' 
	FROM movimientos_maestra GROUP BY dni)";	
	//echo $sql_2;
	
	//echo $sql_2;
	$res_2= mysql_query($sql_2);
	
	
	echo "Se registro el aplicativo: ". $aplicativo. " correctamente";	
	
	echo "<p>";
	
//               $lista = "select * from tb_aplicativos where estado='1' order by orden desc";
////echo $lista;
//               $res_lis = mysql_query($lista);
//
//               echo "<table width='50%' >";
//               echo "<tr>";
//               echo "<td class='cabec_1'>ITEM </td>";
//               echo "<td class='cabec_1'>APLICATIVO </td>";
//               echo "</tr>";
//               $i = 0;
//               while ($reg_lis = mysql_fetch_row($res_lis)) {
//
//
//                   echo "<tr>";
//
//                   echo "<td  class='caja_texto_cb'>";
//                   echo $i = $i + 1;
//                   echo "</td>";
//
//                   echo "<td  class='caja_texto_cb'>";
//                   echo $reg_lis[1];
//                   echo "</td>";
//
//                   echo "</tr>";
//               }
//               echo "</table>";	
	}
}


//*23/07/20*

if ($accion=="detalle_usuarioscot"){

	$c_supervisor = $_GET["c_supervisor"];
	$c_gestor = $_GET["c_gestor"];
	
	
		if ($_GET["c_gestor"]=="0"){
			$sql_1="select * from tb_usuarios where c_supervisor='$c_supervisor' and estado='HABILITADO'";	
		}else{
			$sql_1="select * from tb_usuarios where dni='$c_gestor' and estado='HABILITADO'";	
		}
	
	
	
	$res_1= mysql_query($sql_1);
	
			echo "<table width='90%'>";					
			echo "<tr>";
			echo "<td class='boton_3' width='5%' align='center'>ITEM </td>";									
			echo "<td class='boton_3' width='5%' align='center'>DNI </td>";	
			echo "<td class='boton_3' width='5%' align='center'>CIP</td>";		
			echo "<td class='boton_3' width='40%' align='center'>NOMBRES COMPLETOS</td>";	
			
			$col="select * from tb_aplicativos order by orden";
			$res_col= mysql_query($col);
			while($reg_col = mysql_fetch_row($res_col)){
				echo "<td class='boton_3' width='30%' align='center'>";	
				echo $reg_col[1]; 					
				echo "</td>";
			}		
										
			echo "</tr>";
		$i = 0;
		while($reg_1 = mysql_fetch_row($res_1)){		
		
		
		echo "<tr>";			
		echo "<td class='celda_cb' valign='top'>";		
		echo $i = $i +1; 			
		echo "</td>";	
						
		echo "<td class='celda_cb' valign='top'>";		
		echo $reg_1[2]; 			
		echo "</td>";	
				
		echo "<td class='celda_cb' align='center' valign='top'>";
		echo $reg_1[3]; 			
		echo "</td>";	
		
		echo "<td class='celda_cb' align='center' valign='top'>";
		echo $reg_1[1]; 			
		echo "</td>";	
		
			$col_1="select * from tb_aplicativos order by orden";
			//echo $col_1;
			
			$res_col_1= mysql_query($col_1);
			while($reg_col_1 = mysql_fetch_row($res_col_1)){
			
				$col_2="select dni,dato,aplicativo,est
				from movimientos_maestra where dni='$reg_1[2]' AND aplicativo='$reg_col_1[1]' group by dni";
				//echo $col_2."|";			
				$res_2= mysql_query($col_2);
				$reg_2 = mysql_fetch_row($res_2);
				$nreg2 = mysql_num_rows($res_2);
				
				if ($nreg2>0){
				?>
				<td class="celda_cb" width="5%" valign="top"
				ondblclick="javascript:edicion_usuarios('<?php echo $reg_2[0]; ?>','<?php echo $reg_2[1]; ?>','<?php echo $reg_2[2]; ?>','<?php echo $reg_2[3]; ?>')" >
				
				<?php
				/*
				if ($reg_2[3]=="DESACTIVADO"){
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='$reg_2[1]' />";
					echo "<img src='image/semaforo_r.JPG' width='25' height='25' />";		
				}else{
					if ($reg_2[1]=="-" or $reg_2[1]==" " or $reg_2[1]=="X"){					
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='USU. EN BLANDO' />";
					echo "<img src='image/semaforo_a.JPG' width='25' height='25' />";			
					}else{
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='$reg_2[1]' />";
					echo "<img src='image/semaforo_v.JPG' width='25' height='25' />";	
					}
				}	
				*/
				if ($reg_2[3]=="DESACTIVADO"){
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='$reg_2[1]' align='center' />";
					echo "<img src='image/semaforo_a.JPG' width='25' height='25' />";	
				}else{
					if ($reg_2[1]=="-"){					
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='$reg_2[1]' align='center' />";
					echo "<img src='image/semaforo_r.JPG' width='25' height='25' />";			
					}else{
					echo "<input name='' type='text' class='caja_sb_pe' id='' value='$reg_2[1]' align='center' />";
					echo "<img src='image/semaforo_v.JPG' width='25' height='25' />";	
					}
					echo "</td>";
				}	
					}else{
					?>
					<td class='celda_cb'>NO CREADO <img src='image/BT7.gif' width='20' height='20' 
					onclick="javascript:edicion_usuarios('<?php echo $reg_1[2]; ?>','','<?php echo $reg_col_1[1]; ?>',
					'NUEVO')" /></td>
					
					<?php
					}
				
			} //dowhile	
			
			
		echo "</tr>";	
	
		} // dowhile
		
		
	echo "</table>";	
	
}


if ($accion=="estado_usuarioscot"){
	$iduser		= $_GET["iduser"];	
	$dni 		= $_GET["dni_1"];
	$dato 		= $_GET["usu_1"];
	$aplicativo = $_GET["aplicativo_1"];
	$aplicativo1 = "t_".$_GET["aplicativo_1"];
	
	
	if ($_GET["est"]=="DESACTIVADO"){
		$est="CREADO";
	}else{
		$est="DESACTIVADO";
	}

	
	$sql_1="update movimientos_maestra set est='$est',fec_mov=now(),usu_mov='$iduser' 
	where dni='$dni' and aplicativo='$aplicativo'";
	//echo $sql_1."|";			
	$res_sql_1= mysql_query($sql_1);
	
	$sql_2="insert into historico_usuarios_maestra VALUES('','$dni','$dato','$aplicativo',
	'',NOW(),CURDATE(),'2050-01-01','$iduser',
	'SE $est EL USUARIO $dato del aplicativo $aplicativo','$est','$aplicativo1','')";
	//echo $sql."|";			
	$res_sql2= mysql_query($sql_2);
	

}

if ($accion=="actualizar_usuarioscot"){
	$iduser		= $_GET["iduser"];	
	$dni 		= $_GET["dni_1"];
	$dato 		= $_GET["usu_1"];
	$aplicativo = $_GET["aplicativo_1"];
	$aplicativo1 = "t_".$_GET["aplicativo_1"];
	$est		= $_GET["est"];
	$usu_ant		= $_GET["usu_ant"];
	/*
	if ($_GET["est"]=="DESACTIVADO"){
		$est="ACTIVO";
	}else{
		$est="DESACTIVADO";
	}
	*/
	$sql_0="select * from movimientos_maestra where dato='$dato' and aplicativo='$aplicativo' and est='CREADO'";
	//echo $sql_0."|";			
	$res_sql_0= mysql_query($sql_0);
	$reg_sql_0 = mysql_fetch_row($res_sql_0);
	$nreg_sql_0 = mysql_num_rows($res_sql_0);
	
	if ($nreg_sql_0 > 0){		
		echo "ALERTA: El usuario $dato ya se encuentra registrado con el mismo aplicativo $aplicativo y le pertenece al dni $reg_sql_0[1]";
	}else{	
		$sql_1="update movimientos_maestra set dato='$dato',fec_mov=now(),usu_mov='$iduser'
		 where dni='$dni' and aplicativo='$aplicativo'";
		//echo $sql."|";			
		$res_sql_1= mysql_query($sql_1);
		
		$sql_1a="select aplicativo from movimientos_maestra where aplicativo='$aplicativo'";
		//echo $sql."|";			
		$res_sql_1a= mysql_query($sql_1a);
		$nreg_1a = mysql_num_rows($res_sql_1a);
		
		//if ($nreg_1a > 0){	
		if ($_GET["est"]=="NUEVO"){		
			$res_x= mysql_query("insert into movimientos_maestra VALUES('','$dni','$dato','$aplicativo','ACT. USUARIO',
			NOW(),CURDATE(),'2050-01-01','$iduser','MODIFICACION POR MODULO','CREADO','$aplicativo1','')");		
		}
		
		$sql_2="insert into historico_usuarios_maestra VALUES('','$dni','$usu_ant','$aplicativo',
		'',NOW(),CURDATE(),'2050-01-01','$iduser',
		'SE ACTUALIZA EL USUARIO $dato del aplicativo $aplicativo','DESACTIVADO','$aplicativo1','')";
		//echo $sql."|";			
		$res_sql2= mysql_query($sql_2);
		
		echo "Se actualizo correctamente datos del gestor";
	}
}

if ($accion=="carga_combo_gestor"){ 

$c_supervisor 		= $_GET["c_supervisor"];

?>

<select name="combo_gestor" id="combo_gestor" class="caja_texto_pe">
          <?php 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			if ($c_supervisor=="T"){
				$sql7="select dni,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
			}else{
				$sql7="select dni,ncompleto,grupo from tb_usuarios where c_supervisor='$c_supervisor' 
			and estado='HABILITADO' order by ncompleto";
			
			}	
			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1] | $rowper[0]  |  $rowper[2]</option>";
			}
			?>
        </select>
<?php }

/*************************************************************************************************************************/


if ($accion=="grabar_incidencias_cot_oficial") { // esta es la que vale
		$modo_gru=$_GET["modo_gru"];	
		$obs_gru=$_GET["obs_gru"];	
		$dni_escogidos = explode("|", $_GET["dni_escogidos"]);		
		$fec_ini_inc	=$_GET["fec_ini"];	
		$fec_fin_inc	=$_GET["fec_fin"];	
		$nro_escogidos=$_GET["nro_escogidos"];
		$c_mot_gru=$_GET["c_mot_gru"];
		$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
		$iduser=$_GET["iduser"];
		$idperfil=$_GET["idperfil"];
		$xc_incidencia=limpia_espacios($_GET["c_incidencia"]);	
		$c_mot_inc_gru=$_GET["c_mot_inc_gru"];		
		$c_doid_gru=$_GET["c_doid_gru"];	
		$c_inc=$_GET["c_inc"];	
		$opc=$_GET["opc"];
		$combo=$_GET["combo"];

		if ($idperfil=="3" or $idperfil=="2") { // si es supervisor estado aprobado
			$xest_inc="1";
		} else {
			$xest_inc="0";
		}
		$valida="select datediff(curdate() + 1,'$fec_ini_inc')";	
		$res_valida= mysql_query($valida);
		$reg_valida = mysql_fetch_row($res_valida);
		
		$dia =  date("d");
	
		if ($_GET["motivo_inc"]=="154"){
			$nuevo_motivo="159";
		}
		if ($_GET["motivo_inc"]=="155"){
			$nuevo_motivo="156";
		}
		if ($_GET["motivo_inc"]=="157"){
			$nuevo_motivo="158";
		}
		if ($_GET["motivo_inc"]=="153"){
			$nuevo_motivo="160";
		}
	
	
	if ($_GET["motivo"]=="154"){
		$dif_tiempo_perm = $reg_dif_0[0];
	}else{
		$dif_tiempo_perm ="-".$reg_dif_0[0];
	}
	
	if ($_GET["motivo_inc"]=="82"){
		$nuevo_motivo="160";
	}
	
	if ($reg_valida[0] > 90 ) {   // VALIDA SI ES MAYOR A 2 DIAS
		$error = "2-Atencion: Solo se puede registrar incidencias con 2 dias de anterioridad";
	} else {
		
		if ($c_mot_inc_gru=="41" and $_GET["modo_gru"]=="H") { //Lactancia
					$inicio_f = $fec_ini_inc;
					$fin_f = $fec_fin_inc;
					$f_ini_inc = explode(" ",$fec_ini_inc);				
					$f_fin_inc = explode(" ",$fec_fin_inc);	
					
					
					$hor_ini_inc = $f_ini_inc[1]; // captura el valor de solo la hora inicial 08:00				
					$fec_inc_ant = $f_ini_inc[0]; // captura el valor de solo la fecha 2019-05-05
					$hor_fin_inc = $f_fin_inc[1];	// captura el valor de solo la hora final 10:00		
					
					$fec_fin_inc_ = date("Y-m-d",strtotime($f_fin_inc[0]));
					$fec_fin_inc = $fec_fin_inc_." ".$hor_fin_inc;
					
					$dif_1 ="select datediff('$fec_fin_inc_','$fec_inc_ant')";
				
					//echo $dif_1;
					$res_dif_1 = mysql_query($dif_1);
					$reg_dif_1 = mysql_fetch_row($res_dif_1);
					$diff = $reg_dif_1[0];
					
					$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
					//echo $cad;
					$rs = mysql_query($cad);
					$rg = mysql_fetch_array($rs);	
					$franq 	= limpia_espacios($rg[0]);
					$c_incidencia = "INC-".$franq;

					$dni_select = array_values(array_filter($dni_escogidos));
					$responseValidacion = array();
					foreach ($dni_select as $key => $value) {
						$queryUsuarios = "select * from horarios_gestores_cot where dni='".$value."' ORDER BY 1 DESC LIMIT 1";
						$resultUsuarios = mysql_query($queryUsuarios);
						$rowUsuarios = mysql_fetch_assoc($resultUsuarios);
						
						$paramsValidacion = array(
							"fechaInicio" => $inicio_f,
							"fechaFin"	=>	$fin_f,
							"motivo"	=> $c_mot_inc_gru,
							"dniUser" => $rowUsuarios['dni'],
							"cipUser"	=> $rowUsuarios['cip'],
							"modo" => "H"
						);
						$validacionAlertaObj = new ValidacionTraslape;
						
						$resultado = $validacionAlertaObj->run($paramsValidacion);
						if(count($resultado) > 0){
							$responseValidacion = array_merge($responseValidacion,$resultado);
						}
					}
		
					if(count($responseValidacion) > 0){
						echo json_encode($responseValidacion);
						exit();
					}

				
					$error = "1-Nota : Fechas de Lactancia. ".$fec_inc_ant. " - ".$fec_fin_inc_;				
					$observacion = trim($obs_gru) ."#". trim($error);

					// calcular el valor de la diferencia de fechas
					$fecha_hora_fin = $fec_inc_ant. ' ' .$hor_fin_inc;
					$fecha_hora_inicio = $fec_ini_inc;
					$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fecha_hora_inicio','$fecha_hora_fin'))*60) as dif";
					$res_calc = mysql_query($calc);
					$reg_calc = mysql_fetch_row($res_calc);
					$tiempo_cal = $reg_calc[0];
				
				for ($j = 1; $j < $nro_escogidos + 1 ; $j++) {
					
						$hor="select * from horarios_gestores_cot
						where dni='".$dni_escogidos[$j]."' ORDER BY 1 DESC LIMIT 1";
						//echo "<br>".$hor;
						$res_hor= mysql_query($hor);
									
						while ($reg_hor=mysql_fetch_row($res_hor)) {	
								$ch1		="select * from tb_usuarios where dni='$reg_hor[0]'";
								//echo $ch1;
								$res_ch1 	= mysql_query($ch1);
								$reg_ch1	= mysql_fetch_row($res_ch1);
							
								$hor_r		="select * from horarios_rrhh where cod_horario='$reg_hor[5]'";
								//echo $hor_r;
								$res_hor_r 	= mysql_query($hor_r);
								$reg_hor_r	= mysql_fetch_row($res_hor_r);
							
								/************************************/
										
								$date1 = $fec_inc_ant;
								$date2 = $fec_fin_inc_;
								//echo "<br>Dias: ".$diff;
								
								//echo "<br>".$date1."|".$date2;
							
							$d=0;									
							for ($contador = 0; $contador < $diff + 1; $contador++) {
										$d=$d+1;
										
										$NombreDia=get_nombre_dia($date1);
										$NombreCorto=substr($NombreDia, 0, 2);
										$validar=Obtener_valor($NombreCorto,$reg_hor_r[7]);
										$FEC_Ini=$date1." ".$reg_hor_r[5];
										$FEC_Fin=$date1." ".$reg_hor_r[6]; //no cambiar	
										/*
											echo "<br>".$NombreCorto."|".$reg_hor_r[7]."|";	
											
											echo "<br>fechaini".$FEC_Ini."|";
											echo "<br>fechafin".$FEC_Fin."|";
											echo "<BR>".$validar."|";
											*/
										if ($validar == 1) {		
												
												$paramsValidacion = array(
														"fechaInicio" => $FEC_Ini,
														"fechaFin"	=>	$FEC_Fin,
														"motivo"	=> $c_mot_inc_gru,
														"cipUser"	=> $reg_ch1[3]
												);
												$validacionAlertaObj = new ValidacionAlerta;
												$responseValidacion = $validacionAlertaObj->run($paramsValidacion);

												if (!$responseValidacion["error"]) {
														if (isset($responseValidacion["fechaInicio"])) {
																$FEC_Ini = $responseValidacion["fechaInicio"];
														}
														if (isset($responseValidacion["fechaFin"])) {
																$FEC_Fin = $responseValidacion["fechaFin"];
														}
														$sql_inc = 
																"INSERT INTO cab_incidencia 
																		(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias,estado_inc,fec_mov_est,usu_mov_est) VALUES ('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini', '$FEC_Fin','$observacion','$nro_escogidos', '$c_incidencia','','$tiempo_cal','$modo_gru', '$c_doid_gru','$dni_escogidos[$j]','1','$xest_inc',now(),'$iduser')";
														//echo $sql_inc;
														$res_sql 	= mysql_query($sql_inc);
												}
										}// if validar						
										$date1 = date("Y-m-d",strtotime($date1."+ 1 days"));
								} //cierre for
														
								/***********************************/
						} // cierre while
								
				}// cierre for
		} else {
		
			if ($_GET["modo_gru"]=="H"){  // Si modo es HORAS

				$dni_select = array_values(array_filter($dni_escogidos));
				$responseValidacion = array();
				foreach ($dni_select as $key => $value) {
					$queryUsuarios = "select * from horarios_gestores_cot where dni='".$value."' ORDER BY 1 DESC LIMIT 1";
					$resultUsuarios = mysql_query($queryUsuarios);
					$rowUsuarios = mysql_fetch_assoc($resultUsuarios);
					
					$paramsValidacion = array(
						"fechaInicio" => $fec_ini_inc,
						"fechaFin"	=>	$fec_fin_inc,
						"motivo"	=> $c_mot_inc_gru,
						"dniUser" => $rowUsuarios['dni'],
						"cipUser"	=> $rowUsuarios['cip'],
						"modo" => "H"
					);
					$validacionAlertaObj = new ValidacionTraslape;
					
					$resultado = $validacionAlertaObj->run($paramsValidacion);
					if(count($resultado) > 0){
						$responseValidacion = array_merge($responseValidacion,$resultado);
					}
				}
	
				if(count($responseValidacion) > 0){
					echo json_encode($responseValidacion);
					exit();
				}
				
					$f_ini_inc = explode(" ",$fec_ini_inc);				
					$f_fin_inc = explode(" ",$fec_fin_inc);				
					
					$hor_ini_inc 	= $f_ini_inc[1]; // captura el valor de solo la hora inicial 08:00				
					$fec_inc 		= $f_ini_inc[0]; // captura el valor de solo la fecha 2019-05-05
					$hor_fin_inc 	= $f_fin_inc[1];	// captura el valor de solo la hora final 10:00		
				
					$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
					//echo $cad;
					$rs = mysql_query($cad);
					$rg = mysql_fetch_array($rs);	
					$franq 	= limpia_espacios($rg[0]);
					$c_incidencia = "INC-".$franq;
					
					for ($i = 1; $i<$nro_escogidos + 1 ; $i++) {
							//validar_incidencia($dni_escogidos[$i],$fec_ini_inc,$fec_fin_inc,$c_mot_inc_gru);
							
							/* tranformo las fechas de horario */
							$c0=
								"select * from horarios_gestores_cot where dni='".$dni_escogidos[$i]."' ORDER BY 1 DESC LIMIT 1";
							//echo "<br>".$c0;
							$res_c0= mysql_query($c0);
							$reg_c0 = mysql_fetch_row($res_c0);
						
								$hor_ini_horario = $reg_c0[8];
								$hor_fin_horario = $reg_c0[9];
								
								/*			
								echo "<br>"."fec.total.ini.incidencia = ".$fec_ini_inc;
								echo "<br>"."fec.total.fin.incidencia= ".$fec_fin_inc;
								echo "<br>"."fec.incidencia= ".$fec_inc;
								echo "<br>"."hor.ini.incidencia= ".$hor_ini_inc;
								echo "<br>"."hor.fin.incidencia= ".$hor_fin_inc;
								echo "<br>"."hor_ini_horario = ".$hor_ini_horario;
								echo "<br>"."hor_fin_horario = ".$hor_fin_horario;
								*/
							if ($reg_c0[5]=="") {  // Si gestor se encuentra sin horario								
								$dif_tiempo   = "00:00";
								$error="2-Nota: Sin horarios registrado";									
								$xest = 3;	
							
							} else {	 // GESTORES CON HORARIOS
							
									// calcular el valor de la diferencia de fechas							
									$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini_inc','$fec_fin_inc'))*60) as dif";
									$res_calc = mysql_query($calc);
									$reg_calc = mysql_fetch_row($res_calc);
									
									if ($c_mot_inc_gru=="154"){								
										$dif_tiempo="-".$reg_calc[0];
									}else{
										$dif_tiempo = $reg_calc[0];
									}
									
									$xest = 0;	
									
									if ($hor_ini_inc <=  $hor_ini_horario and $hor_fin_inc >=  $hor_fin_horario ) { // fuera de rango al inicio y al final																											
										$error="0-Nota: Rango de fecha de incidencias exceden a las fechas de su horario";			
										} else { 
												if ($hor_ini_inc <=  $hor_ini_horario and $hor_fin_inc <= $hor_ini_horario )  { // antes del horario 
														$error="0-Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";				
												} else {// dentro del rango inicial 	
												
													if ($hor_ini_inc <=  $hor_ini_horario and $hor_fin_inc <= $hor_fin_horario ){ //fuera de rango al incio
													$error="0-Nota: Rango de fecha Inicio de incidencias exceden a las fechas Inicio de su horario";																		
													} else {
															if ($hor_ini_inc >=  $hor_ini_horario and $hor_fin_inc >= $hor_fin_horario) { // fuera de rango final
																	$error="0-Nota: Rango de fecha Final de incidencias exceden a las fechas Final de su horario";														
															}else{ // dentro del rango 
																	$error="1-Nota : Fechas de incidencias dentro de las fechas de horarios";														
															}
													}
												}					   
										}
							}//cerrar if
							$paramsValidacion = array(
									"fechaInicio" => $fec_ini_inc,
									"fechaFin"	=>	$fec_fin_inc,
									"motivo"	=> $c_mot_inc_gru,
									"dniUser"	=> $dni_escogidos[$i],
									"modo"	=>	$_GET["modo_gru"]
							);
							$validacionAlertaObj = new ValidacionAlerta;
							$responseValidacion = $validacionAlertaObj->run($paramsValidacion);
							if (!$responseValidacion["error"]) {
									if (isset($responseValidacion["fechaInicio"])) {
											$fec_ini_inc = $responseValidacion["fechaInicio"];
									}
									if (isset($responseValidacion["fechaFin"])) {
											$fec_fin_inc = $responseValidacion["fechaFin"];
									}
									$observacion = trim($obs_gru) ."#". trim($error);
									$sql_inc=
											"INSERT INTO cab_incidencia
													(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,
													tiempo,modo,cod_incidencia,c_doid,dni,dias,nro_participantes,estado_inc,fec_mov_est,usu_mov_est)
											VALUES	
													('','$cip',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$fec_ini_inc','$fec_fin_inc','$observacion',
													'$dif_tiempo','$modo_gru','$c_incidencia',
													'$c_doid_gru','$dni_escogidos[$i]','0','$nro_escogidos','$xest_inc',now(),'$iduser')";
											//echo "<br>".$sql_inc;	
											$res_1= mysql_query($sql_inc);	
													
											$msn_inc="SE REGISTRO LA INCIDENCIA PARA ".$cip." con codigo incidencia ".$c_incidencia."|$c_mot_gru - $c_mot_inc_gru";
														
											$sql_2="INSERT INTO movimiento_incidencias(id,estado,usu_mov,fec_mov,obs,dato,pc)
											VALUES(LAST_INSERT_ID(),'REGISTRO INCIDENCIA','$iduser',now(),'$msn_inc','$cip','$pc_asig')";
											//echo $sql_3;
											$res_2= mysql_query($sql_2);
														
											$sql_3= "UPDATE cab_incidencia SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9 and cod_incidencia='$c_incidencia'";
											$sql_3 	= mysql_query($sql_3) or die(mysql_error());
														
														
											$sql_4="update cab_incidencia a, tb_usuarios b set a.cip=b.cip where a.dni=b.dni and a.dni='$dni_escogidos[$i]' 
											and a.cod_incidencia='$c_incidencia'";
											//echo $sql_4;
											$res_4= mysql_query($sql_4);
							}				
				}//cerrar for
		} else {  // modo DIAS

			$dni_select = array_values(array_filter($dni_escogidos));
			$responseValidacion = array();
			foreach ($dni_select as $key => $value) {
				$queryUsuarios = "select * from horarios_gestores_cot where dni='".$value."' ORDER BY 1 DESC LIMIT 1";
				$resultUsuarios = mysql_query($queryUsuarios);
				$rowUsuarios = mysql_fetch_assoc($resultUsuarios);
				
				$paramsValidacion = array(
					"fechaInicio" => $fec_ini_inc,
					"fechaFin"	=>	$fec_fin_inc,
					"motivo"	=> $c_mot_inc_gru,
					"dniUser" => $rowUsuarios['dni'],
					"cipUser"	=> $rowUsuarios['cip'],
					"modo" => "D"
				);
				$validacionAlertaObj = new ValidacionTraslape;
				
				$resultado = $validacionAlertaObj->run($paramsValidacion);
				if(count($resultado) > 0){
					$responseValidacion = array_merge($responseValidacion,$resultado);
				}
			}

			if(count($responseValidacion) > 0){
				echo json_encode($responseValidacion);
				exit();
			}

				/*
				echo "<br>"."fec.total.ini.incidencia = ".$fec_ini_inc;
				echo "<br>"."fec.total.fin.incidencia= ".$fec_fin_inc;
				*/
				//Calculo de la marcha blanca
				if ($c_mot_inc_gru=="800") {
						$fec_ini_inc = $_GET["fec_ini"];			
						$fec_fin_inc = date("Y-m-d",strtotime($_GET["fec_ini"]."+ 2 month"));			
				} else {	
						$fec_ini_inc = $_GET["fec_ini"];		
						$fec_fin_inc = $_GET["fec_fin"];		
				}
				//echo $c_mot_inc_gru."|".$modo_gru."|".$fec_ini_inc."|".$fec_fin_inc;
		
				//if ($fec_ini_inc > $fec_fin_inc){ //Ricardo Flores
				if ($fec_ini_inc > $fec_fin_inc){ //Ricardo Flores
					$error = "0-Nota: La fecha inicial es mayor que la fecha final"; //Ricardo Flores
				} else { //Ricardo Flores
					$error = "1-Nota : Fechas de incidencias dentro de las fechas de horarios";
					
					$observacion = trim($obs_gru) ."#". trim($error);
					
					if ($fec_ini_inc == $fec_fin_inc) {					
						$dif_1 ="select 0";				
						
					} else {
						$dif_1 ="select datediff('$fec_fin_inc','$fec_ini_inc')";
						
					}
					//echo $dif_1;
					$res_dif_1 = mysql_query($dif_1);
					$reg_dif_1 = mysql_fetch_row($res_dif_1);
					$diff = $reg_dif_1[0];
					$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
					//echo $cad;
					$rs = mysql_query($cad);
					$rg = mysql_fetch_array($rs);	
					$franq 	= limpia_espacios($rg[0]);
					$c_incidencia = "INC-".$franq;
					
					for ($j = 1; $j < $nro_escogidos + 1 ; $j++) {
							$hor="select * from horarios_gestores_cot where dni='".$dni_escogidos[$j]."' ORDER BY 1 DESC LIMIT 1";
							//echo "<br>".$hor;
							$res_hor= mysql_query($hor);
									
							while ($reg_hor=mysql_fetch_row($res_hor)) {
									$ch1		="select * from tb_usuarios where dni='$reg_hor[0]'";
									//echo $ch1;
									$res_ch1 	= mysql_query($ch1);
									$reg_ch1	= mysql_fetch_row($res_ch1);
									
									$hor_r		="select * from horarios_rrhh where cod_horario='$reg_hor[5]'";
									//echo $hor_r;
									$res_hor_r 	= mysql_query($hor_r);
									$reg_hor_r	= mysql_fetch_row($res_hor_r);
									/************************************/
												
									$date1 = $fec_ini_inc;
									$date2 = $fec_fin_inc;

									//echo "<br>dif.dias=".$diff;
									$d=0;									
									for ($contador = 0; $contador < $diff + 1; $contador++) {
											$d=$d+1;
												
											$NombreDia=get_nombre_dia($date1);
											$NombreCorto=substr($NombreDia, 0, 2);
											$validar=Obtener_valor($NombreCorto,$reg_hor_r[7]);
											$FEC_Ini=$date1." ".$reg_hor_r[5];
											$FEC_Fin=$date1." ".$reg_hor_r[6]; //no cambiar
														
												//echo "<br>".$NombreCorto."|".$reg_hor_r[7]."|";	
												
												//echo "fechaini".$FEC_Ini."|";
												//echo "fechafin".$FEC_Fin."|";
												//echo "<BR>".$validar."|";
												
												if ($c_mot_inc_gru=="154") {								
													$tiempo_cal="-06:00:00";
												} else {
													$tiempo_cal="06:00:00";
												}
												
												if ($validar=="1") {
														$paramsValidacion = array(
																"fechaInicio"		=>	$FEC_Ini,
																"fechaFin"			=>	$FEC_Fin,
																"motivo"				=>	$c_mot_inc_gru,
																"cipUser"				=>	$reg_ch1[3]
														);
														$validacionAlertaObj = new ValidacionAlerta;
														$responseValidacion = $validacionAlertaObj->run($paramsValidacion);

														if (!$responseValidacion["error"]) {
																if (isset($responseValidacion["fechaInicio"])) {
																		$FEC_Ini = $responseValidacion["fechaInicio"];
																}
																if (isset($responseValidacion["fechaFin"])) {
																		$FEC_Fin = $responseValidacion["fechaFin"];
																}
																$sql_inc = "INSERT INTO cab_incidencia
																			(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
																			fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,										
																			c_doid,dni,dias,estado_inc,fec_mov_est,usu_mov_est)
																			VALUES	
																			('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini',																								
																			'$FEC_Fin','$observacion','$nro_escogidos',
																			'$c_incidencia','','$tiempo_cal','$modo_gru',
																			'$c_doid_gru','$dni_escogidos[$j]','1','$xest_inc',now(),'$iduser')";
																	//echo $sql_inc;
																	$res_sql 	= mysql_query($sql_inc);
														}
												}// if validar
												$date1 = date("Y-m-d",strtotime($date1."+ 1 days"));
									} //cierre for
									/***********************************/
							} // cierre while
					  }// cierre for
				}		//Ricardo Flores
			
				$error="1-Nota : Fechas de incidencias dentro de las fechas de horarios";
						
			} // cerrar if modo_gru
		
	}// cerrar if de lactancia
		echo $c_incidencia."|".$error;
	}	// cerrar if tiempo
	
		$pason="delete from lista_gestores_inc where cod_incidencia='$c_incidencia'";	
			//echo "<br>".$i.$paso2;	
		$res_pason = mysql_query($pason);
}

if ($accion=="eliminar_compensaciones"){
	$id = explode("|", $_GET["valor_escogido"]);		
	$nro_escogidos = $_GET["nro_escogidos"];
	
	
	for ($i = 1; $i < $nro_escogidos + 1 ; $i++) {
		//echo $id[$i].",";
		$sql="delete from cab_incidencia where id='$id[$i]'";	
		//echo "<br>".$sql;	
		$res = mysql_query($sql);		
	}
}


if ($accion=="grabar_motivos_inc"){
	$tipo_inc = $_GET["tipo_inc"];
	$motivo_inc = $_GET["motivo_inc"];
	$iduser = $_GET["iduser"];
	

	$sql0 = "select * from tb_motivos_incidencia where tp_inc='$tipo_inc' and nom_mot_inc='$motivo_inc' and est ='1'";
	//echo $sql0;
	$res = mysql_query($sql0);
	$nreg = mysql_num_rows($res);
	$reg=mysql_fetch_row($res);
	
	//echo "<br>".$nreg;
	
	if ($nreg<1){
		
		$sql_1 = "select max(cod_mot_inc) + 1 from tb_motivos_incidencia where tp_inc='$tipo_inc'";
		//echo "<br>".$sql_1;
		$res_1 = mysql_query($sql_1);		
		$reg_1 = mysql_fetch_row($res_1);
				
		$sql_2="insert into tb_motivos_incidencia values('$reg_1[0]','$motivo_inc','$tipo_inc','1','COT-TDP')";	
		//echo "<br>".$sql_2;	
		$res_2 = mysql_query($sql_2);
		
		$msn = "Se registro nuevo motivo "."\n"."\n";
		$msn = $msn."Motivo:  ".$motivo_inc."\n";
		$msn = $msn."Tipo:  ".$tipo_inc."\n";
		$msn = $msn."Codigo:  ".$reg_1[0]."\n";
		
		echo $msn;
	}else{
		echo "Ya se encuentra registrado";
	}	
	
	$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$dato = $tipo_inc."|".$motivo_inc;
		
	$mov ="INSERT INTO movimiento_mantenimientos(id,proceso,usu_mov,fec_mov,obs,pc,dato)
	VALUES(LAST_INSERT_ID(),'NUEVO REGISTRO DE LA TABLA tb_motivos_incidencia','$iduser',now(),'','$pc','$dato')";
	//echo $mov;
	$res_mov= mysql_query($mov);
}


if($accion=="detalle_maestra_reniec_gescot"){

	$dni=$_GET["dni"]; 
	
	$cc				= "select * from data_reniec where dni='$dni'";		 
				//echo $cc;
	$res_cc			= mysql_query($cc);
	$num_rows_cc	= mysql_num_rows($res_cc);
				
	echo "
	<table width='100%' border='0' cellpadding='0' cellspacing='0' class='marco_tabla'>"; 
	echo "
	  <tr>
		<td class='caja_texto_AMA'>APELLIDO PATERNO</td>
		<td class='caja_texto_AMA'>APELLIDO MATERNO</td>
		<td class='caja_texto_AMA'>NOMBRES</td>
		<td class='caja_texto_AMA'>FECHA NACIMIENTO</td> 
		<td class='caja_texto_AMA'>SEXO</td> 
	  </tr>";
	  
	  	  
	  if ($num_rows_cc>0){
		 
		while($reg_cc=mysql_fetch_row($res_cc)){	
		
				 $col_dni				=$reg_cc[0];			
				 $col_ape_pat			=$reg_cc[1];				
				 $col_ape_mat			=$reg_cc[2];
				 $col_nombre			=$reg_cc[3];			  
				 $col_fec_nacimiento	=$reg_cc[5];
				 $col_sexo				=$reg_cc[4];		 
				 
		echo "			
		  <tr>
			<td class='caja_texto_pe'><input name='APE_PAT' type='text' class='caja_texto_cb' id='APE_PAT' size='30' value='$col_ape_pat'  /></td>
			<td class='caja_texto_pe'><input name='APE_MAT' type='text' class='caja_texto_cb' id='APE_MAT' size='30' value='$col_ape_mat' /></td>
			<td class='caja_texto_pe'><input name='NOMBRES' type='text' class='caja_texto_cb' id='NOMBRES' size='30' value='$col_nombre' /></td>
			<td class='caja_texto_pe'><input name='fec_nacimiento' type='text' class='caja_texto_cb' id='fec_nacimiento' size='30' value='$col_fec_nacimiento' /></td>
			<td class='caja_texto_pe'><input name='sexo' type='text' class='caja_texto_cb' id='sexo' size='30' value='$col_sexo' /></td>
		  </tr>";
		  
		  		
		}
	 }else{
	 	echo "			
		  <tr>
			<td colspan='10' class='caja_texto_pe' align='center'>DNI NO SE ENCUENTRA REGISTRADO EN LA RENIEC</td>
		  </tr>";	 
	 }	 
	echo "</table>";
}


if ($accion=="grabar_olas"){
	$olas	= $_GET["olas"];	
	$iduser		= $_GET["iduser"];	
	$fec_ini	= $_GET["fec_ini"];	
	$fec_fin	= $_GET["fec_fin"];	
	
	$sql ="select ola from tb_olas where ola='$olas' and est='1'";
	//echo $sql;
	$res_sql = mysql_query($sql);
	$nreg = mysql_num_rows($res_sql);
	
	//echo $nreg;
	
	if ($nreg>0){
	echo "<a class='aviso_horario'>Ola ya se encuentra registrada</a>";
	
	}else{
	
	
	$sql_0="SELECT MAX(ord) FROM tb_olas where est='1'";
	$res_sql_0 = mysql_query($sql_0);
	$reg_sql_0=mysql_fetch_row($res_sql_0);
	$orden = $reg_sql_0[0]+1;
	
	
	$sql_1="insert into tb_olas(ola,fec1,fec2,est,ord) 
	values('$olas','$fec_ini','$fec_fin','1','$orden')";	
	//echo $sql_1;
	$res_1= mysql_query($sql_1);
	
	
	echo "Se registro ". $olas. " correctamente";	
	
	echo "<p>";
	
//        $ola = "select * from tb_olas where est='1' order by ord";
//        //echo $hor;
//        $res_ola = mysql_query($ola) or die(mysql_error());
//
//        echo "<table border='0' class='marco_tabla' width='50%'>";
//        echo "<tr>";
//        echo "<td class='celda_cab'>ITEM</td>";
//        echo "<td class='celda_cab'>OLA</td>";
//
//        $i = 0;
//
//        while ($reg_ola = mysql_fetch_row($res_ola)) {
//            $i = $i + 1;
//            echo "<tr>";
//            echo "<td class='caja_texto_peq'>$i</td>";
//            echo "<td class='caja_texto_peq'>$reg_ola[0]</td>";
//            echo "</tr>";
//        }
//        echo "</table>";
	}
}



if ($accion=="listar_olas"){
	
	$iduser		= $_GET["iduser"];	
	
	
	echo "<p>";
	
		$ola ="select * from tb_olas where est='1' order by ord";
		//echo $hor;
		$res_ola = mysql_query($ola) or die (mysql_error());
	
		echo "<table border='0' class='marco_tabla' width='50%'>";
				echo "<tr>";
				echo "<td class='celda_cab'>ITEM</td>";
				echo "<td class='celda_cab'>OLA</td>";
			   
			$i=0;
			
			while($reg_ola=mysql_fetch_row($res_ola)){	
					$i=$i+1;		
				echo "<tr>";
				echo "<td class='caja_texto_peq'>$i</td>";
				echo "<td class='caja_texto_peq'>$reg_ola[0]</td>";			
				echo "</tr>";
				}		
		echo "</table>";
}


if ($accion=="grabar_incidencia_masiva_nuevo"){
	
	$pc			= gethostbyaddr($_SERVER['REMOTE_ADDR']);	
	
	$iduser=$_GET["iduser"];
	//$c_incidencia=limpia_espacios($_GET["c_incidencia"]);
	$c_supervisor=$_GET["c_supervisor"];
	$c_mot_mas=$_GET["c_mot_mas"];
	$c_mot_inc_mas=$_GET["c_mot_inc_mas"];
	$modo_mas=$_GET["modo_mas"];
	
	$obs_mas=trim($_GET["obs_mas"]);
	$c_doid_mas=$_GET["c_doid_mas"];	
	$opc=$_GET["opc"];
	$combo=$_GET["combo"];

	$fec_ini_inc	=$_GET["fec_ini"];	
	$fec_fin_inc	=$_GET["fec_fin"];	
		
	$obs=trim(quitar_tildes($_GET["obs"]));

				$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
				//echo $cad;
				$rs = mysql_query($cad);
				$rg = mysql_fetch_array($rs);	
				$franq 	= limpia_espacios($rg[0]);
				$c_incidencia = "MAS-".$franq;
			
		//echo $c_mot_inc_gru."|".$modo_gru."|".$fec_ini_inc."|".$fec_fin_inc;
		
			//if ($fec_ini_inc > $fec_fin_inc){ //Ricardo Flores
			if ($fec_ini_inc > $fec_fin_inc){ //Ricardo Flores
				$error = "0-Nota: La fecha inicial es mayor que la fecha final"; //Ricardo Flores				
			
			}else{ //Ricardo Flores					
			
				
				if ($fec_ini_inc == $fec_fin_inc){					
					$dif_1 ="select 0";				
					
				}else{
					$dif_1 ="select datediff('$fec_fin_inc','$fec_ini_inc')";
					
				}
				//echo $dif_1;
				$res_dif_1 = mysql_query($dif_1);
				$reg_dif_1 = mysql_fetch_row($res_dif_1);
				$diff = $reg_dif_1[0];
							
						/************************************/
									
						$date1 = $fec_ini_inc;
						$date2 = $fec_fin_inc;
						
						
						
						//echo "<br>dif.dias=".$diff;
						$d=0;									
						for ($contador = 0; $contador < $diff + 1; $contador++) {
										$d=$d+1;
									
										$NombreDia=get_nombre_dia($date1);
										$NombreCorto=substr($NombreDia, 0, 2);
										$validar=Obtener_valor($NombreCorto,'1111111');
										$FEC_Ini=$date1." "."08:00";
										$FEC_Fin=$date1." "."22:00"; //no cambiar
										
										
										//echo "<br>".$NombreCorto."|".$reg_hor_r[7]."|";	
										
										//echo "fechaini".$FEC_Ini."|";
										//echo "fechafin".$FEC_Fin."|";
										
										
										//echo "<BR>".$validar."|";
										
									
										
										if ($validar=="1"){									
										
										
										
										$sql_inc = "INSERT INTO cab_incidencia
												(id,cip,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,
												fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,										
												c_doid,dni,dias,estado_inc,fec_mov_est,usu_mov_est)
												VALUES	
												('','$reg_ch1[3]',now(),'$iduser','$c_mot_gru','$c_mot_inc_gru','$FEC_Ini',																								
												'$FEC_Fin','$observacion','$nro_escogidos',
												'$c_incidencia','','$tiempo_cal','$modo_gru',
												'$c_doid_gru','$c_supervisor','1','$xest_inc',now(),'$iduser')";
										//echo $sql_inc;
										$res_sql 	= mysql_query($sql_inc);
										
										
										
										}// if validar
									$date1 = date("Y-m-d",strtotime($date1."+ 1 days"));	
										
								
				}// cierre for
				
				
			}		//Ricardo Flores
		
		echo "Codigo de Averia Masiva : ".$c_incidencia;
	
	
 
}

if ($accion=="eliminar_detalle_incidencia"){
	$inc = $_GET["c_incidencia"];		
	$dni = $_GET["dni"];
	$fecha = $_GET["fecha"];
	
	//echo $id[$i].",";
	$sql="delete from cab_incidencia where cod_incidencia='$inc' and dni='$dni' and fec_ini_inc='$fecha'";	
	//echo "<br>".$sql;	
	$res = mysql_query($sql);		
}

if ($accion=="cargar_horarios_csv"){
	ini_set('max_execution_time', 300);
	if(isset($_FILES['file'])){
    $filename=$_FILES["file"]["name"];
	$info = new SplFileInfo($filename);
	$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
	$q1= "DELETE FROM horario_cot_mes";
	mysql_query($q1);

		if($extension == 'csv'){
			$filename = $_FILES['file']['tmp_name'];
			$handle = fopen($filename, "r");
			//Verificamos la cantidad de columnas
			$linea_texto = FGETS($handle, 4096);
			$explode_valores = explode(';', $linea_texto);
			// no debe superar las 6 columnas
			if(count($explode_valores) == 6){

				while( ($data = fgetcsv($handle, 1000, ";") ) !== FALSE ){
						$q = "INSERT INTO horario_cot_mes (Mes, CIP, NCOMPLETO, FECHA_INICIO, COD_HORARIO, FECHA_FIN) VALUES (
						'$data[0]', 
						'$data[1]',
						'$data[2]',
						'$data[3]',
						'$data[4]',
						'$data[5]'
					)";
					
					mysql_query($q);
				}

				fclose($handle);

				mysql_query("CALL procesar_horarios_cot_mes()");

				echo "<p class='ok_color'> REPORTE CARGADO CORRECTAMENTE !!!<img src='image/ok-icon.png' width='17px' height='17px'/></p>";
			
			}else{

				echo "<p class='warning_color'>El archivo tiene mas o menos columnas de lo que se esperaba. <img src='image/warning.png' width='17px' height='17px'/></p>";
			
			}
		
		}else{
			echo "<p class='warning_color'>Seleccione un archivo valido. <img src='image/warning.png' width='17px' height='17px'/></p>";
		}

	}else{
		echo "<p class='warning_color'>Eliga un archivo. <img src='image/warning.png' width='17px' height='17px'/></p>";
	}
}

?>





