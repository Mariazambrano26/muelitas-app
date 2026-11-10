// Pacientes: listar, buscar, agregar, editar y eliminar con AJAX
$(function () {
  var form = $('#formPaciente');

  // LISTAR
  function cargar() {
    $.ajax({
      url: 'php/pacientes_listar.php',
      type: 'GET',
      data: { q: $('#buscar').val() },
      dataType: 'json',
      success: function (r) {
        if (r.pacientes.length === 0) {
          $('#cuerpo').html('<tr><td colspan="6" class="text-center text-muted">No hay pacientes.</td></tr>');
          return;
        }
        var filas = '';
        $.each(r.pacientes, function (i, p) {
          filas += '<tr>' +
            '<td><i class="fa fa-user-circle fa-lg text-primary"></i> ' + esc(p.nombres) + ' ' + esc(p.apellidos) + '</td>' +
            '<td>' + esc(p.cedula) + '</td>' +
            '<td>' + p.edad + ' años</td>' +
            '<td>' + (esc(p.telefono) || '-') + '</td>' +
            '<td><span class="badge badge-pill badge-info">' + p.consultas + '</span></td>' +
            '<td class="text-nowrap">' +
              '<a class="btn btn-sm btn-info" href="paciente.php?id=' + p.id + '" title="Ver historia"><i class="fa fa-folder-open"></i></a> ' +
              '<button class="btn btn-sm btn-warning btn-editar" data-id="' + p.id + '" title="Editar"><i class="fa fa-pencil"></i></button> ' +
              '<button class="btn btn-sm btn-danger btn-eliminar" data-id="' + p.id + '" title="Eliminar"><i class="fa fa-trash"></i></button>' +
            '</td></tr>';
        });
        $('#cuerpo').html(filas);
      },
      error: function () {
        $('#cuerpo').html('<tr><td colspan="6" class="text-center text-danger">No se pudo cargar la lista.</td></tr>');
      }
    });
  }

  // Buscar mientras se escribe
  var espera;
  $('#buscar').on('input', function () {
    clearTimeout(espera);
    espera = setTimeout(cargar, 300);
  });

  // NUEVO: abre el modal vacío
  function nuevo() {
    form[0].reset();
    $('#paciente_id').val('');
    $('#tituloModal').text('Nuevo paciente');
    limpiarAviso(form);
    $('#modalPaciente').modal('show');
  }
  $('#btnNuevo').click(nuevo);

  // SELECCIONAR: trae un paciente y llena el modal para editarlo
  $(document).on('click', '.btn-editar', function () {
    $.ajax({
      url: 'php/pacientes_seleccionar.php',
      type: 'GET',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function (r) {
        if (r.estado !== 'exito') { mensaje('danger', r.mensaje); return; }
        var p = r.paciente;
        $('#paciente_id').val(p.id);
        $('#f_cedula').val(p.cedula);
        $('#f_nombres').val(p.nombres);
        $('#f_apellidos').val(p.apellidos);
        $('#f_nac').val(p.fecha_nacimiento);
        $('#f_sexo').val(p.sexo);
        $('#f_tel').val(p.telefono);
        $('#f_dir').val(p.direccion);
        $('#f_ale').val(p.alergias);
        $('#f_ant').val(p.antecedentes);
        $('#tituloModal').text('Editar paciente');
        limpiarAviso(form);
        $('#modalPaciente').modal('show');
      }
    });
  });

  // AGREGAR o EDITAR (según si hay un id guardado)
  form.submit(function (e) {
    e.preventDefault();
    var url = $('#paciente_id').val() ? 'php/pacientes_editar.php' : 'php/pacientes_agregar.php';
    $.ajax({
      url: url,
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function (r) {
        if (r.estado === 'exito') {
          $('#modalPaciente').modal('hide');
          mensaje('success', r.mensaje);
          cargar();
        } else {
          avisoForm(form, 'danger', r.mensaje);
        }
      },
      error: function () { avisoForm(form, 'danger', 'Error del servidor.'); }
    });
  });

  // ELIMINAR
  $(document).on('click', '.btn-eliminar', function () {
    if (!confirm('¿Eliminar a este paciente y todas sus consultas? No se puede deshacer.')) return;
    $.ajax({
      url: 'php/pacientes_eliminar.php',
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
