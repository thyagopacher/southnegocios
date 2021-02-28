<?php
    session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    
    include "../model/Conexao.php";
    $conexao = new Conexao();
    $and     = "";
    
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and empresa.nome like '%{$_POST["nome"]}%'";
    }

    $res = $conexao->comando("select codconsulta, empresa.razao, sc.qtdconsulta, DATE_FORMAT(sc.dtcadastro, '%d/%m/%Y %H:%i:%s') as dtcadastro2 
        from southconsulta as sc
        inner join empresa on empresa.codempresa = sc.codempresa 
        where 1 = 1 {$and} 
        order by sc.dtcadastro desc");
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                        Dt. Cadastro
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Empresa
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Qtd. Consulta
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($sc = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $sc["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $sc["razao"] ?>
                                    </td>
                                    <td>
                                        <?= $sc["qtdconsulta"] ?>
                                    </td>
                                    <td>
                                        <a href="?codconsulta=<?=$sc["codconsulta"]?>" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>
                                        <a href="javascript: excluirSouthConsulta(<?=$sc["codconsulta"]?>)" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>
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