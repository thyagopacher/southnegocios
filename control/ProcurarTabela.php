<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    $conexao = new Conexao();
    
    $and     = "";
//    if(isset($_POST["codnivel"]) && $_POST["codnivel"] != NULL && $_POST["codnivel"] != ""){
//        $and .= " and tabela.codtabela in(select codtabela from tabelanivel where codempresa = '{$_SESSION['codempresa']}' and codnivel = '{$_POST["codnivel"]}')";
//    }
    if(isset($_POST["prazoate"]) && $_POST["prazoate"] != NULL && $_POST["prazoate"] != ""){
        $and .= " and tabelaprazo.prazoate = '{$_POST["prazoate"]}'";
    }
    if(isset($_POST["prazode"]) && $_POST["prazode"] != NULL && $_POST["prazode"] != ""){
        $and .= " and tabelaprazo.prazode = '{$_POST["prazode"]}'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and tabela.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and tabela.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["codbanco"]) && $_POST["codbanco"] != NULL && $_POST["codbanco"] != ""){
        $and .= " and tabela.codbanco in(select codbanco from banco where numbanco = '{$_POST["codbanco"]}')";
    }
    if(isset($_POST["numbanco"]) && $_POST["numbanco"] != NULL && $_POST["numbanco"] != ""){
        $and .= " and tabela.codbanco in(select codbanco from banco where numbanco = '{$_POST["numbanco"]}')";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and tabela.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and tabela.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select tabela.codtabela, tabela.nome, DATE_FORMAT(tabela.dtcadastro, '%d/%m/%Y') as dtcadastro2, 
    banco.nome as banco, convenio.nome as convenio
    from tabela
    inner join banco on banco.codbanco = tabela.codbanco
    inner join convenio on convenio.codconvenio = tabela.codconvenio
    inner join tabelaprazo on tabelaprazo.codtabela = tabela.codtabela
    where 1 = 1 and tabela.codempresa = {$_SESSION["codempresa"]}
    {$and} order by tabela.dtcadastro desc";

    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ',$qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">CADASTRO TABELA</th>';
        echo '<th>';
        echo 'Opções';
        echo '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($tabela = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $tabela["nome"],'<br>';
            echo 'Dt. Cadastro: ',$tabela["dtcadastro2"],'<br>';
            echo 'Banco:', $tabela["banco"] , ' - Convênio: ', $tabela["convenio"];
            echo '</td>';
            echo '<td>';
            echo '<a href="Tabela.php?codtabela=',$tabela["codtabela"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2Tabela(',$tabela["codtabela"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            if($_SESSION["codnivel"] == 1){
                $sql = "select codtabela from tabelanivel where codtabela = '{$tabela["codtabela"]}' and codnivel = '{$_POST["codnivel"]}'";
                $tabelnivelp = $conexao->comandoArray($sql);
                if(isset($tabelnivelp["codtabela"]) && $tabelnivelp["codtabela"] != NULL && $tabelnivelp["codtabela"] != ""){
                    echo '<input checked class="tabela_selecao" type="checkbox" name="tabela_selecao[]" id="tabela_selecao',$tabela["codtabela"],'" value="',$tabela["codtabela"],'"/>';
                }else{
                    echo '<input class="tabela_selecao" type="checkbox" name="tabela_selecao[]" id="tabela_selecao',$tabela["codtabela"],'" value="',$tabela["codtabela"],'"/>';
                }
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '';
    }
    