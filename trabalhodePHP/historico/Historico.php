<?php
/**
 * Historico.php
 * Página de histórico de movimentações.
 *
 * Utiliza foreach para percorrer o array da $_SESSION e listar todas as operações.
 * Cada linha exibe: data, nome, tipo (badge), valor, impacto no saldo e % de despesas (bônus).
 *
 * Protegida por sessão — redireciona para login se não autenticado.
 */

require_once(__DIR__ . '/../despesas/config.php');
require_once(__DIR__ . '/../protetor_pagina/funcoes.php');

// ── Controle de Acesso ─────────────────────────────────────────────────────
proteger_pagina();

// ── Deletar transação individual via POST ──────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_id'])) {
    $id = htmlspecialchars(trim($_POST['deletar_id']));
    $_SESSION['transacoes'] = array_values(
        array_filter($_SESSION['transacoes'], fn($t) => $t['id'] !== $id)
    );
    header('Location: Historico.php');
    exit;
}

// ── Limpar Histórico (Gestão de Dados) ────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zerar'])) {
    $_SESSION['transacoes'] = [];
    header('Location: Historico.php');
    exit;
}

// ── Recupera e ordena do mais recente para o mais antigo ──────────────────
$transacoes_raw  = $_SESSION['transacoes'];
$transacoes      = array_reverse($transacoes_raw);   // foreach do mais novo ao mais antigo
$total_despesas  = calcular_total_despesas($transacoes_raw);
$total_receitas  = calcular_total_receitas($transacoes_raw);
$saldo_periodo   = calcular_saldo($transacoes_raw);

$titulo_pagina = 'Histórico';
require_once(__DIR__ . '/../includes/cabecalho.php');
?>

<main>
    <div class="container">

        <div class="panel">

            <!-- ── Cabeçalho da seção ── -->
            <div style="display:flex; justify-content:space-between; align-items:center;
                        flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <h1 style="font-size:1rem; font-weight:700; color:#1e293b;">
                    Histórico de Movimentações
                </h1>
                <div style="display:flex; gap:8px; align-items:center;">
                    <a href="../pagina/index.php" class="btn-voltar">← Voltar</a>
                    <?php if (!empty($_SESSION['transacoes'])): ?>
                    <form method="POST"
                          onsubmit="return confirm('Apagar todo o histórico? Esta ação não pode ser desfeita.')">
                        <button type="submit" name="zerar" class="btn-zerar">
                            <svg width="11" height="11" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                            Zerar
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ── Estado vazio ── -->
            <?php if (empty($transacoes)): ?>

                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <p>Nenhuma movimentação registrada ainda.</p>
                    <a href="../pagina/index.php">+ Adicionar primeira transação</a>
                </div>

            <?php else: ?>

                <!-- ── Tabela: foreach percorre o array da $_SESSION ── -->
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th style="text-align:right;">Valor</th>
                                <th style="text-align:right;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transacoes as $t): ?>
                                <?php
                                    // Lógica de Cálculos: impacto no saldo (+ receita / – despesa)
                                    $impacto    = ($t['tipo'] === 'Receita')
                                                  ? $t['valor'] : -$t['valor'];

                                    // BÔNUS: relevância percentual da despesa frente ao total
                                    $percentual = ($t['tipo'] === 'Despesa')
                                                  ? calcular_percentual_despesa($t['valor'], $total_despesas)
                                                  : null;

                                    $cls_valor  = ($t['tipo'] === 'Receita') ? 'txt-receita' : 'txt-despesa';
                                    $sinal      = ($t['tipo'] === 'Receita') ? '+' : '−';
                                ?>
                                <tr>
                                    <!-- Data -->
                                    <td style="color:#94a3b8; font-size:0.78rem; white-space:nowrap;">
                                        <?= htmlspecialchars($t['data']) ?>
                                    </td>

                                    <!-- Nome / Descrição -->
                                    <td style="font-weight:500; color:#1e293b;">
                                        <?= htmlspecialchars($t['nome']) ?>
                                    </td>

                                    <!-- Tipo (badge colorido) -->
                                    <td>
                                        <span class="badge badge-<?= strtolower($t['tipo']) ?>">
                                            <?= $t['tipo'] ?>
                                        </span>
                                    </td>

                                    <!-- Valor com sinal e impacto no saldo -->
                                    <td style="text-align:right;">
                                        <span class="<?= $cls_valor ?>">
                                            <?= $sinal ?> <?= formatar_moeda($t['valor']) ?>
                                        </span>
                                        <?php if ($percentual): ?>
                                        <div style="font-size:0.68rem; color:#b0bec5;
                                                    margin-top:2px; font-weight:400;">
                                            <?= $percentual ?> das despesas
                                        </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Ações: deletar -->
                                    <td style="text-align:right;">
                                        <form method="POST"
                                              onsubmit="return confirm('Remover esta transação?')"
                                              style="display:inline;">
                                            <input type="hidden"
                                                   name="deletar_id"
                                                   value="<?= htmlspecialchars($t['id']) ?>">
                                            <button type="submit" class="btn-del" title="Remover">
                                                <svg width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <!-- ── Rodapé com totais ── -->
                        <tfoot>
                            <tr>
                                <td colspan="2" style="color:#64748b; font-size:0.75rem;
                                                       font-weight:600; text-transform:uppercase;
                                                       letter-spacing:0.05em;">
                                    Totais do período
                                </td>
                                <td></td>
                                <td style="text-align:right;">
                                    <div class="txt-receita" style="font-size:0.8rem;">
                                        + <?= formatar_moeda($total_receitas) ?>
                                    </div>
                                    <div class="txt-despesa" style="font-size:0.8rem;">
                                        − <?= formatar_moeda($total_despesas) ?>
                                    </div>
                                    <div style="font-size:0.85rem; margin-top:4px;
                                                color:<?= $saldo_periodo >= 0 ? '#16a34a' : '#dc2626' ?>;
                                                font-weight:800;">
                                        = <?= $saldo_periodo >= 0 ? '+' : '−' ?> <?= formatar_moeda($saldo_periodo) ?>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            <?php endif; ?>

        </div>

    </div>
</main>

<?php require_once(__DIR__ . '/../includes/rodape.php'); ?>