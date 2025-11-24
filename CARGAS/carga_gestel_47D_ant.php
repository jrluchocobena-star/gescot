<?


include("../conexion_bd.php");
//include("../funciones_fecha.php");

set_time_limit(5000);
	//$tabla = "tb_gestel_423";


$row=0;
	
mysql_query("truncate table gestel_47d") ;	
	
//$fileName = "d:/data_cot/Reasignaciones_47D/GESTEL_47D_LIM.txt";	




		$zon="LIM";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_LIM.txt Satisfactoriamente";
		$sw=2;

		$zon="ARE";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_ARE.txt Satisfactoriamente";
		$sw=3;

		$zon="CHB";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;			
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_CHB.txt Satisfactoriamente";
		$sw=4;
		//echo "<br>"."proceso 3 terminado";

		$zon="CHY";		
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
			
		echo "<br>"."Se cargo el archivo GESTEL_47D_CHY.txt Satisfactoriamente";	
		carga_tabla_GESTEL_47D($fileName,$zon);		
		$sw=5;
		//echo "<br>"."proceso 3 terminado";

		$zon="ICA";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_ICA.txt Satisfactoriamente";
		$sw=6;
		//echo "<br>"."proceso 3 terminado";
	
		$zon="CUZ";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		carga_tabla_GESTEL_47D($fileName,$zon);		
		echo "<br>"."Se cargo el archivo GESTEL_47D_CUZ.txt Satisfactoriamente";	
		$sw=7;
		//echo "<br>"."proceso 3 terminado";

		$zon="HYO";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		carga_tabla_GESTEL_47D($fileName,$zon);		
		echo "<br>"."Se cargo el archivo GESTEL_47D_HYO.txt Satisfactoriamente";	
		$sw=8;
		//echo "<br>"."proceso 3 terminado";

		$zon="PIU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";		
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
				
		carga_tabla_GESTEL_47D($fileName,$zon);			
		echo "<br>"."Se cargo el archivo GESTEL_47D_PIU.txt Satisfactoriamente";	
		$sw=9;
		//echo "<br>"."proceso 3 terminado";
	
		$zon="TRU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_TRU.txt Satisfactoriamente";			
		$sw=10;
		//echo "<br>"."proceso 3 terminado";

		$zon="IQU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		carga_tabla_GESTEL_47D($fileName,$zon);
		echo "<br>"."Se cargo el archivo GESTEL_47D_IQU.txt Satisfactoriamente";				
		$sw=11;
		//echo "<br>"."proceso 3 terminado";

		$ini=date("Y-m-d H:m");
		echo "<br>"."PROCESO DE CARGA FINALIZADO......";
		archivo_log($ini,'USER_WIN','CARGA GESTEL 47D','1. ARCHIVOS IMPORTADOS OK ');




