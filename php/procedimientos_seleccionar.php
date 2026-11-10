<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$id = (int)($_GET['id'] ?? 0);
$res = mysqli_query($conexion, "SELECT * FROM procedimientos WHERE id = $id AND usuario_id = $usuario_id");
$procedimiento = mysqli_fetch_assoc($res);

if (!$procedimiento) {
    responder('error', 'Procedimiento no encontrado.');
}
responder('exito', '', ['procedimiento' => $procedimiento]);
