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
    $codigo = filter_input(INPUT_GET, 'codconteudo', FILTER_VALIDATE_INT);
    if (isset($codigo)) {
        include("../model/Conteudo.php");
        $conteudo = $conexao->comandoArray("select * from conteudo where codconteudo = '{$codigo}'");
        $titulo       = "Alterar uma conteudo";
        $action = "../control/AtualizarConteudo.php";
    } else { 
        $titulo = "Cadastrar uma conteudo";
        $action = "../control/InserirConteudo.php";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '48'");
}

?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <link rel="stylesheet" href="./recursos/css/jquery-ui.min.css">
        <title>South Negócios › <?= $titulo ?></title>                
    </head>
    <body>  
        <?php 
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3><?= $titulo ?></h3>
        <div id="tabs" style="width: 800px;  margin-right: 25%; margin-left: 25%; float: left;">
            <ul>
                <li><a href="#tabs-1">Cadastro</a></li>
                <li><a href="#tabs-2">Procurar</a></li>
                <li><a href="#tabs-3">Contato</a></li>
            </ul>
            <div id="tabs-1">
                <?php include("formConteudo.php");?>
            </div>
            <?php if($nivelp["procurar"] == 1){?>
            <div id="tabs-2">
                <?php 
                    include("formProcurarConteudo.php");
                ?>
            </div>
            <?php }?>  
            <div id="tabs-3">
                <?php include("formSite.php");?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>      
        <script src="/visao/recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskedinput.min.js"></script>
        <script src="./recursos/js/ajax/Conteudo.js"></script>
        <script src="./recursos/js/ajax/Site.js"></script>
        <script src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>   
        <script src="../visao/recursos/js/Geral.js" type="text/javascript"></script>
        
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