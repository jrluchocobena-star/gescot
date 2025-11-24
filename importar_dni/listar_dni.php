<?php
// Establecer conexión con la base de datos
$mysqli = @new mysqli('localhost', 'root', '', 'cot');

// Verificar la conexión
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: " . $mysqli->connect_error;
    exit();
}

// Consulta SQL
$query = "SELECT a.id, a.nombres, a.apellido_paterno, a.apellido_materno, a.sexo, a.dni, a.fecha_nacimiento, b.ncompleto AS usuario_registro, a.fecha_registro FROM tb_dni a LEFT JOIN tb_usuarios b ON a.usuario_registro = b.iduser";

// Ejecutar la consulta
$result = $mysqli->query($query);

// Verificar si la consulta fue exitosa
if (!$result) {
    echo "Error al ejecutar la consulta: " . $mysqli->error;
    exit();
}

// Inicializar un array para almacenar los resultados
$data = array();

// Recorrer los resultados y almacenarlos en el array
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Cerrar la conexión
$mysqli->close();

// Armar el array con la clave "data"
$output = array(
    "data" => $data
);

// Convertir el array en formato JSON
$json_output = json_encode($output);

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Mostrar el JSON
echo $json_output;
?>
