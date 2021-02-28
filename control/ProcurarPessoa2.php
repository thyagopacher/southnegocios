<?php
session_start();
//validação caso a sessão caia
if (!isset($_SESSION)) {
    die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
}
include "../model/Conexao.php";
$conexao = new Conexao();
$and = "";
$sql = "select * from nivel where codempresa = '{$_SESSION['codempresa']}' and codnivel = '{$_SESSION["codnivel"]}'";
$innerJoin = "";
$campos = "";
$nivel = $conexao->comandoArray($sql);
if ($_SESSION["codnivel"] == '16') {
    if (!isset($_POST["codcategoria"]) || $_POST["codcategoria"] == NULL || $_POST["codcategoria"] == "") {
        $and .= " and pessoa.codcategoria not in(1,6)";
    } else {
        if (isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != "") {
            $cpf_limpo = str_replace(".", "", str_replace("-", "", $_POST["cpf"]));
            $and .= " and (pessoa.cpf = '{$_POST["cpf"]}' or pessoa.cpf = '{$cpf_limpo}')";
        } else {
            die("Para realizar esse tipo consulta é necessário informar o CPF!!!");
        }
        if (isset($_POST["codcategoria"]) && $_POST["codcategoria"] != NULL && $_POST["codcategoria"] != "") {
            $and .= " and pessoa.codcategoria = '{$_POST["codcategoria"]}'";
        }
    }
} else {
    if (isset($_POST["email"]) && $_POST["email"] != NULL && $_POST["email"] != "") {
        $and .= " and pessoa.email like '%{$_POST["email"]}%'";
    }
    if (isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != "") {
        if (strpos($_POST["data1"], "/")) {
            $data1 = implode("-", array_reverse(explode("/", $_POST["data1"])));
        } else {
            $data1 = $_POST["data1"];
        }
        $and .= " and pessoa.dtcadastro >= '{$data1}'";
    }
    if (isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != "") {
        if (strpos($_POST["data2"], "/")) {
            $data1 = implode("-", array_reverse(explode("/", $_POST["data2"])));
        } else {
            $data1 = $_POST["data2"];
        }
        $and .= " and pessoa.dtcadastro <= '{$_POST["data2"]}'";
    }
    if (isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != "") {
        $cpf_limpo = str_replace(".", "", str_replace("-", "", $_POST["cpf"]));
        $and .= " and (pessoa.cpf = '{$_POST["cpf"]}' or pessoa.cpf = '{$cpf_limpo}')";
    }
    if (isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != "") {
        $and .= " and pessoa.nome like '%{$_POST["nome"]}%'";
    }
    if (isset($_POST["status"]) && $_POST["status"] != NULL && $_POST["status"] != "") {
        $and .= " and pessoa.status = '{$_POST["status"]}'";
    }
    if (isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != "") {
        $and .= " and pessoa.codstatus = '{$_POST["codstatus"]}'";
    }
    if (isset($_POST["carteira"]) && $_POST["carteira"] != NULL && $_POST["carteira"] != "") {
        $and .= " and pessoa.codpessoa in (select codcarteira from carteiracliente where codcarteira = '{$_POST["carteira"]}')";
    }
    if (isset($_POST["codstatus"]) && $_POST["codstatus"] != NULL && $_POST["codstatus"] != "") {
        $and .= " and pessoa.codstatus = '{$_POST["codstatus"]}'";
    }
    if (isset($_POST["codcategoria"]) && $_POST["codcategoria"] != NULL && $_POST["codcategoria"] != "" && $_POST["codcategoria"] != "1" && $_POST["codcategoria"] != "6") {
        $and .= " and pessoa.codcategoria = '{$_POST["codcategoria"]}'";
    } elseif($_POST["codcategoria"] != "1" && $_POST["codcategoria"] != "6"){
        $and .= " and pessoa.codcategoria not in ('1','6')";
    }
    if (isset($_POST["sexo"]) && $_POST["sexo"] != NULL && $_POST["sexo"] != "") {
        $and .= " and pessoa.sexo = '{$_POST["sexo"]}'";
    }
    if (isset($_POST["rg"]) && $_POST["rg"] != NULL && $_POST["rg"] != "") {
        $and .= " and pessoa.rg = '{$_POST["rg"]}'";
    }
    if (isset($_POST["ufrg"]) && $_POST["ufrg"] != NULL && $_POST["ufrg"] != "") {
        $and .= " and pessoa.ufrg = '{$_POST["ufrg"]}'";
    }
    if (isset($_POST["dtnascimento"]) && $_POST["dtnascimento"] != NULL && $_POST["dtnascimento"] != "") {
        $and .= " and pessoa.dtnascimento = '{$_POST["dtnascimento"]}'";
    }
    if (isset($_POST["localnascimento"]) && $_POST["localnascimento"] != NULL && $_POST["localnascimento"] != "") {
        $and .= " and pessoa.localnascimento like '%{$_POST["localnascimento"]}%'";
    }
    if (isset($_POST["estado"]) && $_POST["estado"] != NULL && $_POST["estado"] != "") {
        $and .= " and pessoa.estado = '{$_POST["estado"]}'";
    }
    if (isset($_POST["email"]) && $_POST["email"] != NULL && $_POST["email"] != "") {
        $and .= " and pessoa.email = '{$_POST["email"]}'";
    }
//margem inicial para buscar
    if (isset($_POST["margem_inicial"]) && $_POST["margem_inicial"] != NULL && $_POST["margem_inicial"] != "") {
        $innerJoin .= " inner join beneficiocliente as beneficio on beneficio.codpessoa = pessoa.codpessoa and beneficio.codempresa = pessoa.codempresa";
        $campos .= ", beneficio.margem";
        $and .= " and beneficio.margem >= '" . str_replace(",", ".", $_POST["margem_inicial"]) . "'";
    }
    if (isset($_POST["margem_fim"]) && $_POST["margem_fim"] != NULL && $_POST["margem_fim"] != "") {
        $innerJoin .= " inner join beneficiocliente as beneficio on beneficio.codpessoa = pessoa.codpessoa and beneficio.codempresa = pessoa.codempresa";
        $campos .= ", beneficio.margem";
        $and .= " and beneficio.margem <= '" . str_replace(",", ".", $_POST["margem_fim"]) . "'";
    }

//se com telefone
    if (isset($_POST["ctelefone"]) && $_POST["ctelefone"] != NULL && $_POST["ctelefone"] != "" && $_POST["ctelefone"] == "s") {
        $innerJoin .= " inner join telefone on telefone.codpessoa = pessoa.codpessoa";
        $campos .= ", telefone.numero as telefone";
    } elseif (isset($_POST["ctelefone"]) && $_POST["ctelefone"] != NULL && $_POST["ctelefone"] != "" && $_POST["ctelefone"] == "n") {
        $and .= " and pessoa.codpessoa not in(select codpessoa from telefone)";
    }

//se com endereço
    if (isset($_POST["cendereco"]) && $_POST["cendereco"] != NULL && $_POST["cendereco"] != "" && $_POST["cendereco"] == "s") {
        $campos .= ", pessoa.tipologradouro, pessoa.logradouro, pessoa.numero, pessoa.bairro, pessoa.cidade, pessoa.estado";
        $and .= " and pessoa.cidade <> '' and pessoa.estado <> ''";
    } elseif (isset($_POST["cendereco"]) && $_POST["cendereco"] != NULL && $_POST["cendereco"] != "" && $_POST["cendereco"] == "n") {
        $and .= " and pessoa.cidade = '' and pessoa.estado = ''";
    }

//se com beneficio
    if (isset($_POST["cbeneficio"]) && $_POST["cbeneficio"] != NULL && $_POST["cbeneficio"] != "" && $_POST["cbeneficio"] == "s") {
        $innerJoin .= " inner join beneficiocliente as beneficio on beneficio.codpessoa = pessoa.codpessoa and beneficio.codempresa = pessoa.codempresa";
        $innerJoin .= " inner join especie on especie.codespecie = beneficio.codespecie";
        $campos .= ", beneficio.numbeneficio, beneficio.salariobase, beneficio.margem, especie.nome as especie";
    } elseif (isset($_POST["cbeneficio"]) && $_POST["cbeneficio"] != NULL && $_POST["cbeneficio"] != "" && $_POST["cbeneficio"] == "n") {
        $and .= " and pessoa.codpessoa not in(select codpessoa from beneficiocliente)";
    }

//se com empréstimo
    if (isset($_POST["cemprestimo"]) && $_POST["cemprestimo"] != NULL && $_POST["cemprestimo"] != "" && $_POST["cemprestimo"] == "s") {
        $innerJoin .= " inner join emprestimo on emprestimo.codpessoa = pessoa.codpessoa";
        $campos .= ", emprestimo.prazo, emprestimo.quitacao, emprestimo.vlparcela, emprestimo.meio, emprestimo.situacao, emprestimo.parcelas_aberto";
    } elseif (isset($_POST["cemprestimo"]) && $_POST["cemprestimo"] != NULL && $_POST["cemprestimo"] != "" && $_POST["cemprestimo"] == "n") {
        $and .= " and pessoa.codpessoa not in(select codpessoa from emprestimo)";
    }

    if (isset($_POST["ordem"])) {
        if ($_POST["ordem"] == "1") {
            $orderby = " order by pessoa.nome";
        } elseif ($_POST["ordem"] == "2") {
            $orderby = " order by pessoa.dtcadastro";
        }
    }
    if (isset($_POST["ehUsuario"]) && $_POST["ehUsuario"] != NULL && $_POST["ehUsuario"] == "s") {
        $and .= " and pessoa.codcategoria not in(1,6) and pessoa.codnivel > 0";
    }
}
$sql = 'select pessoa.codpessoa, pessoa.nome, pessoa.codcategoria, pessoa.cpf, 
    pessoa.email, DATE_FORMAT(pessoa.dtcadastro, "%d/%m/%Y") as data, pessoa.senha, categoria.nome as categoria, pessoa.status,
    nivel.nome as nivel ' . $campos . '
    from pessoa 
    left join categoriapessoa as categoria on categoria.codcategoria = pessoa.codcategoria 
    left join nivel on nivel.codnivel = pessoa.codnivel ' . $innerJoin . '
    where 1 = 1 ' . $and . '
    and pessoa.codempresa = ' . $_SESSION['codempresa'] . $orderby;
