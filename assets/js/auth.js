// Login y registro: envían el formulario con AJAX
$(function () {
  $('#formAuth').submit(function (e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
      url: form.data('url'),
      type: 'POST',
      data: form.serialize(),
      dataType: 'json',
      success: function (r) {
        if (r.estado === 'exito') { location.href = r.ir; }
        else { avisoForm(form, 'danger', r.mensaje); }
      },
      error: function () { avisoForm(form, 'danger', 'Error del servidor.'); }
    });
  });
});
