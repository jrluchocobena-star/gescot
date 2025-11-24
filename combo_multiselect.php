<? 
include("conexion_bd.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
div.multiple_select_checkbox {
    width: 150px;
    height: 60px;
    overflow-x: hidden;
    overflow-y: auto;
    border: 1px solid #CCCCCC;
}
</style>
<script language="javascript" >
function validate(){
	alert(document.getElementsByName("languages_known").value)
   for (var i=0;i<document.getElementsByName("languages_known").length;i++){
		if (document.getElementsByName("languages_known")[i].checked==true){
        alert(document.getElementsByName("languages_known")[i].checked+"-"+document.getElementsByName("languages_known")[i].value);	   
		}
    }
}
</script>
<title>Documento sin título</title>
</head>

<body>
<!--
<div class="multiple_select_checkbox">
   <div id="multiple_select_checkbox_choice"><input type="checkbox" name="slt_username" value="1001" />Siva</div>
   <div id="multiple_select_checkbox_choice"><input type="checkbox" name="slt_username" value="1002" />Raja</div>
   <div id="multiple_select_checkbox_choice"><input type="checkbox" name="slt_username" value="1003" />Kumar</div>
   <div id="multiple_select_checkbox_choice"><input type="checkbox" name="slt_username" value="1004" />Vijay</div>
</div>

<br />
<button onclick="javascript:validate();">Validate</button>
 -->
 
<p>
<select name="languages_known[]" multiple="multiple" onchange="javascript:validate();">
<?php
$users_language = explode(",",$users["languages_known"]);
$languages_result = mysql_query("SELECT * FROM area_cot");
$i=0;
while($languages_stack = mysql_fetch_array($languages_result)) {	
if(in_array($languages_stack["area"],$users_language)) $str_flag = "selected";
else $str_flag="";
?>
<option value="<?=$languages_stack["id_area"];?>" <?php echo $str_flag; ?>><?=$languages_stack["area"];?></option>
<?php
$i++;
}
?>
</select>


</body>
</html>