<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    include "../model/Classificado.php";
    
    $conexao = new Conexao();
    $classificado = new Classificado($conexao);
    $and     = "";
    if(isset($_POST["nome"])){
        $and .= " and titulo like '%{$_POST["nome"]}%'";
    }
    if(isset($_POST["ehMorador"]) && $_POST["ehMorador"] != NULL && $_POST["ehMorador"] != ""){
        $and .= " and ehMorador = '{$_POST["ehMorador"]}'";
    }
    if(isset($_POST["data"]) && $_POST["data"] != NULL){
        $and .= " and data >= '{$_POST["data"]}'";
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL){
        $and .= " and data <= '{$_POST["data2"]}'";
    }
    $res = $conexao->comando("select codclassificado, titulo, data, DATE_FORMAT(data, '%d/%m/%Y') as data2, pessoa.nome as funcionario, pessoa.codpessoa
        from classificado
        inner join pessoa on pessoa.codpessoa = classificado.codpessoa
        where 1 = 1 {$and}");
    if($res != FALSE){
        $qtd = $conexao->qtdResultado($res);

        if($qtd > 0){
            echo '<table class="responstable">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Código</th>';
            echo '<th>Nome</th>';
            echo '<th>Data</th>';
            echo '<th>Responsável</th>';
            echo '<th>Editar</th>';
            echo '<th>Excluir</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($classificado = $conexao->resultadoArray($res)){
                echo '<tr>';
                echo '<td>',$classificado["codclassificado"],'</td>';
                echo '<td>',$classificado["titulo"],'</td>';
                echo '<td>',$classificado["data2"],'</td>';
                echo '<td><a href="Pessoa.php?codpessoa=',$classificado["codpessoa"],'" title="Clique para visualizar ficha da pessoa">',$classificado["funcionario"],'</a></td>';
                echo '<td><a href="Classificado.php?codclassificado=',$classificado["codclassificado"],'" title="Clique aqui para editar"><img src="../visao/recursos/img/editar.png" alt="botão editar"/></a></td>';
                echo '<td><a href="#" onclick="excluir2(',$classificado["codclassificado"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }else{
            echo '0';
        }
    }else{
        echo '0';
    }