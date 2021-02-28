<?php
    session_start();
        //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }  
    include "../model/Conexao.php";
    $conexao = new Conexao();
    $and     = "";

    if(isset($_POST["quemfez"]) && $_POST["quemfez"] != NULL && $_POST["quemfez"] != ""){
        $and .= " and pessoa.nome like '%{$_POST["quemfez"]}%'";
    }
    if(isset($_POST["data1"]) && $_POST["data1"] != NULL && $_POST["data1"] != ""){
        if(strpos($_POST["data1"], "/")){
            $data1 = implode("-",array_reverse(explode("/", $_POST["data1"])));
            $and .= " and log.data >= '{$data1}'";
        }else{
            $and .= " and log.data >= '{$_POST["data1"]}'";
        }          
    }
    if(isset($_POST["data2"]) && $_POST["data2"] != NULL && $_POST["data2"] != ""){
        if(strpos($_POST["data2"], "/")){
            $data2 = implode("-",array_reverse(explode("/", $_POST["data2"])));
            $and .= " and log.data <= '{$data2}'";
        }else{
            $and .= " and log.data <= '{$_POST["data2"]}'";
        } 
    }
    if(isset($_POST["observacao"]) && $_POST["observacao"] != NULL && $_POST["observacao"] != ""){
        $and .= " and log.observacao like '%{$_POST["observacao"]}%'";
    }
    if(isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] == 1){
        $andPessoa = " and (pessoa.codempresa = '{$_SESSION['codempresa']}')";
    }else{
        $andPessoa = " and pessoa.codempresa = '{$_SESSION['codempresa']}'";
    }
    $sql = "select codlog, DATE_FORMAT(data, '%d/%m/%Y') as data2, 
        DATE_FORMAT(hora, '%H:%i') as hora, pessoa.codpessoa, pessoa.nome as quemfez, pagina.nome as pagina, log.observacao
    from log 
    left join pagina on pagina.codpagina = log.codpagina
    inner join pessoa on pessoa.codpessoa = log.codpessoa $andPessoa
    where log.codempresa = '{$_SESSION['codempresa']}' {$and} order by log.data desc, log.hora desc";
    $res = $conexao->comando($sql);
    $qtd = $conexao->qtdResultado($res);
    
    if($qtd > 0){
        echo 'Encontrou ', $qtd, ' resultados<br>';
        echo '<table class="responstable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th style="min-width: 500px;">REL. LOG</th>';
        if($_SESSION['codpessoa'] == 6 && $_SESSION["codnivel"] == 1){
            echo '<th>Excluir</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($acesso = $conexao->resultadoArray($res)){
            echo '<tr>';
            echo '<td style="text-align: left;  min-width: 500px;">';
            echo 'Data:', $acesso["data2"], ' - Hora:', $acesso["hora"], '<br>';
            echo 'Por:', $acesso["quemfez"], '<br>';
            echo 'Obs:', $acesso["observacao"];
            echo '</td>';
//            if($_SESSION['codpessoa'] == 6 && $_SESSION["codnivel"] == 1){
//                echo '<td><a href="#" onclick="excluir2Log(',$acesso["codlog"],')" title="Clique aqui para excluir"><img src="../visao/recursos/img/excluir.png" alt="botão excluir"/></a></td>';
//            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        echo '';
    }

