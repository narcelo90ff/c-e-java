<?php
/**
 * Logout.php
 * Encerra a sessão ativa e redireciona para a tela de login.
 */

require_once(__DIR__ . '/config.php');

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

session_destroy();
header('Location: ../pagina/Login.php');
exit;