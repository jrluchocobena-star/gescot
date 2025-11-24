<?php
// Establecer conexión con la base de datos
$mysqli = @new mysqli('localhost', 'root', '', 'cot');

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: " . $mysqli->connect_error;
    exit();
}

$id = $_POST['id'];

// Consulta SQL
$query = "DELETE FROM tb_dni WHERE  id = ". $id;

// Ejecutar la consulta
$result = $mysqli->query($query);

$mysqli->close();

// Armar el array con la clave "data"
$output = array(
    "success" => true
);

// Convertir el array en formato JSON
$json_output = json_encode($output);

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Mostrar el JSON
echo $json_output;
?>
