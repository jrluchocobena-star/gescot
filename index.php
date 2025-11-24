<?php
include ("conexion_bd.php");
error_reporting(0);
$pc = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$pc = explode(".", $pc);
$pc = $pc[0]; // porción1





$idsess = trim($_GET["idsess"]);
$iduser = $_GET["iduser"];
$s_area = $_GET["s_area"];
$idperfil = $_GET["idperfil"];
$grupo = $_GET["grupo"];

//session_start();

$sql_usu = "select * from tb_usuarios where iduser='$iduser'";
//echo $sql_usu;
$res_USU = mysql_query($sql_usu);
$usu = mysql_fetch_array($res_USU);

//echo $idperfil;
//echo "<a class='texto_sb'>index.php</a>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>@-GESCOT</title>
        <link href="estilos.css" rel="stylesheet" type="text/css" />
        <script src="./js/jquery-3.5.1.min.js"></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

        <script type="text/javascript" src="funciones_js.js?v=1804"></script>
        <script >
            function mueveReloj() {


                momentoActual = new Date()
                hora = momentoActual.getHours()
                minuto = momentoActual.getMinutes()
                segundo = momentoActual.getSeconds()

                horaImprimible = hora + " : " + minuto + " : " + segundo

                document.form_reloj.reloj.value = horaImprimible

                if (document.form_reloj.reloj.value == "19 : 0 : 0") {
                    var idsess = document.getElementById("idsess").value;
                    var iduser = document.getElementById("iduser").value;
                    //alert("entro")						
                    salir(idsess, iduser)
                }
                /*
                 if (minuto == 20){
                 var idsess = document.getElementById("idsess").value;
                 var iduser = document.getElementById("iduser").value;
                 //alert("entro")						
                 salir(idsess,iduser)
                 
                 }
                 */
                setTimeout("mueveReloj()", 1000)

            }

        </script>

    </head>

    <body onload="mueveReloj()" style="margin: 0.5px;">
        <? ?>

        <table width="100%" height="243" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="80" colspan="2" valign="top" bgcolor="#165365">
                    <img src="image/logo telefonica.jpg" alt="" width="728" height="83" /><span id="liveclock" style="position:absolute;left:0;top:0;"></span>

                    <input name="idperfil" type="hidden" id="idperfil" value="<?php echo $idperfil; ?>" size="30" />   
                    <input name="idsess" type="hidden" id="idsess" value="<?php echo $idsess; ?>" size="30" />  
                    <input name="grupo" type="hidden" id="grupo" value="<?php echo $grupo; ?>" size="30" />      
            </tr>

            <tr>
                <td align="right" valign="top" class="caja_sb" colspan="2">    
                    <table>
                        <tr>
                            <td align="right" valign="top" class="caja_sb">        
                                PC:  <input id="pc" name="pc" type="text"  size="10" class="caja_sb" value="<?php echo $pc; ?>"> 
                            </td>
                            <td align="right" valign="top" class="caja_sb">
                                ID:   
                                <input name="iduser" type="text" id="iduser" class="caja_sb" value="<?php echo $iduser; ?>" size="10" />   
                            </td>
                            <td align="right" valign="top" class="caja_sb">
                                <form name="form_reloj"> 
                                    Hora:  <input name="reloj" type="text"  size="10" class="caja_sb"> 
                                </form> 
                            </td>

                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td height="24" colspan="2" align="right" valign="top">

                    <?php if ($grupo == "COT-TDP") { ?>  


                        <?php if ($idperfil == 0) {  // PERFIL ADMINISTRADOR?>
                            <table width="30%" border="0">           	
                                <tr align="center">  
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" title="INICIO" width="70" height="70" /></td>      
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('23');"><img src="image/importar_dni.jpg" title="CARGA DNI" width="70" height="70" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('22');"><img src="image/importar.png" title="CARGA HORARIOS" width="70" height="70" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" title="CONTACTOS" width="70" height="70" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('6')" ><img src="image/TECNICO.jpg" title="TECNICOS" width="80" height="70" /></td>    
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('15');"><img src="image/liquidar.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('2');"><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('3');" ><img src="image/panel.jpg" title="REPORTERIA" width="70" height="70" /></td>        
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td>     
                                            <!--<td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/anula1.jpg" width="70" height="70" title="USUARIOS BETA" /></td> -->      
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" title="INCIDENCIAS" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('12')" ><img src="image/CAPA.jpg" alt="" width="70" height="70" title="CAPACITACION" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('8')" ><img src="image/PC.jpg" alt="" width="80" height="70" title="MONITOR" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('13')" ><img src="image/icon1.png" alt="" width="80" height="70" title="" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('11')" ><img src="image/04-07-2017 04-46-52 p.m..jpg" alt="" width="80" height="70" title="" /></td>
                                    <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                    <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->                     
                                    <!-- 
                                    <td colspan="50" onclick="" ><img src= "image/gees.jpg" alt="" width="70" height="70" /></td> 
                                    -->
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('19')" ><img src="image/04-07-2017 04-47-10 p.m..jpg" title="MANTENIMIENTOS" width="70" height="70" /></td>  
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('20')"><img src="image/CASA.jpg" title="Detalle de Usuarios" width="70" 
                                                                                                              height="70" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')"><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                              height="70" /></td>
                                    <td width="70"><img src="image/SAL.jpg" alt="" width="70" height="70" 
                                                        onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');" /></td>
                                </tr>
                            </table>
                        <?php } ?>    

                        <?php if ($idperfil == 1) {  //OPERADOR ASIGNACIONES  ?>
                            <table width="20%" border="0">
                                <tr>
                                    <td width="94" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>      
                                    <!--<td width="70" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> --> 
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" title="INCIDENCIAS" /></td>
                                    <td width="109" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                                height="70" /></td> 
                                                                                                               <!-- <td width="73" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" alt="" width="70" height="70" class="imagen_link" /></td>
                                                                                                                       <td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                                                                                       <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->      
                                    <td width="91" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>  
                            </table>            
                        <?php } ?>  

                        <?php if ($idperfil == 2) {  // JEFE ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">      
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>        
                                   <!-- <td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>--> 
                                    <!--
                            <td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>  
                            <td colspan="50" onclick="javascript:menu('6')" ><img src="image/TECNICO.jpg" title="TECNICOS" width="80" height="70" /></td>                -->
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src= image/usu.jpg width="70" height="70" /></td>  
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('3');" ><img src="image/panel.jpg" title="PANEL CONTROL" width="70" height="70" /></td>    
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td> 
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('20')" ><img src="image/CASA.jpg" title="Detalle de Usuarios" width="70" 
                                                                                                               height="70" /></td>  
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td> 
                                                                                                                       <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                                                                                       <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->      
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');" /></td>
                                </tr>
                            </table>
                        <?php } ?>     

                        <?php if ($idperfil == 3) {  // SUPERVISOR ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">       
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>       
                                    <!--<td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>-->
                                    <!--<td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td> 
                                    <td colspan="50" onclick="javascript:menu('3');" ><img src="image/panel.jpg" title="PANEL CONTROL" width="70" height="70" /></td>-->                          
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>          
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td>   
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('8')" >
                                        <img src="image/PC.jpg" alt="" width="80" height="70" title="MONITOR" /></td>  
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('20')" ><img src="image/CASA.jpg" title="Detalle de Usuarios" width="70" 
                                                                                                               height="70" /></td>   
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td>    
                                                                                                                        <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->           
                                                                                                                               <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>
                            </table>
                        <?php } ?>    

                        <?php if ($idperfil == "4") {  // analista ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">       
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>       
                                    <!--<td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> -->
                                        <!--<td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>	 -->          			
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td>  
                                    <? if ($iduser=="155"){?>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('13')" ><img src="image/icon1.png" alt="" width="80" height="70" title="" /></td> 
                                    <? } ?>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('8')" >
                                        <img src="image/PC.jpg" alt="" width="80" height="70" title="MONITOR" /></td>  
        <!--                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('19')" ><img src="image/04-07-2017 04-47-10 p.m..jpg" title="MANTENIMIENTOS" width="80" 
                                                                                                               height="70" /></td>               -->
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('20')" ><img src="image/CASA.jpg" title="Detalle de Usuarios" width="70" 
                                                                                                               height="70" /></td>
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td>

                                                <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> 
                                                           <td colspan="50" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>-->
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>
                            </table>
                        <?php } ?>     

                        <?php if ($idperfil == 5) {  // monitor ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">       
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>       
                                    <!--<td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> -->               
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td> 
                                    <!--<td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>    
                                    <td colspan="50" onclick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>  -->
                                   <!-- <td colspan="50" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>   -->      
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('12')" ><img src="image/CAPA.jpg" alt="" width="70" height="70" title="CAPACITACION" /></td>
                                    <!--<td width="50" class="caja_texto_pe" onclick="javascript:menu('19')" ><img src="image/04-07-2017 04-47-10 p.m..jpg" title="MANTENIMIENTOS" width="70" height="70" /></td>-->  
                                    <td colspan="50" onclick="javascript:menu('8')" ><img src="image/PC.jpg" alt="" width="80" height="70" title="PANEL CONTROL" /></td> 
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td>
                                                                                                                      <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                                                                                       <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->    
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');" /></td>
                                </tr>
                            </table>
                        <?php } ?>  

                        <?php if ($idperfil == "6") {  // soporte ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">       
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td> 
                                    <!--<td width="50" class="caja_texto_pe"  onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> 
                                        <!--<td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>	 -->          			
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td>  
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>     
                           <!--<td colspan="50" onclick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>-->
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('3');" ><img src="image/panel.jpg" title="REPORTERIA" width="70" height="70" /></td>   
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('8')" >
                                        <img src="image/PC.jpg" alt="" width="80" height="70" title="MONITOR" /></td> 
                                    <!--<td width="50" class="caja_texto_pe" onclick="javascript:menu('19')" ><img src="image/04-07-2017 04-47-10 p.m..jpg" title="MANTENIMIENTOS" width="80"--> 
                                    <!--height="70" /></td>-->    
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td>            
                                                                                                                    <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->

                                                               <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> 
                                                                           <td colspan="50" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>-->
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('20')"><img src="image/CASA.jpg" title="Detalle de Usuarios" width="70" 
                                                                                                              height="70" /></td>
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>
                            </table>
                        <?php } ?>     

                        <?php if ($idperfil == "7") {  // planificacion ?>    
                            <table width="20%" border="0">           	
                                <tr align="center">       
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>       
                                   <!-- <td width="50" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> -->
                                        <!--<td width="50" onclick="javascript:menu('2');" ><img src="image/asinga.jpg" title="ASIGNACIONES" width="70" height="70" class="imagen_link" /></td>	 -->          			<td colspan="50" onclick="javascript:menu('18');" ><img src="image/usu.jpg" width="70" height="70" title="USUARIOS" /></td>  
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>     
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('8')" >
                                        <img src="image/PC.jpg" alt="" width="80" height="70" title="MONITOR" /></td>  
                                    <td width="50" class="caja_texto_pe" onclick="javascript:menu('21')" ><img src="image/manual.jpg" title="Tutorial" width="90" 
                                                                                                               height="70" /></td>             
                                                                                                                    <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->

                                                               <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> 
                                                                           <td colspan="50" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>-->
                                    <td width="70" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>
                            </table>
                        <?php } ?>  



                        <?php
                    }

                    if ($grupo == "TDP") {
                        ?>       

                        <?php if ($idperfil == 1) {  //GESTOR TDP NO COT  ?>
                            <table width="20%" border="0">
                                <tr>
                                    <td width="80" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>      
                                    <!--<td width="76" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>   -->
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>	
                                                       <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                       <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->      		
                                    <td width="107" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70"  
                                                                               onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>  
                            </table>            
                        <?php } ?>  

                        <?php if ($idperfil == 3) {  //GESTOR TDP NO COT  ?>
                            <table width="20%" border="0">
                                <tr>
                                    <td width="76" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>      
                                    <!--<td width="76" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td> -->  
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('17')" ><img src="image/BT2.gif" alt="" width="80" height="70" title="USSD 101" /></td>	
                                    <td colspan="50" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>    
                                                                   <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                                   <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->      		
                                    <td width="78" class="caja_texto_pe"><img src="image/SAL.jpg" alt="" width="70" height="70" 
                                                                              onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>  
                            </table>            
                        <?php } ?>  
                        <?php if ($idperfil == 6) {  //GESTOR TDP NO COT   ?>
                            <table width="20%" border="0">
                                <tr>
                                    <td width="35%" class="caja_texto_pe" onclick="javascript:menu('0');"><img src="image/inicio.jpg" alt="" width="70" height="70" /></td>      
                                    <!--<td width="76" class="caja_texto_pe" onclick="javascript:menu('16');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>  --> 				
                                    <td colspan="5%" class="caja_texto_pe" onclick="javascript:menu('14')" ><img src= "image/INCIDENCIAS.jpg" alt="" width="80" height="70" /></td>    
                                                                   <!--<td colspan="50" onclick="javascript:menu('9')" ><img src="image/MONITOR.jpg" alt="" width="70" height="70" title="BO LIQUIDACION" /></td>-->
                                                                   <!--<td colspan="50" onclick="javascript:menu('7')" ><img src="image/contrase.jpg" alt="" width="80" height="70" title="CAMBIO CONTRASEÑA" /></td> -->      		
                                    <td width="26%" class="caja_texto_pe" ><img src="image/SAL.jpg" alt="" width="70" height="70"
                                                                                onclick="javascript:salir('<?php echo $idsess ?>', '<?php echo $iduser ?>');"/></td>
                                </tr>  
                            </table>            
                        <?php } ?>  
                    <?php } ?>       

                </td>
            </tr>
            <tr>
                <td class="presentacion" colspan="3">GESTION DE INCIDENCIAS</td>
            </tr>
            <tr>
                <td colspan="3" align="right" class="i_resolucion">BIENVENIDO : <?php echo $usu[1] ?></td>
            </tr>  
            <tr>
                <td width="1%">&nbsp;</td>
                <td width="100%"valign="top">
                    <div id="d_cambio_contra" style="display:none">
                        <table width="60%" class="marco_tabla_red">
                            <tr>
                                <td colspan="6" class="cabec_1">CAMBIO DE CONTRASEÑA</td>
                            </tr>
                            <tr>
                                <td width="17%" valign="top" class="TitTablaI">NUEVA CONTRASEÑA</td>
                                <td width="29%" valign="top" class="casilla_texto">
                                    <input name="contra1" type="text" class="casilla_texto" id="contra1" size="30" maxlength="10" />
                                </td>
                                <td width="20%" valign="top" class="TitTablaI">REPETIR CONTRASEÑA</td>
                                <td width="28%" valign="top" class="casilla_texto">
                                    <input name="contra2" type="text" class="casilla_texto" id="contra2" size="30" maxlength="10" />
                                </td>
                                <td width="6%" align="center"><img src="image/vis.jpg" width="30" height="30" onclick="javascript:cambio_contra('<?php echo $iduser ?>')" /></td>
                                <td width="6%" align="center"><img src="image/eliminar.jpg" width="30" height="30"  onclick="javascript:cerra_cambio_contra()"/></td>
                            </tr>
                        </table>
                    </div>   


                    <div id="d_modulos" style="display:none">
                        <iframe id="f_modulos"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
                                width="100%"  scrolling="Auto"  height="1000" > </iframe>
                    </div>

                </td>
            </tr>

        </table>

<!--        <table width="200%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>-->

    </body>
</html>