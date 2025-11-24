<? 
$idperfil=$_GET["idperfil"];
?>

<table width="100%" height="243" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="24" colspan="2" align="right" valign="top">
    
    <? if ($idperfil==0){  // PERFIL ADMINISTRADOR?>    
    <table width="40%" border="0">           	
        <tr align="center">        
        <td width="50" onClick="javascript:menu('1');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>
        <td width="50" onClick="javascript:menu('2');" ><img src="image/asinga.jpg" alt="" width="70" height="70" class="imagen_link" /></td>
        <td colspan="50" onClick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>        
        <td colspan="50" onClick="javascript:menu('4');" ><img src= image/usu.jpg width="70" height="70" /></td>       
        <td colspan="50" onClick="" ><img src= "image/email.gif" alt="" width="70" height="70" /></td>       
        <td colspan="50" onClick="" ><img src= "image/hardware.gif" alt="" width="70" height="70" /></td>  
        <td colspan="50" onClick="" ><img src= "image/gees.jpg" alt="" width="70" height="70" /></td> 
        <td width="70"><img src="image/SAL.jpg" alt="" width="70" height="70" onClick="javascript:salir();" /></td>
	    </tr>
        </table>
    <? } ?>    
    
     <? if ($idperfil==1){  //OPERADOR ?> 
	    <table width="20%" border="0">
        <tr>
        <td width="70" onClick="javascript:menu('1');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>      
        <? if ($s_area=="ASIGNACIONES"){ ?> 
        <td width="73" onClick="javascript:menu('2');" ><img src="image/asinga.jpg" alt="" width="70" height="70" class="imagen_link" /></td>              
        <? } ?>        
        <td width="70"><img src="image/SAL.jpg" alt="" width="70" height="70" onClick="javascript:salir();" /></td>
	    </tr>  
      </table>            
	<? }?>  
        
     <? if ($idperfil==2){  // JEFE?>    
    <table width="20%" border="0">           	
        <tr align="center">        
        <td width="50" onClick="javascript:menu('1');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>        
        <td colspan="50" onClick="javascript:menu('3');" ><img src="image/panel.jpg" alt="" width="70" height="70" /></td>        
        <td colspan="50" onClick="javascript:menu('4');" ><img src= image/usu.jpg width="70" height="70" /></td>                      
        <td width="70"><img src="image/SAL.jpg" alt="" width="70" height="70" onClick="javascript:salir();" /></td>
	    </tr>
        </table>
    <? } ?>     
    
     <? if ($idperfil==3){  // JEFE?>    
    <table width="20%" border="0">           	
        <tr align="center">        
        <td width="50" onClick="javascript:menu('1');"><img src="image/bt_contactos.jpg" alt="" width="70" height="70" /></td>                
        <td colspan="50" onClick="javascript:menu('4');" ><img src= image/usu.jpg width="70" height="70" /></td>               
        <td width="70"><img src="image/SAL.jpg" alt="" width="70" height="70" onClick="javascript:salir();" /></td>
	    </tr>
        </table>
    <? } ?>     
        
    </td>
  </tr>  
</table>

