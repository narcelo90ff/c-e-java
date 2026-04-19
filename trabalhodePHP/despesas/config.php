<?php
/**
 * config.php
 * Responsável por iniciar a sessão e definir as credenciais fixas do sistema.
 * Utiliza password_hash() para armazenar o hash da senha de forma segura.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Credenciais fixas — senha protegida com password_hash()
define('USUARIO_FIXO', 'admin');
define('SENHA_HASH',   password_hash('admin123', PASSWORD_BCRYPT));

// Inicializa o array de transações na sessão caso não exista
if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
}