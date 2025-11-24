<?PHP
include("conexion_bd.php");
include("conexion_ftp.php");

		
	set_time_limit(5000);
	
	mysql_query("truncate table tb_cms") ; 
	
	$cms="D:/COMPARTIDO/DATA/CMS/tb_cms_".date("d").date("m").date("y").".csv";	
	
	echo $cms;
	$row = 1 ;	
	$fp = fopen($cms, "r");
	
	while (!feof($fp) ) {
		//$linea = fread($fp,8192);
		
		$linea  = fgets($fp);	
		
		//echo "<br>".$row;
		
		if($row > 1){ // a partir de la linea 20
		
		$linea = explode(",", $linea);

		$col					=$linea[0];
		$n_requer				=$linea[1];
		$Area_Ant				=$linea[2];
		$AREA					=$linea[3];
		$Cliente				=$linea[4];
		$VIP					=$linea[5];
		$CORP					=$linea[6];
		$Agendado				=$linea[7];
		$En_Gaudi				=$linea[8];
		$Seg_Gaudi				=$linea[9];
		$PAI					=$linea[10];
		$Nivel_Ubic				=$linea[11];
		$Peticion				=$linea[12];
		$MultiServicio			=$linea[13];
		$Tipo_Deco				=$linea[14];
		$T_Rq					=$linea[15];
		$Motv					=$linea[16];
		$Descripcion_Motivo		=$linea[17];
		$Cod_Cmts				=$linea[18];
		$Descrip_Cmts			=$linea[19];
		$Nodo					=$linea[20];
		$Plano					=$linea[21];
		$Troncal				=$linea[22];
		$Sector					=$linea[23];
		$Line_Ext				=$linea[24];
		$Tap					=$linea[25];
		$Borne					=$linea[26];
		$Numcoo_X				=$linea[27];
		$Numcoo_Y				=$linea[28];
		$Dist					=$linea[29];
		$Via					=$linea[30];
		$Direccion				=quitar_tildes($linea[31]);
		$Numero					=$linea[32];
		$INT					=$linea[33];
		$Piso					=$linea[34];
		$Mzn					=$linea[35];
		$Lote					=$linea[36];
		$Urb					=$linea[37];
		$Nombre_Urb				=quitar_tildes($linea[38]);
		$Referencia				=quitar_tildes($linea[39]);
		$Clase_Srv				=quitar_tildes($linea[40]);
		$Señal_de_la_Troba		=$linea[41];
		$_Cr					=$linea[42];
		$Premium				=$linea[43];
		$N_Cross				=$linea[44];
		$Categoria_Srv			=$linea[45];
		$Tlf					=$linea[46];
		
		if ($linea[46]!=""){
			$Fecha_Llegada=$linea[48];
			$Sit="";
		}else{
			$Fecha_Llegada=$linea[47];
			$Sit=$linea[48];
		}				
		$Edo					=$linea[49];
		$Motv_					=$linea[50];
		$Ofc_Adm				=trim($linea[51]);
		$F_Prg_MM				=$linea[52];
		$Prior					=$linea[53];
		$Observaciones			=$linea[54];
		$Autorizacion			=$linea[55];
		$Cod_Autorizacion		=$linea[56];
		$Contacto_Clte			=$linea[57];
		$Cliente_Conforme		=$linea[58];
		$Tel_Contacto_CCT		=$linea[59];
		$Tel_Contacto_REF_CCT	=$linea[60];
		$Mot_Autorizacion		=$linea[61];
		$DescMot_Autorizcion	=$linea[62];
		$Escenario_Autorizacion	=$linea[63];
		$Tecnico				=$linea[64];
		$Nombre_Tecnico			=$linea[65];
		$Fec_Autorizacion		=$linea[66];
		$Usu_Autorizacion		=$linea[67];
		$Encuesta				=$linea[68];
		$Contacto_Enc			=$linea[69];
		$Parentesco_Enc			=$linea[70];
		$Telefono_Enc			=$linea[71];
		$Incidencia				=$linea[72];
		$Ticket_Incidencia		=$linea[73];
		$Seg_Incidencia			=$linea[74];
		$Resegmentacion			=$linea[75];
		$Tipo_Paquete			=$linea[76];
		$N_OS					=$linea[77];
		$Estado_OS				=$linea[78];
		$Tipo_Linea				=$linea[79];
		$NroTlfVOIP				=$linea[80];
		$PromLinea				=$linea[81];
		$Descripcion_Prom_Linea	=$linea[82];
		$Tipo_Tecnologia		=$linea[83];
		$zon					=$linea[84];
		$zon1					=$linea[85];
		$est					=$linea[86];

		
	/*	
	echo "<br>".$col."|".$n_requer."|".$Area_Ant."|".$AREA."|".$Cliente."|".$VIP."|".$CORP."|".$Agendado."|".$En_Gaudi."|".$En_Gaudi."|".$PAI."|".$Nivel_Ubic."|".$Peticion."|".$MultiServicio."|".$Tipo_Deco."|".$T_Rq."|".$Motv."|".$Descripcion_Motivo."|".$Cod_Cmts."|".$Descrip_Cmts."|".$Nodo."|".$Plano."|".$Troncal."|".$Sector."|".$Line_Ext."|".$Tap."|".$Borne."|".$Numcoo_X."|".$Numcoo_Y."|dist".$Dist."|via".$Via."|dire".$Direccion."|".$Numero."|".$INT."|".$Piso."|".$Mzn."|".$Lote."|".$Urb."|".$Nombre_Urb."|".$Referencia."|".$Clase_Srv."|".$Señal_de_la_Troba."|".$_Cr."|".$Premium."|".$N_Cross."|".$Categoria_Srv."|".$Tlf."|".$Fecha_Llegada."|".$Sit."|".$Edo."|".$Motv_."|".$Ofc_Adm."|".$F_Prg_MM."|".$Prior."|".$Observaciones."|".$Autorizacion."|".$Cod_Autorizacion."|".$Contacto_Clte."|".$Cliente_Conforme."|".$Tel_Contacto_CCT."|".$Tel_Contacto_REF_CCT."|".$Mot_Autorizacion."|".$DescMot_Autorizcion."|".$Escenario_Autorizacion."|".$Tecnico."|".$Nombre_Tecnico."|".$Fec_Autorizacion."|".$Usu_Autorizacion."|".$Encuesta."|".$Contacto_Enc."|".$Parentesco_Enc."|".$Telefono_Enc."|".$Incidencia."|".$Ticket_Incidencia."|".$Seg_Incidencia."|".$Resegmentacion."|".$Tipo_Paquete."|".$N_OS."|".$Estado_OS."|".$Tipo_Linea."|".$NroTlfVOIP."|".$PromLinea."|".$Descripcion_Prom_Linea."|".$Tipo_Tecnologia."|".$zon."|".$zon1."|".$est."<br>";	
	*/
	
	
	
	$sql_0="INSERT INTO tb_cms(col,n_requer,Area_Ant,AREA_,Cliente,VIP,CORP,Agendado,En_Gaudi,Seg_Gaudi,PAI,
Nivel_Ubic,Peticion,MultiServicio,Tipo_Deco,T_Rq,Motv,Descripcion_Motivo,Cod_Cmts,Descrip_Cmts,Nodo,
Plano,Troncal,Sector,Line_Ext,Tap,Borne,Numcoo_X,Numcoo_Y,Dist,Via,Direccion,Numero,INT_,
Piso,Mzn,Lote,Urb,Nombre_Urb,Referencia,Clase_Srv,Senal_de_la_Troba,_Cr,Premium,N_Cross,Categoria_Srv,
Tlf,Fecha_Llegada,Sit,Edo,Motv_,Ofc_Adm,F_Prg_MM,Prior,Observaciones,Autorizacion,Cod_Autorizacion,Contacto_Clte,
Cliente_Conforme,Tel_Contacto_CCT,Tel_Contacto_REF_CCT,Mot_Autorizacion,DescMot_Autorizcion,Escenario_Autorizacion,
Tecnico, Nombre_Tecnico,Fec_Autorizacion,Usu_Autorizacion,Encuesta,Contacto_Enc,Parentesco_Enc,Telefono_Enc,Incidencia,
Ticket_Incidencia,Seg_Incidencia,Resegmentacion,Tipo_Paquete,N_OS,Estado_OS,Tipo_Linea,NroTlfVOIP,PromLinea,
Descripcion_Prom_Linea,Tipo_Tecnologia,zon,zon1,est) 
VALUES ('$col','$n_requer','$Area_Ant','$AREA','$Cliente','$VIP','$CORP','$Agendado','$En_Gaudi','$Seg_Gaudi','$PAI','$Nivel_Ubic','$Peticion','$MultiServicio','$Tipo_Deco','$T_Rq','$Motv','$Descripcion_Motivo','$Cod_Cmts','$Descrip_Cmts','$Nodo','$Plano','$Troncal','$Sector','$Line_Ext','$Tap','$Borne','$Numcoo_X','$Numcoo_Y','$Dist','$Via','$Direccion','$Numero','$INT','$Piso','$Mzn','$Lote','$Urb','$Nombre_Urb','$Referencia','$Clase_Srv','$Senal_de_la_Troba','$_Cr','$Premium','$N_Cross','$Categoria_Srv','$Tlf','$Fecha_Llegada','$Sit','$Edo','$Motv_','$Ofc_Adm','$F_Prg_MM','$Prior','$Observaciones','$Autorizacion','$Cod_Autorizacion','$Contacto_Clte','$Cliente_Conforme','$Tel_Contacto_CCT','$Tel_Contacto_REF_CCT','$Mot_Autorizacion','$DescMot_Autorizcion','$Escenario_Autorizacion','$Tecnico','$Nombre_Tecnico','$Fec_Autorizacion','$Usu_Autorizacion','$Encuesta','$Contacto_Enc','$Parentesco_Enc','$Telefono_Enc','$Incidencia','$Ticket_Incidencia','$Seg_Incidencia','$Resegmentacion','$Tipo_Paquete','$N_OS','$Estado_OS','$Tipo_Linea','$NroTlfVOIP','$PromLinea','$Descripcion_Prom_Linea','$Tipo_Tecnologia','$zon','$zon1','$est');";
		
		
			
		//echo "<br>".$sql_0;
		$res_0 = mysql_query($sql_0);
		
		}
		$row++;
	}
	fclose($fp);	

	
	
	$sql_1="DELETE FROM tb_cms WHERE n_requer in('','N',' ')";			
		//echo "<br>".$sql;
	$res_1 = mysql_query($sql_1) or die(mysql_error());	
		
	
	$sql_3="UPDATE tb_cms SET Ofc_Adm=trim(F_Prg_MM)
			WHERE TRIM(Ofc_adm) NOT IN ('AMA','APU','ARE','AYA','CAJ','CHI','CTE','CUS','HCV',
			'HNC','HUA','ICA','LIM','LOR','MDD','MOQ','PAS','PIU','PUN',
			'PUN','SMT','TAC','TRU','TUM','UCA')";
		//echo "<BR>".$sql_3;
	$res_3 = mysql_query($sql_3) or die(mysql_error($sql_3));
	
	/*
	$sql_4="INSERT IGNORE INTO tb_cms
	select * from tb_cms_tmp";
	$res_sql_4= mysql_query($sql_4) or die(mysql_error($sql_4));
	*/
	
	$sql_5="UPDATE tb_cms a,  cab_asignaciones_cot b
	SET a.est=b.estado_asig 
	WHERE a.peticion=b.peticion";			
		//echo "<br>".$sql;
	$res_5 = mysql_query($sql_5) or die(mysql_error($sql_5));	
	
	$sql_6="INSERT IGNORE INTO tb_cms_total
	SELECT * FROM tb_cms";			
	//echo "<br>".$sql;
	$res_6 = mysql_query($sql_6) or die(mysql_error($sql_6));
	
	$sql_7="INSERT ignore into carga_pedidos_total
		(SELECT n_requer,peticion,cliente,CONCAT(via,',',TRIM(direccion),urb,',',nombre_urb,'-',referencia)
		 AS  direccion,CONCAT(SUBSTR(fecha_llegada,7,4),'-',
		 SUBSTR(fecha_llegada,4,2),'-',SUBSTR(fecha_llegada,1,2),' ',
		 SUBSTR(fecha_llegada,12,5)) AS fec,'CMS','0',trim(Ofc_Adm)
		FROM tb_cms order by 4)";
		//echo "<BR>".$sql_14;
	$res_sql_7 = mysql_query($sql_7) or die(mysql_error($sql_7));
	
	$sql_8="UPDATE carga_pedidos_total a, cab_asignaciones_cot b
		SET a.estado=b.estado_asig 
		WHERE a.peticion=b.peticion";
		//echo "<BR>".$sql_3;
	$res_sql_8 = mysql_query($sql_8) or die(mysql_error($sql_8));
	
	echo "PROCESO DE CARGA CMS TERMINADO";	
	
?>