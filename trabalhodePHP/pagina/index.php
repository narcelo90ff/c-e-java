<?php


require_once(__DIR__ . '/../despesas/config.php');
require_once(__DIR__ . '/../protetor_pagina/funcoes.php');

proteger_pagina();

$mensagem = '';
$tipo_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['zerar'])) {
        $_SESSION['transacoes'] = [];
        $mensagem = 'Histórico do mês zerado com sucesso.';
        $tipo_msg = 'success';

    } elseif (isset($_POST['nome'])) {
        $nome  = trim($_POST['nome']  ?? '');
        $valor = str_replace(',', '.', trim($_POST['valor'] ?? ''));
        $tipo  = trim($_POST['tipo']  ?? '');

        if (empty($nome)) {
            $mensagem = 'Informe a descrição da transação.';
            $tipo_msg = 'error';
        } elseif (!is_numeric($valor) || floatval($valor) <= 0) {
            $mensagem = 'Informe um valor numérico válido e maior que zero.';
            $tipo_msg = 'error';
        } elseif (!in_array($tipo, ['Receita', 'Despesa'])) {
            $mensagem = 'Selecione um tipo válido: Receita ou Despesa.';
            $tipo_msg = 'error';
        } else {
            $_SESSION['transacoes'][] = [
                'id'    => uniqid('tx_', true),
                'nome'  => htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'),
                'valor' => round(floatval($valor), 2),
                'tipo'  => $tipo,
                'data'  => date('d/m/Y H:i:s'),
            ];
            $mensagem = 'Transação "' . htmlspecialchars($nome) . '" adicionada com sucesso!';
            $tipo_msg = 'success';
        }
    }
}

$transacoes     = $_SESSION['transacoes'];
$saldo          = calcular_saldo($transacoes);         
$total_receitas = calcular_total_receitas($transacoes);
$total_despesas = calcular_total_despesas($transacoes);

$titulo_pagina = 'Dashboard';

require_once(__DIR__ . '/../includes/cabecalho.php');
?>

<main>
    <div class="container">

        <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo_msg ?>">
            <?php if ($tipo_msg === 'success'): ?>
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            <?php else: ?>
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
            <?php endif; ?>
            <?= $mensagem ?>
        </div>
        <?php endif; ?>

        <div class="resumo-grid">

            <div class="resumo-card receitas-card">
                <div class="resumo-label">Total Receitas</div>
                <div class="resumo-valor"><?= formatar_moeda($total_receitas) ?></div>
            </div>

            <div class="resumo-card despesas-card">
                <div class="resumo-label">Total Despesas</div>
                <div class="resumo-valor"><?= formatar_moeda($total_despesas) ?></div>
            </div>

            <div class="resumo-card saldo-card">
                <div class="resumo-label">Saldo Disponível</div>
                <div class="resumo-valor"><?= formatar_moeda($saldo) ?></div>
            </div>

        </div>

        <div class="panel">
            <div class="panel-title">Nova Transação</div>

            <form method="POST" action="index.php">
                <div class="form-row">

                    <div class="field-group">
                        <label for="nome">Descrição</label>
                        <input type="text" id="nome" name="nome"
                               placeholder="Ex: Salário, Aluguel...">
                    </div>

                    <div class="field-group">
                        <label for="valor">Valor</label>
                        <input type="number" id="valor" name="valor"
                               placeholder="0,00" step="0.01" min="0.01">
                    </div>

                    <div class="field-group">
                        <label for="tipo">Tipo</label>
                        <select id="tipo" name="tipo">
                            <option value="Receita">Receita</option>
                            <option value="Despesa">Despesa</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn-adicionar">Adicionar</button>
                    </div>

                </div>
            </form>

            <div class="btn-historico-wrap">
                <a href="../historico/Historico.php" class="btn-historico">
                    Ver Detalhes do Histórico
                </a>
            </div>
        </div>

        <?php if (!empty($transacoes)): ?>
        <div style="display:flex; justify-content:flex-end; margin-top:6px;">
            <form method="POST" action="index.php"
                  onsubmit="return confirm('Zerar todas as transações do mês atual? Esta ação não pode ser desfeita.')">
                <button type="submit" name="zerar" class="btn-zerar">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                    Zerar Mês
                </button>
            </form>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once(__DIR__ . '/../includes/rodape.php'); ?>
