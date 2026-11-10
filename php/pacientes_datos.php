<?php
// Lo incluyen pacientes_agregar.php y pacientes_editar.php: leen y validan el formulario
$nombres = limpiar($conexion, $_POST['nombres'] ?? '');
$apellidos = limpiar($conexion, $_POST['apellidos'] ?? '');
$cedula = limpiar($conexion, $_POST['cedula'] ?? '');
$nacimiento = limpiar($conexion, $_POST['fecha_nacimiento'] ?? '');
$sexo = limpiar($conexion, $_POST['sexo'] ?? '');
$telefono = limpiar($conexion, $_POST['telefono'] ?? '');
$direccion = limpiar($conexion, $_POST['direccion'] ?? '');
$alergias = limpiar($conexion, $_POST['alergias'] ?? '');
$antecedentes = limpiar($conexion, $_POST['antecedentes'] ?? '');

if ($nombres === '' || $apellidos === '' || $cedula === '' || $nacimiento === '' || $sexo === '') {
    responder('error', 'Completa los campos obligatorios.');
}
if (!in_array($sexo, ['F', 'M', 'O'])) {
    responder('error', 'El sexo no es válido.');
}
if (strtotime($nacimiento) === false || $nacimiento > date('Y-m-d')) {
    responder('error', 'La fecha de nacimiento no es válida.');
}
