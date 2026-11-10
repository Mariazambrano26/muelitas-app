<?php
session_start();
require __DIR__ . '/conexion.php';

$correo = limpiar($conexion, $_POST['correo'] ?? '');
$clave = $_POST['clave'] ?? '';

$res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");
$usuario = mysqli_fetch_assoc($res);

if (!$usuario || !password_verify($clave, $usuario['clave'])) {
    responder('error', 'Correo o contraseña incorrectos.');
}

session_regenerate_id(true);
$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nombre'] = $usuario['nombre'];
$_SESSION['usuario_consultorio'] = $usuario['consultorio'];
responder('exito', '', ['ir' => 'panel.php']);
