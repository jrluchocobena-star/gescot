
<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$from = '07:00';
$to = '15:00';
$dateTest = new DateTime('midnight');
for ($a = 1; $a 	<= 24; $a++) {
    $input = $dateTest->format('H:i');
	$valor = (hourIsBetween($from, $to, $input) ? 'Yes' : 'No');
	
	
	if ($valor=="No"){
		echo "<br>".$input."|".$valor;
	}
    //echo "<br>"."$from <= $input <= $to -> " . (hourIsBetween($from, $to, $input) ? 'Yes' : 'No') . "\n";
	//echo "<br>".$input."=".$valor;
    $dateTest->modify("+1 hour");
	
}



$date_nueva = date('Y-m-d');
$date_inicio = date('Y-06-01');
$date_fin = date('Y-06-31');
 
echo "<p>";

if (verifica_rango($date_inicio, $date_fin, $date_nueva)) {
    echo '<div class="alert alert-danger">Salimos de vacaciones.</div>';
}
else {
    echo '<div class="alert alert-success">Atendemos de Lunes a viernes.</strong></div>';
}
?>