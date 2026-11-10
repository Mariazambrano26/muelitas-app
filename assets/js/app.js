// Funciones comunes para todas las páginas (necesita jQuery)

// Escapa texto para mostrarlo en HTML sin riesgos
function esc(texto) {
  return $('<div>').text(texto == null ? '' : texto).html();
}

// Muestra un mensaje arriba a la derecha (tipo: success, danger, warning...)
function mensaje(tipo, texto) {
  $('#mensaje').stop(true, true).hide()
    .html('<div class="alert alert-' + tipo + ' shadow">' + esc(texto) + '</div>')
    .fadeIn();
  setTimeout(function () { $('#mensaje').fadeOut(); }, 3000);
}

// Muestra un aviso dentro de un formulario (el div con clase "aviso")
function avisoForm(form, tipo, texto) {
  form.find('.aviso').attr('class', 'aviso alert alert-' + tipo).text(texto);
}
function limpiarAviso(form) {
  form.find('.aviso').attr('class', 'aviso').text('');
}

// Si la sesión expira, cualquier petición AJAX manda al login
$(document).ajaxError(function (evento, xhr) {
  if (xhr.status === 401) { location.href = 'login.php'; }
});

// 2024-05-31 -> 31/05/2024
function fechaLatina(f) {
  return f ? f.split('-').reverse().join('/') : '-';
}
