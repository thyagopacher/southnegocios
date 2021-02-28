<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if (!isset($_SESSION["nome"])) {
    $retorno = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
    $retorno .= "<script>location.href='/'</script>";
    die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();
    $site = $conexao->comandoArray("select * from site limit 1");
    $titulo = "Acompanhamento de Carteira";
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' {$andNivelPagina}");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <style>
            .tbox{
                left: 400px;
            }
            .tinner{
                width: 620px !important;
            }
        </style>
        <?php include("head.php"); ?>     
        <title><?= $site["nome"] ?> › <?= $titulo ?></title>        
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3><?= $titulo ?></h3>
        <div id="tabs" style="width: 1085px; margin-right: 5%; margin-left: 16%; float: left;">
            <ul>
                <li><a href="#tabs-1"><?= $titulo ?></a></li>
            </ul>
            <div id="tabs-1">
                <form name="fprocurarAcompanhamentoCarteira" id="fprocurarAcompanhamentoCarteira" method="post">
                    <table class="tabela_formulario">
                        <tr>
                            <td>Filial:</td>
                            <td>
                                <select name="filial" id="filial">
                                    <?php
                                    $resfilial = $conexao->comando("select codempresa, razao from empresa order by razao");
                                    $qtdfilial = $conexao->qtdResultado($resfilial);
                                    if($qtdfilial > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($filial = $conexao->resultadoArray($resfilial)){
                                            echo '<option value="',$filial["codempresa"],'">',  strtoupper($filial["razao"]),'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </form>
                <div id="resultado_acompanhamento_carteira"></div>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
                @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="/visao/recursos/js/ajax/AcompanharCarteira.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/Geral.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/chat.js"></script>
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