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
        <title>South Negócios › Relatório de Ligações</title>             
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
                <li><a href="#tabs-1">Relatório de Ligações</a></li>
            </ul>
            <div id="tabs-1">
                <form target="_blank" action="../control/ProcurarLigacaoRelatorio.php" name="fpligacao" id="fpligacao" method="post" onsubmit="return false;">
                    <input type="hidden" name="tipo" id="tipo" value="pdf"/>
                    <table class="tabela_formulario">
                        <tr>
                            <td>Dt. Inicio:</td>
                            <td><input style="width: 150px;" type="date" name="data1" id="data1"/></td>
                            <td>Dt. Fim:</td>
                            <td><input style="width: 150px;" type="date" name="data2" id="data2"/></td>
                        </tr>
                        <tr>
                            <td>Operador:</td>
                            <td>
                                <select style="width: 155px;" name="operador" id="operador">
                                    <?php
                                    $respessoa = $conexao->comando("select codpessoa, nome from pessoa where codcategoria not in(1,6) and codempresa = '{$_SESSION['codempresa']}'");
                                    $qtdpessoa = $conexao->qtdResultado($respessoa);
                                    if($qtdpessoa > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($pessoa = $conexao->resultadoArray($respessoa)){
                                            echo '<option value="',$pessoa["codpessoa"],'">',$pessoa["nome"],'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>Situação:</td>
                            <td>
                                <select name="codstatus" id="codstatus">
                                    <?php
                                    $resstatus = $conexao->comando("select * from statuspessoa order by nome");
                                    $qtdstatus = $conexao->qtdResultado($resstatus);
                                    if($qtdstatus > 0){
                                        echo '<option value="">--Selecione--</option>';
                                        while($status = $conexao->resultadoArray($resstatus)){
                                            echo '<option value="',$status["codstatus"],'">',$status["nome"],'</option>';
                                        }
                                    }else{
                                        echo '<option value="">--Nada encontrado--</option>';
                                    }
                                    ?>
                                </select>
                            </td>    
                        </tr>                        
                    </table>
                    <?php if($nivelp["procurar"] == 1){?>
                        <button onclick="procurarLigacao(false)">Procurar</button>
                    <?php }?>
                    <button onclick="abreRelatorio()">Gera PDF</button>
                    <button onclick="abreRelatorio2()">Gera Excel</button>                    
                </form>                
                <div id="listagemLigacao"></div>
            <span style="float: right; color: grey;width: 100%;text-align: right;">
            @ South Negócios
            </span>                   
            </div>         
        </div>
        <?php include "includeChat.php";?>
        <script src="/visao/recursos/js/jquery-1.10.2.min.js"></script>
        <script src="/visao/recursos/js/jquery-ui.min.js"></script>         
        <script src="./recursos/js/ajax/Ligacao.js"></script>
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