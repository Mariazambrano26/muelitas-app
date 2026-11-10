<?php
session_start();
if (isset($_SESSION['usuario_id'])) { header('Location: panel.php'); exit; }
require_once __DIR__ . '/includes/fotos.php';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear cuenta - Muelitas App</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="d-flex align-items-center py-4" style="min-height:100vh">
<div class="container">
  <div class="card shadow border-0 overflow-hidden">
    <div class="row no-gutters">
      <div class="col-md-5 d-none d-md-block position-relative bg-dark">
        <?= foto('hero.jfif', 'AQG6C_xYEpA', 'foto-lado', 'Consultorio odontológico', 900) ?>
        <div class="card-img-overlay d-flex flex-column justify-content-end text-white" style="background:linear-gradient(transparent,rgba(0,0,0,.7))">
          <h3>Tu consultorio, en orden</h3>
          <p class="mb-0">Crea tu cuenta y empieza a registrar pacientes hoy mismo.</p>
        </div>
      </div>
      <div class="col-md-7">
        <div class="card-body p-5">
          <h3 class="text-primary mb-1"><i class="fa fa-user-plus"></i> Crear cuenta</h3>
          <p class="text-muted mb-4">Registra al odontólogo responsable del consultorio.</p>
          <form id="formAuth" data-url="php/registro.php">
            <div class="form-group">
              <label for="nombre">Nombre del odontólogo</label>
              <input class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <label for="consultorio">Nombre del consultorio</label>
              <input class="form-control" id="consultorio" name="consultorio" required>
            </div>
            <div class="form-group">
              <label for="correo">Correo</label>
              <input class="form-control" type="email" id="correo" name="correo" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="clave">Contraseña</label>
                <input class="form-control" type="password" id="clave" name="clave" minlength="6" required>
              </div>
              <div class="form-group col-md-6">
                <label for="clave2">Repite la contraseña</label>
                <input class="form-control" type="password" id="clave2" name="clave2" required>
              </div>
            </div>
            <div class="aviso"></div>
            <button class="btn btn-primary btn-block" type="submit">Crear cuenta</button>
          </form>
          <p class="mt-4 mb-0 text-muted">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/auth.js"></script>
</body>
</html>
