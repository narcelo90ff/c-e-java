<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('USUARIO_FIXO', 'admin');
define('SENHA_HASH',   password_hash('admin123', PASSWORD_BCRYPT));

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
}
