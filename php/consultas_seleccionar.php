<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT h.* FROM historias h JOIN pacientes p ON p.id = h.paciente_id WHERE h.id = $id AND p.usuario_id = $usuario_id";
$consulta = mysqli_fetch_assoc(mysqli_query($conexion, $sql));

if (!$consulta) {
    responder('error', 'Consulta no encontrada.');
}
responder('exito', '', ['consulta' => $consulta]);
