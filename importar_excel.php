<body>
<p class="formulario">* Selecciona el archivo Excel a Importar (.xlsx): </p><br/>
 
<img src="image/excel5.jpg" width="50" height="50" /><p>
 
<form name="importa" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" >
<input type="file" name="excel" />
<input type='submit' name='enviar' value="Importar" />
<input type="hidden" value="upload" name="action" />
</form>
<p>
 
<?php
extract($_POST);
if ($action == "upload") //si action tiene como valor UPLOAD haga algo (el value de este hidden es es UPLOAD iniciado desde el value
{
//cargamos el archivo al servidor con el mismo nombre(solo le agregue el sufijo bak_)
$archivo = $_FILES['excel']['name']; //captura el nombre del archivo
$tipo = $_FILES['excel']['type']; //captura el tipo de archivo (2003 o 2007)
 
$destino = "bak_".$archivo; //lugar donde se copiara el archivo

echo $destino."<br>";
 
if (copy($_FILES['excel']['tmp_name'],$destino)) //si dese copiar la variable excel (archivo).nombreTemporal a destino (bak_.archivo) (si se ha dejado copiar)
{
echo "Archivo Cargado Con Exito";
}
else
{
echo "Error Al Cargar el Archivo";
}
 
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)) //validacion para saber si el archivo ya existe previamente
{
/*INVOCACION DE CLASES Y CONEXION A BASE DE DATOS*/
/** Invocacion de Clases necesarias */
require_once("PHPExcel_/PHPExcel.php");
require_once('PHPExcel/Excel2007.php');
//DATOS DE CONEXION A LA BASE DE DATOS
$cn = mysql_connect ("localhost","root","") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("cot",$cn) or die ("ERROR AL CONECTAR A LA BD");
 
 
// Cargando la hoja de calculo
$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
$objPHPExcel = $objReader->load("bak_".$archivo); //carga en objphpExcel por medio de objReader,el nombre del archivo
$objFecha = new PHPExcel_Shared_Date();
 
// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
 
// Llenamos un arreglo con los datos del archivo xlsx
$i=1; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
$param=0;
$contador=0;
while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
{
 
	$Zonal=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$n_requer=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	$Area_Ant=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
	$AREA=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$Cliente=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$VIP=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	$CORP=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$Agendado=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$En_Gaudi=$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$Seg_Gaudi=$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$PAI=$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$Nivel_Ubic=$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	$Peticion=$objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
	$MultiServicio=$objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
	$Tipo_Deco=$objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
	$T_Rq=$objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
	$Motv=$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
	$Descripcion_Motivo=$objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
	$Cod_Cmts=$objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
	$Descrip_Cmts=$objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
	$Nodo=$objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
	$Plano=$objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
	$Troncal=$objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
	$Sector=$objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
	$Line_Ext=$objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
	$Tap=$objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
	$Borne=$objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
	$Numcoo_X=$objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
	$Numcoo_Y=$objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
	$Dist=$objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
	$Via=$objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
	$Direccion=$objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
	$Numero=$objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
	$INT=$objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
	$Piso=$objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
	$Mzn=$objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
	$Lote=$objPHPExcel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
	$Urb=$objPHPExcel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
	$Nombre_Urb=$objPHPExcel->getActiveSheet()->getCell('AN'.$i)->getCalculatedValue();
	$Referencia=$objPHPExcel->getActiveSheet()->getCell('AO'.$i)->getCalculatedValue();
	$Clase_Srv=$objPHPExcel->getActiveSheet()->getCell('AP'.$i)->getCalculatedValue();
	$Señal_de_la_Troba=$objPHPExcel->getActiveSheet()->getCell('AQ'.$i)->getCalculatedValue();
	$_Cr=$objPHPExcel->getActiveSheet()->getCell('AR'.$i)->getCalculatedValue();
	$Premium=$objPHPExcel->getActiveSheet()->getCell('AS'.$i)->getCalculatedValue();
	$N_Cross=$objPHPExcel->getActiveSheet()->getCell('AT'.$i)->getCalculatedValue();
	$Categoria_Srv=$objPHPExcel->getActiveSheet()->getCell('AV'.$i)->getCalculatedValue();
	$Tlf=$objPHPExcel->getActiveSheet()->getCell('AU'.$i)->getCalculatedValue();
	$Fecha_Llegada=$objPHPExcel->getActiveSheet()->getCell('AW'.$i)->getCalculatedValue();
	$fechallegada1=$objPHPExcel->getActiveSheet()->getCell('AX'.$i)->getCalculatedValue();
	$dia=$objPHPExcel->getActiveSheet()->getCell('AY'.$i)->getCalculatedValue();
	$hora=$objPHPExcel->getActiveSheet()->getCell('AZ'.$i)->getCalculatedValue();
	$Sit=$objPHPExcel->getActiveSheet()->getCell('BA'.$i)->getCalculatedValue();
	$Edo=$objPHPExcel->getActiveSheet()->getCell('BB'.$i)->getCalculatedValue();
	$Motv_=$objPHPExcel->getActiveSheet()->getCell('BC'.$i)->getCalculatedValue();
	$Ofc_Adm=$objPHPExcel->getActiveSheet()->getCell('BD'.$i)->getCalculatedValue();
	$F_Prg_MM=$objPHPExcel->getActiveSheet()->getCell('BE'.$i)->getCalculatedValue();
	$Prior=$objPHPExcel->getActiveSheet()->getCell('BF'.$i)->getCalculatedValue();
	$Observaciones=$objPHPExcel->getActiveSheet()->getCell('BG'.$i)->getCalculatedValue();
	$Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BH'.$i)->getCalculatedValue();
	$Cod_Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BI'.$i)->getCalculatedValue();
	$Contacto_Clte=$objPHPExcel->getActiveSheet()->getCell('BJ'.$i)->getCalculatedValue();
	$Cliente_Conforme=$objPHPExcel->getActiveSheet()->getCell('BK'.$i)->getCalculatedValue();
	$Tel_Contacto_CCT=$objPHPExcel->getActiveSheet()->getCell('BL'.$i)->getCalculatedValue();
	$Tel_Contacto_REF_CCT=$objPHPExcel->getActiveSheet()->getCell('BM'.$i)->getCalculatedValue();
	$Mot_Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BN'.$i)->getCalculatedValue();
	$DescMot_Autorizcion=$objPHPExcel->getActiveSheet()->getCell('BO'.$i)->getCalculatedValue();
	$Escenario_Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BP'.$i)->getCalculatedValue();
	$Tecnico=$objPHPExcel->getActiveSheet()->getCell('BQ'.$i)->getCalculatedValue();
	$Nombre_Tecnico=$objPHPExcel->getActiveSheet()->getCell('BR'.$i)->getCalculatedValue();
	$Fec_Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BS'.$i)->getCalculatedValue();
	$Usu_Autorizacion=$objPHPExcel->getActiveSheet()->getCell('BT'.$i)->getCalculatedValue();
	$Encuesta=$objPHPExcel->getActiveSheet()->getCell('BU'.$i)->getCalculatedValue();
	$Contacto_Enc=$objPHPExcel->getActiveSheet()->getCell('BV'.$i)->getCalculatedValue();
	$Parentesco_Enc=$objPHPExcel->getActiveSheet()->getCell('BW'.$i)->getCalculatedValue();
	$Telefono_Enc=$objPHPExcel->getActiveSheet()->getCell('BX'.$i)->getCalculatedValue();
	$Incidencia=$objPHPExcel->getActiveSheet()->getCell('BY'.$i)->getCalculatedValue();
	$Ticket_Incidencia=$objPHPExcel->getActiveSheet()->getCell('BZ'.$i)->getCalculatedValue();
	$Seg_Incidencia=$objPHPExcel->getActiveSheet()->getCell('CA'.$i)->getCalculatedValue();
	$Resegmentacion=$objPHPExcel->getActiveSheet()->getCell('CB'.$i)->getCalculatedValue();
	$Tipo_Paquete=$objPHPExcel->getActiveSheet()->getCell('CC'.$i)->getCalculatedValue();
	$N_OS=$objPHPExcel->getActiveSheet()->getCell('CD'.$i)->getCalculatedValue();
	$Estado_OS=$objPHPExcel->getActiveSheet()->getCell('CE'.$i)->getCalculatedValue();
	$Tipo_Linea=$objPHPExcel->getActiveSheet()->getCell('CF'.$i)->getCalculatedValue();
	$NroTlfVOIP=$objPHPExcel->getActiveSheet()->getCell('CG'.$i)->getCalculatedValue();
	$PromLinea=$objPHPExcel->getActiveSheet()->getCell('CH'.$i)->getCalculatedValue();
	$Descripcion_Prom_Linea=$objPHPExcel->getActiveSheet()->getCell('CI'.$i)->getCalculatedValue();
	$Tipo_Tecnologia=$objPHPExcel->getActiveSheet()->getCell('CJ'.$i)->getCalculatedValue();

 
$c=("insert into tb_cms values('','$Zonal,'$n_requer,'$Area_Ant,'$AREA,'$Cliente,'$VIP,'$CORP,'$Agendado,'$En_Gaudi,'$Seg_Gaudi,'$PAI,'$Nivel_Ubic,'$Peticion,'$MultiServicio,'$Tipo_Deco,'$T_Rq,'$Motv,'$Descripcion_Motivo,'$Cod_Cmts,'$Descrip_Cmts,'$Nodo,'$Plano,'$Troncal,'$Sector,'$Line_Ext,'$Tap,'$Borne,'$Numcoo_X,'$Numcoo_Y,'$Dist,'$Via,'$Direccion,'$Numero,'$INT,'$Piso,'$Mzn,'$Lote,'$Urb,'$Nombre_Urb,'$Referencia,'$Clase_Srv,'$Señal_de_la_Troba,'$_Cr,'$Premium,'$N_Cross,'$Categoria_Srv,'$Tlf,'$Fecha_Llegada,'$fechallegada1,'$dia,'$hora,'$Sit,'$Edo,'$Motv_,'$Ofc_Adm,'$F_Prg_MM,'$Prior,'$Observaciones,'$Autorizacion,'$Cod_Autorizacion,'$Contacto_Clte,'$Cliente_Conforme,'$Tel_Contacto_CCT,'$Tel_Contacto_REF_CCT,'$Mot_Autorizacion,'$DescMot_Autorizcion,'$Escenario_Autorizacion,'$Tecnico,'$Nombre_Tecnico,'$Fec_Autorizacion,'$Usu_Autorizacion,'$Encuesta,'$Contacto_Enc,'$Parentesco_Enc,'$Telefono_Enc,'$Incidencia,'$Ticket_Incidencia,'$Seg_Incidencia,'$Resegmentacion,'$Tipo_Paquete,'$N_OS,'$Estado_OS,'$Tipo_Linea,'$NroTlfVOIP,'$PromLinea,'$Descripcion_Prom_Linea,'$Tipo_Tecnologia)");
echo $c;
mysql_query($c);
 
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
unlink($destino); //desenlazar a destino el lugar donde salen los datos(archivo)
}
 
?>
 
 
 
</div>
 
 
</body>