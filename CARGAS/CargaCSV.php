<script language="javascript" src="../funciones_js.js"></script>
<link href="../estilos.css" rel="stylesheet" type="text/css">

<?php 

// conexión
$mysqli = @new mysqli('localhost','root','','gescot');

$sw = 0;

if (isset($_POST['enviar'])){
  $sw = 1;
  $filename=$_FILES["file"]["name"];
  $info = new SplFileInfo($filename);
  $extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
  $q1= "DELETE FROM horario_cot_mes";
  $mysqli->query($q1);

   if($extension == 'csv'){
	$filename = $_FILES['file']['tmp_name'];
	$handle = fopen($filename, "r");
// $indiceNumeros = 0;
	while( ($data = fgetcsv($handle, 1000, ";") ) !== FALSE ){
	   $q = "INSERT INTO horario_cot_mes (Mes, CIP, NCOMPLETO, FECHA_INICIO, COD_HORARIO, FECHA_FIN) VALUES (
		'$data[0]', 
		'$data[1]',
		'$data[2]',
		'$data[3]',
		'$data[4]',
		'$data[5]'
	   )";
        //echo $q."<br>";
        
	$mysqli->query($q);
   
        
   }
      $sw = 2;
      fclose($handle);
   }
    
       
}

if($sw==1){
    
        $paso_1="INSERT INTO horario_cot_mes(
            Mes,cip,ncompleto,FECHA_INICIO, COD_HORARIO,FECHA_FIN, DETALLE_HORARIO,
            AREA, LIDER_DIRECTO, COMENTARIO, DNI, MAESTRA, EST, F_CARGA
        )

        SELECT 
            SUBSTR(CURDATE(),1,7),
            cip,
            ncompleto,
            '',
            c_horario,
            '',
            d_horario,
            '',
            '',
            '',
            dni,
            '',
            '',
            NOW()
        FROM horarios_manuales
        WHERE enc = ''
        GROUP BY dni";

        $mysqli->query($paso_1);
      


        $paso_2="DELETE FROM HORARIO_COT_MES WHERE ncompleto = ''";
        $mysqli->query($paso_2);


        $paso_3="UPDATE horario_cot_mes SET cip = LPAD(TRIM(cip), 9,'0') WHERE LENGTH(cip)<10";
        $mysqli->query($paso_3);

        $paso_4="UPDATE horario_cot_mes SET mes= SUBSTR(CURDATE(),1,7), F_CARGA=NOW()";
        $mysqli->query($paso_4);

        $paso_5="UPDATE horario_cot_mes
        SET COD_HORARIO = CONCAT('0', COD_HORARIO)
        WHERE LENGTH(COD_HORARIO) = 3";
        $mysqli->query($paso_5);

        $paso_6="UPDATE horario_cot_mes
        SET COD_HORARIO = CONCAT('00', COD_HORARIO)
        WHERE LENGTH(COD_HORARIO) = 2";
        $mysqli->query($paso_6);

        $paso_7="UPDATE horario_cot_mes a, tb_usuarios b
        SET a.dni = b.dni
        WHERE a.cip = b.cip";
        $mysqli->query($paso_7);

        $paso_8="UPDATE horario_cot_mes
        SET FECHA_INICIO = CONCAT('0', FECHA_INICIO)
        WHERE LENGTH(FECHA_INICIO) = 9";
        $mysqli->query($paso_8);

        $paso_9="UPDATE horario_cot_mes
        SET FECHA_FIN = CONCAT('0', FECHA_FIN)
        WHERE LENGTH(FECHA_FIN) = 9";
        $mysqli->query($paso_9);

        $paso_10="UPDATE horario_cot_mes
        SET n_fecha_inicio = CONCAT(SUBSTR(FECHA_INICIO, 7, 4), '-', SUBSTR(FECHA_INICIO, 4, 2), '-', SUBSTR(FECHA_INICIO, 1, 2)),
            n_fecha_fin = CONCAT(SUBSTR(FECHA_FIN, 7, 4), '-', SUBSTR(FECHA_FIN, 4, 2), '-', SUBSTR(FECHA_FIN, 1, 2))";
        $mysqli->query($paso_10);

        $paso_11="UPDATE horario_cot_mes
        SET ncompleto = TRIM(ncompleto)";
        $mysqli->query($paso_11);

        $paso_12="TRUNCATE TABLE horarios_gestores_cot";
        $mysqli->query($paso_12);

        $paso_13="INSERT INTO horarios_gestores_cot

          SELECT
            dni,
            cip,
            ncompleto,
            c_supervisor,
            sgrupo,
            '',
            '',
            '',
            '',
            '',
            '',
            ''
          FROM tb_usuarios
          WHERE estado = 'HABILITADO'";
        $mysqli->query($paso_13);

        $paso_14="UPDATE horarios_gestores_cot
        SET Cargo = '-'
        WHERE Cargo IS NULL";
        $mysqli->query($paso_14);

        $paso_14a="UPDATE horarios_gestores_cot SET cip = LPAD(TRIM(cip), 9,'0') WHERE LENGTH(cip)<10";
        $mysqli->query($paso_14a);

        $paso_15="UPDATE horarios_gestores_cot a, tb_usuarios b
        SET a.SUPERVISOR = b.c_supervisor
        WHERE a.dni = b.dni";
        $mysqli->query($paso_15);

        $paso_16="UPDATE horarios_gestores_cot a, tb_usuarios b
        SET a.supervisor = b.ncompleto
        WHERE a.supervisor = b.iduser";
        $mysqli->query($paso_16);

        $paso_17="UPDATE horarios_gestores_cot a, horario_cot_mes b
        SET a.COD_HORARIO = b.COD_HORARIO
        WHERE a.cip = b.cip";
        $mysqli->query($paso_17);

        $paso_18="UPDATE horarios_gestores_cot a, horarios_personal_apoyo b
        SET a.COD_HORARIO = b.COD_HORARIO
        WHERE a.dni = b.dni
        AND a.COD_HORARIO = ''";
        $mysqli->query($paso_18);

        $paso_19="UPDATE horarios_gestores_cot a, horarios_cot b
        SET a.COD_HORARIO = b.COD_HORARIO
        WHERE a.dni = b.dni
        AND a.COD_HORARIO = ''
        AND b.est = '1'";
        $mysqli->query($paso_19);

        $paso_20="UPDATE horarios_gestores_cot a, horarios_rrhh b
        SET a.desc_horario = b.descripcion_1,
            a.dias_horario = b.descripcion_2,
            a.hor_ini = b.F1,
            a.hor_fin = b.F2
        WHERE a.COD_HORARIO = b.COD_HORARIO";
        $mysqli->query($paso_20);

        $paso_21="UPDATE horarios_gestores_cot
        SET dias_horario = TRIM(SUBSTRING_INDEX (TRIM(SUBSTRING_INDEX (desc_horario, '[', 1)), '-', -2)),
            f_carga = NOW()";
        $mysqli->query($paso_21);

        $paso_22="UPDATE horarios_gestores_cot a, cab_incidencia b
        SET a.vacaciones = 'SI'
        WHERE a.dni = b.dni
        AND b.motivo_incidencia = '50'
        AND CURDATE() BETWEEN SUBSTR(b.fec_ini_inc, 1, 10)
        AND SUBSTR(b.fec_fin_inc, 1, 10)";
        $mysqli->query($paso_22);


        $paso_23="UPDATE horarios_gestores_cot
        SET COD_HORARIO = 'S/H',
            desc_horario = 'SIN HORARIO ASIGNADO',
            dias_horario = 'SIN HORARIO ASIGNADO',
            hor_ini = '00:00',
            hor_fin = '00:00'
        WHERE COD_HORARIO = ''";
        $mysqli->query($paso_23);

        $paso_24="UPDATE horarios_gestores_cot a, tb_usuarios b
        SET a.ncompleto = b.ncompleto
        WHERE a.dni = b.dni
        AND a.ncompleto = ' , '";
        $mysqli->query($paso_24);

        $paso_25="UPDATE horarios_gestores_cot a, horario_cot_mes b
        SET a.COD_HORARIO = b.COD_HORARIO
        WHERE a.dni = b.dni
        AND a.COD_HORARIO = 'S/H'";
        $mysqli->query($paso_25);

        $paso_26="UPDATE horarios_gestores_cot a, horarios_rrhh b
        SET a.desc_horario = b.descripcion_1,
            a.dias_horario = b.descripcion_2,
            a.hor_ini = b.F1,
            a.hor_fin = b.F2
        WHERE a.COD_HORARIO = b.COD_HORARIO";
        $mysqli->query($paso_26);
}


