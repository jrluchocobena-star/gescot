<?php

//include("cabecera.php") ;
//check($iduser,502);
//include("funciones.php");

$link = mysql_connect("localhost", "root", "") ;
$db = mysql_select_db("cot", $link) ; 

//$base = "d:/" ;

set_time_limit(5000);
$tabla = "tb_contactos_prueba";


/**********************AQUI CARGO MI TABLA TMP_CONTACTOS***********************************************************/
mysql_query("truncate table tb_contactos_prueba") ; 

echo "En proceso";

$archivo="D://COMPARTIDO/DATA/CONTACTOS/BASE_CONTACTOS_01022019.txt";

$qry = "LOAD DATA INFILE '$archivo'
INTO TABLE $tabla
FIELDS TERMINATED BY '|'
LINES TERMINATED BY '\n' 
IGNORE 1 LINES 
(campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10)"; 	
//echo "<br>".$qry;

$res = mysql_query($qry, $link) or die(mysql_error());

/*
$qry1 = "UPDATE tb_contactos_prueba SET campo10=NOW()";
$r1 = mysql_query($qry1) ;
*/
/**********************AQUI CARGO MI TABLA Tb_CONTACTOS***********************************************************/
/*
mysql_query("truncate table tb_contactos;") ; 



*/
echo "<br>"."CARGA TERMINADA";

?>
