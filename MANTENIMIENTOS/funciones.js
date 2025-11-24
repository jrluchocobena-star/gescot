$(document).on('ready',function(event) {
	event.preventDefault();
	listar();
});

function guardar(){
	if ($('#id_p').val() == '') {
		var name = $('#name').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var age = $('#age').val();
		var birthday = $('#birthday').val();
		$.ajax({
			url: 'crud.php',
			type: 'POST',
			data: {name:name,lastname:lastname,email:email,age:age,birthday:birthday,action:'create'},
			success: function(data){
				console.log(data);
				listar();
				clean();
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		});
	}else{
		update();
	}
}

function listar(){
	$.post('crud.php', {action: 'read'}, function(respuesta) {
		$('#tabla').html(respuesta);
	});
}

function delete_row(id){
	$.ajax({
		url: 'crud.php',
		type: 'POST',
		data: {action:"delete",id:id},
		success:function(datos){
			console.log(datos);
			listar();
		}
	}).done(function() {
		console.log("success");
	}).fail(function() {
		console.log("error");
	});
}

function edit_row(id){
	$.ajax({
		url: 'crud.php',
		type: 'POST',
		data: {action:"edit",id:id},
		success:function(datos){
			console.log(datos);
		}
	}).done(function(data) {
		$('#id_p').val(data.id);
		$('#name').val(data.name);
		$('#lastname').val(data.lastname);
		$('#email').val(data.email);
		$('#age').val(data.age);
		$('#birthday').val(data.birthday);
	}).fail(function() {
		console.log("error");
	});
}

function update(){
	if ($('#id_p').val() != '') {
		var id_p = $('#id_p').val();
		var name = $('#name').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var age = $('#age').val();
		var birthday = $('#birthday').val();
		$.ajax({
			url: 'crud.php',
			type: 'POST',
			data: {name:name,lastname:lastname,email:email,age:age,birthday:birthday,action:'update',id_p:id_p},
			success: function(data){
				console.log(data);
				listar();
				clean();
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		});
	}else{
		console.log("Error");
	}
}

function clean(){
	$('#id_p').val("");
	$('#name').val("");
	$('#lastname').val("");
	$('#email').val("");
	$('#age').val("");
	$('#birthday').val("");
}