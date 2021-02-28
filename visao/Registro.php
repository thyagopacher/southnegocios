<?php
header('Content-Type: text/html; charset=utf-8');    
session_start();
if (!isset($_SESSION["nome"])) {
        $retorno  = "<script>alert('Não pode acessar funcionalidade sem estar logado!');</script>";
        $retorno .= "<script>location.href='/login'</script>";
        die($retorno);
} else {
    include("../model/Conexao.php");
    $conexao = new Conexao();    
    if (isset($_GET["codregistro"]) && $_GET["codregistro"] != NULL && trim($_GET["codregistro"]) != "") {
        $sql = "select * from registro where codregistro = '{$_GET["codregistro"]}'";
        $registro = $conexao->comandoArray($sql);
        $titulo = "Alterar um registro";
    } else {
        $titulo = "Cadastrar um registro";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <style>
            #alfabeto{
                margin-left: 10px;
            }
            #alfabeto a{
                margin-right: 10px;
            }
        </style>
        <?php include("head.php");?>     
        <title>Anesthesiass › <?= $titulo ?></title>        
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
            </ul>
            <div id="tabs-1" style="padding: 0px;">
                <?php include("formRegistro.php");?>
            </div>
            <div id="tabs-2">
                <?php include("formProcurarRegistro.php");?>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @Anesthesiass
            </span>               
        </div>

        <script src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js"></script>    
        <script src="/visao/recursos/js/ajax/Registro.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.maskMoney.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/modernizr-2.5.3.min.js"></script>
        <script type="text/javascript" src="/visao/recursos/js/Geral.js"></script>
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
            procurarRegistro(true);
        </script>        
        <?php }?>    
