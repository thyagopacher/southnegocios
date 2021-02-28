<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='Login.php'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    
    if (isset($_GET["codconta"])) {
        $sql    = "select conta.*, DATE_FORMAT(conta.dtpagamento, '%d/%m/%Y') as dtpagamento2 from conta where codconta = '{$_GET["codconta"]}'";
        $conta  = $conexao->comandoArray($sql);
        $titulo = "Alterar uma conta";
        $action = "../control/AtualizarConta.php";
    } else { 
        $titulo = "Cadastrar uma conta";
        $action = "../control/InserirConta.php";
    }
}
if(!isset($_GET["movimentacao"]) && isset($conta) && $conta["movimentacao"] != NULL && $conta["movimentacao"] != ""){
    $_GET["movimentacao"] = $conta["movimentacao"];
}
if(isset($_GET["movimentacao"])){
    if($_GET["movimentacao"] == "R"){
        $titulo .= " a receber";
        $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '6'");
    }elseif($_GET["movimentacao"] == "D"){
        $titulo .= " a pagar";
        $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '7'");
    }
}elseif(isset($_GET["master"]) && $_GET["master"] == "true"){
    $titulo .= " de filiais";
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '62'");
}
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › <?= $titulo ?></title>             
    </head>
    <body>
        <?php 
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3><?= $titulo ?></h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Cadastro</a></li>
                <?php if($nivelp["procurar"] == 1){?>
                <li><a href="#tabs-2">Procurar</a></li>
                <?php }?>
                <li><a href="#tabs-3">Tipo Conta</a></li>
            </ul>
            <div id="tabs-1">
                <?php include("formConta.php");?>
            </div>
            <div id="tabs-2">
                <?php 
                if($nivelp["procurar"] == 1){
                    include("formProcurarConta.php");
                }
                ?>
            </div>
            <div id="tabs-3">
                <?php include("formTipoConta.php");?>
            </div>
        </div>
        <?php include "includeChat.php";?>

<script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script>         
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Conta.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/TipoConta.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script>   
        <script type="text/javascript" src="../visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/jquery.maskedinput.min.js"></script>

        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>            
        <?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>      