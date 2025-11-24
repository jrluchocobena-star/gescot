<?php
require('PHPExcel_/PHPExcel.php');


$iduser = $_GET["iduser"];
$dni = $_GET["dni"];
$xmes = date("Y")."-".$_GET["xmes"];


$conexion = new mysqli('localhost','root','','cot',3306);
if (mysqli_connect_errno()) {
   printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
   exit();
}



$objPHPExcel = new PHPExcel;

//First sheet
$sheet = $objPHPExcel->getActiveSheet();

$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

//Start adding next sheets

// Pagina 1 //
/***********************************************************************************************************************/

$HOJA="INFO_GENERAL";

$i=1;
// Add new sheet
$objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating

//Write cells
$objWorkSheet->setCellValue('A2', 'ID')
		   ->setCellValue('B2', 'NOMBRE COMPLETO')
		   ->setCellValue('C2', 'DNI')
		   ->setCellValue('D2', 'CIP')
           ->setCellValue('E2', 'ESTADO')
		   ->setCellValue('F2', 'AREA')
		   ->setCellValue('G2', 'GRUPO')
		   ->setCellValue('H2', 'S-GRUPO')
		   ->setCellValue('I2', 'CORREO PERSONAL')
           ->setCellValue('J2', 'CORREO TRABAJO')
		   ->setCellValue('K2', 'CEL.1')
		   ->setCellValue('L2', 'CEL.2')
		   ->setCellValue('M2', 'ANEXO')
		   ->setCellValue('N2', 'LOCAL-PISO')
           ->setCellValue('O2', 'SUPERVISOR')
		   ->setCellValue('P2', 'MONITOR(A)')
		   ->setCellValue('Q2', 'INVENTARIO PC')
		   ->setCellValue('R2', 'INVENTARIO MONITOR')
		   ->setCellValue('S2', 'OLA')		
		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:S2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('G')->setAutoSize(true);
