<?php 
/*
	$fecha_i = '02/03/2017';
    $fecha_f = '10/03/2017';

    $begin = new DateTime($fecha_i);
    $end = new DateTime($fecha_f);
    $end = $end->modify( '+1 day' );
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval ,$end);

    foreach($daterange as $date){
		if(date('l', strtotime($date->format("d-m-Y"))) == 'Sunday' || date('l', strtotime($date->format("d-m-Y"))) == 'Saturday'){
			print 'Fin de Semana: '.$date->format("d-m-Y")."<br>";
		} else {
			print 'Semana: '.$date->format("d-m-Y")."<br>"; 
		}
	}
*/

$fecha="2018-10-06";
$dia=date("w", strtotime($fecha));

if($dia=="0"){
	echo $fecha."es Domingo";
}
if($dia=="6"){
	echo $fecha." es Sabado";
}

?>