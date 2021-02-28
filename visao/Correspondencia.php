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
    if (isset($_GET["codcorrespondencia"])) {
        include("../model/Correspondencia.php");
        $sql = "select correspondencia.*, pessoa.nome as morador, pessoa.codpessoa as codmorador
        from correspondencia 
        inner join pessoa on pessoa.codpessoa = correspondencia.codmorador
        where codcorrespondencia = '{$_GET["codcorrespondencia"]}'";
        $correspondencia = $conexao->comandoArray($sql);
        if(isset($correspondencia["codmorador"]) && (!isset($correspondencia["apartamento"]) || $correspondencia["apartamento"] == NULL || $correspondencia["apartamento"] == "")){
            $pessoa2 = $conexao->comandoArray("select apartamento, bloco from pessoa where codpessoa = '{$correspondencia["codmorador"]}' and codempresa = '{$_SESSION['codempresa']}' and status = 'a'");
            $correspondencia["apartamento"] = $pessoa2["apartamento"];
            $correspondencia["bloco"] = $pessoa2["bloco"];
        }
        $titulo   = "Alterar uma correspondencia";
    } else { 
        $titulo = "Cadastrar uma correspondencia";
    }
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '18'");
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
                <li><a href="#tabs-3">Tipo Correspondência</a></li>
                <?php if($_SESSION["codnivel"] == 1){?>
                <li><a href="#tabs-4">Status Correspondência</a></li>
                <?php }?>
            </ul>
            <div id="tabs-1">
                <?php include("formCorrespondencia.php");?>
            </div>
            <div id="tabs-2">
                <?php
                if($nivelp["procurar"] == 1){
                    include("formProcurarCorrespondencia.php");
                }
                ?>
            </div>
            <div id="tabs-3">
                <?php include("formTipoCorrespondencia.php");?>
            </div>
            <?php if($_SESSION["codnivel"] == 1){?>
            <div id="tabs-4">
                <?php include("formStatusCorrespondencia.php");?>
            </div>
            <?php }?>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>               
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script src="./recursos/js/ajax/Correspondencia.js"></script>
        <script src="./recursos/js/ajax/TipoCorrespondencia.js"></script>
        <script src="./recursos/js/ajax/StatusCorrespondencia.js"></script>
        <script src="../visao/recursos/js/Geral.js" type="text/javascript"></script>
        <script src="../visao/recursos/js/ajax/ProcurarMorador.js"></script>
        
        <script type="text/javascript" src="./recursos/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="./recursos/js/tinybox.min.js"></script>
        <script type="text/javascript" src="./recursos/js/modernizr-2.5.3.min.js"></script>
        <script src="/visao/recursos/js/chat.js"></script>            
        <?php if(isset($_GET["procurar"]) && $_GET["procurar"] != NULL && $_GET["procurar"] == "1"){?>
        <script>
            $("#tabs").tabs({
                active: 1
            });
            procurarCorrespondencia(true);
        </script>        
        <?php }?>
<?php
    $nivel_popup = $conexao->comandoArray("SELECT * FROM `nivelpagina` WHERE `codpagina` = 81 and inserir = 1");
    if(isset($nivel_popup["inserir"]) && $nivel_popup["inserir"] == 1){
        echo '<script src="/visao/recursos/js/ajax/Frase.js" type="text/javascript"></script>';
        echo '<script>visualizaPopup();</script>';
    }
?>      