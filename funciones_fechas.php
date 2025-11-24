<?php 

function cambiaf_a_mysql($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}


function dif_fechas($fechaInicio){	

	$date1=date("Y/m/d h:i"); //"2007-04-16 19:18";
	$date2=$fechaInicio;  //"2007-04-15 13:05";
	
	$s = strtotime($date1)-strtotime($date2);
	$d = intval($s/86400);
	$s -= $d*86400;
	$h = intval($s/3600);
	$s -= $h*3600;
	$m = intval($s/60);
	$s -= $m*60;
	
	$dif= (($d*24)+$h).",".hrs.",".$m."min";
//	$dif2= $d.$space.",".dias.",".$h.",".hrs." ".$m.",min";
	$dif2=$d.$space."d | ".$h."h | ".$m."'";
	return $dif2 ;
}

function dif_2_fechas($date1,$date2){	

	$s = strtotime($date1)-strtotime($date2);
	$d = intval($s/86400);
	$s -= $d*86400;
	$dif2=$d.$space;
	return $dif2 ;
}

function suma_vacaciones($fecha,$ndias)
            
 
{
            
 
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$año)=split("/", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
 
      return ($nuevafecha);  
            
 
}

function n_dias($fecha_desde,$fecha_hasta)
{
$dias= (strtotime($fecha_desde)-strtotime($fecha_hasta))/86400;
$dias = abs($dias); $dias = floor($dias);
return  $dias;
} 


function calcular_tiempo_trasnc($fechaInicio,$fechaFin){ 

	$fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
        
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
            
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }
        
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
            
        if($fecha->m == 1)
            $tiempo .= " mes, ";
        else
            $tiempo .= " meses, ";
    }
        
    //dias
    if($fecha->d > 0)
    {
        $tiempo .= $fecha->d;
            
        if($fecha->d == 1)
            $tiempo .= " dia, ";
        else
            $tiempo .= " dias, ";
    }
        
    //horas
    if($fecha->h > 0)
    {
        $tiempo .= $fecha->h;
            
        if($fecha->h == 1)
            $tiempo .= " hora, ";
        else
            $tiempo .= " horas, ";
    }
        
    //minutos
    if($fecha->i > 0)
    {
        $tiempo .= $fecha->i;
            
        if($fecha->i == 1)
            $tiempo .= " minuto";
        else
            $tiempo .= " minutos";
    }
    else if($fecha->i == 0) //segundos
        $tiempo .= $fecha->s." segundos";
        
    return $tiempo;
}  
//llamamos la función e imprimimos 


function diff_sinp($fecha1,$fecha2,$tiempo1,$tiempo2){
   $dif = date("H:i", strtotime("00:00") + strtotime($tiempo2) - strtotime($tiempo1));
   /*
   if($dif == '00:00'){
      $dif = null;
   }
   $difd = date_diff(date_create($fecha1),date_create($fecha2));
   $difd = $difd->format('%a');
   */
   return rtrim($dif);
   //return $difd;
}


function calcular_tiempo_($fechaInicio,$fechaFin){ 

	$fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
        
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
            
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }
        
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
            
        if($fecha->m == 1)
            $tiempo .= " mes, ";
        else
            $tiempo .= " meses, ";
    }
        
    //dias
    if($fecha->d > 0)
    {
        $tiempo .= $fecha->d;
            
        if($fecha->d == 1)
            $tiempo .= " dia, ";
        else
            $tiempo .= " dias, ";
    }
        
    //horas
    if($fecha->h > 0)
    {
        $tiempo .= $fecha->h;
            
        if($fecha->h == 1)
            $tiempo .= ":";
        else
            $tiempo .= ":";
    }
        
    //minutos
    if($fecha->i > 0)
    {
        $tiempo .= $fecha->i;
            
        if($fecha->i == 1)
            $tiempo .= ":00";
        else
            $tiempo .= ":00";
    }
    else if($fecha->i == 0) //segundos
        $tiempo .= $fecha->s.":";
        
    return $tiempo;
} 

/********************************************/


