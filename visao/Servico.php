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
    if (isset($_GET["codservico"])) {
        $sql = "select servico.*, morador.codpessoa as codmorador, morador.apartamento, morador.bloco 
        from servico 
        inner join pessoa as morador on morador.codpessoa = servico.codmorador and morador.codempresa = servico.codempresa
        where servico.codservico = '{$_GET["codservico"]}' 
        and servico.codempresa = '{$_SESSION['codempresa']}'";
        $servico  = $conexao->comandoArray($sql);
        $titulo = "Alterar uma serviço";
        $action = "../control/AtualizarServico.php";
    } else { 
        $titulo = "Cadastrar uma serviço";
        $action = "../control/InserirServico.php";
    }
    $sql = "select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '40'";
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
                <?php if(isset($nivelp) && $nivelp["procurar"] == 1){?>
                <li><a href="#tabs-2">Procurar</a></li>
                <?php }?>
                <li><a href="#tabs-3">Tipo</a></li>
            </ul>
            <div id="tabs-1">
                <?php include("formServico.php");?>
            </div>
            <?php if(isset($nivelp) && $nivelp["procurar"] == 1){?>
            <div id="tabs-2">
                <?php 
                include("formProcurarServico.php");
                ?>
            </div>
            <?php }?>
            <div id="tabs-3">
                <?php 
                include("./formTipoServico.php");
                ?>                
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js"></script>         
        <script src="/visao/recursos/js/jquery.form.js"></script>
        <script src="./recursos/js/ajax/Servico.js"></script>
        <script src="./recursos/js/ajax/TipoServico.js"></script>
        <script src="./recursos/js/ajax/ProcurarMorador.js"></script>
        <script src="./recursos/js/jquery.maskMoney.min.js"></script>   
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