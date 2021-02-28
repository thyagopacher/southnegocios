<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Link.php";
    $conexao = new Conexao();
    $link  = new Link($conexao);
    
    $and     = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and link.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and link.dtcadastro >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and link.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codlink, link.nome, DATE_FORMAT(link.dtcadastro, '%d/%m/%Y') as dtcadastro2, link.link
    from link
    where 1 = 1
    {$and} order by link.dtcadastro desc";
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
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Nome
                                    </th>  
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Link
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                        colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Opções
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($link = $conexao->resultadoArray($res)) {?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $link["dtcadastro2"] ?>
                                    </td>
                                    <td>
                                        <?= $link["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $link["link"] ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($link["codcategoria"] == 1 || $link["codcategoria"] == 6) {
                                            $caminhoTelaPessoa = "Cliente";
                                        } else {
                                            $caminhoTelaPessoa = "Pessoa";
                                        }
                                        if ($sms["codcategoria"] == 6) {
                                            $complementoCaminho = "&callcenter=true";
                                        }
                                        echo '<a href="Link.php?codlink=',$link["codlink"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        echo '<a href="#" onclick="excluir2Link(',$link["codlink"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                        ?>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">
                                        Data Cad.
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Nome
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Link
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        Opções
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
<?php
        $classe_linha = "even";
    }
 /*       if(isset($_POST["nome"])){
            echo 'Encontrou ',$qtd, ' resultados<br>';
        }
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">LINKS ÚTEIS</th>';
        if(isset($_POST["nome"])){
            echo '<th>Opções</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($link = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $link["nome"], ' - Dt. Cadastro: ',$link["dtcadastro2"],'<br>';
            if(isset($link["link"]) && $link["link"] != NULL && $link["link"] != ""){
                echo '<a href="',$link["link"],'" target="_blank">Link</a>';
            }
            echo '</td>';
            if(isset($_POST["nome"])){
                echo '<td>';
                echo '<a href="Link.php?codlink=',$link["codlink"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                echo '<a href="#" onclick="excluir2Link(',$link["codlink"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '';
    }
    
   */   
        include "../model/Log.php";
        $log = new Log($conexao);
        $log->codpessoa  = $_SESSION['codpessoa'];
        $log->codempresa = $_SESSION['codempresa'];
        $log->acao       = "procurar";
        $log->observacao = "Procurado link - em ". date('d/m/Y'). " - ". date('H:i');
        $log->codpagina  = "0";
        $log->data = date('Y-m-d');
        $log->hora = date('H:i:s');
        $log->inserir();        
 