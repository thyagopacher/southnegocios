<?php

    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";   
    $conexao = new Conexao();
    $orderBy = '';
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and conta.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $data = implode("-",array_reverse(explode("/",$_POST["data"])));
        $and .= " and conta.data >= '{$data}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $data2 = implode("-",array_reverse(explode("/",$_POST["data2"])));
        $and  .= " and conta.data <= '{$data2}'";
    }
    if(isset($_POST["movimentacao"]) && $_POST["movimentacao"] != NULL && $_POST["movimentacao"] != ""){
        $and .= " and conta.movimentacao = '{$_POST["movimentacao"]}'";
    }
    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL && $_POST["codtipo"] != ""){
        $and .= " and conta.codtipo = '{$_POST["codtipo"]}'";
    }
    if(isset($_POST['valor']) && $_POST['valor'] != NULL && $_POST['valor'] != ""){
        $and .= " and conta.valor = '{$_POST['valor']}'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != ""){
        $and .= " and conta.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and conta.codempresa = '{$_POST["codempresa"]}'";
    }elseif(!isset($_POST["master"]) || $_POST["master"] == NULL || $_POST["master"] == ""){
        $and .= " and conta.codempresa = '{$_SESSION['codempresa']}'";
    }
    if(isset($_POST["rateio"]) && $_POST["rateio"] != NULL && $_POST["rateio"] == "s"){
        $and .= " and conta.codambiente > 0";
        $link = "Rateio.php";
    }else{
        $link = "Conta.php";
    }
    if(isset($_POST["ordem"]) && $_POST["ordem"] != NULL && $_POST["ordem"] != ""){
        if($_POST["ordem"] == 1){
            $orderBy = "order by codconta desc";
        }elseif($_POST["ordem"] == 2){
            $orderBy = "order by conta.nome desc";
        }
    }
    
    $sql = "select conta.codconta, conta.nome, conta.valor, DATE_FORMAT(conta.data, '%d/%m/%Y') as data2, DATE_FORMAT(conta.dtpagamento, '%d/%m/%Y') as dtpagamento2,
    DATE_FORMAT(conta.dtcadastro, '%d/%m/%Y') as dtcadastro2, funcionario.nome as funcionario, conta.data, empresa.razao as empresa, tipo.nome as tipo
    from conta 
    inner join pessoa as funcionario on funcionario.codpessoa = conta.codfuncionario
    inner join empresa on empresa.codempresa = conta.codempresa
    inner join tipoconta as tipo on tipo.codtipo = conta.codtipo and tipo.codempresa = tipo.codempresa 
    where 1 = 1 {$and} $orderBy";

    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    $totalConta = 0.0;
    if($qtd > 0){
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
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Dt. Pagamento
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Valor
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Por
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Tipo
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Vencimento
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Centro de Custo
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($conta = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $conta["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $conta["dtpagamento2"] ?>
                                    </td>
                                    <td>
                                        <?= number_format($conta["valor"], 2, ',', '') ?>
                                    </td>
                                    <td>
                                        <?= $conta["funcionario"] ?>
                                    </td>
                                    <td>
                                        <?= $conta["tipo"] ?>
                                    </td>
                                    <td>
                                        <?= $conta["data2"] ?>
                                    </td>
                                    <td>
                                        <?= $conta["empresa"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="',$link,'?codconta=',$conta["codconta"],'&master=',$_POST["master"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluir2Conta(',$conta["codconta"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                            echo '<a href="#" onclick="pagaConta(',$conta["codconta"],')" title="Clique aqui para definir como paga para o dia de hoje"><img style="width: 50px;" src="../visao/recursos/img/dinheiro.png" alt="botão dinheiro"/></a>';
                                        ?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">
                                        Nome
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Dt. Cadastro
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Valor
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Funcionário
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Tipo
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Vencimento
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Empresa
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Opções
                                    </th>
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