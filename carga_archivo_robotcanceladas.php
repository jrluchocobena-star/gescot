<?PHP
include("funciones_fechas.php");
$xmes_archivo	= date("mY");
$xmes_carga		= date("m-Y");

$n_archivo ="TecnicasInput_".date("Ymd")."0730".".xlsx";
$archivo_xlsx = 'd://compartido/data/canceladas_robot/'.$n_archivo;

//echo $archivo_xlsx;	
		
		 
if (file_exists ($archivo_xlsx)){ 
	echo "Si se encontro ".$archivo_xlsx."<br>";
	extract($_POST);

		 
		////////////////////////////////////////////////////////
		if (file_exists ($archivo_xlsx)) //validacion para saber si el archivo ya existe previamente
		{
		/*INVOCACION DE CLASES Y CONEXION A BASE DE DATOS*/
		/** Invocacion de Clases necesarias */
		require_once('PHPExcel/Classes/PHPExcel.php');
		require_once('PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');
		//DATOS DE CONEXION A LA BASE DE DATOS
		
		$db_host = 'localhost';
		$db_user = 'root';
		$db_pwd  = '';
		$db_name = 'cot';
	
			
		$cn = mysql_connect($db_host, $db_user, $db_pwd) or die ("ERROR EN LA CONEXION");
		$db = mysql_select_db ($db_name ,$cn) or die ("ERROR AL CONECTAR A LA BD");
		 
		$c1="truncate table robotcanceladas_robot_tecnicas";		
		mysql_query($c1,$cn);
		 
		// Cargando la hoja de calculo
		$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
		$objPHPExcel = $objReader->load($archivo_xlsx); //carga en objphpExcel por medio de objReader,el nombre del archivo
		$objFecha = new PHPExcel_Shared_Date();
		 
		// Asignar hoja de excel activa
		$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
		 
		// Llenamos un arreglo con los datos del archivo xlsx
		//$i=1; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
		$param=0;
		$contador=0;
		
		$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		//$numRows = 300;
		
		//echo $numRows; 
		
		//while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
		
		
		
		for ($i = 2; $i <= $numRows ; $i++) 
		{
		
		$col_1				=$objPHPExcel->getActiveSheet()->getCell('A'.$i);
		$col_2				=$objPHPExcel->getActiveSheet()->getCell('B'.$i);
		$col_3				=$objPHPExcel->getActiveSheet()->getCell('C'.$i);
		$col_4				=$objPHPExcel->getActiveSheet()->getCell('D'.$i);
		$col_5				=$objPHPExcel->getActiveSheet()->getCell('E'.$i);
		$col_6				=$objPHPExcel->getActiveSheet()->getCell('F'.$i);
		$col_7				=$objPHPExcel->getActiveSheet()->getCell('G'.$i);
		$col_8				=$objPHPExcel->getActiveSheet()->getCell('H'.$i);
		$col_9				=$objPHPExcel->getActiveSheet()->getCell('I'.$i);
		
		
		//echo $mes."|".$cip."|".$nombres."|".$fec_fin_horario."|".$cod_horario."|".$fec_ini_horario."<br>";
 		
		
		$sql = "INSERT INTO robotcanceladas_robot_tecnicas
				 VALUES ('$col_1','$col_2','$col_3','$col_4','$col_5','$col_6','$col_7','$col_8','$col_9',now())";
		//echo $sql."<p>";
		
		mysql_query($sql,$cn);
		
		}
	
	}else{
	echo "No se encontro ".$archivo_xlsx."<br>";
	}
	
	//unlink($archivo_xlsx); 
}
	
?>