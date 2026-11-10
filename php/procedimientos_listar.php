<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';

$res = mysqli_query($conexion, "SELECT * FROM procedimientos WHERE usuario_id = $usuario_id ORDER BY activo DESC, nombre");
$lista = [];
while ($fila = mysqli_fetch_assoc($res)) {
    $lista[] = $fila;
}
responder('exito', '', ['procedimientos' => $lista]);
