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
    if(isset($_GET["codramo"])){
        $sql     = "select nome from ramo where codramo = '{$_GET["codramo"]}'";    
        $ramo    = $conexao->comandoArray($sql);
        $titulo2 = $ramo["nome"];
    }else{
        $titulo2 = "empresa";
    }
    if (isset($_GET["codempresa"])) {
        $empresaf = $conexao->comandoArray("select * from empresa where codempresa = '{$_GET["codempresa"]}'");
        $titulo = "Alterar um ".$titulo2;
        $action = "../control/AtualizarEmpresa.php";
        $_GET["codramo"] = $empresaf["codramo"];
    } else{
        $titulo = "Cadastrar um ".$titulo2;
        $action = "../control/InserirEmpresa.php";
    }     
    $site   = $conexao->comandoArray("select * from site limit 1");
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '11'");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title><?=$site["nome"]?> › <?= $titulo ?></title>        
        <style>
            .funcionamento_p{
                width: 100px; float: left;
            }
            .comboHoras{
                margin-right: 10px;font-size: 15px;width: 90px;
            }
            .caixa_vinculo{
                height: 150px;
                overflow: auto;
                width: 400px;
                border: 1px solid #CCCCCC;
            }
            .caixa_vinculo ul{
                margin: 0;
                padding: 0;
            }

        </style>          
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
                 <?php if(isset($_GET["codempresa"])){?>
                <li><a href="#tabs-2">Configurações</a></li>
                 <?php }?>
                <?php if($nivelp["procurar"] == 1){?>
                <li><a href="#tabs-3">Procurar</a></li>
                <?php }?>
                <?php if(isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && $_GET["codempresa"] != ""){?>
                <li><a href="#tabs-4" title="Cadastre administrador para a empresa">Cad. Admin</a></li>
                <?php }?>
                 <?php if(isset($_GET["codempresa"])){?>
                <li><a href="#tabs-5">Horário Funcionamento</a></li>
                 <?php }?>               
            </ul>
            <div id="tabs-1">
                <?php include("formEmpresa.php");?>
            </div>
            <?php if(isset($_GET["codempresa"])){?>
            <div id="tabs-2">
                <?php include("formConfiguracao.php");?>
            </div>
             <?php }?>
            <div id="tabs-3">
                <?php 
                if($nivelp["procurar"] == 1){
                    include("formProcurarEmpresa.php");
                }
                ?>
            </div>
            <?php if(isset($_GET["codempresa"]) && $_GET["codempresa"] != NULL && $_GET["codempresa"] != ""){?>
            <div id="tabs-4">
                <?php 
                $action = "../control/InserirPessoa.php";
                include("formPessoa.php");
                ?>
            </div>
            <?php }?>
            <?php if(isset($_GET["codempresa"])){?>
            <div id="tabs-5">
                <?php include("./formHorarioFilial.php");?>
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
        <script type="text/javascript" src="./recursos/js/ajax/Empresa.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Pessoa.js"></script>
        <script type="text/javascript" src="./recursos/js/ajax/Configuracao.js"></script>
        <script type="text/javascript" src="./recursos/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="./recursos/js/Editor.js"></script> 
        <script type="text/javascript" src="./recursos/js/jquery.maskMoney.min.js"></script>  
        <script type="text/javascript" src="./recursos/js/jquery.maskedinput.min.js"></script>
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