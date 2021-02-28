<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/StatusPessoa.php";
    
    $conexao = new Conexao();
    $status  = new StatusPessoa($conexao);
    
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $res = $status->procuraNome($_POST["nome"]);
    }else{
        $res = $status->procuraNome("");
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
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($status = $conexao->resultadoArray($res)) {
                                    $arrayJavascript = "new Array('{$status["codstatus"]}', '{$status["nome"]}')";
                                    ?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $status["nome"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="javascript:setaEditarStatus(',$arrayJavascript,')" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluir2Status(',$status["codstatus"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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