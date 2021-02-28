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
    $nivelp  = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '28'");
}
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <link rel="stylesheet" href="./recursos/css/jquery-ui.min.css">
        <title>South Negócios › Relatório de Log do Sistema</title>             
    </head>
    <body>
        <?php 
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
        <h3>Relatório de Log</h3>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Relatório de Log</a></li>
            </ul>
            <div id="tabs-1">
                <form action="../control/ProcurarLogRelatorio.php" name="rLogSistema" id="rLogSistema" method="post" onsubmit="return false;">
                    <input type="hidden" name="html" id="html" value=""/>
                    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
                    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Log"/>
                    <table class="tabela_formulario">
                        <tr>
                            <td>Dt. Inicio:</td>
                            <td><input type="text" class="data" name="data1"/></td>
                            <td>Dt. Fim:</td>
                            <td><input type="text" class="data" name="data2"/></td>
                        </tr>
                        <tr>
                            <td>Quem fez:</td>
                            <td><input style="width: 202px;" type="text" name="quemfez" id="quemfez" placeholder="digite aqui o nome de quem fez a exclusão" value=""/></td>
                            <td>Observação:</td>
                            <td><input style="width: 202px;" type="text" name="observacao" id="observacao" value=""/></td>    
                        </tr>                        
                    </table>
                    <?php if($nivelp["procurar"] == 1){?>
                        <button onclick="procurarLog(false)">Procurar</button>
                    <?php }?>
                    <button onclick="abreRelatorio()">Gera PDF</button>
                    <button onclick="abreRelatorio2()">Gera Excel</button>                    
                </form>
<form action="Excel.php" method="post" target="_blank" id="rLogSistema2" name="rLogSistema2">
    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Log"/>
    <input type="hidden" name="html" id="html2" value=""/>
</form>                
                <div id="listagem"></div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>                   
            </div>         
        </div>
        <?php include "includeChat.php";?>
        <script src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js"></script>         
        <script src="./recursos/js/ajax/Log.js"></script>
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