<?php 
include("conexion_bd.php");


$paso_0="TRUNCATE TABLE formato_psi";	
//echo "<br>".$paso_0;
$res_0 = mysql_query($paso_0);	

		
$paso_1="INSERT INTO formato_psi
(
SELECT 'ASIGNACIONES','' AS ATENCION,'GESTEL-423' AS FUENTE,'' AS CODACTU,'' AS CODCLI,'' AS TIPOAVERIA,'' AS CLIENTENOMBRE,'' AS CLIENTECELULAR,'' AS CLIENTETELEFONO,'' AS CLIENTECORREO,'' AS CLIENTEDNI,'' AS CONTACTONOMBRE,'' AS CONTACTOCELULAR,'' AS CONTACTOTELEFONO,'' AS CONTACTOCORREO,'' AS CONTACTODNI,'' AS EMBAJADORNOMBRE,'' AS EMBAJADORCORREO,'' AS EMBAJADORCELULAR,'' AS EMBAJADORDNI,'' AS COMENTARIO,fecha_reg AS FH_REG104,NOW() AS FH_REG1L,'' AS FH_REG2L,peticion AS CODMULTIGESTION,'' AS LLAMADOR,'' AS TITULAR,direccion AS Direccion,distrito AS Distrito,'' AS Urbanizacion,'' AS TELF_GESTION,'' AS TELF_ENTRANTE,'' AS OPERADOR,'' AS MOTIVO_CALL
FROM tb_gestel_423 GROUP BY peticion
)UNION
(
SELECT 'ASIGNACIONES','' AS ATENCION,'CMS' AS FUENTE,'' AS CODACTU,CLIENTE AS CODCLI,'' AS TIPOAVERIA,'' AS CLIENTENOMBRE,'' AS CLIENTECELULAR,'' AS CLIENTETELEFONO,
'' AS CLIENTECORREO,'' AS CLIENTEDNI,'' AS CONTACTONOMBRE,'' AS CONTACTOCELULAR,'' AS CONTACTOTELEFONO,'' AS CONTACTOCORREO,'' AS CONTACTODNI,'' AS EMBAJADORNOMBRE,
'' AS EMBAJADORCORREO,'' AS EMBAJADORCELULAR,'' AS EMBAJADORDNI,'' AS COMENTARIO,FECHA_LLEGADA AS FH_REG104,NOW() AS FH_REG1L,'' AS FH_REG2L,peticion AS CODMULTIGESTION,
'' AS LLAMADOR,'' AS TITULAR,LTRIM(CONCAT(direccion,'',numero,'',int_,'',piso,'',lote,'',urb)) AS Direccion,'' AS Distrito,'' AS Urbanizacion,'' AS TELF_GESTION,'' AS TELF_ENTRANTE,'' AS OPERADOR,'' AS MOTIVO_CALL
FROM tb_cms GROUP BY n_requer
)
UNION
(SELECT 'REASIGNACIONES','' AS ATENCION,'GESTEL-47D' AS FUENTE,'' AS CODACTU,cliente AS CODCLI,'' AS TIPOAVERIA,'' AS CLIENTENOMBRE,'' AS CLIENTECELULAR,'' AS CLIENTETELEFONO,'' AS CLIENTECORREO,'' AS CLIENTEDNI,'' AS CONTACTONOMBRE,'' AS CONTACTOCELULAR,'' AS CONTACTOTELEFONO,'' AS CONTACTOCORREO,'' AS CONTACTODNI,'' AS EMBAJADORNOMBRE,'' AS EMBAJADORCORREO,'' AS EMBAJADORCELULAR,'' AS EMBAJADORDNI,'' AS COMENTARIO,fecha AS FH_REG104,NOW() AS FH_REG1L,'' AS FH_REG2L,peticion AS CODMULTIGESTION,'' AS LLAMADOR,'' AS TITULAR,'' AS Direccion,origen AS Distrito,'' AS Urbanizacion,telefono AS TELF_GESTION,'' AS TELF_ENTRANTE,'' AS OPERADOR,'' AS MOTIVO_CALL
FROM gestel_47d GROUP BY comprob_)";	
//echo "<br>".$paso_1;
$res_1 = mysql_query($paso_1);	


$archivo_out="v://INFORMES/PSI/asignaciones_psi_".date("mY").".csv";

$paso_2="(select * FROM formato_psi
INTO OUTFILE '$archivo_out' 
FIELDS TERMINATED BY ',' ENCLOSED BY '' 
LINES TERMINATED BY '\n')";
//echo "<br>".$paso_2;
$res_2 = mysql_query($paso_2);


copiar_psi();



function ConectarFTP(){

define("SERVER","10.226.44.223"); //IP o Nombre del Servidor
define("PORT",21); //Puerto
define("USER","cot_lectura"); //Nombre de Usuario
define("PASSWORD","c0tr34d#"); //Contraseña de acceso
define("PASV",true); //Activa modo pasivo

//Permite conectarse al Servidor FTP
$id_ftp=ftp_connect(SERVER,PORT); //Obtiene un manejador del Servidor FTP
ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
ftp_pasv($id_ftp,MODO); //Establece el modo de conexión
return $id_ftp; //Devuelve el manejador a la función
}


function copiar_psi(){

	$id_ftp=ConectarFTP();
	
	$archivo="asignaciones_psi_".date("mY").".csv";
	
	$archivo_local = 'v:/informes/psi/'.$archivo; //Nombre archivo en nuestro PC
	//$server_file = '/home/geslis/lcobena0/gppl480_r_fecusu.txt'; //Nombre archivo en FTP lcobena0
	$archivo_remoto = '/movimientos/'.$archivo; //Nombre archivo en FTP sonia
			
	// //Obtiene un manejador y se conecta al Servidor FTP
	
	ftp_put($id_ftp,$archivo_remoto,$archivo_local,FTP_BINARY);
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
}

?>