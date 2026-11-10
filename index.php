<?php
session_start();
require_once __DIR__ . '/includes/fotos.php';
$logueado = isset($_SESSION['usuario_id']);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Muelitas App - Historia clínica odontológica</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fa fa-heartbeat"></i> Muelitas App</a>
    <div>
      <?php if ($logueado): ?>
        <a class="btn btn-light btn-sm" href="panel.php"><i class="fa fa-dashboard"></i> Ir al panel</a>
      <?php else: ?>
        <a class="btn btn-outline-light btn-sm" href="login.php">Iniciar sesión</a>
        <a class="btn btn-light btn-sm" href="registro.php">Crear cuenta</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Portada con foto -->
<div class="card bg-dark text-white border-0 rounded-0">
  <?= foto('hero.jfif', 'AQG6C_xYEpA', 'card-img rounded-0 foto-hero', 'Consultorio odontológico', 1600) ?>
  <div class="card-img-overlay d-flex align-items-center">
    <div class="container">
      <h1 class="display-4 font-weight-bold">Cada paciente,<br>una historia clara</h1>
      <p class="lead col-lg-6 px-0">Registra pacientes, procedimientos y consultas en un solo lugar, y entrega la historia clínica en PDF cuando la necesiten.</p>
      <a class="btn btn-light btn-lg mr-2" href="registro.php"><i class="fa fa-user-plus"></i> Crear mi cuenta</a>
      <a class="btn btn-outline-light btn-lg" href="login.php">Ya tengo cuenta</a>
    </div>
  </div>
</div>

<!-- Tres tarjetas con foto -->
<div class="container my-5">
  <h2 class="text-center mb-4">¿Qué puedes hacer?</h2>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <?= foto('paciente.jfif', '7lBJaJpS3z4', 'card-img-top foto-card', 'Paciente en consulta', 700) ?>
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-users text-primary"></i> Pacientes</h5>
          <p class="card-text">Datos personales, alergias y antecedentes siempre a mano.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <?= foto('instrumentos.jfif', 'R8MoN4FV5q0', 'card-img-top foto-card', 'Instrumental dental', 700) ?>
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-medkit text-primary"></i> Procedimientos</h5>
          <p class="card-text">Registra lo que ofreces, con su precio, y aplícalo a cada consulta.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <?= foto('consulta.jfif', 'rm7Mgu33tHU', 'card-img-top foto-card', 'Dentista examinando a un paciente', 700) ?>
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-file-pdf-o text-primary"></i> Historia en PDF</h5>
          <p class="card-text">Cada consulta queda guardada y puedes descargar la historia completa.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Lista de procedimientos -->
<section class="bg-white py-5 border-top border-bottom">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <?= foto('co.jfif', 'R8MoN4FV5q0', 'img-fluid rounded shadow', 'Instrumental dental', 900) ?>
      </div>
      <div class="col-md-6">
        <h2 class="mb-3">Procedimientos de tu consultorio</h2>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><i class="fa fa-check text-success"></i> Limpieza dental</li>
          <li class="list-group-item"><i class="fa fa-check text-success"></i> Blanqueamiento</li>
          <li class="list-group-item"><i class="fa fa-check text-success"></i> Extracción de muelas y cordales</li>
          <li class="list-group-item"><i class="fa fa-check text-success"></i> Tratamiento de conductos</li>
          <li class="list-group-item"><i class="fa fa-check text-success"></i> Calzas</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="text-center text-white bg-primary py-5">
  <div class="container">
    <h2>Abre tu consultorio digital</h2>
    <p class="lead">Crea tu cuenta en menos de un minuto y registra tu primer paciente.</p>
    <a class="btn btn-light btn-lg" href="registro.php">Crear mi cuenta</a>
  </div>
</section>

<footer class="text-center text-muted py-4 bg-white">
  Muelitas App &middot; Proyecto académico de historia clínica odontológica
</footer>
</body>
</html>
