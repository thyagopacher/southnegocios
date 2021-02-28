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
    $nivelp = $conexao->comandoArray("select * from nivelpagina where codnivel = '{$_SESSION["codnivel"]}' and codpagina = '22'");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("head.php");?>     
        <title>South Negócios › Relatório de Receita</title>        
    </head>
    <body>
        <?php
        include("cabecalho.php");
        include("menu.php");
        ?>
        <div id="barra_pos_cabecalho"></div>
         <div id="tabs" style="width: 955px; margin: 0 auto;  margin-top: 55px;">
            <ul>
                <li><a href="#tabs-1">Relatório de Receita</a></li>
            </ul>
            <div id="tabs-1">
                <form id="freceita" autocomplete="on" role="form" class="form-horizontal form-groups-bordered" method="POST" target="_blank" action="../control/ProcurarReceitaRelatorio.php" onsubmit="return false;">        
                    <input type="hidden" name="html" id="html" value=""/>
                    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
                    <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Receita"/>
                    <table class="tabela_formulario">
                        <tr>
                            <td>Dt. Inicio</td>
                            <td><input type="date" class="data" name="data1" value="<?=date('Y-m-d', strtotime("-30 days"))?>"/></td>
                            <td>Dt. Fim</td>
                            <td><input type="date" class="data" name="data2" value="<?=date('Y-m-d')?>"/></td>
                        </tr>
                    </table>
                    <?php if($nivelp["procurar"] == 1){?>
                        <button onclick="procurarReceita()">Procurar</button>
                        <button onclick="abreRelatorio()">Gera PDF</button>
                        <button onclick="abreRelatorio2()">Gera Excel</button>
                    <?php }?>                    
                </form>
                <?php include("./carregando.php");?>
                <div id="listagem"></div>
            </div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>   
        </div>        
        <?php include "includeChat.php";?>
        <form action="Excel.php" method="post" target="_blank" id="freceita2" name="freceita2">
            <input type="hidden" name="nome_pagina" id="nome_pagina" value="Relatório de Receita"/>
            <input type="hidden" name="html" id="html2" value=""/>
        </form>
        
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>      
        <script src="./recursos/js/ajax/Receita.js"></script>      
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