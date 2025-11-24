<?php

require_once '../conexion_bd.php';

$colum = $_GET['colum'];
$edit = $_GET['edival'];
$id = $_GET['id'];
$tipo = $_GET['tipo'];
$tipo_inc= $_GET['tipo_inc'];
try {

    switch ($tipo) {
        case '1':
            $sql_1 = "UPDATE tb_motivos_incidencia tmi
            SET $colum = UPPER('$edit')
            WHERE tmi.cod_mot_inc = $id AND tmi.tp_inc = '".$tipo_inc."'";

            break;

        case '2':

            $sql_1 = "UPDATE tb_aplicativos tba
            SET tba.$colum = UPPER('$edit')
            WHERE tba.c_aplicativo = $id;";
            break;

        case '3':

            $sql_1 = "UPDATE tb_olas tbo
            SET tbo.$colum = UPPER('$edit')
            WHERE tbo.ord = $id";
            break;

        default:
            break;
    }

//echo $sql;
    $res_sql1 = mysql_query($sql_1);
} catch (Exception $exc) {
    echo $exc->getMessage();
}
