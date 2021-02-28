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
    $codigo = filter_input(INPUT_GET, 'codclassificado', FILTER_VALIDATE_INT);
    if (isset($codigo)) {
        include("../model/Classificado.php");
        $classificado = $conexao->comandoArray("select * from classificado where codclassificado = '{$codigo}'");
        $titulo       = "Alterar uma classificado";
        $action = "../control/AtualizarClassificado.php";
    } else { 
        $titulo = "Cadastrar uma classificado";
        $action = "../control/InserirClassificado.php";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '14'");
   
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
                <li><a href="#tabs-2">Procurar</a></li>
                <?php
                if(isset($_GET["codclassificado"]) && $_GET["codclassificado"] != NULL && $_GET["codclassificado"] != ""){
                    echo '<li><a href="#tabs-3">Comentários</a></li>';
                }
                ?>
                <li><a href="#tabs-4">Fornecedor</a></li>
                <li><a href="#tabs-5">Proc. Fornecedor</a></li>
            </ul>
            <div id="tabs-1">
                <?php include("formClassificado.php");?>
            </div>
            <?php if($nivelp["procurar"] == 1){?>
            <div id="tabs-2">
                <?php 
                    include("formProcurarClassificado.php");
                ?>
            </div>
            <?php 
            }
            if(isset($_GET["codclassificado"]) && $_GET["codclassificado"] != NULL && $_GET["codclassificado"] != ""){?>
            <div id="tabs-3">
                <?php  include("formComentarioClassificado.php");?>
            </div>
            <?php }?>
            <div id="tabs-4"><?php  include("formEmpresa.php");?></div>
            <div id="tabs-5">
                <?php   $fornecedor = true;include("formProcurarEmpresa.php");?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>          
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.form.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Classificado.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/ComentarioClassificado.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Empresa.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script>   
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