$objWorkSheet->getColumnDimension('H')->setAutoSize(true);
$objWorkSheet->getColumnDimension('I')->setAutoSize(true);
$objWorkSheet->getColumnDimension('J')->setAutoSize(true);
$objWorkSheet->getColumnDimension('K')->setAutoSize(true);
$objWorkSheet->getColumnDimension('L')->setAutoSize(true);
$objWorkSheet->getColumnDimension('M')->setAutoSize(true);
$objWorkSheet->getColumnDimension('N')->setAutoSize(true);
$objWorkSheet->getColumnDimension('O')->setAutoSize(true);
$objWorkSheet->getColumnDimension('P')->setAutoSize(true);
$objWorkSheet->getColumnDimension('Q')->setAutoSize(true);
$objWorkSheet->getColumnDimension('R')->setAutoSize(true);
$objWorkSheet->getColumnDimension('S')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_1 = "select * from tb_usuarios WHERE estado='HABILITADO' order by dni ";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_1; 
$res_q1 = $conexion->query($query_1);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_1 = $res_q1->fetch_ARRAY()) { 
	
	$c_supervisor = $fila_1['c_supervisor'];
	$c_monitor = $fila_1['c_monitor'];
	
	$query_s = "select * from tb_supervisores WHERE cod_supervisor='$c_supervisor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_1; 
	$res_qs = $conexion->query($query_s);
	$fila_s = $res_qs->fetch_ARRAY();
	
	$query_m = "select * from tb_monitores WHERE cod_monitor='$c_monitor'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_1; 
	$res_qm = $conexion->query($query_m);
	$fila_m = $res_qm->fetch_ARRAY();
	
 	$objWorkSheet->setCellValue('A'.$i, $fila_1['iduser'])
	 ->setCellValue('B'.$i, $fila_1['ncompleto'])
	 ->setCellValue('C'.$i, $fila_1['dni'])
	  ->setCellValue('D'.$i, $fila_1['cip'])
	 ->setCellValue('E'.$i, $fila_1['estado'])
	 ->setCellValue('F'.$i, $fila_1['n_area'])
	 ->setCellValue('G'.$i, $fila_1['grupo'])
	 ->setCellValue('H'.$i, $fila_1['sgrupo'])
	  ->setCellValue('I'.$i, $fila_1['correo_personal'])
	 ->setCellValue('J'.$i, $fila_1['correo_w'])
	 ->setCellValue('K'.$i, $fila_1['celular1'])
	 ->setCellValue('L'.$i, $fila_1['celular2'])
	 ->setCellValue('M'.$i, $fila_1['anexo'])
	  ->setCellValue('N'.$i, $fila_1['local'])
	 ->setCellValue('O'.$i, $fila_s['nom_supervisor'])
	 ->setCellValue('P'.$i, $fila_m['nom_monitor'])
	 ->setCellValue('Q'.$i, $fila_1['pc'])
	 ->setCellValue('R'.$i, $fila_1['monitor'])
	 ->setCellValue('S'.$i, $fila_1['ola'])
	 ;
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:S".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("A2:A".$i)->applyFromArray($estilo);

/********************************************************************************************************************/
//PAGINA 2

$HOJA = "INFO SISTEMAS";
//Write cells
$objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating

$objWorkSheet->setCellValue('A2', 'ID')
		   ->setCellValue('B2', 'NOMBRE COMPLETO')
		   ->setCellValue('C2', 'DNI')
		   ->setCellValue('D2', 'CIP')
           ->setCellValue('E2', 'U.MULTICONSULTA')
		   ->setCellValue('F2', 'U.INTRAWAY')
		   ->setCellValue('G2', 'U.WEB UNIFICADA')
		   ->setCellValue('H2', 'U.PSI')
		   ->setCellValue('I2', 'U.ATIS')
           ->setCellValue('J2', 'PERFIL ATIS')
		   ->setCellValue('K2', 'U.CMS')
		   ->setCellValue('L2', 'PERFIL CMS')
		   ->setCellValue('M2', 'U.GESTEL')
		   ->setCellValue('N2', 'PERFIL CMS')
           ->setCellValue('O2', 'U.WEB INCIDENCIAS PSI')
		   ->setCellValue('P2', 'PDM')
		   ->setCellValue('Q2', 'CLEAR_VIEW')
		   ->setCellValue('R2', 'REPARTIDOR')
		   ->setCellValue('S2', 'U. WEB SARA')	
		   ->setCellValue('T2', 'U.WEB ASEGURAMIENTO')
           ->setCellValue('U2', 'U.WEB ARPU')
		   ->setCellValue('V2', 'U.GENIO')
		   ->setCellValue('W2', 'U.WEB ASIGNACION')
		   ->setCellValue('X2', 'U.SIGTPMAPA SIG ')
		   ->setCellValue('Y2', 'U.RED ')
		   ;

// Making headers text bold and larger
//$objWorkSheet->getStyle('A3:B5')->getFont()->setBold(true)->setSize(12);
$objWorkSheet->getStyle('A2:Y2')->getFont()->setBold(true)->setSize(12);

// Autosize the columns
$objWorkSheet->getColumnDimension('A')->setAutoSize(true);
$objWorkSheet->getColumnDimension('B')->setAutoSize(true);
$objWorkSheet->getColumnDimension('C')->setAutoSize(true);
$objWorkSheet->getColumnDimension('D')->setAutoSize(true);
$objWorkSheet->getColumnDimension('E')->setAutoSize(true);
$objWorkSheet->getColumnDimension('F')->setAutoSize(true);
$objWorkSheet->getColumnDimension('G')->setAutoSize(true);
$objWorkSheet->getColumnDimension('H')->setAutoSize(true);
$objWorkSheet->getColumnDimension('I')->setAutoSize(true);
$objWorkSheet->getColumnDimension('J')->setAutoSize(true);
$objWorkSheet->getColumnDimension('K')->setAutoSize(true);
$objWorkSheet->getColumnDimension('L')->setAutoSize(true);
$objWorkSheet->getColumnDimension('M')->setAutoSize(true);
$objWorkSheet->getColumnDimension('N')->setAutoSize(true);
$objWorkSheet->getColumnDimension('O')->setAutoSize(true);
$objWorkSheet->getColumnDimension('P')->setAutoSize(true);
$objWorkSheet->getColumnDimension('Q')->setAutoSize(true);
$objWorkSheet->getColumnDimension('R')->setAutoSize(true);
$objWorkSheet->getColumnDimension('S')->setAutoSize(true);
$objWorkSheet->getColumnDimension('T')->setAutoSize(true);
$objWorkSheet->getColumnDimension('U')->setAutoSize(true);
$objWorkSheet->getColumnDimension('V')->setAutoSize(true);
$objWorkSheet->getColumnDimension('W')->setAutoSize(true);
$objWorkSheet->getColumnDimension('X')->setAutoSize(true);
$objWorkSheet->getColumnDimension('Y')->setAutoSize(true);
// Rename sheet
$objWorkSheet->setTitle($HOJA);
		   



//Se agregan los datos de los alumnos
 
$query_2 = "SELECT * FROM usuarios_detalle where dni<>'' ORDER BY dni";
//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
//echo $query_2; 
$res_q2 = $conexion->query($query_2);

$i = 3; //Numero de fila donde se va a comenzar a rellenar
$item = 0;


while ($fila_2 = $res_q2->fetch_ARRAY()) { 
	
	$xdni = $fila_2['DNI'];

	$query_u = "select * from tb_usuarios WHERE dni='$xdni'";
	//$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	//echo $query_u; 
	$res_qu = $conexion->query($query_u);
	$fila_u = $res_qu->fetch_ARRAY();

	if ($fila_u['dni']<>''){	
		if ($fila_u['dni']==$fila_2['DNI']){			   
		 $objWorkSheet->setCellValue('A'.$i, $fila_u['iduser'])
		 ->setCellValue('B'.$i, $fila_u['ncompleto'])
		 ->setCellValue('C'.$i, $fila_u['dni'])
		 ->setCellValue('D'.$i, $fila_u['cip'])
		 ->setCellValue('E'.$i, $fila_2['USUARIO_MULTICONSULTA'])
		 ->setCellValue('F'.$i, $fila_2['USUARIO_INTRAWAY'])
		 ->setCellValue('G'.$i, $fila_2['USUARIO_WEB_UNIFICADA'])
		 ->setCellValue('H'.$i, $fila_2['USUARIO_PSI'])
		 ->setCellValue('I'.$i, $fila_2['USUARIO_ATIS'])
		 ->setCellValue('J'.$i, $fila_2['PERFIL_ATIS'])
		 ->setCellValue('K'.$i, $fila_2['USUARIO_CMS'])
		 ->setCellValue('L'.$i, $fila_2['PERFIL_CMS'])
		 ->setCellValue('M'.$i, $fila_2['USUARIO_GESTEL'])
		 ->setCellValue('N'.$i, $fila_2['PERFIL_GESTEL'])
		 ->setCellValue('O'.$i, $fila_2['WEB_INCIDENCIAS_PSI'])
		 ->setCellValue('P'.$i, $fila_2['PDM'])
		 ->setCellValue('Q'.$i, $fila_2['CLEAR_VIEW'])
		 ->setCellValue('R'.$i, $fila_2['REPARTIDOR'])
		 ->setCellValue('S'.$i, $fila_2['WEB_SARA'])
		 ->setCellValue('T'.$i, $fila_2['WEB_ASEGURAMIENTO'])
		 ->setCellValue('U'.$i, $fila_2['WEB_ARPU_CALCULADORA'])
		 ->setCellValue('V'.$i, $fila_2['USUARIO_GENIO'])
		 ->setCellValue('W'.$i, $fila_2['WEB_ASIGNACIONES'])
		 ->setCellValue('X'.$i, $fila_2['WEB_SIGTP_MAPA_GIG'])
		 ->setCellValue('Y'.$i, $fila_2['usuario_red']);
		}
	}
 $i++;
}
	   
	   
$objWorkSheet->getStyle("A2:Y".$i)->applyFromArray(
    array( 
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')				
            )
        )
    )
);

$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

$objPHPExcel->getActiveSheet()->getStyle("A2:Y".$i)->applyFromArray($estilo);

/*********************************************************************************************************************/
// Rename sheet
//$objWorkSheet->setTitle("HOJA".$i);


// POner hoja por defecto
//$objPHPExcel->setActiveSheetIndex(0);
		   
// Save the spreadsheet
//$writer->save('products.xlsx');
$n_archivo="programacion_maestra_".date("Y-m-d").".xls";


header('Content-Disposition: attachment;filename="'.$n_archivo.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
