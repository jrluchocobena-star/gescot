<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../js/jquery-3.5.1.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
	<form action="./upload.php" method="post" enctype="multipart/form-data">
 		<input type="file" name="archivo_excel" id="archivo_excel"></input>
 		<button id="upload" type="button">Subir archivo</button>
</form>


<script >

$('#upload').on('click', function() {
    var file_data = $('#archivo_excel').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('archivo_excel', file_data);
    $.ajax({
        url: './upload.php', // <-- point to server-side PHP script 
        dataType: 'JSON',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(resp){
            //alert(php_script_response); // <-- display response from the PHP script, if any
        }
     });
});
	
</script>
</body>
</html>