<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    $conexao = new Conexao();
    
    $and     = "";
    if(isset($_POST["numinss"]) && $_POST["numinss"] != NULL && $_POST["numinss"] != ""){
        $and .= " and especie.numinss = '{$_POST["numinss"]}'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and especie.nome like '%{$_POST["nome"]}%'";
    }
    
    $sql = "select codespecie, nome, numinss from especie
    where 1 = 1 {$and}";
    $res = $conexao->comando($sql);
    if($res == FALSE){
        die("Erro ocasionado por:". mysqli_error($conexao->conexao));
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
                                        Num
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($especie = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td>
                                        <?= $especie["numinss"] ?>
                                    </td>
                                    <td>
                                        <?= $especie["nome"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="Especie.php?codespecie=',$especie["codespecie"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluir2Especie(',$especie["codespecie"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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