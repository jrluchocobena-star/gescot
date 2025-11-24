<?php
include ("conexion_teradata.php");
require_once('conexion_.php');
//Establece conexion con Teradata
$connection_teradata = db_conn_teradata();

//Establece conexion con COT
$db=DB::conectar();

set_time_limit(100000);	
?>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  padding: 1px;
}
table {
  border-spacing: 1px;
}
</style>
</head>
<body>

<?php
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir') {
	echo "Entra 1";
	if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
		// get details of the uploaded file
		$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
		$fileName = $_FILES['uploadedFile']['name'];
		$fileSize = $_FILES['uploadedFile']['size'];
		$fileType = $_FILES['uploadedFile']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		#$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
		$allowedfileExtensions = array('txt', 'csv', 'xls', 'xlsx');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			// directory in which the uploaded file will be moved
			$uploadFileDir = 'D:/COMPARTIDO/DATA/MAESTRA/';
			$dest_path = $uploadFileDir . $fileName;
 
			if(move_uploaded_file($fileTmpPath, $dest_path))
			{
				#$message ='Archivo Cargado Exitosamente.';
				#echo "Archivo Guardado <br />\n";
				$fila = 1;
				if (($gestor = fopen($dest_path, "r")) !== FALSE) {
					echo "<table style='width:100%'>";
					echo "<tr>";
					echo "<th colspan='5'><h2>Resultados de la carga masiva</h2></th>";
					echo "</tr>";
					echo "<tr>";
					echo "<th>Nombre Completo</th>";
					echo "<th>DNI</th>";
					echo "<th>CIP</th>";
					echo "<th>Usuarios</th>";
					echo "<th>Observacion</th>";
					echo "</tr>";
					while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
						if ($fila=='1'){
							//Obviamos la primera línea que es la cabecera del archivo de entrada
							$numero = count($datos);
							$fila++;
						}else{
							echo "<tr>";
							$numero = count($datos);
							#echo "<p> $numero campos en la linea $fila: <br /></p>\n";
							$fila++;
							//Leemos cada uno de los campos de cara a validar contra BBDD_COT y BBDD_RRHH [0] es el primer campo
							$dni_gestor=str_pad($datos[0], 8, "0", STR_PAD_LEFT);
							//Validamos si existe en la BBDD_COT
							$selectall=$db->prepare('SELECT * FROM tb_usuarios WHERE dni=:dni');
							$selectall->bindValue('dni',$dni_gestor);
							$selectall->execute();
							$numfilas = $selectall->rowCount();
							$selectall->closeCursor();
							#echo "Numero de Filas: ".$numfilas. "<br />\n";
							if ($numfilas==0){
								#echo "El gestor con DNI: ".$dni_gestor." no existe en GesCOT<br />\n";
								//Validamos si existe en la BBDD_RRHH
								$sql="SEL idempleadolegado, nombresyapellidos, direccioncorreoelectronico, positiontitulo  
								FROM dbi_cot.ls_maestra_recursos WHERE idnacionalprincipal=$dni_gestor";
								$statement = odbc_exec($connection_teradata, $sql);
								$n_filas = odbc_num_rows($statement);
								if ($n_filas==0){
									#echo "El gestor con DNI: ".$dni_gestor." no existe en GesCOT ni en RRHH <br />\n";
									echo "<td></td>";
									echo "<td>".$dni_gestor."</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td>No existe en RRHH</td></tr>";
								}else{
									$cip_gestor=odbc_result($statement,1);
									//echo  existe en RRHH<br />\n";
									$nombre_gestor=odbc_result($statement,2);
									$correo_gestor=odbc_result($statement,3);
									$cargo_gestor=odbc_result($statement,4);
									
									$cargo=NULL;
									$fecha_registro=date("Y-m-d");
									$perfilatis_gestor=$datos[4];
									#echo "Perfil ATIS ".$perfilatis_gestor. "<br />\n";	
									$perfilcms_gestor=$datos[6];
									#echo "Perfil CMS ".$perfilcms_gestor. "<br />\n";										
									$macaddress_gestor=$datos[28];
									#echo "Mac Addrress ".$macaddress_gestor. "<br />\n";
									$place_gestor=$datos[29];
									#echo "Place ".$place_gestor. "<br />\n";
									$ipaudiocode_gestor=$datos[30];
									#echo "IP AudioCode ".$ipaudiocode_gestor. "<br />\n";
									$equipo_gestor=$datos[31];
									#echo "Equipo Gestor ".$equipo_gestor. "<br />\n";
									$grupo_gestor=$datos[32];
									#echo "Grupo Gestor ".$grupo_gestor. "<br />\n";
									$correopersonal_gestor=$datos[33];
									#echo "Correo Personal ".$correopersonal_gestor. "<br />\n";
									$celular1_gestor=$datos[34];
									#echo "Celular 1 ".$celular1_gestor. "<br />\n";
									$celular2_gestor=$datos[35];
									#echo "Celular 2 ".$celular2_gestor. "<br />\n";
									$anexo_gestor=$datos[36];
									#echo "Anexo ".$anexo_gestor. "<br />\n";
									$local_gestor=$datos[37];
									#echo "Local ".$local_gestor. "<br />\n";
									$pc_gestor=$datos[38];
									#echo "PC ".$pc_gestor. "<br />\n";
									$monitor_gestor=$datos[39];
									#echo "Monitor ".$monitor_gestor. "<br />\n";
									$piso_gestor=$datos[40];
									#echo "Piso ".$piso_gestor. "<br />\n";
									$fec_nac_gestor=$datos[41];
									#echo "Fec. Nacimiento ".$fec_nac_gestor. "<br />\n";
									$emergencia_gestor=$datos[42];
									#echo "Emergencia ".$emergencia_gestor. "<br />\n";
									$fec_ini_capa=$datos[43];
									$fec_ini_capa_gestor=date('Y-m-d', strtotime(str_replace('/', '-', $fec_ini_capa)));
									#echo "Fec Ini Capa ".$fec_ini_capa_gestor. "<br />\n";
									$fec_fin_capa=$datos[44];
									$fec_fin_capa_gestor=date('Y-m-d', strtotime(str_replace('/', '-', $fec_fin_capa)));
									#echo "Fec Fin Capa ".$fec_fin_capa_gestor. "<br />\n";
									$ola_gestor=$datos[45];
									#echo "Ola ".$ola_gestor. "<br />\n";									
									$desc_gestor=$datos[46];
									#echo "Descripcion ".$desc_gestor. "<br />\n";
									
									if (substr($cargo_gestor,0,18)=="ANALISTA FUNCIONAL"){
										$cargo="AF";
									};
									if (substr($cargo_gestor,0,19)=="ANALISTA DE GESTION"){
										$cargo="AG";	
									};
									if (substr($cargo_gestor,0,19)=="ANALISTA DE SOPORTE"){
										$cargo="AS";	
									};
									if (substr($cargo_gestor,0,18)=="EJECUTIVO ASOCIADO"){
										$cargo="EA";	
									};									
									if (substr($cargo_gestor,0,16)=="EJECUTIVO SENIOR"){
										$cargo="EAS";	
									};
									if (substr($cargo_gestor,0,7)=="EXPERTO"){
										$cargo="EXP";	
									};
									if (substr($cargo_gestor,0,4)=="JEFE"){
										$cargo="Jefe";	
									};
									if (substr($cargo_gestor,0,10)=="SUPERVISOR"){
										$cargo="SUP";
									};
									if (substr($cargo_gestor,0,21)=="TECNICO ESPECIALIZADO"){
										$cargo="TE";	
									};
									if (substr($cargo_gestor,0,22)=="TECNICO DE OPERACIONES"){
										$cargo="TO";	
									};
									if (substr($cargo_gestor,0,18)=="TECNICO DE SOPORTE"){
										$cargo="TS";	
									};
									if ($cargo == NULL){
										$cargo='TBD';
									};
									$insert=$db->prepare('INSERT INTO tb_usuarios_tmp (ncompleto,dni,cip,login, pass, perfil, estado, grupo, sgrupo,  correo_personal, correo_w,celular1, celular2, anexo, local, pc, monitor, piso, fec_nacimiento, c_emergencia, fec_reg, fec_ing_cot, fec_fin_cot, ola, cod_cargo, mac_address, cod_place, ip_audiocode, equipo) VALUES (:nombre,:dni,:cip, :login, :clave, :perfil, :estado, :grupo, :sgrupo, :correo_p, :correo, :cel1, :cel2, :anexo, :local, :pc, :monitor, :piso, :fec_nac, :emerg, :fecreg, :fecingcot, :fecfincot, :ola, :cargo, :macaddress, :codplace, :ipauidocode, :equipo)');
									$insert->bindValue('nombre',$nombre_gestor);
									$insert->bindValue('dni',$dni_gestor);
									$insert->bindValue('cip',$cip_gestor);
									$insert->bindValue('login',$dni_gestor);
									$insert->bindValue('clave',$dni_gestor);
									$insert->bindValue('perfil',"1");
									$insert->bindValue('estado',"HABILITADO");
									$insert->bindValue('grupo',$grupo_gestor);
									$insert->bindValue('sgrupo',"BACK");
									$insert->bindValue('correo_p',$correopersonal_gestor);
									$insert->bindValue('correo',$correo_gestor);
									$insert->bindValue('cel1',$celular1_gestor);
									$insert->bindValue('cel2',$celular2_gestor);
									$insert->bindValue('anexo',$anexo_gestor);
									$insert->bindValue('local',$local_gestor);
									$insert->bindValue('pc',$pc_gestor);
									$insert->bindValue('monitor',$monitor_gestor);
									$insert->bindValue('piso',$piso_gestor);
									$insert->bindValue('fec_nac',$fec_nac_gestor);
									$insert->bindValue('emerg',$emergencia_gestor);
									$insert->bindValue('fecreg',$fecha_registro);
									$insert->bindValue('fecingcot',$fec_ini_capa_gestor);
									$insert->bindValue('fecfincot',$fec_fin_capa_gestor);
									$insert->bindValue('ola',$ola_gestor);
									$insert->bindValue('cargo',$cargo);
									$insert->bindValue('macaddress',$macaddress_gestor);
									$insert->bindValue('codplace',$place_gestor);
									$insert->bindValue('ipauidocode',$ipaudiocode_gestor);
									$insert->bindValue('equipo',$equipo_gestor);
									$insert->execute();
									#echo "El gestor con Nombre: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor." se registra en GesCOT<br />\n";
									//Creación Usuario PSI
									echo "<td>".$nombre_gestor."</td>";
									echo "<td>".$dni_gestor."</td>";
									echo "<td>".$cip_gestor."</td>";
									echo "<td></td>";
									echo "<td>Registrado OK</td></tr>";
									$usuario_psi=$datos[2];
									if($usuario_psi != NULL){
										$selectpsi_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectpsi_tmp->bindValue('dato',$usuario_psi);
										$selectpsi_tmp->execute();
										$numfilas_psi_tmp = $selectpsi_tmp->rowCount();
										$selectpsi_tmp->closeCursor();										
										if ($numfilas_psi_tmp==0){
											$selectpsi=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectpsi->bindValue('dato',$usuario_psi);
											$selectpsi->execute();
											$numfilas_psi = $selectpsi->rowCount();
											$selectpsi->closeCursor();
											if($numfilas_psi==0){
												#echo "El usuario PSI: ".$usuario_psi. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_psi=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_psi->bindValue('dni',$dni_gestor);
												$insert_psi->bindValue('dato',$usuario_psi);
												$insert_psi->bindValue('aplicativo',"USUARIO PSI");											
												$insert_psi->bindValue('tipo_mov',"ACT. USUARIO");									
												$insert_psi->bindValue('fecha_actual',$fecha_actual);
												$insert_psi->bindValue('fec_ini',$next_day);
												$insert_psi->bindValue('obs_mov',"PROC.MASIVO");
												$insert_psi->bindValue('est',"ACTIVO");
												$insert_psi->bindValue('aplicativo1',"t_usuario_psi");											
												$insert_psi->execute();
												#echo "		El usuario PSI: ".$usuario_psi. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario PSI: ".$usuario_psi."</td>";
												echo "<td>Registrado OK</td>";
											}else{
												#echo "		El usuario PSI: ".$usuario_psi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario PSI: ".$usuario_psi."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";
											}
										}else{
											#echo "		El usuario PSI: ".$usuario_psi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario PSI: ".$usuario_psi."</td>";
											echo "<td>Repetido</td></tr>";
										}
									}
									//Termina Creacion de Usuario PSI
									//Creación Usuario ATIS
									$usuario_atis=$datos[3];
									if($usuario_atis != NULL){
										$selectatis_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectatis_tmp->bindValue('dato',$usuario_atis);
										$selectatis_tmp->execute();
										$numfilas_atis_tmp = $selectatis_tmp->rowCount();
										$selectatis_tmp->closeCursor();										
										if ($numfilas_atis_tmp==0){
											$selectatis=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectatis->bindValue('dato',$usuario_atis);
											$selectatis->execute();
											$numfilas_atis = $selectatis->rowCount();
											$selectatis->closeCursor();
											if($numfilas_atis==0){
												#echo "El usuario ATIS: ".$usuario_atis. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_atis=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1,perfil) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1,:perfil_atis)');
												$insert_atis->bindValue('dni',$dni_gestor);
												$insert_atis->bindValue('dato',$usuario_atis);
												$insert_atis->bindValue('aplicativo',"USUARIO ATIS");											
												$insert_atis->bindValue('tipo_mov',"ACT. USUARIO");									
												$insert_atis->bindValue('fecha_actual',$fecha_actual);
												$insert_atis->bindValue('fec_ini',$next_day);
												$insert_atis->bindValue('obs_mov',"PROC.MASIVO");
												$insert_atis->bindValue('est',"ACTIVO");
												$insert_atis->bindValue('aplicativo1',"t_usuario_atis");
												$insert_atis->bindValue('perfil_atis',$perfilatis_gestor);
												$insert_atis->execute();
												#echo "		El usuario ATIS: ".$usuario_atis. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario ATIS: ".$usuario_atis."</td>";
												echo "<td>Registrado OK</td>";												
											}else{
												#echo "		El usuario ATIS: ".$usuario_atis. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario ATIS: ".$usuario_atis."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario ATIS: ".$usuario_atis. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario ATIS: ".$usuario_atis."</td>";
											echo "<td>Repetido</td></tr>";											
										}
									}
									//Termina Creacion de Usuario ATIS
									//Creación Usuario CMS
									$usuario_cms=$datos[5];
									if($usuario_cms != NULL){
										$selectcms_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectcms_tmp->bindValue('dato',$usuario_cms);
										$selectcms_tmp->execute();
										$numfilas_cms_tmp = $selectcms_tmp->rowCount();
										$selectcms_tmp->closeCursor();										
										if ($numfilas_cms_tmp==0){
											$selectcms=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectcms->bindValue('dato',$usuario_cms);
											$selectcms->execute();
											$numfilas_cms = $selectcms->rowCount();
											$selectcms->closeCursor();
											if($numfilas_cms==0){
												#echo "El usuario CMS: ".$usuario_cms. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_cms=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1,perfil) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1,:perfil_cms)');
												$insert_cms->bindValue('dni',$dni_gestor);
												$insert_cms->bindValue('dato',$usuario_cms);
												$insert_cms->bindValue('aplicativo',"USUARIO CMS");											
												$insert_cms->bindValue('tipo_mov',"ACT. USUARIO");									
												$insert_cms->bindValue('fecha_actual',$fecha_actual);
												$insert_cms->bindValue('fec_ini',$next_day);
												$insert_cms->bindValue('obs_mov',"PROC.MASIVO");
												$insert_cms->bindValue('est',"ACTIVO");
												$insert_cms->bindValue('aplicativo1',"t_usuario_cms");
												$insert_cms->bindValue('perfil_cms',$perfilcms_gestor);
												$insert_cms->execute();
												#echo "		El usuario CMS: ".$usuario_cms. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CMS: ".$usuario_cms."</td>";
												echo "<td>Registrado OK</td>";												
											}else{
												#echo "		El usuario CMS: ".$usuario_cms. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CMS: ".$usuario_cms."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario CMS: ".$usuario_cms. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario CMS: ".$usuario_cms."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario CMS
									//Creación Usuario GESTEL
									$usuario_gestel=$datos[7];
									if($usuario_gestel != NULL){
										$selectgestel_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectgestel_tmp->bindValue('dato',$usuario_gestel);
										$selectgestel_tmp->execute();
										$numfilas_gestel_tmp = $selectgestel_tmp->rowCount();
										$selectgestel_tmp->closeCursor();										
										if ($numfilas_gestel_tmp==0){
											$selectgestel=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectgestel->bindValue('dato',$usuario_gestel);
											$selectgestel->execute();
											$numfilas_gestel = $selectgestel->rowCount();
											$selectgestel->closeCursor();
											if($numfilas_gestel==0){
												#echo "El usuario GESTEL: ".$usuario_gestel. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_gestel=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_gestel->bindValue('dni',$dni_gestor);
												$insert_gestel->bindValue('dato',$usuario_gestel);
												$insert_gestel->bindValue('aplicativo',"USUARIO GESTEL");											
												$insert_gestel->bindValue('tipo_mov',"ACT. USUARIO");									
												$insert_gestel->bindValue('fecha_actual',$fecha_actual);
												$insert_gestel->bindValue('fec_ini',$next_day);
												$insert_gestel->bindValue('obs_mov',"PROC.MASIVO");
												$insert_gestel->bindValue('est',"ACTIVO");
												$insert_gestel->bindValue('aplicativo1',"t_usuario_gestel");											
												$insert_gestel->execute();
												#echo "		El usuario GESTEL: ".$usuario_gestel. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GESTEL: ".$usuario_gestel."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario GESTEL: ".$usuario_gestel. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GESTEL: ".$usuario_gestel."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";	
											}
										}else{
											#echo "		El usuario GESTEL: ".$usuario_gestel. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario GESTEL: ".$usuario_gestel."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario GESTEL
									//Creación Usuario WEB INCIDENCIAS PSI
									$usuario_inc_psi=$datos[8];
									if($usuario_inc_psi != NULL){
										$selectincpsi_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectincpsi_tmp->bindValue('dato',$usuario_inc_psi);
										$selectincpsi_tmp->execute();
										$numfilas_incpsi_tmp = $selectincpsi_tmp->rowCount();
										$selectincpsi_tmp->closeCursor();										
										if ($numfilas_incpsi_tmp==0){
											$selectincpsi=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectincpsi->bindValue('dato',$usuario_inc_psi);
											$selectincpsi->execute();
											$numfilas_incpsi = $selectincpsi->rowCount();
											$selectincpsi->closeCursor();
											if($numfilas_incpsi==0){
												#echo "El usuario WEB INCIDENCIAS PSI: ".$usuario_inc_psi. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_incpsi=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_incpsi->bindValue('dni',$dni_gestor);
												$insert_incpsi->bindValue('dato',$usuario_inc_psi);
												$insert_incpsi->bindValue('aplicativo',"USUARIO WEB INCIDENCIAS PSI");
												$insert_incpsi->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_incpsi->bindValue('fecha_actual',$fecha_actual);
												$insert_incpsi->bindValue('fec_ini',$next_day);
												$insert_incpsi->bindValue('obs_mov',"PROC.MASIVO");
												$insert_incpsi->bindValue('est',"ACTIVO");
												$insert_incpsi->bindValue('aplicativo1',"t_usuario_incidencias_psi");										$insert_incpsi->execute();
												#echo "		El usuario WEB INCIDENCIAS PSI: ".$usuario_inc_psi. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario INCIDENCIAS PSI: ".$usuario_inc_psi."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario WEB INCIDENCIAS PSI: ".$usuario_inc_psi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario INCIDENCIAS PSI: ".$usuario_inc_psi."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario WEB INCIDENCIAS PSI: ".$usuario_inc_psi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario INCIDENCIAS PSI: ".$usuario_inc_psi."</td>";
											echo "<td>Repetido</td></tr>";	
										}
									}
									//Termina Creacion de Usuario WEB INCIDENCIAS PSI
									//Creación Usuario INTRAWAY
									$usuario_itw=$datos[11];
									if($usuario_itw != NULL){
										$selectitw_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectitw_tmp->bindValue('dato',$usuario_itw);
										$selectitw_tmp->execute();
										$numfilas_itw_tmp = $selectitw_tmp->rowCount();
										$selectitw_tmp->closeCursor();										
										if ($numfilas_itw_tmp==0){
											$selectitw=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectitw->bindValue('dato',$usuario_itw);
											$selectitw->execute();
											$numfilas_itw = $selectitw->rowCount();
											$selectitw->closeCursor();
											if($numfilas_itw==0){
												#echo "El usuario INTRAWAY: ".$usuario_itw. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_itw=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_itw->bindValue('dni',$dni_gestor);
												$insert_itw->bindValue('dato',$usuario_itw);
												$insert_itw->bindValue('aplicativo',"USUARIO INTRAWAY");
												$insert_itw->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_itw->bindValue('fecha_actual',$fecha_actual);
												$insert_itw->bindValue('fec_ini',$next_day);
												$insert_itw->bindValue('obs_mov',"PROC.MASIVO");
												$insert_itw->bindValue('est',"ACTIVO");
												$insert_itw->bindValue('aplicativo1',"t_usuario_intraway");
												$insert_itw->execute();
												#echo "		El usuario INTRAWAY: ".$usuario_itw. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario INTRAWAY: ".$usuario_itw."</td>";
												echo "<td>Registrado OK</td>";	
											}else{
												#echo "		El usuario INTRAWAY: ".$usuario_itw. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario INTRAWAY: ".$usuario_itw."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";													
											}
										}else{
											#echo "		El usuario INTRAWAY: ".$usuario_itw. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario INTRAWAY: ".$usuario_itw."</td>";
											echo "<td>Repetido</td></tr>";	
										}
									}
									//Termina Creacion de Usuario INTRAWAY
									//Creación Usuario ASEGURAMIENTO
									$usuario_aseg=$datos[13];
									if($usuario_aseg != NULL){
										$selectaseg_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectaseg_tmp->bindValue('dato',$usuario_aseg);
										$selectaseg_tmp->execute();
										$numfilas_aseg_tmp = $selectaseg_tmp->rowCount();
										$selectaseg_tmp->closeCursor();										
										if ($numfilas_aseg_tmp==0){
											$selectaseg=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectaseg->bindValue('dato',$usuario_aseg);
											$selectaseg->execute();
											$numfilas_aseg = $selectaseg->rowCount();
											$selectaseg->closeCursor();
											if($numfilas_aseg==0){
												#echo "El usuario ASEGURAMIENTO: ".$usuario_aseg. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_aseg=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_aseg->bindValue('dni',$dni_gestor);
												$insert_aseg->bindValue('dato',$usuario_aseg);
												$insert_aseg->bindValue('aplicativo',"USUARIO WEB ASEGURAMIENTO");
												$insert_aseg->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_aseg->bindValue('fecha_actual',$fecha_actual);
												$insert_aseg->bindValue('fec_ini',$next_day);
												$insert_aseg->bindValue('obs_mov',"PROC.MASIVO");
												$insert_aseg->bindValue('est',"ACTIVO");
												$insert_aseg->bindValue('aplicativo1',"t_usuario_web_aseguramiento");
												$insert_aseg->execute();
												#echo "		El usuario ASEGURAMIENTO: ".$usuario_aseg. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB ASEGURAMIENTO: ".$usuario_aseg."</td>";
												echo "<td>Registrado OK</td>";	
											}else{
												#echo "		El usuario ASEGURAMIENTO: ".$usuario_aseg. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB ASEGURAMIENTO: ".$usuario_aseg."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";
											}
										}else{
											#echo "		El usuario ASEGURAMIENTO: ".$usuario_aseg. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB ASEGURAMIENTO: ".$usuario_aseg."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario ASEGURAMIENTO
									//Creación Usuario ARPU
									$usuario_arpu=$datos[14];
									if($usuario_arpu != NULL){
										$selectarpu_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectarpu_tmp->bindValue('dato',$usuario_arpu);
										$selectarpu_tmp->execute();
										$numfilas_arpu_tmp = $selectarpu_tmp->rowCount();
										$selectarpu_tmp->closeCursor();										
										if ($numfilas_arpu_tmp==0){
											$selectarpu=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectarpu->bindValue('dato',$usuario_arpu);
											$selectarpu->execute();
											$numfilas_arpu = $selectarpu->rowCount();
											$selectarpu->closeCursor();
											if($numfilas_arpu==0){
												#echo "El usuario ARPU: ".$usuario_arpu. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_arpu=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_arpu->bindValue('dni',$dni_gestor);
												$insert_arpu->bindValue('dato',$usuario_arpu);
												$insert_arpu->bindValue('aplicativo',"USUARIO ARPU CALCULADORA");
												$insert_arpu->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_arpu->bindValue('fecha_actual',$fecha_actual);
												$insert_arpu->bindValue('fec_ini',$next_day);
												$insert_arpu->bindValue('obs_mov',"PROC.MASIVO");
												$insert_arpu->bindValue('est',"ACTIVO");
												$insert_arpu->bindValue('aplicativo1',"t_usuario_arpu_calculadora");
												$insert_arpu->execute();
												#echo "		El usuario ARPU: ".$usuario_arpu. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario ARPU: ".$usuario_arpu."</td>";
												echo "<td>Registrado OK</td>";	
											}else{
												#echo "		El usuario ARPU: ".$usuario_arpu. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario ARPU: ".$usuario_arpu."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario ARPU: ".$usuario_arpu. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario ARPU: ".$usuario_arpu."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario ARPU
									//Creación Usuario GENIO
									$usuario_genio=$datos[15];
									if($usuario_genio != NULL){
										$selectgenio_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectgenio_tmp->bindValue('dato',$usuario_genio);
										$selectgenio_tmp->execute();
										$numfilas_genio_tmp = $selectgenio_tmp->rowCount();
										$selectgenio_tmp->closeCursor();										
										if ($numfilas_genio_tmp==0){
											$selectgenio=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectgenio->bindValue('dato',$usuario_genio);
											$selectgenio->execute();
											$numfilas_genio = $selectgenio->rowCount();
											$selectgenio->closeCursor();
											if($numfilas_genio==0){
												#echo "El usuario ARPU: ".$usuario_genio. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_genio=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_genio->bindValue('dni',$dni_gestor);
												$insert_genio->bindValue('dato',$usuario_genio);
												$insert_genio->bindValue('aplicativo',"USUARIO GENIO");
												$insert_genio->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_genio->bindValue('fecha_actual',$fecha_actual);
												$insert_genio->bindValue('fec_ini',$next_day);
												$insert_genio->bindValue('obs_mov',"PROC.MASIVO");
												$insert_genio->bindValue('est',"ACTIVO");
												$insert_genio->bindValue('aplicativo1',"t_usuario_genio");
												$insert_genio->execute();
												#echo "		El usuario GENIO: ".$usuario_genio. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GENIO: ".$usuario_genio."</td>";
												echo "<td>Registrado OK</td>";												
											}else{
												#echo "		El usuario GENIO: ".$usuario_genio. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GENIO: ".$usuario_genio."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario GENIO: ".$usuario_genio. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario GENIO: ".$usuario_genio."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario GENIO
									//Creación Usuario ASIGNACIONES
									$usuario_asig=$datos[16];
									if($usuario_asig != NULL){
										$selectasig_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectasig_tmp->bindValue('dato',$usuario_asig);
										$selectasig_tmp->execute();
										$numfilas_asig_tmp = $selectasig_tmp->rowCount();
										$selectasig_tmp->closeCursor();										
										if ($numfilas_asig_tmp==0){
											$selectasig=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectasig->bindValue('dato',$usuario_asig);
											$selectasig->execute();
											$numfilas_asig = $selectasig->rowCount();
											$selectasig->closeCursor();
											if($numfilas_asig==0){
												#echo "El usuario ASIGNACIONES: ".$usuario_asig. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_asig=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_asig->bindValue('dni',$dni_gestor);
												$insert_asig->bindValue('dato',$usuario_asig);
												$insert_asig->bindValue('aplicativo',"USUARIO WEB ASIGNACIONES");
												$insert_asig->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_asig->bindValue('fecha_actual',$fecha_actual);
												$insert_asig->bindValue('fec_ini',$next_day);
												$insert_asig->bindValue('obs_mov',"PROC.MASIVO");
												$insert_asig->bindValue('est',"ACTIVO");
												$insert_asig->bindValue('aplicativo1',"t_usuario_web_asignaciones");
												$insert_asig->execute();
												#echo "		El usuario ASIGNACIONES: ".$usuario_asig. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB ASIGNACIONES: ".$usuario_asig."</td>";
												echo "<td>Registrado OK</td>";	
											}else{
												#echo "		El usuario ASIGNACIONES: ".$usuario_asig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB ASIGNACIONES: ".$usuario_asig."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario ASIGNACIONES: ".$usuario_asig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB ASIGNACIONES: ".$usuario_asig."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario ASIGNACIONES																		
									//Creación Usuario MULTICONSULTA
									$usuario_multi=$datos[18];
									if($usuario_multi != NULL){
										$selectmulti_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectmulti_tmp->bindValue('dato',$usuario_multi);
										$selectmulti_tmp->execute();
										$numfilas_multi_tmp = $selectmulti_tmp->rowCount();
										$selectmulti_tmp->closeCursor();										
										if ($numfilas_multi_tmp==0){
											$selectmulti=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectmulti->bindValue('dato',$usuario_multi);
											$selectmulti->execute();
											$numfilas_multi = $selectmulti->rowCount();
											$selectmulti->closeCursor();
											if($numfilas_multi==0){
												#echo "El usuario INTRAWAY: ".$usuario_multi. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_multi=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_multi->bindValue('dni',$dni_gestor);
												$insert_multi->bindValue('dato',$usuario_multi);
												$insert_multi->bindValue('aplicativo',"USUARIO MULTICONSULTA");
												$insert_multi->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_multi->bindValue('fecha_actual',$fecha_actual);
												$insert_multi->bindValue('fec_ini',$next_day);
												$insert_multi->bindValue('obs_mov',"PROC.MASIVO");
												$insert_multi->bindValue('est',"ACTIVO");
												$insert_multi->bindValue('aplicativo1',"t_usuario_multiconsulta");
												$insert_multi->execute();
												#echo "		El usuario MULTICONSULTA: ".$usuario_multi. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario MULTICONSULTA: ".$usuario_multi."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario MULTICONSULTA: ".$usuario_multi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario MULTICONSULTA: ".$usuario_multi."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";													
											}
										}else{
											#echo "		El usuario MULTICONSULTA: ".$usuario_multi. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario MULTICONSULTA: ".$usuario_multi."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario MULTICONSULTA									
									//Creación Usuario RED
									$usuario_red=$datos[19];
									if($usuario_red != NULL){
										$selectred_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectred_tmp->bindValue('dato',$usuario_red);
										$selectred_tmp->execute();
										$numfilas_red_tmp = $selectred_tmp->rowCount();
										$selectred_tmp->closeCursor();										
										if ($numfilas_red_tmp==0){
											$selectred=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectred->bindValue('dato',$usuario_red);
											$selectred->execute();
											$numfilas_red = $selectred->rowCount();
											$selectred->closeCursor();
											if($numfilas_red==0){
												#echo "El usuario RED: ".$usuario_red. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_red=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_red->bindValue('dni',$dni_gestor);
												$insert_red->bindValue('dato',$usuario_red);
												$insert_red->bindValue('aplicativo',"USUARIO RED");
												$insert_red->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_red->bindValue('fecha_actual',$fecha_actual);
												$insert_red->bindValue('fec_ini',$next_day);
												$insert_red->bindValue('obs_mov',"PROC.MASIVO");
												$insert_red->bindValue('est',"ACTIVO");
												$insert_red->bindValue('aplicativo1',"t_usuario_red");
												$insert_red->execute();
												#echo "		El usuario RED: ".$usuario_red. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario RED: ".$usuario_red."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario RED: ".$usuario_red. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario RED: ".$usuario_red."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario RED: ".$usuario_red. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario RED: ".$usuario_red."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario RED									
									//Creación Usuario TOA
									$usuario_toa=$datos[20];
									if($usuario_toa != NULL){
										$selecttoa_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selecttoa_tmp->bindValue('dato',$usuario_toa);
										$selecttoa_tmp->execute();
										$numfilas_toa_tmp = $selecttoa_tmp->rowCount();
										$selecttoa_tmp->closeCursor();										
										if ($numfilas_toa_tmp==0){
											$selecttoa=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selecttoa->bindValue('dato',$usuario_toa);
											$selecttoa->execute();
											$numfilas_toa = $selecttoa->rowCount();
											$selecttoa->closeCursor();
											if($numfilas_toa==0){
												#echo "El usuario TOA: ".$usuario_toa. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_toa=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_toa->bindValue('dni',$dni_gestor);
												$insert_toa->bindValue('dato',$usuario_toa);
												$insert_toa->bindValue('aplicativo',"USUARIO TOA");
												$insert_toa->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_toa->bindValue('fecha_actual',$fecha_actual);
												$insert_toa->bindValue('fec_ini',$next_day);
												$insert_toa->bindValue('obs_mov',"PROC.MASIVO");
												$insert_toa->bindValue('est',"ACTIVO");
												$insert_toa->bindValue('aplicativo1',"t_usuario_toa");
												$insert_toa->execute();
												#echo "		El usuario TOA: ".$usuario_toa. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario TOA: ".$usuario_toa."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario TOA: ".$usuario_toa. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario TOA: ".$usuario_toa."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";													
											}
										}else{
											#echo "		El usuario TOA: ".$usuario_toa. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario TOA: ".$usuario_toa."</td>";
											echo "<td>Repetido</td></tr>";	
										}
									}
									//Termina Creacion de Usuario TOA
									//Creación Usuario GENESYS
									$usuario_genesys=$datos[27];
									if($usuario_genesys != NULL){
										$selectgenesys_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectgenesys_tmp->bindValue('dato',$usuario_genesys);
										$selectgenesys_tmp->execute();
										$numfilas_genesys_tmp = $selectgenesys_tmp->rowCount();
										$selectgenesys_tmp->closeCursor();										
										if ($numfilas_genesys_tmp==0){
											$selectgenesys=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectgenesys->bindValue('dato',$usuario_genesys);
											$selectgenesys->execute();
											$numfilas_genesys = $selectgenesys->rowCount();
											$selectgenesys->closeCursor();
											if($numfilas_genesys==0){
												#echo "El usuario GENESYS: ".$usuario_genesys. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_genesys=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_genesys->bindValue('dni',$dni_gestor);
												$insert_genesys->bindValue('dato',$usuario_genesys);
												$insert_genesys->bindValue('aplicativo',"USUARIO GENESYS");
												$insert_genesys->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_genesys->bindValue('fecha_actual',$fecha_actual);
												$insert_genesys->bindValue('fec_ini',$next_day);
												$insert_genesys->bindValue('obs_mov',"PROC.MASIVO");
												$insert_genesys->bindValue('est',"ACTIVO");
												$insert_genesys->bindValue('aplicativo1',"t_usuario_genesys");
												$insert_genesys->execute();
												#echo "		El usuario GENESYS: ".$usuario_genesys. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GENESYS: ".$usuario_genesys."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario GENESYS: ".$usuario_genesys. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GENESYS: ".$usuario_genesys."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";													
											}
										}else{
											#echo "		El usuario GENESYS: ".$usuario_genesys. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario GENESYS: ".$usuario_genesys."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario GENESYS
									//Creación Usuario GESCOT
									$usuario_gescot=$dni_gestor;
									if($usuario_gescot != NULL){
										$selectgescot_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectgescot_tmp->bindValue('dato',$usuario_gescot);
										$selectgescot_tmp->execute();
										$numfilas_gescot_tmp = $selectgescot_tmp->rowCount();
										$selectgescot_tmp->closeCursor();										
										if ($numfilas_gescot_tmp==0){
											$selectgescot=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectgescot->bindValue('dato',$usuario_gescot);
											$selectgescot->execute();
											$numfilas_gescot = $selectgescot->rowCount();
											$selectgescot->closeCursor();
											if($numfilas_gescot==0){
												#echo "El usuario GESCOT: ".$usuario_gescot. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_gescot=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_gescot->bindValue('dni',$dni_gestor);
												$insert_gescot->bindValue('dato',$usuario_gescot);
												$insert_gescot->bindValue('aplicativo',"USUARIO GESCOT");
												$insert_gescot->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_gescot->bindValue('fecha_actual',$fecha_actual);
												$insert_gescot->bindValue('fec_ini',$next_day);
												$insert_gescot->bindValue('obs_mov',"PROC.MASIVO");
												$insert_gescot->bindValue('est',"ACTIVO");
												$insert_gescot->bindValue('aplicativo1',"t_usuario_gescot");
												$insert_gescot->execute();
												#echo "		El usuario GESCOT: ".$usuario_gescot. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GESCOT: ".$usuario_gescot."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario GESCOT: ".$usuario_gescot. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GESCOT: ".$usuario_gescot."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";													
											}
										}else{
											#echo "		El usuario GESCOT: ".$usuario_gescot. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario GESCOT: ".$usuario_gescot."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario GESCOT
									//Creación Usuario WEB SIG
									$usuario_websig=$datos[17];;
									if($usuario_websig != NULL){
										$selectwebsig_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectwebsig_tmp->bindValue('dato',$usuario_websig);
										$selectwebsig_tmp->execute();
										$numfilas_websig_tmp = $selectwebsig_tmp->rowCount();
										$selectwebsig_tmp->closeCursor();										
										if ($numfilas_websig_tmp==0){
											$selectwebsig=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectwebsig->bindValue('dato',$usuario_websig);
											$selectwebsig->execute();
											$numfilas_websig = $selectwebsig->rowCount();
											$selectwebsig->closeCursor();
											if($numfilas_websig==0){
												#echo "El usuario WEB SIG: ".$usuario_websig. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_websig=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_websig->bindValue('dni',$dni_gestor);
												$insert_websig->bindValue('dato',$usuario_websig);
												$insert_websig->bindValue('aplicativo',"USUARIO WEB SIGTP MAPA GIG");
												$insert_websig->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_websig->bindValue('fecha_actual',$fecha_actual);
												$insert_websig->bindValue('fec_ini',$next_day);
												$insert_websig->bindValue('obs_mov',"PROC.MASIVO");
												$insert_websig->bindValue('est',"ACTIVO");
												$insert_websig->bindValue('aplicativo1',"t_usuario_web_sigtp_mapa_gig");
												$insert_websig->execute();
												#echo "		El usuario WEB SIG: ".$usuario_websig. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB SIGTP: ".$usuario_websig."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario WEB SIG: ".$usuario_websig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB SIGTP: ".$usuario_websig."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario WEB SIG: ".$usuario_websig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB SIGTP: ".$usuario_websig."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario WEB SIG
									//Creación Usuario PDM
									$usuario_pdm=$datos[9];;
									if($usuario_pdm != NULL){
										$selectpdm_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectpdm_tmp->bindValue('dato',$usuario_pdm);
										$selectpdm_tmp->execute();
										$numfilas_pdm_tmp = $selectpdm_tmp->rowCount();
										$selectpdm_tmp->closeCursor();										
										if ($numfilas_pdm_tmp==0){
											$selectpdm=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectpdm->bindValue('dato',$usuario_pdm);
											$selectpdm->execute();
											$numfilas_pdm = $selectpdm->rowCount();
											$selectpdm->closeCursor();
											if($numfilas_pdm==0){
												#echo "El usuario PDM: ".$usuario_pdm. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_pdm=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_pdm->bindValue('dni',$dni_gestor);
												$insert_pdm->bindValue('dato',$usuario_pdm);
												$insert_pdm->bindValue('aplicativo',"USUARIO PDM");
												$insert_pdm->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_pdm->bindValue('fecha_actual',$fecha_actual);
												$insert_pdm->bindValue('fec_ini',$next_day);
												$insert_pdm->bindValue('obs_mov',"PROC.MASIVO");
												$insert_pdm->bindValue('est',"ACTIVO");
												$insert_pdm->bindValue('aplicativo1',"t_usuario_pdm");
												$insert_pdm->execute();
												#echo "		El usuario PDM: ".$usuario_pdm. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario PDM: ".$usuario_pdm."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario PDM: ".$usuario_pdm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario PDM: ".$usuario_pdm."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario PDM: ".$usuario_pdm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario PDM: ".$usuario_pdm."</td>";
											echo "<td>Repetido</td></tr>";													
										}
									}
									//Termina Creacion de Usuario PDM
									//Creación Usuario CLEARVIEW
									$usuario_clearview=$datos[10];;
									if($usuario_clearview != NULL){
										$selectclearview_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectclearview_tmp->bindValue('dato',$usuario_clearview);
										$selectclearview_tmp->execute();
										$numfilas_clearview_tmp = $selectclearview_tmp->rowCount();
										$selectclearview_tmp->closeCursor();										
										if ($numfilas_clearview_tmp==0){
											$selectclearview=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectclearview->bindValue('dato',$usuario_clearview);
											$selectclearview->execute();
											$numfilas_clearview = $selectclearview->rowCount();
											$selectclearview->closeCursor();
											if($numfilas_clearview==0){
												#echo "El usuario CLEARVIEW: ".$usuario_clearview. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_clearview=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_clearview->bindValue('dni',$dni_gestor);
												$insert_clearview->bindValue('dato',$usuario_clearview);
												$insert_clearview->bindValue('aplicativo',"USUARIO CLEAR VIEW");
												$insert_clearview->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_clearview->bindValue('fecha_actual',$fecha_actual);
												$insert_clearview->bindValue('fec_ini',$next_day);
												$insert_clearview->bindValue('obs_mov',"PROC.MASIVO");
												$insert_clearview->bindValue('est',"ACTIVO");
												$insert_clearview->bindValue('aplicativo1',"t_usuario_clear_view");
												$insert_clearview->execute();
												#echo "		El usuario CLEARVIEW: ".$usuario_clearview. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CLEAVIEW: ".$usuario_clearview."</td>";
												echo "<td>Registrado OK</td>";												
											}else{
												#echo "		El usuario CLEARVIEW: ".$usuario_clearview. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CLEARVIEW: ".$usuario_clearview."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario CLEARVIEW: ".$usuario_clearview. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario CLEARVIEW: ".$usuario_clearview."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario CLEARVIEW
									//Creación Usuario SARA
									$usuario_sara=$datos[12];;
									if($usuario_sara != NULL){
										$selectsara_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectsara_tmp->bindValue('dato',$usuario_sara);
										$selectsara_tmp->execute();
										$numfilas_sara_tmp = $selectsara_tmp->rowCount();
										$selectsara_tmp->closeCursor();										
										if ($numfilas_sara_tmp==0){
											$selectsara=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectsara->bindValue('dato',$usuario_sara);
											$selectsara->execute();
											$numfilas_sara = $selectsara->rowCount();
											$selectsara->closeCursor();
											if($numfilas_sara==0){
												#echo "El usuario SARA: ".$usuario_sara. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_sara=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_sara->bindValue('dni',$dni_gestor);
												$insert_sara->bindValue('dato',$usuario_sara);
												$insert_sara->bindValue('aplicativo',"USUARIO WEB SARA");
												$insert_sara->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_sara->bindValue('fecha_actual',$fecha_actual);
												$insert_sara->bindValue('fec_ini',$next_day);
												$insert_sara->bindValue('obs_mov',"PROC.MASIVO");
												$insert_sara->bindValue('est',"ACTIVO");
												$insert_sara->bindValue('aplicativo1',"t_usuario_web_sara");
												$insert_sara->execute();
												#echo "		El usuario SARA: ".$usuario_sara. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB SARA: ".$usuario_sara."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario SARA: ".$usuario_sara. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB SARA: ".$usuario_sara."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";
											}
										}else{
											#echo "		El usuario SARA: ".$usuario_sara. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB SARA: ".$usuario_sara."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario SARA
									//Creación Usuario SRM
									$usuario_srm=$datos[21];;
									if($usuario_srm != NULL){
										$selectsrm_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectsrm_tmp->bindValue('dato',$usuario_srm);
										$selectsrm_tmp->execute();
										$numfilas_srm_tmp = $selectsrm_tmp->rowCount();
										$selectsrm_tmp->closeCursor();										
										if ($numfilas_srm_tmp==0){
											$selectsrm=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectsrm->bindValue('dato',$usuario_srm);
											$selectsrm->execute();
											$numfilas_srm = $selectsrm->rowCount();
											$selectsrm->closeCursor();
											if($numfilas_srm==0){
												#echo "El usuario SRM: ".$usuario_srm. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_srm=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_srm->bindValue('dni',$dni_gestor);
												$insert_srm->bindValue('dato',$usuario_srm);
												$insert_srm->bindValue('aplicativo',"USUARIO SRM");
												$insert_srm->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_srm->bindValue('fecha_actual',$fecha_actual);
												$insert_srm->bindValue('fec_ini',$next_day);
												$insert_srm->bindValue('obs_mov',"PROC.MASIVO");
												$insert_srm->bindValue('est',"ACTIVO");
												$insert_srm->bindValue('aplicativo1',"t_usuario_srm");
												$insert_srm->execute();
												#echo "		El usuario SRM: ".$usuario_srm. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario SRM: ".$usuario_srm."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario SRM: ".$usuario_srm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario SRM: ".$usuario_srm."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario SRM: ".$usuario_srm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario SRM: ".$usuario_srm."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario SRM
									//Creación Usuario WEB SPEEDY SIG
									$usuario_speedysig=$datos[22];;
									if($usuario_speedysig != NULL){
										$selectspeedysig_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectspeedysig_tmp->bindValue('dato',$usuario_speedysig);
										$selectspeedysig_tmp->execute();
										$numfilas_speedysig_tmp = $selectspeedysig_tmp->rowCount();
										$selectspeedysig_tmp->closeCursor();										
										if ($numfilas_speedysig_tmp==0){
											$selectspeedysig=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectspeedysig->bindValue('dato',$usuario_speedysig);
											$selectspeedysig->execute();
											$numfilas_speedysig = $selectspeedysig->rowCount();
											$selectspeedysig->closeCursor();
											if($numfilas_speedysig==0){
												#echo "El usuario WEB SPEEDY SIG: ".$usuario_speedysig. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_speedysig=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_speedysig->bindValue('dni',$dni_gestor);
												$insert_speedysig->bindValue('dato',$usuario_speedysig);
												$insert_speedysig->bindValue('aplicativo',"USUARIO WEB SPEEDY SIG");
												$insert_speedysig->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_speedysig->bindValue('fecha_actual',$fecha_actual);
												$insert_speedysig->bindValue('fec_ini',$next_day);
												$insert_speedysig->bindValue('obs_mov',"PROC.MASIVO");
												$insert_speedysig->bindValue('est',"ACTIVO");
												$insert_speedysig->bindValue('aplicativo1',"t_usuario_speedy_sig");
												$insert_speedysig->execute();
												#echo "		El usuario WEB SPEEDY SIG: ".$usuario_speedysig. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario SPEEDY SIG: ".$usuario_speedysig."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario WEB SPEEDY SIG: ".$usuario_speedysig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario SPEEDY SIG: ".$usuario_speedysig."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario WEB SPEEDY SIG: ".$usuario_speedysig. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario SPEEDY SIG: ".$usuario_speedysig."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario WEB SPEEDY SIG
									//Creación Usuario WEB TECNICA
									$usuario_tecnica=$datos[23];;
									if($usuario_tecnica != NULL){
										$selecttecnica_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selecttecnica_tmp->bindValue('dato',$usuario_tecnica);
										$selecttecnica_tmp->execute();
										$numfilas_tecnica_tmp = $selecttecnica_tmp->rowCount();
										$selecttecnica_tmp->closeCursor();										
										if ($numfilas_tecnica_tmp==0){
											$selecttecnica=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selecttecnica->bindValue('dato',$usuario_tecnica);
											$selecttecnica->execute();
											$numfilas_tecnica = $selecttecnica->rowCount();
											$selecttecnica->closeCursor();
											if($numfilas_tecnica==0){
												#echo "El usuario WEB TECNICA: ".$usuario_tecnica. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_tecnica=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_tecnica->bindValue('dni',$dni_gestor);
												$insert_tecnica->bindValue('dato',$usuario_tecnica);
												$insert_tecnica->bindValue('aplicativo',"USUARIO WEB TECNICA");
												$insert_tecnica->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_tecnica->bindValue('fecha_actual',$fecha_actual);
												$insert_tecnica->bindValue('fec_ini',$next_day);
												$insert_tecnica->bindValue('obs_mov',"PROC.MASIVO");
												$insert_tecnica->bindValue('est',"ACTIVO");
												$insert_tecnica->bindValue('aplicativo1',"t_usuario_web_tecnica");
												$insert_tecnica->execute();
												#echo "		El usuario WEB TECNICA: ".$usuario_tecnica. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB TECNICA: ".$usuario_tecnica."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario WEB TECNICA: ".$usuario_tecnica. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB TECNICA: ".$usuario_tecnica."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario WEB TECNICA: ".$usuario_tecnica. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB TECNICA: ".$usuario_tecnica."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario WEB TECNICA
									//Creación Usuario WEB PREVENCION
									$usuario_prevencion=$datos[24];
									if($usuario_prevencion != NULL){
										$selectprevencion_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectprevencion_tmp->bindValue('dato',$usuario_prevencion);
										$selectprevencion_tmp->execute();
										$numfilas_prevencion_tmp = $selectprevencion_tmp->rowCount();
										$selectprevencion_tmp->closeCursor();										
										if ($numfilas_prevencion_tmp==0){
											$selectprevencion=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectprevencion->bindValue('dato',$usuario_prevencion);
											$selectprevencion->execute();
											$numfilas_prevencion = $selectprevencion->rowCount();
											$selectprevencion->closeCursor();
											if($numfilas_prevencion==0){
												#echo "El usuario WEB PREVENCION: ".$usuario_prevencion. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_prevencion=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_prevencion->bindValue('dni',$dni_gestor);
												$insert_prevencion->bindValue('dato',$usuario_prevencion);
												$insert_prevencion->bindValue('aplicativo',"USUARIO WEB PREVENCION");
												$insert_prevencion->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_prevencion->bindValue('fecha_actual',$fecha_actual);
												$insert_prevencion->bindValue('fec_ini',$next_day);
												$insert_prevencion->bindValue('obs_mov',"PROC.MASIVO");
												$insert_prevencion->bindValue('est',"ACTIVO");
												$insert_prevencion->bindValue('aplicativo1',"t_usuario_web_prevencion");
												$insert_prevencion->execute();
												#echo "		El usuario WEB PREVENCION: ".$usuario_prevencion. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB PREVENCION: ".$usuario_prevencion."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario WEB PREVENCION: ".$usuario_prevencion. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario WEB PREVENCION: ".$usuario_prevencion."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario WEB PREVENCION: ".$usuario_prevencion. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario WEB PREVENCION: ".$usuario_prevencion."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario WEB PREVENCION
									//Creación Usuario CCPULSE
									$usuario_ccpulse=$datos[25];
									if($usuario_ccpulse != NULL){
										$selectccpulse_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectccpulse_tmp->bindValue('dato',$usuario_ccpulse);
										$selectccpulse_tmp->execute();
										$numfilas_ccpulse_tmp = $selectccpulse_tmp->rowCount();
										$selectccpulse_tmp->closeCursor();										
										if ($numfilas_ccpulse_tmp==0){
											$selectccpulse=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectccpulse->bindValue('dato',$usuario_ccpulse);
											$selectccpulse->execute();
											$numfilas_ccpulse = $selectccpulse->rowCount();
											$selectccpulse->closeCursor();
											if($numfilas_ccpulse==0){
												#echo "El usuario CCPULSE: ".$usuario_ccpulse. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_ccpulse=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_ccpulse->bindValue('dni',$dni_gestor);
												$insert_ccpulse->bindValue('dato',$usuario_ccpulse);
												$insert_ccpulse->bindValue('aplicativo',"USUARIO CCPULSE");
												$insert_ccpulse->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_ccpulse->bindValue('fecha_actual',$fecha_actual);
												$insert_ccpulse->bindValue('fec_ini',$next_day);
												$insert_ccpulse->bindValue('obs_mov',"PROC.MASIVO");
												$insert_ccpulse->bindValue('est',"ACTIVO");
												$insert_ccpulse->bindValue('aplicativo1',"t_usuario_ccpulse");
												$insert_ccpulse->execute();
												#echo "		El usuario CCPULSE: ".$usuario_ccpulse. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CCPULSE: ".$usuario_ccpulse."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario CCPULSE: ".$usuario_ccpulse. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario CCPULSE: ".$usuario_ccpulse."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario CCPULSE: ".$usuario_ccpulse. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario CCPULSE: ".$usuario_ccpulse."</td>";
											echo "<td>Repetido</td></tr>";												
										}
									}
									//Termina Creacion de Usuario CCPULSE
									//Creación Usuario GADMINISTRATOR
									$usuario_genadm=$datos[26];
									if($usuario_genadm != NULL){
										$selectgenadm_tmp=$db->prepare('SELECT * FROM movimientos_maestra_tmp WHERE dato=:dato and est="ACTIVO"');
										$selectgenadm_tmp->bindValue('dato',$usuario_genadm);
										$selectgenadm_tmp->execute();
										$numfilas_genadm_tmp = $selectgenadm_tmp->rowCount();
										$selectgenadm_tmp->closeCursor();										
										if ($numfilas_genadm_tmp==0){
											$selectgenadm=$db->prepare('SELECT * FROM movimientos_maestra WHERE dato=:dato and est="ACTIVO"');
											$selectgenadm->bindValue('dato',$usuario_genadm);
											$selectgenadm->execute();
											$numfilas_genadm = $selectgenadm->rowCount();
											$selectgenadm->closeCursor();
											if($numfilas_genadm==0){
												#echo "El usuario GADMINISTRATOR: ".$usuario_genadm. "No existe en movimientos <br />\n";
												$next_day= date("Y/m/d",strtotime("+1 day"));
												$fecha_actual=date("Y-m-d H:i:s");
												$insert_genadm=$db->prepare('INSERT INTO movimientos_maestra_tmp (dni, dato, aplicativo,tipo_mov,fec_mov,fec_ini,obs_mov,est,aplicativo1) VALUES (:dni,:dato,:aplicativo,:tipo_mov,:fecha_actual,:fec_ini,:obs_mov,:est,:aplicativo1)');
												$insert_genadm->bindValue('dni',$dni_gestor);
												$insert_genadm->bindValue('dato',$usuario_genadm);
												$insert_genadm->bindValue('aplicativo',"USUARIO GADMINISTRATOR");
												$insert_genadm->bindValue('tipo_mov',"ACT. USUARIO");								
												$insert_genadm->bindValue('fecha_actual',$fecha_actual);
												$insert_genadm->bindValue('fec_ini',$next_day);
												$insert_genadm->bindValue('obs_mov',"PROC.MASIVO");
												$insert_genadm->bindValue('est',"ACTIVO");
												$insert_genadm->bindValue('aplicativo1',"t_usuario_genesys_administrator");
												$insert_genadm->execute();
												#echo "		El usuario GADMINISTRATOR: ".$usuario_genadm. " se registro OK. Asociado al gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor."<br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GADMINISTRATOR: ".$usuario_genadm."</td>";
												echo "<td>Registrado OK</td>";													
											}else{
												#echo "		El usuario GADMINISTRATOR: ".$usuario_genadm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta asociado a otro gestor <br />\n";
												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>Usuario GADMINISTRATOR: ".$usuario_genadm."</td>";
												echo "<td>Esta asociado a otro gestor</td></tr>";												
											}
										}else{
											#echo "		El usuario GADMINISTRATOR: ".$usuario_genadm. " del gestor: ".$nombre_gestor.", con CIP: ".$cip_gestor. " y con DNI: ".$dni_gestor. " esta repetido <br />\n";
											echo "<tr>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "<td>Usuario GADMINISTRATOR: ".$usuario_genadm."</td>";
											echo "<td>Repetido</td></tr>";	
										}
									}
									//Termina Creacion de Usuario GADMINISTRATOR
								}
							}else{
								#echo "El gestor con DNI: ".$dni_gestor." ya existe en GesCOT <br />\n";
								echo "<td></td>";
								echo "<td>".$dni_gestor."</td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td>Ya existe en GesCOT</td></tr>";
							}					
							#echo "DNI Completo:". $dni_gestor ."<br />\n";
							#echo "CIP Completo:". str_pad($datos[1], 9, "0", STR_PAD_LEFT). "<br />\n";
						}
					}
					echo"</table>";
					fclose($gestor);
/* 					$insert_users=$db->prepare('CALL registro_masivo_usuarios()');
					$insert_users->execute();
					
					$insert_movimientos=$db->prepare('CALL regitro_masivo_movimientos_maestra()');
					$insert_movimientos->execute(); */
				}
			}
			else
			{
				#$message = 'Hubo un problema en la carga del archivo.';
				echo "Archivo No Guardado";	
			}
		}
	
	}
}else{
	$message ='Aca.';
	
}
?>
</body>
</html>