<?php
$activo = 'pacientes'; $titulo = 'Pacientes'; $icono = 'fa-users'; $js = 'pacientes.js';
require __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
          <input id="buscar" class="form-control" type="search" placeholder="Buscar por nombre o cédula">
        </div>
      </div>
      <div class="col-md-6 text-md-right mt-2 mt-md-0">
        <button id="btnNuevo" class="btn btn-primary"><i class="fa fa-user-plus"></i> Nuevo paciente</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-light"><tr><th>Paciente</th><th>Cédula</th><th>Edad</th><th>Teléfono</th><th>Consultas</th><th>Acciones</th></tr></thead>
        <tbody id="cuerpo"><tr><td colspan="6" class="text-center text-muted">Cargando...</td></tr></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Ventana para agregar y editar -->
<div class="modal fade" id="modalPaciente" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formPaciente">
        <input type="hidden" name="id" id="paciente_id">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloModal">Nuevo paciente</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-6"><label for="f_nombres">Nombres</label><input class="form-control" id="f_nombres" name="nombres" required></div>
            <div class="form-group col-md-6"><label for="f_apellidos">Apellidos</label><input class="form-control" id="f_apellidos" name="apellidos" required></div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4"><label for="f_cedula">Cédula</label><input class="form-control" id="f_cedula" name="cedula" required></div>
            <div class="form-group col-md-4"><label for="f_nac">Fecha de nacimiento</label><input class="form-control" type="date" id="f_nac" name="fecha_nacimiento" max="<?= date('Y-m-d') ?>" required></div>
            <div class="form-group col-md-4"><label for="f_sexo">Sexo</label>
              <select class="form-control" id="f_sexo" name="sexo" required>
                <option value="">Elige...</option><option value="F">Femenino</option><option value="M">Masculino</option><option value="O">Otro</option>
              </select></div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-5"><label for="f_tel">Teléfono</label><input class="form-control" id="f_tel" name="telefono"></div>
            <div class="form-group col-md-7"><label for="f_dir">Dirección</label><input class="form-control" id="f_dir" name="direccion"></div>
          </div>
          <div class="form-group"><label for="f_ale">Alergias</label><input class="form-control" id="f_ale" name="alergias" placeholder="Ej.: penicilina, látex"></div>
          <div class="form-group"><label for="f_ant">Antecedentes médicos</label><textarea class="form-control" id="f_ant" name="antecedentes" rows="2"></textarea></div>
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
