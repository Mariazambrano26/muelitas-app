<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_POST['id'] ?? 0);

$sql = "DELETE h FROM historias h JOIN pacientes p ON p.id = h.paciente_id WHERE h.id = $id AND p.usuario_id = $usuario_id";
if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Consulta eliminada.');
}
responder('error', 'No se pudo eliminar la consulta.');