function DiasHabiles($fecha_inicial,$fecha_final) 
{ 
list($dia,$mes,$year) = explode("-",$fecha_inicial); 
$ini = mktime(0, 0, 0, $mes , $dia, $year); 
list($diaf,$mesf,$yearf) = explode("-",$fecha_final); 
$fin = mktime(0, 0, 0, $mesf , $diaf, $yearf); 
 
$r = 1; 
while($ini != $fin) 
{ 
$ini = mktime(0, 0, 0, $mes , $dia+$r, $year); 
$newArray[]=$ini;  
$r++; 
} 
return $newArray; 
}
 
 
function Evalua($arreglo) 
{ 
$feriados        = array( 
'1-1',  //  Año Nuevo (irrenunciable) 
'10-4',  //  Viernes Santo (feriado religioso) 
'11-4',  //  Sábado Santo (feriado religioso) 
'1-5',  //  Día Nacional del Trabajo (irrenunciable) 
'21-5',  //  Día de las Glorias Navales 
'29-6',  //  San Pedro y San Pablo (feriado religioso) 
'16-7',  //  Virgen del Carmen (feriado religioso) 
'15-8',  //  Asunción de la Virgen (feriado religioso) 
'18-9',  //  Día de la Independencia (irrenunciable) 
'19-9',  //  Día de las Glorias del Ejército 
'12-10',  //  Aniversario del Descubrimiento de América 
'31-10',  //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso) 
'1-11',  //  Día de Todos los Santos (feriado religioso) 
'8-12',  //  Inmaculada Concepción de la Virgen (feriado religioso) 
'13-12',  //  elecciones presidencial y parlamentarias (puede que se traslade al domingo 13) 
'25-12',  //  Natividad del Señor (feriado religioso) (irrenunciable) 
); 
 
 
$j= count($arreglo); 
 
for($i=0;$i<=$j;$i++) 
{ 
$dia = $arreglo[$i]; 
 
        $fecha = getdate($dia); 
            $feriado = $fecha['mday']."-".$fecha['mon']; 
                    if($fecha["wday"]==0 or $fecha["wday"]==6) 
                    { 
                        $dia_ ++; 
                    } 
                        elseif(in_array($feriado,$feriados)) 
                        {    
                            $dia_++; 
                        } 
} 
$rlt = $j - $dia_; 
return $rlt; 
}
 
$CantidadDiasHabiles = Evalua(DiasHabiles('19-10-2010','28-12-2010')); 
 
//echo   $CantidadDiasHabiles; 

/********************************************/
function Obtener_valor($NombreCorto,$Cadena){

//echo $NombreCorto."|".$Cadena;

  $result = 0;
  
  switch(TRUE)
  {
    case ($NombreCorto=="Lu" && substr($Cadena,0,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Ma" && substr($Cadena,1,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Mi" && substr($Cadena,2,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Ju" && substr($Cadena,3,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Vi" && substr($Cadena,4,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Sa" && substr($Cadena,5,1)== "1") :   $result = 1;
    break;
    case ($NombreCorto=="Do" && substr($Cadena,6,1)== "1") :   $result = 1;
    break;
    default: $result = 0;
  }

  return $result;
}



function borrar_caracteres($cadena){
//	echo "entro";
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã'","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã\"","Ã‹","Ñ","ñ",'#([^.a-z0-9]+)#i','#-{2,}#','#|^-#´-',
'"','/','//');
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N","n",'','','','','','');
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}

function hourIsBetween($from, $to, $input) {
    $dateFrom = DateTime::createFromFormat('!H:i', $from);
    $dateTo = DateTime::createFromFormat('!H:i', $to);
    $dateInput = DateTime::createFromFormat('!H:i', $input);
    if ($dateFrom > $dateTo) $dateTo->modify('+1 day');
    return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
}


function verifica_rango($date_inicio, $date_fin, $date_nueva) {
   $date_inicio = strtotime($date_inicio);
   $date_fin = strtotime($date_fin);
   $date_nueva = strtotime($date_nueva);
   if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin))
	   return true;
   return false;
}
?>  

