<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conexion_bd2.php");
//include("funciones_fechas.php");
set_time_limit(2000);


$conn = db_conn();



$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$u_reg=$_GET["u_reg"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];
$estado=$_GET['estado'];
$supervisor=$_GET['supervisor'];

/*
$iduser=1;
$perfil=2;
$c_inc=3;
$gestor=4;
$u_reg=156;
$fec_i='2025-01-01';
$fec_f='2025-11-01';
$estado=1;
$supervisor='';
*/

//echo "<input name='iduser' type='hidden' class='casilla_texto' id='iduser' value='$iduser'/>";

if ($c_inc=="" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
	if($perfil!=1){
		$cad="";
	} else {
		$cad=" and  usu_reg='$iduser'";
	}
}else{

	if ($c_inc<>"" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
		if($perfil!=1){
			$cad=" and  cod_incidencia='$c_inc'";
		} else {
			$cad=" and  cod_incidencia='$c_inc' and  usu_reg='$iduser'";
		}
		}else{
			if ($c_inc=="" and $gestor=="0" and $u_reg=="0"){
				if($perfil!=1){
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
				} else {
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f' and  usu_reg='$iduser'";
				}
			}else{
				if ($c_inc=="" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
					$cad=" and  dni='$gestor'";	
				}else{
					if ($c_inc=="" and $u_reg=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0"){
						$cad=" and  dni='$gestor' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
					}else{
						if ($u_reg<>"0" and $c_inc=="" and $gestor=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0" ){
							$cad=" and  usu_reg='$u_reg' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";								 					}else{		
							$cad=" and usu_reg='$u_reg'";						
						}
					}
					
				}
			}
		}
}


if($estado!='Todos'){
	$cad =  $cad ." AND estado_inc = '" . $estado . "'";
}

//echo $cad;


if($supervisor!='Todos'){
	//$cad = $cad ." AND lider.iduser = " .$supervisor;
}

/*
$lista="SELECT  * FROM cab_incidencia inc 
INNER JOIN tb_usuarios usu ON  dni = usu.dni
INNER JOIN tb_usuarios lider ON usu.c_supervisor = lider.iduser
WHERE tp_incidencia NOT IN ('MONITOREO Y CAPACITACION COT') ".$cad." AND  fec_reg >= DATE_SUB(NOW(), INTERVAL 365 DAY) GROUP BY cod_incidencia, tp_incidencia";
*/

$lista ="Select * from cab_incidencia where substr(fec_reg,1,4)='2025'".$cad." GROUP BY cod_incidencia, dni";

//echo $lista;
//exit();

$res_lista = mysqli_query($conn, $lista);

$hoy=date("Y_m_d");
$n_archivo="rep_incidenciascot_".$hoy.".xlsx";


header("Pragma: public");
header("Expires: 0");

