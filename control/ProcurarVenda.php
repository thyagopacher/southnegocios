<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}
include "../model/Conexao.php";
$conexao = new Conexao();

$and = " and (empresa.codempresa = {$_SESSION["codempresa"]} or empresa.codpessoa in(select codpessoa from pessoa where codempresa = {$_SESSION["codempresa"]}))";

if (isset($_POST["codfuncionario"]) && $_POST["codfuncionario"] != NULL && $_POST["codfuncionario"] != "") {
    $and .= " and proposta.codfuncionario = '{$_POST["codfuncionario"]}'";
}
if (isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != "") {
    $and .= " and proposta.codstatus = '{$_POST["codstatus"]}'";
}

if (isset($_POST["data1"]) && $_POST["data1"] != NULL) {
    $and .= " and proposta.dtcadastro >= '{$_POST["data1"]}'";
}
if (isset($_POST["data2"]) && $_POST["data2"] != NULL) {
    $and .= " and proposta.dtcadastro <= '{$_POST["data2"]}'";
}
$sql = "select cliente.nome as cliente, funcionario.nome as funcionario, 
        DATE_FORMAT(proposta.dtcadastro, '%d/%m/%Y') as dtcadastro2, 
    funcionario.nome as funcionario, proposta.nome as proposta, proposta.prazo, 
    DATE_FORMAT(proposta.dtvenda, '%d/%m/%Y') as dtvenda2, 
    DATE_FORMAT(proposta.dtpago, '%d/%m/%Y') as dtpago2,
    proposta.vlliberado
    from proposta
    inner join pessoa as funcionario on funcionario.codpessoa = proposta.codfuncionario
    inner join pessoa as cliente     on cliente.codpessoa     = proposta.codfuncionario
    inner join empresa on empresa.codempresa = proposta.codempresa
    where 1 = 1 {$and} order by proposta.dtcadastro desc";

$res = $conexao->comando($sql);
$qtd = $conexao->qtdResultado($res);

if ($qtd > 0) {
    ?>
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-striped dataTable"
                           role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Browser: activate to sort column ascending">
                                    Cliente
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Operador
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Tabela
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Prazo
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Status
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Dt Venda
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Dt Pagamento
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Valor Contrato
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($proposta = $conexao->resultadoArray($res)) { ?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $proposta["cliente"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["funcionario"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["tabela"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["prazo"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["status"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["dtvenda2"] ?>
                                    </td>
                                    <td>
                                        <?= $proposta["dtpago2"] ?>
                                    </td>
                                    <td>
                                        <?= number_format($proposta["vlliberado"], 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php
                                $totalLiberado += $proposta["vlliberado"];
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?= number_format($totalLiberado, 2, ',', '.') ?></td>
                            </tr>
                        </tfoot>                            
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    $classe_linha = "even";
}
?>