function carga_tabla_GESTEL_47D($fileName,$zon){	
		
	//echo "<br>".$fileName."<br>";
	
	$gestel_47D = fopen($fileName, "r");
	
	while (!feof($gestel_47D) ) {
		//$linea = fread($gestel_47D,8192);
		$linea  = fgets($gestel_47D);			
		$row=$row+1;		
		//echo $linea;
		if ($zon=="LIM"){
			$lin=13;	
		}else{
			$lin=14;
		}
		
		if ($row>$lin){
		$fecha = trim(substr($linea, 2, 18));
		if($fecha==""){$fecha='X';}else{$fecha=$fecha;}
		
		$Comprob = trim(substr($linea, 20, 10));
		if($Comprob==""){$Comprob='X';}else{$Comprob=$Comprob;}
		
		$Inscripcion = trim(substr($linea, 30, 10));
		if($Inscripcion==""){$Inscripcion='X';}else{$Inscripcion=$Inscripcion;}
		
		$Solicitud = trim(substr($linea, 40, 10));
		if($Solicitud==""){$Solicitud='X';}else{$Solicitud=$Solicitud;}
		
		$Usuario = trim(substr($linea, 50, 10));
		if($Usuario==""){$Usuario='X';}else{$Usuario=$Usuario;}
		
		$CodSol = trim(substr($linea, 60, 8));
		if($CodSol==""){$CodSol='X';}else{$CodSol=$CodSol;}
		
		$Motivo = trim(substr($linea, 69, 30));
		if($Motivo==""){$Motivo='X';}else{$Motivo=$Motivo;}
		
		$Pedido = trim(substr($linea, 88, 10));
		if($Pedido==""){$Pedido='X';}else{$Pedido=$Pedido;}
		
		$Red = trim(substr($linea, 98, 15));
		if($Red==""){$Red='X';}else{$Red=$Red;}
		
		$MDFo = trim(substr($linea, 114, 5));
		if($MDFo==""){$MDFo='X';}else{$MDFo=$MDFo;}
		
		$Cabl = trim(substr($linea, 120, 5));
		if($Cabl==""){$Cabl='X';}else{$Cabl=$Cabl;}
		
		$PAli = trim(substr($linea, 126, 5));
		if($PAli==""){$PAli='X';}else{$PAli=$PAli;}
		
		$Armar = trim(substr($linea, 131, 5));
		if($Armar==""){$Armar='X';}else{$Armar=$Armar;}
		
		$Bloq = trim(substr($linea, 136, 5));
		if($Bloq==""){$Bloq='X';}else{$Bloq=$Bloq;}
		
		$PDis = trim(substr($linea, 141, 5));
		if($PDis==""){$PDis='X';}else{$PDis=$PDis;}
		
		$Caja = trim(substr($linea, 146, 5));
		if($Caja==""){$Caja='X';}else{$Caja=$Caja;}
		
		$Born = trim(substr($linea, 151, 5));
		if($Born==""){$Born='X';}else{$Born=$Born;}
		
		$MDFd = trim(substr($linea, 156, 5));
		if($MDFd==""){$MDFd='X';}else{$MDFd=$MDFd;}
		
		$Cabld = trim(substr($linea, 161, 8));
		if($Cabld==""){$Cabld='X';}else{$Cabld=$Cabld;}
		
		$PAlid = trim(substr($linea, 169, 5));
		if($PAlid==""){$PAlid='X';}else{$PAlid=$PAlid;}
		
		$Armard = trim(substr($linea, 173, 5));
		if($Armard==""){$Armard='X';}else{$Armard=$Armard;}
		
		$Bloqd = trim(substr($linea, 178, 6));
		if($Bloqd==""){$Bloqd='X';}else{$Bloqd=$Bloqd;}
		
		$PDisd = trim(substr($linea, 184, 5));
		if($PDisd==""){$PDisd='X';}else{$PDisd=$PDisd;}
		
		$Cajad = trim(substr($linea, 189, 5));
		if($Cajad==""){$Cajad='X';}else{$Cajad=$Cajad;}
		
		$Bornd = trim(substr($linea, 195, 5));
		if($Bornd==""){$Bornd='X';}else{$Bornd=$Bornd;}
		
		$Telefono = trim(substr($linea, 200, 8));
		if($Telefono==""){$Telefono='X';}else{$Telefono=$Telefono;}
		
		$Sect = trim(substr($linea, 208, 6));
		if($Sect==""){$Sect='X';}else{$Sect=$Sect;}
		
		$Manz = trim(substr($linea, 214, 6));
		if($Manz==""){$Manz='X';}else{$Manz=$Manz;}
		
		$Peticion = trim(substr($linea, 220, 10));
		if($Peticion==""){$Peticion='X';}else{$Peticion=$Peticion;}
		
		$Agrupacion = trim(substr($linea, 240, 2));
		if($Agrupacion==""){$Agrupacion='X';}else{$Agrupacion=$Agrupacion;}
		
		$Cliente = trim(substr($linea, 243, 12));
		if($Cliente==""){$Cliente='X';}else{$Cliente=$Cliente;}
		
		$Cuenta = trim(substr($linea, 257, 10));
		if($Cuenta==""){$Cuenta='X';}else{$Cuenta=$Cuenta;}
		
		$PC = trim(substr($linea, 270, 10));
		if($PC==""){$PC='X';}else{$PC=$PC;}
		
		/*
		echo "<br>".$row."|".$fecha."|".$Comprob."|".$Inscripcion."|".$Solicitud."|".$Usuario."|".$CodSol."|".$Motivo."|".$Pedido."|".$Red."|".$MDFo."|".$Cabl."|".$PAli."|"
		.$Armar."|".$Bloq."|".$PDis."|".$Caja."|".$Born."|".$MDFd."|".$Cabld."|".$PAlid."|".$Armard."|".$Bloqd."|".$PDisd."|".$Cajad."|".$Bornd
		."|".$Telefono."|".$Sect."|".$Manz."|".$Peticion."|".$Agrupacion."|".$Cliente."|".$Cuenta."|".$PC."|".$v."|".$v;
		
		*/
		
		
		
		
		$sql_1="INSERT INTO gestel_47d (Fecha,Comprob_,Inscripcion,Solicitud,Usuario,Cod_Sol,Motivo,Pedido,Red,MDF,Cabl ,PAli ,Armar ,Bloq ,PDis ,Caja ,Born ,MDFd,Cabld ,PAlid ,Armard ,Bloqd ,PDisd ,Cajad ,Bornd ,Telefono ,Sect ,Manz,Peticion ,Agrupacion ,Cliente,Cuenta ,PC,Tipo_Circuito1,N_Circuito1,Tipo_Circuito2,N_Circuito2,Segmento,origen,fec_carga,n_area) 
			VALUES ('$fecha','$Comprob','$Inscripcion','$Solicitud','$Usuario','$CodSol','$Motivo','$Pedido','$Red','$MDFo','$Cabl',
			'$PAli','$Armar','$Bloq','$PDis','$Caja','$Born','$MDFd','$Cabld','$PAlid','$Armard','$Bloqd','$PDisd','$Cajad','$Bornd',
			'$Telefono','$Sect','$Manz','$Peticion','$Agrupacion','$Cliente','$Cuenta','','','','','','','$zon',now(),'')";
			
		//echo "<br>".$sql_1;
		$res_1 = mysql_query($sql_1) or die(mysql_error());
		
				
		}		
		
		if ($ciudad=="X"){
			unset($cont[$row]); 
			
		}
			
		
	}
	
	fclose($gestel_47D);	
	
	
	$sql_2="DELETE FROM gestel_47d WHERE SUBSTR(fecha,1,1) IN ('','-','f','t','x','s')";		
		//echo "<br>".$sql;
	$res_2 = mysql_query($sql_2) or die(mysql_error());	
		
	$sql_3="DELETE FROM gestel_47d WHERE SUBSTR(fecha,1,4)!='2018'";		
		//echo "<br>".$sql;
	$res_3 = mysql_query($sql_3) or die(mysql_error());		
		
	/*
	$sql_4=" UPDATE gestel_47d a, usuarios_detalle b
	 SET a.n_area=b.equipo_back
	 WHERE a.Usuario=b.usuario_gestel";			
	//echo "<br>".$sql_1;
	$res_4 = mysql_query($sql_4) or die(mysql_error());	
	*/

	$sql_4="INSERT INTO gestel_47d_total
		SELECT * FROM gestel_47d";			
		//echo "<br>".$sql;
		$res_4 = mysql_query($sql_4) or die(mysql_error());
		
	
}
?>	