$res = $conexao->comando($sql)or die('Erro no comando');
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
                                    Data Cad.
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Browser: activate to sort column ascending">
                                    Nome
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    CPF
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                    Status
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1" aria-label="Engine version: activate to sort column ascending">
                                    Opções
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($pessoa = $conexao->resultadoArray($res)) { ?>
                                <tr role="row" class="<?= $classe_linha ?>">
                                    <td class="sorting_1">
                                        <?= $pessoa["data"] ?>
                                    </td>
                                    <td>
                                        <?= $pessoa["nome"] ?>
                                    </td>
                                    <td>
                                        <?= $pessoa["cpf"] ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($pessoa["status"] == "i"){
                                                echo "Inativo";
                                            }else{
                                                echo "Ativo";
                                            }
                                        ?>                                      
                                    </td>
                                    <td>
                                        <?php
                                        if ($pessoa["codcategoria"] == 1 || $pessoa["codcategoria"] == 6) {
                                            $caminhoTelaPessoa = "Cliente";
                                        } else {
                                            $caminhoTelaPessoa = "Pessoa";
                                        }
                                        if ($pessoa["codcategoria"] == 6) {
                                            $complementoCaminho = "&callcenter=true";
                                        }
                                        echo '<a href="', $caminhoTelaPessoa, '.php?codpessoa=', $pessoa["codpessoa"], $complementoCaminho, '" title="Clique aqui para editar"><img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
                                        if ($nivel["nome"] != NULL && $nivel["nome"] != "" && trim($nivel["nome"]) !== "OPERADOR") {
                                            echo '<a href="#" onclick="excluir2(', $pessoa["codpessoa"], ')" title="Clique aqui para excluir"><img style="width: 20px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <!--                <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                        Mostrando 1 de 10 do total <?= $qtd ?> resultados
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button previous disabled" id="example2_previous">
                                                <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Anterior</a>
                                            </li>
                                            <li class="paginate_button active">
                                                <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a>
                                            </li>
                                            <li class="paginate_button ">
                                                <a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a>
                                            </li>
                                            <li class="paginate_button ">
                                                <a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a>
                                            </li>
                                            <li class="paginate_button ">
                                                <a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a>
                                            </li>
                                            <li class="paginate_button ">
                                                <a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a>
                                            </li>
                                            <li class="paginate_button ">
                                                <a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a>
                                            </li>
                                            <li class="paginate_button next" id="example2_next">
                                                <a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Posterior</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>-->
        </div>
    </div>
    <?php
    $classe_linha = "even";
}
?>