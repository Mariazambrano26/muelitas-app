<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$q = limpiar($conexion, $_GET['q'] ?? '');

$sql = "SELECT p.*, TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad,
        (SELECT COUNT(*) FROM historias h WHERE h.paciente_id = p.id) AS consultas,
        (SELECT MAX(h.fecha) FROM historias h WHERE h.paciente_id = p.id) AS ultima
        FROM pacientes p
        WHERE p.usuario_id = $usuario_id
          AND (p.nombres LIKE '%$q%' OR p.apellidos LIKE '%$q%' OR p.cedula LIKE '%$q%')
        ORDER BY p.apellidos, p.nombres";
$res = mysqli_query($conexion, $sql);

$lista = [];
while ($fila = mysqli_fetch_assoc($res)) {
    $lista[] = $fila;
}
responder('exito', '', ['pacientes' => $lista]);
