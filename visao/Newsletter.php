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
    if(isset($_GET["codimportacao"])){
        $importacao = $conexao->comandoArray("select * from importacao where codimportacao = '{$_GET["codimportacao"]}'");
    }
}
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › Importação Padrão</title>
    </head>
    <body>
        <?php 
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3>Importação Padrão</h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Importação</a></li>
                <li><a href="#tabs-2">Procurar</a></li>
            </ul>
            <div id="tabs-1">
                <form name="fimportacao" id="fimportacao" method="post" action="../control/Importacao.php">
                    <table class="tabela_formulario">
                    <tr>
                        <td>Arquivo</td>
                        <td><input type="file" name="arquivo" required title="Escolha seu importacao aqui"/></td>
                    </tr>      
                    <tr>
                        <td><input type="submit" name="submit" value="Enviar" title="Clique aqui para enviar importacao ao cliente"/></td>
                    </tr>
                    </table>
                </form>
                
                <br><a href="../arquivos/importacao.xls" target="_blank" title="Download do arquivo de importação padrão">* Arquivo de importação padrão</a><br>
                <div class="progress">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                </div>

                <div id="status"></div>                
            </div>
            <div id="tabs-2">
                <?php 
                include("formProcurarImportacao.php");
                ?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>

<script type="text/javascript" src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script>        
        <script src="/visao/recursos/js/jquery.form.js"></script>  
        <script src="../visao/recursos/js/Geral.js"></script>      
        <script src="../visao/recursos/js/ajax/Importacao.js"></script>    
        
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