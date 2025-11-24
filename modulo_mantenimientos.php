<?php
include("conexion_bd.php");

$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"> </link>
        <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css" rel="stylesheet"> </link>
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
      
        <link href="estilos.css" rel="stylesheet" type="text/css" />
        <script language="javascript" src="funciones_js.js"></script>
    </head>

    <body>
        <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
        <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
        <br>
            <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" >
                <tr>
                    <td width="20%" align="center" class="cabeceras_grid_color" onclick="javascript:mostrar_modulos_mant('1')">MOTIVOS GESCOT </td>
                    <td width="20%" align="center" class="cabeceras_grid_color" onclick="javascript:mostrar_modulos_mant('3')">APLICATIVOS PARA MAESTRA</td>
                    <td width="20%" align="center" class="cabeceras_grid_color" onclick="javascript:mostrar_modulos_mant('4')">HISTORICO DE CLAVES</td>
                    <!--<td width="17%" align="center" class="cabeceras_grid" onclick="javascript:mostrar_modulos_mant('2')">OLAS</td>-->

                    <td width="54%">&nbsp;</td>
                </tr>
            </table>
            <p>

                <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td>
                            <div id="mod_mant_motivoincidencias" style="display:block">
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="3" class="boton_3">MANTENIMIENTO DE MOTIVOS DE INCIDENCIAS</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="11%" class="TitTablaI">TIPO</td>
                                        <td width="40%"><select name="tipo_inc" id="tipo_inc" class="caja_texto_pe" >
                                                <?php
                                                print "<option value='0' selected>Seleccione...</option>";
                                                $sql1 = "SELECT tp_inc FROM tb_motivos_incidencia GROUP BY tp_inc";
                                                $queryresult1 = mysql_query($sql1) or die(mysql_error());
                                                while ($rowper1 = mysql_fetch_row($queryresult1)) {
                                                    print "<option value='$rowper1[0]'>$rowper1[0]</option>";
                                                }
                                                ?>
                                            </select></td>
                                        <td width="49%" ><a class="boton_c" href="javascript:grabar_motivos_inc();"> 
                                                <img src="image/adjuntar.jpg" width="20" height="20" />Grabar</a></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="TitTablaI">MOTIVO</td>
                                        <td><input name="motivo_inc" type="text" class="caja_texto_pe" id="motivo_inc" size="70" 
                                                   onkeypress="return soloLetras(event)" onkeyup="javascript:this.value = this.value.toUpperCase();" /></td>
                                        <td ><a class="boton_c ListaMant2" id="1" href="javaScript:void(0)" ><img src="image/bookmark_add.png" width="20" height="20" />Listar</a></td>
                                    </tr>
                                </table>

                                <div class="container-fluid">
                                    <div class="table-responsive" id="ChangeListaMnt2">
                                    </div>
                                </div>
                            </div>


                            <div id="mod_mant_aplicativos" style="display:none">
                                <table width="80%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="3" class="boton_3">MANTENIMIENTO DE APLICATIVOS</td>
                                    </tr>
                                    <tr>
                                        <td class="TitTablaI">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="11%" class="TitTablaI">APLICATIVO</td>
                                        <td width="45%"><input name="aplicativo" type="text" class="caja_texto_pe" id="aplicativo" 
                                                               size="70" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value = this.value.toUpperCase();"  /></td>
                                        <td>
                                            <a class="caja_texto_pe" onclick="javascript:grabar_aplicativo()"><img src="image/adjuntar.jpg" width="20" height="20" />Grabar</a>
                                            <a class="caja_texto_pe ListaMant2" href="javaScript:void(0)" id="2"> 
                                                Listar</a>
                                        </td>
<!--                                        <td> <a class="caja_texto_pe ListaMant2"  id="2"> 
                                                Listar</a></td>-->

                                    </tr>
<!--                                    <tr>
                                        <td width="" colspan="2"><a class="caja_texto_pe ListaMant2" href="javaScript:void(0)" > 
                                                Listar</a></td>
                                    </tr>-->
                                    <tr>

                                        <td class="TitTablaI">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="aviso"><div id="msn_registro"></div></td>
                                    </tr>
                                </table>

                                <div class="container-fluid">
                                    <div class="table-responsive" id="ChangeListaMnt22">
                                    </div>
                                </div>
                            </div>


                            <div id="mod_mant_olas" style="display:none">
                                <br>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td colspan="3" class="enc_grid">MANTENIMIENTO DE OLAS-COT</td>
                                        </tr>
                                        <tr> 
                                            <td width="84%" valign="top">
                                                <table width="60%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
                                                    <tr>
                                                        <td width="23%">NOMBRE DE OLA </td> 
                                                        <td width="77%"><input name="olas" type="text" class="caja_texto_pe" id="olas" size="60" />
                                                            <a class="caja_texto_pe" onclick="javascript:grabar_olas();"> <img src="image/liquidar.jpg" width="25" height="25" />GRABAR</a>
                                                            <a class="caja_texto_pe ListaMant2" href="javaScript:void(0)" id="3"> Listar</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>FECHA INICIO </td>
                                                        <td><input name="fec_ini" type="text" class="caja_texto_pe" id="fec_ini" VALUE="<?php echo date("Y-m-d"); ?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>FECHA FIN </td>
                                                        <td><input name="fec_fin" type="text" class="caja_texto_pe" id="fec_fin" value="2050-12-31" readonly /> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="16%" valign="top">
                                                <div id="lista_olas" style="display:block">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="container-fluid">
                                        <div class="table-responsive" id="ChangeListaMnt23">
                                        </div>
                                    </div>

                            </div>
                        </td>
                    </tr>
                </table>
                <script type="text/javascript">

                    $('.ListaMant2').click(function () {

                        var ida = $(this).attr("id");
                        var carga;
                        var tipo_inc = $('select[name="tipo_inc"]');

                        switch (ida) {
                            case '1':

                                if (tipo_inc.val() == '0') {
                                    alert("Porfavor Escoja un Tipo");
                                    tipo_inc.focus();
                                    return false;
                                }
                                carga = $('#ChangeListaMnt2');
                                $('#ChangeListaMnt22').empty();
                                $('#ChangeListaMnt23').empty();
                                break;

                            case '2' :

                                carga = $('#ChangeListaMnt22');
                                $('#ChangeListaMnt2').empty();
                                $('#ChangeListaMnt23').empty();
                                break;
                            case '3' :

                                carga = $('#ChangeListaMnt23');
                                $('#ChangeListaMnt2').empty();
                                $('#ChangeListaMnt22').empty();
                                break;

                            default:

                                break;
                        }
                        $.ajax({
                            url: "./ajax/ListaMantenimientos2.php",
                            type: "POST",
                            data: {tipo_inc: tipo_inc.val(), tipo: ida},
                            success: function (data) {
                                carga.html(data);
                            }
                        });

                    });
                </script>
        
<div id="div_cambiodeclaves" style="display:none">
<iframe id="bandeja_cambioclaves"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" width="100%"  scrolling="Auto"  height="1000" > </iframe>
</div> 
        
                </body>
                </html>