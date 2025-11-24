$(function(){
  
  $('#uploadMasivasExcel').click(function (e) { 
    e.preventDefault();
    var file_data = $('#archivo_excel').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('archivo_excel', file_data);
    $.ajax({
        url: './importar_masivas_excel/upload.php', // <-- point to server-side PHP script 
        dataType: 'JSON',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'POST',
        beforeSend:function() {
          $('#ContentUploadExcel').hide();
          $('#ContentProcesando').show();
        },
        success: function(resp){
          $('#ContentUploadExcel').show();
          $('#ContentProcesando').hide();
          if(resp['success']){
            procesarDatosExcel(resp['archivo'])
          }else{
            $('#archivo_excel').val('')
            Swal.fire({
              title: 'Error!',
              icon: 'error',
              html: resp.mensaje
            })
          }
        }
    });
  });
})

function procesarDatosExcel(archivo)
{
  var form_data = new FormData();                  
  form_data.append('archivo', archivo);
  form_data.append('usuario', $('#usuario_excel_masiva').val());
  form_data.append('perfil', $('#perfil_excel_masiva').val());
  $.ajax({
    type: "POST",
    url: "./importar_masivas_excel/importar_data.php",
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
        var incidencias = '';
        $.each(response.data, function (index, value) { 
           incidencias += value.response.c_incidencia + ', '
        });
        incidencias = incidencias.slice(0,-2)
        Swal.fire(
          'Buen trabajo!',
          `Las incidencias agregadas son: ${incidencias}.`,
          'success'
        )
      }else{
        Swal.fire(
          'Error!',
          `Ocurrió un error al momento de guardar las incidencias.`,
          'warning'
        )
      }
    }
  })
}