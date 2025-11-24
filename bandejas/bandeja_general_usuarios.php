<?
include_once("../conexion_bd.php");
//validar_logeo($iduser);
//set_time_limit(0);					

$hoy=date("Y-m-d");
$cad="select * from tb_usuarios where estado='HABILITADO'";
//echo $cad;
$res =mysql_query($cad);		

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">

<link href="estillos_css.css" rel="stylesheet" type="text/css" />
<title>PANEL CONTROL USUARIOS</title>
</head>

<body>
<input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
<div class="tabcontent">  
<table width="90%" 
class="example table-autosort table-autofilter table-autopage:30 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
  
<thead>	
	        <tr class="txtlabel">
            <td colspan="12" align="center"><span id="t1filtercount"></span>&nbsp;de 
            <span id="t1allcount"></span>&nbsp;registro(s)</td>		
            </tr>
            <tr>		
              <!--<td class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>-->
              <td class="table-page:previous" style="cursor:pointer;">
              <img src="../image/anterior.jpg" alt="" width="30" height="30" ></td>
              
              <td style="text-align:center;" colspan="8">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>      
             
              <!--<td colspan="10" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>-->
              <td class="table-page:next" style="cursor:pointer;"><img src="../image/next.jpg" 
              width="30" height="30" ></td>	                         	
            </tr>    
    

  	<tr>
   			<?					
			
			
			echo "<th class='table-filterable'>SUPERVISOR</th>";
			
			echo "<th class='table-filterable'>IDUSER</th>";
			
			echo "<th class='table-filterable table-sortable:default sort01'>GESTOR</th>";			
			
			echo "<th class='filterable'>CIP";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable'>DNI";						
			echo "<input name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='table-filterable'>ESTADO</th>";
			
			echo "<th >...</th>";
					
			echo "<th class='table-sortable:default sort01'>CONECTADO</th>";
			
			echo "<th class='table-sortable:default sort01'>DESCONECTADO</th>";
			
			echo "<th class='table-sortable:default sort01'>TIEMPO</th>";
			
			echo "<th class='table-filterable'> N.INGRESOS</th>";
			?>	
  </tr>
</thead>
<tbody>
		<?
		$con=0;
		while($reg=mysql_fetch_row($res))
		{		
		echo "<tr class='alternate'>";			
		
		
		$s="select nom_supervisor from tb_supervisores where cod_supervisor='".$reg[23]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		
		$d="SELECT * FROM conexiones_web WHERE usu_mov='$reg[0]' and substr(fec_ini,1,10)='$hoy'  ORDER BY fec_ini DESC LIMIT 1";
		//echo "<p>".$d;
		$rs_d = mysql_query($d);											
		$rg_d = mysql_fetch_row($rs_d);


		$e="SELECT COUNT(*) FROM conexiones_web WHERE usu_mov='$reg[0]' 
		AND SUBSTR(fec_ini,1,10)='$hoy' ORDER BY fec_ini DESC";
		//echo "<p>".$e;
		$rs_e = mysql_query($e);											
		$rg_e = mysql_fetch_row($rs_e);		
		
						
		echo "<td>";		
		echo $rg_s[0]; 	//SUPERVISOR			
		echo "</td>";
		
		echo "<td>";		
		echo $reg[0]; 	//IDUSER			
		echo "</td>";
		
		echo "<td>";		
		echo $reg[1]; 	 //OPERADOR			
		echo "</td>";
		
		echo "<td>";		
		echo $reg[3]; 		 //DNI		
		echo "</td>";

		echo "<td>";		
		echo $reg[2]; 		//CIP		
		echo "</td>";
		
		echo "<td>";  // ESTADO
		if ($rg_d[10]==""){			
			echo "INACTIVO";			
		}else{
			echo $rg_d[10]; 			
		}
		echo "</td>";
		
		echo "<td>";
		if ($rg_d[10]==""){			
			echo "<img src='../image/semaforo_n.JPG' width='20' height='20' />";
		}else{
			if ($rg_d[10]=="CONECTADO"){			
					echo "<img src='../image/semaforo_v.JPG' width='20' height='20' />";
				}else{			
					echo "<img src='../image/semaforo_r.JPG' width='20' height='20' />";	
				}
		}
		echo "</td>";		
			

		echo "<td>";		
		if ($rg_d[7]==""){		
			echo "0000-00-00 00:00:00";
		}else{
			echo $rg_d[7]; 		
		}
		echo "</td>";
		
		echo "<td>";		
		if ($rg_d[8]==""){		
			echo "0000-00-00 00:00:00";
		}else{
			echo $rg_d[8]; 		
		}
		echo "</td>";
		
		echo "<td>";		
		if ($rg_d[9]==""){		
			echo "00:00:00";
		}else{
			echo $rg_d[9]; 		
		}		
		echo "</td>";
		
		echo "<td align='center'>";		
		echo $rg_e[0]; 		
		echo "</td>";
		
		echo "</tr>";		
		}		
	?>
</tbody>

</table>			
</div>
</body>
</html>
