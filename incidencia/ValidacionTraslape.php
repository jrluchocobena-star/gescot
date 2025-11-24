<?php

class ValidacionTraslape {
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


		$queryUsuario = "SELECT tb_usuarios.ncompleto, tb_usuarios.dni FROM tb_usuarios WHERE dni = '$dniUser'";
		$resultUsuario = mysql_query($queryUsuario);
		$rowUsuario = mysql_fetch_assoc($resultUsuario);

		$datetime1 = new DateTime($fechaInicio);
		$datetime2 = new DateTime($fechaFin);
		$interval = $datetime1->diff($datetime2);
		$dias = $interval->format('%d') + 1;


		$queryHorarioGestor = "SELECT horarios_gestores_cot.cod_horario, hor_ini, hor_fin,F1,F2 from horarios_gestores_cot
		INNER JOIN horarios_rrhh ON horarios_gestores_cot.cod_horario = horarios_rrhh.cod_horario
		where horarios_gestores_cot.dni='$dniUser' LIMIT 1";
		$resultHorarioGestor = mysql_query($queryHorarioGestor);
		$rowHorarioGestor = mysql_fetch_assoc($resultHorarioGestor);

		$data = array();

		for ($i=0; $i < $dias; $i++) { 
			if($modo == 'D'){
				$fecha_inicio_modificado = date("Y-m-d H:i:s", strtotime($fechaInicio." ".$rowHorarioGestor['hor_ini']. " + ".$i." day"));
				$fecha_fin_modificado = date("Y-m-d H:i:s", strtotime($fechaInicio." ".$rowHorarioGestor['hor_fin']. " + ".$i." day"));
			}else{
				
				$fecha_inicio_modificado = date("Y-m-d H:i:s", strtotime($fechaInicio. " + ".$i." day"));
				$fecha_inicio_explode = explode(' ',$fechaInicio);
				$fecha_fin_explode = explode(' ',$fechaFin);
				$fecha_fin = $fecha_inicio_explode[0];
				$hora_fin = $fecha_fin_explode[1];
				$fecha_fin_modificado = date("Y-m-d H:i:s", strtotime($fecha_fin." " .$hora_fin." + ".$i." day"));
			}

			// Verificando si existe una incidencia asignada de un día.
			$queryIncidencia = "SELECT * FROM cab_incidencia 
				WHERE cip = '$cipUser' AND dni = '$dniUser' and estado_inc<>'3'
				AND (
					(
						fec_ini_inc between '$fecha_inicio_modificado' AND '$fecha_fin_modificado' 
						OR fec_fin_inc between '$fecha_inicio_modificado' AND '$fecha_fin_modificado'
					)
					OR (
						fec_ini_inc = '$fecha_inicio_modificado' AND fec_fin_inc = '$fecha_fin_modificado'
						)
					OR(
						fec_ini_inc <= '$fecha_inicio_modificado' AND fec_fin_inc >= '$fecha_fin_modificado'
					)
					OR(
						fec_fin_inc >= '$fecha_inicio_modificado' AND fec_fin_inc <= '$fecha_fin_modificado'
					)
				)";
			
			$result = mysql_query($queryIncidencia);
			$num_rows = mysql_num_rows($result);
	
			$data_result = array();
			if($num_rows > 0){
				$row = mysql_fetch_assoc($result);
				$data_result['error'] = true;
				$data_result['incidencia'] = $rowUsuario['ncompleto'] . ' tiene un traslape con la incidencia ' . $row['cod_incidencia'] . ' en la fecha y hora '. $row['fec_ini_inc'] . ' | '.$row['fec_fin_inc'];
				array_push($data, $data_result);
			}

		}

		return $data;
	}
}