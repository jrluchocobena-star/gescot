<?php

class ValidacionAlerta {
	public function run($params = array()) {
		$fechaInicio = isset($params["fechaInicio"])? $params["fechaInicio"] : date("Y-m-d H:i:s");
		$fechaFin = isset($params["fechaFin"])? $params["fechaFin"] : date("Y-m-d H:i:s");
		$motivo = isset($params["motivo"])? $params["motivo"] : "";
		$cipUser = isset($params["cipUser"])? $params["cipUser"] : "";
		$dniUser = isset($params["dniUser"])? $params["dniUser"] : "";
		$modo = isset($params["modo"])? $params["modo"] : "D";

		if (
			$fechaInicio == "" || 
			$fechaInicio == "0000-00-00 00:00:00" || 
			is_null($fechaInicio)
		) {
			return array("error" => true, "message" => "Debe registrar una Fecha de Inicio Válida", "tipo" => "notificacion");
		}
		if (
			$fechaFin == "" || 
			$fechaFin == "0000-00-00 00:00:00" || 
			is_null($fechaFin)
		) {
			return array("error" => true, "message" => "Debe registrar una Fecha de Fin Válida", "tipo" => "notificacion");
		}

		if ($fechaInicio > $fechaFin){
			return array("error" => true, "message" => "La fecha inicial no puede ser mayor que la fecha final", "tipo" => "notificacion");
		}
		if (
			$motivo == "" ||
			is_null($motivo)
		) {
			return array("error" => true, "message" => "Debe registrar una Motivo Válido", "tipo" => "notificacion");
		}
		if (
			$cipUser == "" ||
			is_null($cipUser)
		) {
			//return array("error" => true, "message" => "Debe registrar un CIP de Usuario Válido", "tipo" => "notificacion");
		}
		// Verificando si existe una incidencia asignada de un día.
		$queryIncidencia = 
			"SELECT id, cod_incidencia, TIMESTAMPDIFF(HOUR, fec_ini_inc, fec_fin_inc) AS tiempoIncidencia
				FROM cab_incidencia
    		WHERE TIMESTAMPDIFF(HOUR, fec_ini_inc, fec_fin_inc) = 24
    			AND dias > 0
    			AND modo = '$modo'";
    	if ($cipUser !="") {
    		$queryIncidencia.=" AND cip = '$cipUser' ";
    	}
    	if ($dniUser !="") {
    		$queryIncidencia.=" AND dni = '$dniUser' ";
    	}
    	$queryIncidencia.=" AND motivo_incidencia = '$motivo' AND DATE(fec_ini_inc) = DATE(fec_fin_inc) LIMIT 1";

    	$resultQuery = mysql_query($queryIncidencia);
    	while ($row = mysql_fetch_row($resultQuery)) {
    		return array("error" => true, "incidenciaId" => $row["id"], "message" => "La incidencia ".$row["cod_incidencia"]." Existe y reemplazará a las demás", "tipo" => "todoDia");
    	}
    	if ($modo == "D") {
    		return array("error" => false);
    	}
    	// Verificando si se traslapa horas de una nueva incidencia con otras
    	// Listamos todas las incidencias por horas que coinciden con el día de FechaInicio y FechaFin
    	$queryAllIncidenciasHoras = 
    		"SELECT id, cod_incidencia, fec_ini_inc, fec_fin_inc
    			FROM cab_incidencia
    		WHERE modo = '$modo'";

    	if ($cipUser !="") {
    		$queryAllIncidenciasHoras.=" AND cip = '$cipUser' ";
    	}
    	if ($dniUser !="") {
    		$queryAllIncidenciasHoras.=" AND dni = '$dniUser' ";
    	}
       
    	$queryAllIncidenciasHoras.=" AND motivo_incidencia = '$motivo'
    			AND fec_ini_inc >= '$fechaInicio' 
    			AND DATE(fec_ini_inc) = DATE('$fechaInicio')
    		ORDER BY fec_ini_inc ASC ";
    	//echo $queryAllIncidenciasHoras;
        
    	//exit;

    	$resultAll 	= mysql_query($queryAllIncidenciasHoras);
    	$incidencias = 
    		array(
    			0 => array(
    				"fec_ini_inc"	=>	$fechaInicio,
    				"fec_fin_inc"	=>	$fechaFin
    			)
    		);
    	$cantidad = 0;
    	while ($row = mysql_fetch_row($resultAll)) {
    		$incidencias[$row[0]] = 
    			array(
    				"fec_ini_inc"	=>	$row[2],
    				"fec_fin_inc"	=>	$row[3]
    			);
    		$cantidad++;
    	}
    	if ($cantidad <= 0) {
    		return array("error" => false);
    	}
    	$horaInicio = $horaFin = "";
		$explodeFechaInicio = explode(" ", $fechaInicio);
		$explodeFechaFin = explode(" ", $fechaFin);
		if (isset($explodeFechaInicio[1])) {
			$horaInicio = $explodeFechaInicio[1];
		}
		if (isset($explodeFechaFin[1])) {
			$horaFin = $explodeFechaFin[1];
		}

		$incidenciasOnlyHours = array();

		$i = 0;
		foreach ($incidencias as $key => $value) {
			$explodeFechaInicio = explode(" ", $value["fec_ini_inc"]);
			$explodeFechaFin = explode(" ", $value["fec_fin_inc"]);
			if (isset($explodeFechaInicio[1])) {
				$incidenciasOnlyHours[$i] = "$key|".$explodeFechaInicio[1]."|".$value["fec_ini_inc"];
			}
			$i++;
			if (isset($explodeFechaFin[1])) {
				$incidenciasOnlyHours[$i] = "$key|".$explodeFechaFin[1]."|".$value["fec_fin_inc"];
			}
			$i++;
			
		}
		$longitud = count($incidenciasOnlyHours);
		for($i = 0; $i < $longitud; $i++) {
			for($j = 0; $j < $longitud - 1; $j++) {
				$explode = explode("|", $incidenciasOnlyHours[$j]);
				$explodeTwo = explode("|", $incidenciasOnlyHours[$j+1]);
				if (isset($explode[1]) && isset($explodeTwo[1])) {
					$tmp = strtotime($explode[1]);
					$tmpTwo = strtotime($explodeTwo[1]);
					$tmpItem = $incidenciasOnlyHours[$j];
					$tmpTwoItem = $incidenciasOnlyHours[$j+1];
					if ($tmp > $tmpTwo) {
						$temporal = $incidenciasOnlyHours[$j+1];
						$incidenciasOnlyHours[$j] = $tmpTwoItem;
						$incidenciasOnlyHours[$j+1] = $tmpItem;
					}
				} 
			}
		}

		$incidenciasHorasOrdenadas = array();
		$incidenciasIdsArray = array();

		$rangosHoras = array();
		$longitud = count($incidenciasOnlyHours);
		for($i = 0; $i < $longitud - 1; $i++) {
			$explodeUno = explode("|", $incidenciasOnlyHours[$i]);
			$explodeDos = explode("|", $incidenciasOnlyHours[$i+1]);

			if (!isset($rangosHoras[$explodeUno[0]])) {
				$rangosHoras[$explodeUno[0]] = array();
			}
			if (!isset($rangosHoras[$explodeUno[0]][$explodeDos[0]])) {
				$rangosHoras[$explodeUno[0]][$explodeDos[0]] = array();
			}
			if ((int)$explodeUno[0] > 0) {
				$incidenciasIdsArray[$explodeUno[0]] = $explodeUno[0];
			}
			if ((int)$explodeDos[0] > 0) {
				$incidenciasIdsArray[$explodeDos[0]] = $explodeDos[0];
			}
			$rangosHoras[$explodeUno[0]][$explodeDos[0]][] = 
				array(
					"horaInicio" => $explodeUno[1],
					"horaFin"	=>	$explodeDos[1] 
				);
		}
		foreach($rangosHoras as $key => $value) {
			foreach($value as $key2 => $value2) {
				foreach($value2 as $key3 => $value3) {
					if ($value3["horaInicio"] == $value3["horaFin"]) {
						unset($rangosHoras[$key][$key2][$key3]);
					}
					if (isset($rangosHoras[$key][$key2]) && count($rangosHoras[$key][$key2]) <=0) {
						unset($rangosHoras[$key][$key2]);
					}
					if (isset($rangosHoras[$key]) && count($rangosHoras[$key]) <=0) {
						unset($rangosHoras[$key]);
					}
				}
			}
		}
		$horaInicioMenor = $horaFinMayor = $horaInicio;
		foreach($rangosHoras as $key => $value) {
			foreach($value as $key2 => $value2) {
				foreach($value2 as $key3 => $value3) {
					if (strtotime($value3["horaInicio"]) <= strtotime($horaInicioMenor)) {
						$horaInicioMenor = $value3["horaInicio"];
					}
					if (strtotime($value3["horaFin"]) >= strtotime($horaFinMayor)) {
						$horaFinMayor = $value3["horaFin"];
					}
				}
			}
		}
    	return array(
    		"error" => false,
    		"incidenciaId" => $incidenciasIdsArray,
    		"fechaInicio" => date("Y-m-d", strtotime($fechaInicio))." ".$horaInicioMenor,
    		"fechaFin"	=>	date("Y-m-d", strtotime($fechaInicio))." ".$horaFinMayor
    	);
	}
}