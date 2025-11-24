<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>


<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>


<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
	<form action="ws_subir_archivo.php" method="post" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="nombre_archivo" />
    </div>
 
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
</body>
</html>
</body>
</html>
