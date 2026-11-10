<?php
// Todos los archivos de php/ (menos login y registro) incluyen este: exige sesión iniciada
session_start();
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['estado' => 'error', 'mensaje' => 'Sesión expirada.']);
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
