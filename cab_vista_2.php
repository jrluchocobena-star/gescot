<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript" src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="3%" valign="top" >ANO</td>
    <td width="19%" valign="top">
      <select name="xano" class="caja_texto_pe" id="xano" >
        <option value="0">ESCOGER..</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
      </select>
    </td>
    <td width="5%" valign="top">MES</td>
    <td width="16%" valign="top">
      <select name="xmes" class="caja_texto_pe" id="xmes">
        <option value="0">ESCOGER...</option>
        <option value="01">enero</option>
        <option value="02">febrero</option>
        <option value="03">marzo</option>
        <option value="04">abril</option>
        <option value="05">mayo</option>
        <option value="06">junio</option>
        <option value="07">julio</option>
        <option value="08">agosto</option>
        <option value="09">septiembre</option>
        <option value="10">octubre</option>
        <option value="11">noviembre</option>
        <option value="12">diciembre</option>
      </select>
    </td>
    <td width="3%" valign="top" >&nbsp;</td>
    <td width="10%" align="center" valign="middle" class="caja_texto_pe" onclick="javascript:mostrar_vista_2()"
    ><img src="image/visto3.jpg" width="20" height="20" />Filtrar</td>
    <td width="2%" >&nbsp;</td>
     <td width="9%" class="caja_texto_pe" onclick="javascript:cerrar_win('7')">
     <img src="image/SAL.jpg" width="30" height="30" />Salir</td>
     <td width="35%" >&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="5" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" valign="top"><div id="div_vista_2"></div></td>
  </tr>
</table>
</body>
</html>