<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/pacientes_datos.php';

$sql = "INSERT INTO pacientes (usuario_id, cedula, nombres, apellidos, fecha_nacimiento, sexo, telefono, direccion, alergias, antecedentes)
        VALUES ($usuario_id, '$cedula', '$nombres', '$apellidos', '$nacimiento', '$sexo', '$telefono', '$direccion', '$alergias', '$antecedentes')";

if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Paciente guardado.');
}
if (mysqli_errno($conexion) == 1062) {
    responder('error', 'Ya existe un paciente con esa cédula.');
}
responder('error', 'No se pudo guardar el paciente.');
