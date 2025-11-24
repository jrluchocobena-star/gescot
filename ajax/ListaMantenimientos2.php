<?php
require_once '../conexion_bd.php';

$tipo_inc = $_POST['tipo_inc'];
$tipo = $_POST['tipo'];

switch ($tipo) {
    case 1:
        $ola = "SELECT
                    tmi.cod_mot_inc,
                    tmi.nom_mot_inc,
                    tmi.tp_inc
                  FROM tb_motivos_incidencia tmi
                  WHERE tmi.est = 1  AND tmi.tp_inc ='$tipo_inc' ORDER BY tmi.cod_mot_inc DESC";
        $campo = 'nom_mot_inc';
        break;
    case 2:

        $ola = "SELECT
                    tba.c_aplicativo,
                    tba.aplicativo
                  FROM tb_aplicativos tba
                  WHERE tba.estado = 1 ORDER BY tba.c_aplicativo DESC";
        $campo = 'aplicativo';
        break;

    case 3:
        $ola = "SELECT
                tos.ord,
                tos.Ola,
                tos.fec1,
                tos.fec2
              FROM tb_olas tos
              WHERE tos.est = '1'
              ORDER BY ord DESC";

        break;

    default:
        break;
}


//echo $hor;
$res_ola = mysql_query($ola) or die(mysql_error());

$i = 0;

if ($tipo == 3) {
    ?>
    <hr>
    <table border="1" id="TableB" class="table table-striped table-bordered table-hover " >
        <input type="hidden" name="tip" value="<?php echo $tipo ?>" >
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($reg_ola = mysql_fetch_row($res_ola)) {
                $i = $i + 1;
                ?>
                <tr>
                    <td><?php echo $reg_ola[0] ?></td>
                    <td style="text-align: left !important;" contenteditable="true" onBlur="Edicion(this, 'Ola', '<?php echo $reg_ola[0]; ?>')" onclick="showEdit(this);"><?php echo $reg_ola[1]; ?></td>
                    <td style="text-align: left !important;" contenteditable="true" onBlur="Edicion(this, 'fec1', '<?php echo $reg_ola[0]; ?>')" onclick="showEdit(this);"><?php echo $reg_ola[2]; ?></td>
                    <td style="text-align: left !important;" contenteditable="true" onBlur="Edicion(this, 'fec2', '<?php echo $reg_ola[0]; ?>')" onclick="showEdit(this);"><?php echo $reg_ola[3]; ?></td>
                    <td align="center"><a href="javaScript:void(0)" onclick="Eliminar(<?php echo $reg_ola[0] . "," . $tipo ?>)"><img src="./image/trash.png" ></a></td>
                </tr>
                <?php
            }
            ?>
    </table>

<?php } else {
    ?>
    <hr>
    <table border="1" id="TableB" class="table table-striped table-bordered table-hover">
        <input type="hidden" name="tip" value="<?php echo $tipo ?>" >
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Descripción</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($reg_ola = mysql_fetch_row($res_ola)) {
                $i = $i + 1;
                ?>
                <tr>
                    <td><?php echo $reg_ola[0] ?></td>
                    <td style="text-align: left !important;" contenteditable="true"
                        onBlur="Edicion(this, '<?php echo addslashes($campo); ?>', '<?php echo addslashes($reg_ola[0]); ?>', <?php echo is_null($tipo_inc) ? 'null' : "'" . addslashes($tipo_inc) . "'"; ?>)"
                        onclick="showEdit(this);">
                        <?php echo htmlspecialchars($reg_ola[1]); ?>
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)"
                            onclick="Eliminar('<?php echo $reg_ola[0]; ?>', '<?php echo $tipo; ?>', <?php echo is_null($tipo_inc) ? 'null' : "'" . $tipo_inc . "'"; ?>)">
                            <img src="./image/trash.png">
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
    </table>
<?php } ?>

<script type="text/javascript">

    $('#TableB').dataTable({
        "language": {
            "url": "./js/datatables/Spanish.json"
        },
        responsive: true,
        "ordering": false
    });

    function Eliminar(val, tipo, tipo_inc= null) {
        let text = "¿Desea Eliminar este Registro? \n Precione Aceptar o Cancelar.";
        if (confirm(text) == true) {
            $.ajax({
                url: "./ajax/DeleteMantenimientos2.php",
                type: "POST",
                data: {val: val, tipo: tipo, tipo_inc: tipo_inc},
                success: function (data) {
//                console.log(data);
                }
            });
        } else {
             console.log("Cancelado");
        }
    }

    function showEdit(editableObj) {
        $(editableObj).css("background", "#8fdbe4");
    }
    function Edicion(editableObj, colum, id, tipo_inc = null) {
        var tipo = $('input[name="tip"]').val();
        $(editableObj).css("background", "#FFF url(./image/load.png) no-repeat center");
//        $.ajax({
//            url: "./ajax/UpdateMantenimientos2.php",
//            type: "GET",
//            data: 'colum=' + colum + '&edival=' + editableObj.innerHTML + '&id=' + id,
//            success: function (data) {
//                $(editableObj).css("background", "#FDFDFD");
//                console.log(data);
//            }
//        });

        $.ajax({
            url: "./ajax/UpdateMantenimientos2.php",
            type: "GET",
//            data: {colum: colum, edival: editableObj, id: id, tipo: tipo},
            data: 'colum=' + colum + '&edival=' + editableObj.innerHTML + '&id=' + id + '&tipo=' + tipo + '&tipo_inc=' + tipo_inc,
            success: function (data) {
                $(editableObj).css("background", "#FDFDFD");
//                console.log(data);
            }
        });

    }

</script>

