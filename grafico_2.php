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
        text: 'Monthly Average Temperature'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {		
			categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24','25', '26', '27', '28', '29', '30', '31'],	
		
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
    series: [{		
        name: '<? echo '156'; ?>',				
        data: [
		<? 		
			$lista="SELECT * FROM conteo_pedidos_user WHERE usu_reg=156";	
			//echo $lista;
			$res_lis = mysql_query($lista);
			while($reg_lis=mysql_fetch_row($res_lis)){				
		?>	
		<?php 
			
				if ($d == SUBSTR($reg_lis[1],8,2)){
					echo $reg_lis[2];
				}else{
					echo "0";
				}
		?>,
		<? } ?>	
		]
    }]
	
});
		</script>        
		
	</body>
</html>
