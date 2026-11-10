<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$activo = $activo ?? '';
$titulo = $titulo ?? '';
$icono = $icono ?? 'fa-home';
$menu = [
    'panel' => ['Inicio', 'fa-home'],
    'pacientes' => ['Pacientes', 'fa-users'],
    'historias' => ['Historias clínicas', 'fa-file-text-o'],
    'procedimientos' => ['Procedimientos', 'fa-medkit'],
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titulo) ?> - Muelitas App</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="panel.php"><i class="fa fa-heartbeat"></i> Muelitas App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav mr-auto">
        <?php foreach ($menu as $clave => $item): ?>
          <li class="nav-item <?= $activo === $clave ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $clave ?>.php"><i class="fa <?= $item[1] ?>"></i> <?= $item[0] ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
      <span class="navbar-text mr-3"><i class="fa fa-user-md"></i> <?= e($_SESSION['usuario_nombre']) ?></span>
      <a class="btn btn-outline-light btn-sm" href="logout.php"><i class="fa fa-sign-out"></i> Salir</a>
    </div>
  </div>
</nav>

<div class="bg-white border-bottom py-3 mb-4">
  <div class="container">
    <h3 class="mb-0 text-primary"><i class="fa <?= $icono ?>"></i> <?= e($titulo) ?></h3>
  </div>
</div>

<div class="container pb-5">
<div id="mensaje"></div>
