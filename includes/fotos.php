<?php
// Muestra una foto de assets/img/. Si el archivo no existe todavía,
// carga la misma foto desde Unsplash (licencia libre) para que la página no se vea vacía.
function foto($archivo, $unsplash, $clase = '', $alt = '', $ancho = 1400) {
    $remota = 'https://unsplash.com/photos/' . $unsplash . '/download?force=true&w=' . $ancho;
    return '<img src="assets/img/' . $archivo . '" class="' . $clase . '" alt="' . $alt . '" '
         . 'onerror="this.onerror=null;this.src=\'' . $remota . '\'">';
}
