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
        $and .= " and pctnivel.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $data = implode("-",array_reverse(explode("/",$_POST["data"])));
        $and .= " and pctnivel.data >= '{$data}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $data2 = implode("-",array_reverse(explode("/",$_POST["data2"])));
        $and  .= " and pctnivel.data <= '{$data2}'";
    }
    if(isset($_POST["movimentacao"]) && $_POST["movimentacao"] != NULL && $_POST["movimentacao"] != ""){
        $and .= " and pctnivel.movimentacao = '{$_POST["movimentacao"]}'";
    }
    if(isset($_POST["codtipo"]) && $_POST["codtipo"] != NULL && $_POST["codtipo"] != ""){
        $and .= " and pctnivel.codtipo = '{$_POST["codtipo"]}'";
    }
    if(isset($_POST['valor']) && $_POST['valor'] != NULL && $_POST['valor'] != ""){
        $and .= " and pctnivel.valor = '{$_POST['valor']}'";
    }
    if(isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != ""){
        $and .= " and pctnivel.codstatus = '{$_POST["codstatus"]}'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and pctnivel.codempresa = '{$_POST["codempresa"]}'";
    }elseif(!isset($_POST["master"]) || $_POST["master"] == NULL || $_POST["master"] == ""){
        $and .= " and pctnivel.codempresa = '{$_SESSION['codempresa']}'";
    }
    if(isset($_POST["rateio"]) && $_POST["rateio"] != NULL && $_POST["rateio"] == "s"){
        $and .= " and pctnivel.codambiente > 0";
        $link = "Rateio.php";
    }else{
        $link = "Conta.php";
    }
    if(isset($_POST["ordem"]) && $_POST["ordem"] != NULL && $_POST["ordem"] != ""){
        if($_POST["ordem"] == 1){
            $orderBy = "order by codpctnivel desc";
        }elseif($_POST["ordem"] == 2){
            $orderBy = "order by pctnivel.nome desc";
        }
    }
    
    $sql = "select pctnivel.codpct, nivel.nome as nivel, pctnivel.porcentagem, DATE_FORMAT(pctnivel.dtcadastro, '%d/%m/%Y') as dtcadastro2, nivel.codnivel,
    funcionario.nome as funcionario
    from pctnivel 
    inner join pessoa as funcionario on funcionario.codpessoa = pctnivel.codfuncionario
    inner join nivel on nivel.codnivel = pctnivel.codnivel
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
                                        Nivel
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Dt. Cadastro
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Porcentagem
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Por
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pctnivel = $conexao->resultadoArray($res)) {
                                    $vlPorcentagem = number_format($pctnivel["porcentagem"], 2, ',', '');
                                    ?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $pctnivel["nivel"] ?>
                                    </td>
                                    <td>
                                        <?= $pctnivel["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?=  $vlPorcentagem?>
                                    </td>
                                    <td>
                                        <?= $pctnivel["funcionario"] ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                            $arrayJavascript = "new Array('{$pctnivel["codpct"]}', '{$pctnivel["codnivel"]}', '{$vlPorcentagem}')";
                                            echo '<a href="javascript: setaEditarPctNivel(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="javascript: excluir2PctNivel(',$pctnivel["codpct"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                        ?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">
                                        Nivel
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Dt. Cadastro
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Porcentagem
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Por
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