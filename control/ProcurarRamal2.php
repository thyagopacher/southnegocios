<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    $conexao = new Conexao();
    $and     = "";
    
    if(isset($_POST["ramal"]) && $_POST["ramal"] != NULL && $_POST["ramal"] != ""){
        $and .= " and ramal.ramal like '%{$_POST["ramal"]}%'";
    }
    if(isset($_POST["externo"]) && $_POST["externo"] != NULL && $_POST["externo"] != ""){
        $and .= " and ramal.externo = '{$_POST["externo"]}'";
    }
    if(isset($_POST["telefone"]) && $_POST["telefone"] != NULL && $_POST["telefone"] != ""){
        $and .= " and ramal.telefone like '%{$_POST["telefone"]}%'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and ramal.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["codempresa"]) && $_POST["codempresa"] != NULL && $_POST["codempresa"] != ""){
        $and .= " and (ramal.codempresa = '{$_POST["codempresa"]}' or ramal.externo = 's')";
    }else{
        $and .= " and ramal.codempresa = '{$_SESSION['codempresa']}'";
    }    
    $sql = 'select ramal.*, DATE_FORMAT(ramal.dtcadastro, "%d/%m/%Y") as dtcadastro2, empresa.razao as empresa 
    from ramal
    inner join empresa on empresa.codempresa = ramal.codempresa 
    where 1 = 1 '.$and.' order by ramal.nome';
    $res = $conexao->comando($sql)or die("<pre>$sql</pre>");
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
                                        Ramal
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Empresa
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Telefone
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($ramal = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $ramal["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $ramal["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $ramal["ramal"] ?>
                                    </td>
                                    <td>
                                        <?= $ramal["empresa"] ?>
                                    </td>
                                    <td>
                                        <?= $ramal["telefone"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="Ramal.php?codramal=',$ramal["codramal"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluirRamal2(',$ramal["codramal"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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
        $classe_linha = "even";
    }

?>