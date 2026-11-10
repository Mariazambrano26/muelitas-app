<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_POST['id'] ?? 0);

if (mysqli_query($conexion, "DELETE FROM procedimientos WHERE id = $id AND usuario_id = $usuario_id")) {
    responder('exito', 'Procedimiento eliminado.');
}
// Error 1451: tiene consultas registradas
if (mysqli_errno($conexion) == 1451) {
    responder('error', 'No se puede eliminar: ya se usó en consultas. Desactívalo en su lugar.');
}
responder('error', 'No se pudo eliminar el procedimiento.');
