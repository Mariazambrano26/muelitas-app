// Procedimientos: listar, agregar, editar, activar/desactivar y eliminar con AJAX
$(function () {
  var form = $('#formProc');

  // LISTAR
  function cargar() {
    $.ajax({
      url: 'php/procedimientos_listar.php',
      type: 'GET',
      dataType: 'json',
      success: function (r) {
        if (r.procedimientos.length === 0) {
          $('#cuerpo').html('<tr><td colspan="5" class="text-center text-muted">Aún no tienes procedimientos.</td></tr>');
          return;
        }
        var filas = '';
        $.each(r.procedimientos, function (i, p) {
          var activo = p.activo == 1;
          filas += '<tr>' +
            '<td><i class="fa fa-medkit text-primary"></i> ' + esc(p.nombre) + '</td>' +
            '<td>' + esc(p.descripcion) + '</td>' +
            '<td>$' + parseFloat(p.precio).toFixed(2) + '</td>' +
            '<td><span class="badge badge-' + (activo ? 'success' : 'secondary') + '">' + (activo ? 'Activo' : 'Inactivo') + '</span></td>' +
            '<td class="text-nowrap">' +
              '<button class="btn btn-sm btn-warning btn-editar" data-id="' + p.id + '" title="Editar"><i class="fa fa-pencil"></i></button> ' +
              '<button class="btn btn-sm btn-secondary btn-alternar" data-id="' + p.id + '" title="' + (activo ? 'Desactivar' : 'Activar') + '"><i class="fa fa-toggle-' + (activo ? 'on' : 'off') + '"></i></button> ' +
              '<button class="btn btn-sm btn-danger btn-eliminar" data-id="' + p.id + '" title="Eliminar"><i class="fa fa-trash"></i></button>' +
            '</td></tr>';
        });
        $('#cuerpo').html(filas);
      }
    });
  }

  // NUEVO
  function nuevo() {
    form[0].reset();
    $('#proc_id').val('');
    $('#p_precio').val('0');
    $('#tituloProc').text('Nuevo procedimiento');
    limpiarAviso(form);
    $('#modalProc').modal('show');
  }
  $('#btnNuevo').click(nuevo);

  // SELECCIONAR para editar
  $(document).on('click', '.btn-editar', function () {
    $.ajax({
      url: 'php/procedimientos_seleccionar.php',
      type: 'GET',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function (r) {
        if (r.estado !== 'exito') { mensaje('danger', r.mensaje); return; }
        var p = r.procedimiento;
        $('#proc_id').val(p.id);
        $('#p_nombre').val(p.nombre);
        $('#p_desc').val(p.descripcion);
        $('#p_precio').val(p.precio);
        $('#tituloProc').text('Editar procedimiento');
        limpiarAviso(form);
        $('#modalProc').modal('show');
      }
    });
  });

  // AGREGAR o EDITAR
  form.submit(function (e) {
    e.preventDefault();
    var url = $('#proc_id').val() ? 'php/procedimientos_editar.php' : 'php/procedimientos_agregar.php';
    $.ajax({
      url: url,
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function (r) {
        if (r.estado === 'exito') {
          $('#modalProc').modal('hide');
          mensaje('success', r.mensaje);
          cargar();
        } else {
          avisoForm(form, 'danger', r.mensaje);
        }
      },
      error: function () { avisoForm(form, 'danger', 'Error del servidor.'); }
    });
  });

  // ACTIVAR / DESACTIVAR
  $(document).on('click', '.btn-alternar', function () {
    $.ajax({
      url: 'php/procedimientos_alternar.php',
      type: 'POST',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function () { cargar(); }
    });
  });

  // ELIMINAR
  $(document).on('click', '.btn-eliminar', function () {
    if (!confirm('¿Eliminar este procedimiento?')) return;
    $.ajax({
      url: 'php/procedimientos_eliminar.php',
      type: 'POST',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function (r) {
        mensaje(r.estado === 'exito' ? 'success' : 'danger', r.mensaje);
        cargar();
      }
    });
  });

  cargar();
  if (location.search.indexOf('nuevo=1') !== -1) { nuevo(); }
});
