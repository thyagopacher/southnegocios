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
    if(isset($_GET["codtarefa"])){
        $tarefa = $conexao->comandoArray("select * from tarefa where codtarefa = '{$_GET["codtarefa"]}'");
        $action = "../control/AtualizarTarefa.php";
    }else{
        $action = "../control/InserirTarefa.php";
    }
    if(isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] == 1){
        $and = " and nivelpagina.codpagina = '38'";
    }else{
        $and = " and nivelpagina.codpagina = '67'";
    }

    $nivelp = $conexao->comandoArray("select nivelpagina.*, pagina.nome as pagina
    from nivelpagina
    inner join  pagina on pagina.codpagina = nivelpagina.codpagina
    where nivelpagina.codnivel = '{$_SESSION["codnivel"]}'
    {$and}");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › <?=$nivelp["pagina"]?></title>         
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <div>
            <h3><?=$nivelp["pagina"]?></h3>
             <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
                <ul>
                    <li><a href="#tabs-1">Cadastro</a></li>
                    <?php if(isset($nivelp["procurar"]) && $nivelp["procurar"] == "1"){?>
                    <li><a href="#tabs-2">Procurar</a></li>
                    <?php }?>
                </ul>
                <div id="tabs-1">
                    <?php include("formTarefa.php"); ?>
                </div>
                <?php if(isset($nivelp["procurar"]) && $nivelp["procurar"] == "1"){?>
                <div id="tabs-2">
                    <?php include("formProcurarTarefa.php"); ?>
                </div>
                <?php }?>
                <span style="float: right; color: grey;width: 100%;text-align: right;">
                @ South Negócios
                </span>               
            </div>
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script src="/visao/recursos/js/jquery.form.js"></script>  
        <script src="./recursos/js/ajax/Tarefa.js"></script>
        <script src="./recursos/js/Geral.js" type="text/javascript"></script>
        
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
        <?php if(isset($_GET["procurar"]) && $_GET["procurar"] != NULL && $_GET["procurar"] == "1"){?>
        <script>
            $("#tabs").tabs({
                active: 1
            });
            procurarTarefa(true);
        </script>        
        <?php }?>        