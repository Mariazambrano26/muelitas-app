<?php
$activo = 'historias'; $titulo = 'Historias clínicas'; $icono = 'fa-file-text-o'; $js = 'historias.js';
require __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm border-0">
  <div class="card-body">
    <p class="text-muted">Una historia clínica por paciente. Ábrela para ver y agregar consultas, o descárgala en PDF.</p>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="thead-light"><tr><th>Paciente</th><th>Cédula</th><th>Consultas</th><th>Última consulta</th><th>Acciones</th></tr></thead>
        <tbody id="cuerpo"><tr><td colspan="5" class="text-center text-muted">Cargando...</td></tr></tbody>
      </table>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
