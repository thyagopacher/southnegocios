<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/StatusProposta.php";
    
    $conexao = new Conexao();
    
    $and  = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and  .= " and statusproposta.nome like '%{$_POST["nome"]}%'";
    }
    
    
    $sql = 'select excluir from nivelpagina where codpagina = 84 and codnivel = '. $_SESSION["codnivel"];
    $nivelp = $conexao->comandoArray($sql);
    
    $res = $conexao->comando('select statusproposta.*, DATE_FORMAT(statusproposta.dtcadastro, "%d/%m/%Y") as data from statusproposta where 1=1 '.$and.' order by nome');
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
                                        Dt Cadastro
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Browser: activate to sort column ascending">
                                        Status Prioritário
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Cor
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($status = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $status["data"] ?>
                                    </td>
                                    <td>
                                        <?= $status["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $status["statusprioritario"] ?>
                                    </td>
                                    <td>
                                        <?= $status["cor"] ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<a href="StatusProposta.php?codstatus=', $status["codstatus"], $complementoCaminho, '" title="Clique aqui para editar"><img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        if ($nivelp["excluir"] != NULL && $nivelp["excluir"] != "" && $nivelp["excluir"] == "1" && $status["codstatus"] != 3) {
                                            echo '<a href="#" onclick="excluir2Status(', $status["codstatus"], ')" title="Clique aqui para excluir"><img style="width: 20px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                        }
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