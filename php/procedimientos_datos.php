<?php
// Lo incluyen procedimientos_agregar.php y procedimientos_editar.php
$nombre = limpiar($conexion, $_POST['nombre'] ?? '');
$descripcion = limpiar($conexion, $_POST['descripcion'] ?? '');
$precio = str_replace(',', '.', trim($_POST['precio'] ?? '0'));

if ($nombre === '') {
    responder('error', 'El nombre es obligatorio.');
}
if (!is_numeric($precio) || $precio < 0) {
    responder('error', 'El precio no es válido.');
}
$precio = (float)$precio;