header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$n_archivo");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	
	echo "<table width='100%'>";											
	echo "<tr>";													
			echo "<td class='caja_texto_peke' width='5%'>C.INDICENCIA </td>";	
			echo "<td class='caja_texto_peke' width='5%'>ESTADO </td>";						
			echo "<td class='caja_texto_peke' width='5%'>DNI</td>";	
			echo "<td class='caja_texto_peke' width='20%'>TRABAJADOR COT</td>";		
			echo "<td class='caja_texto_peke' width='10%'>TP.INCIDENCIA</td>";	
			echo "<td class='caja_texto_peke' width='10%'>MOTIVO</td>";	
			echo "<td class='caja_texto_peke'>FEC.INI INCIDENCIA</td>";						
			echo "<td class='caja_texto_peke'>FEC.FIN INCIDENCIA</td>";				
			echo "<td class='caja_texto_peke'>MODO</td>";
			echo "<td class='caja_texto_peke'>TIEMPO</td>";	
			echo "<td class='caja_texto_peke'>MINUTOS</td>";
            echo "<td class='caja_texto_peke'>USU.REGISTRO</td>";
            echo "<td class='caja_texto_peke'>FECHA REGISTRO</td>";
            echo "<td class='caja_texto_peke'>USU.APROBADO</td>";
            echo "<td class='caja_texto_peke'>FECHA APROB.</td>";
            echo "<td class='caja_texto_peke'>USU.RECHAZADO</td>";
            echo "<td class='caja_texto_peke'>FECHA RECH.</td>";
            echo "<td class='caja_texto_peke'>MOTIVO RECH.</td>";
            echo "<td class='caja_texto_peke'>USU.CANCELADO</td>";
            echo "<td class='caja_texto_peke'>FECHA CANCE.</td>";
			/*
			echo "<td class='caja_texto_peke'>FEC.RECHAZO</td>";
			echo "<td class='caja_texto_peke'>RESP.RECHAZO</td>";
			echo "<td class='caja_texto_peke'>MOTIVO RECHAZO</td>";
			*/

	echo "</tr>";
	
	$con = 0		;
	while($reg_lista=mysqli_fetch_row($res_lista)){			
		
		$con = $con + 1;			
		
		$fila = "fila_".$con;
		 
		echo "<tr id='$fila' name='$fila' >";					
		/*
		$fec		= "SELECT min(fec_ini_inc),max(fec_fin_inc) FROM cab_incidencia WHERE cod_incidencia='$reg_lista[10]' ";	
		//echo $fec;	
		$res_fec	= mysql_query($fec);
		$reg_fec	= mysql_fetch_row($res_fec);
		
        
		$contar		= "SELECT dni FROM cab_incidencia WHERE cod_incidencia='$reg_lista[10]' group by 1";		
		$res_contar	= mysql_query($contar);
		$reg_contar	= mysql_fetch_row($res_contar);
		$nreg_contar = mysql_num_rows($res_contar);
		*/
		
		$gestor		= "select * from tb_usuarios where dni='$reg_lista[17]'";		
		$res_gestor	= mysqli_query($conn, $gestor);
		$reg_gestor	= mysqli_fetch_row($res_gestor);
		
		$usu		= "select ncompleto from tb_usuarios where iduser='$reg_lista[3]'";	
       // echo $usu."<br>";
		$res_usu	= mysqli_query($conn,$usu);
		$reg_usu	= mysqli_fetch_row($res_usu);

        $usu_apro		= "select ncompleto from tb_usuarios where iduser='$reg_lista[20]'";	
        //echo $usu_apro."<br>";
		$res_usu_apro	= mysqli_query($conn,$usu_apro);
		$reg_usu_apro	= mysqli_fetch_row($res_usu_apro);
        
        $usu_rech		= "select ncompleto from tb_usuarios where iduser='$reg_lista[22]'";	
        //echo $usu_apro."<br>";
		$res_usu_rech	= mysqli_query($conn,$usu_rech);
		$reg_usu_rech	= mysqli_fetch_row($res_usu_rech);
        
        $usu_canc		= "select ncompleto from tb_usuarios where iduser='$reg_lista[25]'";	
        //echo $usu_apro."<br>";
		$res_usu_canc	= mysqli_query($conn,$usu_canc);
		$reg_usu_canc	= mysqli_fetch_row($res_usu_canc);
		
		$c1="select * from tb_motivos_incidencia where tp_inc = '$reg_lista[4]' AND cod_mot_inc='$reg_lista[5]'";
		//echo $c1;
		$res_c1 = mysqli_query($conn,$c1);
		$reg_c1=mysqli_fetch_row($res_c1);
		
		
		echo "<td class='TitTablaI'>"; // C.INDCIDENCIA
		echo $reg_lista[10]; 				
		echo "</td>";	

		echo "<td class='TitTablaI'>"; // ESTADO
		switch($reg_lista[15]){
			case 0 :
				echo "PENDIENTE";
			break;
			case 1 :
				echo "APROBADO";
			break;
			case 2 :
				echo "RECHAZADO";
				break;
            case 3 :
				echo "CANCELADO";
				break;
			default:
				echo $reg_lista[15];
		}				
		echo "</td>";	
		
			echo "<td class='TitTablaI'>"; // 
			echo $reg_lista[17]; 				
			echo "</td>";
        
			echo "<td class='TitTablaI'>"; // 
			echo $reg_gestor[1]; 				
			echo "</td>";	
					
		
		echo "<td  class='TitTablaI'>"; // TP INCIDENCIA
		echo $reg_lista[4]; 			
		echo "</td>";	
		
		echo "<td  class='TitTablaI'>"; //MOTIVO
		echo $reg_c1[1]; 			
		echo "</td>";	
		
		
		echo "<td  class='TitTablaI'>";// F INICIO
		echo $reg_lista[6]; 			
		echo "</td>";	
			
		
		echo "<td class='TitTablaI'>"; // F FIN
		echo $reg_lista[7]; 				
		echo "</td>";
			
					
			echo "<td class='TitTablaI'>"; //MODO
			echo $reg_lista[14]; 				
			echo "</td>";
			
			echo "<td class='TitTablaI'>";
			
			if ($reg_lista[14]=="H"){ //TIEMPO
				echo $reg_lista[12];
			}else{
				echo $reg_lista[16];
			}				
			echo "</td>";
		
			echo "<td class='TitTablaI'>"; // MINUTOS
			
			if ($reg_lista[14]=="H"){
				echo $reg_lista[13];
			}else{
				echo "";
			}				
			echo "</td>";
		
		echo "<td  class='TitTablaI'>"; // USU REGISTRO
        echo $reg_usu[0]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // FEC REGISTRO
        echo $reg_lista[2]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // USU aprobado
        echo $reg_usu_apro[0]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // FEC aprobado
        echo $reg_lista[19]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // USU RECHAZADO
        echo $reg_usu_rech[0]; 			
        echo "</td>";
    
        echo "<td  class='TitTablaI'>"; // FEC RECHAZO
        echo $reg_lista[21]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // motivo RECHAZO
        echo $reg_lista[23]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // USU CANCELADO
        echo $reg_usu_canc[0]; 			
        echo "</td>";
        
        echo "<td  class='TitTablaI'>"; // FEC CANCELADO
        echo $reg_lista[24]; 			
        echo "</td>";
        
		/*
		echo "<td class='TitTablaI'>";  // fecha rechazo
			if ($reg_lista[24]){
				echo $reg_lista[24]; 	
			}else{
				echo "-";
			}		
		echo "</td>";
		
		echo "<td class='TitTablaI'>";  // responsable rechazo
			if ($reg_lista[23]){
				echo $reg_lista[23]; 	
			}else{
				echo "-";
			}	
		echo "</td>";
		
		echo "<td class='TitTablaI'>";  //  motivo rechazo
			if ($reg_lista[22]){
				echo $reg_lista[22]; 	
			}else{
				echo "-";
			}	
		
		echo "</td>";
		*/
		echo "</tr>";				
		}	
	echo "</table>";
	//echo "total: ".$con;


/*
$hoy=date("Y_m_d");
$n_archivo="rep_incidenciascot_".$hoy.".xlsx";


header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$n_archivo); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);


*/


?>