?>

<!DOCTYPE html>
<html lang="en">    
<head>    
   <meta charset="UTF-8">    
   <title>Importación</title>
</head>
<body>

<br>
<div class="cabeceras_grid">
 Este proceso de carga de horarios, se debe de considerar lo siguiente:
 <br>
 1.- Tener el archivo de horarios actualizado.
 <br> 
 2.- Este proceso cuenta con procesos internos, y ya no es necesario ejecutar los querys.
 <br>
 3.- Los cambios de horarios puntuales, se realizan en el modulo de incidencias, en la bandeja de horarios.
</div>
    
<br>
<form enctype="multipart/form-data" method="post" action="" class="cabeceras_grid">
   CSV File:<input type="file" name="file" id="file">
   <input type="submit" value="Enviar" name="enviar">   
</form>

<p>

<table width="400" border="0">
  
    <tr>
      <td width="179" class="cabeceras_grid">Informacion de Carga</td>
      <td width="87" class="caja_texto_pe" align="center"><a href="javascript:mostrar_msn_carga('1')" >Ver</a></td>
      <td width="120">&nbsp;</td>
  </tr>
</table>

    <div id="div_msn_carga" style="display: block">   
    </div>
    
  <br>
        <iframe id="f_bandejahorarioscot"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" src="../bandejas/bandeja_general_horarios_cot.php"
                                width="100%"  scrolling="Auto"  height="1000" > </iframe>
   
</body>
</html>