// Historia clínica de un paciente: consultas (listar, agregar, editar, eliminar)
$(function () {
  var form = $('#formConsulta');
  var pacienteId = $('#datosPaciente').data('id');

  // LISTAR consultas del paciente
  function cargar() {
    $.ajax({
      url: 'php/consultas_listar.php',
      type: 'GET',
      data: { paciente_id: pacienteId },
      dataType: 'json',
      success: function (r) {
        $('#totalConsultas').text(r.consultas.length);
        if (r.consultas.length === 0) {
          $('#cuerpo').html('<tr><td colspan="5" class="text-center text-muted">Este paciente aún no tiene consultas.</td></tr>');
          return;
        }
        var filas = '';
        $.each(r.consultas, function (i, c) {
          var detalle = '';
          if (c.motivo) detalle += '<small><strong>Motivo:</strong> ' + esc(c.motivo) + '</small><br>';
          if (c.diagnostico) detalle += '<small><strong>Diagnóstico:</strong> ' + esc(c.diagnostico) + '</small><br>';
          if (c.observaciones) detalle += '<small><strong>Observaciones:</strong> ' + esc(c.observaciones) + '</small>';
          filas += '<tr>' +
            '<td>' + fechaLatina(c.fecha) + '</td>' +
            '<td><span class="badge badge-info">' + esc(c.procedimiento) + '</span></td>' +
            '<td>' + (esc(c.pieza_dental) || '-') + '</td>' +
            '<td>' + detalle + '</td>' +
            '<td class="text-nowrap">' +
              '<button class="btn btn-sm btn-warning btn-editar" data-id="' + c.id + '" title="Editar"><i class="fa fa-pencil"></i></button> ' +
              '<button class="btn btn-sm btn-danger btn-eliminar" data-id="' + c.id + '" title="Eliminar"><i class="fa fa-trash"></i></button>' +
            '</td></tr>';
        });
        $('#cuerpo').html(filas);
      }
    });
  }

  // NUEVA consulta
  $('#btnNueva').click(function () {
    form[0].reset();
    $('#consulta_id').val('');
    $('#c_fecha').val($('#c_fecha').data('hoy'));
    $('#tituloConsulta').text('Nueva consulta');
    limpiarAviso(form);
    $('#modalConsulta').modal('show');
  });

  // SELECCIONAR para editar
  $(document).on('click', '.btn-editar', function () {
    $.ajax({
      url: 'php/consultas_seleccionar.php',
      type: 'GET',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function (r) {
        if (r.estado !== 'exito') { mensaje('danger', r.mensaje); return; }
        var c = r.consulta;
        $('#consulta_id').val(c.id);
        $('#c_proc').val(c.procedimiento_id);
        $('#c_fecha').val(c.fecha);
        $('#c_pieza').val(c.pieza_dental);
        $('#c_motivo').val(c.motivo);
        $('#c_diag').val(c.diagnostico);
        $('#c_obs').val(c.observaciones);
        $('#tituloConsulta').text('Editar consulta');
        limpiarAviso(form);
        $('#modalConsulta').modal('show');
      }
    });
  });

  // AGREGAR o EDITAR
  form.submit(function (e) {
    e.preventDefault();
    var url = $('#consulta_id').val() ? 'php/consultas_editar.php' : 'php/consultas_agregar.php';
    $.ajax({
      url: url,
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function (r) {
        if (r.estado === 'exito') {
          $('#modalConsulta').modal('hide');
          mensaje('success', r.mensaje);
          cargar();
        } else {
          avisoForm(form, 'danger', r.mensaje);
        }
      },
      error: function () { avisoForm(form, 'danger', 'Error del servidor.'); }
    });
  });

  // ELIMINAR consulta
  $(document).on('click', '.btn-eliminar', function () {
    if (!confirm('¿Eliminar esta consulta de la historia clínica? No se puede deshacer.')) return;
    $.ajax({
      url: 'php/consultas_eliminar.php',
      type: 'POST',
      data: { id: $(this).data('id') },
      dataType: 'json',
      success: function (r) {
        mensaje(r.estado === 'exito' ? 'success' : 'danger', r.mensaje);
        cargar();
      }
    });
  });

  // ELIMINAR el paciente completo
  $('#btnEliminarPaciente').click(function () {
    if (!confirm('¿Eliminar a este paciente y toda su historia clínica? No se puede deshacer.')) return;
    $.ajax({
      url: 'php/pacientes_eliminar.php',
      type: 'POST',
      data: { id: pacienteId },
      dataType: 'json',
      success: function (r) {
        if (r.estado === 'exito') { location.href = 'pacientes.php'; }
        else { mensaje('danger', r.mensaje); }
      }
    });
  });

  cargar();
});
