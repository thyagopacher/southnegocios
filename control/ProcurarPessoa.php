<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
include "../model/Conexao.php";
$conexao = new Conexao();
$and = "";
$sql = "select * from nivel where codempresa = '{$_SESSION['codempresa']}' and codnivel = '{$_SESSION["codnivel"]}'";
$innerJoin = "";
$campos = "";
$nivel = $conexao->comandoArray($sql);
if ($nivel["nome"] == "OPERADOR" || $_SESSION["codnivel"] != '1') {
    
    if(!isset($_POST["codcategoria"]) || $_POST["codcategoria"] == NULL || $_POST["codcategoria"] == ""){
        $and .= " and pessoa.codcategoria not in(1,6)";
    }else{
        if (isset($_POST["cpf"]) && $_POST["cpf"] != NULL && $_POST["cpf"] != "") {
            $cpf_limpo = str_replace(".", "", str_replace("-", "", $_POST["cpf"]));
            $and .= " and (pessoa.cpf = '{$_POST["cpf"]}' or pessoa.cpf = '{$cpf_limpo}')";
        } else {
            die("Para realizar esse tipo consulta é necessário informar o CPF!!!");
        }
    }
//    if (isset($_POST["codcategoria"]) && $_POST["codcategoria"] != NULL && $_POST["codcategoria"] != "") {
//        $and .= " and pessoa.codcategoria = '{$_POST["codcategoria"]}'";
//    }
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
    if (isset($_POST["codcategoria"]) && $_POST["codcategoria"] != NULL && $_POST["codcategoria"] != "") {
        $and .= " and pessoa.codcategoria = '{$_POST["codcategoria"]}'";
    } else {
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
    if ((!isset($_POST["callcenter"]) || $_POST["callcenter"] == NULL || $_POST["callcenter"] == "") && !isset($_POST["codcategoria"])) {
        $and .= " and pessoa.codcategoria not in(1,6)";
    }
}
$sql = "select pessoa.codpessoa, pessoa.nome, pessoa.codcategoria, pessoa.cpf, 
    pessoa.email, DATE_FORMAT(pessoa.dtcadastro, '%d/%m/%Y') as data, pessoa.senha, categoria.nome as categoria, pessoa.status,
    nivel.nome as nivel {$campos}
    from pessoa 
    left join categoriapessoa as categoria on categoria.codcategoria = pessoa.codcategoria 
    left join nivel on nivel.codnivel = pessoa.codnivel {$innerJoin}
    where 1 = 1 {$and}
    and pessoa.codempresa = '{$_SESSION['codempresa']}'    
    $orderby";

echo $sql;
$res = $conexao->comando($sql)or die("<pre>$sql</pre>");
$qtd = $conexao->qtdResultado($res);
if ($qtd > 0) {
    echo 'Encontrou ', $qtd, ' resultados<br>';
    echo '<table class="responstable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>CADASTRO DE PESSOA</th>';
    echo '<th style="width: 100px;">Opções</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $titulo = "";
    while ($pessoa = $conexao->resultadoArray($res)) {
        echo '<tr>';
        echo '<td style="text-align: left;">';
        if (isset($pessoa["email"]) && $pessoa["email"] != NULL && $pessoa["email"] != "") {
            $complemento1 = ' - E-mail:<a style="text-transform: initial;" href="mailto: ' . $pessoa["email"] . '">' . strtolower($pessoa["email"]) . '</a>';
        }
        echo 'Nome:', $pessoa["nome"], $complemento1, ' - Dt. Cadastro:', $pessoa["data"], '<br>';
        if (isset($pessoa["cpf"]) && $pessoa["cpf"] != NULL && $pessoa["cpf"] != "") {
            echo 'CPF:', $pessoa["cpf"], '<br>';
        }
        echo 'Status:', trocaStatus($pessoa["status"]);
        if (isset($pessoa["nivel"]) && $pessoa["nivel"] != NULL && $pessoa["nivel"] != "") {
            echo ' - Nivel:', $pessoa["nivel"];
        }
        if (isset($pessoa["margem"]) && $pessoa["margem"] != NULL && $pessoa["margem"] != "") {
            echo ' - Margem: R$ ', number_format($pessoa["margem"], 2, ',', '.'), '<br>';
        }
        if (isset($pessoa["tipologradouro"]) && $pessoa["tipologradouro"] != NULL && $pessoa["tipologradouro"] != "") {
            echo '<br>Endereço: <br>';
            echo $pessoa["tipologradouro"], ', ', $pessoa["numero"], ' ', $pessoa["bairro"], ' ', $pessoa["cidade"], ' - ', $pessoa["estado"];
        }
        if (isset($pessoa["telefone"]) && $pessoa["telefone"] != NULL && $pessoa["telefone"] != "") {
            echo '<br>Telefone:', $pessoa["telefone"];
        }
        echo '</td>';
        echo '<td>';
        if ($pessoa["codcategoria"] == 1 || $pessoa["codcategoria"] == 6) {
            $caminhoTelaPessoa = "Cliente";
        } else {
            $caminhoTelaPessoa = "Pessoa";
        }
        if ($pessoa["codcategoria"] == 6) {
            $complementoCaminho = "&callcenter=true";
        }
        echo '<a href="../visao/', $caminhoTelaPessoa, '.php?codpessoa=', $pessoa["codpessoa"], $complementoCaminho, '" title="Clique aqui para editar"><img style="width: 20px;" src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
        if ($nivel["nome"] != NULL && $nivel["nome"] != "" && trim($nivel["nome"]) !== "OPERADOR") {
            echo '<a href="#" onclick="excluir2(', $pessoa["codpessoa"], ')" title="Clique aqui para excluir"><img style="width: 20px;" src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
        }
        echo '</td>';
        echo '</tr>';
        $titulo = "";
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '';
}

include "../model/Log.php";
$log = new Log($conexao);
$log->codpessoa  = $_SESSION['codpessoa'];
$log->codempresa = $_SESSION['codempresa'];
$log->acao       = "procurar";
$log->observacao = "Procurar pessoa - em ". date('d/m/Y'). " - ". date('H:i');
$log->codpagina  = "0";
$log->data = date('Y-m-d');
$log->hora = date('H:i:s');
$log->inserir(); 

function trocaStatus($status) {
    switch ($status) {
        case 'a':
            $status = 'ativo';
            break;
        case 'i':
            $status = 'inativo';
            break;
        case 'n':
            $status = 'novo';
            break;
    }
    return $status;
}
