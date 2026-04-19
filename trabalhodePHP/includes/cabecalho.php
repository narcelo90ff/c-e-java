<?php

$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet — <?= htmlspecialchars($titulo_pagina ?? 'Sistema') ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
                         'Helvetica Neue', Arial, sans-serif;
            background: #f0f2f5;
            color: #111827;
            min-height: 100vh;
            font-size: 14px;
        }

        .navbar {
            background: #1a1a2e;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 1px 4px rgba(0,0,0,0.35);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            letter-spacing: 0.01em;
        }

        .navbar-brand svg { flex-shrink: 0; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-greeting {
            color: #c9d1e0;
            font-size: 0.82rem;
            font-weight: 400;
        }

        .navbar-greeting strong { color: #fff; font-weight: 600; }

        .btn-sair {
            background: #e53e3e;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s;
            display: inline-block;
        }
        .btn-sair:hover { background: #c53030; }

        .container {
            max-width: 1060px;
            margin: 0 auto;
            padding: 28px 20px;
        }

        .resumo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        .resumo-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 18px;
        }

        .resumo-card.saldo-card {
            background: #3b5bdb;
            border: none;
        }

        .resumo-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 7px;
        }

        .resumo-card.saldo-card .resumo-label { color: rgba(255,255,255,0.75); }

        .resumo-valor {
            font-size: 1.45rem;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            line-height: 1;
        }

        .resumo-card.receitas-card .resumo-valor { color: #16a34a; }
        .resumo-card.despesas-card .resumo-valor { color: #dc2626; }
        .resumo-card.saldo-card    .resumo-valor { color: #fff; }

        .panel {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 12px;
        }

        .panel-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 160px 170px auto;
            gap: 10px;
            align-items: end;
        }

        .field-group label {
            display: block;
            font-size: 0.68rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 0.87rem;
            color: #1e293b;
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }

        input::placeholder { color: #b0bec5; }

        input:focus, select:focus {
            border-color: #3b5bdb;
            box-shadow: 0 0 0 3px rgba(59,91,219,0.12);
        }

        .btn-adicionar {
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 9px 22px;
            font-size: 0.83rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.18s;
            letter-spacing: 0.02em;
        }
        .btn-adicionar:hover { background: #2d2d4e; }

        .btn-historico-wrap { text-align: center; margin-top: 16px; }

        .btn-historico {
            display: inline-block;
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 24px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: border-color 0.18s, color 0.18s;
        }
        .btn-historico:hover { border-color: #3b5bdb; color: #3b5bdb; }

        .btn-zerar {
            background: #e53e3e;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 16px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-zerar:hover { background: #c53030; }

        .btn-voltar {
            background: #fff;
            color: #374151;
            border: 1.5px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: border-color 0.18s, color 0.18s;
            display: inline-block;
        }
        .btn-voltar:hover { border-color: #3b5bdb; color: #3b5bdb; }

        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 0.83rem;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        thead th {
            text-align: left;
            padding: 10px 14px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-bottom: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #f8fafc;
            transition: background 0.1s;
        }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child { border-bottom: none; }

        tbody td {
            padding: 11px 14px;
            vertical-align: middle;
        }

        tfoot td {
            padding: 11px 14px;
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            font-weight: 700;
            font-size: 0.83rem;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .badge-receita { background: #dcfce7; color: #15803d; }
        .badge-despesa { background: #fee2e2; color: #dc2626; }

        .txt-receita { color: #16a34a; font-weight: 700; font-variant-numeric: tabular-nums; }
        .txt-despesa { color: #dc2626; font-weight: 700; font-variant-numeric: tabular-nums; }

        .btn-del {
            background: none;
            border: none;
            cursor: pointer;
            color: #e53e3e;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
            font-size: 0.95rem;
        }
        .btn-del:hover { background: #fee2e2; }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }
        .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: 10px; }
        .empty-state p { font-size: 0.9rem; margin-bottom: 12px; }
        .empty-state a { color: #3b5bdb; font-weight: 600; font-size: 0.85rem; text-decoration: none; }

        @media (max-width: 700px) {
            .resumo-grid   { grid-template-columns: 1fr; }
            .form-row      { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="../pagina/index.php" class="navbar-brand">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="5" width="20" height="14" rx="2"/>
            <path d="M16 12h2"/>
            <path d="M2 10h20"/>
        </svg>
        MyWallet
    </a>

    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
    <div class="navbar-right">
        <span class="navbar-greeting">
            Olá, <strong><?= htmlspecialchars(ucfirst($_SESSION['usuario'] ?? 'Admin')) ?></strong>
        </span>
        <a href="../despesas/Logout.php" class="btn-sair">Sair</a>
    </div>
    <?php endif; ?>
</nav>
