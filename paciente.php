<?php
$activo = 'pacientes'; $titulo = 'Historia clínica'; $icono = 'fa-folder-open'; $js = 'paciente.js';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/php/conexion.php';
$uid = (int)$_SESSION['usuario_id'];
$id = (int)($_GET['id'] ?? 0);

$res = mysqli_query($conexion, "SELECT *, TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad FROM pacientes WHERE id=$id AND usuario_id=$uid");
$p = mysqli_fetch_assoc($res);
if (!$p) {
    echo '<div class="alert alert-warning">No encontramos a ese paciente. <a href="pacientes.php">Volver a pacientes</a></div>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

// Procedimientos para el select (los inactivos se marcan)
$res = mysqli_query($conexion, "SELECT id, nombre, activo FROM procedimientos WHERE usuario_id=$uid ORDER BY activo DESC, nombre");
$procs = [];
while ($f = mysqli_fetch_assoc($res)) { $procs[] = $f; }

$sexos = ['F' => 'Femenino', 'M' => 'Masculino', 'O' => 'Otro'];
?>
<div class="row">
  <div class="col-lg-4 mb-3">
    <div class="card shadow-sm border-0" id="datosPaciente" data-id="<?= $p['id'] ?>">
      <div class="card-body text-center bg-light">
        <i class="fa fa-user-circle fa-5x text-primary"></i>
        <h4 class="mt-2 mb-0"><?= e($p['nombres'] . ' ' . $p['apellidos']) ?></h4>
        <small class="text-muted"><?= (int)$p['edad'] ?> años &middot; <?= e($sexos[$p['sexo']] ?? '') ?></small>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Cédula:</strong> <?= e($p['cedula']) ?></li>
        <li class="list-group-item"><strong>Nacimiento:</strong> <?= date('d/m/Y', strtotime($p['fecha_nacimiento'])) ?></li>
        <li class="list-group-item"><strong>Teléfono:</strong> <?= e($p['telefono']) ?: '-' ?></li>
        <li class="list-group-item"><strong>Dirección:</strong> <?= e($p['direccion']) ?: '-' ?></li>
        <li class="list-group-item"><strong>Alergias:</strong> <?= e($p['alergias']) ?: 'Ninguna registrada' ?></li>
        <li class="list-group-item"><strong>Antecedentes:</strong> <?= nl2br(e($p['antecedentes'])) ?: 'Sin antecedentes' ?></li>
      </ul>
      <div class="card-body">
        <a class="btn btn-success btn-block" href="historia_pdf.php?id=<?= $p['id'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Descargar PDF</a>
        <a class="btn btn-secondary btn-block" href="pacientes.php"><i class="fa fa-arrow-left"></i> Volver a pacientes</a>
        <button class="btn btn-outline-danger btn-block" id="btnEliminarPaciente"><i class="fa fa-trash"></i> Eliminar paciente</button>
      </div>
    </div>
  </div>

  <div class="col-lg-8 mb-3">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span><i class="fa fa-stethoscope text-primary"></i> Consultas y procedimientos (<span id="totalConsultas">0</span>)</span>
        <button class="btn btn-primary btn-sm" id="btnNueva" <?= $procs ? '' : 'disabled' ?>><i class="fa fa-plus"></i> Nueva consulta</button>
      </div>
      <div class="card-body">
        <?php if (!$procs): ?>
          <div class="alert alert-warning">No tienes procedimientos. <a href="procedimientos.php?nuevo=1">Agrega uno</a> para poder registrar consultas.</div>
        <?php endif; ?>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="thead-light"><tr><th>Fecha</th><th>Procedimiento</th><th>Pieza</th><th>Detalle</th><th>Acciones</th></tr></thead>
            <tbody id="cuerpo"><tr><td colspan="5" class="text-center text-muted">Cargando...</td></tr></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Ventana para agregar y editar consultas -->
<div class="modal fade" id="modalConsulta" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formConsulta">
        <input type="hidden" name="id" id="consulta_id">
        <input type="hidden" name="paciente_id" value="<?= $p['id'] ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloConsulta">Nueva consulta</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6"><label for="c_proc">Procedimiento</label>
              <select class="form-control" id="c_proc" name="procedimiento_id" required>
                <option value="">Elige...</option>
                <?php foreach ($procs as $pr): ?>
                  <option value="<?= $pr['id'] ?>"><?= e($pr['nombre']) ?><?= $pr['activo'] ? '' : ' (inactivo)' ?></option>
                <?php endforeach; ?>
              </select></div>
            <div class="form-group col-md-3"><label for="c_fecha">Fecha</label><input class="form-control" type="date" id="c_fecha" name="fecha" data-hoy="<?= date('Y-m-d') ?>" required></div>
            <div class="form-group col-md-3"><label for="c_pieza">Pieza dental</label><input class="form-control" id="c_pieza" name="pieza_dental" placeholder="Ej.: 36"></div>
          </div>
          <div class="form-group"><label for="c_motivo">Motivo de consulta</label><input class="form-control" id="c_motivo" name="motivo"></div>
          <div class="form-group"><label for="c_diag">Diagnóstico</label><textarea class="form-control" id="c_diag" name="diagnostico" rows="2"></textarea></div>
          <div class="form-group"><label for="c_obs">Observaciones</label><textarea class="form-control" id="c_obs" name="observaciones" rows="2"></textarea></div>
          <div class="aviso"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
