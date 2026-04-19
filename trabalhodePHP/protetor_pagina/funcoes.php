<?php

function proteger_pagina(): void {
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: ../pagina/Login.php');
        exit;
    }
}


function formatar_moeda(float $valor): string {
    return 'R$ ' . number_format(abs($valor), 2, ',', '.');
}


function calcular_saldo(array $transacoes): float {
    $saldo = 0.0;
    foreach ($transacoes as $t) {
        $saldo += ($t['tipo'] === 'Receita') ? $t['valor'] : -$t['valor'];
    }
    return $saldo;
}


function calcular_total_receitas(array $transacoes): float {
    $total = 0.0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'Receita') $total += $t['valor'];
    }
    return $total;
}


function calcular_total_despesas(array $transacoes): float {
    $total = 0.0;
    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'Despesa') $total += $t['valor'];
    }
    return $total;
}


function calcular_percentual_despesa(float $valor, float $total_despesas): string {
    if ($total_despesas <= 0) return '0,00%';
    return number_format(($valor / $total_despesas) * 100, 2, ',', '.') . '%';
}
