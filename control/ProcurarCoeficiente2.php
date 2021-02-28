<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    
    $conexao = new Conexao();
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        if(strpos($_POST["data1"], "/")){
            $data1 = implode("-",array_reverse(explode("/", $_POST["data1"])));
            $and .= " and coeficiente.dtcadastro >= '{$data1}'";
        }else{
            $and .= " and coeficiente.dtcadastro >= '{$_POST["data1"]}'";
        }          
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        if(strpos($_POST["data2"], "/")){
            $data2 = implode("-",array_reverse(explode("/", $_POST["data2"])));
            $and .= " and coeficiente.dtcadastro <= '{$data2}'";
        }else{
            $and .= " and coeficiente.dtcadastro <= '{$_POST["data2"]}'";
        } 
    }
    $res = $conexao->comando("select codcoeficiente, DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2, valor from coeficiente where 1 = 1 {$and}");
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
                                        Valor
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($coeficiente = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $coeficiente["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $coeficiente["valor"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<a href="Coeficiente.php?codcoeficiente=',$coeficiente["codcoeficiente"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                            echo '<a href="#" onclick="excluir2Coeficiente(',$coeficiente["codcoeficiente"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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