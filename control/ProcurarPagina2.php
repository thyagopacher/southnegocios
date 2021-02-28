<?php
    include "../model/Conexao.php";
    include "../model/Pagina.php";
    $conexao = new Conexao();
    $pagina  = new Pagina($conexao);

    if(isset($_POST["nome"])){
        $res = $pagina->procuraNome($_POST["nome"]);
    }else{
        $res = $pagina->procuraNome("");
    }
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
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Link
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Titulo
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pagina = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $pagina["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $pagina["link"] ?>
                                    </td>
                                    <td>
                                        <?= $pagina["titulo"] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $arrayJavascript = "new Array('{$pagina["codpagina"]}', '{$pagina["nome"]}', '{$pagina["titulo"]}', '{$pagina["link"]}', '{$pagina["codmodulo"]}', '{$pagina["abreaolado"]}')";
                                        echo '<a href="javascript:setaEditarPagina(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        echo '<a href="#" onclick="excluir2(',$pagina["codpagina"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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