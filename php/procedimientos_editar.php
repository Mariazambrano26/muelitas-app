<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/procedimientos_datos.php';

$id = (int)($_POST['id'] ?? 0);

$sql = "UPDATE procedimientos SET nombre='$nombre', descripcion='$descripcion', precio=$precio WHERE id = $id AND usuario_id = $usuario_id";
if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Procedimiento actualizado.');
}
responder('error', 'No se pudo actualizar el procedimiento.');
