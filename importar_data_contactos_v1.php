<?php
echo "Inciando proceso....";
echo "<br>"."En proceso....";
$link = mysql_connect("localhost", "root", "") ;
$db = mysql_select_db("cot", $link) ; 
set_time_limit(90000);

$sql_1	= "insert into tb_contactos_nueva
select * from tb_contactos_actual GROUP BY campo2,campo3 ";
//echo "<br>".$sql;
$res_1 = mysql_query($sql_1, $link) or die(mysql_error($sql_1));	

echo "<br>"."Proceso terminado....";

?>
