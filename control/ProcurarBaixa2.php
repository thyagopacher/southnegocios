<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Baixa.php";
    $conexao = new Conexao();
    $baixa  = new Baixa($conexao);
    
    $and     = "";
    if(isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != ""){
        $and .= " and baixa.cpf like '%{$_POST["cpf"]}%'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and baixa.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and baixa.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and baixa.dtcadastro <= '{$_POST["data2"]}'";
    }
    if(isset($_POST["codfuncionario"]) && $_POST["codfuncionario"] != NULL){
        $and .= " and baixa.codfuncionario = '{$_POST["codfuncionario"]}'";
    }
    $sql = "select * from nivel where codnivel = '{$_SESSION["codnivel"]}'";
    $nivel_logado = $conexao->comandoArray($sql);
    if(isset($nivel_logado["nome"]) && $nivel_logado["nome"] == "OPERADOR"){
        $and .= " and baixa.codfuncionario = '{$_SESSION['codpessoa']}'";
    }
    $sql = "select baixa.codbaixa, baixa.cpf, baixa.valor, DATE_FORMAT(baixa.dtcadastro, '%d/%m/%Y') as dtcadastro2, pessoa.nome as funcionario, baixa.codempresa, DATE_FORMAT(baixa.dtcadastro, '%Y-%m-%d') as dtcadastro, baixa.codfuncionario
    from baixa
    inner join pessoa on pessoa.codpessoa = baixa.codfuncionario
    where 1 = 1 and baixa.codempresa = {$_SESSION["codempresa"]}
    {$and} order by baixa.dtcadastro desc";

    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    if ($qtd > 0) {
        echo 'Encontrou ', $qtd, ' resultados<br>';
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                        Data Cad.
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Func.
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        CPF
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Valor
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($baixa = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $baixa["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $baixa["funcionario"] ?>
                                    </td>
                                    <td>
                                        <?= $baixa["cpf"] ?>
                                    </td>
                                    <td>
                                        <?= number_format($baixa["valor"], 2, ",", ".") ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<a href="Baixa.php?codbaixa=', $baixa["codbaixa"],'" title="Clique aqui para editar"><img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        echo '<a href="#" onclick="excluir2Baixa(',$baixa["codbaixa"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';                                        ?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
        <?php
        $classe_linha = "even";
    }

?>