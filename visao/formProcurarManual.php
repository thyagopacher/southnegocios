<form id="fpmanual" action="../control/ProcurarManualRelatorio.php" target="_blank" role="form" class="form-horizontal form-groups-bordered" method="POST" onsubmit="return false;">                       
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td style="width: 80px;">Nome</td>
            <td colspan="8"><input style="width: 580px;" type="text" name="nome" size="50" maxlength="250" placeholder="Digite nome aqui" value=""></td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="date" name="data" value="<?php if(isset($_GET["data1"])){echo $_GET["data1"];}?>"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="date" name="data2" value="<?php if(isset($_GET["data2"])){echo $_GET["data2"];}?>"/></td>
        </tr>
        
        
    </table>
    <button onclick="procurarManual(false)">Procurar</button>
    <?php
    if(isset($nivelp["gerapdf"]) && $nivelp["gerapdf"] == 1){
        echo '<button onclick="abreRelatorioManual()">Gera PDF</button> ';
    }
    if(isset($nivelp["geraexcel"]) && $nivelp["geraexcel"] == 1){
        echo '<button onclick="abreRelatorio2Manual()">Gera Excel</button>';
    }
    ?>
</form>
<?php include("./carregando.php");?>
<div id="listagemManual"></div>
