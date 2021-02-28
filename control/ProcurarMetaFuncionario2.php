<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/MetaFuncionario.php";
    $conexao = new Conexao();
    $meta = new MetaFuncionario($conexao);
    
    $and     = "";
    if(isset($_POST["codfuncionario"]) && $_POST["codfuncionario"] != NULL && $_POST["codfuncionario"] != ""){
        $and .= " and meta.codfuncionario = '{$_POST["codfuncionario"]}'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and meta.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and meta.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codmeta, DATE_FORMAT(meta.dtcadastro, '%d/%m/%Y') as dtcadastro2, pessoa.nome as funcionario, meta.valor, meta.codfuncionario, DATE_FORMAT(meta.dtinicio, '%d/%m/%Y') as dtinicio2,
    DATE_FORMAT(meta.dtfim, '%d/%m/%Y') as dtfim2, meta.dtinicio, meta.dtfim
    from metafuncionario as meta
    inner join pessoa on pessoa.codpessoa = meta.codfuncionario 
    where 1 = 1
    and meta.codempresa = '{$_SESSION['codempresa']}'
    {$and} order by meta.dtcadastro desc";  
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                        Data Cad.
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Meta
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Inicio
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Fim
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($meta = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $meta["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $meta["funcionario"] ?>
                                    </td>
                                    <td>
                                        <?= number_format($meta["valor"], 2, ",", "") ?>
                                    </td>
                                    <td>
                                        <?= $meta["dtinicio2"] ?>
                                    </td>
                                    <td>
                                        <?= $meta["dtfim2"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="MetaFuncionario.php?codmeta=',$meta["codmeta"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluir2MetaFuncionario(',$meta["codmeta"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                        ?>
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
    }else{
        echo '';
    }
    