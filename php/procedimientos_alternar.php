<?php
// Activa o desactiva un procedimiento
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_POST['id'] ?? 0);
if (mysqli_query($conexion, "UPDATE procedimientos SET activo = 1 - activo WHERE id = $id AND usuario_id = $usuario_id")) {
    responder('exito', 'Estado actualizado.');
}
responder('error', 'No se pudo cambiar el estado.');
