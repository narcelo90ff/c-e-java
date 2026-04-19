<?php
/**
 * funcoes.php
 * Funções reutilizáveis: proteção de página, cálculos financeiros e formatação.
 */

// ── Controle de Acesso ─────────────────────────────────────────────────────
/**
 * Redireciona para o login se não houver sessão ativa.
 */
function proteger_pagina(): void {
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: ../pagina/Login.php');
        exit;
    }
}

// ── Formatação ─────────────────────────────────────────────────────────────
/**
 * Formata um float para o padrão monetário brasileiro (R$ 0,00).
 */
function formatar_moeda(float $valor): string {
    return 'R$ ' . number_format(abs($valor), 2, ',', '.');
}

// ── Cálculos Financeiros ───────────────────────────────────────────────────
/**
 * Calcula o saldo total: soma receitas e subtrai despesas.
 */
function calcular_saldo(array $transacoes): float {
    $saldo = 0.0;
    foreach ($transacoes as $t) {
        $saldo += ($t['tipo'] === 'Receita') ? $t['valor'] : -$t['valor'];
    }
    return $saldo;
}

/**
 * Retorna a soma de todas as receitas.
 */
function calcular_total_receitas(array $transacoes): float {
    $total = 0.0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'Receita') $total += $t['valor'];
    }
    return $total;
}

/**
 * Retorna a soma de todas as despesas.
 */
function calcular_total_despesas(array $transacoes): float {
    $total = 0.0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'Despesa') $total += $t['valor'];
    }
    return $total;
}

/**
 * BÔNUS: Calcula a relevância percentual de uma despesa
 * frente ao total de despesas do período.
 */
function calcular_percentual_despesa(float $valor, float $total_despesas): string {
    if ($total_despesas <= 0) return '0,00%';
    return number_format(($valor / $total_despesas) * 100, 2, ',', '.') . '%';
}