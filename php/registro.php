<?php
session_start();
require __DIR__ . '/conexion.php';

$nombre = limpiar($conexion, $_POST['nombre'] ?? '');
$consultorio = limpiar($conexion, $_POST['consultorio'] ?? '');
$correo = limpiar($conexion, $_POST['correo'] ?? '');
$clave = $_POST['clave'] ?? '';
$clave2 = $_POST['clave2'] ?? '';

if ($nombre === '' || $consultorio === '' || $correo === '' || $clave === '') {
    responder('error', 'Completa todos los campos.');
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    responder('error', 'El correo no es válido.');
}
if (strlen($clave) < 6) {
    responder('error', 'La contraseña debe tener al menos 6 caracteres.');
}
if ($clave !== $clave2) {
    responder('error', 'Las contraseñas no coinciden.');
}

$res = mysqli_query($conexion, "SELECT id FROM usuarios WHERE correo = '$correo'");
if (mysqli_num_rows($res) > 0) {
    responder('error', 'Ese correo ya está registrado.');
}

$hash = password_hash($clave, PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (nombre, correo, clave, consultorio) VALUES ('$nombre', '$correo', '$hash', '$consultorio')";
if (!mysqli_query($conexion, $sql)) {
    responder('error', 'No se pudo crear la cuenta.');
}

$_SESSION['usuario_id'] = mysqli_insert_id($conexion);
$_SESSION['usuario_nombre'] = $_POST['nombre'];
$_SESSION['usuario_consultorio'] = $_POST['consultorio'];
responder('exito', '', ['ir' => 'panel.php']);
