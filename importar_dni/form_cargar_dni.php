
<head>
<script src="../js/jquery-3.5.1.min.js"></script>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.min.css">

<script src="https://cdn.datatables.net/2.0.4/js/dataTables.min.js"></script>
<script src="main.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
    
<h1 style="font-size: 25px">Cargar archivo excel con dni</h1>
<br>
  <div>
    <a style="font-size:16px;text-decoration:none" download href="./Plantilla_carga_dni.xlsx">Descargar Plantilla Excel</a>
  </div>
  <br>
  <div id="ContentUploadExcelDNI">
    <input type="hidden" id="usuario_excel_DNI" name="usuario" value="<?php echo $_GET["iduser"] ?>">
    <input type="file" name="archivo_excel_dni" id="archivo_excel_dni"></input>
    <button class="btn" id="uploadMasivasExcelDNI" type="button">Subir archivo</button>
  </div>
  <div style="font-size:16px;display:none" id="ContentProcesandoDNI">Procesando...</div>

  <br>
  <div id="error-cargar-dni" style="display:none">

  </div>


  <table id="table-dni">
    <thead>
      <tr>
        <th>Id</th>
        <th>DNI</th>
        <th>Nombres</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Sexo</th>
        <th>Fecha de nacimiento</th>
        <th>Fec. Reg.</th>
        <th>Usu. Reg</th>
        <th></th>
      </tr>
    </thead>
    
  </table>
</div>

</body>
