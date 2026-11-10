<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/procedimientos_datos.php';

$sql = "INSERT INTO procedimientos (usuario_id, nombre, descripcion, precio) VALUES ($usuario_id, '$nombre', '$descripcion', $precio)";
if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Procedimiento guardado.');
}
responder('error', 'No se pudo guardar el procedimiento.');
