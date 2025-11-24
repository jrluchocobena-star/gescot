<?php

//include("cabecera.php") ;
//check($iduser,502);
//include("funciones.php");

$link = mysql_connect("localhost", "root", "") ;
$db = mysql_select_db("cot", $link) ; 

//$base = "d:/" ;

echo ""; 

$hoy = date("Ymd");

$hora = date("H");

/*


if ($hora=="08"){
	$hora = date("H");
}else{
	$hora = date("H")-1;
}
*/


echo $hora;

if ($hora < 10){
	$xhora = date("H")-2;
	$xhora = "0".$xhora;
}else{
	$xhora = date("H");	
}

$archivo = "z:\\BASE_CONSOLIDADA_".$hoy."_".$xhora.".csv" ;


set_time_limit(5000);

$tabla = "tb_torrecontrol_";

//echo $archivo;


/**********************AQUI CARGO MI TABLA TMP_CONTACTOS***********************************************************/
mysql_query("truncate table $tabla") ; 

$qry = "LOAD DATA INFILE '".$archivo."' INTO TABLE ". $tabla." FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'  IGNORE 1 LINES"; 	
echo "<br>".$qry;

$res = mysql_query($qry, $link) or die(mysql_error());


/**********************AQUI CARGO MI TABLA Tb_CONTACTOS***********************************************************/

mysql_query("truncate table tb_contactos_tc;") ; 

$qry2 = "INSERT INTO tb_contactos_tc
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_de_contacto_1_back,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)UNION
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_de_contacto_2_back,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)UNION
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_1_back,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)UNION
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_2_back,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)UNION
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_1,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)UNION
(SELECT '',tipo_de_documento_back,numero_de_documento_back,telefono_2,'','','',nombres_apellidos_1,'','BASE TORRE DE CONTROL',CURDATE(),'REGISTRADO'
FROM tb_torrecontrol)";
$r2 = mysql_query($qry2) ;

$qry3 = "UPDATE tb_contactos_tc 
SET campo2=LPAD(campo2,8,'0')
WHERE LENGTH(campo2)<9";
$r3 = mysql_query($qry3) ;

$qry4 = "DELETE FROM tb_contactos_tc WHERE campo3 IN ('','999999999','E','0')";
$r4 = mysql_query($qry4) ;


echo "<br>"."CARGA TERMINADA";

?>
