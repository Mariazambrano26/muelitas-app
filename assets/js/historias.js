// Historias clínicas: lista de pacientes con acceso a su historia y al PDF
$(function () {
  $.ajax({
    url: 'php/pacientes_listar.php',
    type: 'GET',
    dataType: 'json',
    success: function (r) {
      if (r.pacientes.length === 0) {
        $('#cuerpo').html('<tr><td colspan="5" class="text-center text-muted">Aún no hay pacientes. <a href="pacientes.php?nuevo=1">Registra el primero</a>.</td></tr>');
        return;
      }
      var filas = '';
      $.each(r.pacientes, function (i, p) {
        filas += '<tr>' +
          '<td><i class="fa fa-user-circle fa-lg text-primary"></i> ' + esc(p.nombres) + ' ' + esc(p.apellidos) + '</td>' +
          '<td>' + esc(p.cedula) + '</td>' +
          '<td><span class="badge badge-pill badge-info">' + p.consultas + '</span></td>' +
          '<td>' + fechaLatina(p.ultima) + '</td>' +
          '<td class="text-nowrap">' +
            '<a class="btn btn-sm btn-info" href="paciente.php?id=' + p.id + '"><i class="fa fa-folder-open"></i> Abrir</a> ' +
            '<a class="btn btn-sm btn-success" href="historia_pdf.php?id=' + p.id + '" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>' +
          '</td></tr>';
      });
      $('#cuerpo').html(filas);
    }
  });
});
