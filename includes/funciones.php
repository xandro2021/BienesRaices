<?php
// Se necesita que las rutas sean bien especificas
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado(): bool {
    session_start();
    // variable creada en Login
    $auth = $_SESSION['login'];

    if ($auth) {
        return true;
    }

    return false;
}
