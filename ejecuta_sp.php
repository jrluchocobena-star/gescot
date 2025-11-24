<?php
	require_once('conexion.php');
	$db=DB::conectar();
	$update=$db->prepare('CALL Update_horario_cot_mes()');
	$update->execute();
?>