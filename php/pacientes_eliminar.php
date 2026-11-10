<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_POST['id'] ?? 0);

// Sus consultas se borran solas (ON DELETE CASCADE)
if (mysqli_query($conexion, "DELETE FROM pacientes WHERE id = $id AND usuario_id = $usuario_id")) {
    responder('exito', 'Paciente eliminado.');
}
responder('error', 'No se pudo eliminar el paciente.');
