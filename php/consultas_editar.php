<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/consultas_datos.php';

$id = (int)($_POST['id'] ?? 0);

$sql = "UPDATE historias h JOIN pacientes p ON p.id = h.paciente_id
        SET h.procedimiento_id=$procedimiento_id, h.fecha='$fecha', h.pieza_dental='$pieza',
            h.motivo='$motivo', h.diagnostico='$diagnostico', h.observaciones='$observaciones'
        WHERE h.id = $id AND p.usuario_id = $usuario_id";
if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Consulta actualizada.');
}
responder('error', 'No se pudo actualizar la consulta.');
