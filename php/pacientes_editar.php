<?php
require __DIR__ . '/seguridad.php';
require __DIR__ . '/conexion.php';
require __DIR__ . '/pacientes_datos.php';

$id = (int)($_POST['id'] ?? 0);

$sql = "UPDATE pacientes SET cedula='$cedula', nombres='$nombres', apellidos='$apellidos', fecha_nacimiento='$nacimiento',
        sexo='$sexo', telefono='$telefono', direccion='$direccion', alergias='$alergias', antecedentes='$antecedentes'
        WHERE id = $id AND usuario_id = $usuario_id";

if (mysqli_query($conexion, $sql)) {
    responder('exito', 'Paciente actualizado.');
}
if (mysqli_errno($conexion) == 1062) {
    responder('error', 'Ya existe un paciente con esa cédula.');
}
responder('error', 'No se pudo actualizar el paciente.');
