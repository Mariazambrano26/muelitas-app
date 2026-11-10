<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_GET['id'] ?? 0);
$res = mysqli_query($conexion, "SELECT * FROM pacientes WHERE id = $id AND usuario_id = $usuario_id");
$paciente = mysqli_fetch_assoc($res);

if (!$paciente) {
    responder('error', 'Paciente no encontrado.');
}
responder('exito', '', ['paciente' => $paciente]);
