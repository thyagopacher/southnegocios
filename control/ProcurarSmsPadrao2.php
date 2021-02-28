<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/SmsPadrao.php";
    $conexao = new Conexao();
    $smspadrao  = new SmsPadrao($conexao);

    if(isset($_POST["texto"]) && $_POST["texto"] != NULL && $_POST["texto"] != ""){
        $and .= " and texto = '{$_POST["texto"]}'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        $and .= " and dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        $and .= " and dtcadastro = '{$_POST["data2"]}'";
    }
    $res = $conexao->comando("select smspadrao.*, DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2  from smspadrao where 1 = 1 {$and}");
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                        Nome
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Texto
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($sms = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $sms["dtcadastro2"] ?>
                                    </td>
                                    <td class="sorting_1">
                                        <?= $sms["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $sms["texto"] ?>
                                    </td>
    
                                    <td>
                                        <?php
                                        if ($sms["codcategoria"] == 1 || $sms["codcategoria"] == 6) {
                                            $caminhoTelaPessoa = "Cliente";
                                        } else {
                                            $caminhoTelaPessoa = "Pessoa";
                                        }
                                        if ($sms["codcategoria"] == 6) {
                                            $complementoCaminho = "&callcenter=true";
                                        }
                                        echo '<a href="SmsPadrao.php?codsmspadrao=',$sms["codsmspadrao"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        echo '<a href="#" onclick="excluirSmsPadrao2(',$sms["codsmspadrao"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
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