<?php

header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"]) || $_SESSION["nome"] == NULL || $_SESSION["nome"] == "") {
        $retorno  = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='/'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    
    if (isset($_GET["codpessoa"]) && $_GET["codpessoa"] != NULL && trim($_GET["codpessoa"]) != "") {
        $sql = "select * from pessoa where codpessoa = '{$_GET["codpessoa"]}' and codempresa = '{$_SESSION['codempresa']}'";
        $pessoa = $conexao->comandoArray($sql);
        $titulo = "Alterar uma pessoa";
        $action = "../control/AtualizarPessoa.php";
    } else {
        $titulo = "Cadastrar uma pessoa";
        $action = "../control/InserirPessoa.php";
    }
    if (isset($_GET["codpessoa"]) && $_SESSION['codpessoa'] == $_GET["codpessoa"]) {
        $titulo = "Meu Perfil";
    }
    $sql = "select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '4'";
    $nivelp = $conexao->comandoArray($sql);
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
  
            </ul>
            <div id="tabs-1">
                <?php include("formPessoa.php");?>
            </div>
            <?php if($nivelp["procurar"] == 1){?>
            <div id="tabs-2">
                <?php include("formProcurarPessoa.php");?>
            </div>
            <?php }?>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>

        <?php include "includeChat.php";?>

<script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/ajax/Pessoa.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/Geral.js"></script>
        
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
        
        <?php if(isset($_GET["procurar"]) && $_GET["procurar"] != NULL && $_GET["procurar"] == "1"){?>
        <script>
            $("#tabs").tabs({
                active: 1
            });
            procurarPessoa(true);
        </script>        
        <?php }?>        