<?php
\
$procedimiento_id = (int)($_POST['procedimiento_id'] ?? 0);
$fecha = limpiar($conexion, $_POST['fecha'] ?? '');
$pieza = limpiar($conexion, $_POST['pieza_dental'] ?? '');
$motivo = limpiar($conexion, $_POST['motivo'] ?? '');
$diagnostico = limpiar($conexion, $_POST['diagnostico'] ?? '');
$observaciones = limpiar($conexion, $_POST['observaciones'] ?? '');

if ($procedimiento_id === 0 || $fecha === '' || strtotime($fecha) === false) {
    responder('error', 'Elige un procedimiento y una fecha válida.');
}
\
$res = mysqli_query($conexion, "SELECT id FROM procedimientos WHERE id = $procedimiento_id AND usuario_id = $usuario_id");
if (mysqli_num_rows($res) == 0) {
    responder('error', 'Procedimiento no válido.');
}
