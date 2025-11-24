<?PHP
include("funciones_fechas.php");
$xmes_archivo	= date("mY");
$xmes_carga		= date("m-Y");
$archivo_xlsx	="d://compartido/data/horarios_cot/Horarios_".$xmes_archivo.".xlsx";  
$archivo_csv	="d://compartido/data/horarios_cot/Horarios_".$xmes_archivo.".csv"; 

		
		
		 
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
		$db_pwd = '';
		$db_name = 'cot';
	
			
		$cn = mysql_connect($db_host, $db_user, $db_pwd) or die ("ERROR EN LA CONEXION");
		$db = mysql_select_db ($db_name ,$cn) or die ("ERROR AL CONECTAR A LA BD");
		 
		$c1="truncate table horario_cot_mes_prueba";		
		mysql_query($c1,$cn);
		 
		// Cargando la hoja de calculo
		$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
		$objPHPExcel = $objReader->load($archivo_xlsx); //carga en objphpExcel por medio de objReader,el nombre del archivo
		$objFecha = new PHPExcel_Shared_Date();
		 
		// Asignar hoja de excel activa
		$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
		 
		// Llenamos un arreglo con los datos del archivo xlsx
		$i=3; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
		$param=0;
		$contador=0;
		
		$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		
		//echo $numRows; 
		
		//while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
		for ($i = 3; $i <= $numRows; $i++) 
		{
		 
		$mes				=$xmes_carga;
		$cip				=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$nombres			=trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		$fec_ini_horario	=$objPHPExcel->getActiveSheet()->getCell('D'.$i);
		$fec_ini_horario	= date($format = "d-m-Y", PHPExcel_Shared_Date::ExcelToPHP($fec_ini_horario)); 
		$cod_horario		=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$fec_fin_horario	=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
		//$fec_fin_horario	= date("d/m/Y",$fec_fin_horario);
		$obs				=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		
		
		//echo $mes."|".$cip."|".$nombres."|".$fec_fin_horario."|".$cod_horario."|".$fec_ini_horario."<br>";
 		
		
		$c2="insert into horario_cot_mes_prueba values('$mes','$cip','$nombres','$fec_ini_horario',
		'$cod_horario','$fec_fin_horario','$obs','','','','','','','','')";
		//echo $c2."<p>";
		
		mysql_query($c2,$cn);
		
		/*
		$c3="update horario_cot_mes_prueba set fecha_inicio=DATE_FORMAT(fecha_inicio, 'd-m-Y')";
		echo $c3."<p>";
		
		mysql_query($c3,$cn);
		 */
		if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
		{
		$param=1; //para detener el ciclo cuando haya encontrado un valor NULL
		}
		$i++;
		$contador=$contador+1;
		}
		$totalIngresados=$contador-1; //(porque se se para con un NULL y le esta registrando como que tambien un dato)
		echo "- Total elementos subidos: $totalIngresados ";
		}
		else//si no se ha cargado el bak
		{
		echo "Necesitas primero importar el archivo";}
		unlink($archivo_xlsx); //desenlazar a destino el lugar donde salen los datos(archivo)		
		 
}else{
	echo "No se encontro ".$archivo_xlsx."<br>";
}
	
?>