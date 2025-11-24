<?PHP
include("conexion_bd.php");
include("conexion_ftp.php");

		
set_time_limit(5000);

	/*****************************************************************************************/
	//$cms="D:/data_cot/CMS/tb_cms.csv";
	
	//$cms="a:/asignaciones/tb_cms_".date("d").date("m").date("y").".csv";	
	$cms="D:/COMPARTIDO/DATA/CMS/tb_cms_".date("d").date("m").date("y").".csv";	
	

	mysql_query("truncate table tb_cms_tmp") ; 
		
	$sql="LOAD DATA LOCAL INFILE '$cms'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql;
	$res_sql = mysql_query($sql);
	
	
	/*
	$arch_are="a:/asignaciones/arequipa.csv";	
	$sql_are="LOAD DATA LOCAL INFILE '$arch_are'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_are = mysql_query($sql_are);
	
	$sql_are1="update tb_cms_tmp set Ofc_Adm='ARE' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_are1 = mysql_query($sql_are1);
	
	
	$arch_piu="a:/asignaciones/piura.csv";	
	$sql_piu="LOAD DATA LOCAL INFILE '$arch_piu'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_piu = mysql_query($sql_piu);
	
	$sql_piu1="update tb_cms_tmp set Ofc_Adm='PIU' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_piu1 = mysql_query($sql_piu1);
	
	$arch_chi="a:/asignaciones/chiclayo.csv";	
	$sql_chi="LOAD DATA LOCAL INFILE '$arch_chi'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_chi = mysql_query($sql_chi);
	
	$sql_chi1="update tb_cms_tmp set Ofc_Adm='CHI' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_chi1 = mysql_query($sql_chi1);
	
	
	$arch_chb="a:/asignaciones/chimbote.csv";	
	$sql_chb="LOAD DATA LOCAL INFILE '$arch_chb'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_chb = mysql_query($sql_chb);
	
	$sql_chb1="update tb_cms_tmp set Ofc_Adm='CHB' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_chb1 = mysql_query($sql_chb1);
	
	
	$arch_hyo="a:/asignaciones/huancayo.csv";
	$sql_hyo="LOAD DATA LOCAL INFILE '$arch_hyo'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_hyo = mysql_query($sql_hyo);
	
	$sql_hyo1="update tb_cms_tmp set Ofc_Adm='HUA' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_hyo1 = mysql_query($sql_hyo1);
	
	$arch_tru="a:/asignaciones/trujillo.csv";	
	$sql_tru="LOAD DATA LOCAL INFILE '$arch_tru'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_tru = mysql_query($arch_tru);
	
	$sql_tru1="update tb_cms_tmp set Ofc_Adm='TRU' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_tru1 = mysql_query($sql_tru1);
	

	$arch_cus="a:/asignaciones/cusco.csv";
	$sql_cus="LOAD DATA LOCAL INFILE '$arch_cus'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_cus = mysql_query($sql_cus);
	
	$sql_cus1="update tb_cms_tmp set Ofc_Adm='CUS' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_cus1 = mysql_query($sql_cus1);
	
	$arch_lim="a:/asignaciones/lima.csv";
	$sql_lim="LOAD DATA LOCAL INFILE '$arch_lim'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_lim = mysql_query($sql_lim);
	
	$sql_lim1="update tb_cms_tmp set Ofc_Adm='LIM' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_lim1 = mysql_query($sql_lim1);
	

	$arch_uca="a:/asignaciones/ucayali.csv";
	$sql_uca="LOAD DATA LOCAL INFILE '$arch_uca'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_uca = mysql_query($sql_uca);
	
	$sql_uca1="update tb_cms_tmp set Ofc_Adm='UCA' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_uca1 = mysql_query($sql_uca1);

	$arch_smt="a:/asignaciones/SANMARTIN.csv";
	$sql_smt="LOAD DATA LOCAL INFILE '$arch_smt'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_smt = mysql_query($sql_smt);
	
	$sql_smt1="update tb_cms_tmp set Ofc_Adm='SMP' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_smt1 = mysql_query($sql_smt1);
	
	$arch_hno="a:/asignaciones/huanuco.csv";
	$sql_hno="LOAD DATA LOCAL INFILE '$arch_hno'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_hno = mysql_query($sql_hno);
	
	$sql_hno1="update tb_cms_tmp set Ofc_Adm='HCO' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_hno1 = mysql_query($sql_hno1);
	
	
	$arch_caj="a:/asignaciones/cajamarca.csv";
	$sql_caj="LOAD DATA LOCAL INFILE '$arch_caj'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_caj = mysql_query($sql_caj);
	
	$sql_caj1="update tb_cms_tmp set Ofc_Adm='CAJ' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_caj1 = mysql_query($sql_caj1);
	

	$arch_aya="a:/asignaciones/ayacucho.csv";
	$sql_aya="LOAD DATA LOCAL INFILE '$arch_aya'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_aya = mysql_query($sql_aya);
	
	$sql_aya1="update tb_cms_tmp set Ofc_Adm='AYA' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_aya1 = mysql_query($sql_aya1);
	
	
	$arch_tum="a:/asignaciones/tumbes.csv";
	$sql_tum="LOAD DATA LOCAL INFILE '$arch_tum'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_tum = mysql_query($sql_tum);
	
	$sql_tum1="update tb_cms_tmp set Ofc_Adm='TUM' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_tum1 = mysql_query($sql_tum1);
	
	$arch_pun="a:/asignaciones/puno.csv";
	$sql_pun="LOAD DATA LOCAL INFILE '$arch_pun'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_pun = mysql_query($sql_pun);
	
	$sql_pun1="update tb_cms_tmp set Ofc_Adm='PUN' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_pun1 = mysql_query($sql_pun1);
	
	
	$arch_ica="a:/asignaciones/ica.csv";
	$sql_ica="LOAD DATA LOCAL INFILE '$arch_ica'
	INTO TABLE tb_cms_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_are;
	$res_sql_ica= mysql_query($sql_ica);
	
	$sql_ica1="update tb_cms_tmp set Ofc_Adm='ICA' WHERE Ofc_Adm in ('',null)";	
	//echo "<p>".$sql_are;
	$res_sql_ica1 = mysql_query($sql_ica1);
	
	*/
	
	$sql_1="DELETE FROM tb_cms_tmp WHERE n_requer in('','N')";			
		//echo "<br>".$sql;
	$res_1 = mysql_query($sql_1) or die(mysql_error());	
	
	$sql_2="UPDATE tb_cms_tmp a,  cab_asignaciones_cot b
	SET a.est=b.estado_asig 
	WHERE a.peticion=b.peticion";			
		//echo "<br>".$sql;
	$res_2 = mysql_query($sql_2) or die(mysql_error());	
	
	$sql_3="UPDATE tb_cms_tmp SET Ofc_Adm=F_Prg_MM
			WHERE TRIM(Ofc_adm) NOT IN ('AMA','APU','ARE','AYA','CAJ','CHI','CTE','CUS','HCV',
			'HNC','HUA','ICA','LIM','LOR','MDD','MOQ','PAS','PIU','PUN',
			'PUN','SMT','TAC','TRU','TUM','UCA')";
		//echo "<BR>".$sql_3;
	$res_3 = mysql_query($sql_3) or die(mysql_error($sql_3));
	
	
	$sql_4="INSERT IGNORE INTO tb_cms
	select * from tb_cms_tmp";
	$res_sql_4= mysql_query($sql_4) or die(mysql_error($sql_4));	
	
	
	$sql_5="UPDATE tb_cms_tmp a,  cab_asignaciones_cot b
	SET a.est=b.estado_asig 
	WHERE a.peticion=b.peticion";			
		//echo "<br>".$sql;
	$res_5 = mysql_query($sql_5) or die(mysql_error($sql_5));	
	
	$sql_6="INSERT IGNORE INTO tb_cms_total
	SELECT *,now() FROM tb_cms";			
	//echo "<br>".$sql;
	$res_6 = mysql_query($sql_6) or die(mysql_error($sql_6));
	
	$sql_7="INSERT ignore into carga_pedidos_total
		(SELECT n_requer,peticion,cliente,CONCAT(via,',',TRIM(direccion),urb,',',nombre_urb,'-',referencia)
		 AS  direccion,CONCAT(SUBSTR(fecha_llegada,7,4),'-',
		 SUBSTR(fecha_llegada,4,2),'-',SUBSTR(fecha_llegada,1,2),' ',
		 SUBSTR(fecha_llegada,12,5)) AS fec,'CMS','0',trim(Ofc_Adm)
		FROM tb_cms)";
		//echo "<BR>".$sql_14;
	$res_sql_7 = mysql_query($sql_7) or die(mysql_error($sql_7));
	
	$sql_8="UPDATE carga_pedidos_total a, cab_asignaciones_cot b
		SET a.estado=b.estado_asig 
		WHERE a.peticion=b.peticion";
		//echo "<BR>".$sql_3;
	$res_sql_8 = mysql_query($sql_8) or die(mysql_error($sql_8));
	
?>