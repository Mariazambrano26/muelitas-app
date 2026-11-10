<?php
$activo = 'procedimientos'; $titulo = 'Procedimientos'; $icono = 'fa-medkit'; $js = 'procedimientos.js';
require __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <p class="mb-0 text-muted">Los procedimientos que ofreces. Desactiva los que ya no realizas.</p>
      <button id="btnNuevo" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo procedimiento</button>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-light"><tr><th>Procedimiento</th><th>Descripción</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody id="cuerpo"><tr><td colspan="5" class="text-center text-muted">Cargando...</td></tr></tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modalProc" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProc">
        <input type="hidden" name="id" id="proc_id">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloProc">Nuevo procedimiento</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label for="p_nombre">Nombre</label><input class="form-control" id="p_nombre" name="nombre" required></div>
          <div class="form-group"><label for="p_desc">Descripción</label><input class="form-control" id="p_desc" name="descripcion"></div>
          <div class="form-group"><label for="p_precio">Precio (USD)</label><input class="form-control" id="p_precio" name="precio" value="0" required></div>
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
