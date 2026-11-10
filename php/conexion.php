<?php
$servidor = "";
$usuario = "";
$password = "";
$base_datos = "";


$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);
if (!$conexion) {
    header('Content-Type: application/json; charset=utf-8');
    die(json_encode(['estado' => 'error', 'mensaje' => 'No se pudo conectar a la base de datos.']));
}
mysqli_set_charset($conexion, 'utf8mb4');


function responder($estado, $mensaje = '', $extra = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['estado' => $estado, 'mensaje' => $mensaje], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function limpiar($conexion, $valor) {
    return mysqli_real_escape_string($conexion, trim($valor ?? ''));
}
