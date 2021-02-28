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
    $codigo  = filter_input(INPUT_GET, 'codconsumo', FILTER_VALIDATE_INT);
    if (isset($codigo)) {
        include("../model/ConsumoAgua.php");
        $consumo = $conexao->comandoArray("select consumoagua.*
        from consumoagua 
        where codconsumo = '{$codigo}' and codempresa = '{$_SESSION['codempresa']}'");
        $titulo   = "Alterar um consumo";
    } else { 
        $titulo = "Cadastrar um consumo";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '47'");
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
                <?php
                if(isset($nivelp) && isset($nivelp["procurar"]) && $nivelp["procurar"] == 1){
                    echo '<li><a href="#tabs-2">Procurar</a></li>';
                }
                ?>
                <li><a href="#tabs-3">Rateio</a></li>
            </ul>
            <div id="tabs-1">
                <?php include("formConsumoAgua.php");?>
            </div>
            <div id="tabs-2">
                <?php 
                if(isset($nivelp) && isset($nivelp["procurar"]) && $nivelp["procurar"] == 1){
                    include("formProcurarConsumoAgua.php");
                }
                ?>
            </div>
            <div id="tabs-3">
                <?php include("formRateio.php");?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script src="./recursos/js/jquery.maskMoney.js"></script>     
        <script src="./recursos/js/ajax/ConsumoAgua.js"></script>
        <script src="./recursos/js/ajax/Rateio.js"></script>
        <script src="./recursos/js/ajax/ProcurarMorador.js"></script>
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