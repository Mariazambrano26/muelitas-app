<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/consultas_datos.php';

$paciente_id = (int)($_POST['paciente_id'] ?? 0);

$res = mysqli_query($conexion, "SELECT id FROM pacientes WHERE id = $paciente_id AND usuario_id = $usuario_id");
if (mysqli_num_rows($res) == 0) {
    responder('error', 'Paciente no encontrado.');
}

$sql = "INSERT INTO historias (paciente_id, procedimiento_id, fecha, pieza_dental, motivo, diagnostico, observaciones)
        VALUES ($paciente_id, $procedimiento_id, '$fecha', '$pieza', '$motivo', '$diagnostico', '$observaciones')";
if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Consulta guardada.');
}
responder('error', 'No se pudo guardar la consulta.');
