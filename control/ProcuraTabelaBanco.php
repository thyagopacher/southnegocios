<?php
session_start();
    //validação caso a sessão caia
    if(!isset($_SESSION)){
        die("<script>alert('Sua sessão caiu, por favor logue novamente!!!');window.close();</script>");
    }   
include "../model/Conexao.php";
$conexao   = new Conexao();
if($_SESSION["codnivel"] != 1 && $_SESSION["codnivel"] != 19){
    $and .= " and tabela.codtabela in(select codtabela from tabelanivel where codnivel = '{$_SESSION["codnivel"]}')";
}
$sql = "select codtabela, nome from tabela where codbanco = '{$_POST["codbanco"]}' {$and} order by nome";
$restabela = $conexao->comando($sql);
$qtdtabela = $conexao->qtdResultado($restabela);
if($qtdtabela > 0){
    echo '<option value="">--Selecione--</option>';
    while($tabela = $conexao->resultadoArray($restabela)){
        echo '<option value="',$tabela["codtabela"],'">',$tabela["nome"],'</option>';
    }
}else{
    echo '<option value="">--Nada encontrado--</option>';
}
    
    