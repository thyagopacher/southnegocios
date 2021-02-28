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
    if (isset($_GET["codconta"])) {
        $sql = "select * from conta where codconta = '{$_GET["codconta"]}' and codempresa = '{$_SESSION['codempresa']}'";
        $rateio  = $conexao->comandoArray($sql);
        $titulo = "Alterar um rateio";
        $action = "../control/AtualizarRamal.php";
    } else {
        $titulo = "Cadastrar um rateio";
        $action = "../control/InserirRamal.php";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '54'");
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
                <li><a href="#tabs-1">Cadastro</a></li>
                <?php if($nivelp["procurar"] == 1){?>
                <li><a href="#tabs-2">Procurar</a></li>
                <?php }?>
            </ul>
            <div id="tabs-1">
                <?php include("formRateio2.php"); ?>
            </div>
            <div id="tabs-2">
                <?php 
                if($nivelp["procurar"] == 1){
                    include("formProcurarRateio.php");
                }
                ?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="/visao/recursos/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js" type="text/javascript"></script>         
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>     
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script>  
        <script type="text/javascript" src="./recursos/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/AmbienteRateio.js"></script>
        <script type="text/javascript" src="../visao/recursos/js/Geral.js"></script>
        
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
