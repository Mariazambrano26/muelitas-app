<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$paciente_id = (int)($_GET['paciente_id'] ?? 0);

$sql = "SELECT h.*, pr.nombre AS procedimiento
        FROM historias h
        JOIN procedimientos pr ON pr.id = h.procedimiento_id
        JOIN pacientes p ON p.id = h.paciente_id
        WHERE h.paciente_id = $paciente_id AND p.usuario_id = $usuario_id
        ORDER BY h.fecha DESC, h.id DESC";
$res = mysqli_query($conexion, $sql);

$lista = [];
while ($fila = mysqli_fetch_assoc($res)) {
    $lista[] = $fila;
}
responder('exito', '', ['consultas' => $lista]);
