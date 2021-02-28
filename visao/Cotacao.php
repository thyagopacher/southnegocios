<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='http://www.southnegocios.com/'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    

   
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '50'");
    $fornecedor = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › <?= $titulo ?></title>        
        <link rel="stylesheet" href="./recursos/css/jquery-ui.min.css">       
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
                <li><a href="#tabs-5" title="Cotação de novos produtos para o condominio">Cotação</a></li>
                <li><a href="#tabs-6" title="Procurar cotação">Proc. Cotação</a></li>
                <li><a href="#tabs-7" title="Enviar uma cotação">Enviar Cotação</a></li>
                <li><a href="#tabs-8" title="Procurar orçamentos cadastrados">Proc. Orçamentos</a></li>
            </ul>
            <div id="tabs-5">
                <?php include("formCotacao.php");?>
            </div>
            <div id="tabs-6">
                <?php include("formProcurarCotacao.php");?>
            </div>
            <div id="tabs-7">
                <?php include("formEnviarCotacao.php");?>
            </div>
            <div id="tabs-8">
                <?php include("formProcurarOrcamento.php");?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        
        <script type="text/javascript" src="./recursos/js/ajax/Cotacao.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Orcamento.js"></script>
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>        
        <script type="text/javascript" src="./recursos/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script> 
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