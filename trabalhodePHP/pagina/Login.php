<?php
/**
 * Login.php
 * Página de autenticação com formulário POST.
 * Valida usuário e senha fixos usando password_verify().
 * Se válido, inicia a sessão e redireciona para o dashboard.
 */

require_once(__DIR__ . '/../despesas/config.php');
require_once(__DIR__ . '/../protetor_pagina/funcoes.php');

// Se já estiver autenticado, vai direto ao dashboard
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: index.php');
    exit;
}

$erro = '';

// ── Processa formulário POST ───────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha']   ?? '');

    if (empty($usuario) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif ($usuario === USUARIO_FIXO && password_verify($senha, SENHA_HASH)) {
        // ✅ password_verify() confirma que a senha bate com o hash
        $_SESSION['logado']  = true;
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit;
    } else {
        $erro = 'Utilizador ou palavra-passe incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet — Login</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Gradiente roxo da imagem */
            background: linear-gradient(135deg, #667eea 0%, #7c5cbf 50%, #9b6dce 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 348px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.28), 0 4px 16px rgba(0,0,0,0.15);
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Topo escuro com logo ── */
        .card-header {
            background: #1a1a2e;
            padding: 2rem 2rem 1.8rem;
            text-align: center;
            color: #fff;
        }

        .wallet-svg {
            margin-bottom: 10px;
            display: inline-block;
        }

        .card-header h1 {
            font-size: 1.55rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 0.75rem;
            color: #8b8bae;
            letter-spacing: 0.01em;
        }

        /* ── Corpo branco com formulário ── */
        .card-body { padding: 1.8rem 2rem 1.5rem; }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 10px 13px;
            border-radius: 7px;
            font-size: 0.82rem;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .form-group { margin-bottom: 14px; }

        label {
            display: block;
            font-size: 0.67rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-wrap .input-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0bec5;
            pointer-events: none;
            display: flex;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 7px;
            padding: 10px 12px 10px 34px;
            font-size: 0.9rem;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        }

        input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
            background: #fff;
        }

        input::placeholder { color: #b0bec5; }

        .btn-login {
            width: 100%;
            background: #5c6bc0;
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 12px;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 6px;
            transition: background 0.18s, box-shadow 0.18s;
        }

        .btn-login:hover {
            background: #4a5ab8;
            box-shadow: 0 4px 16px rgba(92,107,192,0.4);
        }

        .btn-login:active { transform: scale(0.99); }

        .card-footer {
            text-align: center;
            font-size: 0.68rem;
            color: #b0bec5;
            padding: 10px 0 2px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- Topo escuro -->
    <div class="card-header">
        <div class="wallet-svg">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                 stroke="#ffffff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <path d="M16 12h2"/>
                <path d="M2 10h20"/>
            </svg>
        </div>
        <h1>MyWallet</h1>
        <p>Gestão Financeira Pessoal</p>
    </div>

    <!-- Corpo branco -->
    <div class="card-body">

        <?php if ($erro): ?>
        <div class="alert-error">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <?= htmlspecialchars($erro) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="Login.php" autocomplete="off">

            <div class="form-group">
                <label for="usuario">Utilizador</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/>
                        </svg>
                    </span>
                    <input type="text" id="usuario" name="usuario"
                           placeholder="admin"
                           value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="senha">Palavra-Passe</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                    </span>
                    <input type="password" id="senha" name="senha" placeholder="••••••">
                </div>
            </div>

            <button type="submit" class="btn-login">Entrar no Sistema</button>

        </form>

        <div class="card-footer">PHP Academic Project &copy; <?= date('Y') ?></div>
    </div>

</div>

</body>
</html>