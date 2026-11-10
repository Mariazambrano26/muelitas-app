<?php
$activo = 'panel'; $titulo = 'Inicio'; $icono = 'fa-home';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/fotos.php';
require __DIR__ . '/php/conexion.php';
$uid = (int)$_SESSION['usuario_id'];

// Contadores
$totPac = mysqli_fetch_row(mysqli_query($conexion, "SELECT COUNT(*) FROM pacientes WHERE usuario_id=$uid"))[0];
$totMes = mysqli_fetch_row(mysqli_query($conexion, "SELECT COUNT(*) FROM historias h JOIN pacientes p ON p.id=h.paciente_id
    WHERE p.usuario_id=$uid AND h.fecha >= DATE_FORMAT(CURDATE(), '%Y-%m-01')"))[0];
$totPro = mysqli_fetch_row(mysqli_query($conexion, "SELECT COUNT(*) FROM procedimientos WHERE usuario_id=$uid AND activo=1"))[0];

// Últimas consultas
$res = mysqli_query($conexion, "SELECT h.fecha, p.id AS pid, p.nombres, p.apellidos, pr.nombre AS procedimiento
    FROM historias h JOIN pacientes p ON p.id=h.paciente_id JOIN procedimientos pr ON pr.id=h.procedimiento_id
    WHERE p.usuario_id=$uid ORDER BY h.fecha DESC, h.id DESC LIMIT 8");
$consultas = [];
while ($f = mysqli_fetch_assoc($res)) { $consultas[] = $f; }
?>
<div class="alert alert-info">
  Hola, <strong><?= e($_SESSION['usuario_nombre']) ?></strong>. Que tengas una buena jornada en <strong><?= e($_SESSION['usuario_consultorio']) ?></strong>.
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <div class="card text-white bg-primary shadow-sm border-0"><div class="card-body d-flex justify-content-between align-items-center">
      <div><h2 class="mb-0"><?= $totPac ?></h2>Pacientes registrados</div><i class="fa fa-users fa-3x"></i>
    </div></div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card text-white bg-success shadow-sm border-0"><div class="card-body d-flex justify-content-between align-items-center">
      <div><h2 class="mb-0"><?= $totMes ?></h2>Consultas este mes</div><i class="fa fa-calendar-check-o fa-3x"></i>
    </div></div>
  </div>
  <div class="col-md-4 mb-3">
    <div class="card text-white bg-warning shadow-sm border-0"><div class="card-body d-flex justify-content-between align-items-center">
      <div><h2 class="mb-0"><?= $totPro ?></h2>Procedimientos activos</div><i class="fa fa-medkit fa-3x"></i>
    </div></div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 mb-3">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white"><i class="fa fa-clock-o text-primary"></i> Últimas consultas</div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="thead-light"><tr><th>Fecha</th><th>Paciente</th><th>Procedimiento</th></tr></thead>
          <tbody>
          <?php if (!$consultas): ?>
            <tr><td colspan="3" class="text-center text-muted">Todavía no hay consultas.</td></tr>
          <?php endif; ?>
          <?php foreach ($consultas as $c): ?>
            <tr>
              <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
              <td><a href="paciente.php?id=<?= $c['pid'] ?>"><?= e($c['nombres'] . ' ' . $c['apellidos']) ?></a></td>
              <td><span class="badge badge-info"><?= e($c['procedimiento']) ?></span></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4 mb-3">
    <div class="card shadow-sm border-0">
      <?= foto('consulta.jfif', 'rm7Mgu33tHU', 'card-img-top foto-panel', 'Consulta odontológica', 700) ?>
      <div class="card-body">
        <h5 class="card-title">Acciones rápidas</h5>
        <a class="btn btn-primary btn-block" href="pacientes.php?nuevo=1"><i class="fa fa-user-plus"></i> Nuevo paciente</a>
        <a class="btn btn-outline-primary btn-block" href="procedimientos.php?nuevo=1"><i class="fa fa-plus"></i> Nuevo procedimiento</a>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
