<?php 
    $nivel_logado = $conexao->comandoArray("select * from nivel where codnivel = '{$_SESSION["codnivel"]}'");
?>
<form id="fpagenda" action="../control/ProcurarAgendaRelatorio.php" target="_blank" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <?php
        if(isset($_GET["codcliente"]) && $_GET["codcliente"] != NULL && $_GET["codcliente"] != ""){
            echo '<input type="hidden" name="codcliente" id="codcliente" value="',$_GET["codcliente"],'"/>';
        }
        if(isset($_GET["callcenter"]) && $_GET["callcenter"] != NULL && $_GET["callcenter"] == "true"){
            echo '<input type="hidden" name="codcategoria" id="codcategoria" value="6"/>';
        }else{
            echo '<input type="hidden" name="codcategoria" id="codcategoria" value="1"/>';
        }
        ?>
        <input type="hidden" name="tipo" id="tipoAgenda" value="pdf"/>
       <?php if((isset($_GET["callcenter"]) && $_GET["callcenter"] != NULL && $_GET["callcenter"] == "true") || (isset($nivel_logado["nome"]) && $nivel_logado["nome"] != "OPERADOR")){?>
        <tr>
            <td>Dt. Inicio</td>
            <td style="width: 300px;"><input style="width: 140px;" type="date" name="data1"/></td>
            <td>Dt. Fim</td>
            <td><input style="width: 140px;" type="date" name="data2"/></td>
        </tr>
       <?php }?>
    </table>
    <?php if((isset($_GET["callcenter"]) && $_GET["callcenter"] != NULL && $_GET["callcenter"] == "true") || (isset($nivel_logado["nome"]) && $nivel_logado["nome"] != "OPERADOR")){?>
    <button onclick="procurarAgenda(false)">Procurar</button>
    <?php if($nivelp["gerapdf"] == 1){?>
    <button onclick="abreRelatorioAgenda()">Gera PDF</button>
    <?php }?>
    <?php if($nivelp["geraexcel"] == 1){?>
    <button onclick="abreRelatorio2Agenda()">Gera Excel</button>
    <?php }?>
    <?php }?>
</form>
<?php include("./carregando.php");?>
<div id="listagemAgenda"></div>
