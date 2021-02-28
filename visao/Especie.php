<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='/'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    
    $titulo2 = "especie";
    if (isset($_GET["codespecie"])) {
        $especie = $conexao->comandoArray("select * from especie where codespecie = '{$_GET["codespecie"]}'");
        $titulo = "Alterar um ".$titulo2;
        $action = "../control/AtualizarEspecie.php";
        $_GET["codramo"] = $especief["codramo"];
    } else{
        $titulo = "Cadastrar um ".$titulo2;
        $action = "../control/InserirEspecie.php";
    }  

    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '56'");
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
                <li><a href="#tabs-3">Procurar</a></li>
                <?php }?>               
            </ul>
            <div id="tabs-1">
                <?php include("formEspecie.php");?>
            </div>
            <div id="tabs-3">
                <?php 
                if($nivelp["procurar"] == 1){
                    include("formProcurarEspecie.php");
                }
                ?>
            </div>                       
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script type="text/javascript" src="./recursos/js/ajax/Especie.js"></script>
        <script type="text/javascript" src="./recursos/js/Geral.js"></script>
        
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