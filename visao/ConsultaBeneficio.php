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
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › Consulta Beneficio</title>           
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3>Consulta Beneficio</h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Cadastro</a></li>
            </ul>
            <div id="tabs-1">
                <form onsubmit="return false;" name="fconsulta" id="fconsulta" method="post">
                    <table class="tabela_formulario">
                        <tr>
                            <td>CPF</td>
                            <td><input type="text" name="cpf" id="cpf" class="cpf" placeholder="digite cpf"/></td>
                        </tr>
                    </table>
                    <button onclick="ConsultaCpfInss()">Consulta CPF</button>
                </form>
                <div id="listagemBeneficio"></div>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>            
        </div>
        <?php include "includeChat.php";?>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>    
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="./recursos/js/jquery.mask.min.js" type="text/javascript"></script>
        <script src="./recursos/js/ajax/BeneficioCliente.js" type="text/javascript"></script>
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