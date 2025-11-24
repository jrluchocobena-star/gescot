<?php

//include("cabecera.php") ;
//check($iduser,502);
//include("funciones.php");

$link = mysql_connect("localhost", "root", "") ;
$db = mysql_select_db("cot", $link) ; 
set_time_limit(2000);
$tabla = "tb_gestel_423";

mysql_query("truncate table tb_gestel_423") ;

$row=1;

$fileName = "d:/Macros/Gestel423/glpl494.txt";
$fp = fopen($fileName, "r");

while (!feof($fp) ) {
	//$linea = fread($fp,8192);
	$linea  = fgets($fp);	//echo "<br>".$linea;
	
	if($row > 9){ // a partir de la linea 20
	
	//col1
	$ciudad = trim(substr($linea, 3, 7));
	if($ciudad==""){$ciudad='X';}else{$ciudad=$ciudad;}
	
	$pedido = trim(substr($linea, 11, 10));
	if($pedido==""){$pedido='X';}else{$pedido=$pedido;}
	
	$insc = trim(substr($linea, 21, 12));
	
	$dire = trim(substr($linea, 35, 94));	
	$distrito = trim(substr($linea, 133, 8));
	if($distrito==""){$distrito='-';}else{$distrito=$distrito;}
	$promocion = trim(substr($linea, 140, 5));
	if($promocion==""){$promocion='-';}else{$promocion=$promocion;}
	$grupo = trim(substr($linea, 146, 16));
	if($grupo==""){$grupo='-';}else{$grupo=$grupo;}
	$nref = trim(substr($linea, 166, 10));
	if($nref==""){$nref='-';}else{$nref=$nref;}	
	$fec_reg = trim(substr($linea, 170, 22));
	if($fec_reg==""){$fec_reg='-';}else{$fec_reg=$fec_reg;}
	$tp_serv = trim(substr($linea, 192, 25));
	if($tp_serv==""){$tp_serv='-';}else{$tp_serv=$tp_serv;}
	$priori = trim(substr($linea, 217, 5));
	if($priori==""){$priori='-';}else{$priori=$priori;}
	$oficom = trim(substr($linea, 226, 5));
	if($oficom==""){$oficom='-';}else{$oficom=$oficom;}
	$peticion = trim(substr($linea, 231, 20));
	if($peticion==""){$peticion='-';}else{$peticion=$peticion;}
	$agrupacion = trim(substr($linea, 255, 5));
	if($agrupacion==""){$agrupacion='-';}else{$agrupacion=$agrupacion;}
	$cliente = trim(substr($linea, 260, 12));
	if($cliente==""){$cliente='-';}else{$cliente=$cliente;}
	$cuenta = trim(substr($linea, 272, 12));
	if($cuenta==""){$cuenta='-';}else{$cuenta=$cuenta;}
	$pc = trim(substr($linea, 284, 12));
	if($pc==""){$pc='-';}else{$pc=$pc;}
	$negocio = trim(substr($linea, 300, 10));
	if($negocio==""){$negocio='-';}else{$negocio=$negocio;}
	$prefijo = trim(substr($linea, 310, 10));
	if($prefijo==""){$prefijo='-';}else{$prefijo=$prefijo;}
	$segmento = trim(substr($linea, 320, 10));
	if($segmento==""){$segmento='-';}else{$segmento=$segmento;}
	$cantidad = trim(substr($linea, 330, 10));
	if($cantidad==""){$cantidad='-';}else{$cantidad=$cantidad;}	
	$subseg = trim(substr($linea, 340, 10));
	if($subseg==""){$subseg='-';}else{$subseg=$subseg;}	
	$iris = trim(substr($linea, 350, 10));
	if($iris==""){$iris='-';}else{$iris=$iris;}	
	$dir_ant = trim(substr($linea, 360, 10));
	if($dir_ant==""){$dir_ant='-';}else{$dir_ant=$dir_ant;}	
	$sector = trim(substr($linea, 415, 10));
	if($sector==""){$sector='-';}else{$sector=$sector;}
	$manz = trim(substr($linea, 425, 5));
	if($manz==""){$manz='-';}else{$manz=$manz;}
	$coorX = trim(substr($linea, 430, 20));
	if($coorX==""){$coorX='-';}else{$coorX=$coorX;}
	$coorY = trim(substr($linea, 450, 20));
	if($coorY==""){$coorY='-';}else{$coorY=$coorY;} 

	/*
	echo "<br>".$ciudad."|".$pedido."|".$insc."|".$dire."|".$distrito."|".$promocion."|".$grupo."|".$nref."|".$fec_reg."|".$tp_serv."|".$priori."|".$oficom."|"
	.$peticion."|".$agrupacion."|".$cliente."|".$cuenta."|".$pc."|".$negocio."|".$prefijo."|".$segmento."|".$cantidad."|".$subseg."|".$iris."|".$dir_ant."|".$sector
	."|".$manz."|".$coorX."|".$coorY;	
	*/
	
		
	$sql_1="INSERT INTO tb_gestel_423 (CIUDAD,PEDIDO,INSCRIPCION,DIRECCION,DISTRITO,PROMOCION,GRUPO,NRO_REF,FECHA_REG,TIPO_SERVICIO,PRIORIDAD,OFIC_COM,PETICION,
		AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y) 
		VALUES ('$ciudad','$pedido','$insc','$dire','$distrito','$promocion','$grupo','$nref','$fec_reg','$tp_serv','$priori','$oficom',
		'$peticion','$agrupacion','$cliente','$cuenta','$pc','$negocio','$prefijo','$segmento','$cantidad','$subseg','$iris','$dir_ant','$sector',
		'$manz','$coorX','$coorY');";
		
	//echo "<br>".$sql;
	$res_1 = mysql_query($sql_1, $link) or die(mysql_error());
	
	$sql_2="delete from tb_gestel_423 where ciudad in ('X','-----')";		
	//echo "<br>".$sql;
	$res_2 = mysql_query($sql_2, $link) or die(mysql_error());
			
	}
	$row++;
	
	if ($ciudad=="X"){
		unset($cont[$row]); 
		
	}
	
	
	
}

fclose($fp);

echo "PROCESO TERMINADO";
	
?>
