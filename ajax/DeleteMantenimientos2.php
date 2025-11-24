<?php

require_once '../conexion_bd.php';

$val = $_POST['val'];
$tipo = $_POST['tipo'];
$tipo_inc=$_POST['tipo_inc'];
try {


    switch ($tipo) {
        case 1:

            $sql_1_1 = "UPDATE tb_motivos_incidencia tmi
                        SET tmi.est = 0
                        WHERE tmi.cod_mot_inc = $val AND tmi.tp_inc = '".$tipo_inc."'";
                          var_dump($sql_1_1);
            break;

        case 2:
            $sql_1_1 = "UPDATE tb_aplicativos tba
                        SET tba.estado = 0
                        WHERE tba.c_aplicativo = $val;";
            break;
        case 3:
            $sql_1_1 = "UPDATE tb_olas tbo
                        SET tbo.est = 0
                        WHERE tbo.ord = $val;";
            break;

        default:
            break;
    }


    $res_sql2 = mysql_query($sql_1_1) or die(mysql_error());
} catch (Exception $exc) {
    echo $exc->getMessage();
}
