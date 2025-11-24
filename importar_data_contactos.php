<?php

//include("cabecera.php") ;
//check($iduser,502);
//include("funciones.php");

$link = mysql_connect("localhost", "root", "") ;
$db = mysql_select_db("cot", $link) ; 

//$base = "d:/" ;

echo ""; 

$base = "d:/data_cot/base_contact_dic2017_FINAL.csv" ;
set_time_limit(5000);
$tabla = "tb_contactos";


/**********************AQUI CARGO MI TABLA TMP_CONTACTOS***********************************************************/
mysql_query("truncate table tb_contactos") ; 

$qry = "LOAD DATA INFILE '".$base."' INTO TABLE ". $tabla." FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'  IGNORE 1 LINES"; 	
//echo "<br>".$qry;

$res = mysql_query($qry, $link) or die(mysql_error());


/**********************AQUI CARGO MI TABLA Tb_CONTACTOS***********************************************************/
/*
mysql_query("truncate table tb_contactos;") ; 

$qry1 = "insert into tb_contactos (select * from ".$tabla." WHERE LENGTH(campo3)>8 group by campo3)";
$r1 = mysql_query($qry1) ;

*/
echo "<br>"."CARGA TERMINADA";

?>
