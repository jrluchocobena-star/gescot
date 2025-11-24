$(function(){

  function cargarTabla() {
    // Verifica si la tabla ya está inicializada antes de inicializarla nuevamente
    if (!$.fn.DataTable.isDataTable('#table-dni')) {
        new DataTable('#table-dni', {
            ajax: './listar_dni.php',
            pageLength: 25,
            language: {
                url: './datatable_es.json',
            },
            columns: [
                { data: 'id' },
                { data: 'dni' },
                { data: 'nombres' },
                { data: 'apellido_paterno' },
                { data: 'apellido_materno' },
                { data: 'sexo' },
                { data: 'fecha_nacimiento' },
                { data: 'fecha_registro' },
                { data: 'usuario_registro' },
                {
                    // Definir una columna adicional con botones
                    targets: -1, // La columna será la última
                    data: null, // No se necesita asociar datos
                    render: function(data, type, full, meta) {
                        // Renderizar el botón con el ID como atributo data
                        return '<button class="eliminar-dni" data-id="' + full.id + '">Eliminar</button>';
                    }
                }
            ]
        });
    } else {
        // Si la tabla ya está inicializada, solo recarga los datos
        $('#table-dni').DataTable().ajax.reload();
    }
}

// Llamar a cargarTabla() para inicializar la tabla DataTable
cargarTabla();

// Evento click para eliminar un elemento
$('#table-dni').on('click', '.eliminar-dni', function() {
    let id = $(this).data('id');
    let confirmar = confirm('Esta seguro de eliminar este registro');
    if(!confirmar){
      return;
    }
    $.ajax({
        type: "POST",
        url: "./eliminar-dni.php",
        data: { id },
        dataType: "JSON",
        success: function(response) {
            // Recargar la tabla después de eliminar un elemento
            cargarTabla();
        }
    });
});

  
  $('#uploadMasivasExcelDNI').click(function (e) { 
    e.preventDefault();
    var file_data = $('#archivo_excel_dni').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('archivo_excel_dni', file_data);
    $('#error-cargar-dni').hide();
    $.ajax({
        url: './upload.php', // <-- point to server-side PHP script 
        dataType: 'JSON',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'POST',
        beforeSend:function() {
          $('#ContentUploadExcelDNI').hide();
          $('#ContentProcesandoDNI').show();
        },
        success: function(resp){
          if(resp['success']){
            procesarDatosExcel(resp['archivo'])
          }else{
            $('#ContentUploadExcelDNI').show();
            $('#ContentProcesandoDNI').hide();
            $('#archivo_excel_dni').val('')
            $('#error-cargar-dni').html(resp['mensaje']);
            $('#error-cargar-dni').show();
          }
        }
    });
  });


  function procesarDatosExcel(archivo)
  {
    var form_data = new FormData();                  
    form_data.append('archivo', archivo);
    form_data.append('usuario', $('#usuario_excel_DNI').val());
    $.ajax({
      type: "POST",
      url: "./importar_data.php",
      data: form_data,
      dataType: "JSON",
      contentType: false,
      processData: false,
      beforeSend:function() {
        $('#ContentUploadExcel').hide();
        $('#ContentProcesando').show();
      },
      success: function (response) {
        $('#ContentUploadExcel').show();
        $('#ContentProcesando').hide();
        if(response.success){
          
          $('#ContentUploadExcelDNI').show();
          $('#ContentProcesandoDNI').hide();
          cargarTabla();
          
          alert('Se cargó correctamente los registros.');
        }else{
          
          alert('Ocurrió un problema, vuelva a intentarlo.')
        }
      }
    });
  
  }
})
