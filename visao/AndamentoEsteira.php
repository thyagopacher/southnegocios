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
    $titulo = "Acompanhamento de Esteira";
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = 85");
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
                <form name="fprocurarAndamentoEsteira" id="fprocurarAndamentoEsteira" method="post" onsubmit="return false;">
                    <table class="tabela_formulario">
                        <tr>
                            <td>CPF</td>
                            <td><input type="text" name="cpf" id="cpf" value=""/></td>                            
                            <td>Operador</td>
                            <td>
                                <select name="codfuncionario" id="codfuncionario">
                                    <?php
                                    $resfuncionario = $conexao->comando("select codpessoa, nome from pessoa where senha <> '' and codcategoria not in(1,6) and codempresa = '{$_SESSION['codempresa']}'");
                                    $qtdfuncionario = $conexao->qtdResultado($resfuncionario);
                                    if($qtdfuncionario > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($funcionario = $conexao->resultadoArray($resfuncionario)){
                                            echo '<option value="',$funcionario["codpessoa"],'">',  strtoupper($funcionario["nome"]),'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Loja</td>
                            <td>
                                <select name="codloja" id="codloja">
                                    <?php
                                    $resempresa3 = $conexao->comando("select razao, codempresa from empresa where razao <> '' order by razao");
                                    $qtdempresa3 = $conexao->qtdResultado($resempresa3);
                                    if($qtdempresa3 > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($empresa3 = $conexao->resultadoArray($resempresa3)){
                                            echo '<option value="',$empresa3["codempresa"],'">',$empresa3["razao"],'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>Status</td>
                            <td>
                                <select name="codstatus" id="codstatus">
                                    <?php
                                    $resstatus2 = $conexao->comando("select nome, codstatus from statusproposta order by nome");
                                    $qtdstatus2 = $conexao->qtdResultado($resstatus2);
                                    if($qtdstatus2 > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($status2 = $conexao->resultadoArray($resstatus2)){
                                            echo '<option value="',$status2["codstatus"],'">',$status2["nome"],'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>                            
                        </tr>
                    </table>
                    <?php if(isset($nivelp["procurar"]) && $nivelp["procurar"] == "1"){?>
                    <button onclick="AndamentoEsteira()">Procurar</button>
                    <?php }?>
                </form>
                <div id="resultado_andamento_esteira"></div>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
                @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="/visao/recursos/js/ajax/AndamentoEsteira.js"></script>
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