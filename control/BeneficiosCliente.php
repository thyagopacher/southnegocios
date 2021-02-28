<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
}

function __autoload($class_name) {
    if (file_exists("../model/" . $class_name . '.php')) {
        include "../model/" . $class_name . '.php';
    } elseif (file_exists("../visao/" . $class_name . '.php')) {
        include "../visao/" . $class_name . '.php';
    } elseif (file_exists("./" . $class_name . '.php')) {
        include "./" . $class_name . '.php';
    }
}

$conexao = new Conexao();

$configuracaop = $conexao->comandoArray('select codconfiguracao, consultade 
            from configuracao where codempresa = ' . $_SESSION["codempresa"]);

$sql = 'select beneficiocliente.*, especie.nome as especie, banco.nome as banco 
                    from beneficiocliente 
                    inner join especie on especie.codespecie = beneficiocliente.codespecie
                    left join banco on banco.codbanco = beneficiocliente.codbanco
                    where beneficiocliente.codpessoa = ' . $_POST["codpessoa"] . '  and beneficiocliente.codempresa = ' . $_SESSION["codempresa"];
$resbeneficio = $conexao->comando($sql);
$qtdbeneficio = $conexao->qtdResultado($resbeneficio);
if ($qtdbeneficio > 0) {

    while ($beneficio = $conexao->resultadoArray($resbeneficio)) {
        echo '<table style="background: #01BFEF;color: white;padding: 2px; border-radius: 5px;float: left; margin-right: 10px; width: 33%;">';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Situação: <span style="color: red">', strtoupper($beneficio["situacao"]), '</span></td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Valor: R$ ', number_format($beneficio["salariobase"], 2, ',', ''), '</span></td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Beneficio: ', $beneficio["numbeneficio"], '</td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Espécie: ', $beneficio["especie"], '</td></tr>';
        echo '</table>';

        echo '<table style="background: #F58635;color: white;padding: 2px; border-radius: 5px;float: left; margin-right: 10px; HEIGHT: 84px; width: 20%;">';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Margem Disponível: ', number_format($beneficio["margem"], 2, ',', ''), '</td></tr>';
        if (isset($beneficio["cartao_rmc"]) && $beneficio["cartao_rmc"] != NULL && $beneficio["cartao_rmc"] != "") {
            echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Possui RMC: SIM</span></td></tr>';
        } else {
            echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Possui RMC: NÃO</span></td></tr>';
        }
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Margem RMC: ', number_format($beneficio["valor_cartao_rmc"], 2, ',', ''), '</td></tr>';
        echo '</table>';

        echo '<table style="background: #00A85A;color: white;padding: 2px; border-radius: 5px;float: left; margin-right: 10px;width: 25%;">';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Meio de Pagamento: ', ucfirst($beneficio["meio"]), '</td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Banco Pagador: ', $beneficio["banco"], '</span></td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Agência: ', $beneficio["agencia"], '</td></tr>';
        echo '<tr><td style="padding-left: 15px;padding-right: 15px;">Conta: ', $beneficio["contacorrente"], '</td></tr>';
        echo '</table>';
        $resemprestimo = $conexao->comando('select emprestimo.*, banco.nome as banco 
                                from emprestimo 
                                inner join banco on banco.codbanco = emprestimo.codbanco
                                where emprestimo.codempresa = ' . $_SESSION["codempresa"] . ' and emprestimo.codpessoa = ' . $_POST["codpessoa"] . ' and emprestimo.codbeneficio = ' . $beneficio["codbeneficio"]);
        $qtdemprestimo = $conexao->qtdResultado($resemprestimo);
        if ($qtdemprestimo > 0) {
            ?>
            <table id="example2" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Browser: activate to sort column ascending">
                            BANCO
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            COD.
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            CONTRATO
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            REST./TOTAL
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            PARCELA
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            SALDO APROX.
                        </th>
                        <th style="text-align: center" class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            INCLUIR NA SIMULAÇÃO
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            VALOR LIBERADO
                        </th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    while ($emprestimo = $conexao->resultadoArray($resemprestimo)) {
                        ?>

                        <tr role="row">
                            <td><?= $emprestimo["banco"] ?></td>
                            <td><?= $emprestimo["codbanco"] ?></td>
                            <td></td>
                            <td><?= $emprestimo["parcelas_aberto"] ?> / <?= $emprestimo["prazo"] ?></td>
                            <td id="vlparcela_<?= $emprestimo["codemprestimo"] ?>"><?= number_format($emprestimo["vlparcela"], 2, ',', '') ?></td>
                            <td id="saldo_aproximado_<?= $emprestimo["codemprestimo"] ?>"><?= number_format($emprestimo["saldo_aproximado"], 2, ',', '') ?></td>
                            <td style="text-align: center"><input onclick="calculaCoeficiente(<?= $emprestimo["codemprestimo"] ?>)" codemprestimo="<?= $emprestimo["codemprestimo"] ?>" class="parcela_incluir" type="checkbox" name='parcela_incluir[]' id='parcela_incluir_<?= $emprestimo["codemprestimo"] ?>'/></td>
                            <td id="vl_liberado_<?= $emprestimo["codemprestimo"] ?>"></td>
                        </tr>
                        <?php
                    }
                    echo '<tr>';
                    echo '<td colspan="5" style="text-align: right;">MARGEM DISPONIVEL</td>';
                    echo '<td id="margem_disponivel_', $beneficio["codbeneficio"], '">', number_format($beneficio["margem"], 2, ',', ''), '</td>';
                    echo '<td style="text-align: center"><input onclick="calculaMargem(', $beneficio["codbeneficio"], ')" type="checkbox" class="parcela_incluir_emprestimo" name="parcela_incluir[]" id="parcela_incluir_', $beneficio["codbeneficio"], '"/></td>';
                    echo '<td id="margem_liberado_', $beneficio["codbeneficio"], '"></td>';
                    echo '</tr>';
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<div style="color: red;float: left;width: 100%;margin-bottom: 10px;">Sem empréstimos registrados para esse beneficio</div>';
        }
        if($configuracaop['consultade'] == 2){
            echo '<div id = "div_detalhamento_cliente">';
            echo '<a target="_blank" href="../control/Detalhamento.php?tipo=1&nb='.$beneficio["numbeneficio"].'" title = "Detalhamento 1">Detalhamento I</a> ';
            echo '<a target="_blank" href="../control/Detalhamento.php?tipo=2&nb='.$beneficio["numbeneficio"].'" title = "Detalhamento 2">Detalhamento II</a> ';
            echo '<a target="_blank" href="../control/Detalhamento.php?tipo=3&nb='.$beneficio["numbeneficio"].'" title = "Detalhamento 3">Detalhamento III</a> ';
            echo '</div>';
        } else{
            echo '<div id = "div_detalhamento_cliente">';
            echo '<a target="_blank" href="http://sipa.inss.gov.br/SipaINSS/pages/hiscre/hiscreInicio.xhtml" title = "Previdência">Previdência</a> ';
            echo '</div>';            
        }
    }
}