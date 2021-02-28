<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/OrgaoPagador.php";
    $conexao = new Conexao();
    $orgao  = new OrgaoPagador($conexao);
    
    $and     = "";
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ""){
        $and .= " and orgao.nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL){
        $and .= " and orgao.dtcadastro >= '{$_POST["data1"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and orgao.dtcadastro <= '{$_POST["data2"]}'";
    }
    $sql = "select codorgao, nome, DATE_FORMAT(dtcadastro, '%d/%m/%Y') as dtcadastro2
    from orgaopagador as orgao
    where 1 = 1
    {$and} order by orgao.dtcadastro desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ',$qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width: 600px;">CADASTRO ÓRGÃO PAGADOR</th>';
        echo '<th>Opções</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($orgao = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;">';
            echo 'Nome:', $orgao["nome"], ' - Dt. Cadastro: ',$orgao["dtcadastro2"],'<br>';
            if(isset($orgao["site"]) && $orgao["site"] != NULL && $orgao["site"] != ""){
                echo 'Site: <a href="http://', str_replace("http://", "", $orgao["site"]) , '">Site orgao</a><br>';
            }
            echo '</td>';
            echo '<td>';
            echo '<a href="OrgaoPagador.php?codorgao=',$orgao["codorgao"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a>';
            echo '<a href="#" onclick="excluir2OrgaoPagador(',$orgao["codorgao"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '';
    }
    