<form id="fpdocumento" action="../control/ProcurarDocumentoRelatorio.php" target="_blank" method="POST" onsubmit="return false;">   
    <table class="tabela_formulario">
        <input type="hidden" name="tipo" id="tipo" value="pdf"/>
        <tr>
            <td>Nome</td>
            <td colspan="3">
                <input type="text" name="nome" id="nome" style="width: 600px;" placeholder="Digite nome"/>
            </td>
        </tr>
        <tr>
            <td style="width: 80px;">Dt. Inicio</td>
            <td style="width: 100px;"><input style="width: 200px;" type="date"  name="data" value="<?php if(isset($_GET["data1"])){echo $_GET["data1"];}?>"/></td>
            <td style="width: 80px;">Dt. Fim</td>
            <td style="width: 100px;"><input style="width: 222px;" type="date" name="data2" value="<?php if(isset($_GET["data2"])){echo $_GET["data2"];}?>"/></td>
        </tr>
        
    </table>
    <button onclick="procurarDocumento(false)">Procurar</button>
    <?php
    if(isset($nivelp["gerapdf"]) && $nivelp["gerapdf"] == 1){
        echo '<button onclick="abreRelatorioDocumento()">Gera PDF</button> ';
    }
    if(isset($nivelp["geraexcel"]) && $nivelp["geraexcel"] == 1){
        echo '<button onclick="abreRelatorio2Documento()">Gera Excel</button>';
    }
    ?>
</form>
<?php include("./carregando.php");?>
<div id="listagemDocumento"></div>
