<?php
	require_once('conexion.php');
    if(isset($_REQUEST['i_registrar_refri']))
    {
		//echo $_POST["fec_ini_refri"];
		//echo "<BR>";
		//echo date("Y-m-d", strtotime($_POST["fec_ini_refri"]));
		if($_POST["s_t_refrigerio"] != NULL and $_POST["fec_fin_refri"] >= $_POST["fec_ini_refri"])
		{
			$t_refrigerio = $_POST["s_t_refrigerio"];
			$fec_ini_refrigerio = date("Y-m-d", strtotime($_POST["fec_ini_refri"]));
			$fec_fin_refrigerio = date("Y-m-d", strtotime($_POST["fec_fin_refri"]));
			$db=DB::conectar();
			$update_allr=$db->prepare('UPDATE MOVIMIENTOS_TIEMPOS SET STATUS="INACTIVO" WHERE TIPO="R"');
			$update_allr->execute();
		
			//Registramos en tabla de refrigerio
			$selectr=$db->prepare('SELECT COUNT(*) FROM TIEMPO_REFRIGERIO');
			$selectr->execute();
			if ($selectr->fetchColumn() == 0)
			{
				$insertr=$db->prepare('INSERT INTO TIEMPO_REFRIGERIO VALUES(:tiempo, :fec_ini, :fec_fin, :tipo)');
				$insertr->bindValue('tiempo',$t_refrigerio);
				$insertr->bindValue('fec_ini',$fec_ini_refrigerio);
				$insertr->bindValue('fec_fin',$fec_fin_refrigerio);
				$insertr->bindValue('tipo','R');
				$insertr->execute();
				$insertr->closeCursor();
			}
			else
			{
				$updater=$db->prepare('UPDATE TIEMPO_REFRIGERIO SET TIEMPO='.$t_refrigerio.', FEC_INI="'.$fec_ini_refrigerio.'", FEC_FIN="'.$fec_fin_refrigerio.'" WHERE TIPO="R"');
				$updater->execute();
			}

			//Registramos en movimientos
			$insertr=$db->prepare('INSERT INTO MOVIMIENTOS_TIEMPOS VALUES(:tipo, :tiempo, :fec_ini, :fec_fin, :status)');
			$insertr->bindValue('tipo','R');
			$insertr->bindValue('tiempo',$t_refrigerio);
			$insertr->bindValue('fec_ini',$fec_ini_refrigerio);
			$insertr->bindValue('fec_fin',$fec_fin_refrigerio);
			$insertr->bindValue('status','ACTIVO');
			$insertr->execute();
			$insertr->closeCursor();
?>
			<script>
				alert('Registro exitoso');
			</script>
<?php
		}
		else
		{
?>
			<script>
				alert('Error en Fecha');
			</script>
<?php			
		}
    }elseif(isset($_REQUEST['i_registrar_desc']))
    {
		if($_POST["s_t_descanso"] != NULL and $_POST["fec_fin_desc"] >= $_POST["fec_ini_desc"])
		{
			$t_descanso = $_POST["s_t_descanso"];
			$fec_ini_descanso = date("Y-m-d", strtotime($_POST["fec_ini_desc"]));
			$fec_fin_descanso = date("Y-m-d", strtotime($_POST["fec_fin_desc"]));
			$db=DB::conectar();
			$update_alld=$db->prepare('UPDATE MOVIMIENTOS_TIEMPOS SET STATUS="INACTIVO" WHERE TIPO="D"');
			$update_alld->execute();
			
			//Registramos en tabla de descanso
			$selectd=$db->prepare('SELECT COUNT(*) FROM TIEMPO_DESCANSO');
			$selectd->execute();
			if ($selectd->fetchColumn() == 0)
			{
				$insertd=$db->prepare('INSERT INTO TIEMPO_DESCANSO VALUES(:tiempo, :fec_ini, :fec_fin, :tipo)');
				$insertd->bindValue('tiempo',$t_descanso);
				$insertd->bindValue('fec_ini',$fec_ini_descanso);
				$insertd->bindValue('fec_fin',$fec_fin_descanso);
				$insertd->bindValue('tipo','D');
				$insertd->execute();
				$insertd->closeCursor();
			}
			else
			{
				$updated=$db->prepare('UPDATE TIEMPO_DESCANSO SET TIEMPO='.$t_descanso.', FEC_INI="'.$fec_ini_descanso.'", FEC_FIN="'.$fec_fin_descanso.'" WHERE TIPO="D"');
				$updated->execute();
			}

			//Registramos en movimientos			
			$insertd=$db->prepare('INSERT INTO MOVIMIENTOS_TIEMPOS VALUES(:tipo, :tiempo, :fec_ini, :fec_fin, :status)');
			$insertd->bindValue('tipo','D');
			$insertd->bindValue('tiempo',$t_descanso);
			$insertd->bindValue('fec_ini',$fec_ini_descanso);
			$insertd->bindValue('fec_fin',$fec_fin_descanso);
			$insertd->bindValue('status','ACTIVO');
			$insertd->execute();
?>
			<script>
				alert('Registro exitoso');
			</script>
<?php
		}
		else
		{
?>
			<script>
				alert('Error en Fecha Final');
			</script>
<?php			
		}
	}

	$db=DB::conectar();
	$selectR=$db->prepare('SELECT * FROM MOVIMIENTOS_TIEMPOS WHERE TIPO="R" ORDER BY STATUS ASC LIMIT 4');
	$selectR->execute();
	$arrDatosR=$selectR->fetchAll(PDO::FETCH_ASSOC);
	$selectR->closeCursor();
	
	$selectD=$db->prepare('SELECT * FROM MOVIMIENTOS_TIEMPOS WHERE TIPO="D" ORDER BY STATUS ASC LIMIT 4');
	$selectD->execute();
	$arrDatosD=$selectD->fetchAll(PDO::FETCH_ASSOC);
	$selectD->closeCursor();
	
	//<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Mantenimiento</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="estilos/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="estilos/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="estilos/jquery-ui.css" rel="stylesheet" type="text/css" />
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery-ui.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    
</head>
<body>
	<h4 class="cabeceras_grid" >Mantenimiento de Tiempos</h4>
	<form id="form_login" action="" method="post">
			<table width="80%" align="center">
					<tr>
						<td>
							<div class="col-md-auto">
								<label for="l_t_refrigerio">Tiempo Refrigerio (min):</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<select class="custom-select custom-select-sm" id='s_t_refrigerio' name='s_t_refrigerio' style='width: 100px;'>
									<option value='30'>30</option>
									<option value='45'>45</option>
									<option value='60'>60</option>
								</select>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<label for="fec_ini_refri">Fecha Inicio:</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input type="text" id="filter-date1" name="fec_ini_refri">
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<label for="fec_fin_refri">Fecha Fin:</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input type="text" id="filter-date2" name="fec_fin_refri">
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input class="btn btn-primary" type="submit" name="i_registrar_refri" value="Registrar">
							</div>
						</td>
					</tr>
	  </table>
		<br>
	<?php
	/*
		echo '<div class="table-responsive-sm">';
		echo '<table width="80%" class="table">';
			echo '<thead>';
				echo '<tr>';
					echo '<th scope="col" class="text-center">Tiempo (min)</th>';
					echo '<th scope="col" class="text-center">Fecha Inicio</th>';
					echo '<th scope="col" class="text-center">Fecha Fin</th>';
					echo '<th scope="col" class="text-center">Status</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach ($arrDatosR as $row)
			{
				echo '<tr>';
        		echo '<td class="text-center">' . $row['tiempo'] . '</td>';
				echo '<td class="text-center">' . date("d/m/Y", strtotime($row['fec_ini'])) . '</td>';
				echo '<td class="text-center">' . date("d/m/Y", strtotime($row['fec_fin'])) . '</td>';
				echo '<td class="text-center">' . $row['status'] . '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
		echo '</table>';
		echo '</div>';
	*/
	?>
		<br>
		<div class="table-responsive-sm">
			<table width="80%" align="center" class="table">
				<tbody>
					<tr>
						<td>
							<div class="col-md-auto">
								<label for="l_t_descanso">Tiempo Descanso por Hora (min):</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<select class="custom-select custom-select-sm" id='s_t_descanso' name='s_t_descanso' style='width: 100px;'>
									<option value='10'>10</option>
									<option value='15'>15</option>
								</select>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<label for="fec_ini_desc">Fecha Inicio:</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input type="text" id="filter-date3" name="fec_ini_desc">
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<label for="fec_fin_desc">Fecha Fin:</label>
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input type="text" id="filter-date4" name="fec_fin_desc">
							</div>
						</td>
						<td>
							<div class="col-md-auto">
								<input class="btn btn-primary" type="submit" name="i_registrar_desc" value="Registrar">
							</div>
						</td>
					</tr>
				</tbody>
		  </table>
		</div>
		<br>
	<?php
	/*
		echo '<div class="table-responsive-sm">';
		echo '<table class="table">';
			echo '<thead>';
				echo '<tr>';
					echo '<th scope="col" class="text-center">Tiempo (min)</th>';
					echo '<th scope="col" class="text-center">Fecha Inicio</th>';
					echo '<th scope="col" class="text-center">Fecha Fin</th>';
					echo '<th scope="col" class="text-center">Status</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			foreach ($arrDatosD as $row)
			{
				echo '<tr>';
        		echo '<td class="text-center">' . $row['tiempo'] . '</td>';
				echo '<td class="text-center">' . date("d/m/Y", strtotime($row['fec_ini'])) . '</td>';
				echo '<td class="text-center">' . date("d/m/Y", strtotime($row['fec_fin'])) . '</td>';
				echo '<td class="text-center">' . $row['status'] . '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
		echo '</table>';
		echo '</div>';
	*/
	?>
	</form>
<script type="text/javascript">
    $( "#filter-date1" ).datepicker({
		dateFormat: "dd-mm-yy",
		dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
		firstDay: 1,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre" ],
		showOn: "button",
		buttonImage: "image/calendar.png",
		buttonImageOnly: true,
		buttonText: "Seleccione Fecha"
	});
	
    $( "#filter-date2" ).datepicker({
		dateFormat: "dd-mm-yy",
		dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
		firstDay: 1,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre" ],
		showOn: "button",
		buttonImage: "image/calendar.png",
		buttonImageOnly: true,
		buttonText: "Seleccione Fecha"
	});

    $( "#filter-date3" ).datepicker({
		dateFormat: "dd-mm-yy",
		dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
		firstDay: 1,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre" ],
		showOn: "button",
		buttonImage: "image/calendar.png",
		buttonImageOnly: true,
		buttonText: "Seleccione Fecha"
	});
	
    $( "#filter-date4" ).datepicker({
		dateFormat: "dd-mm-yy",
		dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
		firstDay: 1,
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre" ],
		showOn: "button",
		buttonImage: "image/calendar.png",
		buttonImageOnly: true,
		buttonText: "Seleccione Fecha"
	});
</script>
</body>
</html>