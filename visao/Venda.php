<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='http://www.southnegocios.com/'</script>";
        die($retorno);
} 
if(isset($_SESSION["nome"])){
    include("../model/Conexao.php");
    $conexao = new Conexao();
    $codbaixa = filter_input(INPUT_GET, 'codbaixa', FILTER_VALIDATE_INT);
    if (isset($codbaixa)) {
        $baixa = $conexao->comandoArray("select * from baixa where codbaixa = '{$codbaixa}'");
        $titulo = "Alterar baixas";
        $action = "../control/AtualizarBaixa.php";
    } else {
        $titulo = "Cadastrar baixas";
        $action = "../control/InserirBaixa.php";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '73'");
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
                <li><a href="#tabs-1">Baixa</a></li>
                <?php if($nivelp["procurar"] == 1){?>
                <li><a href="#tabs-2">Procurar Baixa</a></li>
                <?php }?>
                <li><a href="#tabs-3">Meta Func.</a></li>
                <?php if($nivelp["procurar"] == 1){?>
                <li><a href="#tabs-4">Proc. Meta Func.</a></li>
                <?php }?>
            </ul>
            <div id="tabs-1">
                <?php include("formBaixa.php"); ?>
            </div>
            <div id="tabs-2">
                <?php include("formProcurarBaixa.php"); ?>
            </div>
            <div id="tabs-3">
                <?php include("formMetaFuncionario.php"); ?>
            </div>
            <div id="tabs-4">
                <?php include("formProcurarMetaFuncionario.php"); ?>
            </div>            
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>            
        </div>
        <?php include "includeChat.php";?>

        <script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script> 
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="./recursos/js/ajax/Baixa.js"></script>
        <script src="./recursos/js/ajax/MetaFuncionario.js"></script>
        <script src="./recursos/js/Geral.js" type="text/javascript"></script>
        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.mask.min.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>        
<?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>              