<?
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];


?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Highcharts Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>
<script src="js/Highcharts-6.0.4/code/highcharts.js"></script>
<script src="js/Highcharts-6.0.4/code/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Estadisticos de Pedidos Trabajados'
    },
    subtitle: {
        text: 'Criterio: Por Operador'
    },
    xAxis: {		
		<? 
		$lista="SELECT * FROM conteo_pedidos_user WHERE usu_reg=156";	
		//echo $lista;
		$res_lis = mysql_query($lista);
		while($reg_lis=mysql_fetch_row($res_lis)){	
		?>
        categories: [
		
		['<? echo $reg_lis[0]; ?>'];	
		
		<? } ?>	
		]
    },
    yAxis: {
        title: {
            text: 'Temperature (°C)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    /*series: [{
        name: 'Tokyo',
        data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    }, {
        name: 'London',
        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]*/
	
	<? 
	$lista="SELECT * FROM conteo_pedidos_user WHERE usu_reg=156";	
	//echo $lista;
	$res_lis = mysql_query($lista);
	while($reg_lis=mysql_fetch_row($res_lis)){	
	?>
		series: [{
        name: 'Usuarios',
        data: [
		['<? echo $reg_lis[1];?>'],		
    }]
		
	<? } ?>
});
		</script>
	</body>
</html>
